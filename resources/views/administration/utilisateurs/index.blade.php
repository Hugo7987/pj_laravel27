<x-layouts::pj_laravel27 :title="__('Élèves')">
    <section class="mx-auto flex w-full max-w-6xl flex-col gap-6 p-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Élèves et comptes</h1>
                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-300">Une fiche est liée au compte Laravel portant le même identifiant.</p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('administration') }}" class="text-sm underline">Administration</a>
                @can('administration.create')
                    <a href="{{ route('administration.utilisateurs.create') }}" class="rounded-lg bg-zinc-900 px-4 py-2 text-sm text-white dark:bg-white dark:text-zinc-900">Créer une fiche</a>
                @endcan
            </div>
        </div>

        @if (session('status'))
            <div class="rounded-lg bg-emerald-50 p-3 text-sm text-emerald-800 dark:bg-emerald-950 dark:text-emerald-200">{{ session('status') }}</div>
        @endif
        @foreach ($errors->all() as $error)
            <div class="rounded-lg bg-red-50 p-3 text-sm text-red-800 dark:bg-red-950 dark:text-red-200">{{ $error }}</div>
        @endforeach

        <div class="overflow-x-auto rounded-xl border border-zinc-200 dark:border-zinc-700">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-50 dark:bg-zinc-900">
                    <tr>
                        <th class="p-3">Élève</th>
                        <th class="p-3">Classe</th>
                        <th class="p-3">Rôle / statut</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse ($utilisateurs as $utilisateur)
                        <tr>
                            <td class="p-3">
                                <strong>{{ $utilisateur->prenom }} {{ $utilisateur->nom }}</strong>
                                <div class="text-zinc-500">{{ $utilisateur->user?->email }}</div>
                            </td>
                            <td class="p-3">{{ $utilisateur->classe?->nom ?? '—' }}</td>
                            <td class="p-3">{{ $utilisateur->role?->nom ?? '—' }} / {{ $utilisateur->codeStatut?->nom ?? '—' }}</td>
                            <td class="p-3">
                                <div class="flex gap-2">
                                    @can('administration.update')
                                        <a href="{{ route('administration.utilisateurs.edit', $utilisateur) }}" class="rounded border px-3 py-1">Modifier</a>
                                    @endcan
                                    @can('administration.delete')
                                        <form method="POST" action="{{ route('administration.utilisateurs.destroy', $utilisateur) }}" onsubmit="return confirm('Supprimer cette fiche et son compte ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="rounded border border-red-300 px-3 py-1 text-red-700 dark:border-red-800 dark:text-red-300">Supprimer</button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="p-4 text-zinc-500">Aucune fiche utilisateur enregistrée.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $utilisateurs->links() }}
    </section>
</x-layouts::pj_laravel27>
