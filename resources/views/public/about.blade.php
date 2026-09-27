@extends('layouts.public')
@section('title', 'Tentang Kami – Temukan Solusi Sehat Alami Bersama Herbal Bharata')

@push('styles')
<style>
/* ── Fade-up Scroll Animation ────────────────────────────────── */
.fade-up {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.7s ease, transform 0.7s ease;
}
.fade-up.visible {
    opacity: 1;
    transform: translateY(0);
}
.fade-up-delay-1 { transition-delay: 0.1s; }
.fade-up-delay-2 { transition-delay: 0.2s; }
.fade-up-delay-3 { transition-delay: 0.3s; }

/* ── Section 1: Page Hero (Standardized with Catalog & Contact) ─ */
.page-hero {
    background: #0D2618;
    padding: 100px 20px 70px;
    text-align: center;
    position: relative;
}
.page-hero-badge {
    display: inline-block;
    background: rgba(168, 221, 191, 0.12);
    color: #A8DDBF;
    border: 1px solid rgba(168, 221, 191, 0.25);
    border-radius: 50px;
    padding: 6px 22px;
    font-size: 0.7rem;
    letter-spacing: 2px;
    text-transform: uppercase;
    font-weight: 600;
    font-family: 'Inter', sans-serif;
    margin-bottom: 20px;
}
.page-hero-title {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: clamp(2.2rem, 5vw, 3.5rem);
    font-weight: 700;
    color: #FFFFFF;
    line-height: 1.18;
    margin-bottom: 0;
}
.page-hero-title .gold-shimmer {
    color: #A8DDBF;
}
.page-hero-divider {
    width: 60px;
    height: 3px;
    background: #A8DDBF;
    border-radius: 2px;
    margin: 18px auto;
}
.page-hero-desc {
    font-family: 'Inter', sans-serif;
    font-size: 0.95rem;
    color: #D1E5DB;
    max-width: 680px;
    margin: 0 auto;
    line-height: 1.7;
}

/* ── Section 2: Cerita & Tentang Kami ────────────────────────── */
.about-intro-section {
    background: #FFFFFF;
    padding: 80px 24px;
}
.about-intro-grid {
    display: grid;
    grid-template-columns: 1fr 1.2fr;
    gap: 56px;
    max-width: 1160px;
    margin: 0 auto;
    align-items: center;
}
.about-intro-card {
    background: #F8FAF7;
    border: 1px solid #E2EAE5;
    border-radius: 24px;
    padding: 40px 32px;
    text-align: center;
    position: relative;
    box-shadow: 0 4px 20px rgba(13, 38, 24, 0.03);
}
.about-intro-icon {
    width: 72px;
    height: 72px;
    background: #FFFFFF;
    border: 2px solid #D4DCD6;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 18px auto;
    font-size: 1.8rem;
    color: #0D2618;
    box-shadow: 0 4px 12px rgba(13, 38, 24, 0.05);
}
.about-intro-brand {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: 1.35rem;
    font-weight: 700;
    color: #0D2618;
    margin-bottom: 6px;
}
.about-intro-tagline {
    font-family: 'Inter', sans-serif;
    font-size: 0.88rem;
    color: #6A7A72;
    line-height: 1.6;
    max-width: 320px;
    margin: 0 auto 24px auto;
}
.about-mini-stats {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 16px;
    padding-top: 20px;
    border-top: 1px solid #E2EAE5;
}
.about-mini-stat-item {
    text-align: center;
    flex: 1;
}
.about-mini-stat-num {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: 1.45rem;
    font-weight: 700;
    color: #0D2618;
    line-height: 1;
}
.about-mini-stat-lbl {
    font-family: 'Inter', sans-serif;
    font-size: 0.72rem;
    color: #6A7A72;
    margin-top: 4px;
    font-weight: 500;
}
.about-mini-stat-divider {
    width: 1px;
    height: 32px;
    background: #D4DCD6;
}
.about-intro-badge-wrap {
    margin-top: 22px;
}
.about-intro-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #0D2618;
    color: #FFFFFF;
    font-family: 'Inter', sans-serif;
    font-size: 0.72rem;
    font-weight: 600;
    letter-spacing: 1px;
    text-transform: uppercase;
    padding: 6px 18px;
    border-radius: 50px;
}

