<x-layouts::pj_laravel27 :title="__('Photos')">
    <section class="mx-auto flex w-full max-w-6xl flex-col gap-6 p-6">
        <div class="flex flex-wrap items-end justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Mes photos</h1>
                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-300">Tes photos individuelles et celles de groupe de ta classe.</p>
            </div>
            @can('administration.view')
                @can('photos.view')
                    <a href="{{ route('photos.manage') }}" class="rounded-lg border px-4 py-2 text-sm">Gérer les photos</a>
                @endcan
            @endcan
        </div>

        @if (session('status'))
            <div class="rounded-lg bg-emerald-50 p-3 text-sm text-emerald-800 dark:bg-emerald-950 dark:text-emerald-200">{{ session('status') }}</div>
        @endif

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($photos as $photo)
                <article class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
                    <img src="{{ route('photos.file', $photo) }}" alt="{{ $photo->commentaire }}" class="aspect-[4/3] w-full object-cover" loading="lazy">
                    <div class="p-4">
                        <h2 class="font-medium text-zinc-900 dark:text-white">
                            {{ $photo->id_utilisateur !== null ? 'Photo individuelle' : 'Photo de groupe' }}
                        </h2>
                        <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-300">{{ $photo->commentaire }}</p>
                        @if ($photo->id_classe !== null)
                            <p class="mt-1 text-xs text-zinc-500">{{ $photo->classe?->nom }}</p>
                        @endif
                    </div>
                </article>
            @empty
                <p class="text-sm text-zinc-600 dark:text-zinc-300">Aucune photo n’est encore disponible pour ton compte.</p>
            @endforelse
        </div>

        {{ $photos->links() }}
    </section>
</x-layouts::pj_laravel27>
