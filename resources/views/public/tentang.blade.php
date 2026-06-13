@extends('layouts.public')

@section('title', __('tentang.page_title'))
@section('meta_desc', $settings['hero_desc'] ?? __('tentang.page_title'))

@push('styles')
<style>
    /* ================================================================
       PAGE-SPECIFIC: Tentang Akar Sehat
    ================================================================ */

    /* ---- Hero ---- */
    .tentang-hero {
        background-color: var(--color-dark-bark);
        padding: 110px 0 90px;
        position: relative;
        overflow: hidden;
    }
    .tentang-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle at 20% 50%, rgba(200,106,68,0.18) 0%, transparent 55%),
                          radial-gradient(circle at 80% 20%, rgba(200,106,68,0.1) 0%, transparent 45%);
    }
    .tentang-hero-inner {
        position: relative;
        z-index: 1;
        max-width: 760px;
    }
    .tentang-hero-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background-color: rgba(200,106,68,0.18);
        color: var(--color-primary);
        border: 1px solid rgba(200,106,68,0.3);
        border-radius: var(--border-radius-round);
        padding: 6px 18px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        margin-bottom: 24px;
    }
    .tentang-hero h1 {
        font-size: 3rem;
        font-weight: 700;
        color: var(--color-white);
        line-height: 1.2;
        margin-bottom: 20px;
    }
    .tentang-hero h1 em {
        font-style: normal;
        color: var(--color-primary);
    }
    .tentang-hero p {
        font-size: 1.125rem;
        color: rgba(255,255,255,0.7);
        line-height: 1.75;
        max-width: 600px;
    }
    .tentang-hero-stats {
        display: flex;
        gap: 48px;
        margin-top: 48px;
        flex-wrap: wrap;
    }
    .hero-stat-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .hero-stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--color-white);
        line-height: 1;
    }
    .hero-stat-value span { color: var(--color-primary); }
    .hero-stat-label {
        font-size: 0.8125rem;
        color: rgba(255,255,255,0.5);
        font-weight: 400;
    }

    /* ---- Tentang Section ---- */
    .tentang-intro {
        padding: 88px 0;
    }
    .tentang-intro-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 80px;
        align-items: center;
    }
    .tentang-intro-text .section-label {
        display: inline-block;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: var(--color-primary);
        margin-bottom: 14px;
    }
    .tentang-intro-text h2 {
        font-size: 2.25rem;
        font-weight: 700;
        color: var(--color-dark-bark);
        line-height: 1.25;
        margin-bottom: 20px;
    }
    .tentang-intro-text p {
        font-size: 1rem;
        color: var(--color-text-muted);
        line-height: 1.8;
        margin-bottom: 18px;
    }
    .tentang-intro-text p:last-child { margin-bottom: 0; }

    .tentang-values {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    .value-card {
        display: flex;
        gap: 18px;
        align-items: flex-start;
        background-color: var(--color-white);
        border-radius: var(--border-radius-lg);
        padding: 22px 24px;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(56,42,33,0.05);
        transition: var(--transition-normal);
    }
    .value-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateX(4px);
    }
    .value-icon {
        width: 46px;
        height: 46px;
        border-radius: var(--border-radius-md);
        background-color: rgba(200,106,68,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: var(--color-primary);
    }
    .value-text h4 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--color-dark-bark);
        margin-bottom: 5px;
    }
    .value-text p {
        font-size: 0.875rem;
        color: var(--color-text-muted);
        line-height: 1.6;
        margin: 0;
    }

    /* ---- Visi Misi ---- */
    .visi-misi {
        background-color: var(--color-bg-alt);
        padding: 88px 0;
    }
    .visi-misi-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 32px;
        margin-top: 56px;
    }
    .visi-card, .misi-card {
        background-color: var(--color-white);
        border-radius: var(--border-radius-xl);
        padding: 40px 40px 44px;
        position: relative;
        overflow: hidden;
        border: 1.5px solid rgba(56,42,33,0.05);
    }
    .visi-card {
        background-color: var(--color-dark-bark);
    }
    .visi-card::before {
        content: '';
        position: absolute;
        bottom: -40px;
        right: -40px;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: rgba(200,106,68,0.12);
    }
    .vm-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 16px;
        border-radius: var(--border-radius-round);
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 22px;
    }
    .visi-card .vm-badge {
        background-color: rgba(200,106,68,0.2);
        color: var(--color-primary);
    }
    .misi-card .vm-badge {
        background-color: rgba(200,106,68,0.08);
        color: var(--color-primary);
    }
    .visi-card h3 {
        font-size: 1.625rem;
        font-weight: 700;
        color: var(--color-white);
        line-height: 1.4;
        position: relative;
        z-index: 1;
    }
    .misi-card h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--color-dark-bark);
        margin-bottom: 20px;
    }
    .misi-list {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }
    .misi-list li {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        font-size: 0.9375rem;
        color: var(--color-text-muted);
        line-height: 1.6;
    }
    .misi-dot {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background-color: rgba(200,106,68,0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 1px;
        color: var(--color-primary);
        font-size: 0.625rem;
        font-weight: 700;
    }

    /* ---- Profil Kang Bahri ---- */
    .profil-section {
        padding: 88px 0;
    }
    .profil-grid {
        display: grid;
        grid-template-columns: 380px 1fr;
        gap: 72px;
        align-items: flex-start;
        margin-top: 56px;
    }
    .profil-img-col {
        position: sticky;
        top: 90px;
    }
    .profil-img-box {
        background: linear-gradient(145deg, var(--color-bg-alt) 0%, var(--color-soft-ivory) 100%);
        border-radius: var(--border-radius-xl);
        height: 460px;
        display: flex;
        align-items: flex-end;
        justify-content: center;
        overflow: hidden;
        position: relative;
        border: 2px solid rgba(56,42,33,0.06);
    }
    .profil-avatar {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 16px;
    }
    .profil-avatar-circle {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 700;
        color: var(--color-white);
        letter-spacing: -2px;
        box-shadow: 0 12px 40px rgba(200,106,68,0.35);
    }
    .profil-avatar-name {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--color-dark-bark);
    }
    .profil-avatar-title {
        font-size: 0.875rem;
        color: var(--color-text-muted);
        margin-top: -8px;
    }
    .profil-cert-strip {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 20px;
    }
    .profil-cert {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background-color: var(--color-white);
        border: 1px solid rgba(56,42,33,0.1);
        border-radius: var(--border-radius-round);
        padding: 6px 14px;
        font-size: 0.75rem;
        font-weight: 500;
        color: var(--color-dark-bark);
    }
    .profil-cert svg { color: var(--color-primary); }

    .profil-info-col {}
    .profil-info-col .section-label {
        display: inline-block;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: var(--color-primary);
        margin-bottom: 12px;
    }
    .profil-info-col h2 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--color-dark-bark);
        line-height: 1.25;
        margin-bottom: 8px;
    }
    .profil-info-col .profil-subtitle {
        font-size: 1rem;
        color: var(--color-primary);
        font-weight: 500;
        margin-bottom: 24px;
    }
    .profil-bio p {
        font-size: 0.9375rem;
        color: var(--color-text-muted);
        line-height: 1.8;
        margin-bottom: 18px;
    }
    .profil-bio p:last-child { margin-bottom: 0; }

    .profil-stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin: 32px 0;
        padding: 28px 0;
        border-top: 1px solid rgba(56,42,33,0.07);
        border-bottom: 1px solid rgba(56,42,33,0.07);
    }
    .profil-stat {
        text-align: center;
    }
    .profil-stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--color-dark-bark);
        line-height: 1;
    }
    .profil-stat-value span { color: var(--color-primary); }
    .profil-stat-label {
        font-size: 0.75rem;
        color: var(--color-text-muted);
        margin-top: 6px;
        line-height: 1.4;
    }

    .profil-keahlian-title {
        font-size: 0.875rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--color-dark-bark);
        margin-bottom: 14px;
    }
    .keahlian-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .keahlian-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 16px;
        background-color: var(--color-bg-alt);
        border-radius: var(--border-radius-round);
        font-size: 0.8125rem;
        font-weight: 500;
        color: var(--color-dark-bark);
        border: 1px solid rgba(56,42,33,0.08);
    }
    .keahlian-tag::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background-color: var(--color-primary);
        flex-shrink: 0;
    }

    /* ---- Journey / Timeline ---- */
    .journey-section {
        background-color: var(--color-bg-alt);
        padding: 88px 0;
    }
    .timeline {
        position: relative;
        max-width: 820px;
        margin: 56px auto 0;
    }
    .timeline::before {
        content: '';
        position: absolute;
        left: 50%;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(to bottom, var(--color-primary), rgba(200,106,68,0.15));
        transform: translateX(-50%);
    }
    .timeline-item {
        display: grid;
        grid-template-columns: 1fr 52px 1fr;
        gap: 0;
        margin-bottom: 48px;
        position: relative;
    }
    .timeline-item:last-child { margin-bottom: 0; }
    .timeline-item.right .timeline-content-left  { order: 1; }
    .timeline-item.right .timeline-node-col      { order: 2; }
    .timeline-item.right .timeline-content-right { order: 3; }
    .timeline-item.left  .timeline-content-left  { order: 3; }
    .timeline-item.left  .timeline-node-col      { order: 2; }
    .timeline-item.left  .timeline-content-right { order: 1; }

    .timeline-node-col {
        display: flex;
        justify-content: center;
        padding-top: 18px;
        position: relative;
    }
    .timeline-node {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background-color: var(--color-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-white);
        font-size: 0.75rem;
        font-weight: 700;
        z-index: 1;
        position: relative;
        box-shadow: 0 0 0 6px var(--color-bg-alt), 0 0 0 8px rgba(200,106,68,0.2);
        flex-shrink: 0;
    }
    .timeline-content-left,
    .timeline-content-right {
        padding: 10px 32px 10px 0;
    }
    .timeline-item.left .timeline-content-right { padding: 10px 0 10px 32px; }
    .timeline-item.right .timeline-content-right { padding: 10px 0 10px 32px; }
    .timeline-item.right .timeline-content-left { padding: 10px 32px 10px 0; text-align: right; }

    .timeline-card {
        background-color: var(--color-white);
        border-radius: var(--border-radius-lg);
        padding: 22px 24px;
        box-shadow: var(--shadow-sm);
        border: 1.5px solid rgba(56,42,33,0.05);
        transition: var(--transition-normal);
    }
    .timeline-card:hover {
        box-shadow: var(--shadow-md);
        border-color: rgba(200,106,68,0.15);
    }
    .timeline-year {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--color-primary);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }
    .timeline-card h4 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--color-dark-bark);
        margin-bottom: 7px;
        line-height: 1.35;
    }
    .timeline-card p {
        font-size: 0.875rem;
        color: var(--color-text-muted);
        line-height: 1.65;
        margin: 0;
    }

    /* Empty col for alternating layout */
    .timeline-empty { }

    /* ================================================================
       Cara Kerja
    ================================================================ */
    .cara-kerja {
        padding: 88px 0;
    }
    .cara-kerja-intro {
        max-width: 620px;
        margin: 0 auto 64px;
        text-align: center;
    }
    .cara-kerja-intro p {
        font-size: 1rem;
        color: var(--color-text-muted);
        line-height: 1.75;
        margin-top: 16px;
    }

    .cara-kerja-steps {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 0;
        position: relative;
    }
    .cara-kerja-steps::before {
        content: '';
        position: absolute;
        top: 38px;
        left: calc(10% + 24px);
        right: calc(10% + 24px);
        height: 2px;
        background: linear-gradient(to right, var(--color-primary), rgba(200,106,68,0.2));
        z-index: 0;
    }

    .ck-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 0 12px;
        position: relative;
        z-index: 1;
    }
    .ck-step-num {
        width: 76px;
        height: 76px;
        border-radius: 50%;
        background-color: var(--color-white);
        border: 2px solid rgba(200,106,68,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        transition: var(--transition-normal);
        box-shadow: var(--shadow-sm);
        color: var(--color-primary);
        position: relative;
    }
    .ck-step:hover .ck-step-num {
        background-color: var(--color-primary);
        border-color: var(--color-primary);
        color: var(--color-white);
        box-shadow: 0 8px 24px rgba(200,106,68,0.35);
        transform: translateY(-4px);
    }
    .ck-step-badge {
        position: absolute;
        top: -6px;
        right: -6px;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background-color: var(--color-dark-bark);
        color: var(--color-white);
        font-size: 0.625rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .ck-step h4 {
        font-size: 0.9375rem;
        font-weight: 600;
        color: var(--color-dark-bark);
        margin-bottom: 8px;
        line-height: 1.3;
    }
    .ck-step p {
        font-size: 0.8125rem;
        color: var(--color-text-muted);
        line-height: 1.6;
    }

    /* Detail cards below steps */
    .cara-kerja-detail {
        margin-top: 72px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }
    .ck-detail-card {
        background-color: var(--color-white);
        border-radius: var(--border-radius-xl);
        padding: 32px 28px;
        border: 1.5px solid rgba(56,42,33,0.05);
        box-shadow: var(--shadow-sm);
        transition: var(--transition-normal);
    }
    .ck-detail-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-md);
    }
    .ck-detail-icon {
        width: 52px;
        height: 52px;
        border-radius: var(--border-radius-md);
        background-color: rgba(200,106,68,0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
        color: var(--color-primary);
    }
    .ck-detail-card h4 {
        font-size: 1.0625rem;
        font-weight: 600;
        color: var(--color-dark-bark);
        margin-bottom: 10px;
    }
    .ck-detail-card p {
        font-size: 0.875rem;
        color: var(--color-text-muted);
        line-height: 1.7;
        margin: 0;
    }
    .ck-detail-card ul {
        list-style: none;
        margin-top: 12px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .ck-detail-card ul li {
        font-size: 0.875rem;
        color: var(--color-text-muted);
        padding-left: 16px;
        position: relative;
        line-height: 1.55;
    }
    .ck-detail-card ul li::before {
        content: '';
        position: absolute;
        left: 0;
        top: 8px;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background-color: var(--color-primary);
    }

    /* ================================================================
       CTA Konsultasi
    ================================================================ */
    .cta-konsultasi {
        background-color: var(--color-dark-bark);
        padding: 88px 0;
        position: relative;
        overflow: hidden;
    }
    .cta-konsultasi::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle at 75% 50%, rgba(200,106,68,0.15) 0%, transparent 55%),
                          radial-gradient(circle at 10% 80%, rgba(200,106,68,0.08) 0%, transparent 40%);
    }
    .cta-konsultasi-inner {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 64px;
        align-items: center;
    }
    .cta-konsultasi-text {}
    .cta-konsultasi-text .cta-label {
        display: inline-block;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: var(--color-primary);
        margin-bottom: 16px;
    }
    .cta-konsultasi-text h2 {
        font-size: 2.25rem;
        font-weight: 700;
        color: var(--color-white);
        line-height: 1.25;
        margin-bottom: 16px;
    }
    .cta-konsultasi-text h2 em {
        font-style: normal;
        color: var(--color-primary);
    }
    .cta-konsultasi-text p {
        font-size: 1rem;
        color: rgba(255,255,255,0.6);
        line-height: 1.7;
        max-width: 500px;
    }
    .cta-konsultasi-actions {
        display: flex;
        flex-direction: column;
        gap: 12px;
        align-items: center;
        flex-shrink: 0;
    }
    .btn-wa-konsultasi {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 16px 32px;
        background-color: #25D366;
        color: var(--color-white);
        border-radius: var(--border-radius-round);
        font-family: var(--font-primary);
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition-normal);
        white-space: nowrap;
    }
    .btn-wa-konsultasi:hover {
        background-color: #1ebc5a;
        color: var(--color-white);
        transform: translateY(-2px);
        box-shadow: 0 8px 28px rgba(37,211,102,0.35);
    }
    .btn-lihat-produk {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px 32px;
        background-color: transparent;
        color: rgba(255,255,255,0.75);
        border: 1.5px solid rgba(255,255,255,0.2);
        border-radius: var(--border-radius-round);
        font-family: var(--font-primary);
        font-size: 0.9375rem;
        font-weight: 500;
        text-decoration: none;
        transition: var(--transition-normal);
        white-space: nowrap;
    }
    .btn-lihat-produk:hover {
        border-color: rgba(255,255,255,0.5);
        color: var(--color-white);
        background-color: rgba(255,255,255,0.05);
    }
    .cta-konsultasi-note {
        font-size: 0.75rem;
        color: rgba(255,255,255,0.35);
        text-align: center;
        margin-top: 4px;
    }

    /* ================================================================
       Produk Rekomendasi Banner
    ================================================================ */
    .produk-banner {
        padding: 80px 0;
        background-color: var(--color-soft-ivory);
    }
    .produk-banner-inner {
        display: flex;
        align-items: center;
        gap: 48px;
        background-color: var(--color-white);
        border-radius: var(--border-radius-xl);
        padding: 48px 56px;
        box-shadow: var(--shadow-md);
        border: 1.5px solid rgba(56,42,33,0.05);
    }
    .produk-banner-icon {
        width: 80px;
        height: 80px;
        border-radius: var(--border-radius-lg);
        background-color: rgba(200,106,68,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-primary);
        flex-shrink: 0;
    }
    .produk-banner-text { flex: 1; }
    .produk-banner-text h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--color-dark-bark);
        margin-bottom: 8px;
    }
    .produk-banner-text p {
        font-size: 0.9375rem;
        color: var(--color-text-muted);
        line-height: 1.65;
        margin: 0;
    }

    /* ================================================================
       Responsive
    ================================================================ */
    @media (max-width: 992px) {
        .tentang-hero h1 { font-size: 2.25rem; }
        .tentang-intro-grid { grid-template-columns: 1fr; gap: 48px; }
        .visi-misi-grid { grid-template-columns: 1fr; }
        .cara-kerja-steps { grid-template-columns: 1fr 1fr; gap: 32px; }
        .cara-kerja-steps::before { display: none; }
        .cara-kerja-detail { grid-template-columns: 1fr 1fr; }
        .cta-konsultasi-inner { grid-template-columns: 1fr; gap: 40px; }
        .cta-konsultasi-actions { flex-direction: row; }

        /* ---- Profil: single column ---- */
        .profil-grid { grid-template-columns: 1fr; gap: 32px; }
        .profil-img-col { position: static; }
        .profil-img-box { height: 260px; }
        .profil-avatar-circle { width: 110px; height: 110px; font-size: 2.5rem; }
        /* Hide inner "Profil Lengkap" label — outer section-header already introduces the section */
        .profil-info-col .section-label { display: none; }
        .profil-info-col h2 { font-size: 1.75rem; }
        .profil-subtitle { font-size: 0.875rem; }
        .profil-stats-row { grid-template-columns: repeat(3, 1fr); }

        /* ---- Timeline: switch grid → flexbox so ordering works correctly ---- */
        .timeline { margin-top: 40px; }
        .timeline::before { left: 19px; transform: none; }
        .timeline-item {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            margin-bottom: 28px;
        }
        /* Hide empty "left" placeholder columns for all items */
        .timeline-content-left { display: none !important; }
        /* Node always first */
        .timeline-node-col {
            flex-shrink: 0;
            width: 50px;
            order: 1 !important;
            justify-content: flex-start;
            padding-top: 14px;
            padding-left: 0;
        }
        /* Card always second */
        .timeline-content-right {
            flex: 1;
            order: 2 !important;
            padding: 6px 0 6px 14px !important;
        }
        .timeline-node {
            box-shadow: 0 0 0 5px var(--color-bg-alt), 0 0 0 7px rgba(200,106,68,0.2);
        }
    }

    @media (max-width: 768px) {
        .tentang-hero { padding: 80px 0 64px; }
        .tentang-hero h1 { font-size: 1.875rem; }
        .tentang-hero-stats { gap: 28px; }
        .hero-stat-value { font-size: 1.625rem; }
        .cara-kerja-steps { grid-template-columns: 1fr; gap: 24px; }
        .cara-kerja-detail { grid-template-columns: 1fr; }
        .cta-konsultasi-actions { flex-direction: column; width: 100%; }
        .btn-wa-konsultasi, .btn-lihat-produk { width: 100%; }
        .produk-banner-inner { flex-direction: column; text-align: center; padding: 36px 28px; gap: 24px; }
        .visi-card, .misi-card { padding: 28px 28px 32px; }

        /* Profil */
        .profil-img-box { height: 220px; }
        .profil-avatar-circle { width: 90px; height: 90px; font-size: 2rem; }
        .profil-info-col h2 { font-size: 1.5rem; }
        .profil-subtitle { font-size: 0.8125rem; }

        /* Timeline cards */
        .timeline::before { left: 15px; }
        .timeline-node { width: 36px; height: 36px; font-size: 0.6875rem; }
        .timeline-node-col { width: 42px; }
        .timeline-card { padding: 16px 18px; }
        .timeline-card h4 { font-size: 0.9375rem; }
        .timeline-card p { font-size: 0.8125rem; }
    }

    @media (max-width: 576px) {
        .tentang-hero h1 { font-size: 1.625rem; }
        .tentang-hero p { font-size: 1rem; }
        .tentang-hero-stats { gap: 20px; }
        .tentang-intro-text h2 { font-size: 1.75rem; }
        .cta-konsultasi-text h2 { font-size: 1.625rem; }

        /* Profil */
        .profil-stats-row { grid-template-columns: repeat(3, 1fr); gap: 8px; }
        .profil-stat-value { font-size: 1.25rem; }
        .profil-stat-label { font-size: 0.6875rem; }
        .profil-cert-strip { gap: 6px; }
        .keahlian-tag { font-size: 0.75rem; padding: 5px 10px; }

        /* Timeline */
        .timeline::before { left: 13px; }
        .timeline-node { width: 30px; height: 30px; }
        .timeline-node-col { width: 36px; }
        .timeline-content-right { padding: 4px 0 4px 10px !important; }
        .timeline-year { font-size: 0.6875rem; }
        .timeline-card { padding: 14px 16px; }
    }
