<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Genre;
use App\Models\Role;
use App\Models\Statut;
use App\Models\User;
use App\Models\Utilisateur;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UtilisateursController extends Controller
{
    public function index(): View
    {
        Gate::authorize('administration.view');

        $utilisateurs = Utilisateur::query()
            ->with(['user', 'role', 'codeStatut', 'codeGenre', 'classe'])
            ->orderBy('nom')
            ->orderBy('prenom')
            ->paginate(20);

        return view('administration.utilisateurs.index', compact('utilisateurs'));
    }

    public function create(): View
    {
        Gate::authorize('administration.create');

        return view('administration.utilisateurs.form', [
            'utilisateur' => new Utilisateur,
            'user' => new User,
            ...$this->formOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('administration.create');

        $validated = $request->validate($this->rules());

        $user = DB::transaction(function () use ($validated): User {
            $user = User::create([
                'name' => trim($validated['prenom'].' '.$validated['nom']),
                'email' => $validated['email'],
                'password' => Str::random(64),
            ]);

            Utilisateur::create([
                ...$this->profileAttributes($validated),
                'id' => $user->getKey(),
            ]);

            return $user;
        });

        return redirect()
            ->route('administration.utilisateurs.index')
            ->with('status', 'La fiche et le compte ont été créés. L’élève devra utiliser « Mot de passe oublié » pour définir son mot de passe.');
    }

    public function edit(Utilisateur $utilisateur): View
    {
        Gate::authorize('administration.update');

        $user = $utilisateur->user;
        abort_if($user === null, 404);

        return view('administration.utilisateurs.form', [
            'utilisateur' => $utilisateur,
            'user' => $user,
            ...$this->formOptions(),
        ]);
    }

    public function update(Request $request, Utilisateur $utilisateur): RedirectResponse
    {
        Gate::authorize('administration.update');

        $user = $utilisateur->user;
        abort_if($user === null, 404);

        $validated = $request->validate($this->rules($user));

        DB::transaction(function () use ($validated, $user, $utilisateur): void {
            $user->update([
                'name' => trim($validated['prenom'].' '.$validated['nom']),
                'email' => $validated['email'],
            ]);

            $utilisateur->update($this->profileAttributes($validated));
        });

        return redirect()
            ->route('administration.utilisateurs.index')
            ->with('status', 'La fiche a été mise à jour.');
    }

    public function destroy(Utilisateur $utilisateur): RedirectResponse
    {
        Gate::authorize('administration.delete');

        if (
            $utilisateur->photos()->exists()
            || $utilisateur->enseigner()->exists()
        ) {
            return back()->withErrors([
                'utilisateur' => 'Cette fiche ne peut pas être supprimée tant que des photos ou des affectations y sont rattachées.',
            ]);
        }

        $user = $utilisateur->user;

        if (
            $user?->is(auth()->user())
            || $user?->can('administration.view')
        ) {
            return back()->withErrors([
                'utilisateur' => 'Un compte administrateur ne peut pas être supprimé depuis cette page.',
            ]);
        }

        DB::transaction(function () use ($user, $utilisateur): void {
            $utilisateur->delete();
            $user?->delete();
        });

        return redirect()
            ->route('administration.utilisateurs.index')
            ->with('status', 'La fiche et le compte ont été supprimés.');
    }

    private function formOptions(): array
    {
        return [
            'roles' => Role::query()->orderBy('nom')->get(),
            'statuts' => Statut::query()->orderBy('nom')->get(),
            'genres' => Genre::query()->orderBy('nom')->get(),
            'classes' => Classe::query()->orderBy('nom')->get(),
        ];
    }

    private function rules(?User $user = null): array
    {
        return [
            'nom' => ['required', 'string', 'max:50'],
            'prenom' => ['required', 'string', 'max:50'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user?->getKey()),
            ],
            'classe' => ['nullable', 'string', 'exists:classes,code'],
            'adresse' => ['required', 'string', 'max:200'],
            'tel_mobile' => ['required', 'string', 'max:50'],
            'numero_candidat' => ['required', 'string', 'max:20'],
            'commentaire' => ['required', 'string', 'max:250'],
            'id_role' => ['required', 'integer', 'exists:roles,id'],
            'code_statut' => ['required', 'string', 'exists:statuts,code'],
            'code_genre' => ['required', 'string', 'exists:genres,code'],
        ];
    }

    private function profileAttributes(array $validated): array
    {
        return [
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'classe' => $validated['classe'] ?: null,
            'adresse' => $validated['adresse'],
            'tel_mobile' => $validated['tel_mobile'],
            'numero_candidat' => $validated['numero_candidat'],
            'commentaire' => $validated['commentaire'],
            'id_role' => $validated['id_role'],
            'code_statut' => $validated['code_statut'],
            'code_genre' => $validated['code_genre'],
        ];
    }
}
