<x-layouts::pj_laravel27 :title="__('Affectations')">
    <section class="mx-auto flex w-full max-w-6xl flex-col gap-6 p-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Affectations aux classes</h1>
                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-300">Choisissez l’utilisateur enseignant et la classe concernée.</p>
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
            <form method="POST" action="{{ route('administration.enseigners.store') }}" class="grid gap-4 rounded-xl border border-zinc-200 bg-white p-5 sm:grid-cols-3 dark:border-zinc-700 dark:bg-zinc-900">
                @csrf
                <label class="grid gap-1 text-sm">Enseignant
                    <select name="id_utilisateur" required class="rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800">
                        <option value="">Sélectionner un utilisateur</option>
                        @foreach ($utilisateurs as $utilisateur)
                            <option value="{{ $utilisateur->id }}">{{ $utilisateur->prenom }} {{ $utilisateur->nom }} — {{ $utilisateur->role?->nom ?? 'rôle inconnu' }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="grid gap-1 text-sm">Classe
                    <select name="id_classe" required class="rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800">
                        <option value="">Sélectionner une classe</option>
                        @foreach ($classes as $classe)
                            <option value="{{ $classe->code }}">{{ $classe->nom }} ({{ $classe->code }})</option>
                        @endforeach
                    </select>
                </label>
                <div class="flex items-end">
                    <button class="rounded-lg bg-zinc-900 px-4 py-2 text-sm font-medium text-white dark:bg-white dark:text-zinc-900">Affecter</button>
                </div>
            </form>
        @endcan

        <div class="overflow-x-auto rounded-xl border border-zinc-200 dark:border-zinc-700">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-50 dark:bg-zinc-900">
                    <tr><th class="p-3">Enseignant</th><th class="p-3">Classe</th><th class="p-3">Action</th></tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse ($affectations as $affectation)
                        <tr>
                            <td class="p-3">{{ $affectation->utilisateur?->prenom }} {{ $affectation->utilisateur?->nom }} ({{ $affectation->utilisateur?->role?->nom ?? 'rôle inconnu' }})</td>
                            <td class="p-3">{{ $affectation->classe?->nom }} ({{ $affectation->id_classe }})</td>
                            <td class="p-3">
                                @can('administration.delete')
                                    <form method="POST" action="{{ route('administration.enseigners.destroy', [$affectation->id_utilisateur, $affectation->id_classe]) }}" onsubmit="return confirm('Retirer cette affectation ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded border border-red-300 px-3 py-1 text-red-700 dark:border-red-800 dark:text-red-300">Retirer</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="p-4 text-zinc-500">Aucune affectation enregistrée.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $affectations->links() }}
    </section>
</x-layouts::pj_laravel27>
