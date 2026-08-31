{{-- =====================================================
     MODÈLE DÉGRADÉ — Design moderne avec deux couleurs
     ===================================================== --}}
<g x-show="model === 'gradient'" transform="translate(0,0)">
    {{-- Fond dégradé bicolore --}}
    <defs>
        <linearGradient id="gradientBg" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" id="gradientColor1" style="stop-color:#F97316;stop-opacity:1" />
            <stop offset="100%" id="gradientColor2" style="stop-color:#8B5CF6;stop-opacity:1" />
        </linearGradient>
    </defs>
    <rect x="0" y="0" width="600" height="900" fill="url(#gradientBg)" />

    {{-- Formes décoratives --}}
    <circle cx="550" cy="100" r="150" fill="rgba(255,255,255,0.1)" />
    <circle cx="50" cy="800" r="120" fill="rgba(255,255,255,0.08)" />

    {{-- Bandeau principal --}}
    <rect x="30" y="30" width="540" height="840" rx="24" fill="rgba(255,255,255,0.08)" stroke="rgba(255,255,255,0.15)" stroke-width="2" />

    {{-- Badge --}}
    <g transform="translate(60,70)">
        <rect x="0" y="0" width="220" height="36" rx="18" fill="rgba(255,255,255,0.2)" stroke="rgba(255,255,255,0.3)" stroke-width="1" />
        <circle cx="20" cy="18" r="5" fill="#4ade80" />
        <text x="32" y="23" font-size="13" fill="#fff" font-weight="800" font-family="'Inter',sans-serif">
            {{ $formation->status === 'Actif' ? '🚀 Nouvelle session' : '✨ Inscription ouverte' }}
        </text>
    </g>

    {{-- Catégorie --}}
    @if($formation->category)
    <g transform="translate(60,125)">
        <text x="0" y="0" font-size="11" fill="rgba(255,255,255,0.7)" font-weight="600" font-family="'Inter',sans-serif" letter-spacing="1">
            {{ strtoupper($formation->category) }}
        </text>
    </g>
    @endif

    {{-- Titre --}}
    <text x="60" y="240" font-size="46" fill="#fff" font-weight="900" font-family="'Inter',sans-serif">
        {{ \Illuminate\Support\Str::limit($formation->title ?? 'Formation', 28) }}
    </text>

    {{-- Sous-titre --}}
    <text x="60" y="290" font-size="17" fill="rgba(255,255,255,0.9)" font-family="'Inter',sans-serif" font-weight="500">
        {{ \Illuminate\Support\Str::limit($formation->short_description ?? $formation->full_description ?? '', 75) }}
    </text>

    <line x1="60" y1="320" x2="540" y2="320" stroke="rgba(255,255,255,0.25)" stroke-width="2" stroke-linecap="round" />

    {{-- Carte informations --}}
    <g transform="translate(60,350)">
        <defs>
            <filter id="cardShadowGradient" x="-10%" y="-10%" width="120%" height="120%">
                <feDropShadow dx="0" dy="8" stdDeviation="16" flood-color="rgba(0,0,0,0.15)"/>
            </filter>
        </defs>
        <rect x="-4" y="-4" width="448" height="180" rx="20" fill="#fff" filter="url(#cardShadowGradient)" />
        <rect x="0" y="0" width="440" height="172" rx="16" fill="#fff" />

        {{-- Informations en grille --}}
        <g>
            <text x="20" y="30" font-size="10" fill="#64748b" font-weight="700">TARIF</text>
            <text x="20" y="55" font-size="20" fill="#0f172a" font-weight="900" font-family="'Inter',sans-serif">
                {{ $formation->price ? number_format($formation->price) . ' ' . ($formation->currency ?? 'FCFA') : 'Gratuit' }}
            </text>
        </g>

        <g transform="translate(140,0)">
            <text x="20" y="30" font-size="10" fill="#64748b" font-weight="700">DURÉE</text>
            <text x="20" y="55" font-size="16" fill="#0f172a" font-weight="800" font-family="'Inter',sans-serif">
                {{ $formation->start_date && $formation->end_date ? \Carbon\Carbon::parse($formation->start_date)->diffInDays(\Carbon\Carbon::parse($formation->end_date)) . ' jours' : 'N/A' }}
            </text>
        </g>

        <g transform="translate(280,0)">
            <text x="20" y="30" font-size="10" fill="#64748b" font-weight="700">FORMAT</text>
            <text x="20" y="55" font-size="16" fill="#0f172a" font-weight="800" font-family="'Inter',sans-serif">
                {{ $formation->mode ?? 'En ligne' }}
            </text>
        </g>

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

        <g transform="translate(20,130)">
            <circle cx="10" cy="10" r="8" fill="#8b5cf6" />
            <text x="10" y="14" text-anchor="middle" font-size="10" fill="#fff" font-weight="700">👥</text>
            <text x="28" y="15" font-size="14" fill="#334155" font-weight="700" font-family="'Inter',sans-serif">
                {{ $formation->remaining_places ?? 'N/A' }} places
            </text>
        </g>

        <g transform="translate(220,130)">
            <circle cx="10" cy="10" r="8" fill="#f59e0b" />
            <text x="10" y="14" text-anchor="middle" font-size="10" fill="#fff" font-weight="700">📍</text>
            <text x="28" y="15" font-size="14" fill="#334155" font-weight="700" font-family="'Inter',sans-serif">
                {{ $formation->mode ?? 'En ligne' }}
            </text>
        </g>
    </g>

    {{-- Bénéfices --}}
    <text x="60" y="580" font-size="16" fill="#fff" font-weight="800" font-family="'Inter',sans-serif">🎯 Ce que vous allez maîtriser</text>
    <g transform="translate(60,610)">
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
    <g transform="translate(60,780)">
        <defs>
            <filter id="ctaShadowGradient" x="-20%" y="-20%" width="140%" height="140%">
                <feDropShadow dx="0" dy="4" stdDeviation="12" flood-color="rgba(0,0,0,0.3)"/>
            </filter>
        </defs>
        <rect x="0" y="0" width="360" height="60" rx="30" fill="#fff" filter="url(#ctaShadowGradient)" />
        <text x="180" y="38" text-anchor="middle" font-size="18" fill="#0f172a" font-weight="900" font-family="'Inter',sans-serif">
            Inscrivez-vous maintenant →
        </text>

        @if($formation->remaining_places && $formation->remaining_places <= 10)
        <g>
            <rect x="375" y="0" width="120" height="60" rx="30" fill="#ef4444" filter="url(#ctaShadowGradient)" />
            <text x="435" y="38" text-anchor="middle" font-size="13" fill="#fff" font-weight="800" font-family="'Inter',sans-serif">
                Plus que {{ $formation->remaining_places }}
            </text>
        </g>
        @endif
    </g>

    {{-- Pied de page --}}
    <text x="60" y="870" font-size="12" fill="rgba(255,255,255,0.7)" font-family="'Inter',sans-serif">
        Avec {{ $formation->trainer_name ?? 'Formateur' }} • {{ $formation->delivery_link ?? 'Contact via inscription' }}
    </text>
</g>