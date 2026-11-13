<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ClassesController extends Controller
{
    public function index(): View
    {
        Gate::authorize('administration.view');

        $classes = Classe::withCount(['utilisateurs', 'enseigner', 'photos'])
            ->orderBy('nom')
            ->paginate(20);

        return view('administration.classes.index', compact('classes'));
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('administration.create');

        Classe::create($request->validate([
            'code' => ['required', 'string', 'max:10', Rule::unique('classes', 'code')],
            'nom' => ['required', 'string', 'max:100'],
            'commentaire' => ['required', 'string', 'max:250'],
        ]));

        return redirect()
            ->route('administration.classes.index')
            ->with('status', 'La classe a été créée.');
    }

    public function update(Request $request, Classe $classe): RedirectResponse
    {
        Gate::authorize('administration.update');

        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:10',
                Rule::unique('classes', 'code')->ignore($classe->getKey()),
            ],
            'nom' => ['required', 'string', 'max:100'],
            'commentaire' => ['required', 'string', 'max:250'],
        ]);

        if (
            $validated['code'] !== $classe->code
            && (
                $classe->utilisateurs()->exists()
                || $classe->enseigner()->exists()
            )
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'code' => 'Le code ne peut pas changer tant que des élèves ou des enseignants sont affectés à cette classe.',
                ]);
        }

        $classe->update($validated);

        return redirect()
            ->route('administration.classes.index')
            ->with('status', 'La classe a été mise à jour.');
    }

    public function destroy(Classe $classe): RedirectResponse
    {
        Gate::authorize('administration.delete');

        if (
            $classe->utilisateurs()->exists()
            || $classe->enseigner()->exists()
            || $classe->photos()->exists()
        ) {
            return back()->withErrors([
                'classe' => 'Cette classe ne peut pas être supprimée tant que des élèves, affectations ou photos y sont rattachés.',
            ]);
        }

        $classe->delete();

        return redirect()
            ->route('administration.classes.index')
            ->with('status', 'La classe a été supprimée.');
    }
}
