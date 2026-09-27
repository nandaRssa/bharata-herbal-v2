@extends('layouts.public')
@section('title', 'Status Pesanan ' . $orderNumber)

@push('styles')
<style>
/* ─── Premium Invoice / Status Page ──────────────────── */
.invoice-page {
    background: #F8FAF7;
    min-height: 100vh;
    padding: 40px 20px;
}
.invoice-container {
    max-width: 900px;
    margin: 0 auto;
}

/* ─── Animations ─────────────────────────────────────── */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes popIn {
    0%   { opacity: 0; transform: scale(0.5); }
    70%  { transform: scale(1.15); }
    100% { opacity: 1; transform: scale(1); }
}
@keyframes pulseGlow {
    0%, 100% { box-shadow: 0 0 0 6px rgba(13, 38, 24, 0.2); }
    50%      { box-shadow: 0 0 0 10px rgba(13, 38, 24, 0.15); }
}
.fade-up {
    animation: fadeUp 0.6s ease forwards;
    opacity: 0;
}
.fade-up-1 { animation-delay: 0.1s; }
.fade-up-2 { animation-delay: 0.2s; }
.fade-up-3 { animation-delay: 0.3s; }
.fade-up-4 { animation-delay: 0.4s; }
.fade-up-5 { animation-delay: 0.5s; }
.fade-up-6 { animation-delay: 0.6s; }
.pop-in {
    animation: popIn 0.5s ease forwards;
}

/* ─── Card ────────────────────────────────────────────── */
.invoice-card {
    background: #FFFFFF;
    border: 1px solid #E0E6E2;
    border-radius: 16px;
    padding: 24px 28px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.02);
    transition: box-shadow 0.3s ease, transform 0.3s ease;
}
.invoice-card:hover {
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
    transform: translateY(-2px);
}
.card-gap { margin-bottom: 16px; }

/* ─── Order Number ────────────────────────────────────── */
.order-number-label {
    font-family: 'Inter', sans-serif;
    font-size: 0.7rem;
    color: #6A7A72;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 2px;
}
.order-number-value {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: 1.4rem;
    font-weight: 700;
    color: #0D2618;
}

/* ─── Info Grid ───────────────────────────────────────── */
.info-label {
    font-family: 'Inter', sans-serif;
    font-size: 0.75rem;
    color: #6A7A72;
    margin-bottom: 2px;
}
.info-value {
    font-family: 'Inter', sans-serif;
    font-size: 0.95rem;
    font-weight: 600;
    color: #0D2618;
}
.info-value-gold {
    font-family: 'Inter', sans-serif;
    font-size: 1.05rem;
    font-weight: 700;
    color: #0D2618;
}

/* ─── Section Heading ─────────────────────────────────── */
.section-heading {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: 1.2rem;
    color: #0D2618;
    margin-bottom: 16px;
}

/* ─── Payment Status ──────────────────────────────────── */
.payment-status-card {
    border-radius: 12px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.payment-status-icon {
    font-size: 1.4rem;
    flex-shrink: 0;
}
.payment-status-title {
    font-family: 'Inter', sans-serif;
    font-weight: 600;
    font-size: 0.95rem;
}
.payment-status-subtitle {
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    color: #6A7A72;
    margin-top: 2px;
}

/* ─── Products ────────────────────────────────────────── */
.order-product {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 0;
    border-bottom: 1px solid #F0F2F0;
    gap: 16px;
}
.order-product:last-child {
    border-bottom: none;
}
.product-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
    flex: 1;
    min-width: 0;
}
.product-name {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: 1rem;
    color: #0D2618;
    line-height: 1.3;
}
.product-detail {
    font-family: 'Inter', sans-serif;
    font-size: 0.8rem;
    color: #6A7A72;
}
.product-price {
    font-family: 'Inter', sans-serif;
    font-size: 1rem;
    font-weight: 700;
    color: #0D2618;
    white-space: nowrap;
}
.product-img {
    width: 52px;
    height: 52px;
    border-radius: 10px;
    object-fit: cover;
    border: 1px solid #F0F2F0;
    flex-shrink: 0;
}

