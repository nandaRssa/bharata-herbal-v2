@extends('layouts.public')
@section('title', 'Beranda | Toko Herbal Premium Indonesia')

@push('styles')
<style>
/* ── Hero Section ────────────────────────────────────────────── */
.bharata-hero {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    overflow: hidden;
    background: #0A120E;
}
.bharata-hero-bg {
    position: absolute;
    inset: 0;
    background-image: url('{{ asset('images/herbal.jpg') }}');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    will-change: transform;
    transition: transform 10s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.bharata-hero:hover .bharata-hero-bg {
    transform: scale(1.06);
}
.bharata-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to right, rgb(15 51 31 / 88%) 0%, rgb(17 53 31 / 60%) 35%, rgba(90, 168, 122, 0.25) 60%, rgba(168, 221, 191, 0.06) 80%, transparent 100%);
    z-index: 2;
}
/* Green glow accent */
.bharata-hero-glow {
    position: absolute;
    top: 50%;
    left: 40%;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(45,107,68,0.15) 0%, transparent 70%);
    border-radius: 50%;
    filter: blur(60px);
    pointer-events: none;
    z-index: 1;
}
/* Decorative top & bottom lines */
.bharata-hero::before,
.bharata-hero::after {
    content: '';
    position: absolute;
    left: 0;
    right: 0;
    height: 1px;
    z-index: 5;
    background: linear-gradient(to right, transparent, rgba(255,255,255,0.25), transparent);
}
.bharata-hero::before { top: 0; }
.bharata-hero::after { bottom: 0; }

/* ── Vertical Line ──────────────────────────────────────────── */
.bharata-hero-line {
    position: absolute;
    left: 60px;
    top: 15%;
    bottom: 15%;
    width: 2px;
    z-index: 5;
    background: linear-gradient(to bottom, transparent, rgba(255,255,255,0.5), transparent);
}
.bharata-hero-line::after {
    content: '';
    position: absolute;
    left: -3px;
    bottom: -4px;
    width: 8px;
    height: 8px;
    background: #FFFFFF;
    transform: rotate(45deg);
    box-shadow: 0 0 12px rgba(212,175,55,0.5);
}

/* ── Gold Particles ──────────────────────────────────────────── */
.gold-particle {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
    z-index: 3;
    background: #FFFFFF;
    box-shadow: 0 0 8px rgba(255,255,255,0.5);
    animation: float-particle 7s infinite ease-in-out;
}
.gold-particle:nth-child(1)  { top: 18%; left: 58%; width: 4px; height: 4px; animation-delay: 0s; }
.gold-particle:nth-child(2)  { top: 42%; left: 72%; width: 3px; height: 3px; animation-delay: 1.2s; }
.gold-particle:nth-child(3)  { top: 62%; left: 68%; width: 5px; height: 5px; animation-delay: 2.8s; }
.gold-particle:nth-child(4)  { top: 28%; left: 82%; width: 2px; height: 2px; animation-delay: 0.6s; }
.gold-particle:nth-child(5)  { top: 72%; left: 78%; width: 3px; height: 3px; animation-delay: 3.5s; }
.gold-particle:nth-child(6)  { top: 50%; left: 55%; width: 2px; height: 2px; animation-delay: 4.8s; }
.gold-particle:nth-child(7)  { top: 10%; left: 70%; width: 4px; height: 4px; animation-delay: 1.8s; }
.gold-particle:nth-child(8)  { top: 80%; left: 60%; width: 3px; height: 3px; animation-delay: 5.2s; }

@keyframes float-particle {
    0%, 100% { transform: translateY(0) translateX(0); opacity: 0; }
    15% { opacity: 1; }
    50% { transform: translateY(-35px) translateX(18px); opacity: 0.7; }
    85% { opacity: 1; }
}

/* ── Floating Leaves ─────────────────────────────────────────── */
.floating-leaf {
    position: absolute;
    z-index: 3;
    pointer-events: none;
    opacity: 0.1;
    animation: leaf-float 14s infinite ease-in-out;
}
.floating-leaf.gold { color: #FFFFFF; }
.floating-leaf.green { color: #5AA87A; }
.floating-leaf:nth-child(9)  { top: 12%; right: 12%; font-size: 32px; animation-delay: 0s; }
.floating-leaf:nth-child(10) { top: 50%; right: 8%;  font-size: 22px; animation-delay: 4.5s; }
.floating-leaf:nth-child(11) { top: 32%; right: 22%; font-size: 20px; animation-delay: 2.2s; }
.floating-leaf:nth-child(12) { top: 68%; right: 14%; font-size: 28px; animation-delay: 6.5s; }

@keyframes leaf-float {
    0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.06; }
    25% { transform: translateY(-18px) rotate(6deg); opacity: 0.14; }
    50% { transform: translateY(-6px) rotate(-4deg); opacity: 0.10; }
    75% { transform: translateY(-22px) rotate(10deg); opacity: 0.14; }
}

/* ── Hero Content ────────────────────────────────────────────── */
.bharata-hero-content {
    position: relative;
    z-index: 10;
    width: 100%;
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 60px 0 100px;
}
.bharata-hero-inner {
    max-width: 560px;
}

.bharata-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 7px 18px;
    border-radius: 100px;
    font-family: 'Inter', sans-serif;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: #FFFFFF;
    border: 1px solid rgba(255,255,255,0.3);
    background: #0D2618;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    margin-bottom: 28px;
    animation: fadeInUp 0.9s ease forwards;
}

