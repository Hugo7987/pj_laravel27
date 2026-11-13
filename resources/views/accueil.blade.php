<x-layouts::pj_laravel27 :title="__('Accueil')">
    <main class="mx-auto flex w-full max-w-7xl flex-col gap-16 px-6 py-10 sm:px-8 sm:py-14 lg:gap-24 lg:px-12">
        <section class="relative isolate overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-50 via-white to-teal-50 px-6 py-12 ring-1 ring-zinc-200 dark:from-zinc-900 dark:via-zinc-900 dark:to-indigo-950 dark:ring-zinc-700 sm:px-10 sm:py-16 lg:px-16 lg:py-20">
            <div class="absolute -right-20 -top-24 -z-10 size-80 rounded-full bg-indigo-200/40 blur-3xl dark:bg-indigo-500/10"></div>
            <div class="absolute -bottom-28 left-1/3 -z-10 size-80 rounded-full bg-teal-200/40 blur-3xl dark:bg-teal-500/10"></div>

            <div class="grid items-center gap-12 lg:grid-cols-[1.2fr_0.8fr] lg:gap-16">
                <div class="flex flex-col items-start gap-6">
                    <span class="inline-flex items-center gap-2 rounded-full border border-indigo-200 bg-white/80 px-3 py-1 text-sm font-medium text-indigo-800 dark:border-indigo-400/20 dark:bg-zinc-900/70 dark:text-indigo-200">
                        <span class="size-2 rounded-full bg-teal-500"></span>
                        Votre espace scolaire
                    </span>

                    <div class="flex flex-col gap-4">
                        <h1 class="max-w-3xl text-4xl font-semibold tracking-tight text-zinc-950 dark:text-white sm:text-5xl lg:text-6xl">
                            Les photos de classe, simplement organisées.
                        </h1>
                        <p class="max-w-2xl text-lg leading-8 text-zinc-600 dark:text-zinc-300">
                            Retrouvez les photos individuelles et les photos de groupe dans un espace adapté aux élèves, aux professeurs et aux administrateurs.
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        @guest
                            <flux:button :href="route('login')" variant="primary">
                                Se connecter
                            </flux:button>
                        @endguest

                        @auth
                            @can('photos.view')
                                <flux:button :href="route('photos')" variant="primary">
                                    Voir mes photos
                                </flux:button>
                            @endcan

                            @can('trombinoscope.view')
                                <a href="{{ route('trombinoscope') }}" class="inline-flex min-h-10 items-center rounded-lg border border-zinc-300 bg-white/80 px-4 py-2 text-sm font-medium text-zinc-800 transition hover:bg-white dark:border-zinc-600 dark:bg-zinc-900/70 dark:text-zinc-100 dark:hover:bg-zinc-800">
                                    Ouvrir le trombinoscope
                                </a>
                            @endcan

                            @can('administration.view')
                                <a href="{{ route('administration') }}" class="inline-flex min-h-10 items-center rounded-lg border border-zinc-300 bg-white/80 px-4 py-2 text-sm font-medium text-zinc-800 transition hover:bg-white dark:border-zinc-600 dark:bg-zinc-900/70 dark:text-zinc-100 dark:hover:bg-zinc-800">
                                    Accéder à l’administration
                                </a>
                            @endcan

                            @unless (auth()->user()->can('photos.view') || auth()->user()->can('trombinoscope.view') || auth()->user()->can('administration.view'))
                                <p class="text-sm text-zinc-600 dark:text-zinc-300">
                                    Votre compte est connecté. Les rubriques disponibles apparaîtront selon vos autorisations.
                                </p>
                            @endunless
                        @endauth
                    </div>
                </div>

                <div class="rounded-2xl border border-white/80 bg-white/75 p-6 shadow-xl shadow-indigo-950/5 backdrop-blur dark:border-zinc-700 dark:bg-zinc-900/75 dark:shadow-black/10 sm:p-8">
                    <p class="text-sm font-semibold uppercase tracking-wider text-indigo-700 dark:text-indigo-300">
                        Un espace pour chaque profil
                    </p>
                    <div class="mt-6 flex flex-col gap-6">
                        <div class="flex gap-4">
                            <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-indigo-100 text-sm font-semibold text-indigo-800 dark:bg-indigo-400/15 dark:text-indigo-200">01</span>
                            <div class="flex flex-col gap-1">
                                <h2 class="font-semibold text-zinc-900 dark:text-white">Élèves</h2>
                                <p class="text-sm leading-6 text-zinc-600 dark:text-zinc-300">Accès à leur photo individuelle et aux photos de groupe de leur classe.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-teal-100 text-sm font-semibold text-teal-800 dark:bg-teal-400/15 dark:text-teal-200">02</span>
                            <div class="flex flex-col gap-1">
                                <h2 class="font-semibold text-zinc-900 dark:text-white">Professeurs</h2>
                                <p class="text-sm leading-6 text-zinc-600 dark:text-zinc-300">Consultation des trombinoscopes et des photos des classes qui leur sont affectées.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-sm font-semibold text-amber-800 dark:bg-amber-400/15 dark:text-amber-200">03</span>
                            <div class="flex flex-col gap-1">
                                <h2 class="font-semibold text-zinc-900 dark:text-white">Administrateurs</h2>
                                <p class="text-sm leading-6 text-zinc-600 dark:text-zinc-300">Préparation des classes, des fiches élèves, des affectations et des photos.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="flex flex-col gap-8">
            <div class="flex max-w-2xl flex-col gap-3">
                <p class="text-sm font-semibold uppercase tracking-wider text-indigo-700 dark:text-indigo-300">Comment ça marche</p>
                <h2 class="text-3xl font-semibold tracking-tight text-zinc-950 dark:text-white sm:text-4xl">
                    Tout ce qu’il faut pour les photos de rentrée.
                </h2>
                <p class="leading-7 text-zinc-600 dark:text-zinc-300">
                    Les accès sont limités au profil de chaque personne et aux classes qui la concernent.
                </p>
            </div>

            <div class="grid gap-4 md:grid-cols-3">
                <article class="flex flex-col gap-3 rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
                    <span class="flex size-11 items-center justify-center rounded-xl bg-indigo-100 font-semibold text-indigo-800 dark:bg-indigo-400/15 dark:text-indigo-200">01</span>
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Des photos bien rattachées</h3>
                    <p class="text-sm leading-6 text-zinc-600 dark:text-zinc-300">Chaque photo est associée à un élève ou à une classe pour être retrouvée facilement.</p>
                </article>
                <article class="flex flex-col gap-3 rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
                    <span class="flex size-11 items-center justify-center rounded-xl bg-teal-100 font-semibold text-teal-800 dark:bg-teal-400/15 dark:text-teal-200">02</span>
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Un accès adapté</h3>
                    <p class="text-sm leading-6 text-zinc-600 dark:text-zinc-300">Les élèves consultent leurs photos ; les enseignants voient les classes qui leur sont affectées.</p>
                </article>
                <article class="flex flex-col gap-3 rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
                    <span class="flex size-11 items-center justify-center rounded-xl bg-amber-100 font-semibold text-amber-800 dark:bg-amber-400/15 dark:text-amber-200">03</span>
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Une rentrée préparée</h3>
                    <p class="text-sm leading-6 text-zinc-600 dark:text-zinc-300">Les administrateurs préparent les classes, les affectations et les photos avant leur diffusion.</p>
                </article>
            </div>
        </section>

        <section class="flex flex-col items-start justify-between gap-6 rounded-2xl bg-zinc-950 px-6 py-8 text-white dark:bg-zinc-800 sm:flex-row sm:items-center sm:px-10">
            <div class="flex max-w-2xl flex-col gap-2">
                <h2 class="text-xl font-semibold">Prêt à consulter votre espace ?</h2>
                <p class="text-sm leading-6 text-zinc-300">Connectez-vous pour accéder aux rubriques autorisées pour votre compte.</p>
            </div>
            @guest
                <flux:button :href="route('login')" variant="primary">
                    Se connecter
                </flux:button>
            @endguest
            @auth
                @can('photos.view')
                    <flux:button :href="route('photos')" variant="primary">
                        Accéder à mes photos
                    </flux:button>
                @else
                    @can('trombinoscope.view')
                        <flux:button :href="route('trombinoscope')" variant="primary">
                            Accéder au trombinoscope
                        </flux:button>
                    @else
                        @can('administration.view')
                            <flux:button :href="route('administration')" variant="primary">
                                Ouvrir l’administration
                            </flux:button>
                        @endcan
                    @endcan
                @endcan
            @endauth
        </section>
    </main>
</x-layouts::pj_laravel27>
