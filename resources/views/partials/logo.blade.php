@if(!empty($siteSettings['logo']))
    <img src="{{ asset('storage/'.$siteSettings['logo']) }}" alt="{{ $siteSettings['name'] ?? 'Akar Sehat' }}" style="{{ $logoStyle ?? 'height:36px;width:auto;object-fit:contain' }}">
@else
    <svg class="{{ $logoClass ?? 'logo-svg' }}" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" style="{{ $logoSvgStyle ?? '' }}">
        <line x1="50" y1="15" x2="14" y2="85" stroke="currentColor" stroke-width="4" />
        <line x1="50" y1="15" x2="86" y2="85" stroke="currentColor" stroke-width="4" />
        <path d="M 14 85 Q 50 65 50 55 Q 50 65 86 85" stroke="var(--color-primary, #C86A44)" stroke-width="4" fill="none" />
        <circle cx="50" cy="15" r="7" fill="currentColor" />
        <circle cx="38" cy="38" r="7" fill="currentColor" />
        <circle cx="26" cy="61" r="7" fill="currentColor" />
        <circle cx="14" cy="85" r="7" fill="currentColor" />
        <circle cx="62" cy="38" r="7" fill="currentColor" />
        <circle cx="74" cy="61" r="7" fill="currentColor" />
        <circle cx="86" cy="85" r="7" fill="currentColor" />
        <circle cx="50" cy="55" r="7" fill="var(--color-primary, #C86A44)" />
    </svg>
@endif