/* Right Content */
.about-badge {
    display: inline-block;
    color: #0D2618;
    background: rgba(13, 38, 24, 0.08);
    font-family: 'Inter', sans-serif;
    font-size: 0.72rem;
    letter-spacing: 2px;
    text-transform: uppercase;
    font-weight: 700;
    padding: 5px 14px;
    border-radius: 50px;
    margin-bottom: 16px;
}
.about-intro-title {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: clamp(1.8rem, 3.5vw, 2.4rem);
    color: #0D2618;
    line-height: 1.25;
    font-weight: 700;
    margin-bottom: 18px;
}
.about-intro-desc {
    font-family: 'Inter', sans-serif;
    font-size: 0.95rem;
    color: #55655D;
    line-height: 1.8;
    margin-bottom: 14px;
}
.about-values-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
    margin-top: 24px;
}
.about-value-item {
    display: flex;
    align-items: center;
    gap: 12px;
    background: #F8FAF7;
    border: 1px solid #E2EAE5;
    border-radius: 12px;
    padding: 12px 14px;
    transition: all 0.3s ease;
}
.about-value-item:hover {
    border-color: #0D2618;
    background: #FFFFFF;
    box-shadow: 0 4px 14px rgba(13, 38, 24, 0.06);
    transform: translateY(-2px);
}
.about-value-icon {
    width: 38px;
    height: 38px;
    background: rgba(13, 38, 24, 0.08);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #0D2618;
    font-size: 1rem;
}
.about-value-text strong {
    display: block;
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: 0.82rem;
    font-weight: 700;
    color: #0D2618;
    line-height: 1.25;
}
.about-value-text span {
    font-family: 'Inter', sans-serif;
    font-size: 0.72rem;
    color: #6A7A72;
}

/* ── Section 3: Komitmen & Layanan Kami ──────────────────────── */
.commit-section {
    background: #F8FAF7;
    padding: 80px 24px;
}
.section-header {
    text-align: center;
    max-width: 700px;
    margin: 0 auto 48px auto;
}
.section-header-badge {
    display: inline-block;
    color: #0D2618;
    background: rgba(13, 38, 24, 0.08);
    font-family: 'Inter', sans-serif;
    font-size: 0.72rem;
    letter-spacing: 2px;
    text-transform: uppercase;
    font-weight: 700;
    padding: 5px 16px;
    border-radius: 50px;
    margin-bottom: 14px;
}
.section-header-title {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: clamp(1.8rem, 3.5vw, 2.4rem);
    color: #0D2618;
    font-weight: 700;
    margin-bottom: 12px;
}
.section-header-divider {
    width: 60px;
    height: 3px;
    background: #0D2618;
    border-radius: 2px;
    margin: 0 auto;
}
.commit-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    max-width: 1140px;
    margin: 0 auto;
}
.commit-card {
    background: #FFFFFF;
    border: 1px solid #E2EAE5;
    border-radius: 20px;
    padding: 36px 28px;
    box-shadow: 0 4px 20px rgba(13, 38, 24, 0.03);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.commit-card:hover {
    border-color: #0D2618;
    box-shadow: 0 10px 30px rgba(13, 38, 24, 0.06);
    transform: translateY(-4px);
}
.commit-card-top {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 18px;
}
.commit-card-icon {
    width: 52px;
    height: 52px;
    background: #E8F0EC;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #0D2618;
    font-size: 1.4rem;
    flex-shrink: 0;
    transition: all 0.3s ease;
}
.commit-card:hover .commit-card-icon {
    background: #0D2618;
    color: #FFFFFF;
    transform: scale(1.08);
}
.commit-card-badge {
    font-family: 'Inter', sans-serif;
    font-size: 0.7rem;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    font-weight: 700;
    color: #0D2618;
    margin-bottom: 2px;
}
.commit-card-title {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: 1.25rem;
    color: #0D2618;
    font-weight: 700;
    margin: 0;
    line-height: 1.3;
}
.commit-card-desc {
    font-family: 'Inter', sans-serif;
    font-size: 0.92rem;
    color: #55655D;
    line-height: 1.75;
    margin-bottom: 20px;
    flex-grow: 1;
}
.commit-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    padding-top: 16px;
    border-top: 1px solid #E2EAE5;
}
.commit-tag {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #F8FAF7;
    border: 1px solid #E2EAE5;
    color: #0D2618;
    font-family: 'Inter', sans-serif;
    font-size: 0.72rem;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 6px;
}
.commit-tag i {
    font-size: 0.65rem;
    color: #0D2618;
}

