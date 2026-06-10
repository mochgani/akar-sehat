@extends('layouts.public')

@section('title', __('edukasi.page_title'))
@section('meta_desc', 'Artikel edukasi kesehatan holistik dari Akar Sehat. Pelajari tentang pencernaan, nutrisi, detoksifikasi, dan gaya hidup sehat bersama Kang Bahri.')

@push('styles')
<style>
    /* ----------------------------------------------------------------
       PAGE-SPECIFIC STYLES: Education Page
    ---------------------------------------------------------------- */

    /* ---- Page Hero (compact, no image) ---- */
    .edu-hero {
        background-color: var(--color-bg-alt);
        padding: 80px 0 60px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .edu-hero-bg {
        position: absolute;
        inset: 0;
        background-image: radial-gradient(var(--color-muted-sand) 1.5px, transparent 1.5px);
        background-size: 24px 24px;
        opacity: 0.35;
    }

    .edu-hero-content {
        position: relative;
        z-index: 1;
    }

    .edu-hero-label {
        display: inline-block;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--color-primary);
        margin-bottom: 16px;
    }

    .edu-hero h1 {
        font-size: 2.75rem;
        font-weight: 700;
        color: var(--color-dark-bark);
        margin-bottom: 16px;
        line-height: 1.2;
    }

    .edu-hero p {
        font-size: 1rem;
        color: var(--color-text-muted);
        max-width: 540px;
        margin: 0 auto;
    }

    /* ---- Search Bar ---- */
    .search-section {
        background-color: var(--color-white);
        padding: 32px 0;
        border-bottom: 1px solid rgba(56, 42, 33, 0.06);
        position: sticky;
        top: 70px;
        z-index: 100;
        box-shadow: var(--shadow-sm);
    }

    .search-wrap {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .search-input-group {
        flex: 1;
        min-width: 220px;
        position: relative;
    }

    .search-icon {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--color-text-muted);
        pointer-events: none;
    }

    .search-input {
        width: 100%;
        padding: 14px 18px 14px 50px;
        border: 1.5px solid rgba(56, 42, 33, 0.12);
        border-radius: var(--border-radius-round);
        font-family: var(--font-primary);
        font-size: 0.9375rem;
        color: var(--color-text-main);
        background-color: var(--color-soft-ivory);
        transition: var(--transition-normal);
        outline: none;
    }

    .search-input::placeholder {
        color: var(--color-text-muted);
        opacity: 0.7;
    }

    .search-input:focus {
        border-color: var(--color-primary);
        background-color: var(--color-white);
        box-shadow: 0 0 0 4px rgba(200, 106, 68, 0.1);
    }

    /* ---- Category Filter Chips ---- */
    .filter-chips {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
    }

    .chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 18px;
        border-radius: var(--border-radius-round);
        font-size: 0.8125rem;
        font-weight: 500;
        cursor: pointer;
        border: 1.5px solid rgba(56, 42, 33, 0.12);
        background-color: transparent;
        color: var(--color-text-muted);
        font-family: var(--font-primary);
        transition: var(--transition-normal);
        text-decoration: none;
    }

    .chip:hover {
        border-color: var(--color-primary);
        color: var(--color-primary);
    }

    .chip.active {
        background-color: var(--color-primary);
        border-color: var(--color-primary);
        color: var(--color-white);
    }

    /* ---- Article List Section ---- */
    .articles-section {
        padding: 60px 0 80px;
    }

    /* ---- Main Article Grid ---- */
    .articles-main {
        width: 100%;
    }

    .articles-meta-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
        gap: 12px;
        flex-wrap: wrap;
    }

    .articles-count {
        font-size: 0.875rem;
        color: var(--color-text-muted);
    }

    .articles-count span {
        font-weight: 600;
        color: var(--color-dark-bark);
    }

    .sort-select {
        padding: 8px 16px;
        border: 1.5px solid rgba(56, 42, 33, 0.12);
        border-radius: var(--border-radius-round);
        font-family: var(--font-primary);
        font-size: 0.8125rem;
        color: var(--color-text-main);
        background-color: var(--color-white);
        cursor: pointer;
        outline: none;
        transition: var(--transition-normal);
    }

    .sort-select:focus {
        border-color: var(--color-primary);
    }

    /* Article Grid — 3 columns */
    .article-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
    }

    /* Article Card */
    .edu-article-card {
        background-color: var(--color-white);
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: var(--transition-normal);
        display: flex;
        flex-direction: column;
    }

    .edu-article-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-lg);
    }

    .edu-article-img-box {
        height: 200px;
        background-color: var(--color-muted-sand);
        position: relative;
        overflow: hidden;
        flex-shrink: 0;
    }

    .edu-article-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
        display: block;
    }

    .edu-article-card:hover .edu-article-img-box img {
        transform: scale(1.05);
    }

    /* Placeholder image (no src) */
    .edu-article-img-box.no-img {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--color-bg-alt);
        color: var(--color-muted-sand);
    }

    .edu-article-tag {
        position: absolute;
        bottom: 14px;
        left: 14px;
        background-color: var(--color-white);
        color: var(--color-dark-bark);
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 0.6875rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    .edu-article-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .edu-article-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }

    .edu-article-date {
        font-size: 0.75rem;
        color: var(--color-text-muted);
    }

    .edu-article-read-time {
        font-size: 0.75rem;
        color: var(--color-text-muted);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .edu-article-read-time::before {
        content: '·';
    }

    .edu-article-title {
        font-size: 1.0625rem;
        font-weight: 600;
        color: var(--color-dark-bark);
        margin-bottom: 10px;
        line-height: 1.45;
    }

    .edu-article-excerpt {
        font-size: 0.875rem;
        color: var(--color-text-muted);
        line-height: 1.65;
        margin-bottom: 20px;
        flex: 1;
    }

    .edu-article-link {
        font-size: 0.8125rem;
        font-weight: 600;
        color: var(--color-primary);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: var(--transition-normal);
    }

    .edu-article-link:hover {
        color: var(--color-primary-dark);
        gap: 10px;
    }

    /* ---- No Results State ---- */
    .no-results {
        text-align: center;
        padding: 80px 24px;
        grid-column: 1 / -1;
    }

    .no-results-icon {
        width: 72px;
        height: 72px;
        background-color: var(--color-bg-alt);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        color: var(--color-text-muted);
    }

    .no-results h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--color-dark-bark);
        margin-bottom: 10px;
    }

    .no-results p {
        font-size: 0.9375rem;
        color: var(--color-text-muted);
    }

    /* Laravel pagination override */
    .pagination-wrap {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 48px;
        flex-wrap: wrap;
    }
    .pagination-wrap .page-item .page-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 14px;
        border-radius: var(--border-radius-md);
        font-family: var(--font-primary);
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--color-text-muted);
        background-color: var(--color-white);
        border: 1.5px solid rgba(56,42,33,0.12);
        text-decoration: none;
        transition: var(--transition-normal);
    }
    .pagination-wrap .page-item.active .page-link {
        background-color: var(--color-primary);
        border-color: var(--color-primary);
        color: var(--color-white);
    }
    .pagination-wrap .page-item.disabled .page-link {
        opacity: 0.4;
        pointer-events: none;
    }
    .pagination-wrap .page-item .page-link:hover {
        border-color: var(--color-primary);
        color: var(--color-primary);
    }

    /* ---- Placeholder SVG ---- */
    .placeholder-svg {
        width: 64px;
        height: 64px;
        opacity: 0.25;
    }

    /* ---- CTA Banner ---- */
    .cta-banner-wrapper {
        padding: 0 0 80px;
    }

    .cta-banner {
        background-color: var(--color-dark-bark);
        border-radius: var(--border-radius-lg);
        padding: 56px 64px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 40px;
    }

    .cta-banner-icon {
        width: 60px;
        height: 60px;
        background-color: rgba(200, 106, 68, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-primary);
        flex-shrink: 0;
    }

    .cta-banner-text { flex: 1; }

    .cta-banner-text h2 {
        font-size: 1.625rem;
        font-weight: 700;
        color: var(--color-white);
        margin-bottom: 10px;
    }

    .cta-banner-text p {
        font-size: 0.9375rem;
        color: rgba(255, 255, 255, 0.7);
        line-height: 1.6;
    }

    /* ---- Responsive ---- */
    @media (max-width: 992px) {
        .article-grid { grid-template-columns: repeat(2, 1fr); }
        .edu-hero h1 { font-size: 2.25rem; }
        .search-section { top: 62px; }
        .cta-banner { padding: 40px 40px; }
    }

    @media (max-width: 768px) {
        .article-grid { grid-template-columns: repeat(2, 1fr); }
        .search-wrap { flex-direction: column; align-items: stretch; }
        .cta-banner { flex-direction: column; text-align: center; padding: 36px 28px; }
        .cta-banner-icon { margin: 0 auto; }
    }

    @media (max-width: 576px) {
        .edu-hero { padding: 60px 0 40px; }
        .edu-hero h1 { font-size: 1.875rem; }
        .search-section { padding: 20px 0; position: static; }
        .articles-section { padding: 40px 0 40px; }
        .article-grid { grid-template-columns: 1fr; }
        .cta-banner-wrapper { padding: 0 0 60px; }
        .cta-banner { padding: 32px 24px; }
        .cta-banner-text h2 { font-size: 1.375rem; }
    }
