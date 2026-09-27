@extends('layouts.public')
@section('title', 'Hubungi Kontak Kami')

@push('styles')
<style>
/* ── Page Hero (Clean Solid) ────────────────────────────────── */
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
    width: 60px; height: 3px;
    background: #A8DDBF;
    border-radius: 2px;
    margin: 18px auto;
}
.page-hero-desc {
    font-family: 'Inter', sans-serif;
    font-size: 0.95rem;
    color: #D1E5DB;
    max-width: 650px;
    margin: 0 auto;
    line-height: 1.7;
}

/*  Info Kontak  */
.contact-info {
    padding: 80px 40px;
    background: linear-gradient(180deg, #FFFFFF 0%, #F5F0EB 100%);
}
.contact-info-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    max-width: 1200px;
    margin: 0 auto;
}
.contact-info-card {
    background: #FFFFFF;
    border: 1px solid #E0E6E2;
    border-radius: 16px;
    padding: 32px 24px;
    text-align: center;
    transition: all 0.4s ease;
    box-shadow: 0 2px 12px rgba(0,0,0,0.02);
}
.contact-info-card:hover {
    transform: translateY(-6px);
    border-color: #0D2618;
    box-shadow: 0 12px 50px rgba(13, 38, 24, 0.06);
}
.contact-info-card .icon-circle {
    width: 64px; height: 64px;
    background: rgba(13, 38, 24, 0.08);
    border: 2px solid rgba(13, 38, 24, 0.15);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px auto;
    transition: all 0.3s ease;
}
.contact-info-card:hover .icon-circle {
    border-color: #0D2618;
    background: rgba(13, 38, 24, 0.12);
}
.contact-info-card .icon-circle i {
    color: #0D2618;
    font-size: 1.8rem;
}
.contact-info-card h3 {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: 1.2rem;
    color: #0D2618;
    margin-bottom: 8px;
}
.contact-info-card p {
    font-family: 'Inter', sans-serif;
    font-size: 0.95rem;
    color: #6A7A72;
    line-height: 1.6;
    margin-bottom: 12px;
}
.contact-info-card .btn-chat {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #0D2618;
    color: #FFFFFF;
    font-weight: 700;
    font-size: 0.85rem;
    padding: 8px 20px;
    border-radius: 50px;
    transition: all 0.3s ease;
    font-family: 'Inter', sans-serif;
    border: none;
    cursor: pointer;
    text-decoration: none;
}
.contact-info-card .btn-chat:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 30px rgba(13, 38, 24, 0.25);
}

/* ── Metode Pembayaran (Solid) ────────────────────────────── */
.payment-section {
    padding: 70px 20px;
    background: #0D2618;
    text-align: center;
}
.payment-inner {
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
}
.payment-title {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: clamp(1.8rem, 3.5vw, 2.5rem);
    font-weight: 700;
    color: #FFFFFF;
    margin: 0 auto 8px auto;
    text-align: center;
}
.payment-desc {
    font-family: 'Inter', sans-serif;
    font-size: 0.95rem;
    color: #D1E5DB;
    max-width: 600px;
    margin: 8px auto 0 auto;
    line-height: 1.7;
    text-align: center;
}
.payment-grid {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 14px;
    max-width: 780px;
    margin: 32px auto 0 auto;
}
.payment-item {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(168, 221, 191, 0.2);
    border-radius: 14px;
    padding: 16px 18px;
    text-align: center;
    transition: all 0.3s ease;
    cursor: default;
    min-width: 110px;
    flex: 1 1 110px;
    max-width: 140px;
}
.payment-item:hover {
    border-color: #A8DDBF;
    transform: translateY(-4px);
    background: rgba(255, 255, 255, 0.09);
}
.payment-item i {
    color: #A8DDBF;
    font-size: 1.5rem;
    display: block;
    margin-bottom: 8px;
}
.payment-item strong {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: 0.9rem;
    color: #FFFFFF;
    display: block;
    font-weight: 700;
}
.payment-item span {
    font-family: 'Inter', sans-serif;
    font-size: 0.68rem;
    color: #A8DDBF;
    font-weight: 500;
    display: block;
    margin-top: 2px;
}

