@extends('layouts.vitrine')

@section('content')
<div class="grid gap-8 lg:grid-cols-[1.35fr_0.85fr]">
    <main class="space-y-8">
        <a href="{{ route('vitrine.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-orange-600">
            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M15 18l-6-6 6-6" />
            </svg>
            Retour
        </a>

        <div class="rounded-[1.75rem] border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="relative">
                <img src="{{ $formation->image_url }}" alt="{{ $formation->title }}" class="aspect-video w-full object-cover" />
                <div class="absolute inset-x-0 bottom-0 px-5 pb-5 flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center rounded-full bg-white/90 px-3 py-1 text-[0.65rem] font-semibold uppercase tracking-[0.35em] text-slate-700 shadow-sm">{{ $formation->category }}</span>
                    <span class="inline-flex items-center gap-2 rounded-full bg-orange-600 px-3 py-1 text-[0.65rem] font-semibold uppercase tracking-[0.35em] text-white">
                        <svg viewBox="0 0 24 24" class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M12 2C8.134 2 5 5.134 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.866-3.134-7-7-7Z" />
                            <circle cx="12" cy="9" r="2.5" />
                        </svg>
                        {{ $formation->mode }}
                    </span>
                </div>
            </div>

            <div class="px-6 pb-6 pt-6 sm:px-8">
                <p class="text-xs uppercase tracking-[0.35em] text-slate-500">{{ $formation->level }}</p>
                <h1 class="mt-4 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">{{ $formation->title }}</h1>

                <div class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-3xl border border-slate-200 bg-white p-3 text-sm text-slate-800">
                        <p class="text-[0.65rem] uppercase tracking-[0.35em] text-slate-500">Date</p>
                        <p class="mt-2 font-semibold text-slate-900">{{ $formation->date }}</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-white p-3 text-sm text-slate-800">
                        <p class="text-[0.65rem] uppercase tracking-[0.35em] text-slate-500">Lieu</p>
                        <p class="mt-2 font-semibold text-slate-900">{{ $formation->location }}</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-white p-3 text-sm text-slate-800">
                        <p class="text-[0.65rem] uppercase tracking-[0.35em] text-slate-500">Durée</p>
                        <p class="mt-2 font-semibold text-slate-900">{{ $formation->duration }}</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-white p-3 text-sm text-slate-800">
                        <p class="text-[0.65rem] uppercase tracking-[0.35em] text-slate-500">Places</p>
                        <p class="mt-2 font-semibold text-slate-900">{{ $formation->remaining_places }} restantes</p>
                    </div>
                </div>
            </div>
        </div>

        <section class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">À propos de cette formation</h2>
            <p class="mt-4 text-sm leading-7 text-slate-700">{{ $formation->full_description }}</p>
        </section>

        @if($formation->learning_points && count($formation->learning_points) > 0)
        <section class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Ce que vous apprendrez</h2>
            <div class="mt-5 grid gap-3 sm:grid-cols-2">
                @foreach ($formation->learning_points as $point)
                    <div class="flex items-start gap-3 py-3 text-sm leading-7 text-slate-700">
                        <span class="mt-1 inline-flex h-8 w-8 items-center justify-center rounded-full bg-orange-100 text-orange-700">
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>
                        </span>
                        <span>{{ $point }}</span>
                    </div>
                @endforeach
            </div>
        </section>
        @endif
        
        <!-- @if($formation->modules && count($formation->modules) > 0) -->
        <section class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Programme détaillé</h2>
            <div class="mt-5 space-y-3">
                @foreach ($formation->modules as $index => $item)
                    <div class="flex gap-4 py-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-orange-500 text-sm font-semibold text-white">{{ $index + 1 }}</div>
                        <div>
                            <p class="font-semibold text-slate-900">{{ $item['title'] }}</p>
                            <p class="mt-1 text-sm leading-6 text-slate-700">{{ $item['description'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        <!-- @endif -->

        @if ($formation->practical_info && count($formation->practical_info) > 0)
        <section class="rounded-[1.75rem] border border-orange-100 bg-amber-50 p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Informations pratiques</h2>
            <ul class="mt-4 space-y-3 text-sm leading-7 text-slate-700">
                @foreach ($formation->practical_info as $info)
                    <li class="flex items-start gap-3">
                        <span class="mt-1 inline-flex h-7 w-7 items-center justify-center rounded-full bg-orange-100 text-orange-700">
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M5 12l5 5L20 7" />
                            </svg>
                        </span>
                        <span>{{ $info }}</span>
                    </li>
                @endforeach
            </ul>
        </section>
        @endif

        {{-- Section Évaluations --}}
        @php
            $formation->load('evaluations.user');
            $averageRating = $formation->averageRating() ?? 0;
            $ratingDistribution = [];
            for($i = 1; $i <= 5; $i++) {
                $ratingDistribution[$i] = $formation->evaluations()->where('rating', $i)->count();
            }
            $evaluations = $formation->evaluations()->orderBy('created_at', 'desc')->get();
        @endphp
        
        <div class="space-y-6">
            {{-- Formulaire d'évaluation --}}
            @include('evaluations.partials.evaluation-form-simple', ['formation' => $formation])
            
            {{-- Liste des évaluations --}}
            @include('evaluations.partials.evaluation-list', ['formation' => $formation, 'evaluations' => $evaluations, 'averageRating' => $averageRating, 'ratingDistribution' => $ratingDistribution])
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <a href="https://wa.me/{{ $formateur['phone'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full border border-emerald-500 bg-white px-4 py-2 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-50">
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor" aria-hidden="true">
                    <path d="M20.52 3.48A11.63 11.63 0 0 0 12 0C5.37 0 0 5.4 0 12.07c0 2.12.55 4.21 1.6 6.05L0 24l5.96-1.56A11.99 11.99 0 0 0 12 24c6.63 0 12-5.4 12-12.07 0-3.27-1.24-6.35-3.48-8.45ZM12 21.2c-1.9 0-3.75-.5-5.35-1.44l-.38-.23-3.54.93.94-3.43-.25-.37A8.92 8.92 0 0 1 2.8 12.08c0-4.93 4-8.93 9.2-8.93 2.46 0 4.77.96 6.51 2.71a9.24 9.24 0 0 1 2.7 6.52c0 4.98-4 9.26-8.91 9.26Zm4.62-6.75c-.25-.13-1.48-.73-1.71-.82-.23-.09-.4-.13-.57.13-.16.25-.62.82-.76.98-.14.16-.28.18-.52.06-.25-.13-1.05-.39-2-1.24-.74-.66-1.24-1.48-1.39-1.73-.14-.25-.02-.38.11-.51.11-.11.25-.28.38-.42.12-.14.16-.25.25-.42.08-.16.04-.3-.02-.42-.06-.13-.57-1.37-.78-1.88-.2-.48-.4-.42-.57-.43-.15-.01-.33-.01-.51-.01-.18 0-.47.07-.72.34-.25.27-.95.93-.95 2.27 0 1.34.97 2.63 1.11 2.81.14.18 1.92 2.91 4.66 4.08.65.28 1.16.45 1.56.58.66.22 1.26.19 1.74.12.53-.08 1.48-.61 1.69-1.2.21-.58.21-1.08.15-1.2-.06-.12-.23-.18-.48-.3Z" />
                </svg>
                Partager sur WhatsApp
            </a>
            <button type="button" onclick="navigator.clipboard.writeText(window.location.href)" class="inline-flex items-center gap-2 rounded-full border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M20 12H8" />
                    <path d="M13 5l-6 7 6 7" />
                </svg>
                Copier le lien
            </button>
        </div>
    </main>

    <aside x-data="inscriptionSidebar({{ $formation->id }}, {{ $formation->price }})" class="space-y-6 lg:sticky lg:top-8 w-full">
        <div x-show="view === 'summary'" x-cloak class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-xs uppercase tracking-[0.35em] text-slate-500">Prix de la formation</p>
            <div class="mt-4 flex flex-wrap items-end gap-3">
                <span class="text-[2.75rem] font-bold tracking-tight text-slate-900">{{ number_format($formation->price, 0, ' ', ' ') }}</span>
                <span class="pb-1 text-sm uppercase tracking-[0.3em] text-slate-500">FCFA</span>
            </div>

            <div class="mt-5 flex items-center justify-between text-sm text-slate-700">
                <div class="flex items-center gap-2">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-orange-100 text-orange-700">
                        <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                    </span>
                    <span class="font-semibold text-slate-900">{{ $formation->remaining_places }} places restantes</span>
                </div>
                <span class="text-xs uppercase tracking-[0.25em] text-slate-500">{{ round((($formation->max_places - $formation->remaining_places) / $formation->max_places) * 100) }}% rempli</span>
            </div>

            <div class="mt-3 h-2 overflow-hidden rounded-full bg-slate-100">
                <div class="h-full rounded-full bg-emerald-500" style="width: {{ max(0, min(100, round((($formation->max_places - $formation->remaining_places) / $formation->max_places) * 100))) }}%"></div>
            </div>

            <button type="button" @click.prevent="view = 'form'" class="mt-6 inline-flex w-full items-center justify-between rounded-full bg-orange-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-700">
                <span>S'inscrire maintenant</span>
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M5 12h14" />
                    <path d="M13 6l6 6-6 6" />
                </svg>
            </button>

            <p class="mt-4 text-center text-xs text-slate-500">Inscription gratuite · Paiement après confirmation</p>

            <div class="mt-6 space-y-4 text-sm text-slate-700">
                <div class="flex items-center gap-3">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-slate-100 text-orange-600">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M8 7V3h8v4" />
                            <path d="M18 7a6 6 0 0 1-12 0" />
                            <path d="M4 21h16" />
                        </svg>
                    </span>
                    <div>
                        <p class="text-xs uppercase tracking-[0.25em] text-slate-500">Date</p>
                        <p class="font-semibold text-slate-900">{{ $formation->date }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-slate-100 text-orange-600">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M12 21s-6-4.35-6-10a4 4 0 1 1 8 0 4 4 0 1 1 8 0c0 5.65-6 10-6 10Z" />
                            <circle cx="12" cy="11" r="2.5" />
                        </svg>
                    </span>
                    <div>
                        <p class="text-xs uppercase tracking-[0.25em] text-slate-500">Lieu</p>
                        <p class="font-semibold text-slate-900">{{ $formation->location }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-2xl bg-slate-100 text-orange-600">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="12" r="8" />
                            <path d="M12 7v5l3 2" />
                        </svg>
                    </span>
                    <div>
                        <p class="text-xs uppercase tracking-[0.25em] text-slate-500">Durée</p>
                        <p class="font-semibold text-slate-900">{{ $formation->duration }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="view === 'form'" x-cloak class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
            <button type="button" @click.prevent="view = 'summary'" class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-orange-600">
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M15 18l-6-6 6-6" />
                </svg>
                Retour
            </button>

            <h2 class="mt-4 text-lg font-semibold text-slate-900">Formulaire d'inscription</h2>
            <p class="mt-2 text-sm text-slate-600">Prix : {{ number_format($formation->price, 0, ' ', ' ') }} FCFA</p>

            <form x-on:submit.prevent="submit($event)" action="{{ route('inscriptions.store', $formation->id) }}" method="POST" class="mt-6 space-y-4">
                @csrf
                <input type="hidden" name="formation_id" value="{{ $formation->id }}" />

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Nom complet</label>
                    <div class="mt-2 flex items-center gap-3 rounded-3xl border border-slate-200 bg-white px-4 py-3">
                        <svg viewBox="0 0 24 24" class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        <input x-model="form.nom_complet" name="nom_complet" type="text" class="w-full border-0 bg-transparent text-sm text-slate-900 outline-none" placeholder="Nom complet" required />
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Téléphone / WhatsApp</label>
                    <div class="mt-2 flex items-center gap-3 rounded-3xl border border-slate-200 bg-white px-4 py-3">
                        <svg viewBox="0 0 24 24" class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 3 5.18 2 2 0 0 1 5 3h3a2 2 0 0 1 2 1.72 12.38 12.38 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L9 10.6a16 16 0 0 0 6.4 6.4l1.96-1.26a2 2 0 0 1 2.11-.45 12.38 12.38 0 0 0 2.81.7A2 2 0 0 1 22 16.92Z" />
                        </svg>
                        <input x-model="form.telephone" name="telephone" type="text" class="w-full border-0 bg-transparent text-sm text-slate-900 outline-none" placeholder="+221 77 000 00 00" required />
                    </div>
                    <p class="mt-2 text-xs text-slate-500">Le formateur vous contactera à ce numéro</p>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">Email (facultatif)</label>
                    <div class="mt-2 flex items-center gap-3 rounded-3xl border border-slate-200 bg-white px-4 py-3">
                        <svg viewBox="0 0 24 24" class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M4 4h16v16H4z" />
                            <path d="M22 6l-10 7L2 6" />
                        </svg>
                        <input x-model="form.email" name="email" type="email" class="w-full border-0 bg-transparent text-sm text-slate-900 outline-none" placeholder="votre@email.com" />
                    </div>
                </div>

                <div class="rounded-[1.5rem] bg-orange-50 p-4 text-sm leading-6 text-slate-700">
                    Après votre inscription, la formatrice vous contacte sur WhatsApp pour vous communiquer les détails de paiement (Wave, Orange Money, ou virement).
                </div>

                <button type="submit" :disabled="loading" class="inline-flex w-full items-center justify-center rounded-full bg-orange-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-700 disabled:cursor-not-allowed disabled:opacity-70">
                    <span x-text="loading ? 'Envoi en cours...' : 'Confirmer mon inscription'"></span>
                </button>

                <template x-if="error">
                    <div class="rounded-3xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700" x-text="error"></div>
                </template>

                <template x-if="success">
                    <div class="rounded-3xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700" x-text="status"></div>
                </template>
            </form>
        </div>

        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm" x-show="view === 'summary'" x-cloak>
            <div class="flex items-start gap-4">
                <img src="{{ $formateur['photo'] }}" alt="{{ $formateur['name'] }}" class="h-16 w-16 rounded-full object-cover shadow-sm" />
                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-2">
                        <p class="text-sm font-semibold text-slate-900">{{ $formateur['name'] }}</p>
                        <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-[0.65rem] font-semibold uppercase tracking-[0.25em] text-emerald-700">WhatsApp</span>
                    </div>
                    <p class="mt-3 text-sm leading-6 text-slate-600">{{ $formateur['specialty'] }}</p>
                </div>
            </div>
        </div>

        {{-- Section Recommandations --}}
        @php
            // Pour l'instant, on utilise l'utilisateur connecté comme formateur
            // Dans un vrai système, il faudrait lier le formateur à l'utilisateur
            $trainer = auth()->check() ? auth()->user() : null;
            if($trainer) {
                $trainer->load('recommandations');
                $recommandations = $trainer->recommandations()->where('is_public', true)->orderBy('created_at', 'desc')->get();
                $totalRecommandations = $trainer->recommandations()->where('is_public', true)->count();
            }
        @endphp
        
        @if(isset($trainer))
            <div class="space-y-6" x-show="view === 'summary'" x-cloak>
                {{-- Formulaire de recommandation --}}
                @include('recommandations.partials.recommandation-form-simple', ['trainer' => $trainer])
                
                {{-- Liste des recommandations --}}
                @include('recommandations.partials.recommandation-list', ['trainer' => $trainer, 'recommandations' => $recommandations ?? collect(), 'totalRecommandations' => $totalRecommandations ?? 0])
            </div>
        @endif
    </aside>
</div>
@endsection