.bharata-hero-title {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: clamp(2.2rem, 5vw, 4.5rem);
    font-weight: 700;
    line-height: 1.08;
    color: #FFFFFF;
    margin-bottom: 16px;
    opacity: 0;
    animation: fadeInUp 0.9s ease 0.15s forwards;
}
.bharata-hero-title .gold {
    background: linear-gradient(135deg, #FFFFFF 0%, #F0EDE8 40%, #FFFFFF 70%, #F0EDE8 100%);
    background-size: 200% auto;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: shimmer 4s ease-in-out infinite;
}
@keyframes shimmer {
    0%, 100% { background-position: 0% center; }
    50% { background-position: 100% center; }
}

.bharata-hero-subtitle {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-style: italic;
    font-size: clamp(1.1rem, 2vw, 1.5rem);
    font-weight: 400;
    color: #7CC89A;
    margin-bottom: 20px;
    line-height: 1.45;
    opacity: 0;
    animation: fadeInUp 0.9s ease 0.3s forwards;
}

.bharata-hero-desc {
    font-family: 'Inter', sans-serif;
    font-size: clamp(0.9rem, 1.1vw, 1rem);
    font-weight: 300;
    color: #A8DDBF;
    line-height: 1.75;
    margin-bottom: 32px;
    opacity: 0;
    animation: fadeInUp 0.9s ease 0.45s forwards;
}

.bharata-hero-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 14px;
    opacity: 0;
    animation: fadeInUp 0.9s ease 0.6s forwards;
}
.bharata-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 15px 34px;
    border-radius: 8px;
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    font-weight: 600;
    color: #0D2618;
    background: #FFFFFF;
    text-decoration: none;
    transition: all 0.35s cubic-bezier(.4,0,.2,1);
    box-shadow: 0 4px 24px rgba(255,255,255,0.30);
    border: none;
    cursor: pointer;
}
.bharata-btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 36px rgba(255,255,255,0.40);
    background: #F0EDE8;
}
.bharata-btn-primary:active {
    transform: translateY(-1px) scale(0.98);
}
.bharata-btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 15px 34px;
    border-radius: 8px;
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    font-weight: 500;
    color: #FFFFFF;
    background: transparent;
    border: 1px solid rgba(255,255,255,0.18);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    text-decoration: none;
    transition: all 0.35s cubic-bezier(.4,0,.2,1);
    cursor: pointer;
}
.bharata-btn-secondary:hover {
    background: rgba(90,168,122,0.08);
    border-color: rgba(90,168,122,0.25);
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(13, 38, 24, 0.35);
}
.bharata-btn-secondary:active {
    transform: translateY(-1px) scale(0.98);
}

.bharata-trust {
    display: flex;
    flex-wrap: wrap;
    gap: 24px;
    margin-top: 40px;
    opacity: 0;
    animation: fadeInUp 0.9s ease 0.75s forwards;
}
.bharata-trust-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-family: 'Inter', sans-serif;
    font-size: 12px;
    font-weight: 500;
    color: rgba(255,255,255,0.65);
    transition: all 0.3s ease;
    cursor: default;
    text-decoration: none;
}
.bharata-trust-item:hover {
    color: #FFFFFF;
}
.bharata-trust-item .check {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.12);
    color: #FFFFFF;
    font-size: 10px;
    transition: all 0.35s ease;
    flex-shrink: 0;
}
.bharata-trust-item:hover .check {
    background: #FFFFFF;
    color: #0A120E;
    transform: scale(1.1);
    box-shadow: 0 0 16px rgba(255,255,255,0.35);
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(28px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Section Shared ──────────────────────────────────────────── */
.bharata-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px;
}
.bharata-section-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-family: 'Inter', sans-serif;
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: #FFFFFF;
    margin-bottom: 14px;
}
.bharata-section-title {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: clamp(1.8rem, 3.5vw, 2.8rem);
    font-weight: 700;
    color: #0D2618;
    margin-bottom: 12px;
    line-height: 1.2;
}
.bharata-section-desc {
    font-family: 'Inter', sans-serif;
    font-size: 15px;
    font-weight: 300;
    color: #8AA899;
    max-width: 540px;
    margin: 0 auto;
    line-height: 1.65;
}

/* ── Certification Bar ───────────────────────────────────────── */
.bharata-cert {
    background: #F8FAF7;
    padding: 80px 0 90px;
    position: relative;
    overflow: hidden;
}
.bharata-cert-header {
    text-align: center;
    position: relative;
    z-index: 2;
    margin-bottom: 50px;
}
.bharata-cert-header .bharata-section-badge {
    justify-content: center;
    color: #0D2618;
}
.bharata-cert-title {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: clamp(1.6rem, 3vw, 2.4rem);
    font-weight: 700;
    color: #0F172A;
    margin-bottom: 10px;
    line-height: 1.2;
}
.bharata-cert-title .gold {
    color: #0F172A;
}
.bharata-cert-sub {
    font-family: 'Inter', sans-serif;
    font-size: 15px;
    font-weight: 400;
    color: #475569;
    max-width: 480px;
    margin: 0 auto;
    line-height: 1.6;
}
.bharata-cert-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
    position: relative;
    z-index: 2;
}
.bharata-cert-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 40px 24px 36px;
    border-radius: 16px;
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    position: relative;
    transition: all 0.4s cubic-bezier(.4,0,.2,1);
    text-decoration: none;
    opacity: 0;
    transform: translateY(24px);
}
.bharata-cert-item:hover {
    transform: translateY(-6px);
    border-color: #0D2618;
    box-shadow: 0 12px 40px rgba(13, 38, 24, 0.08);
}
.bharata-cert-item.visible {
    opacity: 1;
    transform: translateY(0);
}
.bharata-cert-item-inner {
    position: relative;
    z-index: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
}
.bharata-cert-icon {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #E8F0EC;
    color: #0D2618;
    font-size: 1.8rem;
    margin-bottom: 16px;
    transition: all 0.4s ease;
    flex-shrink: 0;
    position: relative;
}
.bharata-cert-item:hover .bharata-cert-icon {
    transform: scale(1.05);
    box-shadow: 0 0 20px rgba(13, 38, 24, 0.12);
}
.bharata-cert-label {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: 18px;
    font-weight: 700;
    color: #0D2618;
    margin-bottom: 4px;
}
.bharata-cert-desc {
    font-family: 'Inter', sans-serif;
    font-size: 12px;
    font-weight: 400;
    color: #475569;
    line-height: 1.4;
}
.bharata-cert-divider {
    width: 30px;
    height: 2px;
    background: #0D2618;
    margin: 10px 0 12px;
    border-radius: 2px;
}

