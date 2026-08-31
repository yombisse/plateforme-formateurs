@extends('layouts.vitrine')

@section('content')
<div class="space-y-8">
    <section class="overflow-hidden rounded-[2rem] border border-orange-100 bg-white shadow-sm">
        <div class="relative h-[300px] overflow-hidden sm:h-[340px]">
            <img src="{{ $formateur['hero_image'] }}" alt="Portrait du formateur" class="h-full w-full object-cover" />
            <div class="absolute inset-0 bg-gradient-to-r from-emerald-600/80 via-orange-500/70 to-rose-500/70"></div>
            <div class="absolute inset-x-0 bottom-0 h-20 rounded-t-[2rem] bg-gradient-to-t from-slate-950/20 to-transparent"></div>
        </div>

        <div class="relative -mt-16 px-4 pb-8 sm:px-8 lg:px-10">
            <div class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-lg sm:p-7 lg:p-8">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                    <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                        <div class="relative shrink-0">
                            <img src="{{ $formateur['photo'] }}" alt="{{ $formateur['name'] }}" class="h-36 w-36 rounded-full border-4 border-white object-cover shadow-md sm:h-40 sm:w-40" />
                            <span class="absolute bottom-1 right-1 flex h-8 w-8 items-center justify-center rounded-full border-2 border-white bg-orange-500 text-white shadow">
                                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor" aria-hidden="true">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.54-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.729c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 0 0 .95-.69l1.07-3.292Z" />
                                </svg>
                            </span>
                        </div>

                        <div class="min-w-0">
                            <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">{{ $formateur['name'] }}</h1>
                            <p class="mt-2 text-base font-semibold text-orange-500">{{ $formateur['specialty'] }}</p>
                            <div class="mt-4 flex flex-wrap items-center gap-2 text-sm text-slate-600">
                                <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1">
                                    <svg viewBox="0 0 24 24" class="h-4 w-4 text-orange-500" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M12 21s-6-4.35-6-10a4 4 0 1 1 8 0 4 4 0 1 1 8 0c0 5.65-6 10-6 10Z" />
                                        <circle cx="12" cy="11" r="2.5" />
                                    </svg>
                                    {{ $formateur['location'] }}
                                </span>
                                @foreach ($formateur['socials'] as $social)
                                    <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer" class="rounded-full border border-slate-200 p-2 text-slate-600 transition hover:border-orange-300 hover:text-orange-500" aria-label="{{ $social['name'] }}">
                                        @if ($social['icon'] === 'instagram')
                                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <rect x="3" y="3" width="18" height="18" rx="5" />
                                                <circle cx="12" cy="12" r="4" />
                                                <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none" />
                                            </svg>
                                        @elseif ($social['icon'] === 'linkedin')
                                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor" aria-hidden="true">
                                                <path d="M6.94 8.5A1.56 1.56 0 1 0 6.94 5.38a1.56 1.56 0 0 0 0 3.12ZM5.5 9.5h2.88V18H5.5zM10.5 9.5h2.76v1.16h.04c.38-.72 1.32-1.48 2.72-1.48 2.9 0 3.43 1.9 3.43 4.39V18h-2.88v-7.41c0-1.77-.03-4.05-2.47-4.05-2.47 0-2.85 1.93-2.85 3.91V18H10.5z" />
                                            </svg>
                                        @else
                                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <circle cx="12" cy="12" r="9" />
                                                <path d="M12 3v18" />
                                                <path d="M3 12h18" />
                                            </svg>
                                        @endif
                                    </a>
                                @endforeach
                            </div>

                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach ($formateur['tags'] as $tag)
                                    <a href="#" class="rounded-full bg-orange-50 px-3 py-2 text-sm font-medium text-orange-600 transition hover:bg-orange-100">{{ $tag }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3 sm:gap-4 lg:min-w-[320px] lg:justify-end">
                        @foreach ($formateur['stats'] as $stat)
                            <div class="min-w-[100px] rounded-2xl bg-slate-50 px-4 py-3 text-center shadow-sm">
                                <div class="text-2xl font-bold text-slate-900">{{ $stat['value'] }}</div>
                                <div class="mt-1 text-sm text-slate-500">{{ $stat['label'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="grid gap-6 lg:grid-cols-[1.15fr_0.85fr]">
        <section class="rounded-[1.5rem] border border-slate-200 bg-slate-50 p-6 shadow-sm sm:p-8">
            <h2 class="text-xl font-semibold text-slate-900">À propos</h2>
            <p class="mt-4 text-base leading-8 text-slate-600">{{ $formateur['bio'] }}</p>
        </section>

        <aside class="rounded-[1.5rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Formations disponibles</h2>
                    <p class="mt-2 text-sm text-slate-500">12 places disponibles</p>
                </div>
                <span class="rounded-full border border-orange-200 bg-orange-50 px-3 py-2 text-sm font-semibold text-orange-600">Paiement via Mobile Money</span>
            </div>

            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center">
                <label class="relative flex-1">
                    <span class="sr-only">Rechercher une formation</span>
                    <input type="text" placeholder="Rechercher une formation" class="w-full rounded-full border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none ring-0" />
                </label>
                <select class="rounded-full border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none">
                    <option>Tri : Plus récent</option>
                    <option>Tri : Plus populaire</option>
                </select>
            </div>

            <div class="mt-4 flex flex-wrap gap-2">
                <button class="rounded-full bg-orange-500 px-3 py-2 text-sm font-medium text-white">Tous</button>
                <button class="rounded-full border border-slate-200 px-3 py-2 text-sm font-medium text-slate-600">En ligne</button>
                <button class="rounded-full border border-slate-200 px-3 py-2 text-sm font-medium text-slate-600">Présentiel</button>
            </div>
        </aside>
    </div>

    <section class="rounded-[1.5rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-slate-900">Toutes les formations</h2>
                <p class="mt-2 text-sm text-slate-500">Découvrez l’ensemble des sessions disponibles pour ce formateur.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <span class="rounded-full border border-slate-200 bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-700">{{ $formations->count() }} formations</span>
                <span class="rounded-full border border-orange-200 bg-orange-50 px-3 py-2 text-sm font-semibold text-orange-600">Paiement via Mobile Money</span>
            </div>
        </div>

        <div class="mt-6 grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($formations as $formation)
                @php
                    $progress = $formation->max_places > 0 ? round(($formation->remaining_places / $formation->max_places) * 100) : 0;
                @endphp

                <article class="group relative overflow-hidden rounded-[1.5rem] border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                    <a href="{{ route('formations.show', $formation->slug) }}" class="absolute inset-0 z-10"></a>

                    <div class="relative overflow-hidden">
                        <img src="{{ $formation->image }}" alt="{{ $formation->title }}" class="aspect-video w-full object-cover" />
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/20 to-transparent"></div>
                        <span class="absolute left-3 top-3 rounded-full bg-white/90 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-700 backdrop-blur">
                            {{ $formation->category }}
                        </span>
                        <span class="absolute right-3 top-3 inline-flex items-center gap-1 rounded-full {{ $formation->mode === 'En ligne' ? 'bg-emerald-100 text-emerald-700' : 'bg-orange-100 text-orange-700' }} px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.2em]">
                            @if ($formation->mode === 'En ligne')
                                <svg viewBox="0 0 24 24" class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M4 10a8 8 0 1 1 16 0" />
                                    <path d="M4 10a8 8 0 0 0 16 0" />
                                    <path d="M12 18v3" />
                                    <path d="M8 21h8" />
                                </svg>
                            @else
                                <svg viewBox="0 0 24 24" class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M12 21s-6-4.35-6-10a4 4 0 1 1 8 0 4 4 0 1 1 8 0c0 5.65-6 10-6 10Z" />
                                    <circle cx="12" cy="11" r="2.5" />
                                </svg>
                            @endif
                            {{ $formation->mode }}
                        </span>
                    </div>

                    <div class="relative z-20 p-5">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-slate-400">{{ $formation->level }}</p>
                        <h3 class="mt-3 overflow-hidden text-lg font-semibold text-slate-900 line-clamp-2">{{ $formation->title }}</h3>
                        <p class="mt-2 overflow-hidden text-sm leading-6 text-slate-500 line-clamp-2">{{ $formation->description }}</p>

                        <div class="mt-4 space-y-2 text-sm text-slate-600">
                            <div class="flex items-center gap-2">
                                <svg viewBox="0 0 24 24" class="h-4 w-4 text-orange-500" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <rect x="3" y="4" width="18" height="18" rx="2" />
                                    <path d="M16 2v4" />
                                    <path d="M8 2v4" />
                                    <path d="M3 10h18" />
                                </svg>
                                <span>{{ $formation->date }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                @if ($formation->mode === 'En ligne')
                                    <svg viewBox="0 0 24 24" class="h-4 w-4 text-orange-500" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M4 10a8 8 0 1 1 16 0" />
                                        <path d="M4 10a8 8 0 0 0 16 0" />
                                        <path d="M12 18v3" />
                                        <path d="M8 21h8" />
                                    </svg>
                                @else
                                    <svg viewBox="0 0 24 24" class="h-4 w-4 text-orange-500" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M12 21s-6-4.35-6-10a4 4 0 1 1 8 0 4 4 0 1 1 8 0c0 5.65-6 10-6 10Z" />
                                        <circle cx="12" cy="11" r="2.5" />
                                    </svg>
                                @endif
                                <span>{{ $formation->location }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg viewBox="0 0 24 24" class="h-4 w-4 text-orange-500" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <circle cx="12" cy="12" r="8" />
                                    <path d="M12 7v5l3 2" />
                                </svg>
                                <span>{{ $formation->duration }}</span>
                            </div>
                        </div>

                        <div class="mt-5">
                            <div class="h-2 rounded-full bg-slate-200">
                                <div class="h-2 rounded-full {{ $formation->remaining_places <= 6 ? 'bg-orange-500' : 'bg-emerald-500' }}" style="width: {{ $progress }}%"></div>
                            </div>
                            <div class="mt-2 flex items-center justify-between text-sm">
                                <span class="font-medium text-slate-600">{{ $formation->remaining_places }} places restantes</span>
                                <span class="font-semibold text-slate-700">{{ $progress }}%</span>
                            </div>
                        </div>

                        <div class="mt-5 flex items-end justify-between gap-3">
                            <div>
                                <div class="text-2xl font-bold text-slate-900">{{ number_format($formation->price, 0, ',', ' ') }}</div>
                                <div class="text-[11px] uppercase tracking-[0.3em] text-slate-400">FCFA</div>
                            </div>
                            <a href="{{ route('formations.show', $formation->slug) }}" class="relative z-20 inline-flex items-center gap-2 rounded-full bg-orange-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-orange-600">S'inscrire <span aria-hidden="true">→</span></a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    {{-- Section Recommandations du formateur --}}
    @php
        $trainer = null;
        $recommandations = collect();
        $totalRecommandations = 0;
        
        // Récupérer le premier utilisateur formateur, sinon utiliser un utilisateur par défaut
        $trainerUser = \App\Models\User::whereHas('formations')->first();
        if(!$trainerUser) {
            // Si aucun formateur n'a de formations, utiliser le premier utilisateur
            $trainerUser = \App\Models\User::first();
        }
        
        if($trainerUser) {
            $trainerUser->load('recommandations');
            $recommandations = $trainerUser->recommandations()->where('is_public', true)->orderBy('created_at', 'desc')->get();
            $totalRecommandations = $trainerUser->recommandations()->where('is_public', true)->count();
        }
    @endphp
    
    @if($trainerUser)
        <section class="rounded-[1.5rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-slate-900">Recommandations</h2>
                <span class="inline-flex items-center gap-1 text-sm text-slate-600">
                    <svg class="w-4 h-4 text-orange-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                    </svg>
                    {{ $totalRecommandations }} recommandation{{ $totalRecommandations > 1 ? 's' : '' }}
                </span>
            </div>
            
            {{-- Formulaire de recommandation simple --}}
            @include('recommandations.partials.recommandation-form-simple', ['trainer' => $trainerUser])
            
            {{-- Liste des recommandations --}}
            @include('recommandations.partials.recommandation-list', ['trainer' => $trainerUser, 'recommandations' => $recommandations, 'totalRecommandations' => $totalRecommandations])
        </section>
    @endif
</div>
@endsection