/* ─── Summary Lines ───────────────────────────────────── */
.summary-line {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 6px 0;
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    color: #6A7A72;
}
.summary-total {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0 0 0;
    margin-top: 8px;
    border-top: 1px solid #E0E6E2;
    font-family: 'Inter', sans-serif;
    font-size: 1.1rem;
    font-weight: 700;
    color: #0D2618;
}
.summary-total .amount {
    color: #0D2618;
}

/* ─── Timeline ────────────────────────────────────────── */
.timeline {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    position: relative;
    padding: 16px 0 8px 0;
    gap: 4px;
}
.timeline-bar-bg {
    position: absolute;
    top: 24px;
    left: 20px;
    right: 20px;
    height: 3px;
    background: #E0E6E2;
    z-index: 0;
    border-radius: 2px;
}
.timeline-bar-fill {
    position: absolute;
    top: 24px;
    left: 20px;
    height: 3px;
    background: linear-gradient(90deg, #2E7D32, #0D2618);
    z-index: 1;
    border-radius: 2px;
    transition: width 1s ease;
}

.timeline-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    flex: 1;
    position: relative;
    z-index: 2;
}
.step-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-family: 'Inter', sans-serif;
    font-size: 0.8rem;
    transition: all 0.3s ease;
    position: relative;
}
.step-circle.done {
    background: #2E7D32;
    color: #FFFFFF;
}
.step-circle.active {
    background: #0D2618;
    color: #FFFFFF;
    animation: pulseGlow 2s ease-in-out infinite;
}
.step-circle.pending {
    background: #E0E6E2;
    color: #8A9A92;
}
.step-circle.cancelled {
    background: #EF4444;
    color: #FFFFFF;
}
.step-circle.done i,
.step-circle.active i {
    font-size: 1rem;
}
.step-label {
    font-family: 'Inter', sans-serif;
    font-size: 0.65rem;
    font-weight: 500;
    text-align: center;
    color: #6A7A72;
    max-width: 70px;
    line-height: 1.2;
}
.step-label.done {
    color: #2E7D32;
}
.step-label.active {
    color: #0D2618;
    font-weight: 600;
}
.step-label.cancelled {
    color: #EF4444;
}
.step-date {
    font-family: 'Inter', sans-serif;
    font-size: 0.6rem;
    color: #8A9A92;
}
.step-extra {
    font-family: 'Inter', sans-serif;
    font-size: 0.6rem;
    color: #0D2618;
    font-weight: 600;
    text-align: center;
    max-width: 70px;
    line-height: 1.2;
}

