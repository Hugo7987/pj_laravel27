<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Enseigner;
use App\Models\Utilisateur;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EnseignersController extends Controller
{
    public function index(): View
    {
        Gate::authorize('administration.view');

        $affectations = Enseigner::query()
            ->with(['utilisateur.user', 'utilisateur.role', 'classe'])
            ->orderBy('id_classe')
            ->orderBy('id_utilisateur')
            ->paginate(25);
        $utilisateurs = Utilisateur::query()
            ->with(['user', 'role'])
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get();
        $classes = Classe::query()->orderBy('nom')->get();

        return view('administration.enseigners.index', compact(
            'affectations',
            'utilisateurs',
            'classes'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('administration.create');

        $validated = $request->validate([
            'id_utilisateur' => ['required', 'integer', 'exists:utilisateurs,id'],
            'id_classe' => ['required', 'string', 'exists:classes,code'],
        ]);

        $alreadyAssigned = Enseigner::query()
            ->where('id_utilisateur', $validated['id_utilisateur'])
            ->where('id_classe', $validated['id_classe'])
            ->exists();

        if (! $alreadyAssigned) {
            Enseigner::create($validated);
        }

        return redirect()
            ->route('administration.enseigners.index')
            ->with('status', $alreadyAssigned
                ? 'Cette affectation existe déjà.'
                : 'L’enseignant a été affecté à la classe.');
    }

    public function destroy(string $utilisateur, string $classe): RedirectResponse
    {
        Gate::authorize('administration.delete');

        $affectation = Enseigner::query()
            ->where('id_utilisateur', $utilisateur)
            ->where('id_classe', $classe)
            ->firstOrFail();

        Enseigner::query()
            ->where('id_utilisateur', $utilisateur)
            ->where('id_classe', $classe)
            ->delete();

        return redirect()
            ->route('administration.enseigners.index')
            ->with('status', 'L’affectation a été supprimée.');
    }
}
