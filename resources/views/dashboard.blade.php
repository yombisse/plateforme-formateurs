@extends('layouts.app')

@section('content')
<div class="space-y-6 sm:space-y-8">
    <div class="rounded-[2rem] border border-orange-100 bg-white p-6 sm:p-8 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-orange-500">Espace formateur</p>
                <h1 class="mt-2 text-2xl sm:text-3xl font-semibold tracking-tight text-slate-900">Tableau de bord</h1>
                <p class="mt-3 max-w-2xl text-sm sm:text-base text-slate-600">Gérez vos formations, suivez vos inscriptions et gardez un œil sur les prochains événements.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('trainer-profile.edit') }}" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-4 py-2.5 sm:px-5 sm:py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Mon profil
                </a>
                <a href="{{ route('formations.mes') }}" class="inline-flex items-center justify-center rounded-full bg-orange-600 px-4 py-2.5 sm:px-5 sm:py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-700">
                    Voir mes formations
                </a>
            </div>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
        <section class="rounded-[2rem] border border-orange-100 bg-white p-4 sm:p-6 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-orange-500">À venir</p>
                    <h2 class="mt-2 text-xl sm:text-2xl font-semibold tracking-tight text-slate-900">Prochaines formations</h2>
                </div>
                <div class="flex flex-wrap gap-2 sm:gap-3 text-xs sm:text-sm text-slate-600">
                    <span class="rounded-full border border-slate-200 bg-slate-50 px-2 py-1.5 sm:px-3 sm:py-2">{{ $upcoming->count() }} formations à venir</span>
                    <span class="rounded-full border border-slate-200 bg-slate-50 px-2 py-1.5 sm:px-3 sm:py-2">{{ $totalPlaces }} places disponibles</span>
                </div>
            </div>

            <div class="mt-4 sm:mt-6 space-y-4">
                @foreach($upcoming as $formation)
                    <article class="rounded-[1.5rem] border border-slate-200 bg-slate-50 p-4 shadow-sm">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                            <div class="flex items-center gap-4">
                                <div class="h-16 w-16 sm:h-20 sm:w-20 overflow-hidden rounded-3xl bg-slate-200 flex-shrink-0">
                                    <img src="{{ $formation->image }}" alt="{{ $formation->title }}" class="h-full w-full object-cover" />
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-slate-900 truncate">{{ $formation->title }}</p>
                                    <p class="mt-1 text-xs sm:text-sm text-slate-600">{{ $formation->location }} · {{ $formation->duration }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col gap-2 text-right">
                                <span class="text-xs sm:text-sm text-slate-500">{{ $formation->date }}</span>
                                <span class="text-base sm:text-lg font-semibold text-slate-900">{{ number_format($formation->price, 0, ' ', ' ') }} FCFA</span>
                            </div>
                        </div>
                        <div class="mt-4 grid gap-3 sm:grid-cols-2">
                            <div class="rounded-3xl border border-slate-200 bg-white px-3 py-2.5 sm:px-4 sm:py-3 text-xs sm:text-sm text-slate-700">
                                <p class="font-semibold text-slate-900">{{ $formation->remaining_places }}</p>
                                <p class="text-slate-500">places restantes</p>
                            </div>
                            <div class="rounded-3xl border border-slate-200 bg-white px-3 py-2.5 sm:px-4 sm:py-3 text-xs sm:text-sm text-slate-700">
                                <p class="font-semibold text-slate-900">{{ $formation->max_places - $formation->remaining_places }}</p>
                                <p class="text-slate-500">inscrits</p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <aside class="space-y-6">
            <div class="rounded-[2rem] border border-slate-200 bg-white p-4 sm:p-6 shadow-sm">
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-orange-500">Statistiques</p>
                <div class="mt-4 sm:mt-6 grid gap-4">
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-3 sm:p-4">
                        <p class="text-xs sm:text-sm text-slate-500">Formations actives</p>
                        <p class="mt-2 text-2xl sm:text-3xl font-semibold text-slate-900">{{ $formations->count() }}</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-3 sm:p-4">
                        <p class="text-xs sm:text-sm text-slate-500">Inscriptions totales</p>
                        <p class="mt-2 text-2xl sm:text-3xl font-semibold text-slate-900">{{ $totalInscrits }}</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-3 sm:p-4">
                        <p class="text-xs sm:text-sm text-slate-500">Revenus estimés</p>
                        <p class="mt-2 text-2xl sm:text-3xl font-semibold text-slate-900">{{ number_format($estimatedRevenue, 0, ' ', ' ') }} FCFA</p>
                    </div>
                </div>
            </div>

            <div class="rounded-[2rem] border border-slate-200 bg-white p-4 sm:p-6 shadow-sm">
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-orange-500">Formateur</p>
                <div class="mt-4 sm:mt-6 flex items-center gap-4">
                    <img src="{{ $formateur['photo'] }}" alt="{{ $formateur['name'] }}" class="h-14 w-14 sm:h-16 sm:w-16 rounded-3xl object-cover" />
                    <div>
                        <p class="font-semibold text-slate-900">{{ $formateur['name'] }}</p>
                        <p class="mt-1 text-xs sm:text-sm text-slate-600">{{ $formateur['specialty'] }}</p>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
