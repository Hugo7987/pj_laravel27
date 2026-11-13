<x-layouts::pj_laravel27 :title="$utilisateur->exists ? __('Modifier un élève') : __('Créer un élève')">
    @php($editing = $utilisateur->exists)
    <section class="mx-auto flex w-full max-w-4xl flex-col gap-6 p-6">
        <div>
            <a href="{{ route('administration.utilisateurs.index') }}" class="text-sm underline">Retour aux élèves</a>
            <h1 class="mt-3 text-2xl font-semibold text-zinc-900 dark:text-white">{{ $editing ? 'Modifier la fiche' : 'Créer une fiche et son compte' }}</h1>
            @unless ($editing)
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-300">Le compte sera créé sans mot de passe connu ; l’élève devra utiliser « Mot de passe oublié ».</p>
            @endunless
        </div>

        @foreach ($errors->all() as $error)
            <div class="rounded-lg bg-red-50 p-3 text-sm text-red-800 dark:bg-red-950 dark:text-red-200">{{ $error }}</div>
        @endforeach

        <form method="POST" action="{{ $editing ? route('administration.utilisateurs.update', $utilisateur) : route('administration.utilisateurs.store') }}" class="grid gap-4 rounded-xl border border-zinc-200 bg-white p-5 sm:grid-cols-2 dark:border-zinc-700 dark:bg-zinc-900">
            @csrf
            @if ($editing)
                @method('PUT')
            @endif

            <label class="grid gap-1 text-sm">Prénom
                <input name="prenom" value="{{ old('prenom', $utilisateur->prenom) }}" required maxlength="50" class="rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800">
            </label>
            <label class="grid gap-1 text-sm">Nom
                <input name="nom" value="{{ old('nom', $utilisateur->nom) }}" required maxlength="50" class="rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800">
            </label>
            <label class="grid gap-1 text-sm sm:col-span-2">Adresse e-mail du compte
                <input name="email" type="email" value="{{ old('email', $user->email) }}" required maxlength="255" class="rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800">
            </label>
            <label class="grid gap-1 text-sm">Classe (facultative)
                <select name="classe" class="rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800">
                    <option value="">Aucune classe</option>
                    @foreach ($classes as $classe)
                        <option value="{{ $classe->code }}" @selected(old('classe', $utilisateur->classe) === $classe->code)>{{ $classe->nom }} ({{ $classe->code }})</option>
                    @endforeach
                </select>
            </label>
            <label class="grid gap-1 text-sm">Rôle
                <select name="id_role" required class="rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800">
                    <option value="">Sélectionner un rôle</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" @selected((string) old('id_role', $utilisateur->id_role) === (string) $role->id)>{{ $role->nom }}</option>
                    @endforeach
                </select>
            </label>
            <label class="grid gap-1 text-sm">Statut
                <select name="code_statut" required class="rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800">
                    <option value="">Sélectionner un statut</option>
                    @foreach ($statuts as $statut)
                        <option value="{{ $statut->code }}" @selected(old('code_statut', $utilisateur->code_statut) === $statut->code)>{{ $statut->nom }}</option>
                    @endforeach
                </select>
            </label>
            <label class="grid gap-1 text-sm">Genre
                <select name="code_genre" required class="rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800">
                    <option value="">Sélectionner</option>
                    @foreach ($genres as $genre)
                        <option value="{{ $genre->code }}" @selected(old('code_genre', $utilisateur->code_genre) === $genre->code)>{{ $genre->nom }}</option>
                    @endforeach
                </select>
            </label>
            <label class="grid gap-1 text-sm">Téléphone
                <input name="tel_mobile" value="{{ old('tel_mobile', $utilisateur->tel_mobile) }}" required maxlength="50" class="rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800">
            </label>
            <label class="grid gap-1 text-sm sm:col-span-2">Adresse
                <input name="adresse" value="{{ old('adresse', $utilisateur->adresse) }}" required maxlength="200" class="rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800">
            </label>
            <label class="grid gap-1 text-sm">Numéro candidat
                <input name="numero_candidat" value="{{ old('numero_candidat', $utilisateur->numero_candidat) }}" required maxlength="20" class="rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800">
            </label>
            <label class="grid gap-1 text-sm sm:col-span-2">Commentaire
                <textarea name="commentaire" required maxlength="250" rows="3" class="rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800">{{ old('commentaire', $utilisateur->commentaire) }}</textarea>
            </label>
            <div class="sm:col-span-2">
                <button class="rounded-lg bg-zinc-900 px-4 py-2 text-sm font-medium text-white dark:bg-white dark:text-zinc-900">{{ $editing ? 'Enregistrer' : 'Créer' }}</button>
            </div>
        </form>
    </section>
</x-layouts::pj_laravel27>