/* ─── Action Buttons ──────────────────────────────────── */
.action-buttons {
    display: flex;
    gap: 12px;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 24px;
}
.btn-chat-wa {
    background: transparent;
    color: #25D366;
    padding: 12px 32px;
    border-radius: 50px;
    border: 2px solid #25D366;
    font-weight: 600;
    font-family: 'Inter', sans-serif;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    text-decoration: none;
}
.btn-chat-wa:hover {
    background: #25D366;
    color: #FFFFFF;
    transform: scale(1.02);
    box-shadow: 0 8px 30px rgba(37, 211, 102, 0.2);
    text-decoration: none;
}
.btn-home-gold {
    background: linear-gradient(135deg, #0D2618, #0D2618);
    color: #FFFFFF;
    padding: 12px 32px;
    border-radius: 50px;
    border: none;
    font-weight: 600;
    font-family: 'Inter', sans-serif;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    text-decoration: none;
}
.btn-home-gold:hover {
    transform: scale(1.02);
    box-shadow: 0 8px 30px rgba(13, 38, 24, 0.2);
    text-decoration: none;
}

/* ─── Verification Form ───────────────────────────────── */
.verify-card {
    background: #FFFFFF;
    border: 1px solid #E0E6E2;
    border-radius: 16px;
    padding: 40px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.02);
}
.verify-heading {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: 1.5rem;
    color: #0D2618;
    margin-bottom: 4px;
}
.verify-input {
    width: 100%;
    border: 1px solid #E0E6E2;
    border-radius: 12px;
    padding: 14px 18px;
    font-size: 0.95rem;
    font-family: 'Inter', sans-serif;
    font-weight: 500;
    color: #0D2618;
    background: #F5F0EB;
    transition: all 0.3s ease;
    outline: none;
}
.verify-input:focus {
    border-color: #0D2618;
    box-shadow: 0 0 0 3px rgba(13, 38, 24, 0.15);
    background: #FFFFFF;
}
.verify-btn {
    width: 100%;
    padding: 14px;
    border-radius: 50px;
    border: none;
    background: linear-gradient(135deg, #0D2618, #0D2618);
    color: #FFFFFF;
    font-weight: 600;
    font-family: 'Inter', sans-serif;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.verify-btn:hover {
    transform: scale(1.01);
    box-shadow: 0 8px 25px rgba(13, 38, 24, 0.25);
}

/* ─── Review Form ─────────────────────────────────────── */
.review-card {
    background: #FFFFFF;
    border: 1px solid #E0E6E2;
    border-radius: 16px;
    padding: 24px 28px;
    margin-top: 16px;
}
.star-btn {
    transition: all 0.2s ease;
    background: none;
    border: none;
    cursor: pointer;
    font-size: 1.5rem;
    padding: 0 2px;
}
.star-btn:hover {
    transform: scale(1.2);
}
.review-textarea {
    width: 100%;
    border: 1px solid #E0E6E2;
    border-radius: 12px;
    padding: 12px 16px;
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    color: #0D2618;
    resize: none;
    outline: none;
    transition: border-color 0.3s ease;
}
.review-textarea:focus {
    border-color: #0D2618;
}
.review-submit-btn {
    width: 100%;
    padding: 12px;
    border-radius: 50px;
    border: none;
    background: linear-gradient(135deg, #0D2618, #0D2618);
    color: #FFFFFF;
    font-weight: 600;
    font-family: 'Inter', sans-serif;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
}
.review-submit-btn:hover:not(:disabled) {
    transform: scale(1.01);
    box-shadow: 0 8px 25px rgba(13, 38, 24, 0.2);
}
.review-submit-btn:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

/* ─── Flash Messages ──────────────────────────────────── */
.flash-success {
    background: rgba(46, 125, 50, 0.08);
    border: 1px solid #43A047;
    border-radius: 12px;
    padding: 14px 18px;
    color: #2E7D32;
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    font-weight: 500;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.flash-error {
    background: rgba(239, 68, 68, 0.08);
    border: 1px solid #EF4444;
    border-radius: 12px;
    padding: 14px 18px;
    color: #DC2626;
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    font-weight: 500;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* ─── Responsive ──────────────────────────────────────── */
@media (max-width: 768px) {
    .invoice-page {
        padding: 20px 16px;
    }
    .invoice-card {
        padding: 20px 16px;
    }
    .verify-card {
        padding: 28px 20px;
    }
    .review-card {
        padding: 20px 16px;
    }
    .order-number-value {
        font-size: 1.1rem;
    }
    .section-heading {
        font-size: 1.05rem;
    }
    .product-name {
        font-size: 0.9rem;
    }
    .product-price {
        font-size: 0.9rem;
    }
    .action-buttons {
        flex-direction: column;
        gap: 10px;
        width: 100%;
    }
    .action-buttons .btn-chat-wa,
    .action-buttons .btn-home-gold {
        width: 100%;
        justify-content: center;
        padding: 14px 20px;
    }
    .timeline {
        flex-direction: column;
        gap: 16px;
        padding-left: 40px;
    }
    .timeline-bar-bg,
    .timeline-bar-fill {
        display: none;
    }
    .timeline-step {
        flex-direction: row;
        gap: 16px;
        align-items: center;
        width: 100%;
    }
    .step-circle {
        width: 32px;
        height: 32px;
        font-size: 0.7rem;
        flex-shrink: 0;
    }
    .step-circle.active {
        animation: pulseGlow 2s ease-in-out infinite;
    }
    .step-label {
        text-align: left;
        max-width: 100%;
        font-size: 0.75rem;
    }
    .step-date {
        display: none;
    }
    .timeline-step:not(:last-child)::after {
        content: '';
        position: absolute;
        left: 16px;
        top: 40px;
        width: 2px;
        height: 24px;
        background: #E0E6E2;
        z-index: 1;
    }
    .timeline-step.done-connector:not(:last-child)::after {
        background: #2E7D32;
    }
    .timeline-step.active-connector:not(:last-child)::after {
        background: #0D2618;
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .invoice-page {
        padding: 32px 24px;
    }
    .invoice-card {
        padding: 20px 24px;
    }
}
</style>
@endpush

@section('content')
<div class="invoice-page">
<div class="invoice-container">

    {{-- Flash messages --}}
    @if(session('success'))
    <div class="fade-up fade-up-1 flash-success">
        <i class="fas fa-check-circle" style="font-size:1.1rem;"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div class="fade-up fade-up-1 flash-error">
        <i class="fas fa-exclamation-circle" style="font-size:1.1rem;"></i>
        <span>{{ $errors->first() }}</span>
    </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════
         NOT YET VERIFIED — Phone verification form
         ═══════════════════════════════════════════════════════ --}}
    @if(!$order)
    <div class="fade-up fade-up-2" style="max-width:520px;margin:60px auto 0;">
        <div class="verify-card">
            {{-- Lock icon --}}
            <div style="text-align:center;margin-bottom:20px;">
                <div style="display:inline-flex;width:56px;height:56px;border-radius:50%;background:rgba(13, 38, 24, 0.12);align-items:center;justify-content:center;">
                    <i class="fas fa-lock" style="color:#0D2618;font-size:1.3rem;"></i>
                </div>
            </div>

            <h1 class="verify-heading" style="text-align:center;">Lacak Status Pesanan</h1>
            <p style="text-align:center;font-family:'Inter',sans-serif;font-size:0.85rem;color:#6A7A72;margin-bottom:28px;line-height:1.5;">
                Masukkan nomor HP yang digunakan saat pemesanan untuk melihat detail status pesanan Anda.
            </p>

            <div style="text-align:center;margin-bottom:24px;">
                <span style="display:inline-block;background:rgba(13, 38, 24, 0.06);padding:4px 16px;border-radius:50px;font-family:'Inter',sans-serif;font-size:0.75rem;color:#0D2618;font-weight:500;">
                    <i class="fas fa-receipt" style="margin-right:6px;"></i>
                    {{ $orderNumber }}
                </span>
            </div>

            <form method="POST" action="{{ route('order.track.verify', $orderNumber) }}">
                @csrf
                <div style="margin-bottom:20px;">
                    <label style="display:block;font-family:'Inter',sans-serif;font-size:0.75rem;font-weight:600;color:#0D2618;margin-bottom:8px;">
                        <i class="fas fa-phone-alt" style="margin-right:6px;color:#0D2618;"></i> Nomor HP Pembeli
                    </label>
                    <input type="tel" name="phone" placeholder="Contoh: 08123456789" required
                           inputmode="tel" pattern="[0-9\s\-\+]+"
                           value="{{ old('phone') }}"
                           class="verify-input">
                </div>
                <button type="submit" class="verify-btn">
                    <i class="fas fa-search"></i> Verifikasi & Lihat Status
                </button>
            </form>

            <div style="text-align:center;margin-top:24px;">
                <a href="{{ route('home') }}"
                   style="font-family:'Inter',sans-serif;font-size:0.8rem;color:#8A9A92;text-decoration:none;transition:color 0.3s;"
                   onmouseover="this.style.color='#0D2618'" onmouseout="this.style.color='#8A9A92'">
                    <i class="fas fa-arrow-left" style="margin-right:6px;"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════
         VERIFIED — Premium Invoice / Status Detail
         ═══════════════════════════════════════════════════════ --}}
    @else

    {{-- ─── 1. KARTU INFORMASI PESANAN (HEADER) ─────────── --}}
    <div class="invoice-card fade-up fade-up-1 card-gap">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
            {{-- Left: Order number --}}
            <div>
                <div class="order-number-label">No. Pesanan</div>
                <div class="order-number-value">{{ $order->order_number }}</div>
            </div>
            {{-- Right: 2x2 grid of info --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div>
                    <div class="info-label">Pelanggan</div>
                    <div class="info-value">{{ $order->customer_name }}</div>
                </div>
                <div>
                    <div class="info-label">Tanggal</div>
                    <div class="info-value">{{ $order->created_at->format('d M Y') }}</div>
                </div>
                <div>
                    <div class="info-label">Total Pembayaran</div>
                    <div class="info-value-gold">{{ $order->formatted_total }}</div>
                </div>
                <div>
                    <div class="info-label">Metode Bayar</div>
                    <div class="info-value">{{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ─── 2. STATUS PEMBAYARAN ─────────────────────────── --}}
    @if($order->order_status === 'cancelled')
    <div class="fade-up fade-up-2 card-gap">
        <div class="payment-status-card" style="background:rgba(239,68,68,0.06);border-color:#EF4444;">
            <i class="fas fa-times-circle payment-status-icon" style="color:#EF4444;"></i>
            <div>
                <div class="payment-status-title" style="color:#DC2626;">Pesanan Dibatalkan</div>
                <div class="payment-status-subtitle">Pesanan ini telah dibatalkan. Silakan hubungi admin jika ada pertanyaan.</div>
            </div>
        </div>
    </div>
    @elseif($order->payment_method === 'cod')
    <div class="fade-up fade-up-2 card-gap">
        <div class="payment-status-card" style="background:rgba(13, 38, 24, 0.06);border-color:#0D2618;">
            <i class="fas fa-truck payment-status-icon" style="color:#0D2618;"></i>
            <div>
                <div class="payment-status-title" style="color:#B8962E;">Bayar di Tempat (COD)</div>
                <div class="payment-status-subtitle">Siapkan uang tunai sebesar <strong>{{ $order->formatted_total }}</strong> saat pesanan tiba.</div>
            </div>
        </div>
    </div>
    @elseif($order->payment_status === 'confirmed')
    <div class="fade-up fade-up-2 card-gap">
        <div class="payment-status-card">
            <i class="fas fa-check-circle payment-status-icon"></i>
            <div>
                <div class="payment-status-title">Pembayaran Dikonfirmasi</div>
                <div class="payment-status-subtitle">Pembayaran Anda telah berhasil diverifikasi.</div>
            </div>
        </div>
    </div>
    @elseif($order->payment_status === 'pending')
    <div class="fade-up fade-up-2 card-gap">
        <div class="payment-status-card" style="background:rgba(13, 38, 24, 0.06);border-color:#0D2618;">
            <i class="fas fa-clock payment-status-icon" style="color:#0D2618;"></i>
            <div style="flex:1;">
                <div class="payment-status-title" style="color:#B8962E;">Menunggu Pembayaran</div>
                <div class="payment-status-subtitle">Metode: <strong>{{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}</strong> — Total: <strong>{{ $order->formatted_total }}</strong></div>
            </div>
            <button id="pay-button" onclick="fetchAndPay()"
                style="background:linear-gradient(135deg,#0D2618,#0D2618);color:#FFFFFF;padding:10px 24px;border-radius:50px;border:none;font-weight:600;font-family:'Inter',sans-serif;font-size:0.85rem;cursor:pointer;transition:all 0.3s;white-space:nowrap;"
                onmouseover="this.style.transform='scale(1.03)';this.style.boxShadow='0 4px 15px rgba(13, 38, 24, 0.3)'"
                onmouseout="this.style.transform='scale(1)';this.style.boxShadow='none'">
                <i class="fas fa-credit-card"></i> Bayar Sekarang
            </button>
        </div>
        @if(!config('midtrans.is_production'))
        <p style="font-family:'Inter',sans-serif;font-size:0.7rem;color:#8A9A92;text-align:center;margin-top:8px;">
            <i class="fas fa-flask" style="margin-right:4px;"></i> Mode sandbox — saldo tidak terpotong
        </p>
        @endif
    </div>
    @elseif($order->payment_status === 'failed')
    <div class="fade-up fade-up-2 card-gap">
        <div class="payment-status-card" style="background:rgba(239,68,68,0.06);border-color:#EF4444;">
            <i class="fas fa-times-circle payment-status-icon" style="color:#EF4444;"></i>
            <div>
                <div class="payment-status-title" style="color:#DC2626;">Pembayaran Gagal</div>
                <div class="payment-status-subtitle">Pembayaran tidak dapat diproses. Silakan hubungi admin untuk bantuan.</div>
            </div>
        </div>
    </div>
    @endif

    {{-- ─── 3. PRODUK DIPESAN ─────────────────────────────── --}}
    <div class="invoice-card fade-up fade-up-3 card-gap">
        <h3 class="section-heading" style="margin-bottom:4px;">Produk Dipesan</h3>

        <div>
            @foreach($order->items as $item)
            <div class="order-product">
                <div style="display:flex;align-items:center;gap:12px;flex:1;min-width:0;">
                    @if($item->product && $item->product->images->isNotEmpty())
                    <img src="{{ asset('storage/'.$item->product->images->first()->image_path) }}"
                         class="product-img" alt="{{ $item->product_name }}">
                    @else
                    <div class="product-img" style="background:#F5F0EB;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-box" style="color:#8A9A92;font-size:1.1rem;"></i>
                    </div>
                    @endif
                    <div class="product-info">
                        <div class="product-name">{{ $item->product_name }}</div>
                        <div class="product-detail">
                            @if($item->original_price && $item->original_price != $item->price)
                            <span style="text-decoration:line-through;color:#8A9A92;">Rp {{ number_format($item->original_price, 0, ',', '.') }}</span>
                            <span style="color:#0D2618;font-weight:600;"> → </span>
                            @endif
                            {{ $item->quantity }} × {{ $item->formatted_price }}
                        </div>
                    </div>
                </div>
                <div class="product-price">{{ $item->formatted_subtotal }}</div>
            </div>
            @endforeach
        </div>

        {{-- Subtotal & Shipping Summary --}}
        <div style="margin-top:4px;padding-top:4px;">
            <div class="summary-line">
                <span>Subtotal</span>
                <span style="font-weight:600;color:#0D2618;">{{ $order->formatted_subtotal }}</span>
            </div>
            @if($order->shipping_cost > 0)
            <div class="summary-line">
                <span>Ongkos Kirim</span>
                <span style="font-weight:600;color:#0D2618;">{{ $order->formatted_shipping_cost }}</span>
            </div>
            @endif
            <div class="summary-total">
                <span>Total Belanja</span>
                <span class="amount">{{ $order->formatted_total }}</span>
            </div>
        </div>
    </div>

    {{-- ─── 4. TIMELINE PESANAN ───────────────────────────── --}}
    @if($order->order_status !== 'cancelled')
    <div class="invoice-card fade-up fade-up-4 card-gap">
        <h3 class="section-heading">Timeline Pesanan</h3>

        @php
            $orderSeq = ['new', 'processing', 'packing', 'shipped', 'delivered'];
            $currentIdx = array_search($order->order_status, $orderSeq);
            $progress = $currentIdx !== false ? (($currentIdx + 1) / count($orderSeq)) * 100 : 0;
        @endphp

        <div class="timeline">
            <div class="timeline-bar-bg"></div>
            <div class="timeline-bar-fill" style="width:{{ $progress }}%;"></div>

            @foreach($steps as $i => $step)
            @php
                $isDone = $step['done'] && !$step['active'];
                $isActive = $step['active'];
                $iconName = $step['icon'] ?? '';
                $faIcon = match($iconName) {
                    'clock-pending' => 'fa-clock',
                    'settings' => 'fa-cog',
                    'package' => 'fa-box',
                    'shipping' => 'fa-truck',
                    'check' => 'fa-check',
                    default => 'fa-circle'
                };
            @endphp
            <div class="timeline-step
                {{ $isDone ? 'done-connector' : '' }}
                {{ $isActive ? 'active-connector' : '' }}"
                style="cursor:default;">
                <div class="step-circle {{ $isDone ? 'done' : ($isActive ? 'active' : 'pending') }}">
                    @if($isDone || $isActive)
                    <i class="fas {{ $faIcon }}"></i>
                    @else
                    {{ $i + 1 }}
                    @endif
                </div>
                <div class="step-label {{ $isDone ? 'done' : ($isActive ? 'active' : '') }}">
                    {{ $step['label'] }}
                </div>
                @if($step['extra'])
                <div class="step-extra">{{ $step['extra'] }}</div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ─── 5. TOMBOL AKSI ─────────────────────────────────--}}
    <div class="fade-up fade-up-5">
        <div class="action-buttons">
            @php
                $wa = preg_replace('/[^0-9]/', '', $settings->wa_number ?? '6282244664526');
                if(str_starts_with($wa, '0')) $wa = '62'.substr($wa, 1);
                $waMsg = rawurlencode("Halo admin Bharata Herbal, saya ingin menanyakan pesanan saya dengan No. Pesanan: {$order->order_number}");
            @endphp
            <a href="https://wa.me/{{ $wa }}?text={{ $waMsg }}" target="_blank" class="btn-chat-wa">
                <i class="fab fa-whatsapp" style="font-size:1.1rem;"></i>
                Chat Admin via WhatsApp
            </a>
            <a href="{{ route('home') }}" class="btn-home-gold">
                <i class="fas fa-home"></i>
                Kembali ke Beranda
            </a>
        </div>
    </div>

    {{-- ─── 6. REVIEW FORM (only if delivered) ─────────────--}}
    @if($order->order_status === 'delivered')
    <div class="review-card fade-up fade-up-6">
        <h3 class="section-heading" style="font-size:1.1rem;margin-bottom:4px;">
            <i class="fas fa-star" style="color:#C9A227;"></i> Beri Ulasan Produk
        </h3>
        <p style="font-family:'Inter',sans-serif;font-size:0.8rem;color:#6A7A72;margin-bottom:20px;">
            Pesanan sudah diterima? Bantu pembeli lain dengan ulasan Anda.
        </p>

        @foreach($order->items as $item)
        @if($item->product && !in_array($item->product_id, $existingReviewProductIds ?? []))
        <div style="border:1px solid #F0F2F0;border-radius:12px;padding:16px;margin-bottom:16px;">
            <div style="font-family:'Inter',sans-serif;font-size:0.9rem;font-weight:600;color:#0D2618;margin-bottom:12px;">
                {{ $item->product_name }}
            </div>

            <form method="POST" action="{{ route('order.track.review', $orderNumber) }}"
                  x-data="{ rating: 0, hover: 0 }">
                @csrf
                <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                <input type="hidden" name="customer_name" value="{{ $order->customer_name }}">
                <input type="hidden" name="rating" x-model="rating">

                <div style="display:flex;gap:4px;margin-bottom:12px;">
                    @for($s = 1; $s <= 5; $s++)
                    <button type="button"
                            @mouseenter="hover = {{ $s }}"
                            @mouseleave="hover = 0"
                            @click="rating = {{ $s }}"
                            class="star-btn"
                            :style="(hover || rating) >= {{ $s }} ? 'color:#C9A227;' : 'color:#E0E6E2;'">
                        <i class="fas fa-star"></i>
                    </button>
                    @endfor
                </div>

                <textarea name="comment" rows="2" placeholder="Ceritakan pengalaman Anda dengan produk ini..."
                    class="review-textarea"></textarea>

                <div style="margin-top:12px;">
                    <button type="submit" :disabled="rating === 0" class="review-submit-btn">
                        <i class="fas fa-paper-plane" style="margin-right:6px;"></i> Kirim Ulasan
                    </button>
                </div>
            </form>
        </div>
        @elseif($item->product && in_array($item->product_id, $existingReviewProductIds ?? []))
        <div style="background:rgba(46,125,50,0.06);border:1px solid #43A047;border-radius:12px;padding:14px 16px;margin-bottom:12px;display:flex;align-items:center;gap:10px;">
            <i class="fas fa-check-circle" style="color:#2E7D32;font-size:1.1rem;"></i>
            <span style="font-family:'Inter',sans-serif;font-size:0.85rem;color:#2E7D32;font-weight:500;">
                Ulasan untuk <strong>{{ $item->product_name }}</strong> sudah dikirim. Terima kasih!
            </span>
        </div>
        @endif
        @endforeach
    </div>
    @endif

    @endif {{-- end if $order --}}

</div>
</div>
@endsection

@push('scripts')
@if(isset($order) && $order->payment_method !== 'cod' && $order->payment_status === 'pending')
<script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
    data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    var isSandbox = {{ config('midtrans.is_production') ? 'false' : 'true' }};

    function onFinish(result, method) {
        if (isSandbox) {
            var f = document.createElement('form');
            f.method = 'POST';
            f.action = '{{ route("payment.simulate-success", $order->id) }}';
            var t = document.createElement('input');
            t.type = 'hidden';
            t.name = '_token';
            t.value = '{{ csrf_token() }}';
            f.appendChild(t);
            document.body.appendChild(f);
            f.submit();
        } else if (method === 'onSuccess') {
            fetch('{{ route("payment.confirm") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(result)
            })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                Alpine.store('modal').alert('Pembayaran berhasil! Terima kasih.', 'success');
                setTimeout(function() { window.location.reload(); }, 2000);
            })
            .catch(function() {
                Alpine.store('modal').alert('Pembayaran berhasil! Terima kasih.', 'success');
                setTimeout(function() { window.location.reload(); }, 2000);
            });
        }
    }

    function payWithSnapToken(token) {
        window.snap.pay(token, {
            onSuccess: function(result)  { onFinish(result, 'onSuccess'); },
            onPending: function(result)  { if (isSandbox) onFinish(result, 'onPending'); },
            onError: function(result)    { if (isSandbox) onFinish(result, 'onError'); },
            onClose: function()          { if (isSandbox) onFinish({}, 'onClose'); }
        });
    }

    function fetchAndPay() {
        const btn = document.getElementById('pay-button');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right:6px;"></i> Memuat...';

        fetch('{{ route("payment.snap-token", $order->id) }}')
            .then(res => res.json())
            .then(data => {
                if (data.token) {
                    payWithSnapToken(data.token);
                } else {
                    Alpine.store('modal').alert('Gagal memuat token: ' + (data.error || 'Unknown error'), 'error');
                }
            })
            .catch(function() {
                Alpine.store('modal').alert('Koneksi gagal. Coba lagi.', 'error');
            })
            .finally(function() {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-credit-card" style="margin-right:6px;"></i> Bayar Sekarang';
            });
    }
</script>
@endif
@endpush