/* ── Section 4: Standar Kualitas & Legalitas ─────────────────── */
.quality-section {
    background: #0D2618;
    padding: 80px 24px;
    position: relative;
}
.quality-header {
    text-align: center;
    max-width: 700px;
    margin: 0 auto 48px auto;
}
.quality-badge {
    display: inline-block;
    background: rgba(168, 221, 191, 0.12);
    color: #A8DDBF;
    border: 1px solid rgba(168, 221, 191, 0.25);
    border-radius: 50px;
    padding: 6px 20px;
    font-size: 0.7rem;
    letter-spacing: 2px;
    text-transform: uppercase;
    font-weight: 600;
    font-family: 'Inter', sans-serif;
    margin-bottom: 14px;
}
.quality-title {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: clamp(1.8rem, 3.5vw, 2.5rem);
    color: #FFFFFF;
    font-weight: 700;
    margin-bottom: 12px;
}
.quality-desc {
    font-family: 'Inter', sans-serif;
    font-size: 0.95rem;
    color: #D1E5DB;
    line-height: 1.7;
    margin: 0 auto;
}
.quality-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    max-width: 1140px;
    margin: 0 auto;
}
.quality-card {
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(168, 221, 191, 0.2);
    border-radius: 20px;
    padding: 32px 22px;
    text-align: center;
    position: relative;
    transition: all 0.3s ease;
}
.quality-card:hover {
    background: rgba(255, 255, 255, 0.08);
    border-color: #A8DDBF;
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
}
.quality-icon-wrap {
    width: 60px;
    height: 60px;
    background: rgba(168, 221, 191, 0.12);
    border: 1px solid rgba(168, 221, 191, 0.28);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 18px auto;
    color: #A8DDBF;
    font-size: 1.5rem;
    transition: all 0.3s ease;
}
.quality-card:hover .quality-icon-wrap {
    transform: scale(1.08);
    background: rgba(168, 221, 191, 0.2);
    border-color: #A8DDBF;
}
.quality-card h3 {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: 1.1rem;
    color: #FFFFFF;
    font-weight: 700;
    margin-bottom: 8px;
}
.quality-card p {
    font-family: 'Inter', sans-serif;
    font-size: 0.84rem;
    color: #D1E5DB;
    line-height: 1.6;
    margin: 0;
}

/* ── Section 5: CTA Bottom Banner (Senada dengan Kontak & Beranda) */
.about-cta {
    background: #FFFFFF;
    padding: 80px 24px;
    text-align: center;
}
.about-cta-inner {
    max-width: 760px;
    margin: 0 auto;
}
.about-cta-badge {
    display: inline-block;
    color: #0D2618;
    background: rgba(13, 38, 24, 0.08);
    font-family: 'Inter', sans-serif;
    font-size: 0.72rem;
    letter-spacing: 2px;
    text-transform: uppercase;
    font-weight: 700;
    padding: 5px 16px;
    border-radius: 50px;
    margin-bottom: 16px;
}
.about-cta-title {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: clamp(1.8rem, 3.5vw, 2.5rem);
    color: #0D2618;
    font-weight: 700;
    margin-bottom: 14px;
    line-height: 1.25;
}
.about-cta-desc {
    font-family: 'Inter', sans-serif;
    font-size: 0.95rem;
    color: #6A7A72;
    line-height: 1.75;
    margin: 0 auto 24px auto;
}
.about-cta-phone {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: #F8FAF7;
    border: 1px solid #E2EAE5;
    padding: 10px 24px;
    border-radius: 50px;
    color: #0D2618;
    font-weight: 700;
    font-size: 1.05rem;
    margin-bottom: 30px;
}
.about-cta-phone i {
    color: #25D366;
    font-size: 1.2rem;
}
.about-cta-btns {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 14px;
}
.btn-primary-cta {
    background: #0D2618;
    color: #FFFFFF;
    font-family: 'Inter', sans-serif;
    font-size: 0.95rem;
    font-weight: 700;
    padding: 14px 34px;
    border-radius: 50px;
    border: none;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
}
.btn-primary-cta:hover {
    background: #173f29;
    color: #FFFFFF;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(13, 38, 24, 0.2);
}
.btn-outline-cta {
    background: transparent;
    color: #0D2618;
    font-family: 'Inter', sans-serif;
    font-size: 0.95rem;
    font-weight: 700;
    padding: 14px 34px;
    border-radius: 50px;
    border: 2px solid #0D2618;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
}
.btn-outline-cta:hover {
    background: #0D2618;
    color: #FFFFFF;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(13, 38, 24, 0.12);
}

