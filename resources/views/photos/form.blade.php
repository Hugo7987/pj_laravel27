<x-layouts::pj_laravel27 :title="$photo->exists ? __('Modifier une photo') : __('Importer une photo')">
    @php($editing = $photo->exists)
    <section class="mx-auto flex w-full max-w-3xl flex-col gap-6 p-6">
        <div>
            <a href="{{ route('photos.manage') }}" class="text-sm underline">Retour à la gestion des photos</a>
            <h1 class="mt-3 text-2xl font-semibold text-zinc-900 dark:text-white">{{ $editing ? 'Modifier une photo' : 'Importer une photo' }}</h1>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-300">Les fichiers sont stockés sur le disque privé et servis uniquement après vérification des droits.</p>
        </div>

        @foreach ($errors->all() as $error)
            <div class="rounded-lg bg-red-50 p-3 text-sm text-red-800 dark:bg-red-950 dark:text-red-200">{{ $error }}</div>
        @endforeach

        @if ($editing)
            <img src="{{ route('photos.file', $photo) }}" alt="{{ $photo->commentaire }}" class="max-h-80 rounded-xl object-contain">
        @endif

        <form method="POST" enctype="multipart/form-data" action="{{ $editing ? route('photos.update', $photo) : route('photos.store') }}" class="grid gap-4 rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
            @csrf
            @if ($editing)
                @method('PUT')
            @endif
            <label class="grid gap-1 text-sm">Fichier image {{ $editing ? '(facultatif)' : '' }}
                <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp" @required(! $editing) class="rounded-lg border border-zinc-300 p-2 dark:border-zinc-600">
            </label>

            <fieldset class="grid gap-2 text-sm">
                <legend class="font-medium">Type de photo</legend>
                <label class="flex items-center gap-2">
                    <input type="radio" name="photo_type" value="individual" @checked(old('photo_type', $photoType) === 'individual')>
                    Photo individuelle
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="photo_type" value="group" @checked(old('photo_type', $photoType) === 'group')>
                    Photo de groupe
                </label>
            </fieldset>

            <label class="grid gap-1 text-sm">Élève (photo individuelle)
                <select name="id_utilisateur" class="rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800">
                    <option value="">Sélectionner un élève</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" @selected((string) old('id_utilisateur', $photo->id_utilisateur) === (string) $student->id)>{{ $student->prenom }} {{ $student->nom }} — {{ $student->role?->nom ?? 'rôle inconnu' }}</option>
                    @endforeach
                </select>
            </label>

            <label class="grid gap-1 text-sm">Classe (photo de groupe)
                <select name="id_classe" class="rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800">
                    <option value="">Sélectionner une classe</option>
                    @foreach ($classes as $classe)
                        <option value="{{ $classe->id }}" @selected((string) old('id_classe', $photo->id_classe) === (string) $classe->id)>{{ $classe->nom }} ({{ $classe->code }})</option>
                    @endforeach
                </select>
            </label>

            <label class="grid gap-1 text-sm">Commentaire
                <textarea name="commentaire" required maxlength="250" rows="3" class="rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800">{{ old('commentaire', $photo->commentaire) }}</textarea>
            </label>

            <div>
                <button class="rounded-lg bg-zinc-900 px-4 py-2 text-sm font-medium text-white dark:bg-white dark:text-zinc-900">{{ $editing ? 'Enregistrer' : 'Importer' }}</button>
            </div>
        </form>
    </section>
</x-layouts::pj_laravel27>