</style>
@endpush

@section('content')

    <!-- ================================================================
         HERO
    ================================================================ -->
    <section class="tentang-hero">
        <div class="container">
            <div class="tentang-hero-inner">
                <span class="tentang-hero-label">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                    {{ $settings['hero_badge'] ?? 'Mengenal Akar Sehat' }}
                </span>
                <h1>{{ $settings['hero_title'] ?? '' }}</h1>
                <p>{{ $settings['hero_desc'] ?? '' }}</p>
                <div class="tentang-hero-stats">
                    @foreach([1,2,3,4] as $i)
                    <div class="hero-stat-item">
                        <div class="hero-stat-value">{!! preg_replace('/\+$/', '<span>+</span>', e($settings["hero_stat{$i}_val"] ?? '')) !!}</div>
                        <div class="hero-stat-label">{{ $settings["hero_stat{$i}_label"] ?? '' }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- ================================================================
         TENTANG AKAR SEHAT
    ================================================================ -->
    <section class="tentang-intro">
        <div class="container">
            <div class="tentang-intro-grid">
                <div class="tentang-intro-text">
                    <span class="section-label">{{ $settings['intro_label'] ?? '' }}</span>
                    <h2>{{ $settings['intro_title'] ?? '' }}</h2>
                    @foreach(['intro_p1','intro_p2','intro_p3'] as $pk)
                        @if(!empty($settings[$pk]))<p>{{ $settings[$pk] }}</p>@endif
                    @endforeach
                </div>
                <div class="tentang-values">
                    @php
                        $valueIcons = [
                            '<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>',
                            '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
                            '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
                            '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>',
                        ];
                    @endphp
                    @foreach([1,2,3,4] as $i)
                    <div class="value-card">
                        <div class="value-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $valueIcons[$i-1] !!}</svg>
                        </div>
                        <div class="value-text">
                            <h4>{{ $settings["value{$i}_title"] ?? '' }}</h4>
                            <p>{{ $settings["value{$i}_desc"] ?? '' }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- ================================================================
         VISI & MISI
    ================================================================ -->
    <section class="visi-misi">
        <div class="container">
            <div class="section-header" style="text-align:center;">
                <h2 class="section-title">{{ $settings['vm_title'] ?? '' }}</h2>
                <p class="section-desc">{{ $settings['vm_desc'] ?? '' }}</p>
            </div>
            <div class="visi-misi-grid">
                <!-- Visi -->
                <div class="visi-card">
                    <span class="vm-badge">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        {{ $settings['visi_label'] ?? '' }}
                    </span>
                    <h3>{{ $settings['visi'] ?? '' }}</h3>
                </div>
                <!-- Misi -->
                <div class="misi-card">
                    <span class="vm-badge">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        {{ $settings['misi_label'] ?? '' }}
                    </span>
                    <h3>{{ $settings['misi_heading'] ?? '' }}</h3>
                    <ul class="misi-list">
                        @php $misiItems = array_filter(array_map('trim', explode("\n", $settings['misi'] ?? ''))); @endphp
                        @foreach($misiItems as $idx => $item)
                        <li>
                            <span class="misi-dot">{{ str_pad($idx + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            {{ $item }}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- ================================================================
         PROFIL KANG BAHRI
    ================================================================ -->
    <section class="profil-section">
        <div class="container">
            <div class="section-header">
                <span style="display:block;font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:var(--color-primary);margin-bottom:10px;">{{ $settings['profil_section_label'] ?? '' }}</span>
                <h2 class="section-title">{{ $settings['profil_section_title'] ?? '' }}</h2>
            </div>
            <div class="profil-grid">
                <!-- Image col -->
                <div class="profil-img-col">
                    <div class="profil-img-box">
                        @if(!empty($settings['profil_foto']))
                            <img src="{{ asset('storage/'.$settings['profil_foto']) }}" alt="{{ $settings['profil_nama'] ?? 'Kang Bahri' }} — Pendiri Akar Sehat"
                                 style="width:100%;height:100%;object-fit:cover;object-position:center top;">
                        @else
                            <img src="{{ asset('asset/profile/foto-kang-bahri-removebg-preview.png') }}" alt="{{ $settings['profil_nama'] ?? 'Kang Bahri' }} — Terapis Herbal & Pendiri Akar Sehat"
                                 style="width:100%;height:100%;object-fit:cover;object-position:center top;">
                        @endif
                    </div>
                    <div class="profil-cert-strip" style="margin-top:16px;">
                        @foreach(['cert1','cert2','cert3'] as $ck)
                        @if(!empty($settings[$ck]))
                        <span class="profil-cert">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
                            {{ $settings[$ck] }}
                        </span>
                        @endif
                        @endforeach
                    </div>
                </div>

                <!-- Info col -->
                <div class="profil-info-col">
                    <span class="section-label">{{ $settings['profil_inner_label'] ?? '' }}</span>
                    <h2>{{ $settings['profil_nama'] ?? '' }}</h2>
                    <p class="profil-subtitle">{{ $settings['profil_gelar'] ?? '' }}</p>

                    <div class="profil-bio">
                        @foreach(array_filter(explode("\n\n", $settings['profil_bio'] ?? '')) as $paragraph)
                            <p>{{ trim($paragraph) }}</p>
                        @endforeach
                    </div>

                    <div class="profil-stats-row">
                        @foreach([1,2,3] as $i)
                        <div class="profil-stat">
                            <div class="profil-stat-value">{!! preg_replace('/\+$/', '<span>+</span>', e($settings["profil_stat{$i}_val"] ?? '')) !!}</div>
                            <div class="profil-stat-label">{{ $settings["profil_stat{$i}_label"] ?? '' }}</div>
                        </div>
                        @endforeach
                    </div>

                    <div class="profil-keahlian-title">{{ $settings['keahlian_title'] ?? '' }}</div>
                    <div class="keahlian-tags">
                        @php $keahlian = array_filter(array_map('trim', explode("\n", $settings['keahlian_tags'] ?? ''))); @endphp
                        @foreach($keahlian as $tag)
                        <span class="keahlian-tag">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================================================================
         JOURNEY KANG BAHRI
    ================================================================ -->
    <section class="journey-section">
        <div class="container">
            <div class="section-header" style="text-align:center;">
                <h2 class="section-title">{{ $settings['journey_title'] ?? '' }}</h2>
                <p class="section-desc">{{ $settings['journey_desc'] ?? '' }}</p>
            </div>

            @php
                $tlIcons = [
                    '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
                    '<path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/>',
                    '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>',
                    '<circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>',
                    '<circle cx="12" cy="12" r="3"/><path d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83M1 12h4M19 12h4M4.22 19.78l2.83-2.83M16.95 7.05l2.83-2.83"/>',
                    '<rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>',
                    '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>',
                ];
            @endphp
            <div class="timeline">
                @foreach([1,2,3,4,5,6,7] as $i)
                @php
                    $side  = $i % 2 === 1 ? 'right' : 'left';
                    $last  = $i === 7;
                    $year  = $settings["tl{$i}_year"] ?? '';
                    $tlTitle = $settings["tl{$i}_title"] ?? '';
                    $tlDesc  = $settings["tl{$i}_desc"] ?? '';
                @endphp
                @continue($year === '' && $tlTitle === '' && $tlDesc === '')
                <div class="timeline-item {{ $side }}">
                    <div class="timeline-content-left"></div>
                    <div class="timeline-node-col">
                        <div class="timeline-node" @if($last) style="background:linear-gradient(135deg,var(--color-primary),var(--color-primary-dark));" @endif>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">{!! $tlIcons[$i-1] !!}</svg>
                        </div>
                    </div>
                    <div class="timeline-content-right">
                        <div class="timeline-card" @if($last) style="border-color:rgba(200,106,68,0.2);" @endif>
                            <div class="timeline-year">{{ $year }}</div>
                            <h4>{{ $tlTitle }}</h4>
                            <p>{{ $tlDesc }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ================================================================
         CARA KERJA AKAR SEHAT
    ================================================================ -->
    <section class="cara-kerja">
        <div class="container">
            <div class="cara-kerja-intro">
                <span style="display:inline-block;font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:var(--color-primary);margin-bottom:12px;">{{ $settings['ck_label'] ?? '' }}</span>
                <h2 class="section-title">{{ $settings['ck_title'] ?? '' }}</h2>
                <p>{{ $settings['ck_desc'] ?? '' }}</p>
            </div>

            <!-- 5 Steps -->
            @php
                $stepIcons = [
                    '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
                    '<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>',
                    '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
                    '<path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>',
                    '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>',
                ];
            @endphp
            <div class="cara-kerja-steps">
                @foreach([1,2,3,4,5] as $i)
                <div class="ck-step">
                    <div class="ck-step-num">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $stepIcons[$i-1] !!}</svg>
                        <span class="ck-step-badge">{{ $i }}</span>
                    </div>
                    <h4>{{ $settings["step{$i}_title"] ?? '' }}</h4>
                    <p>{{ $settings["step{$i}_desc"] ?? '' }}</p>
                </div>
                @endforeach
            </div>

            <!-- Detail cards -->
            @php
                $ckdIcons = [
                    '<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>',
                    '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
                    '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>',
                ];
            @endphp
            <div class="cara-kerja-detail">
                @foreach([1,2,3] as $i)
                <div class="ck-detail-card">
                    <div class="ck-detail-icon">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $ckdIcons[$i-1] !!}</svg>
                    </div>
                    <h4>{{ $settings["ckd{$i}_title"] ?? '' }}</h4>
                    <p>{{ $settings["ckd{$i}_intro"] ?? '' }}</p>
                    <ul>
                        @foreach(array_filter(array_map('trim', explode("\n", $settings["ckd{$i}_list"] ?? ''))) as $li)
                        <li>{{ $li }}</li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ================================================================
         CTA KONSULTASI
    ================================================================ -->
    <section class="cta-konsultasi">
        <div class="container">
            <div class="cta-konsultasi-inner">
                <div class="cta-konsultasi-text">
                    <span class="cta-label">{{ $settings['cta_label'] ?? '' }}</span>
                    <h2>{{ $settings['cta_title'] ?? '' }}</h2>
                    <p>{{ $settings['cta_desc'] ?? '' }}</p>
                </div>
                <div class="cta-konsultasi-actions">
                    <a href="https://wa.me/{{ $siteSettings['wa_number'] ?? '6281234567890' }}?text=Halo%20Kang%20Bahri%2C%20saya%20ingin%20konsultasi%20kesehatan%20gratis.%20Boleh%20saya%20ceritakan%20keluhan%20saya%3F" target="_blank" class="btn-wa-konsultasi">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        {{ $settings['cta_btn'] ?? '' }}
                    </a>

                    <p class="cta-konsultasi-note">{{ $settings['cta_note'] ?? '' }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ================================================================
         PRODUK REKOMENDASI BANNER
    ================================================================ -->
    <section class="produk-banner">
        <div class="container">
            <div class="produk-banner-inner">
                <div class="produk-banner-icon">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <path d="M16 10a4 4 0 0 1-8 0"/>
                    </svg>
                </div>
                <div class="produk-banner-text">
                    <h3>{{ $settings['banner_title'] ?? '' }}</h3>
                    <p>{{ $settings['banner_desc'] ?? '' }}</p>
                </div>
                <a href="{{ route('produk.index') }}" class="btn btn-primary" style="white-space:nowrap;flex-shrink:0;">
                    {{ $settings['banner_btn'] ?? __('common.see_all_products') }} →
                </a>
            </div>
        </div>
    </section>

@endsection
