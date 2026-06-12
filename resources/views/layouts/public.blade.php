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
                        <a href="{{ !empty($siteSettings['fb_url']) ? $siteSettings['fb_url'] : '#' }}" class="social-icon" {{ !empty($siteSettings['fb_url']) ? 'target="_blank" rel="noopener"' : '' }} aria-label="Facebook">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="{{ !empty($siteSettings['ig_url']) ? $siteSettings['ig_url'] : '#' }}" class="social-icon" {{ !empty($siteSettings['ig_url']) ? 'target="_blank" rel="noopener"' : '' }} aria-label="Instagram">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="{{ !empty($siteSettings['yt_url']) ? $siteSettings['yt_url'] : '#' }}" class="social-icon" {{ !empty($siteSettings['yt_url']) ? 'target="_blank" rel="noopener"' : '' }} aria-label="YouTube">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M23.495 6.205a3.007 3.007 0 0 0-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 0 0 .527 6.205a31.247 31.247 0 0 0-.522 5.805 31.247 31.247 0 0 0 .522 5.783 3.007 3.007 0 0 0 2.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 0 0 2.088-2.088 31.247 31.247 0 0 0 .5-5.783 31.247 31.247 0 0 0-.5-5.805zM9.609 15.601V8.408l6.264 3.602z"/></svg>
                        </a>
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
                        <li><span>📞</span> <a href="https://wa.me/{{ preg_replace('/\D/', '', $siteSettings['wa_number']) }}" target="_blank" rel="noopener" style="color:inherit;text-decoration:none;">{{ $siteSettings['wa_number'] }}</a></li>
                        @endif
                        @if(!empty($siteSettings['wa_number_2']))
                        <li><span>📞</span> <a href="https://wa.me/{{ preg_replace('/\D/', '', $siteSettings['wa_number_2']) }}" target="_blank" rel="noopener" style="color:inherit;text-decoration:none;">{{ $siteSettings['wa_number_2'] }}</a></li>
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