/* ── Premium Collection ──────────────────────────────────────── */
.bharata-collection {
    padding: 100px 0;
    background: #FFFFFF;
    position: relative;
    overflow: hidden;
}
.bharata-collection .bharata-container {
    position: relative;
    z-index: 1;
}
.bharata-collection .bharata-section-header {
    text-align: center;
    margin-bottom: 56px;
}
.bharata-collection .bharata-section-header .bharata-section-badge {
    justify-content: center;
    color: #0D2618;
}
.bharata-collection .bharata-section-title {
    color: #0F172A;
}
.bharata-collection .bharata-section-desc {
    color: #475569;
}
.bharata-collection-divider {
    width: 50px;
    height: 2px;
    background: #0D2618;
    margin: 0 auto 16px;
    border-radius: 2px;
}
.bharata-product-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
    padding: 0 2px;
}
.bharata-product-card {
    background: #FFFFFF;
    border: 1px solid #F1F4F2;
    border-radius: 12px;
    padding: 12px;
    transition: all 0.4s cubic-bezier(.4,0,.2,1);
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    display: flex;
    flex-direction: column;
    height: 100%;
    min-height: 220px;
    opacity: 0;
    transform: translateY(30px);
}
.bharata-product-card.visible {
    opacity: 1;
    transform: translateY(0);
}
.bharata-product-card:hover {
    transform: translateY(-4px);
    border-color: #0D2618;
    box-shadow: 0 12px 50px rgba(0,0,0,0.08);
}
.bharata-product-image {
    aspect-ratio: 1/1;
    background: #F8FAF7;
    border-radius: 8px;
    overflow: hidden;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}
.bharata-product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}
.bharata-product-card:hover .bharata-product-image img {
    transform: scale(1.08);
}
.bharata-product-icon-fallback {
    color: #0D2618;
    font-size: 48px;
    opacity: 0.3;
}
.bharata-product-discount {
    position: absolute;
    top: 6px;
    right: 6px;
    background: #0D2618;
    color: #FFFFFF;
    font-family: 'Inter', sans-serif;
    font-size: 0.6rem;
    font-weight: 700;
    padding: 2px 10px;
    border-radius: 4px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.1);
    z-index: 2;
}
.bharata-product-info {
    padding: 8px 0 0;
    display: flex;
    flex-direction: column;
    flex: 1;
}
.bharata-product-name {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: 0.85rem;
    font-weight: 600;
    color: #0F172A;
    margin: 8px 0 4px 0;
    line-height: 1.2;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 2.4rem;
}
.bharata-product-benefits {
    margin: 4px 0 8px 0;
    flex: 1;
}
.bharata-product-benefits li {
    font-family: 'Inter', sans-serif;
    font-size: 0.65rem;
    color: #475569;
    list-style: none;
    padding: 1px 0;
    display: flex;
    align-items: center;
    gap: 4px;
}
.bharata-product-benefits li::before {
    content: '\2713';
    color: #0D2618;
    font-weight: 700;
    font-size: 0.6rem;
}
.bharata-product-rating {
    display: flex;
    align-items: center;
    gap: 4px;
    flex-wrap: wrap;
    margin: 2px 0 6px;
    min-height: 0;
}
.bharata-product-rating .stars { display: flex; align-items: center; gap: 1px; }
.bharata-product-rating .stars i { font-size: 0.6rem; }
.bharata-product-rating .stars .fa-star,
.bharata-product-rating .stars .fa-star-half-alt { color: #C9A227; }
.bharata-product-rating .stars .far.fa-star { color: #D4DCD6; }
.bharata-product-rating .rating-value {
    font-family: 'Inter', sans-serif;
    font-size: 0.7rem;
    font-weight: 600;
    color: #475569;
}
.bharata-product-rating .rating-separator { color: #D4DCD6; font-size: 0.5rem; }
.bharata-product-rating .rating-sold {
    font-family: 'Inter', sans-serif;
    font-size: 0.6rem;
    color: #94A3B8;
}
.bharata-product-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 4px;
    padding-top: 8px;
    border-top: 1px solid #E2E8F0;
}
.bharata-product-prices {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 1px;
}
.bharata-product-price {
    font-family: 'Inter', sans-serif;
    font-size: 0.9rem;
    font-weight: 700;
    color: #0D2618;
}
.bharata-product-price-old {
    font-family: 'Inter', sans-serif;
    font-size: 0.65rem;
    color: #94A3B8;
    text-decoration: line-through;
}
.bharata-product-link {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #0D2618;
    background: transparent;
    border: 1px solid #E2E8F0;
    text-decoration: none;
    transition: all 0.35s ease;
    flex-shrink: 0;
    font-size: 0.7rem;
}
.bharata-product-link:hover {
    background: #0D2618;
    color: #FFFFFF;
    transform: scale(1.1);
    box-shadow: 0 4px 20px rgba(13, 38, 24, 0.15);
}
.bharata-collection-footer {
    text-align: center;
    margin-top: 48px;
}
.bharata-collection-footer a {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 48px;
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    font-weight: 600;
    color: #FFFFFF;
    background: #0D2618;
    text-decoration: none;
    border-radius: 50px;
    transition: all 0.35s cubic-bezier(.4,0,.2,1);
    box-shadow: 0 4px 24px rgba(13, 38, 24, 0.2);
    letter-spacing: 0.5px;
}
.bharata-collection-footer a:hover {
    gap: 14px;
    transform: scale(1.05);
    box-shadow: 0 8px 36px rgba(13, 38, 24, 0.3);
}

/* ── Keunggulan Kami ─────────────────────────────────────────── */
.bharata-heritage {
    padding: 100px 0;
    background: #F8FAF7;
    position: relative;
    overflow: hidden;
}
.bharata-heritage-header {
    text-align: center;
    margin-bottom: 56px;
    position: relative;
    z-index: 1;
}
.bharata-heritage-header .bharata-section-badge {
    justify-content: center;
    color: #0D2618;
}
.bharata-heritage-title {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: clamp(1.6rem, 3vw, 2.5rem);
    font-weight: 700;
    color: #0F172A;
    margin-bottom: 12px;
    line-height: 1.2;
}
.bharata-heritage-subtitle {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-style: italic;
    font-size: 1rem;
    font-weight: 400;
    color: #0D2618;
    margin: 0 0 12px 0;
}
.bharata-heritage-header .bharata-section-desc {
    color: #475569;
    max-width: 600px;
    margin: 0 auto;
}
.bharata-heritage-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
    margin-bottom: 56px;
    position: relative;
    z-index: 1;
}
.bharata-heritage-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 36px 20px 32px;
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    transition: all 0.4s cubic-bezier(.4,0,.2,1);
}
.bharata-heritage-item:hover {
    transform: translateY(-8px);
    border-color: #0D2618;
    box-shadow: 0 12px 50px rgba(13, 38, 24, 0.08);
}
.bharata-heritage-icon {
    width: 64px;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #E8F0EC;
    color: #0D2618;
    font-size: 1.5rem;
    margin-bottom: 16px;
    transition: all 0.3s ease;
    flex-shrink: 0;
}
.bharata-heritage-item:hover .bharata-heritage-icon {
    transform: scale(1.1);
    background: #0D2618;
    color: #FFFFFF;
}
.bharata-heritage-item h4 {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: 1.2rem;
    font-weight: 600;
    color: #0F172A;
    margin-bottom: 8px;
}
.bharata-heritage-item p {
    font-family: 'Inter', sans-serif;
    font-size: 0.9rem;
    font-weight: 400;
    color: #475569;
    line-height: 1.6;
    margin: 0;
}
.bharata-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 16px;
    padding: 36px 20px;
    margin-top: 40px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
}
.bharata-stat-card {
    padding: 0 20px;
    text-align: center;
    transition: all 0.35s cubic-bezier(.4,0,.2,1);
    position: relative;
}
.bharata-stat-card + .bharata-stat-card {
    border-left: 1px solid #E2E8F0;
}
.bharata-stat-card:hover .bharata-stat-num {
    transform: scale(1.05);
}
.bharata-stat-num {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: 2.5rem;
    font-weight: 700;
    color: #0D2618;
    margin-bottom: 4px;
    line-height: 1.1;
    transition: transform 0.3s ease;
    display: inline-block;
}
.bharata-stat-label {
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    font-weight: 500;
    color: #475569;
    margin-top: 4px;
}

