<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#FAFAFA] font-sans text-slate-800 antialiased">
        {{-- Simple header with login button only --}}
        <header class="sticky top-0 z-50 border-b border-orange-100/80 bg-white/90 backdrop-blur">
            <div class="mx-auto flex max-w-7xl items-center justify-end px-4 py-3 sm:py-4 sm:px-6 lg:px-8">
                @guest
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-full bg-orange-600 px-4 py-2 sm:px-5 sm:py-2.5 text-sm font-semibold text-white transition hover:bg-orange-700">
                        Se connecter
                    </a>
                @endguest

                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-4 py-2 sm:px-5 sm:py-2.5 text-sm font-semibold text-slate-900 transition hover:bg-slate-50">
                        Tableau de bord
                    </a>
                @endauth
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-6 sm:py-8 sm:px-6 lg:px-8">
            @yield('content')
        </main>
    </body>
</html>