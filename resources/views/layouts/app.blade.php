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
        <header class="sticky top-0 z-50 border-b border-orange-100/80 bg-white/90 backdrop-blur">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#F97316] shadow-sm">
                        <svg class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M4 5.5A1.5 1.5 0 0 1 5.5 4h8A1.5 1.5 0 0 1 15 5.5V8H5.5A1.5 1.5 0 0 0 4 9.5v7A1.5 1.5 0 0 0 5.5 18H15v-2.5" />
                            <path d="M17 8h2.5A1.5 1.5 0 0 1 21 9.5v7A1.5 1.5 0 0 1 19.5 18H17" />
                            <path d="M8 8v10" />
                            <path d="M12 8v10" />
                        </svg>
                    </div>
                    <span class="text-lg font-semibold tracking-tight text-slate-900 hidden sm:block">FormatPro</span>
                </a>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center gap-2">
                    <a href="{{ url('/') }}" class="rounded-full px-4 py-2 text-sm font-medium transition {{ request()->is('/') ? 'bg-orange-50 text-orange-600' : 'text-slate-600 hover:bg-slate-100' }}">
                        Vitrine
                    </a>

                    <a href="{{ route('formations.mes') }}" class="rounded-full px-4 py-2 text-sm font-medium transition {{ request()->routeIs('formations.mes') ? 'bg-orange-50 text-orange-600' : 'text-slate-600 hover:bg-slate-100' }}">
                        Mes formations
                    </a>

                    @guest
                        <a href="{{ route('login') }}" class="rounded-full px-4 py-2 text-sm font-medium transition {{ request()->routeIs('login') ? 'bg-orange-50 text-orange-600' : 'text-slate-600 hover:bg-slate-100' }}">
                            Connexion
                        </a>
                    @endguest

                    @auth
                        <a href="{{ route('dashboard') }}" class="rounded-full px-4 py-2 text-sm font-medium transition {{ request()->is('dashboard') || request()->is('admin*') ? 'bg-orange-50 text-orange-600' : 'text-slate-600 hover:bg-slate-100' }}">
                            Admin
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="rounded-full px-4 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50">
                                Déconnexion
                            </button>
                        </form>
                    @endauth

                    <a href="#" class="rounded-full border border-orange-300 px-4 py-2 text-sm font-semibold text-orange-600 transition hover:bg-orange-50">
                        Partager
                    </a>
                </nav>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-slate-600 hover:bg-slate-100">
                    <svg id="menu-icon" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg id="close-icon" class="h-6 w-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden border-t border-slate-200 bg-white">
                <div class="px-4 py-3 space-y-2">
                    <a href="{{ url('/') }}" class="block rounded-lg px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">
                        Vitrine
                    </a>
                    <a href="{{ route('formations.mes') }}" class="block rounded-lg px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">
                        Mes formations
                    </a>
                    @guest
                        <a href="{{ route('login') }}" class="block rounded-lg px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">
                            Connexion
                        </a>
                    @endguest
                    @auth
                        <a href="{{ route('dashboard') }}" class="block rounded-lg px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">
                            Admin
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline w-full">
                            @csrf
                            <button type="submit" class="block w-full rounded-lg px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 text-left">
                                Déconnexion
                            </button>
                        </form>
                    @endauth
                    <a href="#" class="block rounded-lg px-4 py-2 text-sm font-semibold text-orange-600 hover:bg-orange-50">
                        Partager
                    </a>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:py-8">
            @yield('content')
        </main>

        <script>
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('menu-icon');
            const closeIcon = document.getElementById('close-icon');

            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                menuIcon.classList.toggle('hidden');
                closeIcon.classList.toggle('hidden');
            });
        </script>
    </body>
</html>
