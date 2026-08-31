{{-- =====================================================
     MODÈLE PROFESSIONNEL AMÉLIORÉ — Affiche orientée conversion
     Utilisation directe des variables Blade pour compatibilité SVG
     ===================================================== --}}
<g transform="translate(0,0)">
    {{-- Arrière-plan décoratif amélioré --}}
    <circle cx="600" cy="60" r="200" fill="rgba(255,255,255,0.08)" />
    <circle cx="-50" cy="850" r="250" fill="rgba(255,255,255,0.06)" />
    <circle cx="580" cy="880" r="150" fill="rgba(255,255,255,0.05)" />
    <path d="M0,200 Q300,250 600,200" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="2" />

    {{-- Bandeau principal avec ombre --}}
    <rect x="30" y="30" width="540" height="840" rx="28" fill="rgba(255,255,255,0.08)" stroke="rgba(255,255,255,0.18)" stroke-width="2" />
    
    {{-- Conteneur principal --}}
    <rect x="40" y="40" width="520" height="820" rx="24" fill="rgba(255,255,255,0.05)" />

    {{-- Pas de logo/bannière selon demande utilisateur --}}

    {{-- Badge statut --}}
    <g transform="translate(60,70)">
        <rect x="0" y="0" width="240" height="38" rx="19" fill="rgba(255,255,255,0.2)" stroke="rgba(255,255,255,0.3)" stroke-width="1" />
        <circle cx="20" cy="19" r="6" fill="#4ade80" />
        <text x="36" y="25" font-size="14" fill="#fff" font-weight="800" font-family="'Inter',sans-serif">
            {{ $formation->status === 'Actif' ? '🚀 Nouvelle session' : '✨ Inscription ouverte' }}
        </text>
    </g>

    {{-- Catégorie --}}
    @if($formation->category)
    <g transform="translate(60,125)">
        <text x="0" y="0" font-size="12" fill="rgba(255,255,255,0.7)" font-weight="600" font-family="'Inter',sans-serif" letter-spacing="1">
            {{ strtoupper($formation->category) }}
        </text>
    </g>
    @endif

    {{-- Titre --}}
    <text x="60" y="250" font-size="42" fill="#fff" font-weight="900" font-family="'Inter',sans-serif">
        {{ \Illuminate\Support\Str::limit($formation->title ?? 'Formation', 28) }}
    </text>

    {{-- Sous-titre --}}
    <text x="60" y="290" font-size="16" fill="rgba(255,255,255,0.9)" font-family="'Inter',sans-serif">
        {{ \Illuminate\Support\Str::limit($formation->short_description ?? $formation->full_description ?? '', 70) }}
    </text>

    <line x1="60" y1="320" x2="540" y2="320" stroke="rgba(255,255,255,0.25)" stroke-width="2" stroke-linecap="round" />

    {{-- Carte informations clés --}}
    <g transform="translate(60,350)">
        <defs>
            <filter id="cardShadow" x="-10%" y="-10%" width="120%" height="120%">
                <feDropShadow dx="0" dy="8" stdDeviation="16" flood-color="rgba(0,0,0,0.15)"/>
            </filter>
        </defs>
        <rect x="-4" y="-4" width="448" height="170" rx="20" fill="#fff" filter="url(#cardShadow)" />
        <rect x="0" y="0" width="440" height="162" rx="16" fill="#fff" />

        {{-- PRIX --}}
        <rect class="price-bg" x="15" y="15" width="125" height="40" rx="8" fill="#FFE4D6" />
        <text x="25" y="32" font-size="10" fill="#64748b" font-weight="700">TARIF</text>
        <text x="25" y="50" font-size="18" fill="#0f172a" font-weight="900" font-family="'Inter',sans-serif">
            {{ $formation->price ? number_format($formation->price) . ' ' . ($formation->currency ?? 'FCFA') : 'Gratuit' }}
        </text>

        {{-- DURÉE --}}
        <text x="160" y="30" font-size="11" fill="#64748b" font-weight="700">DURÉE</text>
        <text x="160" y="55" font-size="18" fill="#0f172a" font-weight="800" font-family="'Inter',sans-serif">
            {{ $formation->start_date && $formation->end_date ? \Carbon\Carbon::parse($formation->start_date)->diffInDays(\Carbon\Carbon::parse($formation->end_date)) . ' jours' : 'N/A' }}
        </text>

        {{-- MODE --}}
        <text x="300" y="30" font-size="11" fill="#64748b" font-weight="700">FORMAT</text>
        <text x="300" y="55" font-size="18" fill="#0f172a" font-weight="800" font-family="'Inter',sans-serif">
            {{ $formation->mode ?? 'En ligne' }}
        </text>

        {{-- Séparateur --}}
        <line x1="20" y1="75" x2="420" y2="75" stroke="#f1f5f9" stroke-width="2" stroke-linecap="round" />

        {{-- Dates --}}
        <g transform="translate(20,95)">
            <circle cx="10" cy="10" r="8" fill="#3b82f6" />
            <text x="10" y="14" text-anchor="middle" font-size="10" fill="#fff" font-weight="700">📅</text>
            <text x="28" y="15" font-size="14" fill="#334155" font-weight="700" font-family="'Inter',sans-serif">
                {{ $formation->start_date ? \Carbon\Carbon::parse($formation->start_date)->format('d M Y') : 'À planifier' }}
            </text>
        </g>
        
        <g transform="translate(220,95)">
            <circle cx="10" cy="10" r="8" fill="#10b981" />
            <text x="10" y="14" text-anchor="middle" font-size="10" fill="#fff" font-weight="700">🏁</text>
            <text x="28" y="15" font-size="14" fill="#334155" font-weight="700" font-family="'Inter',sans-serif">
                {{ $formation->end_date ? \Carbon\Carbon::parse($formation->end_date)->format('d M Y') : '' }}
            </text>
        </g>

        {{-- PLACES --}}
        <g transform="translate(20,130)">
            <circle cx="10" cy="10" r="8" fill="#8b5cf6" />
            <text x="10" y="14" text-anchor="middle" font-size="10" fill="#fff" font-weight="700">👥</text>
            <text x="28" y="15" font-size="14" fill="#334155" font-weight="700" font-family="'Inter',sans-serif">
                {{ $formation->remaining_places ?? 'N/A' }} places
            </text>
        </g>
    </g>

    {{-- Bénéfices --}}
    <text x="60" y="560" font-size="16" fill="#fff" font-weight="800" font-family="'Inter',sans-serif">🎯 Ce que vous allez maîtriser</text>
    <g transform="translate(60,590)">
        @php
            $benefits = $formation->objectives ?? ['Compétences pratiques', 'Projets concrets', 'Certification'];
            $benefits = array_slice($benefits, 0, 4);
        @endphp
        @foreach($benefits as $index => $benefit)
        <g transform="translate(0,{{ $index * 35 }})">
            <rect class="benefit-dot" x="0" y="0" width="6" height="6" rx="3" fill="#F97316" />
            <text x="20" y="17" font-size="14" fill="#fff" font-family="'Inter',sans-serif" font-weight="500">
                {{ \Illuminate\Support\Str::limit($benefit, 35) }}
            </text>
        </g>
        @endforeach
    </g>

    {{-- CTA --}}
    <g transform="translate(60,770)">
        <defs>
            <filter id="ctaShadow" x="-20%" y="-20%" width="140%" height="140%">
                <feDropShadow dx="0" dy="4" stdDeviation="12" flood-color="rgba(0,0,0,0.3)"/>
            </filter>
        </defs>
        <rect x="0" y="0" width="360" height="60" rx="30" fill="#fff" filter="url(#ctaShadow)" />
        <text x="180" y="38" text-anchor="middle" font-size="18" fill="#0f172a" font-weight="900" font-family="'Inter',sans-serif">
            Inscrivez-vous maintenant →
        </text>

        @if($formation->remaining_places && $formation->remaining_places <= 10)
        <g>
            <rect x="375" y="0" width="120" height="60" rx="30" fill="#ef4444" filter="url(#ctaShadow)" />
            <text x="435" y="38" text-anchor="middle" font-size="13" fill="#fff" font-weight="800" font-family="'Inter',sans-serif">
                Plus que {{ $formation->remaining_places }} places
            </text>
        </g>
        @endif
    </g>

    {{-- Pied de page --}}
    <text x="60" y="860" font-size="12" fill="rgba(255,255,255,0.7)" font-family="'Inter',sans-serif">
        Avec {{ $formation->trainer_name ?? 'Formateur' }} • {{ $formation->delivery_link ?? 'Contact via inscription' }}
    </text>
</g>