/* ── Responsive Rules ────────────────────────────────────────── */
@media (max-width: 1024px) {
    .about-intro-grid { gap: 36px; }
    .commit-grid { gap: 16px; }
    .quality-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; }
}

@media (max-width: 768px) {
    .page-hero {
        padding: 90px 20px 70px;
    }
    .about-intro-section {
        padding: 50px 16px;
    }
    .about-intro-grid {
        grid-template-columns: 1fr;
        gap: 32px;
    }
    .about-intro-card {
        padding: 30px 20px;
    }
    .about-values-grid {
        grid-template-columns: 1fr;
        gap: 10px;
    }
    .commit-section {
        padding: 50px 16px;
    }
    .commit-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    .commit-card {
        padding: 28px 20px;
    }
    .quality-section {
        padding: 50px 16px;
    }
    .quality-grid {
        grid-template-columns: 1fr;
        gap: 14px;
    }
    .quality-card {
        padding: 26px 20px;
    }
    .about-cta {
        padding: 50px 16px;
    }
    .about-cta-btns {
        flex-direction: column;
        align-items: stretch;
    }
    .btn-primary-cta,
    .btn-outline-cta {
        width: 100%;
        max-width: 100%;
        justify-content: center;
        box-sizing: border-box;
    }
}

@media (max-width: 480px) {
    .about-mini-stat-num {
        font-size: 1.25rem;
    }
    .about-mini-stat-lbl {
        font-size: 0.68rem;
    }
    .about-mini-stats {
        gap: 10px;
    }
}
</style>
@endpush

@section('content')

{{-- ── SECTION 1: PAGE HERO (Standardized Clean Solid) ────────── --}}
<section class="page-hero">
    <div style="position:relative; z-index:2; max-width:800px; margin:0 auto;">
        <span class="page-hero-badge">
            <i class="fas fa-leaf" style="font-size:10px; margin-right:6px;"></i>
            Tentang Kami
        </span>
        <h1 class="page-hero-title">
            Temukan Solusi Sehat Alami <span class="gold-shimmer">Bersama Herbal Bharata</span>
        </h1>
        <div class="page-hero-divider"></div>
        <p class="page-hero-desc">
            Menghadirkan kebaikan alam pilihan untuk membantu memelihara kesehatan tubuh Anda dan keluarga secara aman.
        </p>
    </div>
</section>

{{-- ── SECTION 2: CERITA & TENTANG KAMI ────────────────────────── --}}
<section class="about-intro-section">
    <div class="about-intro-grid">

        {{-- Kolom Kiri: Kartu Identitas --}}
        <div class="about-intro-card fade-up">
            <div class="about-intro-icon">
                <i class="fas fa-seedling"></i>
            </div>
            <div class="about-intro-brand">Bharata Herbal</div>
            <div class="about-intro-tagline">
                Layanan Resmi Penyedia Produk Herbal Pilihan &amp; Terpercaya
            </div>

            {{-- Mini Stats --}}
            <div class="about-mini-stats">
                <div class="about-mini-stat-item">
                    <div class="about-mini-stat-num">5000+</div>
                    <div class="about-mini-stat-lbl">Pelanggan</div>
                </div>
                <div class="about-mini-stat-divider"></div>
                <div class="about-mini-stat-item">
                    <div class="about-mini-stat-num">100%</div>
                    <div class="about-mini-stat-lbl">Alami</div>
                </div>
                <div class="about-mini-stat-divider"></div>
                <div class="about-mini-stat-item">
                    <div class="about-mini-stat-num">BPOM</div>
                    <div class="about-mini-stat-lbl">Resmi</div>
                </div>
            </div>

            <div class="about-intro-badge-wrap">
                <span class="about-intro-badge">
                    <i class="fas fa-award" style="font-size:10px;"></i>
                    Premium Herbal
                </span>
            </div>
        </div>

        {{-- Kolom Kanan: Narasi Kisah Sesuai Konten User --}}
        <div class="fade-up fade-up-delay-1">
            <span class="about-badge">
                <i class="fas fa-heart" style="font-size:9px; margin-right:5px;"></i>
                Tentang Kami
            </span>
            <h2 class="about-intro-title">
                Membawa Kebaikan Alam untuk <em>Kesehatan Keluarga Anda</em>
            </h2>
            <p class="about-intro-desc">
                Selamat datang di layanan resmi penyedia Herbal Bharata. Kami percaya bahwa kesehatan adalah investasi paling berharga, dan alam telah menyediakan banyak jalan untuk merawatnya.
            </p>
            <p class="about-intro-desc">
                Berangkat dari kepedulian tersebut, kami hadir untuk menjembatani Anda yang sedang mencari alternatif pengobatan dan perawatan kesehatan berbahan dasar herbal. Fokus utama kami sederhana: memastikan Anda bisa mendapatkan produk-produk Herbal Bharata dengan mudah, cepat, dan didampingi informasi yang tepat sesuai kebutuhan tubuh Anda.
            </p>

            {{-- 4 Value Badges --}}
            <div class="about-values-grid">
                <div class="about-value-item">
                    <div class="about-value-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <div class="about-value-text">
                        <strong>Bahan Alami Pilihan</strong>
                        <span>Ekstrak murni tanpa bahan kimia obat</span>
                    </div>
                </div>

                <div class="about-value-item">
                    <div class="about-value-icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="about-value-text">
                        <strong>Informasi Tepat</strong>
                        <span>Pendampingan konsultasi yang ramah</span>
                    </div>
                </div>

                <div class="about-value-item">
                    <div class="about-value-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <div class="about-value-text">
                        <strong>Standar Teruji</strong>
                        <span>Legalitas resmi BPOM RI &amp; Halal MUI</span>
                    </div>
                </div>

                <div class="about-value-item">
                    <div class="about-value-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div class="about-value-text">
                        <strong>Pengiriman Cepat</strong>
                        <span>Layanan kurir ke seluruh Indonesia</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- ── SECTION 3: KOMITMEN & LAYANAN KAMI ──────────────────────── --}}
