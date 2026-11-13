<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Enseigner;
use App\Models\Photo;
use App\Models\Utilisateur;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use RuntimeException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Throwable;

class PhotosController extends Controller
{
    public function index(): View
    {
        Gate::authorize('photos.view');

        $user = auth()->user();

        if ($user->can('administration.view')) {
            $photos = Photo::with(['utilisateur.user', 'classe'])
                ->latest('id')
                ->paginate(24);
        } else {
            $profile = $user->utilisateur;

            if ($profile === null) {
                $photos = Photo::query()->whereRaw('1 = 0')->paginate(24);
            } else {
                $classId = $profile->classe !== null
                    ? Classe::where('code', $profile->classe)->value('id')
                    : null;

                $isAssignedAsTeacher = Enseigner::query()
                    ->where('id_utilisateur', $profile->id)
                    ->exists();

                $photos = Photo::query()
                    ->with(['utilisateur.user', 'classe'])
                    ->where(function ($query) use ($profile): void {
                        $query->where('id_utilisateur', $profile->id);
                    })
                    ->when(
                        ! $isAssignedAsTeacher && $classId !== null,
                        fn ($query) => $query->orWhere('id_classe', $classId)
                    )
                    ->latest('id')
                    ->paginate(24);
            }
        }

        return view('photos', compact('photos'));
    }

    public function manage(): View
    {
        Gate::authorize('administration.view');
        Gate::authorize('photos.view');

        $photos = Photo::with(['utilisateur.user', 'classe'])
            ->latest('id')
            ->paginate(24);

        return view('photos.manage', compact('photos'));
    }

    public function create(): View
    {
        Gate::authorize('administration.view');
        Gate::authorize('photos.create');

        return view('photos.form', $this->formData(new Photo));
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('administration.view');
        Gate::authorize('photos.create');

        $validated = $request->validate($this->photoRules());
        $path = $request->file('image')->store('photos', 'local');

        if ($path === false) {
            throw new RuntimeException('La photo n’a pas pu être enregistrée.');
        }

        try {
            DB::transaction(function () use ($validated, $path): void {
                Photo::create([
                    'chemin' => $path,
                    'commentaire' => $validated['commentaire'],
                    'id_utilisateur' => $validated['photo_type'] === 'individual'
                        ? $validated['id_utilisateur']
                        : null,
                    'id_classe' => $validated['photo_type'] === 'group'
                        ? $validated['id_classe']
                        : null,
                ]);
            });
        } catch (Throwable $exception) {
            Storage::disk('local')->delete($path);

            throw $exception;
        }

        return redirect()
            ->route('photos.manage')
            ->with('status', 'La photo a été ajoutée.');
    }

    public function edit(Photo $photo): View
    {
        Gate::authorize('administration.view');
        Gate::authorize('photos.update');

        return view('photos.form', $this->formData($photo));
    }

    public function update(Request $request, Photo $photo): RedirectResponse
    {
        Gate::authorize('administration.view');
        Gate::authorize('photos.update');

        $validated = $request->validate($this->photoRules(requiredImage: false));
        $oldPath = $photo->chemin;
        $newPath = $request->file('image')?->store('photos', 'local');

        if ($request->hasFile('image') && $newPath === false) {
            throw new RuntimeException('La nouvelle photo n’a pas pu être enregistrée.');
        }

        try {
            DB::transaction(function () use ($photo, $validated, $newPath): void {
                $photo->update([
                    'chemin' => $newPath ?? $photo->chemin,
                    'commentaire' => $validated['commentaire'],
                    'id_utilisateur' => $validated['photo_type'] === 'individual'
                        ? $validated['id_utilisateur']
                        : null,
                    'id_classe' => $validated['photo_type'] === 'group'
                        ? $validated['id_classe']
                        : null,
                ]);
            });
        } catch (Throwable $exception) {
            if (is_string($newPath)) {
                Storage::disk('local')->delete($newPath);
            }

            throw $exception;
        }

        if (is_string($newPath) && ! Storage::disk('local')->delete($oldPath)) {
            Log::warning('Une ancienne photo n’a pas pu être supprimée après remplacement.', [
                'photo_id' => $photo->getKey(),
                'path' => $oldPath,
            ]);
        }

        return redirect()
            ->route('photos.manage')
            ->with('status', 'La photo a été mise à jour.');
    }

    public function destroy(Photo $photo): RedirectResponse
    {
        Gate::authorize('administration.view');
        Gate::authorize('photos.delete');

        $path = $photo->chemin;
        $photo->delete();

        if (! Storage::disk('local')->delete($path)) {
            Log::warning('Le fichier d’une photo supprimée n’a pas pu être effacé.', [
                'photo_id' => $photo->getKey(),
                'path' => $path,
            ]);
        }

        return redirect()
            ->route('photos.manage')
            ->with('status', 'La photo a été supprimée.');
    }

    public function file(Photo $photo): BinaryFileResponse
    {
        Gate::authorize('view', $photo);

        $disk = Storage::disk('local');

        abort_unless($disk->exists($photo->chemin), 404);

        return response()->file($disk->path($photo->chemin), [
            'Cache-Control' => 'private, no-store, max-age=0',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function trombinoscope(): View
    {
        Gate::authorize('trombinoscope.view');

        $user = auth()->user();

        if ($user->can('administration.view')) {
            $classes = Classe::query()->orderBy('nom')->get();
        } else {
            $profile = $user->utilisateur;

            abort_if($profile === null, 403);

            $classCodes = Enseigner::query()
                ->where('id_utilisateur', $profile->id)
                ->pluck('id_classe');

            $classes = Classe::query()
                ->whereIn('code', $classCodes)
                ->orderBy('nom')
                ->get();
        }

        $classes->load([
            'photos',
            'utilisateurs' => fn ($query) => $query
                ->with(['user', 'photos'])
                ->orderBy('nom')
                ->orderBy('prenom'),
        ]);

        return view('trombinoscope', compact('classes'));
    }

    private function formData(Photo $photo): array
    {
        return [
            'photo' => $photo,
            'students' => Utilisateur::with(['user', 'role'])
                ->whereNotNull('classe')
                ->orderBy('nom')
                ->orderBy('prenom')
                ->get(),
            'classes' => Classe::query()->orderBy('nom')->get(),
            'photoType' => $photo->id_utilisateur !== null ? 'individual' : 'group',
        ];
    }

    private function photoRules(bool $requiredImage = true): array
    {
        return [
            'image' => [
                $requiredImage ? 'required' : 'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'photo_type' => ['required', Rule::in(['individual', 'group'])],
            'id_utilisateur' => [
                'nullable',
                'required_if:photo_type,individual',
                'prohibited_if:photo_type,group',
                'integer',
                Rule::exists('utilisateurs', 'id')->whereNotNull('classe'),
            ],
            'id_classe' => [
                'nullable',
                'required_if:photo_type,group',
                'prohibited_if:photo_type,individual',
                'integer',
                'exists:classes,id',
            ],
            'commentaire' => ['required', 'string', 'max:250'],
        ];
    }
}