/* ── Testimonials ────────────────────────────────────────────── */
.bharata-testimonials {
    padding: 100px 0;
    background: #FFFFFF;
    position: relative;
}
.bharata-testimonial-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}
.bharata-testimonial-card {
    background: #FFFFFF;
    border-radius: 16px;
    padding: 28px 24px;
    border: 1px solid #E2E8F0;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    transition: all 0.4s cubic-bezier(.4,0,.2,1);
    position: relative;
    opacity: 0;
    transform: translateY(30px);
}
.bharata-testimonial-card.visible {
    opacity: 1;
    transform: translateY(0);
}
.bharata-testimonial-card:hover {
    transform: translateY(-6px);
    border: 1px solid #0D2618;
    box-shadow: 0 12px 50px rgba(13, 38, 24, 0.08);
}
.bharata-testimonial-quote {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: 4rem;
    font-weight: 700;
    line-height: 0.7;
    color: rgba(13, 38, 24, 0.06);
    position: absolute;
    top: -4px;
    left: 16px;
    font-style: italic;
}
.bharata-testimonial-stars {
    display: flex;
    gap: 2px;
    margin-bottom: 12px;
    color: #C9A227;
    font-size: 14px;
    position: relative;
    z-index: 1;
}
.bharata-testimonial-text {
    font-family: 'Inter', sans-serif;
    font-size: 0.95rem;
    font-weight: 400;
    color: #475569;
    line-height: 1.8;
    margin: 8px 0 20px;
    font-style: italic;
    padding-top: 8px;
    position: relative;
    z-index: 1;
}
.bharata-testimonial-author {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid #E2E8F0;
}
.bharata-testimonial-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #E8F0EC;
    border: 2px solid #E8F0EC;
    color: #0D2618;
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: 1.2rem;
    font-weight: 700;
    flex-shrink: 0;
}
.bharata-testimonial-name {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: 1rem;
    font-weight: 600;
    color: #0F172A;
}
.bharata-testimonial-role {
    font-family: 'Inter', sans-serif;
    font-size: 0.8rem;
    color: #0D2618;
    font-weight: 400;
}

/* ── Final CTA ───────────────────────────────────────────────── */
.bharata-cta {
    padding: 90px 0;
    background: #0D2618;
    position: relative;
    text-align: center;
}
.bharata-cta .bharata-container {
    position: relative;
    z-index: 2;
}
.bharata-cta .bharata-section-title {
    color: #FFFFFF;
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: clamp(1.8rem, 3.5vw, 2.6rem);
    font-weight: 700;
}
.bharata-cta .bharata-section-title .gold {
    color: #A8DDBF;
}
.bharata-cta .bharata-section-desc {
    color: #D1E5DB;
    max-width: 600px;
    margin: 16px auto 32px;
    line-height: 1.8;
    font-family: 'Inter', sans-serif;
    font-size: 1rem;
}
.bharata-cta-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    justify-content: center;
}
.bharata-cta-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(168, 221, 191, 0.12);
    color: #A8DDBF;
    padding: 6px 20px;
    border-radius: 50px;
    font-size: 0.75rem;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 20px;
    border: 1px solid rgba(168, 221, 191, 0.25);
    font-weight: 600;
}
.bharata-cta-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 40px;
    border-radius: 50px;
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    font-weight: 600;
    color: #0D2618;
    background: #FFFFFF;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 24px rgba(255,255,255,0.3);
    border: none;
    cursor: pointer;
}
.bharata-cta-btn-primary:hover {
    transform: scale(1.05);
    background: #F0EDE8;
    box-shadow: 0 8px 40px rgba(255,255,255,0.4);
}
.bharata-cta-btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 14px 40px;
    border-radius: 50px;
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    font-weight: 600;
    color: #FFFFFF;
    background: transparent;
    border: 2px solid rgba(255,255,255,0.25);
    text-decoration: none;
    transition: all 0.3s ease;
    cursor: pointer;
}
.bharata-cta-btn-secondary:hover {
    background: rgba(255,255,255,0.08);
    color: #FFFFFF;
    transform: scale(1.05);
    box-shadow: 0 8px 40px rgba(13, 38, 24, 0.15);
}

