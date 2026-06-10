@extends('layouts.public')

@section('title', ($artikel->trans('meta_title') ?? $artikel->trans('judul')) . ' — Akar Sehat')
@section('meta_desc', $artikel->trans('meta_desc') ?? \Illuminate\Support\Str::limit(strip_tags($artikel->trans('konten') ?? ''), 160))

@push('styles')
<style>
    /* ----------------------------------------------------------------
       PAGE-SPECIFIC STYLES: Article Detail Page
    ---------------------------------------------------------------- */

    /* ---- Breadcrumb ---- */
    .breadcrumb-bar {
        background-color: var(--color-white);
        border-bottom: 1px solid rgba(56, 42, 33, 0.06);
        padding: 14px 0;
    }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.8125rem;
        color: var(--color-text-muted);
        flex-wrap: wrap;
    }

    .breadcrumb a {
        color: var(--color-text-muted);
        transition: var(--transition-fast);
    }

    .breadcrumb a:hover {
        color: var(--color-primary);
    }

    .breadcrumb-sep {
        opacity: 0.4;
        font-size: 0.6875rem;
    }

    .breadcrumb-current {
        color: var(--color-dark-bark);
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 260px;
    }

    /* ---- Article Page Layout ---- */
    .article-page {
        padding: 60px 0 0;
    }

    .article-wrap {
        max-width: 800px;
        margin: 0 auto;
    }

    /* ---- Article Header ---- */
    .article-category-row {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .article-category-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 16px;
        background-color: rgba(200, 106, 68, 0.1);
        color: var(--color-primary);
        border-radius: var(--border-radius-round);
        font-size: 0.6875rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .article-read-time-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.8125rem;
        color: var(--color-text-muted);
    }

    .article-main-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--color-dark-bark);
        line-height: 1.25;
        margin-bottom: 24px;
    }

    .article-byline {
        display: flex;
        align-items: center;
        gap: 16px;
        padding-bottom: 28px;
        border-bottom: 1px solid rgba(56, 42, 33, 0.08);
        margin-bottom: 36px;
        flex-wrap: wrap;
    }

    .byline-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background-color: var(--color-bg-alt);
        border: 2px solid var(--color-muted-sand);
        overflow: hidden;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-primary-dark);
    }

    .byline-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .byline-info { flex: 1; }

    .byline-name {
        font-size: 0.9375rem;
        font-weight: 600;
        color: var(--color-dark-bark);
    }

    .byline-date {
        font-size: 0.8125rem;
        color: var(--color-text-muted);
    }

    .byline-share {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .share-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--color-bg-alt);
        color: var(--color-text-muted);
        border: none;
        cursor: pointer;
        transition: var(--transition-normal);
    }

    .share-btn:hover {
        background-color: var(--color-primary);
        color: var(--color-white);
    }

    /* ---- Hero Image ---- */
    .article-hero-img-box {
        width: 100%;
        height: 420px;
        border-radius: var(--border-radius-xl);
        overflow: hidden;
        margin-bottom: 48px;
        background-color: var(--color-muted-sand);
        position: relative;
    }

    .article-hero-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .article-hero-img-box.no-img {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--color-bg-alt);
    }

    /* ---- Article Body Typography ---- */
    .article-body {
        font-size: 1.0625rem;
        line-height: 1.85;
        color: var(--color-text-main);
    }

    .article-body p {
        margin-bottom: 24px;
    }

    .article-body h2 {
        font-size: 1.625rem;
        font-weight: 700;
        color: var(--color-dark-bark);
        margin: 48px 0 18px;
        line-height: 1.3;
    }

    .article-body h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--color-dark-bark);
        margin: 32px 0 14px;
    }

    .article-body ul,
    .article-body ol {
        margin-bottom: 24px;
        padding-left: 0;
        list-style: none;
    }

    .article-body ul li,
    .article-body ol li {
        position: relative;
        padding-left: 24px;
        margin-bottom: 10px;
        color: var(--color-text-main);
    }

    .article-body ul li::before {
        content: '';
        position: absolute;
        left: 0;
        top: 11px;
        width: 7px;
        height: 7px;
        background-color: var(--color-primary);
        border-radius: 50%;
    }

    .article-body ol {
        counter-reset: list-counter;
    }

    .article-body ol li {
        counter-increment: list-counter;
    }

    .article-body ol li::before {
        content: counter(list-counter) '.';
        position: absolute;
        left: 0;
        font-weight: 600;
        color: var(--color-primary);
        font-size: 0.875rem;
    }

    /* Blockquote */
    .article-body blockquote {
        margin: 36px 0;
        padding: 28px 32px;
        background-color: var(--color-bg-alt);
        border-left: 4px solid var(--color-primary);
        border-radius: 0 var(--border-radius-md) var(--border-radius-md) 0;
        font-style: italic;
        font-size: 1.0625rem;
        color: var(--color-dark-bark);
        line-height: 1.7;
    }

    .article-body blockquote cite {
        display: block;
        margin-top: 12px;
        font-style: normal;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--color-primary);
    }

    /* Callout / Key Takeaway Box */
    .callout-box {
        background-color: var(--color-white);
        border: 1.5px solid rgba(200, 106, 68, 0.2);
        border-radius: var(--border-radius-lg);
        padding: 28px 32px;
        margin: 36px 0;
        box-shadow: var(--shadow-sm);
    }

    .callout-box-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
    }

    .callout-box-icon {
        width: 36px;
        height: 36px;
        background-color: rgba(200, 106, 68, 0.1);
        border-radius: var(--border-radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-primary);
        flex-shrink: 0;
    }

    .callout-box-title {
        font-size: 0.9375rem;
        font-weight: 700;
        color: var(--color-dark-bark);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .callout-box ul {
        margin-bottom: 0;
    }

    .callout-box ul li {
        font-size: 0.9375rem;
    }

    /* ---- Article Tags & Share Footer ---- */
    .article-tags-row {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        padding: 28px 0;
        border-top: 1px solid rgba(56, 42, 33, 0.08);
        border-bottom: 1px solid rgba(56, 42, 33, 0.08);
        margin: 48px 0 40px;
    }

    .tags-label {
        font-size: 0.8125rem;
        font-weight: 600;
        color: var(--color-dark-bark);
    }

    .article-tag-pill {
        padding: 5px 14px;
        background-color: var(--color-bg-alt);
        border-radius: var(--border-radius-round);
        font-size: 0.75rem;
        font-weight: 500;
        color: var(--color-text-muted);
        transition: var(--transition-normal);
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }

    .article-tag-pill:hover {
        background-color: var(--color-muted-sand);
        color: var(--color-dark-bark);
    }

    /* ---- Author Card ---- */
    .author-card {
        background-color: var(--color-bg-alt);
        border-radius: var(--border-radius-xl);
        padding: 36px;
        display: flex;
        gap: 28px;
        align-items: flex-start;
        margin-bottom: 60px;
    }

    .author-card-img {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background-color: var(--color-muted-sand);
        border: 3px solid var(--color-white);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        flex-shrink: 0;
        display: flex;
        align-items: flex-end;
        justify-content: center;
    }

    .author-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .author-card-info { flex: 1; }

    .author-card-label {
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--color-primary);
        margin-bottom: 6px;
        display: block;
    }

    .author-card-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--color-dark-bark);
        margin-bottom: 10px;
    }

    .author-card-bio {
        font-size: 0.9375rem;
        color: var(--color-text-muted);
        line-height: 1.65;
        margin-bottom: 16px;
    }

    /* ---- Prev / Next Navigation ---- */
    .article-nav {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 80px;
    }

    .article-nav-btn {
        background-color: var(--color-white);
        border-radius: var(--border-radius-lg);
        padding: 20px 24px;
        box-shadow: var(--shadow-sm);
        transition: var(--transition-normal);
        display: flex;
        flex-direction: column;
        gap: 6px;
        border: 1.5px solid rgba(56, 42, 33, 0.06);
        cursor: pointer;
        text-decoration: none;
    }

    .article-nav-btn:hover {
        border-color: var(--color-primary);
        box-shadow: var(--shadow-md);
        transform: translateY(-3px);
    }

    .article-nav-btn.next {
        text-align: right;
    }

    .article-nav-btn.disabled {
        opacity: 0.35;
        pointer-events: none;
    }

    .nav-btn-label {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--color-primary);
    }

    .nav-btn-title {
        font-size: 0.9375rem;
        font-weight: 600;
        color: var(--color-dark-bark);
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* ---- Related Articles ---- */
    .related-section {
        background-color: var(--color-bg-alt);
        padding: 80px 0;
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-top: 40px;
    }

    /* edu-article-card reused */
    .edu-article-card {
        background-color: var(--color-white);
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: var(--transition-normal);
        display: flex;
        flex-direction: column;
        text-decoration: none;
    }

    .edu-article-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-lg);
    }

    .edu-article-img-box {
        height: 180px;
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

    .edu-article-img-box.no-img {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--color-bg-alt);
        color: var(--color-muted-sand);
    }

    .edu-article-tag {
        position: absolute;
        bottom: 12px;
        left: 12px;
        background-color: var(--color-white);
        color: var(--color-dark-bark);
        padding: 3px 10px;
        border-radius: 30px;
        font-size: 0.6875rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    .edu-article-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .edu-article-meta {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }

    .edu-article-date,
    .edu-article-read-time {
        font-size: 0.75rem;
        color: var(--color-text-muted);
    }

    .edu-article-read-time::before {
        content: '·';
        margin-right: 4px;
    }

    .edu-article-title {
        font-size: 0.9375rem;
        font-weight: 600;
        color: var(--color-dark-bark);
        margin-bottom: 12px;
        line-height: 1.45;
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

    /* ---- CTA Banner ---- */
    .cta-banner-wrapper {
        padding: 60px 0 80px;
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

    /* ---- Placeholder SVG ---- */
    .placeholder-svg {
        width: 72px;
        height: 72px;
        opacity: 0.2;
    }

    /* ---- Produk Terkait ---- */
    .produk-terkait-section {
        padding: 80px 0;
        background-color: var(--color-white);
    }

    .produk-terkait-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-top: 40px;
    }

    .pt-card {
        background-color: var(--color-soft-ivory);
        border-radius: var(--border-radius-xl);
        overflow: hidden;
        border: 1.5px solid rgba(56,42,33,0.05);
        box-shadow: var(--shadow-sm);
        transition: var(--transition-normal);
        display: flex;
        flex-direction: column;
        text-decoration: none;
    }
    .pt-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-lg);
        border-color: rgba(200,106,68,0.15);
    }
    .pt-card-img-wrap {
        height: 200px;
        background-color: var(--color-soft-ivory);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    .pt-card-img-wrap.no-img { background-color: var(--color-bg-alt); }
    .pt-card-img {
        width: 68%;
        height: 84%;
        object-fit: contain;
        transition: transform 0.4s ease;
    }
    .pt-card:hover .pt-card-img { transform: scale(1.06); }
    .pt-card-badge {
        position: absolute;
        top: 12px; left: 12px;
        padding: 3px 10px;
        border-radius: var(--border-radius-round);
        font-size: 0.6875rem;
        font-weight: 700;
    }
    .pt-card-badge.best-seller { background-color: var(--color-primary); color: var(--color-white); }
    .pt-card-badge.new         { background-color: var(--color-dark-bark); color: var(--color-white); }
    .pt-placeholder-svg { width: 64px; height: 64px; opacity: 0.15; color: var(--color-dark-bark); }
    .pt-card-body {
        padding: 20px 22px 22px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .pt-card-category {
        font-size: 0.6875rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--color-primary);
        margin-bottom: 7px;
    }
    .pt-card-name {
        font-size: 1rem;
        font-weight: 700;
        color: var(--color-dark-bark);
        line-height: 1.35;
        margin-bottom: 8px;
        flex: 1;
    }
    .pt-card-desc {
        font-size: 0.8125rem;
        color: var(--color-text-muted);
        line-height: 1.6;
        margin-bottom: 16px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .pt-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding-top: 14px;
        border-top: 1px solid rgba(56,42,33,0.07);
    }
    .pt-card-price {
        font-size: 1rem;
        font-weight: 700;
        color: var(--color-dark-bark);
    }
    .pt-card-btn {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 7px 14px;
        background-color: var(--color-dark-bark);
        color: var(--color-white);
        border-radius: var(--border-radius-round);
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
        transition: var(--transition-normal);
    }
    .pt-card-btn:hover { background-color: var(--color-primary); }
    .pt-lihat-semua {
        text-align: center;
        margin-top: 36px;
    }

    /* ---- Responsive ---- */
    @media (max-width: 992px) {
        .article-main-title { font-size: 2rem; }
        .related-grid { grid-template-columns: repeat(2, 1fr); }
        .cta-banner { padding: 40px; }
        .produk-terkait-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 768px) {
        .article-page { padding: 40px 0 0; }
        .article-main-title { font-size: 1.75rem; }
        .article-hero-img-box { height: 280px; border-radius: var(--border-radius-lg); }
        .article-body { font-size: 1rem; }
        .article-body h2 { font-size: 1.375rem; }
        .author-card { flex-direction: column; align-items: center; text-align: center; padding: 28px 24px; }
        .article-nav { grid-template-columns: 1fr; }
        .article-nav-btn.next { text-align: left; }
        .cta-banner { flex-direction: column; text-align: center; padding: 36px 28px; }
        .cta-banner-icon { margin: 0 auto; }
        .produk-terkait-section { padding: 60px 0; }
    }

    @media (max-width: 576px) {
        .article-main-title { font-size: 1.5rem; }
        .byline-share { display: none; }
        .article-hero-img-box { height: 220px; }
        .callout-box { padding: 20px; }
        .article-body blockquote { padding: 20px; }
        .related-grid { grid-template-columns: 1fr; }
        .cta-banner { padding: 28px 20px; }
        .cta-banner-text h2 { font-size: 1.375rem; }
        .cta-banner-wrapper { padding: 40px 0 60px; }
        .related-section { padding: 60px 0; }
        .produk-terkait-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

    <!-- BREADCRUMB -->
    <div class="breadcrumb-bar">
        <div class="container">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <span class="breadcrumb-sep">›</span>
                <a href="{{ route('edukasi.index') }}">{{ __('edukasi.breadcrumb') }}</a>
                <span class="breadcrumb-sep">›</span>
                <span class="breadcrumb-current">{{ \Illuminate\Support\Str::limit($artikel->trans('judul'), 50) }}</span>
            </nav>
        </div>
    </div>

    <!-- ARTICLE PAGE -->
    <section class="article-page">
        <div class="container">
            <div class="article-wrap">

                <!-- Category + Read Time -->
                <div class="article-category-row">
                    <span class="article-category-badge">{{ $artikel->kategori }}</span>
                    @if($artikel->read_time ?? $artikel->readTime ?? false)
                    <span class="article-read-time-badge">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                        {{ $artikel->read_time ?? $artikel->readTime }} {{ __('common.min_read') }}
                    </span>
                    @endif
                </div>

                <!-- Title -->
                <h1 class="article-main-title">{{ $artikel->trans('judul') }}</h1>

                <!-- Byline -->
                <div class="article-byline">
                    <div class="byline-avatar">
                        <img src="{{ asset('asset/profile/foto-kang-bahri-removebg-preview.png') }}"
                             alt="{{ $artikel->penulis ?? 'Kang Bahri' }}"
                             onerror="this.style.display='none';this.parentNode.innerHTML='<svg width=\'22\' height=\'22\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'1.5\'><path d=\'M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2\'/><circle cx=\'12\' cy=\'7\' r=\'4\'/></svg>'">
                    </div>
                    <div class="byline-info">
                        <div class="byline-name">{{ $artikel->penulis ?? 'Kang Bahri' }}</div>
                        <div class="byline-date">
                            {{ $artikel->published_at
                                ? \Carbon\Carbon::parse($artikel->published_at)->isoFormat('D MMMM Y')
                                : ($artikel->tanggal
                                    ? \Carbon\Carbon::parse($artikel->tanggal)->isoFormat('D MMMM Y')
                                    : '') }}
                        </div>
                    </div>
                    <div class="byline-share">
                        <button class="share-btn" onclick="navigator.share ? navigator.share({title: document.title, url: location.href}) : navigator.clipboard.writeText(location.href)" title="{{ __('common.share') }}">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/>
                                <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Hero Image -->
                <div class="article-hero-img-box {{ $artikel->thumbnail ? '' : 'no-img' }}">
                    @if($artikel->thumbnail)
                        <img src="{{ asset('asset/artikel/'.$artikel->thumbnail) }}" alt="{{ $artikel->trans('judul') }}">
                    @else
                        <svg class="placeholder-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.8">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <polyline points="21 15 16 10 5 21"/>
                        </svg>
                    @endif
                </div>

                <!-- Article Body -->
                <div class="article-body">
                    {!! $artikel->trans('konten') !!}
                </div>

                <!-- Tags -->
                @if(($artikel->keywords ?? $artikel->tags ?? false) && count($artikel->keywords ?? $artikel->tags ?? []) > 0)
                <div class="article-tags-row">
                    <span class="tags-label">Tag:</span>
                    @foreach($artikel->keywords ?? $artikel->tags ?? [] as $tag)
                    <a href="{{ route('edukasi.index', ['q' => $tag]) }}" class="article-tag-pill">{{ $tag }}</a>
                    @endforeach
                </div>
                @endif

                <!-- Author Card -->
                <div class="author-card">
                    <div class="author-card-img">
                        <img src="{{ asset('asset/profile/foto-kang-bahri-removebg-preview.png') }}"
                             alt="{{ $artikel->penulis ?? 'Kang Bahri' }}"
                             onerror="this.style.display='none'">
                    </div>
                    <div class="author-card-info">
                        <span class="author-card-label">Ditulis oleh</span>
                        <div class="author-card-name">{{ $artikel->penulis ?? 'Kang Bahri' }}</div>
                        <p class="author-card-bio">Terapis herbal bersertifikat dengan pengalaman lebih dari 15 tahun dalam bidang pengobatan tradisional dan konsultasi kesehatan holistik. Pendiri Akar Sehat dan praktisi jamu Nusantara.</p>
                        <a href="{{ route('tentang') }}" class="btn btn-secondary" style="display:inline-flex;align-items:center;gap:6px;font-size:.875rem;">
                            {{ __('common.view_profile') }}
                        </a>
                    </div>
                </div>

                <!-- Prev / Next Navigation -->
                <nav class="article-nav">
                    @if(isset($prev) && $prev)
                    <a href="{{ route('edukasi.show', $prev->slug) }}" class="article-nav-btn prev">
                        <span class="nav-btn-label">{{ __('edukasi.prev') }}</span>
                        <span class="nav-btn-title">{{ $prev->judul }}</span>
                    </a>
                    @else
                    <div class="article-nav-btn prev disabled">
                        <span class="nav-btn-label">{{ __('edukasi.prev') }}</span>
                        <span class="nav-btn-title">Tidak ada artikel sebelumnya</span>
                    </div>
                    @endif

                    @if(isset($next) && $next)
                    <a href="{{ route('edukasi.show', $next->slug) }}" class="article-nav-btn next">
                        <span class="nav-btn-label">{{ __('edukasi.next') }}</span>
                        <span class="nav-btn-title">{{ $next->judul }}</span>
                    </a>
                    @else
                    <div class="article-nav-btn next disabled">
                        <span class="nav-btn-label">{{ __('edukasi.next') }}</span>
                        <span class="nav-btn-title">Tidak ada artikel selanjutnya</span>
                    </div>
                    @endif
                </nav>

            </div>
        </div>
    </section>

    <!-- RELATED ARTICLES -->
    @if(isset($related) && $related->count() > 0)
    <section class="related-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">{{ __('edukasi.related_title') }}</h2>
                <p class="section-desc">{{ __('edukasi.related_desc') }}</p>
            </div>
            <div class="related-grid">
                @foreach($related as $r)
                <a href="{{ route('edukasi.show', $r->slug) }}" class="edu-article-card">
                    <div class="edu-article-img-box {{ $r->thumbnail ? '' : 'no-img' }}">
                        @if($r->thumbnail)
                            <img src="{{ asset('asset/artikel/'.$r->thumbnail) }}" alt="{{ $r->judul }}" loading="lazy">
                        @else
                            <svg class="placeholder-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.8">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <polyline points="21 15 16 10 5 21"/>
                            </svg>
                        @endif
                        <span class="edu-article-tag">{{ $r->kategori }}</span>
                    </div>
                    <div class="edu-article-body">
                        <div class="edu-article-meta">
                            <span class="edu-article-date">
                                {{ $r->published_at ? \Carbon\Carbon::parse($r->published_at)->format('d M Y') : ($r->tanggal ? \Carbon\Carbon::parse($r->tanggal)->format('d M Y') : '') }}
                            </span>
                            @if($r->read_time ?? $r->readTime ?? false)
                            <span class="edu-article-read-time">{{ $r->read_time ?? $r->readTime }} menit</span>
                            @endif
                        </div>
                        <h3 class="edu-article-title">{{ $r->judul }}</h3>
                        <span class="edu-article-link">
                            {{ __('common.read') }}
                        </span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- PRODUK TERKAIT -->
    @if(isset($produkTerkait) && $produkTerkait->count() > 0)
    <section class="produk-terkait-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">{{ __('edukasi.related_products_title') }}</h2>
                <p class="section-desc">Produk herbal pilihan yang berkaitan dengan topik artikel ini.</p>
            </div>
            <div class="produk-terkait-grid">
                @foreach($produkTerkait as $p)
                <a href="{{ route('produk.show', $p->slug) }}" class="pt-card">
                    <div class="pt-card-img-wrap {{ $p->foto ? '' : 'no-img' }}">
                        @if($p->foto)
                            <img class="pt-card-img" src="{{ asset('asset/produk/'.$p->foto) }}" alt="{{ $p->nama }}" loading="lazy">
                        @else
                            <svg class="pt-placeholder-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.8">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <polyline points="21 15 16 10 5 21"/>
                            </svg>
                        @endif
                        @if(isset($p->is_best_seller) && $p->is_best_seller)
                            <span class="pt-card-badge best-seller">{{ __('common.best_seller') }}</span>
                        @elseif(isset($p->is_new) && $p->is_new)
                            <span class="pt-card-badge new">{{ __('common.new') }}</span>
                        @endif
                    </div>
                    <div class="pt-card-body">
                        <div class="pt-card-category">{{ $p->kategori }}</div>
                        <div class="pt-card-name">{{ $p->nama }}</div>
                        <p class="pt-card-desc">{{ $p->deskripsi }}</p>
                        <div class="pt-card-footer">
                            <span class="pt-card-price">Rp {{ number_format($p->harga, 0, ',', '.') }}</span>
                            <span class="pt-card-btn">{{ __('common.view_detail') }} →</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            <div class="pt-lihat-semua">
                <a href="{{ route('produk.index') }}" class="btn btn-secondary">{{ __('common.see_all_products') }}</a>
            </div>
        </div>
    </section>
    @endif

    <!-- CTA BANNER -->
    <div class="container cta-banner-wrapper">
        <div class="cta-banner">
            <div class="cta-banner-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
            </div>
            <div class="cta-banner-text">
                <h2>{{ __('edukasi.cta_title') }}</h2>
                <p>{{ __('edukasi.show_cta_desc') }}</p>
            </div>
            <a href="https://wa.me/{{ $siteSettings['wa_number'] ?? '6281234567890' }}?text={{ rawurlencode('Halo Kang Bahri, saya membaca artikel "'.$artikel->trans('judul').'" dan ingin konsultasi lebih lanjut. Apakah bisa?') }}"
               target="_blank" class="btn btn-primary btn--large" style="white-space: nowrap; flex-shrink: 0;">
                {{ __('common.consult_now') }}
            </a>
        </div>
    </div>

@endsection
