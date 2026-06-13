@extends('layouts.public')

@section('title', __('produk.page_title'))
@section('meta_desc', 'Temukan suplemen herbal pilihan Akar Sehat — diformulasikan untuk mendukung detoksifikasi, pencernaan, imunitas, dan kesehatan tubuh secara alami.')

@push('styles')
<style>
    /* ----------------------------------------------------------------
       PAGE-SPECIFIC STYLES: Product Listing Page
    ---------------------------------------------------------------- */

    /* ---- Page Hero ---- */
    .produk-hero {
        background-color: var(--color-bg-alt);
        padding: 80px 0 60px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .produk-hero-bg {
        position: absolute;
        inset: 0;
        background-image: radial-gradient(var(--color-muted-sand) 1.5px, transparent 1.5px);
        background-size: 24px 24px;
        opacity: 0.35;
    }

    .produk-hero-content {
        position: relative;
        z-index: 1;
    }

    .produk-hero-label {
        display: inline-block;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--color-primary);
        margin-bottom: 16px;
    }

    .produk-hero h1 {
        font-size: 2.75rem;
        font-weight: 700;
        color: var(--color-dark-bark);
        margin-bottom: 16px;
        line-height: 1.2;
    }

    .produk-hero p {
        font-size: 1rem;
        color: var(--color-text-muted);
        max-width: 540px;
        margin: 0 auto;
    }

    /* ---- Stats Strip ---- */
    .stats-strip {
        background-color: var(--color-white);
        border-bottom: 1px solid rgba(56, 42, 33, 0.06);
        padding: 28px 0;
    }

    .stats-strip-inner {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .stats-strip-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 8px;
        font-size: 0.875rem;
        color: var(--color-text-muted);
        padding: 8px 12px;
    }

    .stats-strip-item svg {
        color: var(--color-primary);
        flex-shrink: 0;
    }

    .stats-strip-item strong {
        font-weight: 600;
        color: var(--color-dark-bark);
    }

    /* ---- Filter Bar ---- */
    .filter-bar {
        background-color: var(--color-white);
        padding: 24px 0;
        border-bottom: 1px solid rgba(56, 42, 33, 0.06);
        position: sticky;
        top: 70px;
        z-index: 100;
        box-shadow: var(--shadow-sm);
    }

    .filter-bar-inner {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    /* Search Input */
    .filter-search-group {
        position: relative;
        flex: 1;
        min-width: 200px;
    }

    .filter-search-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--color-text-muted);
        pointer-events: none;
    }

    .filter-search-input {
        width: 100%;
        padding: 12px 16px 12px 46px;
        border: 1.5px solid rgba(56, 42, 33, 0.12);
        border-radius: var(--border-radius-round);
        font-family: var(--font-primary);
        font-size: 0.9375rem;
        color: var(--color-text-main);
        background-color: var(--color-soft-ivory);
        transition: var(--transition-normal);
        outline: none;
    }

    .filter-search-input::placeholder {
        color: var(--color-text-muted);
        opacity: 0.7;
    }

    .filter-search-input:focus {
        border-color: var(--color-primary);
        background-color: var(--color-white);
        box-shadow: 0 0 0 4px rgba(200, 106, 68, 0.1);
    }

    /* Filter divider */
    .filter-divider {
        width: 1px;
        height: 32px;
        background-color: rgba(56, 42, 33, 0.1);
        flex-shrink: 0;
    }

    /* Category Chips */
    .filter-chips {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        align-items: center;
    }

    .chip {
        display: inline-flex;
        align-items: center;
        padding: 8px 16px;
        border-radius: var(--border-radius-round);
        font-size: 0.8125rem;
        font-weight: 500;
        cursor: pointer;
        border: 1.5px solid rgba(56, 42, 33, 0.12);
        background-color: transparent;
        color: var(--color-text-muted);
        font-family: var(--font-primary);
        transition: var(--transition-normal);
        white-space: nowrap;
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

    /* Price & Sort Selects */
    .filter-select {
        padding: 10px 16px;
        border: 1.5px solid rgba(56, 42, 33, 0.12);
        border-radius: var(--border-radius-round);
        font-family: var(--font-primary);
        font-size: 0.8125rem;
        color: var(--color-text-main);
        background-color: var(--color-white);
        cursor: pointer;
        outline: none;
        transition: var(--transition-normal);
        white-space: nowrap;
    }

    .filter-select:focus {
        border-color: var(--color-primary);
    }

    /* ---- Product Section ---- */
    .products-section {
        padding: 48px 0 80px;
    }

    .products-meta-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
        gap: 12px;
        flex-wrap: wrap;
    }

    .products-count {
        font-size: 0.875rem;
        color: var(--color-text-muted);
    }

    .products-count span {
        font-weight: 600;
        color: var(--color-dark-bark);
    }

    /* ---- Product Grid ---- */
    .produk-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
    }

    /* ---- Product Card (vertical) ---- */
    .produk-card {
        background-color: var(--color-white);
        border-radius: var(--border-radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: var(--transition-normal);
        display: flex;
        flex-direction: column;
        border: 1.5px solid rgba(56, 42, 33, 0.04);
    }

    .produk-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-xl);
        border-color: rgba(200, 106, 68, 0.12);
    }

    /* Image Area */
    .produk-card-img-wrap {
        position: relative;
        background-color: var(--color-soft-ivory);
        height: 260px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .produk-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        transition: transform 0.45s ease;
    }

    .produk-card:hover .produk-card-img {
        transform: scale(1.06);
    }

    .produk-card-img-wrap.no-img {
        background-color: var(--color-bg-alt);
    }

    .produk-placeholder-svg {
        width: 80px;
        height: 80px;
        opacity: 0.18;
    }

    /* Badges */
    .produk-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        padding: 4px 12px;
        border-radius: var(--border-radius-round);
        font-size: 0.6875rem;
        font-weight: 700;
        letter-spacing: 0.3px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .produk-badge.best-seller {
        background-color: var(--color-primary);
        color: var(--color-white);
    }

    .produk-badge.new {
        background-color: var(--color-dark-bark);
        color: var(--color-white);
    }

    /* Info Area */
    .produk-card-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .produk-card-category {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.6875rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: var(--color-primary);
        margin-bottom: 10px;
    }

    .produk-card-category::before {
        content: '';
        display: inline-block;
        width: 6px;
        height: 6px;
        background-color: var(--color-primary);
        border-radius: 50%;
    }

    .produk-card-name {
        font-size: 1.0625rem;
        font-weight: 700;
        color: var(--color-dark-bark);
        margin-bottom: 10px;
        line-height: 1.35;
    }

    .produk-card-desc {
        font-size: 0.8125rem;
        color: var(--color-text-muted);
        line-height: 1.65;
        margin-bottom: 20px;
        flex: 1;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .produk-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding-top: 16px;
        border-top: 1px solid rgba(56, 42, 33, 0.07);
    }

    .produk-card-price {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--color-dark-bark);
    }

    .produk-card-price .price-original {
        font-size: 0.8125rem;
        font-weight: 400;
        color: var(--color-text-muted);
        text-decoration: line-through;
        display: block;
        margin-bottom: 2px;
    }

    .produk-card-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 20px;
        background-color: var(--color-dark-bark);
        color: var(--color-white);
        border-radius: var(--border-radius-round);
        font-size: 0.8125rem;
        font-weight: 600;
        transition: var(--transition-normal);
        white-space: nowrap;
        flex-shrink: 0;
        text-decoration: none;
    }

    .produk-card-btn:hover {
        background-color: var(--color-primary);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(200, 106, 68, 0.3);
        color: var(--color-white);
    }

    /* ---- Empty State ---- */
    .no-products {
        text-align: center;
        padding: 80px 24px;
        grid-column: 1 / -1;
    }

    .no-products-icon {
        width: 80px;
        height: 80px;
        background-color: var(--color-bg-alt);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        color: var(--color-text-muted);
    }

    .no-products h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--color-dark-bark);
        margin-bottom: 10px;
    }

    .no-products p {
        font-size: 0.9375rem;
        color: var(--color-text-muted);
        margin-bottom: 28px;
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

    /* Laravel pagination */
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
        border-radius: var(--border-radius-round);
        font-family: var(--font-primary);
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--color-text-muted);
        background-color: var(--color-white);
        border: 1.5px solid rgba(56,42,33,0.1);
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
    .pagination-wrap .page-item .page-link:hover:not(.disabled) {
        border-color: var(--color-primary);
        color: var(--color-primary);
    }

    /* ---- Responsive ---- */
    @media (max-width: 992px) {
        .produk-hero h1 { font-size: 2.25rem; }

        .produk-grid { grid-template-columns: repeat(2, 1fr); }

        .filter-bar { top: 62px; }

        .stats-strip-inner { grid-template-columns: repeat(2, 1fr); gap: 12px; }

        .cta-banner { padding: 40px; }

        .filter-divider { display: none; }
    }

    @media (max-width: 768px) {
        .filter-bar-inner { flex-direction: column; align-items: stretch; }

        .filter-search-group { min-width: 100%; }

        .filter-chips { justify-content: flex-start; }

        .cta-banner {
            flex-direction: column;
            text-align: center;
            padding: 36px 28px;
        }

        .cta-banner-icon { margin: 0 auto; }

        .stats-strip-inner { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    }

    @media (max-width: 576px) {
        .produk-hero { padding: 60px 0 40px; }
        .produk-hero h1 { font-size: 1.875rem; }

        .filter-bar { position: static; }

        .produk-grid { grid-template-columns: 1fr; }

        .products-section { padding: 40px 0 60px; }

        .cta-banner { padding: 28px 20px; }
        .cta-banner-text h2 { font-size: 1.375rem; }
        .cta-banner-wrapper { padding: 0 0 60px; }

        .produk-card-img-wrap { height: 220px; }

        .stats-strip { display: none; }
    }
</style>
@endpush

@section('content')

    <!-- PAGE HERO -->
    <header class="produk-hero">
        <div class="produk-hero-bg"></div>
        <div class="container produk-hero-content">
            <span class="produk-hero-label">{{ __('produk.hero_label') }}</span>
            <h1>{{ __('produk.hero_title') }} <span class="text-primary">{{ __('produk.hero_title_highlight') }}</span> {{ __('produk.hero_title_suffix') }}</h1>
            <p>{{ __('produk.hero_desc') }}</p>
        </div>
    </header>

    <!-- TRUST STRIP -->
    <div class="stats-strip">
        <div class="container">
            <div class="stats-strip-inner">
                <div class="stats-strip-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                    <span><strong>{{ __('produk.trust1') }}</strong> — {{ __('produk.trust1_sub') }}</span>
                </div>
                <div class="stats-strip-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                    </svg>
                    <span><strong>Ratusan+</strong> pengguna aktif terbantu</span>
                </div>
                <div class="stats-strip-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                    </svg>
                    <span>{{ __('produk.trust2') }} <strong>{{ __('produk.trust2_strong') }}</strong></span>
                </div>
                <div class="stats-strip-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                    <span>{{ __('produk.trust3') }} <strong>{{ __('produk.trust3_strong') }}</strong> {{ __('produk.trust3_suffix') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTER BAR -->
    <div class="filter-bar" id="filter-bar">
        <div class="container">
            <form method="GET" action="{{ route('produk.index') }}" id="filter-form">
                <div class="filter-bar-inner">
                    <!-- Search by Name -->
                    <div class="filter-search-group">
                        <svg class="filter-search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input type="text" name="q" id="search-input" class="filter-search-input"
                            placeholder="{{ __('common.search_product') }}" autocomplete="off"
                            value="{{ request('q') }}" />
                    </div>

                    <div class="filter-divider"></div>

                    <!-- Category Chips -->
                    <div class="filter-chips" id="filter-chips">
                        <a href="{{ route('produk.index', array_merge(request()->except('kategori', 'page'), [])) }}"
                           class="chip {{ !request('kategori') ? 'active' : '' }}">{{ __('common.all') }}</a>
                        @foreach($kategoris as $kat)
                        <a href="{{ route('produk.index', array_merge(request()->except('kategori', 'page'), ['kategori' => $kat->nama])) }}"
                           class="chip {{ request('kategori') === $kat->nama ? 'active' : '' }}">{{ $kat->trans('nama') }}</a>
                        @endforeach
                    </div>

                    <div class="filter-divider"></div>

                    <!-- Sort -->
                    <select name="sort" id="sort-select" class="filter-select" aria-label="{{ __('common.sort') }}" onchange="this.form.submit()">
                        <option value="default" {{ request('sort', 'default') === 'default' ? 'selected' : '' }}>{{ __('common.sort') }}</option>
                        <option value="harga-asc" {{ request('sort') === 'harga-asc' ? 'selected' : '' }}>{{ __('common.sort_price_low') }}</option>
                        <option value="harga-desc" {{ request('sort') === 'harga-desc' ? 'selected' : '' }}>{{ __('common.sort_price_high') }}</option>
                        <option value="nama-az" {{ request('sort') === 'nama-az' ? 'selected' : '' }}>{{ __('common.sort_name_az') }}</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- PRODUCTS -->
    <section class="products-section">
        <div class="container">

            <!-- Meta bar -->
            <div class="products-meta-bar">
                <p class="products-count">
                    {{ __('common.showing') }} <span>{{ $produk->total() }}</span> {{ __('common.products_unit') }}
                    @if(request('kategori'))
                        @php $activeKat = $kategoris->firstWhere('nama', request('kategori')); @endphp
                        dalam kategori <strong>{{ $activeKat ? $activeKat->trans('nama') : request('kategori') }}</strong>
                    @endif
                    @if(request('q'))
                        untuk "<strong>{{ request('q') }}</strong>"
                    @endif
                </p>
            </div>

            <!-- Grid -->
            <div class="produk-grid">
                @forelse($produk as $item)
                <div class="produk-card">
                    <div class="produk-card-img-wrap {{ $item->fotos ? '' : 'no-img' }}">
                        @if($item->fotos)
                            <img class="produk-card-img" src="{{ asset('storage/'.($item->fotos[0] ?? '')) }}" alt="{{ $item->trans('nama') }}" loading="lazy">
                        @else
                            <svg class="produk-placeholder-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.8">
                                <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/>
                                <polyline points="21 15 16 10 5 21"/>
                            </svg>
                        @endif
                        @if($item->is_best_seller ?? false)
                            <span class="produk-badge best-seller">{{ __('common.best_seller') }}</span>
                        @elseif($item->is_new ?? false)
                            <span class="produk-badge new">{{ __('common.new') }}</span>
                        @endif
                    </div>
                    <div class="produk-card-body">
                        <span class="produk-card-category">{{ $kategoris->firstWhere('nama', $item->kategori)?->trans('nama') ?? $item->kategori }}</span>
                        <h3 class="produk-card-name">{{ $item->trans('nama') }}</h3>
                        <p class="produk-card-desc">{{ $item->trans('deskripsi') }}</p>
                        <div class="produk-card-footer">
                            <div class="produk-card-price">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </div>
                            <a href="{{ route('produk.show', $item->slug) }}" class="produk-card-btn">
                                {{ __('common.view_detail') }}
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="no-products">
                    <div class="no-products-icon">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                            <line x1="8" y1="11" x2="14" y2="11"/>
                        </svg>
                    </div>
                    <h3>{{ __('common.not_found_product') }}</h3>
                    <p>{{ __('common.not_found_try') }}</p>
                    <a href="{{ route('produk.index') }}" class="btn btn-secondary">{{ __('common.reset_filter') }}</a>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($produk->hasPages())
            <div class="pagination-wrap">
                {{ $produk->appends(request()->except('page'))->links() }}
            </div>
            @endif

        </div>
    </section>

    <!-- CTA BANNER -->
    <div class="container cta-banner-wrapper">
        <div class="cta-banner">
            <div class="cta-banner-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
            </div>
            <div class="cta-banner-text">
                <h2>{{ __('produk.cta_title') }}</h2>
                <p>{{ __('produk.cta_desc') }}</p>
            </div>
            <a href="https://wa.me/{{ $siteSettings['wa_number'] ?? '6281234567890' }}" target="_blank"
                class="btn btn-primary btn--large" style="white-space:nowrap; flex-shrink:0;">
                {{ __('common.consult_free') }}
            </a>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Auto-submit search form on input (debounced)
    (function() {
        var searchInput = document.getElementById('search-input');
        var filterForm  = document.getElementById('filter-form');
        if (!searchInput || !filterForm) return;

        var timer;
        searchInput.addEventListener('input', function() {
            clearTimeout(timer);
            timer = setTimeout(function() {
                filterForm.submit();
            }, 500);
        });
    })();
</script>
@endpush
