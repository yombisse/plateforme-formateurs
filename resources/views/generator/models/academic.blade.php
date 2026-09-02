{{-- =====================================================
     MODÈLE ACADÉMIQUE AMÉLIORÉ — Style université / formation diplômante
     Utilisation directe des variables Blade pour compatibilité SVG
     ===================================================== --}}
<g transform="translate(0,0)">
    {{-- Bandeau héraldique supérieur --}}
    <rect x="0" y="0" width="600" height="240" fill="rgba(255,255,255,0.1)" />
    <rect x="0" y="240" width="600" height="4" fill="rgba(255,255,255,0.3)" />
    
    {{-- Formes décoratives --}}
    <path d="M0,0 L100,0 L0,100 Z" fill="rgba(255,255,255,0.05)" />
    <path d="M600,0 L500,0 L600,100 Z" fill="rgba(255,255,255,0.05)" />

    {{-- Blason / sceau --}}
    <g transform="translate(60,60)">
        <circle cx="40" cy="40" r="36" fill="none" stroke="rgba(255,255,255,0.7)" stroke-width="3" />
        <circle cx="40" cy="40" r="28" fill="none" stroke="rgba(255,255,255,0.5)" stroke-width="2" />
        <circle cx="40" cy="40" r="20" fill="rgba(255,255,255,0.1)" />
        <text x="40" y="50" text-anchor="middle" font-size="24" fill="#fff" font-weight="900" font-family="'Inter',sans-serif">U</text>
    </g>

    {{-- Logo --}}
    @if($formation->image_url)
    <g transform="translate(460,50)">
        <defs>
            <filter id="academicLogoShadow" x="-20%" y="-20%" width="140%" height="140%">
                <feDropShadow dx="0" dy="4" stdDeviation="8" flood-color="rgba(0,0,0,0.3)"/>
            </filter>
        </defs>
        <clipPath id="ac-logo-clip">
            <rect x="0" y="0" width="80" height="80" rx="40" />
        </clipPath>
        <image x="0" y="0" width="80" height="80" preserveAspectRatio="xMidYMid slice" href="{{ $formation->image_url }}" clip-path="url(#ac-logo-clip)" filter="url(#academicLogoShadow)" />
    </g>
    @endif

    {{-- En-tête --}}
    @if($formation->category)
    <g transform="translate(60,150)">
        <text x="0" y="0" font-size="11" fill="rgba(255,255,255,0.6)" font-weight="700" font-family="'Inter',sans-serif" letter-spacing="3">
            {{ strtoupper($formation->category) }}
        </text>
    </g>
    @endif
    
    <text x="60" y="185" font-size="13" fill="rgba(255,255,255,0.8)" font-weight="700" font-family="'Inter',sans-serif" letter-spacing="2">
        PROGRAMME DE FORMATION CERTIFIANT
    </text>
    
    <text x="60" y="230" font-size="40" fill="#fff" font-weight="900" font-family="'Inter',sans-serif">
        {{ \Illuminate\Support\Str::limit($formation->title ?? 'Formation', 30) }}
    </text>

    {{-- Description --}}
    <text x="60" y="280" font-size="15" fill="rgba(255,255,255,0.85)" font-family="'Inter',sans-serif">
        {{ \Illuminate\Support\Str::limit($formation->full_description ?? $formation->short_description ?? '', 150) }}
    </text>

    {{-- Carte programme --}}
    <g transform="translate(60,330)">
        <defs>
            <filter id="academicCardShadow" x="-10%" y="-10%" width="120%" height="120%">
                <feDropShadow dx="0" dy="8" stdDeviation="16" flood-color="rgba(0,0,0,0.15)"/>
            </filter>
        </defs>
        <rect x="-4" y="-4" width="498" height="230" rx="12" fill="#f8fafc" filter="url(#academicCardShadow)" />
        <rect x="0" y="0" width="490" height="222" rx="8" fill="#f8fafc" />
        <rect x="0" y="0" width="12" height="222" fill="#b45309" rx="4" />

        <text x="35" y="45" font-size="16" fill="#78350f" font-weight="900" font-family="'Inter',sans-serif">📚 PROGRAMME & COMPÉTENCES</text>
        <line x1="35" y1="60" x2="455" y2="60" stroke="#e7e5e4" stroke-width="2" stroke-linecap="round" />

        @php
            $benefits = $formation->objectives ?? ['Compétences fondamentales', 'Projets pratiques', 'Certification'];
            $benefits = array_slice($benefits, 0, 5);
        @endphp
        @foreach($benefits as $index => $benefit)
        <g transform="translate(35, {{ 85 + $index * 28 }})">
            <circle cx="8" cy="12" r="4" fill="#b45309" />
            <text x="24" y="17" font-size="14" fill="#1e293b" font-family="'Inter',sans-serif" font-weight="500">
                {{ \Illuminate\Support\Str::limit($benefit, 40) }}
            </text>
        </g>
        @endforeach
    </g>

    {{-- Informations clés --}}
    <g transform="translate(60,600)">
        <g>
            <rect x="0" y="0" width="140" height="70" rx="8" fill="rgba(255,255,255,0.08)" />
            <text x="15" y="25" font-size="11" fill="rgba(255,255,255,0.6)" font-weight="700">DÉBUT</text>
            <text x="15" y="50" font-size="16" fill="#fff" font-weight="800" font-family="'Inter',sans-serif">
                {{ $formation->start_date ? \Carbon\Carbon::parse($formation->start_date)->format('d M Y') : 'À planifier' }}
            </text>
        </g>

        <g transform="translate(155,0)">
            <rect x="0" y="0" width="140" height="70" rx="8" fill="rgba(255,255,255,0.08)" />
            <text x="15" y="25" font-size="11" fill="rgba(255,255,255,0.6)" font-weight="700">DURÉE</text>
            <text x="15" y="50" font-size="16" fill="#fff" font-weight="800" font-family="'Inter',sans-serif">
                {{ $formation->start_date && $formation->end_date ? \Carbon\Carbon::parse($formation->start_date)->diffInDays(\Carbon\Carbon::parse($formation->end_date)) . ' jours' : 'N/A' }}
            </text>
        </g>

        <g transform="translate(310,0)">
            <rect x="0" y="0" width="140" height="70" rx="8" fill="rgba(255,255,255,0.08)" />
            <text x="15" y="25" font-size="11" fill="rgba(255,255,255,0.6)" font-weight="700">FORMAT</text>
            <text x="15" y="50" font-size="16" fill="#fff" font-weight="800" font-family="'Inter',sans-serif">
                {{ $formation->mode ?? 'En ligne' }}
            </text>
        </g>

        <g transform="translate(0,85)">
            <rect x="0" y="0" width="220" height="70" rx="8" fill="rgba(255,255,255,0.08)" />
            <text x="15" y="25" font-size="11" fill="rgba(255,255,255,0.6)" font-weight="700">FORMATEUR</text>
            <text x="15" y="50" font-size="15" fill="#fff" font-weight="800" font-family="'Inter',sans-serif">
                {{ \Illuminate\Support\Str::limit($formation->trainer_name ?? 'Formateur', 25) }}
            </text>
        </g>

        <g transform="translate(235,85)">
            <rect x="0" y="0" width="215" height="70" rx="8" fill="rgba(255,255,255,0.08)" />
            <text x="15" y="25" font-size="11" fill="rgba(255,255,255,0.6)" font-weight="700">TARIF</text>
            <text x="15" y="50" font-size="22" fill="#fff" font-weight="900" font-family="'Inter',sans-serif">
                {{ $formation->price ? number_format($formation->price) . ' ' . ($formation->currency ?? 'FCFA') : 'Gratuit' }}
            </text>
        </g>
    </g>

    {{-- CTA --}}
    <g transform="translate(60,780)">
        <defs>
            <filter id="academicCTAShadow" x="-20%" y="-20%" width="140%" height="140%">
                <feDropShadow dx="0" dy="4" stdDeviation="12" flood-color="rgba(0,0,0,0.3)"/>
            </filter>
        </defs>
        <rect x="0" y="0" width="480" height="60" rx="8" fill="#b45309" filter="url(#academicCTAShadow)" />
        <text x="240" y="38" text-anchor="middle" font-size="18" fill="#fff" font-weight="900" font-family="'Inter',sans-serif">
            Rejoignez la formation →
        </text>
    </g>

    <text x="60" y="865" font-size="12" fill="rgba(255,255,255,0.6)" font-family="'Inter',sans-serif">
        Formateur : {{ $formation->trainer_name ?? 'Expert' }} | {{ $formation->delivery_link ?? 'Contact via inscription' }}
    </text>
</g>
