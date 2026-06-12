@extends('layouts.public')

@section('title', __('home.page_title'))
@section('meta_desc', 'Akar Sehat menyediakan edukasi dan pendampingan kesehatan untuk membantu Anda memahami penyakit secara menyeluruh sampai ke akarnya.')

@section('content')

    <!-- MAIN BODY CONTENT -->
    <main>

        <!-- HERO SECTION -->
        <header id="hero" class="hero">
            <div class="hero-bg-pattern"></div>
            <div class="container">
                <div class="hero-content">
                    @if(!empty($settings['hero_badge']))
                    <span class="hero-badge">{{ $settings['hero_badge'] }}</span>
                    @endif
                    <h1>{{ $settings['hero_title1'] ?? 'Pahami Tubuh.' }}<br>
                        <span class="text-primary">{{ $settings['hero_title2'] ?? 'Sehat dari Akar.' }}</span>
                    </h1>
                    <p>{{ $settings['hero_desc'] ?? 'Akar Sehat menyediakan edukasi dan pendampingan kesehatan untuk membantu Anda memahami penyakit secara menyeluruh sampai ke akarnya.' }}</p>
                    <div class="hero-buttons">
                        <a href="{{ route('tentang') }}" class="btn btn-primary">{{ $settings['hero_btn_text'] ?? 'Selengkapnya' }}</a>
                    </div>
                </div>
                <div class="hero-visual">
                    @if(!empty($settings['hero_image']))
                        <img src="{{ asset('storage/'.$settings['hero_image']) }}" alt="Hero Image" class="hero-image">
                    @else
                        <img src="{{ asset('asset/profile/image-hero-2.png') }}" alt="Hero Image" class="hero-image">
                    @endif
                </div>
            </div>
        </header>

        <!-- STATS STRIP -->
        @php
            $heroStats = isset($settings['stats']) && is_string($settings['stats'])
                ? json_decode($settings['stats'], true)
                : ($settings['stats'] ?? []);
        @endphp
        @if(!empty($heroStats))
        <div class="stats-strip">
            <div class="container">
                <div class="stats-strip-grid">
                    @foreach($heroStats as $stat)
                    <div class="stats-strip-item">
                        @if(!empty($stat['icon']))
                        <div class="stats-strip-icon">{{ $stat['icon'] }}</div>
                        @endif
                        <div class="stats-strip-nilai">{{ $stat['nilai'] ?? '' }}</div>
                        <div class="stats-strip-label">{{ $stat['label'] ?? '' }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- MENGAPA AKAR SEHAT -->
        <section id="mengapa" class="section section-bg-alt">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">{{ __('home.why_title') }}</h2>
                    <p class="section-desc">{{ __('home.why_desc') }}</p>
                </div>
                <div class="why-grid">
                    <div class="why-card">
                        <div class="card-icon-box">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <circle cx="12" cy="12" r="6" />
                                <circle cx="12" cy="12" r="2" />
                            </svg>
                        </div>
                        <h3>{{ __('home.why1_title') }}</h3>
                        <p>{{ __('home.why1_desc') }}</p>
                    </div>
                    <div class="why-card">
                        <div class="card-icon-box">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z" />
                                <path d="M12 6v12M6 12h12" />
                            </svg>
                        </div>
                        <h3>{{ __('home.why2_title') }}</h3>
                        <p>{{ __('home.why2_desc') }}</p>
                    </div>
                    <div class="why-card">
                        <div class="card-icon-box">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                <polyline points="22 4 12 14.01 9 11.01" />
                            </svg>
                        </div>
                        <h3>{{ __('home.why3_title') }}</h3>
                        <p>{{ __('home.why3_desc') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- DIBIMBING OLEH KANG BAHRI (MENTOR) -->
        <section id="mentor" class="section mentor-section">
            <div class="container">
                <div class="mentor-visual">
                    @if(!empty($settings['mentor_image']))
                        <img src="{{ asset('storage/'.$settings['mentor_image']) }}" alt="{{ $settings['mentor_nama'] ?? 'Kang Bahri' }} - Mentor Akar Sehat" class="mentor-img">
                    @else
                        <img src="{{ asset('asset/foto-kang-bahri-removebg-preview.png') }}" alt="{{ $settings['mentor_nama'] ?? 'Kang Bahri' }} - Mentor Akar Sehat" class="mentor-img">
                    @endif
                </div>
                <div class="mentor-content">
                    <span class="mentor-tag">{{ $settings['mentor_tag'] ?? 'Dibimbing Oleh' }}</span>
                    <h2>{{ $settings['mentor_nama'] ?? 'Kang Bahri' }}</h2>
                    <p class="mentor-bio">{{ $settings['mentor_bio'] ?? 'Kang Bahri membantu masyarakat memahami tubuh melalui edukasi, konsultasi, dan panduan kesehatan alami yang mudah diterapkan dalam kehidupan sehari-hari secara fleksibel dan bertahap.' }}</p>
                    <div class="mentor-stats">
                        @php
                            $mentorStats = isset($settings['mentor_stats']) && is_string($settings['mentor_stats'])
                                ? json_decode($settings['mentor_stats'], true)
                                : ($settings['mentor_stats'] ?? []);
                        @endphp
                        @if(!empty($mentorStats))
                            @foreach($mentorStats as $stat)
                            <div class="stat-item">
                                <h4>{{ $stat['nilai'] ?? '' }}</h4>
                                <p>{{ $stat['label'] ?? '' }}</p>
                            </div>
                            @endforeach
                        @else
                            <div class="stat-item"><h4>20+</h4><p>Tahun Pengalaman</p></div>
                            <div class="stat-item"><h4>Ratusan+</h4><p>Orang Terbantu</p></div>
                            <div class="stat-item"><h4>Sertifikasi</h4><p>Terapis Kesehatan</p></div>
                        @endif
                    </div>
                    <a href="{{ route('tentang') }}" class="btn btn-primary">{{ $settings['mentor_btn'] ?? 'Kenali Kang Bahri →' }}</a>
                </div>
            </div>
        </section>

        <!-- PENDEKATAN AKAR SEHAT -->
        <section id="pendekatan" class="section section-bg-alt">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">{{ __('home.approach_title') }}</h2>
                    <p class="section-desc">{{ __('home.approach_desc') }}</p>
                </div>
                <div class="approach-grid">
                    <div class="approach-card">
                        <div class="approach-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path
                                    d="M12 2a10 10 0 0 1 10 10c0 5.523-4.477 10-10 10S2 17.523 2 12A10 10 0 0 1 12 2z" />
                                <path d="M12 6v12M6 12h12" />
                            </svg>
                        </div>
                        <h3>{{ __('home.ap1_title') }}</h3>
                        <p>{{ __('home.ap1_desc') }}</p>
                    </div>
                    <div class="approach-card">
                        <div class="approach-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z" />
                                <path d="M12 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4z" />
                            </svg>
                        </div>
                        <h3>{{ __('home.ap2_title') }}</h3>
                        <p>{{ __('home.ap2_desc') }}</p>
                    </div>
                    <div class="approach-card">
                        <div class="approach-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                            </svg>
                        </div>
                        <h3>{{ __('home.ap3_title') }}</h3>
                        <p>{{ __('home.ap3_desc') }}</p>
                    </div>
                    <div class="approach-card">
                        <div class="approach-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M18 8h1a4 4 0 0 1 0 8h-1M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z" />
                                <line x1="6" y1="2" x2="6" y2="4" />
                                <line x1="10" y1="2" x2="10" y2="4" />
                                <line x1="14" y1="2" x2="14" y2="4" />
                            </svg>
                        </div>
                        <h3>{{ __('home.ap4_title') }}</h3>
                        <p>{{ __('home.ap4_desc') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- TESTIMONIAL / PERUBAHAN NYATA -->
        <section class="section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">{{ __('home.testi_title') }}</h2>
                    <p class="section-desc">{{ __('home.testi_desc') }}</p>
                </div>

                <!-- Testimonial Slider Container -->
                <div class="testimonial-container">
                    <div class="testimonial-wrapper" id="testimonial-wrapper">
                        @forelse($testimonials as $testi)
                        <div class="testimonial-card">
                            <div class="testi-img-wrapper">
                                @if($testi->foto)
                                    <img src="{{ asset('storage/'.$testi->foto) }}"
                                         alt="{{ $testi->trans('nama') }}"
                                         class="testi-avatar"
                                         style="width:140px;height:140px;border-radius:50%;object-fit:cover;">
                                @else
                                    <svg width="140" height="140" viewBox="0 0 140 140" fill="none" class="testi-avatar">
                                        <circle cx="70" cy="70" r="70" fill="{{ $testi->warna }}22"/>
                                        <circle cx="70" cy="55" r="25" fill="{{ $testi->warna }}"/>
                                        <path d="M30 115 C30 90, 110 90, 110 115" fill="{{ $testi->warna }}"/>
                                        <text x="70" y="62" text-anchor="middle" fill="white"
                                              font-size="20" font-weight="700"
                                              font-family="Poppins,sans-serif">{{ $testi->inisial }}</text>
                                    </svg>
                                @endif
                                <div class="rating-badge">
                                    <span class="rating-star">★</span> {{ number_format($testi->rating, 1) }}
                                </div>
                            </div>
                            <div class="testi-main">
                                <p class="testi-quote">"{{ $testi->trans('isi') }}"</p>
                                <div class="testi-profile">
                                    <h4>{{ $testi->trans('nama') }}</h4>
                                    <p>{{ $testi->trans('jabatan') }}</p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="testimonial-card">
                            <div class="testi-img-wrapper">
                                <svg width="140" height="140" viewBox="0 0 140 140" fill="none" class="testi-avatar">
                                    <circle cx="70" cy="70" r="70" fill="rgba(200,106,68,.1)"/>
                                    <circle cx="70" cy="55" r="25" fill="var(--color-primary-dark)"/>
                                    <path d="M30 115 C30 90, 110 90, 110 115" fill="var(--color-primary-dark)"/>
                                </svg>
                                <div class="rating-badge"><span class="rating-star">★</span> 5.0</div>
                            </div>
                            <div class="testi-main">
                                <p class="testi-quote">"{{ __('home.no_testi') }}"</p>
                                <div class="testi-profile"><h4>—</h4><p>—</p></div>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Dots Navigation -->
                <div class="slider-dots" id="slider-dots">
                    @foreach($testimonials as $i => $testi)
                    <span class="dot {{ $loop->first ? 'active' : '' }}" data-slide="{{ $loop->index }}"></span>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- MID CTA BANNER -->
        <div class="container mid-cta-wrapper">
            <div class="mid-cta">
                <div class="container">
                    <div class="mid-cta-text">
                        <h2>{{ $settings['cta_title'] ?? 'Mulai pahami tubuh Anda dari akarnya.' }}</h2>
                        <p>{{ $settings['cta_desc'] ?? 'Langkah kecil hari ini untuk kesehatan yang jauh lebih baik di masa depan.' }}</p>
                    </div>
                    <a href="{{ route('tentang') }}" class="btn btn-outline-white">{{ $settings['cta_btn'] ?? 'Selengkapnya →' }}</a>
                </div>
            </div>
        </div>

        <!-- INSIGHT KESEHATAN PILIHAN -->
        <section id="insight" class="section section-bg-alt">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">{{ __('home.insight_title') }}</h2>
                    <p class="section-desc">{{ __('home.insight_desc') }}</p>
                </div>
                <div class="insight-grid">
                    @forelse($latestArticles as $artikel)
                    <div class="insight-card">
                        <div class="article-img-box">
                            @if($artikel->thumbnail)
                            <img src="{{ asset('storage/'.$artikel->thumbnail) }}" alt="{{ $artikel->judul }}" class="article-img-box-img">
                            @else
                            <img src="{{ asset('asset/artikel/default.png') }}" alt="{{ $artikel->judul }}" class="article-img-box-img">
                            @endif
                            <span class="article-tag">{{ strtoupper($artikel->kategori ?? 'ARTIKEL') }}</span>
                        </div>
                        <div class="article-content">
                            <h3 class="article-title">{{ $artikel->judul }}</h3>
                            <a href="{{ route('edukasi.show', $artikel->slug) }}" class="article-link">{{ __('common.read_more') }} →</a>
                        </div>
                    </div>
                    @empty
                    <div class="insight-card">
                        <div class="article-img-box">
                            <img src="{{ asset('asset/artikel/detox-alami-tubuh.png') }}" alt="" class="article-img-box-img">
                            <span class="article-tag">DETOX</span>
                        </div>
                        <div class="article-content">
                            <h3 class="article-title">Cara Detoks Alami untuk Tubuh Sehat</h3>
                            <a href="{{ route('edukasi.index') }}" class="article-link">{{ __('common.read_more') }} →</a>
                        </div>
                    </div>
                    <div class="insight-card">
                        <div class="article-img-box">
                            <img src="{{ asset('asset/artikel/pencernaan-sehat.png') }}" alt="" class="article-img-box-img">
                            <span class="article-tag">PENCERNAAN</span>
                        </div>
                        <div class="article-content">
                            <h3 class="article-title">Pencernaan Sehat, Tubuh Lebih Kuat</h3>
                            <a href="{{ route('edukasi.index') }}" class="article-link">{{ __('common.read_more') }} →</a>
                        </div>
                    </div>
                    <div class="insight-card">
                        <div class="article-img-box">
                            <img src="{{ asset('asset/artikel/nutrisi-antioksidan.png') }}" alt="" class="article-img-box-img">
                            <span class="article-tag">NUTRISI</span>
                        </div>
                        <div class="article-content">
                            <h3 class="article-title">Nutrisi & Antioksidan: Lindungi Sel Tubuh</h3>
                            <a href="{{ route('edukasi.index') }}" class="article-link">{{ __('common.read_more') }} →</a>
                        </div>
                    </div>
                    @endforelse
                </div>
                <div class="section-footer-btn">
                    <a href="{{ route('edukasi.index') }}" class="btn btn-secondary">{{ __('common.see_all_articles') }}</a>
                </div>
            </div>
        </section>

        <!-- PRODUK PENDUKUNG KESEHATAN -->
        <section id="produk" class="section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">{{ __('home.products_title') }}</h2>
                    <p class="section-desc">{{ __('home.products_desc') }}</p>
                </div>
                <div class="product-grid">
                    @forelse($featuredProducts as $produk)
                    <div class="product-card">
                        <div class="product-img-box">
                            @if($produk->fotos)
                            <img src="{{ asset('storage/'.($produk->fotos[0] ?? '')) }}" alt="{{ $produk->nama }}"
                                class="product-img-box-img">
                            @endif
                        </div>
                        <div class="product-info">
                            <span class="product-brand">{{ __('common.brand') }}</span>
                            <h3>{{ $produk->nama }}</h3>
                            <p class="product-desc">{{ $produk->deskripsi }}</p>
                            <hr class="product-divider">
                            <a href="{{ route('produk.show', $produk->slug) }}" class="product-cta-btn">{{ __('common.product_detail') }}</a>
                        </div>
                    </div>
                    @empty
                    <div class="product-card">
                        <div class="product-img-box">
                            <img src="{{ asset('asset/produk/r12-detox-removebg-preview.png') }}" alt="R12 Detoksifikasi"
                                class="product-img-box-img">
                        </div>
                        <div class="product-info">
                            <span class="product-brand">{{ __('common.brand') }}</span>
                            <h3>R 12 Detoksifikasi</h3>
                            <p class="product-desc">Membantu mendukung proses detoksifikasi alami dan optimal di dalam
                                tubuh secara berkelanjutan. Diformulasikan dari bahan herbal pilihan yang bekerja
                                sinergis membantu hati dan ginjal membersihkan racun.</p>
                            <hr class="product-divider">
                            <a href="{{ route('produk.index') }}" class="product-cta-btn">{{ __('common.product_detail') }}</a>
                        </div>
                    </div>
                    <div class="product-card">
                        <div class="product-img-box">
                            <img src="{{ asset('asset/produk/b-28-bioalpha-removebg-preview.png') }}" alt="B28 Premium Anti Oxidant"
                                class="product-img-box-img">
                        </div>
                        <div class="product-info">
                            <span class="product-brand">{{ __('common.brand') }}</span>
                            <h3>B28 Premium Anti Oxidant</h3>
                            <p class="product-desc">Membantu melindungi sel tubuh secara menyeluruh dari radikal bebas
                                dan stres oksidatif. Mengandung antioksidan kuat yang mendukung regenerasi sel dan daya
                                tahan tubuh secara alami.</p>
                            <hr class="product-divider">
                            <a href="{{ route('produk.index') }}" class="product-cta-btn">{{ __('common.product_detail') }}</a>
                        </div>
                    </div>
                    @endforelse
                </div>
                <div class="section-footer-btn">
                </div>
            </div>
        </section>

        <!-- CONSULTATION CTA -->
        <section id="konsultasi" class="section section-bg-alt consultation-section">
            <div class="container container--narrow">
                <div class="card-icon-box mx-auto">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    </svg>
                </div>
                <h2>{{ $settings['konsul_title'] ?? 'Butuh Arahan yang Lebih Personal?' }}</h2>
                <p>{{ $settings['konsul_desc'] ?? 'Konsultasi manual bersama Kang Bahri untuk memahami kondisi fungsional tubuh Anda secara spesifik dan menentukan langkah pemulihan alami yang paling tepat.' }}</p>
                <a href="https://wa.me/{{ $siteSettings['wa_number'] ?? '6281234567890' }}" target="_blank" class="btn btn-primary btn--large">
                    {{ $settings['konsul_btn'] ?? 'Konsultasi via WhatsApp' }}</a>
            </div>
        </section>

    </main>

@endsection
