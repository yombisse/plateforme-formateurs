{{-- =====================================================
     MODÈLE STARTUP AMÉLIORÉ — Design dynamique et moderne
     Utilisation directe des variables Blade pour compatibilité SVG
     ===================================================== --}}
<g transform="translate(0,0)">
    {{-- Formes dynamiques --}}
    <circle cx="580" cy="140" r="160" fill="rgba(255,255,255,0.1)" />
    <path d="M0,0 L600,0 L600,200 L0,320 Z" fill="rgba(255,255,255,0.08)" />
    <circle cx="20" cy="880" r="180" fill="rgba(255,255,255,0.06)" />
    <path d="M600,600 Q400,700 600,800" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="3" />

    {{-- Badge --}}
    <g transform="translate(50,70)">
        <rect x="0" y="0" width="220" height="44" rx="22" fill="rgba(255,255,255,0.2)" stroke="rgba(255,255,255,0.3)" stroke-width="1.5" />
        <text x="110" y="28" text-anchor="middle" font-size="16" fill="#fff" font-weight="800" font-family="'Inter',sans-serif">
            {{ $formation->status === 'Actif' ? '🚀 Nouvelle session' : '✨ Inscription ouverte' }}
        </text>
    </g>

    {{-- Logo --}}
    @if($formation->image)
    <g transform="translate(470,55)">
        <defs>
            <filter id="startupLogoShadow" x="-20%" y="-20%" width="140%" height="140%">
                <feDropShadow dx="0" dy="4" stdDeviation="8" flood-color="rgba(0,0,0,0.3)"/>
            </filter>
        </defs>
        <clipPath id="st-logo-clip">
            <rect x="0" y="0" width="80" height="80" rx="20" />
        </clipPath>
        <image x="0" y="0" width="80" height="80" preserveAspectRatio="xMidYMid slice" href="{{ $formation->image }}" clip-path="url(#st-logo-clip)" filter="url(#startupLogoShadow)" />
    </g>
    @endif

    {{-- Catégorie --}}
    @if($formation->category)
    <g transform="translate(50,135)">
        <text x="0" y="0" font-size="12" fill="rgba(255,255,255,0.7)" font-weight="700" font-family="'Inter',sans-serif" letter-spacing="2">
            {{ strtoupper($formation->category) }}
        </text>
    </g>
    @endif

    {{-- Titre --}}
    <text x="50" y="250" font-size="52" fill="#fff" font-weight="900" font-family="'Inter',sans-serif">
        {{ \Illuminate\Support\Str::limit($formation->title ?? 'Formation', 26) }}
    </text>

    {{-- Sous-titre --}}
    <text x="50" y="310" font-size="18" fill="rgba(255,255,255,0.95)" font-family="'Inter',sans-serif" font-weight="500">
        {{ \Illuminate\Support\Str::limit($formation->short_description ?? $formation->full_description ?? '', 80) }}
    </text>

    {{-- Carte prix --}}
    <g transform="translate(50,360)">
        <defs>
            <filter id="startupPriceShadow" x="-10%" y="-10%" width="120%" height="120%">
                <feDropShadow dx="0" dy="8" stdDeviation="16" flood-color="rgba(0,0,0,0.15)"/>
            </filter>
        </defs>
        <rect x="-4" y="-4" width="518" height="120" rx="20" fill="#fff" filter="url(#startupPriceShadow)" />
        <rect x="0" y="0" width="510" height="112" rx="16" fill="#fff" />

        <g>
            <text x="30" y="40" font-size="12" fill="#64748b" font-weight="700">VOTRE INVESTISSEMENT</text>
            <text x="30" y="85" font-size="40" fill="#0f172a" font-weight="900" font-family="'Inter',sans-serif">
                {{ $formation->price ? number_format($formation->price) . ' ' . ($formation->currency ?? 'FCFA') : 'Gratuit' }}
            </text>
        </g>

        <g transform="translate(280,0)">
            <text x="30" y="40" font-size="12" fill="#64748b" font-weight="700">PLACES</text>
            @if($formation->remaining_places && $formation->remaining_places <= 10)
            <g>
                <rect x="30" y="55" width="120" height="35" rx="8" fill="#ef4444" />
                <text x="90" y="78" text-anchor="middle" font-size="13" fill="#fff" font-weight="800" font-family="'Inter',sans-serif">
                    Plus que {{ $formation->remaining_places }}
                </text>
            </g>
            @else
            <text x="30" y="75" font-size="20" fill="#0f172a" font-weight="800" font-family="'Inter',sans-serif">
                {{ $formation->remaining_places ?? 'N/A' }}
            </text>
            @endif
        </g>
    </g>

    {{-- Bénéfices --}}
    <text x="50" y="530" font-size="17" fill="#fff" font-weight="800" font-family="'Inter',sans-serif">🚀 Pourquoi participer ?</text>
    <g transform="translate(50,560)">
        @php
            $benefits = $formation->objectives ?? ['Compétences innovantes', 'Networking', 'Mentorat'];
            $benefits = array_slice($benefits, 0, 4);
        @endphp
        @foreach($benefits as $index => $benefit)
        <g transform="translate({{ ($index % 2) * 255 }}, {{ floor($index / 2) * 36 }})">
            <rect x="0" y="0" width="240" height="30" rx="8" fill="rgba(255,255,255,0.1)" />
            <circle cx="16" cy="15" r="4" fill="#4ade80" />
            <text x="28" y="20" font-size="12" fill="#fff" font-family="'Inter',sans-serif" font-weight="500">
                {{ \Illuminate\Support\Str::limit($benefit, 30) }}
            </text>
        </g>
        @endforeach
    </g>

    {{-- Infos --}}
    <g transform="translate(50,720)">
        <g>
            <rect x="0" y="0" width="170" height="65" rx="12" fill="rgba(255,255,255,0.08)" />
            <text x="15" y="20" font-size="11" fill="rgba(255,255,255,0.6)" font-weight="700">DATE</text>
            <text x="15" y="48" font-size="16" fill="#fff" font-weight="800" font-family="'Inter',sans-serif">
                {{ $formation->start_date ? \Carbon\Carbon::parse($formation->start_date)->format('d M Y') : 'À planifier' }}
            </text>
        </g>

        <g transform="translate(185,0)">
            <rect x="0" y="0" width="170" height="65" rx="12" fill="rgba(255,255,255,0.08)" />
            <text x="15" y="20" font-size="11" fill="rgba(255,255,255,0.6)" font-weight="700">DURÉE</text>
            <text x="15" y="48" font-size="16" fill="#fff" font-weight="800" font-family="'Inter',sans-serif">
                {{ $formation->start_date && $formation->end_date ? \Carbon\Carbon::parse($formation->start_date)->diffInDays(\Carbon\Carbon::parse($formation->end_date)) . ' jours' : 'N/A' }}
            </text>
        </g>

        <g transform="translate(370,0)">
            <rect x="0" y="0" width="180" height="65" rx="12" fill="rgba(255,255,255,0.08)" />
            <text x="15" y="20" font-size="11" fill="rgba(255,255,255,0.6)" font-weight="700">FORMAT</text>
            <text x="15" y="48" font-size="16" fill="#fff" font-weight="800" font-family="'Inter',sans-serif">
                {{ $formation->mode ?? 'En ligne' }}
            </text>
        </g>
    </g>

    {{-- CTA --}}
    <g transform="translate(50,810)">
        <defs>
            <filter id="startupCTAShadow" x="-20%" y="-20%" width="140%" height="140%">
                <feDropShadow dx="0" dy="4" stdDeviation="12" flood-color="rgba(0,0,0,0.3)"/>
            </filter>
        </defs>
        <rect x="0" y="0" width="360" height="60" rx="30" fill="#fff" filter="url(#startupCTAShadow)" />
        <text x="180" y="38" text-anchor="middle" font-size="18" fill="#0f172a" font-weight="900" font-family="'Inter',sans-serif">
            Rejoignez l'aventure →
        </text>

        @if($formation->remaining_places && $formation->remaining_places <= 10)
        <g>
            <rect x="375" y="0" width="140" height="60" rx="30" fill="#ef4444" filter="url(#startupCTAShadow)" />
            <text x="445" y="38" text-anchor="middle" font-size="13" fill="#fff" font-weight="800" font-family="'Inter',sans-serif">
                Plus que {{ $formation->remaining_places }}
            </text>
        </g>
        @endif
    </g>

    <text x="50" y="895" font-size="12" fill="rgba(255,255,255,0.7)" font-family="'Inter',sans-serif">
        Avec {{ $formation->trainer_name ?? 'Expert' }} • {{ $formation->delivery_link ?? 'Contact via inscription' }}
    </text>
</g>