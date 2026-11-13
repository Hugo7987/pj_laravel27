<x-layouts::pj_laravel27 :title="__('Administration')">
    <section class="mx-auto flex w-full max-w-6xl flex-col gap-6 p-6">
        <div>
            <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Administration</h1>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-300">
                Préparez les classes, les élèves et les affectations avant la rentrée.
            </p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @can('administration.view')
                <a href="{{ route('administration.classes.index') }}" class="rounded-xl border border-zinc-200 bg-white p-5 hover:border-zinc-400 dark:border-zinc-700 dark:bg-zinc-900">
                    <h2 class="font-semibold text-zinc-900 dark:text-white">Classes</h2>
                    <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-300">Créer, modifier et supprimer les classes.</p>
                </a>
                <a href="{{ route('administration.utilisateurs.index') }}" class="rounded-xl border border-zinc-200 bg-white p-5 hover:border-zinc-400 dark:border-zinc-700 dark:bg-zinc-900">
                    <h2 class="font-semibold text-zinc-900 dark:text-white">Élèves et comptes</h2>
                    <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-300">Gérer les fiches et leurs comptes de connexion.</p>
                </a>
                <a href="{{ route('administration.enseigners.index') }}" class="rounded-xl border border-zinc-200 bg-white p-5 hover:border-zinc-400 dark:border-zinc-700 dark:bg-zinc-900">
                    <h2 class="font-semibold text-zinc-900 dark:text-white">Affectations</h2>
                    <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-300">Affecter les utilisateurs aux classes enseignées.</p>
                </a>
            @endcan

            @can('photos.view')
                <a href="{{ route('photos.manage') }}" class="rounded-xl border border-zinc-200 bg-white p-5 hover:border-zinc-400 dark:border-zinc-700 dark:bg-zinc-900">
                    <h2 class="font-semibold text-zinc-900 dark:text-white">Gestion des photos</h2>
                    <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-300">Importer et rattacher les photos aux élèves ou classes.</p>
                </a>
            @endcan
        </div>
    </section>
</x-layouts::pj_laravel27>
