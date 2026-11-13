<x-layouts::pj_laravel27 :title="__('Gestion des photos')">
    <section class="mx-auto flex w-full max-w-6xl flex-col gap-6 p-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Gestion des photos</h1>
                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-300">Chaque photo est rattachée soit à un élève, soit à une classe.</p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('administration') }}" class="text-sm underline">Administration</a>
                @can('photos.create')
                    <a href="{{ route('photos.create') }}" class="rounded-lg bg-zinc-900 px-4 py-2 text-sm text-white dark:bg-white dark:text-zinc-900">Importer une photo</a>
                @endcan
            </div>
        </div>

        @if (session('status'))
            <div class="rounded-lg bg-emerald-50 p-3 text-sm text-emerald-800 dark:bg-emerald-950 dark:text-emerald-200">{{ session('status') }}</div>
        @endif
        @foreach ($errors->all() as $error)
            <div class="rounded-lg bg-red-50 p-3 text-sm text-red-800 dark:bg-red-950 dark:text-red-200">{{ $error }}</div>
        @endforeach

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($photos as $photo)
                <article class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
                    <img src="{{ route('photos.file', $photo) }}" alt="{{ $photo->commentaire }}" class="aspect-[4/3] w-full object-cover" loading="lazy">
                    <div class="flex flex-col gap-3 p-4">
                        <div>
                            <h2 class="font-medium">{{ $photo->id_utilisateur !== null ? 'Photo individuelle' : 'Photo de groupe' }}</h2>
                            <p class="text-sm text-zinc-600 dark:text-zinc-300">{{ $photo->commentaire }}</p>
                            <p class="text-xs text-zinc-500">
                                {{ $photo->id_utilisateur !== null
                                    ? ($photo->utilisateur?->prenom.' '.$photo->utilisateur?->nom)
                                    : $photo->classe?->nom }}
                            </p>
                        </div>
                        <div class="flex gap-2">
                            @can('photos.update')
                                <a href="{{ route('photos.edit', $photo) }}" class="rounded border px-3 py-1 text-sm">Modifier</a>
                            @endcan
                            @can('photos.delete')
                                <form method="POST" action="{{ route('photos.destroy', $photo) }}" onsubmit="return confirm('Supprimer cette photo ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded border border-red-300 px-3 py-1 text-sm text-red-700 dark:border-red-800 dark:text-red-300">Supprimer</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </article>
            @empty
                <p class="text-sm text-zinc-600 dark:text-zinc-300">Aucune photo enregistrée.</p>
            @endforelse
        </div>
        {{ $photos->links() }}
    </section>
</x-layouts::pj_laravel27>