/* ── Scroll Animations ───────────────────────────────────────── */
.bharata-fade {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.7s ease, transform 0.7s ease;
}
.bharata-fade.visible {
    opacity: 1;
    transform: translateY(0);
}

/* ── Responsive Rules ────────────────────────────────────────── */
@media (min-width: 768px) {
    .bharata-product-grid { grid-template-columns: repeat(3, 1fr); gap: 16px; }
    .bharata-product-card { padding: 14px; min-height: 240px; }
    .bharata-product-card .bharata-product-name { font-size: 0.9rem; }
    .bharata-product-card .bharata-product-price { font-size: 0.95rem; }
    .bharata-product-card .bharata-product-benefits li { font-size: 0.7rem; }
}
@media (min-width: 1024px) {
    .bharata-product-grid { grid-template-columns: repeat(4, 1fr); gap: 20px; }
    .bharata-product-card { padding: 16px; min-height: 280px; }
    .bharata-product-card .bharata-product-name { font-size: 1rem; }
    .bharata-product-card .bharata-product-price { font-size: 1.05rem; }
    .bharata-product-card .bharata-product-benefits li { font-size: 0.75rem; }
    .bharata-product-card .bharata-product-rating .stars i { font-size: 0.7rem; }
    .bharata-product-card .bharata-product-rating .rating-value { font-size: 0.75rem; }
    .bharata-product-card .bharata-product-rating .rating-sold { font-size: 0.65rem; }
}
@media (min-width: 1280px) {
    .bharata-product-grid { gap: 24px; }
    .bharata-product-card { padding: 20px; }
}
@media (max-width: 1024px) {
    .bharata-hero { min-height: 90vh; }
    .bharata-hero-content { padding: 0 40px 0 80px; }
    .bharata-hero-line { left: 40px; }
    .bharata-hero-line::after { left: -3px; }
    .bharata-hero-inner { max-width: 480px; }
    .bharata-heritage-grid { grid-template-columns: repeat(2, 1fr); gap: 18px; }
    .bharata-cert-grid { grid-template-columns: repeat(2, 1fr); gap: 18px; }
}
@media (max-width: 768px) {
    .bharata-hero { min-height: 85vh; align-items: flex-end; padding-bottom: 60px; }
    .bharata-hero-overlay {
        background: linear-gradient(to top, rgb(15 51 31 / 88%) 0%, rgb(17 53 31 / 60%) 50%, rgba(90, 168, 122, 0.15) 100%);
    }
    .bharata-hero-content { padding: 0 24px; }
    .bharata-hero-inner { max-width: 100%; }
    .bharata-hero-line, .bharata-hero-line::after { display: none; }
    .gold-particle { display: none; }
    .floating-leaf { display: none; }
    .bharata-hero-actions { flex-direction: column; }
    .bharata-btn-primary,
    .bharata-btn-secondary { width: 100%; justify-content: center; }
    .bharata-trust { gap: 14px; }
    .bharata-trust-item { font-size: 11px; }
    .bharata-product-grid { gap: 10px; }
    .bharata-product-card { padding: 10px; min-height: 180px; }
    .bharata-product-card .bharata-product-name { font-size: 0.75rem; min-height: 2rem; }
    .bharata-product-card .bharata-product-price { font-size: 0.8rem; }
    .bharata-product-card .bharata-product-price-old { font-size: 0.6rem; }
    .bharata-product-card .bharata-product-benefits { display: none; }
    .bharata-product-card .bharata-product-discount { font-size: 0.5rem; padding: 2px 8px; top: 4px; right: 4px; }
    .bharata-product-card .bharata-product-link { width: 24px; height: 24px; font-size: 0.6rem; }
    .bharata-product-card .bharata-product-row { padding-top: 6px; }
    .bharata-product-card .bharata-product-rating .stars i { font-size: 0.5rem; }
    .bharata-product-card .bharata-product-rating .rating-value { font-size: 0.6rem; }
    .bharata-product-card .bharata-product-rating .rating-sold { font-size: 0.5rem; }
    .bharata-heritage-grid { grid-template-columns: 1fr; gap: 16px; }
    .bharata-stats {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        padding: 24px 16px;
    }
    .bharata-stat-card { padding: 12px 10px; }
    .bharata-stat-card + .bharata-stat-card { border-left: 1px solid rgba(45,107,68,0.3); }
    .bharata-stat-num { font-size: 2.2rem; }
    .bharata-testimonial-grid { grid-template-columns: 1fr; gap: 16px; }
    .bharata-cert-grid { grid-template-columns: repeat(2, 1fr); gap: 14px; }
    .bharata-cert-item { padding: 28px 18px 24px; }
    .bharata-cert-icon { width: 44px; height: 44px; font-size: 18px; }
    .bharata-cert-label { font-size: 15px; }
    .bharata-collection, .bharata-heritage, .bharata-testimonials, .bharata-cta { padding: 60px 0; }
    .bharata-cert { padding: 50px 0 56px; }
    .bharata-cta-btn-primary,
    .bharata-cta-btn-secondary { padding: 14px 28px; }
}
@media (max-width: 480px) {
    .bharata-badge { font-size: 10px; letter-spacing: 2px; padding: 5px 14px; }
    .bharata-hero-title { font-size: 2rem; }
    .bharata-hero-subtitle { font-size: 1rem; }
    .bharata-trust { gap: 10px; }
    .bharata-trust-item { font-size: 10px; }
    .bharata-collection-footer a { width: 100%; justify-content: center; }
    .bharata-stats { grid-template-columns: 1fr 1fr; gap: 10px; padding: 20px 12px; }
    .bharata-stat-card { padding: 10px 8px; }
    .bharata-stat-card + .bharata-stat-card { border-left: 1px solid rgba(45,107,68,0.3); }
    .bharata-stat-num { font-size: 2rem; }
    .bharata-cert-grid { grid-template-columns: 1fr; gap: 14px; }
    .bharata-cert-item { padding: 24px 16px 20px; }
    .bharata-cta-btn-primary,
    .bharata-cta-btn-secondary { width: 100%; justify-content: center; }
    .bharata-cert-icon { width: 40px; height: 40px; font-size: 16px; }
    .bharata-cert-label { font-size: 14px; }
}
</style>
@endpush

