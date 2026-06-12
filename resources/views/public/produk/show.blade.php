@extends('layouts.public')

@section('title', $produk->trans('nama') . ' — Akar Sehat')
@section('meta_desc', \Illuminate\Support\Str::limit($produk->trans('deskripsi'), 160))

@push('styles')
<style>
    /* ================================================================
       PAGE-SPECIFIC: Product Detail Page
    ================================================================ */

    /* ---- Breadcrumb ---- */
    .breadcrumb-bar {
        background-color: var(--color-white);
        border-bottom: 1px solid rgba(56,42,33,0.06);
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
    .breadcrumb a { color: var(--color-text-muted); transition: var(--transition-fast); }
    .breadcrumb a:hover { color: var(--color-primary); }
    .breadcrumb-sep { opacity: 0.4; font-size: 0.6875rem; }
    .breadcrumb-current {
        color: var(--color-dark-bark);
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 240px;
    }

    /* ---- Main Product Section ---- */
    .detail-section {
        padding: 56px 0 0;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 64px;
        align-items: flex-start;
    }

    /* ---- Left: Image Panel ---- */
    .detail-img-panel {
        position: sticky;
        top: 90px;
    }

    .detail-main-img-box {
        background-color: var(--color-soft-ivory);
        border-radius: var(--border-radius-xl);
        height: 440px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
        border: 1.5px solid rgba(56,42,33,0.05);
    }

    .detail-main-img-box img {
        width: 72%;
        height: 88%;
        object-fit: contain;
        transition: transform 0.45s ease;
    }

    .detail-main-img-box:hover img {
        transform: scale(1.05);
    }

    .detail-main-img-box.no-img {
        background-color: var(--color-bg-alt);
    }

    .detail-placeholder-svg {
        width: 110px;
        height: 110px;
        opacity: 0.15;
        color: var(--color-dark-bark);
    }

    .detail-badge {
        position: absolute;
        top: 18px;
        left: 18px;
        padding: 5px 14px;
        border-radius: var(--border-radius-round);
        font-size: 0.6875rem;
        font-weight: 700;
        letter-spacing: 0.3px;
    }
    .detail-badge.best-seller { background-color: var(--color-primary); color: var(--color-white); }
    .detail-badge.new         { background-color: var(--color-dark-bark); color: var(--color-white); }

    /* Thumbnail strip */
    .detail-thumbnails {
        display: flex;
        gap: 12px;
        margin-top: 16px;
    }

    .detail-thumb {
        width: 76px;
        height: 76px;
        border-radius: var(--border-radius-md);
        background-color: var(--color-soft-ivory);
        border: 2px solid rgba(56,42,33,0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        overflow: hidden;
        transition: var(--transition-normal);
        flex-shrink: 0;
    }
    .detail-thumb.active { border-color: var(--color-primary); }
    .detail-thumb:hover  { border-color: var(--color-primary); }
    .detail-thumb img {
        width: 80%;
        height: 80%;
        object-fit: contain;
    }

    /* Trust strip below image */
    .img-trust-strip {
        display: flex;
        gap: 0;
        margin-top: 24px;
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        border: 1px solid rgba(56,42,33,0.08);
    }
    .img-trust-item {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        padding: 14px 8px;
        background-color: var(--color-white);
        border-right: 1px solid rgba(56,42,33,0.07);
        text-align: center;
    }
    .img-trust-item:last-child { border-right: none; }
    .img-trust-item svg { color: var(--color-primary); }
    .img-trust-item span {
        font-size: 0.6875rem;
        font-weight: 600;
        color: var(--color-dark-bark);
        line-height: 1.3;
    }

    /* ---- Right: Info Panel ---- */
    .detail-info-panel {}

    .detail-category-row {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 14px;
    }

    .detail-category-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 14px;
        background-color: rgba(200,106,68,0.1);
        color: var(--color-primary);
        border-radius: var(--border-radius-round);
        font-size: 0.6875rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .detail-stock {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.8125rem;
        font-weight: 500;
        color: #2e7d32;
    }
    .detail-stock::before {
        content: '';
        display: inline-block;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background-color: #4caf50;
    }

    .detail-product-name {
        font-size: 2rem;
        font-weight: 700;
        color: var(--color-dark-bark);
        line-height: 1.25;
        margin-bottom: 16px;
    }

    /* Rating */
    .detail-rating {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 24px;
    }
    .stars {
        display: flex;
        gap: 2px;
    }
    .star {
        font-size: 0.875rem;
        color: #FFB800;
    }
    .rating-count {
        font-size: 0.8125rem;
        color: var(--color-text-muted);
    }
    .rating-divider {
        width: 1px;
        height: 14px;
        background-color: rgba(56,42,33,0.15);
    }
    .sold-count {
        font-size: 0.8125rem;
        color: var(--color-text-muted);
    }

    /* Price */
    .detail-price-block {
        background-color: var(--color-bg-alt);
        border-radius: var(--border-radius-lg);
        padding: 20px 24px;
        margin-bottom: 24px;
    }
    .detail-price-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--color-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }
    .detail-price {
        font-size: 2rem;
        font-weight: 700;
        color: var(--color-primary);
        line-height: 1;
    }
    .detail-price-note {
        font-size: 0.8125rem;
        color: var(--color-text-muted);
        margin-top: 6px;
    }

    /* Short desc */
    .detail-short-desc {
        font-size: 0.9375rem;
        color: var(--color-text-muted);
        line-height: 1.7;
        margin-bottom: 24px;
        padding-bottom: 24px;
        border-bottom: 1px solid rgba(56,42,33,0.08);
    }

    /* Benefits */
    .detail-benefits-title {
        font-size: 0.875rem;
        font-weight: 700;
        color: var(--color-dark-bark);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 14px;
    }
    .detail-benefits-list {
        list-style: none;
        margin-bottom: 28px;
    }
    .detail-benefits-list li {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 0.9375rem;
        color: var(--color-text-main);
        margin-bottom: 10px;
        line-height: 1.5;
    }
    .benefit-check {
        width: 20px;
        height: 20px;
        background-color: rgba(200,106,68,0.12);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 1px;
        color: var(--color-primary);
    }

    /* Quantity + Order */
    .order-block {
        border-top: 1px solid rgba(56,42,33,0.08);
        padding-top: 24px;
    }

    .quantity-row {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 16px;
    }
    .quantity-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--color-dark-bark);
        min-width: 60px;
    }
    .quantity-ctrl {
        display: flex;
        align-items: center;
        gap: 0;
        border: 1.5px solid rgba(56,42,33,0.12);
        border-radius: var(--border-radius-round);
        overflow: hidden;
    }
    .qty-btn {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1.25rem;
        color: var(--color-dark-bark);
        font-family: var(--font-primary);
        transition: var(--transition-fast);
        line-height: 1;
    }
    .qty-btn:hover { background-color: var(--color-bg-alt); color: var(--color-primary); }
    .qty-value {
        width: 44px;
        text-align: center;
        font-size: 0.9375rem;
        font-weight: 600;
        color: var(--color-dark-bark);
        border-left: 1px solid rgba(56,42,33,0.1);
        border-right: 1px solid rgba(56,42,33,0.1);
        padding: 8px 0;
        line-height: 1.4;
    }
    .qty-total {
        font-size: 0.875rem;
        color: var(--color-text-muted);
    }
    .qty-total strong {
        color: var(--color-dark-bark);
        font-weight: 700;
    }

    /* WhatsApp Order Button */
    .btn-wa-order {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        padding: 16px 28px;
        background-color: #25D366;
        color: #fff;
        border-radius: var(--border-radius-round);
        font-family: var(--font-primary);
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: var(--transition-normal);
        text-decoration: none;
        margin-bottom: 12px;
        letter-spacing: 0.2px;
    }
    .btn-wa-order:hover {
        background-color: #1ebc5a;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(37,211,102,0.35);
        color: #fff;
    }
    .btn-wa-order svg { flex-shrink: 0; }

    .btn-konsultasi {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 14px 28px;
        background-color: transparent;
        color: var(--color-dark-bark);
        border: 1.5px solid rgba(56,42,33,0.2);
        border-radius: var(--border-radius-round);
        font-family: var(--font-primary);
        font-size: 0.9375rem;
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition-normal);
        text-decoration: none;
    }
    .btn-konsultasi:hover {
        border-color: var(--color-primary);
        color: var(--color-primary);
        background-color: rgba(200,106,68,0.04);
    }

    /* Sticky WA Button (mobile only) */
    .sticky-wa {
        display: none;
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 200;
        padding: 14px 20px;
        background-color: var(--color-white);
        border-top: 1px solid rgba(56,42,33,0.08);
        box-shadow: 0 -4px 20px rgba(56,42,33,0.08);
    }
    .sticky-wa-inner {
        display: flex;
        gap: 12px;
        align-items: center;
    }
    .sticky-wa-price { flex: 1; }
    .sticky-wa-price .label {
        font-size: 0.6875rem;
        color: var(--color-text-muted);
        font-weight: 500;
    }
    .sticky-wa-price .value {
        font-size: 1.0625rem;
        font-weight: 700;
        color: var(--color-dark-bark);
    }
    .sticky-wa-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 13px 28px;
        background-color: #25D366;
        color: #fff;
        border-radius: var(--border-radius-round);
        font-family: var(--font-primary);
        font-size: 0.9375rem;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: var(--transition-normal);
        text-decoration: none;
        white-space: nowrap;
    }
    .sticky-wa-btn:hover { background-color: #1ebc5a; color: #fff; }

    /* ================================================================
       Detail Tabs
    ================================================================ */
    .detail-tabs-section {
        padding: 64px 0 0;
    }

    .tabs-nav {
        display: flex;
        gap: 0;
        border-bottom: 2px solid rgba(56,42,33,0.08);
        margin-bottom: 40px;
        overflow-x: auto;
    }

    .tab-btn {
        padding: 14px 28px;
        font-family: var(--font-primary);
        font-size: 0.9375rem;
        font-weight: 500;
        color: var(--color-text-muted);
        background: none;
        border: none;
        cursor: pointer;
        border-bottom: 2px solid transparent;
        margin-bottom: -2px;
        transition: var(--transition-fast);
        white-space: nowrap;
    }
    .tab-btn:hover { color: var(--color-primary); }
    .tab-btn.active {
        color: var(--color-primary);
        font-weight: 600;
        border-bottom-color: var(--color-primary);
    }

    .tab-panel { display: none; }
    .tab-panel.active { display: block; }

    /* Deskripsi */
    .tab-deskripsi { max-width: 780px; }
    .tab-deskripsi p {
        font-size: 1rem;
        color: var(--color-text-main);
        line-height: 1.8;
        margin-bottom: 20px;
    }
    .tab-deskripsi h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--color-dark-bark);
        margin: 32px 0 14px;
    }
    .tab-deskripsi ul {
        list-style: none;
        margin-bottom: 20px;
    }
    .tab-deskripsi ul li {
        position: relative;
        padding-left: 20px;
        margin-bottom: 10px;
        font-size: 0.9375rem;
        color: var(--color-text-main);
        line-height: 1.6;
    }
    .tab-deskripsi ul li::before {
        content: '';
        position: absolute;
        left: 0;
        top: 9px;
        width: 7px;
        height: 7px;
        background-color: var(--color-primary);
        border-radius: 50%;
    }

    /* Kandungan table */
    .ingredients-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9375rem;
        max-width: 600px;
    }
    .ingredients-table th {
        text-align: left;
        padding: 12px 16px;
        background-color: var(--color-bg-alt);
        color: var(--color-dark-bark);
        font-weight: 600;
        font-size: 0.8125rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .ingredients-table th:first-child { border-radius: var(--border-radius-sm) 0 0 0; }
    .ingredients-table th:last-child  { border-radius: 0 var(--border-radius-sm) 0 0; }
    .ingredients-table td {
        padding: 12px 16px;
        color: var(--color-text-main);
        border-bottom: 1px solid rgba(56,42,33,0.06);
    }
    .ingredients-table tr:last-child td { border-bottom: none; }
    .ingredients-table tr:nth-child(even) td { background-color: rgba(56,42,33,0.015); }

    /* Cara Pakai */
    .cara-pakai-steps { max-width: 640px; }
    .step-item {
        display: flex;
        gap: 20px;
        align-items: flex-start;
        margin-bottom: 28px;
    }
    .step-number {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: var(--color-primary);
        color: var(--color-white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9375rem;
        flex-shrink: 0;
    }
    .step-content h4 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--color-dark-bark);
        margin-bottom: 5px;
    }
    .step-content p {
        font-size: 0.9375rem;
        color: var(--color-text-muted);
        line-height: 1.65;
    }

    .warning-box {
        display: flex;
        gap: 14px;
        align-items: flex-start;
        background-color: rgba(200,106,68,0.06);
        border: 1px solid rgba(200,106,68,0.2);
        border-radius: var(--border-radius-lg);
        padding: 20px 24px;
        margin-top: 32px;
    }
    .warning-box svg { color: var(--color-primary); flex-shrink: 0; margin-top: 1px; }
    .warning-box p {
        font-size: 0.875rem;
        color: var(--color-text-muted);
        line-height: 1.65;
    }
    .warning-box p strong { color: var(--color-dark-bark); }

    /* Testimoni */
    .testi-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }
    .testi-card {
        background-color: var(--color-white);
        border-radius: var(--border-radius-lg);
        padding: 24px;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(56,42,33,0.04);
    }
    .testi-card-stars {
        display: flex;
        gap: 2px;
        margin-bottom: 12px;
    }
    .testi-card-stars span { font-size: 0.875rem; color: #FFB800; }
    .testi-card-text {
        font-size: 0.9375rem;
        color: var(--color-text-main);
        line-height: 1.7;
        font-style: italic;
        margin-bottom: 18px;
    }
    .testi-card-user {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .testi-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background-color: var(--color-muted-sand);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.875rem;
        color: var(--color-primary-dark);
        flex-shrink: 0;
    }
    .testi-user-name {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--color-dark-bark);
    }
    .testi-user-loc {
        font-size: 0.75rem;
        color: var(--color-text-muted);
    }
    .testi-verified {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.6875rem;
        font-weight: 600;
        color: #2e7d32;
        background-color: rgba(76,175,80,0.1);
        padding: 2px 8px;
        border-radius: 20px;
        margin-top: 4px;
    }

    /* ================================================================
       Related Products
    ================================================================ */
    .related-section {
        background-color: var(--color-bg-alt);
        padding: 80px 0;
        margin-top: 80px;
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-top: 40px;
    }

    /* Reuse produk-card from listing page */
    .produk-card {
        background-color: var(--color-white);
        border-radius: var(--border-radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: var(--transition-normal);
        display: flex;
        flex-direction: column;
        border: 1.5px solid rgba(56,42,33,0.04);
        text-decoration: none;
    }
    .produk-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-lg);
        border-color: rgba(200,106,68,0.12);
    }
    .produk-card-img-wrap {
        position: relative;
        background-color: var(--color-soft-ivory);
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .produk-card-img {
        width: 70%;
        height: 80%;
        object-fit: contain;
        transition: transform 0.4s ease;
    }
    .produk-card:hover .produk-card-img { transform: scale(1.06); }
    .produk-card-img-wrap.no-img { background-color: var(--color-bg-alt); }
    .produk-placeholder-svg { width: 60px; height: 60px; opacity: 0.18; }
    .produk-badge {
        position: absolute;
        top: 12px; left: 12px;
        padding: 3px 10px;
        border-radius: var(--border-radius-round);
        font-size: 0.6875rem;
        font-weight: 700;
    }
    .produk-badge.best-seller { background-color: var(--color-primary); color: var(--color-white); }
    .produk-badge.new         { background-color: var(--color-dark-bark); color: var(--color-white); }
    .produk-card-body { padding: 20px; display: flex; flex-direction: column; flex: 1; }
    .produk-card-category {
        font-size: 0.6875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--color-primary);
        margin-bottom: 8px;
    }
    .produk-card-name {
        font-size: 1rem;
        font-weight: 700;
        color: var(--color-dark-bark);
        margin-bottom: 12px;
        line-height: 1.35;
        flex: 1;
    }
    .produk-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding-top: 14px;
        border-top: 1px solid rgba(56,42,33,0.07);
    }
    .produk-card-price { font-size: 1rem; font-weight: 700; color: var(--color-dark-bark); }
    .produk-card-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 8px 16px;
        background-color: var(--color-dark-bark);
        color: var(--color-white);
        border-radius: var(--border-radius-round);
        font-size: 0.75rem;
        font-weight: 600;
        transition: var(--transition-normal);
        text-decoration: none;
        white-space: nowrap;
    }
    .produk-card-btn:hover { background-color: var(--color-primary); color: var(--color-white); }

    /* ================================================================
       Responsive
    ================================================================ */
    @media (max-width: 992px) {
        .detail-grid { grid-template-columns: 1fr; gap: 40px; }
        .detail-img-panel { position: static; }
        .detail-main-img-box { height: 360px; }
        .testi-grid { grid-template-columns: repeat(2, 1fr); }
        .related-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 768px) {
        .detail-section { padding: 36px 0 0; }
        .detail-main-img-box { height: 300px; }
        .detail-product-name { font-size: 1.625rem; }
        .detail-price { font-size: 1.625rem; }
        .testi-grid { grid-template-columns: 1fr; }
        .tab-btn { padding: 12px 18px; font-size: 0.875rem; }
        .sticky-wa { display: block; }
        .detail-tabs-section { padding-bottom: 100px; }
    }

    @media (max-width: 576px) {
        .detail-product-name { font-size: 1.375rem; }
        .detail-main-img-box { height: 260px; }
        .img-trust-strip { display: none; }
        .related-grid { grid-template-columns: 1fr; }
        .related-section { padding: 60px 0; margin-top: 60px; }
        .detail-thumbnails { gap: 8px; }
        .detail-thumb { width: 60px; height: 60px; }
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
                <a href="{{ route('produk.index') }}">Produk</a>
                <span class="breadcrumb-sep">›</span>
                <span class="breadcrumb-current">{{ $produk->trans('nama') }}</span>
            </nav>
        </div>
    </div>

    <!-- PRODUCT MAIN -->
    <section class="detail-section">
        <div class="container">
            <div class="detail-grid">

                <!-- LEFT: Image -->
                <div class="detail-img-panel">
                    <div class="detail-main-img-box {{ $produk->foto ? '' : 'no-img' }}" id="main-img-box">
                        @if($produk->foto)
                            <img src="{{ asset('storage/'.$produk->foto) }}" id="main-img" alt="{{ $produk->trans('nama') }}">
                        @else
                            <svg class="detail-placeholder-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.7">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <polyline points="21 15 16 10 5 21"/>
                            </svg>
                        @endif
                        @if($produk->status === 'Tersedia')
                            {{-- no badge for regular --}}
                        @endif
                        @if(isset($produk->is_best_seller) && $produk->is_best_seller)
                            <span class="detail-badge best-seller">{{ __('common.best_seller') }}</span>
                        @elseif(isset($produk->is_new) && $produk->is_new)
                            <span class="detail-badge new">{{ __('common.new') }}</span>
                        @endif
                    </div>

                    @if($produk->foto)
                    <div class="detail-thumbnails">
                        <div class="detail-thumb active" data-src="{{ asset('storage/'.$produk->foto) }}">
                            <img src="{{ asset('storage/'.$produk->foto) }}" alt="{{ $produk->trans('nama') }}">
                        </div>
                    </div>
                    @endif

                    <div class="img-trust-strip">
                        <div class="img-trust-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            <span>{{ __('produk.detail_trust1') }}</span>
                        </div>
                        <div class="img-trust-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <span>{{ __('produk.detail_trust2') }}</span>
                        </div>
                        <div class="img-trust-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.62 3.42 2 2 0 0 1 3.6 1.25h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.91a16 16 0 0 0 6 6l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.73 16.92z"/></svg>
                            <span>{{ __('produk.detail_trust3') }}</span>
                        </div>
                        <div class="img-trust-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            <span>{{ __('produk.detail_trust4') }}</span>
                        </div>
                    </div>
                </div>

                <!-- RIGHT: Info -->
                <div class="detail-info-panel">
                    <div class="detail-category-row">
                        <span class="detail-category-badge">{{ $produk->kategori }}</span>
                        <span class="detail-stock">{{ $produk->status ?? 'Tersedia' }}</span>
                    </div>

                    <h1 class="detail-product-name">{{ $produk->trans('nama') }}</h1>

                    <div class="detail-rating">
                        <div class="stars">
                            <span class="star">★</span><span class="star">★</span><span class="star">★</span>
                            <span class="star">★</span><span class="star" style="opacity:.5">★</span>
                        </div>
                        <span class="rating-count">4.8 ({{ __('produk.buyer_reviews') }})</span>
                        <span class="rating-divider"></span>
                        <span class="sold-count">{{ __('produk.sold') }}</span>
                    </div>

                    <div class="detail-price-block">
                        <div class="detail-price-label">{{ __('common.price') }}</div>
                        <div class="detail-price" id="display-price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>
                        <div class="detail-price-note">{{ __('common.price_per_bottle') }}</div>
                    </div>

                    <p class="detail-short-desc">{{ $produk->trans('deskripsi') }}</p>

                    @if($produk->kandungan && count($produk->kandungan) > 0)
                    <div class="detail-benefits-title">{{ __('produk.main_ingredients') }}</div>
                    <ul class="detail-benefits-list">
                        @foreach($produk->kandungan as $k)
                        <li>
                            <span class="benefit-check">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                            </span>
                            {{ is_array($k) ? ($k['name'] ?? $k) : $k }}
                        </li>
                        @endforeach
                    </ul>
                    @endif

                    <!-- Order Block -->
                    <div class="order-block">
                        <div class="quantity-row">
                            <span class="quantity-label">{{ __('common.quantity') }}</span>
                            <div class="quantity-ctrl">
                                <button class="qty-btn" id="qty-minus" aria-label="Kurangi">−</button>
                                <div class="qty-value" id="qty-value">1</div>
                                <button class="qty-btn" id="qty-plus" aria-label="Tambah">+</button>
                            </div>
                            <span class="qty-total" id="qty-total">Total: <strong>Rp {{ number_format($produk->harga, 0, ',', '.') }}</strong></span>
                        </div>

                        <a href="{{ 'https://wa.me/'.($siteSettings['wa_number'] ?? '6281234567890').'?text='.rawurlencode('Halo Kang Bahri, saya ingin memesan: *'.$produk->trans('nama').'* (1 pcs). Mohon info ketersediaan dan cara pembayarannya. Terima kasih 🙏') }}"
                           target="_blank" id="wa-order-btn" class="btn-wa-order">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            {{ __('common.order_wa') }}
                        </a>

                        <a href="{{ 'https://wa.me/'.($siteSettings['wa_number'] ?? '6281234567890').'?text='.rawurlencode('Halo Kang Bahri, saya ingin bertanya tentang produk '.$produk->trans('nama').' sebelum memesan. Boleh konsultasi dulu?') }}"
                           target="_blank" class="btn-konsultasi">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                            </svg>
                            {{ __('common.consult_first') }}
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- DETAIL TABS -->
    <section class="detail-tabs-section">
        <div class="container">
            <div class="tabs-nav">
                <button class="tab-btn active" data-tab="deskripsi"  onclick="switchTab('deskripsi')">{{ __('produk.tab_desc') }}</button>
                <button class="tab-btn"         data-tab="kandungan" onclick="switchTab('kandungan')">{{ __('produk.tab_ingredients') }}</button>
                <button class="tab-btn"         data-tab="cara-pakai" onclick="switchTab('cara-pakai')">{{ __('produk.tab_how_to_use') }}</button>
                <button class="tab-btn"         data-tab="testimoni" onclick="switchTab('testimoni')">{{ __('produk.tab_review') }}</button>
            </div>

            <!-- Deskripsi -->
            <div class="tab-panel active" id="tab-deskripsi">
                <div class="tab-deskripsi">
                    {!! $produk->deskripsi_lengkap ?? '<p>'.$produk->trans('deskripsi').'</p>' !!}
                </div>
            </div>

            <!-- Kandungan -->
            <div class="tab-panel" id="tab-kandungan">
                <p style="font-size:.9375rem;color:var(--color-text-muted);margin-bottom:24px;">{{ __('produk.ingredients_intro') }}</p>
                @if($produk->kandungan && count($produk->kandungan) > 0)
                <table class="ingredients-table">
                    <thead>
                        <tr><th>{{ __('produk.ingredients_col1') }}</th><th>{{ __('produk.ingredients_col2') }}</th><th>{{ __('produk.ingredients_col3') }}</th></tr>
                    </thead>
                    <tbody>
                        @foreach($produk->kandungan as $k)
                        <tr>
                            @if(is_array($k))
                                <td>{{ $k['name'] ?? $k['bahan'] ?? '-' }}</td>
                                <td>{{ $k['amount'] ?? $k['jumlah'] ?? '-' }}</td>
                                <td>{{ $k['benefit'] ?? $k['manfaat'] ?? '-' }}</td>
                            @else
                                <td colspan="3">{{ $k }}</td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <p style="font-size:.8125rem;color:var(--color-text-muted);margin-top:20px;">{{ __('produk.ingredients_note') }}</p>
                @else
                <p style="color:var(--color-text-muted);">{{ __('produk.ingredients_empty') }}</p>
                @endif
            </div>

            <!-- Cara Pakai -->
            <div class="tab-panel" id="tab-cara-pakai">
                <div class="cara-pakai-steps">
                    @if($produk->trans('cara_pakai'))
                        @foreach(array_filter(array_map('trim', preg_split('/\n|\r\n/', $produk->trans('cara_pakai')))) as $i => $step)
                        <div class="step-item">
                            <div class="step-number">{{ $i + 1 }}</div>
                            <div class="step-content">
                                <h4>{{ __('common.step') }} {{ $i + 1 }}</h4>
                                <p>{{ $step }}</p>
                            </div>
                        </div>
                        @endforeach
                    @else
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <h4>{{ __('produk.default_step_title') }}</h4>
                            <p>{{ __('produk.default_step_desc') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
                @if($produk->peringatan ?? false)
                <div class="warning-box">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                        <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                    <p><strong>{{ __('produk.caution') }} </strong>{{ $produk->peringatan }}</p>
                </div>
                @endif
            </div>

            <!-- Testimoni -->
            <div class="tab-panel" id="tab-testimoni">
                @if(isset($produk->testimoni) && count($produk->testimoni) > 0)
                <div class="testi-grid">
                    @foreach($produk->testimoni as $t)
                    <div class="testi-card">
                        <div class="testi-card-stars">
                            @for($i = 0; $i < ($t['rating'] ?? 5); $i++)<span>★</span>@endfor
                        </div>
                        <p class="testi-card-text">"{{ $t['text'] ?? $t }}"</p>
                        <div class="testi-card-user">
                            <div class="testi-avatar">{{ strtoupper(substr($t['name'] ?? 'U', 0, 1)) }}</div>
                            <div>
                                <div class="testi-user-name">{{ $t['name'] ?? 'Pengguna' }}</div>
                                <div class="testi-user-loc">{{ $t['loc'] ?? '' }}</div>
                                <span class="testi-verified">
                                    <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                    Pembeli Terverifikasi
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p style="color:var(--color-text-muted);font-size:.9375rem;">Belum ada testimoni untuk produk ini.</p>
                @endif
            </div>
        </div>
    </section>

    <!-- RELATED PRODUCTS -->
    @if(isset($related) && $related->count() > 0)
    <section class="related-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">{{ __('produk.related_title') }}</h2>
                <p class="section-desc">{{ __('produk.related_desc') }}</p>
            </div>
            <div class="related-grid">
                @foreach($related as $r)
                <a href="{{ route('produk.show', $r->slug) }}" class="produk-card">
                    <div class="produk-card-img-wrap {{ $r->foto ? '' : 'no-img' }}">
                        @if($r->foto)
                            <img class="produk-card-img" src="{{ asset('storage/'.$r->foto) }}" alt="{{ $r->nama }}" loading="lazy">
                        @else
                            <svg class="produk-placeholder-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.8"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        @endif
                        @if(isset($r->is_best_seller) && $r->is_best_seller)
                            <span class="produk-badge best-seller">{{ __('common.best_seller') }}</span>
                        @elseif(isset($r->is_new) && $r->is_new)
                            <span class="produk-badge new">{{ __('common.new') }}</span>
                        @endif
                    </div>
                    <div class="produk-card-body">
                        <span class="produk-card-category">{{ $r->kategori }}</span>
                        <h3 class="produk-card-name">{{ $r->nama }}</h3>
                        <div class="produk-card-footer">
                            <span class="produk-card-price">Rp {{ number_format($r->harga, 0, ',', '.') }}</span>
                            <span class="produk-card-btn">{{ __('common.view_detail') }} →</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- STICKY WA BUTTON (mobile) -->
    <div class="sticky-wa" id="sticky-wa">
        <div class="sticky-wa-inner">
            <div class="sticky-wa-price">
                <div class="label">Total Harga</div>
                <div class="value" id="sticky-price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>
            </div>
            <a href="{{ 'https://wa.me/'.($siteSettings['wa_number'] ?? '6281234567890').'?text='.rawurlencode('Halo Kang Bahri, saya ingin memesan: *'.$produk->trans('nama').'*. Mohon info ketersediaan. Terima kasih!') }}"
               id="sticky-wa-btn" target="_blank" class="sticky-wa-btn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                {{ __('common.order_wa') }}
            </a>
        </div>
    </div>

@endsection

@push('scripts')
<script>
(function() {
    var produkHarga = {{ $produk->harga }};
    var produkNama  = {{ json_encode($produk->trans('nama')) }};
    var waNumber    = "{{ $siteSettings['wa_number'] ?? '6281234567890' }}";
    var currentQty  = 1;

    function formatPrice(n) {
        return 'Rp ' + n.toLocaleString('id-ID');
    }

    function buildWALink(qty) {
        var total = formatPrice(produkHarga * qty);
        var msg   = 'Halo Kang Bahri, saya ingin memesan:\n\n*' + produkNama + '*\nJumlah: ' + qty + ' pcs\nTotal: ' + total + '\n\nMohon info ketersediaan dan cara pembayarannya. Terima kasih 🙏';
        return 'https://wa.me/' + waNumber + '?text=' + encodeURIComponent(msg);
    }

    function updateQty(delta) {
        currentQty = Math.max(1, currentQty + delta);
        var qtyValue  = document.getElementById('qty-value');
        var qtyTotal  = document.getElementById('qty-total');
        var waBtn     = document.getElementById('wa-order-btn');
        var stickyBtn = document.getElementById('sticky-wa-btn');
        var stickyPr  = document.getElementById('sticky-price');

        if (qtyValue) qtyValue.textContent = currentQty;
        if (qtyTotal) qtyTotal.innerHTML = 'Total: <strong>' + formatPrice(produkHarga * currentQty) + '</strong>';
        var link = buildWALink(currentQty);
        if (waBtn)     waBtn.href     = link;
        if (stickyBtn) stickyBtn.href = link;
        if (stickyPr)  stickyPr.textContent = formatPrice(produkHarga * currentQty);
    }

    var minusBtn = document.getElementById('qty-minus');
    var plusBtn  = document.getElementById('qty-plus');
    if (minusBtn) minusBtn.addEventListener('click', function() { updateQty(-1); });
    if (plusBtn)  plusBtn.addEventListener('click',  function() { updateQty(+1); });

    // Thumbnail switcher
    document.querySelectorAll('.detail-thumb').forEach(function(thumb) {
        thumb.addEventListener('click', function() {
            document.querySelectorAll('.detail-thumb').forEach(function(t) { t.classList.remove('active'); });
            thumb.classList.add('active');
            var mainImg = document.getElementById('main-img');
            if (mainImg) mainImg.src = thumb.dataset.src;
        });
    });

    // Sticky WA — show when order block scrolls out
    var stickyEl = document.getElementById('sticky-wa');
    if (stickyEl) {
        window.addEventListener('scroll', function() {
            var orderBlock = document.querySelector('.order-block');
            if (!orderBlock) return;
            var rect = orderBlock.getBoundingClientRect();
            stickyEl.style.display = (rect.bottom < 0) ? 'block' : 'none';
        }, { passive: true });
    }
})();

// Tab switching
function switchTab(tabId) {
    document.querySelectorAll('.tab-btn').forEach(function(b) {
        b.classList.toggle('active', b.dataset.tab === tabId);
    });
    document.querySelectorAll('.tab-panel').forEach(function(p) {
        p.classList.toggle('active', p.id === 'tab-' + tabId);
    });
}
</script>
@endpush