<section class="commit-section">
    <div class="section-header fade-up">
        <span class="section-header-badge">
            <i class="fas fa-bullseye" style="font-size:9px; margin-right:5px;"></i>
            Komitmen Kami
        </span>
        <h2 class="section-header-title">Komitmen &amp; Layanan Kami</h2>
        <div class="section-header-divider"></div>
    </div>

    <div class="commit-grid">

        {{-- Pilar 1 --}}
        <div class="commit-card fade-up fade-up-delay-1">
            <div>
                <div class="commit-card-top">
                    <div class="commit-card-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <div>
                        <div class="commit-card-badge">Kualitas Utama</div>
                        <h3 class="commit-card-title">Menyediakan Produk Berkualitas</h3>
                    </div>
                </div>
                <p class="commit-card-desc">
                    Kami murni berfokus menyalurkan rangkaian produk herbal Bharata yang diolah dari ekstrak bahan alami pilihan, sehingga aman dikonsumsi untuk jangka panjang tanpa khawatir efek samping bahan kimia obat.
                </p>
            </div>
            <div class="commit-tags">
                <span class="commit-tag"><i class="fas fa-check"></i> 100% Ekstrak Alami</span>
                <span class="commit-tag"><i class="fas fa-check"></i> Tanpa Efek Samping BKO</span>
            </div>
        </div>

        {{-- Pilar 2 --}}
        <div class="commit-card fade-up fade-up-delay-2">
            <div>
                <div class="commit-card-top">
                    <div class="commit-card-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <div>
                        <div class="commit-card-badge">Pendampingan</div>
                        <h3 class="commit-card-title">Tempat Konsultasi yang Nyaman</h3>
                    </div>
                </div>
                <p class="commit-card-desc">
                    Kami paham setiap orang punya keluhan kesehatan yang berbeda. Oleh karena itu, tim kami siap mendengarkan dan membantu mengarahkan pilihan produk yang paling pas untuk kondisi Anda.
                </p>
            </div>
            <div class="commit-tags">
                <span class="commit-tag"><i class="fas fa-check"></i> Siap Mendengarkan</span>
                <span class="commit-tag"><i class="fas fa-check"></i> Rekomendasi Tepat</span>
            </div>
        </div>

        {{-- Pilar 3 --}}
        <div class="commit-card fade-up fade-up-delay-3">
            <div>
                <div class="commit-card-top">
                    <div class="commit-card-icon">
                        <i class="fas fa-truck-fast"></i>
                    </div>
                    <div>
                        <div class="commit-card-badge">Bebas Ribet</div>
                        <h3 class="commit-card-title">Proses Cepat &amp; Pelayanan Ramah</h3>
                    </div>
                </div>
                <p class="commit-card-desc">
                    Mulai dari pemesanan hingga barang sampai di rumah Anda, kami berkomitmen memberikan pengalaman belanja yang aman, transparan, dan bebas ribet.
                </p>
            </div>
            <div class="commit-tags">
                <span class="commit-tag"><i class="fas fa-check"></i> Pemesanan Mudah</span>
                <span class="commit-tag"><i class="fas fa-check"></i> Pengiriman Terlacak</span>
            </div>
        </div>

    </div>
