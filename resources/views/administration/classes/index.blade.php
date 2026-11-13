<x-layouts::pj_laravel27 :title="__('Classes')">
    <section class="mx-auto flex w-full max-w-6xl flex-col gap-6 p-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Classes</h1>
                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-300">Les codes sont utilisés par les fiches élèves et les affectations.</p>
            </div>
            <a href="{{ route('administration') }}" class="text-sm underline">Retour à l’administration</a>
        </div>

        @if (session('status'))
            <div class="rounded-lg bg-emerald-50 p-3 text-sm text-emerald-800 dark:bg-emerald-950 dark:text-emerald-200">{{ session('status') }}</div>
        @endif
        @foreach ($errors->all() as $error)
            <div class="rounded-lg bg-red-50 p-3 text-sm text-red-800 dark:bg-red-950 dark:text-red-200">{{ $error }}</div>
        @endforeach

        @can('administration.create')
            <form method="POST" action="{{ route('administration.classes.store') }}" class="grid gap-4 rounded-xl border border-zinc-200 bg-white p-5 sm:grid-cols-4 dark:border-zinc-700 dark:bg-zinc-900">
                @csrf
                <label class="grid gap-1 text-sm">Code
                    <input name="code" value="{{ old('code') }}" required maxlength="10" class="rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800">
                </label>
                <label class="grid gap-1 text-sm">Nom
                    <input name="nom" value="{{ old('nom') }}" required maxlength="100" class="rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800">
                </label>
                <label class="grid gap-1 text-sm sm:col-span-2">Commentaire
                    <input name="commentaire" value="{{ old('commentaire') }}" required maxlength="250" class="rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800">
                </label>
                <div class="sm:col-span-4">
                    <button class="rounded-lg bg-zinc-900 px-4 py-2 text-sm font-medium text-white dark:bg-white dark:text-zinc-900">Ajouter une classe</button>
                </div>
            </form>
        @endcan

        <div class="overflow-x-auto rounded-xl border border-zinc-200 dark:border-zinc-700">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-50 dark:bg-zinc-900">
                    <tr>
                        <th class="p-3">Classe</th>
                        <th class="p-3">Élèves</th>
                        <th class="p-3">Affectations</th>
                        <th class="p-3">Photos</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse ($classes as $classe)
                        <tr class="align-top">
                            <td class="p-3">
                                @can('administration.update')
                                    <form id="classe-{{ $classe->id }}" method="POST" action="{{ route('administration.classes.update', $classe) }}" class="grid gap-2">
                                        @csrf
                                        @method('PUT')
                                        <input name="code" value="{{ $classe->code }}" required maxlength="10" class="w-32 rounded border-zinc-300 text-sm dark:border-zinc-600 dark:bg-zinc-800">
                                        <input name="nom" value="{{ $classe->nom }}" required maxlength="100" class="w-48 rounded border-zinc-300 text-sm dark:border-zinc-600 dark:bg-zinc-800">
                                        <input name="commentaire" value="{{ $classe->commentaire }}" required maxlength="250" class="w-60 rounded border-zinc-300 text-sm dark:border-zinc-600 dark:bg-zinc-800">
                                    </form>
                                @else
                                    <strong>{{ $classe->nom }}</strong><br><span class="text-zinc-500">{{ $classe->code }}</span>
                                @endcan
                            </td>
                            <td class="p-3">{{ $classe->utilisateurs_count }}</td>
                            <td class="p-3">{{ $classe->enseigner_count }}</td>
                            <td class="p-3">{{ $classe->photos_count }}</td>
                            <td class="p-3">
                                <div class="flex flex-wrap gap-2">
                                    @can('administration.update')
                                        <button form="classe-{{ $classe->id }}" class="rounded border px-3 py-1">Enregistrer</button>
                                    @endcan
                                    @can('administration.delete')
                                        <form method="POST" action="{{ route('administration.classes.destroy', $classe) }}" onsubmit="return confirm('Supprimer cette classe ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="rounded border border-red-300 px-3 py-1 text-red-700 dark:border-red-800 dark:text-red-300">Supprimer</button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="p-4 text-zinc-500">Aucune classe enregistrée.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $classes->links() }}
    </section>
</x-layouts::pj_laravel27>
