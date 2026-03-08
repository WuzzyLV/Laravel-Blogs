<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-900 text-neutral-900 dark:text-neutral-100">

        <header class="border-b border-neutral-200 dark:border-zinc-700 bg-white dark:bg-zinc-900">
            <div class="mx-auto max-w-4xl px-4 py-4 flex items-center justify-between">
                <a href="{{ route('home') }}" class="text-lg font-semibold tracking-tight hover:opacity-80 transition-opacity">
                    {{ config('app.name', 'Blog') }}
                </a>

                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm text-neutral-500 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-100 transition-colors">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-neutral-500 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-neutral-100 transition-colors">
                        Login
                    </a>
                @endauth
            </div>
        </header>

        <main class="mx-auto max-w-4xl px-4 py-10">
            {{ $slot }}
        </main>

        @fluxScripts
    </body>
</html>