@section('content')

{{-- ── SECTION 1: HERO ────────────────────────────────────────── --}}
<section class="bharata-hero" id="bharata-hero">
    <!-- Background -->
    <div class="bharata-hero-bg"></div>
    <!-- Overlay -->
    <div class="bharata-hero-overlay"></div>
    <!-- Green glow -->
    <div class="bharata-hero-glow"></div>

    <!-- Decorative gold line -->
    <div class="bharata-hero-line"></div>

    <!-- Gold particles -->
    <div class="gold-particle"></div>
    <div class="gold-particle"></div>
    <div class="gold-particle"></div>
    <div class="gold-particle"></div>
    <div class="gold-particle"></div>
    <div class="gold-particle"></div>
    <div class="gold-particle"></div>
    <div class="gold-particle"></div>

    <!-- Floating leaves -->
    <i class="fas fa-leaf floating-leaf gold"></i>
    <i class="fas fa-seedling floating-leaf gold"></i>
    <i class="fas fa-spa floating-leaf green"></i>
    <i class="fas fa-leaf floating-leaf green"></i>

    <!-- Content -->
    <div class="bharata-hero-content">
        <div class="bharata-hero-inner">

            <!-- Badge -->
            <div class="bharata-badge">
                <i class="fas fa-certificate" style="font-size: 12px; color:#F5E6A3;"></i>
                Produk Herbal Bharata
            </div>

            <!-- Title -->
            <h1 class="bharata-hero-title">
                Produk Herbal<br>
                <span class="gold">Terpercaya</span>
            </h1>

            <!-- Subtitle -->
            <p class="bharata-hero-subtitle">
                Temukan Produk Herbal Sesuai Kebutuhan Anda
            </p>

            <!-- Description -->
            <p class="bharata-hero-desc">
                Kami menyediakan berbagai pilihan produk herbal berkualitas untuk membantu mendukung kesehatan dan kesejahteraan Anda sehari-hari.
            </p>

            <!-- Buttons -->
            <div class="bharata-hero-actions">
                <a href="{{ route('products.index') }}" class="bharata-btn-primary">
                    Lihat Produk
                    <i class="fas fa-arrow-right" style="font-size: 12px;"></i>
                </a>
                <a href="https://wa.me/{{ preg_replace('/\D/', '', $settings->wa_number ?? '6282244664526') }}?text=Halo%20Bharata%20Herbal%2C%20saya%20ingin%20bertanya..." target="_blank" class="bharata-btn-secondary">
                    <i class="fab fa-whatsapp" style="font-size: 14px; color:#25D366;"></i>
                    Hubungi Kami
                </a>
            </div>

            <!-- Trust badges -->
            <div class="bharata-trust">
                <div class="bharata-trust-item">
                    <span class="check"><i class="fas fa-check"></i></span>
                    BPOM Terdaftar
                </div>
                <div class="bharata-trust-item">
                    <span class="check"><i class="fas fa-check"></i></span>
                    Halal Certified
                </div>
                <div class="bharata-trust-item">
                    <span class="check"><i class="fas fa-check"></i></span>
                    100% Alami
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ── SECTION 2: CERTIFICATION BAR ───────────────────────────── --}}
<section class="bharata-cert">
    <div class="bharata-container">
        <div class="bharata-cert-header">
            <div class="bharata-section-badge">
                <i class="fas fa-certificate" style="font-size:11px;"></i>
                SERTIFIKASI &amp; LEGALITAS
            </div>
            <h2 class="bharata-cert-title">
                Dipercaya &amp; Disertifikasi <span class="gold">Oleh</span>
            </h2>
            <p class="bharata-cert-sub">Produk kami telah teruji dan tersertifikasi secara resmi untuk menjamin kualitas, keamanan, dan kehalalan terbaik.</p>
        </div>
        <div class="bharata-cert-grid">
            <div class="bharata-cert-item bharata-fade" style="transition-delay:0s">
                <div class="bharata-cert-item-inner">
                    <div class="bharata-cert-icon"><i class="fas fa-certificate"></i></div>
                    <div class="bharata-cert-label">BPOM RI</div>
                    <div class="bharata-cert-divider"></div>
                    <div class="bharata-cert-desc">Terdaftar Resmi</div>
                </div>
            </div>
            <div class="bharata-cert-item bharata-fade" style="transition-delay:0.1s">
                <div class="bharata-cert-item-inner">
                    <div class="bharata-cert-icon"><i class="fas fa-moon"></i></div>
                    <div class="bharata-cert-label">Halal Indonesia</div>
                    <div class="bharata-cert-divider"></div>
                    <div class="bharata-cert-desc">Sertifikasi MUI</div>
                </div>
            </div>
            <div class="bharata-cert-item bharata-fade" style="transition-delay:0.2s">
                <div class="bharata-cert-item-inner">
                    <div class="bharata-cert-icon"><i class="fas fa-flask"></i></div>
                    <div class="bharata-cert-label">Standar GMP</div>
                    <div class="bharata-cert-divider"></div>
                    <div class="bharata-cert-desc">Produksi Modern</div>
                </div>
            </div>
            <div class="bharata-cert-item bharata-fade" style="transition-delay:0.3s">
                <div class="bharata-cert-item-inner">
                    <div class="bharata-cert-icon"><i class="fas fa-leaf"></i></div>
                    <div class="bharata-cert-label">Herbal Alami 100%</div>
                    <div class="bharata-cert-divider"></div>
                    <div class="bharata-cert-desc">Tanpa Bahan Kimia</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── SECTION 3: PREMIUM COLLECTION ─────────────────────────── --}}
