<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

     <div class="text-center">
        <p class="text-sm font-semibold uppercase tracking-[0.26em] text-orange-600">Connexion formateur</p>
        <h1 class="mt-4 text-3xl font-semibold text-slate-900">Bienvenue</h1>
        <p class="mt-2 text-sm text-slate-500">Connectez-vous pour accéder à votre espace formateur et gérer vos formations.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="mt-1 block w-full rounded-[8px] border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-slate-700">Mot de passe</label>
            <input id="password" name="password" type="password" required autocomplete="current-password" class="mt-1 block w-full rounded-[8px] border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between text-sm text-slate-600">
            <label class="inline-flex items-center gap-2">
                <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-orange-600 focus:ring-orange-500" />
                <span>Se souvenir de moi</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="font-medium text-orange-600 hover:text-orange-700">Mot de passe oublié ?</a>
            @endif
        </div>

        <div>
            <button type="submit" class="inline-flex w-full items-center justify-center rounded-[10px] bg-[#FF7A1A] px-4 py-2 text-sm font-semibold text-white transition hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-100">Se connecter</button>
        </div>
    </form>
</x-guest-layout>
