@extends('layouts.app')

@section('content')
<div class="space-y-6 sm:space-y-8">
    <header class="rounded-[2rem] border border-orange-100 bg-white p-4 sm:p-6 lg:p-8 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-orange-500">Mes formations</p>
                <h1 class="mt-2 text-2xl sm:text-3xl font-semibold tracking-tight text-slate-900">Gestion de mes formations</h1>
                <p class="mt-3 max-w-2xl text-sm sm:text-base text-slate-600">Toutes vos formations passées, en cours et à venir, avec des actions pour éditer, supprimer ou ajouter une nouvelle session.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                <a href="{{ route('admin.formation.create') }}" class="inline-flex items-center justify-center rounded-full bg-orange-600 px-4 py-2.5 sm:px-5 sm:py-3 text-sm font-semibold text-white transition hover:bg-orange-700">Ajouter une formation</a>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-4 py-2.5 sm:px-5 sm:py-3 text-sm font-semibold text-slate-900 transition hover:bg-slate-50">Retour au tableau de bord</a>
            </div>
        </div>
    </header>

    @if(session('success'))
        <div class="rounded-[16px] border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900 shadow-sm">{{ session('success') }}</div>
    @endif

    @if($formations->isEmpty())
        <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50 p-6 sm:p-10 text-center text-slate-600 shadow-sm">
            <p class="text-base sm:text-lg font-semibold">Vous n'avez encore aucune formation.</p>
            <p class="mt-2 text-sm">Ajoutez votre première formation pour commencer à gérer vos sessions.</p>
        </div>
    @else
        <div class="grid gap-4 sm:gap-6 lg:grid-cols-2">
            @foreach($formations as $formation)
                <article class="overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5">
                    <div class="relative h-48 sm:h-56 lg:h-72 overflow-hidden bg-slate-100">
                        <img src="{{ $formation->image ?? 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1200&q=80' }}" alt="{{ $formation->title }}" class="h-full w-full object-cover transition duration-500" />
                    </div>
                    <div class="p-4 sm:p-6">
                        <div class="flex flex-wrap gap-2 text-xs sm:text-sm text-slate-500">
                            <span class="rounded-full border border-slate-200 bg-slate-50 px-2 py-0.5 sm:px-3 sm:py-1">{{ $formation->category }}</span>
                            <span class="rounded-full border border-slate-200 bg-slate-50 px-2 py-0.5 sm:px-3 sm:py-1">{{ $formation->mode }}</span>
                            <span class="rounded-full border border-slate-200 bg-slate-50 px-2 py-0.5 sm:px-3 sm:py-1">{{ $formation->level }}</span>
                        </div>

                        <h2 class="mt-3 sm:mt-4 text-lg sm:text-xl font-semibold tracking-tight text-slate-900 line-clamp-2">{{ $formation->title }}</h2>
                        <p class="mt-2 sm:mt-3 text-xs sm:text-sm leading-5 sm:leading-6 text-slate-600 line-clamp-2">{{ $formation->short_description }}</p>

                        <div class="mt-4 sm:mt-6 grid gap-3 sm:grid-cols-2">
                            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-3 sm:p-4 text-xs sm:text-sm text-slate-700">
                                <p class="font-semibold text-slate-900">{{ $formation->start_date?->format('d M Y') ?? 'À planifier' }}</p>
                                <p class="mt-1 text-slate-500">Date de début</p>
                            </div>
                            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-3 sm:p-4 text-xs sm:text-sm text-slate-700">
                                <p class="font-semibold text-slate-900">{{ $formation->remaining_places }}</p>
                                <p class="mt-1 text-slate-500">Places restantes</p>
                            </div>
                        </div>

                        <div class="mt-4 sm:mt-6 flex flex-wrap gap-2">
                            <a href="{{ route('formations.show', $formation->slug) }}" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-3 py-2 text-xs sm:text-sm font-medium text-slate-700 hover:bg-slate-50 transition">Voir détails</a>
                            <a href="{{ route('admin.inscriptions.index', $formation->id) }}" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-3 py-2 text-xs sm:text-sm font-medium text-slate-700 hover:bg-slate-50 transition">Inscriptions</a>
                            <a href="{{ route('admin.formation.edit', $formation->slug) }}" class="inline-flex items-center justify-center rounded-full bg-orange-600 px-3 py-2 text-xs sm:text-sm font-medium text-white hover:bg-orange-700 transition">Modifier</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</div>
@endsection