<section id="produk" class="bharata-collection">
    <div class="bharata-container">
        <div class="bharata-section-header">
            <div class="bharata-section-badge">
                <i class="fas fa-leaf" style="font-size:11px;"></i>
                Koleksi Premium
            </div>
            <h2 class="bharata-section-title">Produk Unggulan Kami</h2>
            <div class="bharata-collection-divider"></div>
            <p class="bharata-section-desc">Diramu secara khusus menggunakan teknologi modern untuk memberikan khasiat terbaik bagi tubuh Anda.</p>
        </div>

        <div class="bharata-product-grid">
            @forelse($products->take(8) as $index => $product)
            <div class="bharata-product-card bharata-fade" style="transition-delay: {{ ($index % 4) * 0.08 }}s">
                <div class="bharata-product-image">
                    @php
                        $primaryImage = $product->images->where('is_primary', true)->first() ?? $product->images->first();
                    @endphp
                    @if($primaryImage)
                        <img src="{{ asset('storage/' . $primaryImage->image_path) }}" alt="{{ $product->name }}" loading="lazy">
                    @else
                        <i class="fas fa-seedling bharata-product-icon-fallback"></i>
                    @endif
                    @if($product->discount_percentage)
                        <span class="bharata-product-discount">-{{ $product->discount_percentage }}%</span>
                    @endif
                </div>
                <div class="bharata-product-info">
                    <h3 class="bharata-product-name" title="{{ $product->name }}">{{ $product->name }}</h3>
                    @if(!empty($product->benefits) && is_array($product->benefits))
                    <ul class="bharata-product-benefits">
                        @foreach(array_slice($product->benefits, 0, 2) as $benefit)
                            <li>{{ $benefit }}</li>
                        @endforeach
                    </ul>
                    @endif
                    <div class="bharata-product-rating">
                        <span class="stars">
                            @php
                                $ratingVal = round($product->reviews_avg_rating ?? 5.0, 1);
                                $fullStars = floor($ratingVal);
                                $hasHalf = ($ratingVal - $fullStars) >= 0.5;
                            @endphp
                            @for($s = 1; $s <= 5; $s++)
                                @if($s <= $fullStars)
                                    <i class="fas fa-star"></i>
                                @elseif($s == $fullStars + 1 && $hasHalf)
                                    <i class="fas fa-star-half-alt"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </span>
                        <span class="rating-value">{{ number_format($ratingVal, 1) }}</span>
                        <span class="rating-separator">&bull;</span>
                        <span class="rating-sold">{{ $product->sales_count ?? 0 }} Terjual</span>
                    </div>
                    <div class="bharata-product-row">
                        <div class="bharata-product-prices">
                            <span class="bharata-product-price">{{ $product->formatted_discounted_price ?? $product->formatted_price }}</span>
                            @if($product->discounted_price)
                                <span class="bharata-product-price-old">{{ $product->formatted_price }}</span>
                            @endif
                        </div>
                        <a href="{{ route('products.show', $product->slug) }}" class="bharata-product-link" title="Lihat Detail {{ $product->name }}">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #8A9A92;">
                <p>Belum ada produk yang ditampilkan.</p>
            </div>
            @endforelse
        </div>

        <div class="bharata-collection-footer">
            <a href="{{ route('products.index') }}">
                Lihat Semua Produk
                <i class="fas fa-arrow-right" style="font-size:12px;"></i>
            </a>
        </div>
    </div>
</section>

{{-- ── SECTION 4: KEUNGGULAN KAMI ──────────────────────────────── --}}
<section class="bharata-heritage">
    <div class="bharata-container">
        <div class="bharata-heritage-header">
            <div class="bharata-section-badge">
                <i class="fas fa-spa" style="font-size:11px;"></i>
                KEUNGGULAN KAMI
            </div>
            <h2 class="bharata-heritage-title">Keunggulan Kami</h2>
            <p class="bharata-heritage-subtitle">Mengapa Memilih Bharata Herbal?</p>
            <p class="bharata-section-desc">Kami berdedikasi menyediakan produk kesehatan alami yang aman, efektif, dan diproduksi dengan standar kualitas tertinggi.</p>
        </div>

        <div class="bharata-heritage-grid">
            <div class="bharata-heritage-item bharata-fade" style="transition-delay:0s">
                <i class="fas fa-shield-alt bharata-heritage-icon"></i>
                <h4>Terdaftar BPOM</h4>
                <p>Legalitas resmi dan terjamin keamanannya.</p>
            </div>
            <div class="bharata-heritage-item bharata-fade" style="transition-delay:0.08s">
                <i class="fas fa-mosque bharata-heritage-icon"></i>
                <h4>Sertifikat Halal</h4>
                <p>100% halal diproduksi sesuai syariat.</p>
            </div>
            <div class="bharata-heritage-item bharata-fade" style="transition-delay:0.16s">
                <i class="fas fa-leaf bharata-heritage-icon"></i>
                <h4>Bahan Alami 100%</h4>
                <p>Ekstrak murni tanpa pengawet buatan.</p>
            </div>
            <div class="bharata-heritage-item bharata-fade" style="transition-delay:0.24s">
                <i class="fas fa-thumbs-up bharata-heritage-icon"></i>
                <h4>Kualitas Terpercaya</h4>
                <p>Ribuan pelanggan puas di seluruh Indonesia.</p>
            </div>
        </div>

        <div class="bharata-stats">
            <div class="bharata-stat-card bharata-fade" style="transition-delay:0.3s">
                <div class="bharata-stat-num">5000+</div>
                <div class="bharata-stat-label">Pelanggan Puas</div>
            </div>
            <div class="bharata-stat-card bharata-fade" style="transition-delay:0.38s">
                <div class="bharata-stat-num">50+</div>
                <div class="bharata-stat-label">Produk Herbal</div>
            </div>
            <div class="bharata-stat-card bharata-fade" style="transition-delay:0.46s">
                <div class="bharata-stat-num">BPOM</div>
                <div class="bharata-stat-label">Tersertifikasi</div>
            </div>
            <div class="bharata-stat-card bharata-fade" style="transition-delay:0.54s">
                <div class="bharata-stat-num">100%</div>
                <div class="bharata-stat-label">Bahan Alami</div>
            </div>
        </div>
    </div>