/* ── Konsultasi (Solid) ────────────────────────────────────── */
.consult-section {
    padding: 70px 20px;
    background: #F8FAF7;
    text-align: center;
}
.consult-inner {
    max-width: 700px;
    margin: 0 auto;
    text-align: center;
}
.consult-title {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: clamp(2rem, 3.5vw, 2.8rem);
    font-weight: 800;
    color: #0D2618;
    margin: 0 auto 8px auto;
    text-align: center;
}
.consult-desc {
    font-family: 'Inter', sans-serif;
    font-size: 0.95rem;
    color: #6A7A72;
    max-width: 600px;
    margin: 8px auto 32px auto;
    line-height: 1.8;
    text-align: center;
}
.cta-buttons-contact {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    gap: 16px;
    margin: 0 auto;
}
.btn-whatsapp {
    background: linear-gradient(135deg, #0D2618, #0D2618);
    color: #FFFFFF;
    font-weight: 700;
    padding: 16px 40px;
    border-radius: 50px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    font-family: 'Inter', sans-serif;
    font-size: 1rem;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
}
.btn-whatsapp:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 40px rgba(13, 38, 24, 0.25);
}
.btn-whatsapp i { font-size: 1.2rem; }

.btn-outline-gold {
    background: transparent;
    color: #0D2618;
    font-weight: 700;
    padding: 16px 40px;
    border-radius: 50px;
    border: 2px solid #0D2618;
    cursor: pointer;
    transition: all 0.3s ease;
    font-family: 'Inter', sans-serif;
    font-size: 1rem;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
}
.btn-outline-gold:hover {
    background: #0D2618;
    color: #FFFFFF;
    transform: scale(1.05);
    box-shadow: 0 8px 40px rgba(13, 38, 24, 0.1);
}
.btn-outline-gold i { font-size: 1rem; }

/* ── Responsive ────────────────────────────────────────────── */
@media (max-width: 1024px) {
    .contact-info { padding: 60px 24px; }
    .contact-info-grid { grid-template-columns: repeat(2, 1fr); }
    .payment-section { padding: 60px 24px; }
    .consult-section { padding: 60px 24px; }
}
@media (max-width: 768px) {
    .page-hero { padding: 90px 20px 70px; }
    .contact-info { padding: 40px 20px; }
    .contact-info-grid { grid-template-columns: 1fr; gap: 16px; }
    .payment-section { padding: 40px 20px; }
    .payment-grid { gap: 10px; }
    .payment-item { min-width: 95px; max-width: 110px; padding: 12px 10px; }
    .consult-section { padding: 40px 20px; }
    .cta-buttons-contact { flex-direction: column; align-items: center; }
    .btn-whatsapp, .btn-outline-gold { width: 100%; justify-content: center; max-width: 100%; }
}

/*  Animations  */
.fade-up {
    opacity: 0;
    transform: translateY(40px);
    transition: opacity 0.7s ease, transform 0.7s ease;
}
.fade-up.visible {
    opacity: 1;
    transform: translateY(0);
}
</style>
@endpush

@section('content')

<!-- ── Page Hero ────────────────────────────────────────── -->
<section class="page-hero">
    <div style="position:relative; z-index:2; max-width:800px; margin:0 auto;">
        <span class="page-hero-badge">
            <i class="fas fa-phone-alt" style="font-size:10px; margin-right:6px;"></i>
            Hubungi Kami
        </span>
        <h1 class="page-hero-title">
            Hubungi <span class="gold-shimmer">Layanan Kami</span>
        </h1>
        <div class="page-hero-divider"></div>
        <p class="page-hero-desc">
            Tim terapis &amp; admin kami siap menjawab segala keluhan dan pertanyaan pesanan Anda.
        </p>
    </div>
</section>

<!-- ── INFO KONTAK ──────────────────────────────────────── -->
<section class="contact-info">
    <div class="contact-info-grid">
        <!-- WhatsApp -->
        <div class="contact-info-card fade-up">
            <div class="icon-circle"><i class="fab fa-whatsapp"></i></div>
            <h3>WhatsApp</h3>
            <p>+62 822-4466-4526</p>
            <a href="https://wa.me/{{ preg_replace('/\D/', '', $settings->wa_number ?? '6282244664526') }}?text=Halo%20Bharata%20Herbal%2C%20saya%20ingin%20bertanya..." target="_blank" class="btn-chat">
                <i class="fab fa-whatsapp" style="font-size:14px;"></i>
                Chat Sekarang
            </a>
        </div>

        <!-- Alamat Pengiriman (Disamarkan Profesional) -->
        <div class="contact-info-card fade-up" style="transition-delay:0.08s;">
            <div class="icon-circle"><i class="fas fa-map-marker-alt"></i></div>
            <h3>Layanan Pengiriman</h3>
            <p>Indonesia &bull; Layanan Pengiriman Resmi &amp; Terpercaya ke Seluruh Wilayah Indonesia</p>
        </div>

        <!-- Jam Operasional -->
        <div class="contact-info-card fade-up" style="transition-delay:0.16s;">
            <div class="icon-circle"><i class="fas fa-clock"></i></div>
            <h3>Jam Operasional</h3>
            <p>{{ $settings->operating_hours ?? 'Senin – Sabtu, 08.00 – 17.00 WIB' }}</p>
        </div>
    </div>
