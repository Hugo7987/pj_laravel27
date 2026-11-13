<x-layouts::pj_laravel27 :title="__('Trombinoscope')">
    <section class="mx-auto flex w-full max-w-6xl flex-col gap-8 p-6">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Trombinoscope</h1>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-300">Les classes affichées sont limitées à celles qui te sont affectées.</p>
        </div>

        @forelse ($classes as $classe)
            <section class="flex flex-col gap-4">
                <div>
                    <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">{{ $classe->nom }}</h2>
                    <p class="text-sm text-zinc-500">{{ $classe->code }}</p>
                </div>

                @if ($classe->photos->isNotEmpty())
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($classe->photos as $photo)
                            <article class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
                                <img src="{{ route('photos.file', $photo) }}" alt="{{ $photo->commentaire }}" class="aspect-[4/3] w-full object-cover" loading="lazy">
                                <p class="p-3 text-sm">{{ $photo->commentaire }}</p>
                            </article>
                        @endforeach
                    </div>
                @endif

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($classe->utilisateurs as $utilisateur)
                        @foreach ($utilisateur->photos as $photo)
                            <article class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
                                <img src="{{ route('photos.file', $photo) }}" alt="Photo de {{ $utilisateur->prenom }} {{ $utilisateur->nom }}" class="aspect-[4/3] w-full object-cover" loading="lazy">
                                <p class="p-3 text-sm font-medium">{{ $utilisateur->prenom }} {{ $utilisateur->nom }}</p>
                            </article>
                        @endforeach
                    @endforeach
                </div>

                @if ($classe->photos->isEmpty() && $classe->utilisateurs->every(fn ($utilisateur) => $utilisateur->photos->isEmpty()))
                    <p class="text-sm text-zinc-500">Aucune photo n’est disponible pour cette classe.</p>
                @endif
            </section>
        @empty
            <p class="text-sm text-zinc-600 dark:text-zinc-300">Aucune classe ne t’est affectée.</p>
        @endforelse
    </section>
</x-layouts::pj_laravel27>