</section>

{{-- ── SECTION 5: TESTIMONI ────────────────────────────────────── --}}
<section id="testimoni" class="bharata-testimonials">
    <div class="bharata-container">
        <div class="bharata-section-header" style="text-align:center;margin-bottom:56px;">
            <div class="bharata-section-badge" style="justify-content:center;color:#0D2618;">
                <i class="fas fa-quote-left" style="font-size:11px;"></i>
                Kata Mereka
            </div>
            <h2 class="bharata-testimonial-title" style="font-family:'Plus Jakarta Sans', 'Inter', sans-serif;font-size:clamp(1.6rem,3vw,2.5rem);font-weight:700;color:#0F172A;margin-bottom:12px;line-height:1.2;">Apa Kata Pelanggan Kami</h2>
            <p class="bharata-section-desc" style="color:#475569;font-family:'Plus Jakarta Sans', 'Inter', sans-serif;font-size:1.05rem;">Bukti nyata dari pelanggan yang telah merasakan manfaat produk Bharata Herbal.</p>
        </div>

        <div class="bharata-testimonial-grid">
            <div class="bharata-testimonial-card bharata-fade" style="transition-delay:0s">
                <div class="bharata-testimonial-quote">&ldquo;</div>
                <div class="bharata-testimonial-stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="bharata-testimonial-text">Setelah rutin mengkonsumsi Bharata Lambung, masalah asam lambung saya sangat jarang kambuh. Bisa kembali fokus bekerja tanpa khawatir rasa perih. Sangat direkomendasikan!</p>
                <div class="bharata-testimonial-author">
                    <div class="bharata-testimonial-avatar">B</div>
                    <div>
                        <div class="bharata-testimonial-name">Bapak Budi Santoso</div>
                        <div class="bharata-testimonial-role">Karyawan Swasta</div>
                    </div>
                </div>
            </div>

            <div class="bharata-testimonial-card bharata-fade" style="transition-delay:0.12s">
                <div class="bharata-testimonial-quote">&ldquo;</div>
                <div class="bharata-testimonial-stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="bharata-testimonial-text">Produk Orthafit benar-benar luar biasa. Nyeri sendi lutut yang sering saya rasakan berangsur menghilang. Sekarang bisa kembali aktif beraktivitas setiap hari.</p>
                <div class="bharata-testimonial-author">
                    <div class="bharata-testimonial-avatar">I</div>
                    <div>
                        <div class="bharata-testimonial-name">Ibu Siti Aminah</div>
                        <div class="bharata-testimonial-role">Ibu Rumah Tangga</div>
                    </div>
                </div>
            </div>

            <div class="bharata-testimonial-card bharata-fade" style="transition-delay:0.24s">
                <div class="bharata-testimonial-quote">&ldquo;</div>
                <div class="bharata-testimonial-stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="bharata-testimonial-text">Saya punya riwayat kolesterol tinggi, namun sejak menggunakan produk herbal Bharata secara teratur, hasilnya lebih stabil dan badan terasa jauh lebih ringan.</p>
                <div class="bharata-testimonial-author">
                    <div class="bharata-testimonial-avatar">R</div>
                    <div>
                        <div class="bharata-testimonial-name">Rudi Hermawan</div>
                        <div class="bharata-testimonial-role">Wiraswasta</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── SECTION 6: FINAL CTA ────────────────────────────────────── --}}
<section class="bharata-cta">
    <div class="bharata-container">
        <div class="bharata-cta-badge">
            <i class="fas fa-spa" style="font-size:11px;"></i>
            Mulai Perjalanan Anda
        </div>
        <h2 class="bharata-section-title">Temukan Produk Herbal Sesuai<br><span class="gold">Kebutuhan Anda</span></h2>
        <p class="bharata-section-desc">Konsultasikan kebutuhan kesehatan Anda dengan tim kami. Dapatkan rekomendasi produk herbal terbaik yang sesuai dengan kondisi Anda.</p>
        <div class="bharata-cta-actions">
            <a href="{{ route('products.index') }}" class="bharata-cta-btn-primary">
                Lihat Semua Produk
                <i class="fas fa-arrow-right" style="font-size:12px;"></i>
            </a>
            <a href="https://wa.me/{{ preg_replace('/\D/', '', $settings->wa_number ?? '6282244664526') }}?text=Halo%20Bharata%20Herbal%2C%20saya%20ingin%20konsultasi..." target="_blank" class="bharata-cta-btn-secondary">
                <i class="fab fa-whatsapp" style="font-size:14px; color:#25D366;"></i>
                Konsultasi Gratis
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    /* IntersectionObserver for fade-up animations */
    var fadeElements = document.querySelectorAll('.bharata-fade, .bharata-cert-item, .bharata-product-card, .bharata-heritage-item, .bharata-stat-card, .bharata-testimonial-card');
    if (fadeElements.length > 0 && 'IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.08, rootMargin: '30px 0px 30px 0px' });
        fadeElements.forEach(function (el) { observer.observe(el); });
    } else {
        fadeElements.forEach(function (el) { el.classList.add('visible'); });
    }

    setTimeout(function() {
        fadeElements.forEach(function(el) {
            if (!el.classList.contains('visible')) el.classList.add('visible');
        });
    }, 400);
});
</script>
@endpush
