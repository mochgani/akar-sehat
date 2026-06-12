<!DOCTYPE html>
<html lang="{{ $currentLocale ?? 'id' }}" dir="{{ ($activeLanguages ?? collect())->firstWhere('code', $currentLocale ?? 'id')?->dir ?? 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Akar Sehat - Pahami Tubuh, Sehat dari Akar')</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_desc', 'Akar Sehat menyediakan edukasi dan pendampingan kesehatan holistik untuk membantu Anda memahami penyakit secara menyeluruh sampai ke akarnya bersama Kang Bahri.')">
    <meta name="keywords" content="@yield('meta_keywords', 'kesehatan alami, detoksifikasi, nutrisi pencernaan, pendampingan kesehatan, Kang Bahri, herbal bandung, akar sehat')">
    <meta name="author" content="Akar Sehat">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('og_title', 'Akar Sehat - Pahami Tubuh, Sehat dari Akar')">
    <meta property="og:description" content="@yield('og_description', 'Edukasi dan pendampingan kesehatan holistik untuk memahami penyakit sampai ke akar masalahnya.')">
    <meta property="og:type" content="website">

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    @include('partials.favicon')
    <!-- Project Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @stack('styles')
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('home') }}" class="logo">
                @include('partials.logo')
                {{ $siteSettings['name'] ?? 'Akar Sehat' }}
            </a>
            <ul class="nav-menu" id="nav-menu">
                <li><a href="{{ route('tentang') }}" class="nav-link {{ request()->routeIs('tentang') ? 'active' : '' }}">{{ __('nav.about') }}</a></li>
                <li><a href="{{ route('edukasi.index') }}" class="nav-link {{ request()->routeIs('edukasi.*') ? 'active' : '' }}">{{ __('nav.education') }}</a></li>
                <li><a href="{{ route('produk.index') }}" class="nav-link {{ request()->routeIs('produk.*') ? 'active' : '' }}">{{ __('nav.products') }}</a></li>
                @if(($activeLanguages ?? collect())->count() > 1)
                <li class="nav-lang-wrap">
                    <button class="nav-lang-btn" id="nav-lang-btn" aria-expanded="false" aria-haspopup="true">
                        <span class="nav-lang-flag">{{ ($activeLanguages ?? collect())->firstWhere('code', $currentLocale ?? 'id')?->flag ?? '🌐' }}</span>
                        <span class="nav-lang-code">{{ strtoupper($currentLocale ?? 'id') }}</span>
                        <svg class="nav-lang-chevron" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <div class="nav-lang-menu" id="nav-lang-menu" role="menu">
                        <div class="nav-lang-menu-inner">
                        @foreach($activeLanguages ?? [] as $lang)
                        <a href="{{ route('lang.switch', $lang->code) }}"
                           class="nav-lang-item {{ ($currentLocale ?? 'id') === $lang->code ? 'active' : '' }}"
                           role="menuitem">
                            <span>{{ $lang->flag }}</span>
                            <span>{{ $lang->native_name }}</span>
                            @if(($currentLocale ?? 'id') === $lang->code)
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-left:auto;color:var(--color-primary)"><polyline points="20 6 9 17 4 12"/></svg>
                            @endif
                        </a>
                        @endforeach
                        </div>
                    </div>
                </li>
                @endif
            </ul>
            <div class="menu-toggle" id="mobile-menu" aria-label="Toggle navigation menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>
    </nav>

    <!-- PAGE CONTENT -->
    @yield('content')

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <div class="footer-top">
                <div class="footer-brand">
                    <a href="{{ route('home') }}" class="logo">
                        @if(!empty($siteSettings['logo']))
                            <img src="{{ asset('storage/'.$siteSettings['logo']) }}" alt="{{ $siteSettings['name'] ?? 'Akar Sehat' }}" style="height:32px;width:auto;object-fit:contain">
                        @else
                            @include('partials.logo')
                        @endif
                        {{ $siteSettings['name'] ?? 'Akar Sehat' }}
                    </a>
                    <p>{{ $siteSettings['footer_desc'] ?? 'Platform edukasi dan pendampingan kesehatan modern yang membantu masyarakat memahami tubuh dari akar masalahnya secara natural.' }}</p>
                    <div class="social-links">
                        @if(!empty($siteSettings['fb_url']))
                        <a href="{{ $siteSettings['fb_url'] }}" class="social-icon" target="_blank" rel="noopener" aria-label="Facebook">f</a>
                        @else
                        <a href="#" class="social-icon" aria-label="Facebook">f</a>
                        @endif
                        @if(!empty($siteSettings['ig_url']))
                        <a href="{{ $siteSettings['ig_url'] }}" class="social-icon" target="_blank" rel="noopener" aria-label="Instagram">i</a>
                        @else
                        <a href="#" class="social-icon" aria-label="Instagram">i</a>
                        @endif
                        @if(!empty($siteSettings['yt_url']))
                        <a href="{{ $siteSettings['yt_url'] }}" class="social-icon" target="_blank" rel="noopener" aria-label="YouTube">yt</a>
                        @else
                        <a href="#" class="social-icon" aria-label="YouTube">yt</a>
                        @endif
                    </div>
                </div>
                <div class="footer-col">
                    <h3>{{ __('footer.navigation') }}</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('tentang') }}">{{ __('nav.about') }}</a></li>
                        <li><a href="{{ route('edukasi.index') }}">{{ __('nav.education') }}</a></li>
                        <li><a href="{{ route('produk.index') }}">{{ __('nav.products') }}</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3>{{ __('footer.contact_us') }}</h3>
                    <ul class="contact-info">
                        @if(!empty($siteSettings['address']))
                        <li><span>📍</span> {{ $siteSettings['address'] }}</li>
                        @endif
                        @if(!empty($siteSettings['wa_number']))
                        <li><span>📞</span> {{ $siteSettings['wa_number'] }}</li>
                        @endif
                        @if(!empty($siteSettings['email']))
                        <li><span>✉️</span> {{ $siteSettings['email'] }}</li>
                        @endif
                        @if(!empty($siteSettings['instagram']))
                        <li><span>📷</span> {{ $siteSettings['instagram'] }}</li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>{{ $siteSettings['copyright'] ?? '© '.date('Y').' Akar Sehat. All rights reserved.' }}</p>
            </div>
        </div>
    </footer>

    <!-- Project Script -->
    <script src="{{ asset('js/main.js') }}" defer></script>

    @stack('scripts')
</body>

</html>
