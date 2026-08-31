@extends('layouts.app')

@section('content')
<section class="grid gap-8 lg:grid-cols-[1.2fr_0.8fr] lg:items-center">
    <div class="rounded-3xl border border-orange-100 bg-white p-8 shadow-sm sm:p-10">
        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-orange-500">Bienvenue</p>
        <h1 class="mt-4 text-4xl font-semibold tracking-tight text-slate-900 sm:text-5xl">
            Créez des parcours de formation à grande échelle.
        </h1>
        <p class="mt-5 max-w-2xl text-lg leading-8 text-slate-600">
            Formez, partagez et pilotez vos contenus pédagogiques depuis une seule expérience claire et moderne.
        </p>
        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('login') }}" class="rounded-full bg-orange-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-orange-600">
                Se connecter
            </a>
            <a href="#" class="rounded-full border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                Découvrir la plateforme
            </a>
        </div>
    </div>

    <div class="rounded-3xl bg-orange-50 p-8 shadow-sm sm:p-10">
        <div class="rounded-2xl border border-orange-100 bg-white p-6">
            <p class="text-sm font-semibold text-orange-600">À venir</p>
            <h2 class="mt-2 text-2xl font-semibold text-slate-900">Un espace formateur pensé pour vos équipes</h2>
            <ul class="mt-5 space-y-3 text-sm text-slate-600">
                <li class="flex items-start gap-2">
                    <span class="mt-1 h-2.5 w-2.5 rounded-full bg-orange-500"></span>
                    <span>Publiez vos modules rapidement.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="mt-1 h-2.5 w-2.5 rounded-full bg-orange-500"></span>
                    <span>Suivez l’avancement depuis le tableau de bord.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="mt-1 h-2.5 w-2.5 rounded-full bg-orange-500"></span>
                    <span>Partagez votre savoir en quelques clics.</span>
                </li>
            </ul>
        </div>
    </div>
</section>
@endsection