</style>
@endpush

@section('content')

    <!-- PAGE HERO -->
    <header class="edu-hero">
        <div class="edu-hero-bg"></div>
        <div class="container edu-hero-content">
            <span class="edu-hero-label">{{ __('edukasi.hero_label') }}</span>
            <h1>{{ __('edukasi.hero_title') }}</h1>
            <p>{{ __('edukasi.hero_desc') }}</p>
        </div>
    </header>

    <!-- SEARCH & FILTER BAR -->
    <div class="search-section" id="search-section">
        <div class="container">
            <form method="GET" action="{{ route('edukasi.index') }}" id="search-form">
                <div class="search-wrap">
                    <!-- Search Input -->
                    <div class="search-input-group">
                        <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                        <input type="text" name="q" class="search-input" id="search-input"
                            placeholder="{{ __('common.search_article') }}" autocomplete="off"
                            value="{{ request('q') }}" />
                    </div>
                    <!-- Category Filter Chips -->
                    <div class="filter-chips" id="filter-chips">
                        <a href="{{ route('edukasi.index', array_merge(request()->except('kategori', 'page'), [])) }}"
                           class="chip {{ !request('kategori') ? 'active' : '' }}">{{ __('common.all') }}</a>
                        @foreach($kategoris as $kat)
                        <a href="{{ route('edukasi.index', array_merge(request()->except('kategori', 'page'), ['kategori' => $kat])) }}"
                           class="chip {{ request('kategori') === $kat ? 'active' : '' }}">{{ $kat }}</a>
                        @endforeach
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- ARTICLES -->
    <section class="articles-section">
        <div class="container">
            <div class="articles-main">
                <div class="articles-meta-bar">
                    <p class="articles-count">
                        {{ __('common.showing') }} <span>{{ $artikel->total() }}</span> {{ __('edukasi.hero_title') }}
                        @if(request('kategori'))
                            {{ __('edukasi.search_in') }} <strong>{{ request('kategori') }}</strong>
                        @endif
                        @if(request('q'))
                            untuk "<strong>{{ request('q') }}</strong>"
                        @endif
                    </p>
                    <form method="GET" action="{{ route('edukasi.index') }}" id="sort-form" style="display:inline;">
                        @foreach(request()->except('sort') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <select name="sort" class="sort-select" aria-label="Urutkan artikel" onchange="this.form.submit()">
                            <option value="terbaru" {{ request('sort', 'terbaru') === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                            <option value="terpopuler" {{ request('sort') === 'terpopuler' ? 'selected' : '' }}>Terpopuler</option>
                            <option value="az" {{ request('sort') === 'az' ? 'selected' : '' }}>A–Z</option>
                        </select>
                    </form>
                </div>

                <div class="article-grid">
                    @forelse($artikel as $item)
                    <article class="edu-article-card">
                        <div class="edu-article-img-box {{ $item->thumbnail ? '' : 'no-img' }}">
                            @if($item->thumbnail)
                                <img src="{{ asset('asset/artikel/'.$item->thumbnail) }}" alt="{{ $item->judul }}" loading="lazy">
                            @else
                                <svg class="placeholder-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.8">
                                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                    <polyline points="21 15 16 10 5 21"/>
                                </svg>
                            @endif
                            <span class="edu-article-tag">{{ $item->kategori }}</span>
                        </div>
                        <div class="edu-article-body">
                            <div class="edu-article-meta">
                                <span class="edu-article-date">
                                    {{ $item->published_at ? \Carbon\Carbon::parse($item->published_at)->format('d M Y') : ($item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d M Y') : '') }}
                                </span>
                                @if($item->read_time ?? $item->readTime ?? false)
                                <span class="edu-article-read-time">{{ $item->read_time ?? $item->readTime }} {{ __('common.min_read') }}</span>
                                @endif
                            </div>
                            <h2 class="edu-article-title">{{ $item->judul }}</h2>
                            <p class="edu-article-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags($item->konten ?? $item->excerpt ?? $item->judul), 120) }}</p>
                            <a href="{{ route('edukasi.show', $item->slug) }}" class="edu-article-link">
                                {{ __('common.read_more') }}
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                                </svg>
                            </a>
                        </div>
                    </article>
                    @empty
                    <div class="no-results">
                        <div class="no-results-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <circle cx="11" cy="11" r="8" />
                                <line x1="21" y1="21" x2="16.65" y2="16.65" />
                                <line x1="8" y1="11" x2="14" y2="11" />
                            </svg>
                        </div>
                        <h3>{{ __('common.not_found_article') }}</h3>
                        <p>{{ __('common.not_found_article_try') }}</p>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($artikel->hasPages())
                <div class="pagination-wrap">
                    {{ $artikel->appends(request()->except('page'))->links() }}
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- CTA BANNER -->
    <div class="container cta-banner-wrapper">
        <div class="cta-banner">
            <div class="cta-banner-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                </svg>
            </div>
            <div class="cta-banner-text">
                <h2>{{ __('edukasi.cta_title') }}</h2>
                <p>{{ __('edukasi.cta_desc') }}</p>
            </div>
            <a href="https://wa.me/{{ $siteSettings['wa_number'] ?? '6281234567890' }}" target="_blank"
                class="btn btn-primary btn--large" style="white-space: nowrap; flex-shrink: 0;">
                {{ __('common.consult_now') }}
            </a>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Auto-submit search form on input (debounced)
    (function() {
        var searchInput = document.getElementById('search-input');
        var searchForm  = document.getElementById('search-form');
        if (!searchInput || !searchForm) return;

        var timer;
        searchInput.addEventListener('input', function() {
            clearTimeout(timer);
            timer = setTimeout(function() {
                searchForm.submit();
            }, 500);
        });
    })();
</script>
@endpush
