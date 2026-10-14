<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden mr-2" icon="bars-2" inset="left" />

            <x-app-logo href="{{ route('dashboard') }}" wire:navigate />

            <flux:navbar class="-mb-px max-lg:hidden">
                @can("accueil.view")
                    <flux:sidebar.item icon="layout-grid" :href="route('home')" :current="request()->routeIs('home')" wire:navigate>
                        {{ __('Accueil')  }}
                    </flux:sidebar.item>
                @endcan
                @can("photos.view")
                    <flux:sidebar.item icon="layout-grid" :href="route('photos')" :current="request()->routeIs('photos')" wire:navigate>
                        {{ __('Photos')  }}
                    </flux:sidebar.item>
                @endcan
                @can("trombinoscope.view")
                    <flux:sidebar.item icon="layout-grid" :href="route('trombinoscope')" :current="request()->routeIs('trombinoscope')" wire:navigate>
                        {{ __('Trombinoscope')  }}
                    </flux:sidebar.item>
                @endcan
                @can("administration.view")
                    <flux:sidebar.item icon="layout-grid" :href="route('administration')" :current="request()->routeIs('administration')" wire:navigate>
                        {{ __('Administration')  }}
                    </flux:sidebar.item>
                @endcan
            </flux:navbar>

            <flux:spacer />

            <flux:navbar class="me-1.5 space-x-0.5 rtl:space-x-reverse py-0!">
                 @guest
                <flux:navbar>
                    <flux:navbar.item :href="route('login')" :current="request()->routeIs('login')" wire:navigate>
                        {{ __("Connexion") }}
                    </flux:navbar.item>
                    
                    <flux:navbar.item :href="route('register')" :current="request()->routeIs('register')" wire:navigate>
                        {{ __("Créer un compte") }}
                    </flux:navbar.item>
                    </flux:navbar>
                @endguest

                @auth
                    <x-desktop-user-menu />
                @endauth
                <flux:tooltip :content="__('Repository')" position="bottom">
                    <flux:navbar.item
                        class="h-10 max-lg:hidden [&>div>svg]:size-5"
                        icon="folder-git-2"
                        href="https://github.com/laravel/livewire-starter-kit"
                        target="_blank"
                        :label="__('Repository')"
                    />
                </flux:tooltip>
                <flux:tooltip :content="__('Documentation')" position="bottom">
                    <flux:navbar.item
                        class="h-10 max-lg:hidden [&>div>svg]:size-5"
                        icon="book-open-text"
                        href="https://laravel.com/docs/starter-kits#livewire"
                        target="_blank"
                        :label="__('Documentation')"
                    />
                </flux:tooltip>
            </flux:navbar>

        </flux:header>

        <flux:footer container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <p style="text-align: center;">© 2026 - Mon application</p>
        </flux:footer>

        <!-- Mobile Menu -->
        <flux:sidebar collapsible="mobile" sticky class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Platform')">
                    <flux:sidebar.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard')  }}
                    </flux:sidebar.item>
                    @can("accueil.view")
                        <flux:sidebar.item icon="layout-grid" :href="route('home')" :current="request()->routeIs('home')" wire:navigate>
                            {{ __('Accueil')  }}
                        </flux:sidebar.item>
                    @endcan
                    @can("photos.view")
                        <flux:sidebar.item icon="layout-grid" :href="route('photos')" :current="request()->routeIs('photos')" wire:navigate>
                            {{ __('Photos')  }}
                        </flux:sidebar.item>
                    @endcan
                    @can("trombinoscope.view")
                        <flux:sidebar.item icon="layout-grid" :href="route('trombinoscope')" :current="request()->routeIs('trombinoscope')" wire:navigate>
                            {{ __('Trombinoscope')  }}
                        </flux:sidebar.item>
                    @endcan
                    @can("administration.view")
                        <flux:sidebar.item icon="layout-grid" :href="route('administration')" :current="request()->routeIs('administration')" wire:navigate>
                            {{ __('Administration')  }}
                        </flux:sidebar.item>
                    @endcan
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <flux:sidebar.nav>
                <flux:sidebar.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                    {{ __('Repository') }}
                </flux:sidebar.item>
                <flux:sidebar.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                    {{ __('Documentation') }}
                </flux:sidebar.item>
            </flux:sidebar.nav>
        </flux:sidebar>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
