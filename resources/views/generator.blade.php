@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 px-4 py-8 sm:px-6 lg:px-8">
    <div class="mx-auto w-full max-w-7xl">
        {{-- En-tête amélioré --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ url()->previous() }}" class="inline-flex items-center justify-center h-12 w-12 rounded-xl bg-white shadow-sm border border-slate-200 text-slate-700 hover:bg-slate-50 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Générateur d'affiche</h1>
                    <p class="text-sm text-slate-500">Créez des affiches professionnelles pour vos formations</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white border border-slate-200 text-sm">
                    <span class="w-2 h-2 rounded-full" :class="formation.status === 'Actif' ? 'bg-green-500' : 'bg-slate-400'" x-data></span>
                    <span class="font-medium text-slate-700" x-text="formation.status || 'Brouillon'">{{ $formation->status ?? 'Brouillon' }}</span>
                </span>
            </div>
        </div>

        <div x-data="{
            model: 'professional',
            selectedColor: 0,
            colors: [
                { name: 'Orange', start: '#FFB084', middle: '#F97316', end: '#C2410C', accent: '#F97316', accentLight: '#FFE4D6', secondary: '#8B5CF6' },
                { name: 'Bleu', start: '#93C5FD', middle: '#3B82F6', end: '#1E40AF', accent: '#3B82F6', accentLight: '#DBEAFE', secondary: '#F97316' },
                { name: 'Vert', start: '#6EE7B7', middle: '#10B981', end: '#065F46', accent: '#10B981', accentLight: '#D1FAE5', secondary: '#F59E0B' },
                { name: 'Violet', start: '#C4B5FD', middle: '#8B5CF6', end: '#5B21B6', accent: '#8B5CF6', accentLight: '#E9D5FF', secondary: '#10B981' },
            ],
            init() {
                // Initialize with default color
                this.$nextTick(() => {
                    this.changeColor(0);
                });
            },
            changeColor(index) {
                this.selectedColor = index;
                const color = this.colors[index];
                
                // Change gradient colors for professional model
                const gradientStart = document.getElementById('gradientStart');
                const gradientMiddle = document.getElementById('gradientMiddle');
                const gradientEnd = document.getElementById('gradientEnd');
                
                if (gradientStart) gradientStart.style.stopColor = color.start;
                if (gradientMiddle) gradientMiddle.style.stopColor = color.middle;
                if (gradientEnd) gradientEnd.style.stopColor = color.end;
                
                // Change gradient colors for gradient model
                const gradientColor1 = document.getElementById('gradientColor1');
                const gradientColor2 = document.getElementById('gradientColor2');
                
                if (gradientColor1) gradientColor1.style.stopColor = color.start;
                if (gradientColor2) gradientColor2.style.stopColor = color.secondary;
                
                // Change benefit dots color
                document.querySelectorAll('.benefit-dot').forEach(dot => {
                    dot.setAttribute('fill', color.accent);
                });
                
                // Change price background color
                document.querySelectorAll('.price-bg').forEach(bg => {
                    bg.setAttribute('fill', color.accentLight);
                });
            },
            downloadPNG() {
                const svg = document.getElementById('poster-preview');
                const svgData = new XMLSerializer().serializeToString(svg);
                const canvas = document.createElement('canvas');
                canvas.width = 1080;
                canvas.height = 1620;
                const ctx = canvas.getContext('2d');
                const img = new Image();
                img.onload = () => {
                    ctx.fillStyle = '#ffffff';
                    ctx.fillRect(0, 0, canvas.width, canvas.height);
                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                    const pngUrl = canvas.toDataURL('image/png');
                    const downloadLink = document.createElement('a');
                    downloadLink.href = pngUrl;
                    downloadLink.download = 'affiche-{{ $formation->slug ?? 'formation' }}.png';
                    document.body.appendChild(downloadLink);
                    downloadLink.click();
                    document.body.removeChild(downloadLink);
                };
                img.src = 'data:image/svg+xml;base64,' + btoa(svgData);
            },
            downloadJPG() {
                const svg = document.getElementById('poster-preview');
                const svgData = new XMLSerializer().serializeToString(svg);
                const canvas = document.createElement('canvas');
                canvas.width = 1080;
                canvas.height = 1620;
                const ctx = canvas.getContext('2d');
                const img = new Image();
                img.onload = () => {
                    ctx.fillStyle = '#ffffff';
                    ctx.fillRect(0, 0, canvas.width, canvas.height);
                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                    const jpgUrl = canvas.toDataURL('image/jpeg', 0.9);
                    const downloadLink = document.createElement('a');
                    downloadLink.href = jpgUrl;
                    downloadLink.download = 'affiche-{{ $formation->slug ?? 'formation' }}.jpg';
                    document.body.appendChild(downloadLink);
                    downloadLink.click();
                    document.body.removeChild(downloadLink);
                };
                img.src = 'data:image/svg+xml;base64,' + btoa(svgData);
            }
        }" x-init="init()" class="grid gap-8 lg:grid-cols-12 items-start">

            {{-- ============ COLONNE GAUCHE : CONTRÔLES AMÉLIORÉS ============ --}}
            <aside class="lg:col-span-4 space-y-6">

                {{-- Informations détectées - Version améliorée --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-slate-900">Informations détectées</h3>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 border border-emerald-200">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Auto
                        </span>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-slate-100">
                            <span class="text-sm text-slate-500">Titre</span>
                            <span class="font-medium text-sm text-slate-900 text-right max-w-[180px] truncate">{{ $formation->title ?? '—' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-100">
                            <span class="text-sm text-slate-500">Formateur</span>
                            <span class="font-medium text-sm text-slate-900 text-right">{{ $formation->trainer_name ?? '—' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-100">
                            <span class="text-sm text-slate-500">Catégorie</span>
                            <span class="font-medium text-sm text-slate-900 text-right">{{ $formation->category ?? '—' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-100">
                            <span class="text-sm text-slate-500">Dates</span>
                            <span class="font-medium text-sm text-slate-900 text-right">
                                @if($formation->start_date)
                                    {{ \Carbon\Carbon::parse($formation->start_date)->format('d M Y') }}
                                    @if($formation->end_date)
                                        → {{ \Carbon\Carbon::parse($formation->end_date)->format('d M Y') }}
                                    @endif
                                @else
                                    À planifier
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-100">
                            <span class="text-sm text-slate-500">Durée</span>
                            <span class="font-medium text-sm text-slate-900 text-right">
                                @if($formation->start_date && $formation->end_date)
                                    {{ \Carbon\Carbon::parse($formation->start_date)->diffInDays(\Carbon\Carbon::parse($formation->end_date)) }} jours
                                @else
                                    N/A
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-100">
                            <span class="text-sm text-slate-500">Mode</span>
                            <span class="font-medium text-sm text-slate-900 text-right">{{ $formation->mode ?? 'En ligne' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-100">
                            <span class="text-sm text-slate-500">Lieu / Lien</span>
                            <span class="font-medium text-sm text-slate-900 text-right truncate max-w-[180px]">{{ $formation->delivery_link ?? $formation->location ?? '—' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-100">
                            <span class="text-sm text-slate-500">Prix</span>
                            <span class="font-bold text-sm text-slate-900 text-right">
                                @if($formation->price)
                                    {{ number_format($formation->price) }} {{ $formation->currency ?? 'FCFA' }}
                                @else
                                    Gratuit
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-sm text-slate-500">Places restantes</span>
                            <span class="font-medium text-sm text-slate-900 text-right">
                                @if($formation->remaining_places)
                                    {{ $formation->remaining_places }} place{{ $formation->remaining_places > 1 ? 's' : '' }}
                                @else
                                    —
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="mt-4 p-3 bg-slate-50 rounded-lg">
                        <p class="text-xs text-slate-600 flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Aucune saisie nécessaire — les données proviennent de la formation sélectionnée.
                        </p>
                    </div>
                </div>

                {{-- Choix du modèle --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="font-semibold text-slate-900 mb-4">Modèle d'affiche</h3>
                    <div class="grid grid-cols-1 gap-3">
                        <button type="button" @click="model = 'professional'" 
                            :class="model === 'professional' ? 'ring-2 ring-orange-500 bg-orange-50 border-orange-200' : 'bg-slate-50 border-slate-200 hover:bg-slate-100'" 
                            class="relative rounded-xl p-4 text-left border transition-all">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-slate-900">Professionnel</div>
                                    <div class="text-xs text-slate-500">Idéal pour entreprises et B2B</div>
                                </div>
                            </div>
                            <div x-show="model === 'professional'" class="absolute top-3 right-3 w-5 h-5 rounded-full bg-orange-500 flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </button>

                        <button type="button" @click="model = 'gradient'" 
                            :class="model === 'gradient' ? 'ring-2 ring-orange-500 bg-orange-50 border-orange-200' : 'bg-slate-50 border-slate-200 hover:bg-slate-100'" 
                            class="relative rounded-xl p-4 text-left border transition-all">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-400 to-pink-600 flex items-center justify-center text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-slate-900">Dégradé</div>
                                    <div class="text-xs text-slate-500">Design moderne avec deux couleurs</div>
                                </div>
                            </div>
                            <div x-show="model === 'gradient'" class="absolute top-3 right-3 w-5 h-5 rounded-full bg-orange-500 flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </button>
                    </div>
                </div>

                {{-- Palette de couleurs - Fonctionnelle --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-slate-900">Palette de couleurs</h3>
                        <span class="text-xs text-slate-500" x-text="colors[selectedColor].name"></span>
                    </div>
                    <div class="grid grid-cols-4 gap-3 mb-4">
                        <template x-for="(color, index) in colors" :key="index">
                            <button type="button" @click="changeColor(index)" 
                                :class="selectedColor === index ? 'ring-2 ring-offset-2 ring-orange-500 scale-110' : 'hover:scale-105'" 
                                class="rounded-xl transition-transform duration-200 shadow-sm" 
                                :style="`background: linear-gradient(135deg, ${color.start}, ${color.middle}, ${color.end}); aspect-ratio: 1;`" 
                                :title="color.name">
                            </button>
                        </template>
                    </div>
                    <p class="text-xs text-slate-500 text-center">Cliquez pour changer la couleur de l'affiche</p>
                </div>

                {{-- Format d'export - Version simplifiée --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="font-semibold text-slate-900 mb-4">Format d'export</h3>
                    <div class="grid grid-cols-3 gap-3">
                        <div class="rounded-xl p-4 text-center bg-slate-50 border border-slate-200">
                            <span class="block text-2xl mb-2">📱</span>
                            <span class="block text-xs font-semibold text-slate-900">WhatsApp</span>
                            <span class="block text-xs text-slate-500">2:3</span>
                        </div>
                        <div class="rounded-xl p-4 text-center bg-slate-50 border border-slate-200 opacity-50">
                            <span class="block text-2xl mb-2">📸</span>
                            <span class="block text-xs font-semibold text-slate-900">Instagram</span>
                            <span class="block text-xs text-slate-500">1:1</span>
                        </div>
                        <div class="rounded-xl p-4 text-center bg-slate-50 border border-slate-200 opacity-50">
                            <span class="block text-2xl mb-2">🖥️</span>
                            <span class="block text-xs font-semibold text-slate-900">Facebook</span>
                            <span class="block text-xs text-slate-500">16:9</span>
                        </div>
                    </div>
                    <p class="mt-4 text-xs text-slate-500 text-center">Format actuel : WhatsApp (2:3) - autres formats bientôt disponibles</p>
                </div>

                {{-- Actions - Export PNG/JPG --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm space-y-3">
                    <button @click="downloadPNG()" class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-orange-500 to-orange-600 px-4 py-3 text-white font-semibold hover:from-orange-600 hover:to-orange-700 transition-all shadow-md shadow-orange-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Télécharger PNG
                    </button>
                    <button @click="downloadJPG()" class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-slate-800 to-slate-900 px-4 py-3 text-white font-semibold hover:from-slate-900 hover:to-black transition-all shadow-md shadow-slate-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Télécharger JPG
                    </button>
                    <a href="{{ route('admin.formation.edit', $formation->slug) }}" class="block text-center text-sm text-slate-500 hover:text-slate-700 transition mt-2">← Modifier la formation</a>
                </div>
            </aside>

            {{-- ============ COLONNE DROITE : APERÇU AMÉLIORÉ ============ --}}
            <main class="lg:col-span-8">
                <div class="sticky top-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="font-semibold text-slate-900">Aperçu en temps réel</h3>
                            <p class="text-sm text-slate-500">Modifications instantanées lors de vos changements</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white border border-slate-200 text-xs font-medium text-slate-600">
                                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                600 × 900 px
                            </span>
                        </div>
                    </div>

                    <div class="mx-auto w-full flex justify-center">
                        <div id="poster-container" class="rounded-3xl overflow-hidden shadow-2xl ring-1 ring-slate-900/5 bg-white transition-all duration-300 hover:shadow-3xl">
                            <svg id="poster-preview" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 900" preserveAspectRatio="xMidYMid meet" class="w-full max-w-[400px] h-auto block">
                                <defs>
                                    <linearGradient id="mainGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" id="gradientStart" style="stop-color:#FFB084;stop-opacity:1" />
                                        <stop offset="50%" id="gradientMiddle" style="stop-color:#F97316;stop-opacity:1" />
                                        <stop offset="100%" id="gradientEnd" style="stop-color:#C2410C;stop-opacity:1" />
                                    </linearGradient>
                                </defs>

                                {{-- Fond dégradé --}}
                                <rect id="posterBackground" x="0" y="0" width="600" height="900" fill="url(#mainGradient)" />

                                {{-- MODÈLE PROFESSIONNEL --}}
                                @include('generator.models.professional', compact('formation'))

                                {{-- MODÈLE DÉGRADÉ --}}
                                @include('generator.models.gradient', compact('formation'))
                            </svg>
                        </div>
                    </div>

                    {{-- Validation --}}
                    <div class="mt-6 space-y-3">
                        @if(!$formation->title || !$formation->price || !$formation->start_date)
                        <div class="rounded-xl bg-amber-50 border border-amber-200 p-4">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-6 h-6 rounded-full bg-amber-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-amber-900">Informations manquantes</h4>
                                    <p class="text-sm text-amber-700 mt-1">Complétez les informations de la formation pour un meilleur résultat.</p>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="rounded-xl bg-emerald-50 border border-emerald-200 p-4">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-emerald-900">Excellent !</h4>
                                    <p class="text-sm text-emerald-700">Votre affiche est prête à être visualisée.</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>

</div>
@endsection