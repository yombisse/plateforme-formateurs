@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 px-4 py-6 sm:px-6 lg:px-8">
    <div class="mx-auto w-full max-w-7xl">
        {{-- En-tête --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('formations.mes') }}" class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-white shadow-sm border border-slate-200 text-slate-700 hover:bg-slate-50 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-slate-900">Gestion des inscriptions</h1>
                    <p class="text-sm text-slate-500 mt-1 line-clamp-1">{{ $formation->title }}</p>
                </div>
            </div>
            
            {{-- Statistiques --}}
            <div class="flex items-center gap-2 sm:gap-6 bg-white rounded-xl px-4 py-3 shadow-sm border border-slate-200 w-full sm:w-auto overflow-x-auto">
                <div class="text-center min-w-[60px]">
                    <div class="text-xl sm:text-2xl font-bold text-slate-900">{{ $inscriptions->count() }}</div>
                    <div class="text-xs text-slate-500">Total</div>
                </div>
                <div class="h-8 w-px bg-slate-200"></div>
                <div class="text-center min-w-[60px]">
                    <div class="text-xl sm:text-2xl font-bold text-yellow-600">{{ $inscriptions->where('statut_inscription', 'en_attente')->count() }}</div>
                    <div class="text-xs text-slate-500">En attente</div>
                </div>
                <div class="h-8 w-px bg-slate-200"></div>
                <div class="text-center min-w-[60px]">
                    <div class="text-xl sm:text-2xl font-bold text-green-600">{{ $inscriptions->where('statut_inscription', 'valide')->count() }}</div>
                    <div class="text-xs text-slate-500">Validées</div>
                </div>
                <div class="h-8 w-px bg-slate-200"></div>
                <div class="text-center min-w-[60px]">
                    <div class="text-xl sm:text-2xl font-bold text-red-600">{{ $inscriptions->where('statut_inscription', 'rejete')->count() }}</div>
                    <div class="text-xs text-slate-500">Rejetées</div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="rounded-[16px] border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 mb-6">
                <span>{{ session('success') }}</span>
                @if(session('whatsapp_url'))
                    <a href="{{ session('whatsapp_url') }}" target="_blank" class="inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        Envoyer WhatsApp
                    </a>
                @endif
            </div>
        @endif

        {{-- Liste des inscriptions - Desktop Table --}}
        <div class="hidden lg:block bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Candidat</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Paiement</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($inscriptions as $inscription)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-semibold">
                                            {{ strtoupper(substr($inscription->nom_complet, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-slate-900">{{ $inscription->nom_complet }}</div>
                                            <div class="text-xs text-slate-500">ID: {{ $inscription->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm">
                                        <div class="font-medium text-slate-900">{{ $inscription->telephone }}</div>
                                        <div class="text-xs text-slate-500">{{ $inscription->email ?? 'Non renseigné' }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $inscription->statut_paiement === 'confirme' ? 'bg-green-100 text-green-700' : 
                                           ($inscription->statut_paiement === 'annule' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                        {{ ucfirst($inscription->statut_paiement) }}
                                    </span>
                                    @if($inscription->mode_paiement)
                                        <div class="text-xs text-slate-500 mt-1">{{ ucfirst($inscription->mode_paiement) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($inscription->statut_inscription === 'en_attente')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                            En attente
                                        </span>
                                    @elseif($inscription->statut_inscription === 'valide')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                            Validé
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                            Rejeté
                                        </span>
                                    @endif
                                    @if($inscription->motif_rejet)
                                        <div class="text-xs text-slate-500 mt-1 truncate max-w-[200px]" title="{{ $inscription->motif_rejet }}">
                                            {{ $inscription->motif_rejet }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500">
                                    {{ $inscription->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if($inscription->statut_inscription === 'en_attente')
                                        <div class="flex items-center justify-end gap-2">
                                            <button type="button" 
                                                onclick="openRejectModal({{ $inscription->id }})"
                                                class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg border border-red-200 text-red-700 text-sm font-medium hover:bg-red-50 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Rejeter
                                            </button>
                                            <form action="{{ route('admin.inscriptions.accept', $inscription->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-green-600 text-white text-sm font-medium hover:bg-green-700 transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Valider
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($inscription->statut_inscription === 'valide')
                                        <div class="flex items-center justify-end gap-2">
                                            <button type="button" 
                                                onclick="openWhatsApp('{{ $inscription->telephone }}', 'confirmation')"
                                                class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg border border-green-200 text-green-700 text-sm font-medium hover:bg-green-50 transition">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.M157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                                </svg>
                                                WhatsApp
                                            </button>
                                        </div>
                                    @else
                                        <div class="flex items-center justify-end gap-2">
                                            <button type="button" 
                                                onclick="openWhatsApp('{{ $inscription->telephone }}', 'rejet')"
                                                class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg border border-green-200 text-green-700 text-sm font-medium hover:bg-green-50 transition">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.M157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                                </svg>
                                                WhatsApp
                                            </button>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                    <div class="flex flex-col items-center justify-center gap-4">
                                        <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2a1 1 0 01-1-1V5a1 1 0 011-1h11a1 1 0 011 1v1a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1V6a1 1 0 011-1h1m0 0V5a2 2 0 012 2h6a2 2 0 012 2v2M7 7h10m0 0l-3 3m0 0l-3-3m3 3V4m3 0H7"></path>
                                        </svg>
                                        <p class="text-lg font-medium">Aucune inscription pour le moment</p>
                                        <p class="text-sm">Les inscriptions apparaîtront ici</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Liste des inscriptions - Mobile Cards --}}
        <div class="lg:hidden space-y-4">
            @forelse($inscriptions as $inscription)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4">
                    <div class="flex items-start gap-3 mb-4">
                        <div class="h-12 w-12 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-semibold flex-shrink-0">
                            {{ strtoupper(substr($inscription->nom_complet, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-semibold text-slate-900">{{ $inscription->nom_complet }}</div>
                            <div class="text-xs text-slate-500">ID: {{ $inscription->id }}</div>
                            <div class="text-sm text-slate-700 mt-1">{{ $inscription->telephone }}</div>
                            @if($inscription->email)
                                <div class="text-xs text-slate-500">{{ $inscription->email }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-2 mb-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $inscription->statut_paiement === 'confirme' ? 'bg-green-100 text-green-700' : 
                               ($inscription->statut_paiement === 'annule' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                            {{ ucfirst($inscription->statut_paiement) }}
                        </span>
                        @if($inscription->mode_paiement)
                            <span class="text-xs text-slate-500">{{ ucfirst($inscription->mode_paiement) }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        @if($inscription->statut_inscription === 'en_attente')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                En attente
                            </span>
                        @elseif($inscription->statut_inscription === 'valide')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                Validé
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                Rejeté
                            </span>
                        @endif
                        @if($inscription->motif_rejet)
                            <div class="text-xs text-slate-500 mt-1">{{ $inscription->motif_rejet }}</div>
                        @endif
                    </div>

                    <div class="text-xs text-slate-500 mb-4">
                        {{ $inscription->created_at->format('d/m/Y H:i') }}
                    </div>

                    {{-- Actions - Scrollable on mobile --}}
                    <div class="border-t border-slate-200 pt-3">
                        @if($inscription->statut_inscription === 'en_attente')
                            <div class="flex gap-2 overflow-x-auto pb-2">
                                <button type="button" 
                                    onclick="openRejectModal({{ $inscription->id }})"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg border border-red-200 text-red-700 text-sm font-medium hover:bg-red-50 transition flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Rejeter
                                </button>
                                <form action="{{ route('admin.inscriptions.accept', $inscription->id) }}" method="POST" class="flex-shrink-0">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-green-600 text-white text-sm font-medium hover:bg-green-700 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Valider
                                    </button>
                                </form>
                            </div>
                        @elseif($inscription->statut_inscription === 'valide')
                            <div class="flex gap-2 overflow-x-auto pb-2">
                                <button type="button" 
                                    onclick="openWhatsApp('{{ $inscription->telephone }}', 'confirmation')"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg border border-green-200 text-green-700 text-sm font-medium hover:bg-green-50 transition flex-shrink-0">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.M157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                    WhatsApp
                                </button>
                            </div>
                        @else
                            <div class="flex gap-2 overflow-x-auto pb-2">
                                <button type="button" 
                                    onclick="openWhatsApp('{{ $inscription->telephone }}', 'rejet')"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg border border-green-200 text-green-700 text-sm font-medium hover:bg-green-50 transition flex-shrink-0">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.M157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                    WhatsApp
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 text-center">
                    <div class="flex flex-col items-center justify-center gap-4">
                        <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2a1 1 0 01-1-1V5a1 1 0 011-1h11a1 1 0 011 1v1a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1V6a1 1 0 011-1h1m0 0V5a2 2 0 012 2h6a2 2 0 012 2v2M7 7h10m0 0l-3 3m0 0l-3-3m3 3V4m3 0H7"></path>
                        </svg>
                        <p class="text-lg font-medium">Aucune inscription pour le moment</p>
                        <p class="text-sm">Les inscriptions apparaîtront ici</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Modal de rejet --}}
    <div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full mx-4">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Rejeter l'inscription</h3>
                <form id="rejectForm" action="" method="POST">
                    @csrf
                    <input type="hidden" name="inscription_id" id="rejectInscriptionId">
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Motif du rejet</label>
                        <textarea name="motif_rejet" rows="4" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Expliquez pourquoi vous rejetez cette inscription..." required></textarea>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeRejectModal()" class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 text-sm font-medium hover:bg-slate-50 transition">
                            Annuler
                        </button>
                        <button type="submit" class="px-4 py-2 rounded-lg bg-red-600 text-white text-sm font-medium hover:bg-red-700 transition">
                            Rejeter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openRejectModal(inscriptionId) {
            document.getElementById('rejectInscriptionId').value = inscriptionId;
            document.getElementById('rejectForm').action = '/admin/inscriptions/' + inscriptionId + '/reject';
            document.getElementById('rejectModal').classList.remove('hidden');
            document.getElementById('rejectModal').classList.add('flex');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            document.getElementById('rejectModal').classList.remove('flex');
        }

        function openWhatsApp(phone, type) {
            let message = '';
            if (type === 'confirmation') {
                message = "Bonjour ! Votre inscription a été validée avec succès. Merci pour votre confiance !";
            } else {
                message = "Bonjour ! Nous avons le regret de vous informer que votre inscription n'a pas été retenue.";
            }
            
            const whatsappUrl = `https://wa.me/${phone.replace(/\D/g, '')}?text=${encodeURIComponent(message)}`;
            window.open(whatsappUrl, '_blank');
        }

        // Close modal when clicking outside
        document.getElementById('rejectModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRejectModal();
            }
        });
    </script>
</div>
@endsection