</section>

<!-- ── METODE PEMBAYARAN (Virtual Account) ─────────────── -->
<section class="payment-section fade-up">
    <div class="payment-inner">
        <span style="display:inline-flex; align-items:center; background:rgba(255,255,255,0.1); color:#FFFFFF; border:1px solid rgba(255,255,255,0.2); border-radius:50px; padding:6px 20px; font-size:0.7rem; letter-spacing:2px; text-transform:uppercase; font-weight:600; margin-bottom:16px;">
            <i class="fas fa-credit-card" style="font-size:10px; margin-right:6px;"></i>
            Metode Pembayaran
        </span>
        <h2 class="payment-title">Metode Pembayaran Digital</h2>
        <p class="payment-desc">Kami menerima pembayaran otomatis terverifikasi 24/7 melalui Virtual Account bank nasional terkemuka.</p>

        @php
            $vaBanks = [
                ['name' => 'BCA', 'label' => 'Virtual Account', 'icon' => 'fa-university'],
                ['name' => 'Mandiri', 'label' => 'Virtual Account', 'icon' => 'fa-university'],
                ['name' => 'BNI', 'label' => 'Virtual Account', 'icon' => 'fa-university'],
                ['name' => 'BRI', 'label' => 'Virtual Account', 'icon' => 'fa-university'],
                ['name' => 'Permata', 'label' => 'Virtual Account', 'icon' => 'fa-university'],
                ['name' => 'Bank Lain', 'label' => 'Virtual Account', 'icon' => 'fa-wallet'],
            ];
        @endphp

        <div class="payment-grid">
            @foreach($vaBanks as $va)
            <div class="payment-item fade-up" style="transition-delay:{{ 0.04 * $loop->iteration }}s;">
                <i class="fas {{ $va['icon'] }}"></i>
                <strong>{{ $va['name'] }}</strong>
                <span>{{ $va['label'] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ── KONSULTASI ──────────────────────────────────────── -->
<section class="consult-section fade-up">
    <div class="consult-inner">
        <span style="display:inline-flex; align-items:center; background:rgba(13,38,24,0.08); color:#0D2618; border:1px solid rgba(13,38,24,0.15); border-radius:50px; padding:6px 20px; font-size:0.7rem; letter-spacing:2px; text-transform:uppercase; font-weight:600; margin-bottom:16px;">
            <i class="fas fa-headset" style="font-size:10px; margin-right:6px;"></i>
            Konsultasi &amp; Layanan Cepat
        </span>
        <h2 class="consult-title">Konsultasi &amp; Layanan Cepat</h2>
        <p class="consult-desc">Kami menyambut baik kritik, saran, atau sekadar konsultasi keluhan penyakit secara personal dan rahasia.</p>

        <div class="cta-buttons-contact">
            <a href="https://wa.me/{{ preg_replace('/\D/', '', $settings->wa_number ?? '6282244664526') }}?text=Halo%20Bharata%20Herbal%2C%20saya%20ingin%20bertanya..." target="_blank" class="btn-whatsapp">
                <i class="fab fa-whatsapp"></i>
                Hubungi Via WhatsApp
            </a>
            <a href="{{ route('products.index') }}" class="btn-outline-gold">
                <i class="fas fa-leaf"></i>
                Lihat Produk Kami
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var revealElements = document.querySelectorAll('.fade-up');
    if (revealElements.length > 0 && 'IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0, rootMargin: '80px 0px 80px 0px' });
        revealElements.forEach(function(el) { observer.observe(el); });
    } else {
        revealElements.forEach(function(el) { el.classList.add('visible'); });
    }
    setTimeout(function() {
        revealElements.forEach(function(el) {
            if (!el.classList.contains('visible')) el.classList.add('visible');
        });
    }, 300);
});
</script>
@endpush