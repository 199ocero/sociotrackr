<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @fluxStyles
    </head>

    <body class="min-h-screen bg-white dark:bg-zinc-800">

        @php
            $currentRoute = Route::currentRouteName();
            $isDashboard = $currentRoute === 'dashboard';
            $isProfile = $currentRoute === 'profile';
        @endphp

        <flux:header container sticky class="bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-3" inset="left" />

            <flux:brand href="/" logo='https://ui-avatars.com/api/?name=Idea+Toolbox&background=18181b&color=fff'
                name="Idea Toolbox" class="max-lg:hidden dark:hidden" />
            <flux:brand href="/" logo='https://ui-avatars.com/api/?name=Idea+Toolbox&background=fff&color=18181b'
                name="Idea Toolbox" class="max-lg:!hidden hidden dark:flex" />

            <flux:navbar class="-mb-px max-lg:hidden">
                <flux:navbar.item icon="home" href="{{ route('dashboard') }}" :current="$isDashboard">
                    Dashboard
                </flux:navbar.item>
            </flux:navbar>

            <flux:spacer />

            <div class="flex gap-2">
                <flux:button x-data x-on:click="$flux.dark = ! $flux.dark" icon="moon" variant="subtle"
                    aria-label="Toggle dark mode" />
                <flux:dropdown position="top" align="end">
                    <flux:button icon-trailing="chevron-down">{{ Str::initials(auth()->user()->name) }}</flux:button>
                    <flux:menu>
                        <div class="px-3 py-1">
                            <flux:subheading class="!text-xs">Signed in as</flux:subheading>
                            <flux:heading>{{ auth()->user()->name }}</flux:heading>
                        </div>
                        <flux:menu.separator />
                        <flux:menu.item icon="user" href="{{ route('profile') }}">Profile
                        </flux:menu.item>
                        <flux:menu.separator />
                        <livewire:logout.logout />
                    </flux:menu>
                </flux:dropdown>
            </div>
        </flux:header>

        <flux:sidebar stashable sticky
            class="lg:hidden bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <flux:brand href="/" logo='https://ui-avatars.com/api/?name=Idea+Toolbox&background=18181b&color=fff'
                name="Idea Toolbox" class="px-2 dark:hidden" />
            <flux:brand href="/" logo='https://ui-avatars.com/api/?name=Idea+Toolbox&background=fff&color=18181b'
                name="Idea Toolbox" class="px-2 hidden dark:flex" />

            <flux:navlist variant="outline">
                <flux:navlist.item icon="home" href="{{ route('dashboard') }}" :current="$isDashboard">
                    Dashboard
                </flux:navlist.item>
            </flux:navlist>

            <flux:spacer />

            <flux:navlist variant="outline">
                <flux:navlist.item icon="user" href="{{ route('profile') }}" :current="$isProfile">
                    Profile</flux:navlist.item>
                <livewire:logout.logout-sidebar />
            </flux:navlist>
        </flux:sidebar>

        <flux:main container>
            {{ $slot }}
        </flux:main>

        @fluxScripts
    </body>

</html>