</section>

{{-- ── SECTION 4: STANDAR KUALITAS & KEAMANAN ──────────────────── --}}
<section class="quality-section">
    <div class="quality-header fade-up">
        <span class="quality-badge">
            <i class="fas fa-shield-alt" style="font-size:10px; margin-right:6px;"></i>
            Standar Mutu
        </span>
        <h2 class="quality-title">Standar Kualitas &amp; Keamanan</h2>
        <p class="quality-desc">
            Setiap produk melewati standar uji ketat untuk menjamin keamanan, kemurnian, dan keaslian bagi keluarga Anda.
        </p>
    </div>

    <div class="quality-grid">
        <div class="quality-card fade-up">
            <div class="quality-icon-wrap">
                <i class="fas fa-certificate"></i>
            </div>
            <h3>BPOM RI Terdaftar</h3>
            <p>Izin edar resmi dari BPOM RI untuk jaminan keamanan dan legalitas konsumsi.</p>
        </div>

        <div class="quality-card fade-up fade-up-delay-1">
            <div class="quality-icon-wrap">
                <i class="fas fa-moon"></i>
            </div>
            <h3>Halal Indonesia</h3>
            <p>Tersertifikasi Halal MUI untuk ketenangan ibadah dan konsumsi sehari-hari.</p>
        </div>

        <div class="quality-card fade-up fade-up-delay-2">
            <div class="quality-icon-wrap">
                <i class="fas fa-flask"></i>
            </div>
            <h3>Standar GMP</h3>
            <p>Diproses secara higienis menggunakan teknologi formulasi modern terstandarisasi.</p>
        </div>

        <div class="quality-card fade-up fade-up-delay-3">
            <div class="quality-icon-wrap">
                <i class="fas fa-leaf"></i>
            </div>
            <h3>100% Ekstrak Alami</h3>
            <p>Bahan herbal murni pilihan tanpa campuran bahan kimia obat berbahaya.</p>
        </div>
    </div>
</section>

{{-- ── SECTION 5: CTA BOTTOM BANNER ────────────────────────────── --}}
<section class="about-cta">
    <div class="about-cta-inner fade-up">
        <span class="about-cta-badge">
            <i class="fab fa-whatsapp" style="font-size:9px; margin-right:5px;"></i>
            Konsultasi &amp; Layanan Cepat
        </span>
        <h2 class="about-cta-title">
            Kesehatan yang Baik Dimulai dari <em>Pilihan yang Tepat Hari Ini</em>
        </h2>
        <p class="about-cta-desc">
            Mari kembali ke kebaikan alam bersama ragam produk pilihan dari Herbal Bharata. Punya pertanyaan seputar produk atau keluhan kesehatan Anda? Jangan ragu untuk ngobrol dengan tim kami sekarang.
        </p>

        <div>
            <div class="about-cta-phone">
                <i class="fab fa-whatsapp"></i>
                <span>+62 822-4466-4526</span>
            </div>
        </div>

        <div class="about-cta-btns">
            <a href="https://wa.me/{{ preg_replace('/\D/', '', $settings->wa_number ?? '6282244664526') }}?text=Halo%20Bharata%20Herbal%2C%20saya%20ingin%20konsultasi%20mengenai%20keluhan%20kesehatan%20dan%20produk..." target="_blank" class="btn-primary-cta">
                <i class="fab fa-whatsapp" style="font-size:1.1rem; color:#25D366;"></i>
                Konsultasi Via WhatsApp
            </a>
            <a href="{{ route('products.index') }}" class="btn-outline-cta">
                <i class="fas fa-store" style="font-size:0.9rem;"></i>
                Lihat Produk Kami
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var fadeEls = document.querySelectorAll('.fade-up');
    if (fadeEls.length > 0 && 'IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '40px 0px 40px 0px' });
        fadeEls.forEach(function (el) { observer.observe(el); });
    } else {
        fadeEls.forEach(function (el) { el.classList.add('visible'); });
    }

    setTimeout(function() {
        fadeEls.forEach(function(el) {
            if (!el.classList.contains('visible')) el.classList.add('visible');
        });
    }, 400);
});
</script>
@endpush
