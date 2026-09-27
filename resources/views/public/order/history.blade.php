@extends('layouts.public')
@section('title', 'Riwayat Pesanan')

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

    .tracking-section {
        padding: 70px 20px;
        background: #F8FAF7;
    }
    .tracking-inner {
        max-width: 700px;
        margin: 0 auto;
        text-align: center;
    }

    .tracking-form {
        background: #FFFFFF;
        border: 1px solid #E0E6E2;
        border-radius: 16px;
        padding: 40px 32px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        transition: all 0.3s ease;
        text-align: left;
    }
    .tracking-form:hover {
        border-color: #0D2618;
        box-shadow: 0 8px 40px rgba(13, 38, 24, 0.04);
    }

    .tracking-form .icon-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(13, 38, 24, 0.05);
        border: 2px solid rgba(13, 38, 24, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px auto;
    }
    .tracking-form .icon-circle i {
        font-size: 2rem;
        color: #0D2618;
    }

    .tracking-form label {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        color: #0D2618;
        font-size: 0.9rem;
        display: block;
        margin-bottom: 8px;
    }

    .tracking-form .input-wrapper {
        position: relative;
    }
    .tracking-form .input-wrapper .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #8A9A92;
        font-size: 1rem;
        pointer-events: none;
        transition: color 0.3s ease;
    }
    .tracking-form .input-wrapper input:focus ~ .input-icon {
        color: #0D2618;
    }
    .tracking-form input {
        width: 100%;
        padding: 14px 20px 14px 46px;
        border: 2px solid #E0E6E2;
        border-radius: 12px;
        font-family: 'Inter', sans-serif;
        font-size: 1rem;
        color: #0D2618;
        background: #F5F0EB;
        transition: all 0.3s ease;
        outline: none;
    }
    .tracking-form input:focus {
        border-color: #0D2618;
        box-shadow: 0 0 0 4px rgba(13, 38, 24, 0.08);
        background: #FFFFFF;
    }
    .tracking-form input::placeholder {
        color: #8A9A92;
        font-size: 0.9rem;
    }

    .btn-track {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #0D2618, #0D2618);
        color: #FFFFFF;
        font-weight: 700;
        font-family: 'Inter', sans-serif;
        font-size: 1rem;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: 16px;
    }
    .btn-track:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 40px rgba(13, 38, 24, 0.2);
    }
    .btn-track:active {
        transform: scale(0.98);
    }
    .btn-track i {
        font-size: 1.1rem;
    }

    .tracking-form .info-tip {
        font-family: 'Inter', sans-serif;
        font-size: 0.8rem;
        color: #8A9A92;
        text-align: center;
        margin-top: 16px;
        line-height: 1.6;
    }
    .tracking-form .info-tip i {
        color: #0D2618;
        margin-right: 4px;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
    .tracking-form.shake {
        animation: shake 0.5s ease-in-out;
    }

    .result-section {
        margin-top: 48px;
        text-align: left;
    }
    .result-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid rgba(13, 38, 24, 0.15);
    }
    .result-header h2 {
        font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        font-size: 1.4rem;
        color: #0D2618;
    }
    .result-header span {
        font-size: 0.85rem;
        color: #6A7A72;
        font-weight: 500;
    }

    .order-card {
        background: #FFFFFF;
        border: 1px solid #E0E6E2;
        border-radius: 16px;
        padding: 28px;
        transition: all 0.3s ease;
        margin-bottom: 20px;
    }
    .order-card:hover {
        border-color: #0D2618;
        box-shadow: 0 8px 40px rgba(13, 38, 24, 0.04);
    }
    .order-card-top {
        display: flex;
        flex-direction: column;
        gap: 8px;
        padding-bottom: 20px;
        margin-bottom: 20px;
        border-bottom: 1px solid #EDE8E0;
    }
    @media (min-width: 768px) {
        .order-card-top {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    }
    .order-date {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #8A9A92;
    }
    .order-number {
        font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        font-size: 1.15rem;
        font-weight: 700;
        color: #0D2618;
    }
    .order-status {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .order-status.green { background: rgba(90,168,122,0.15); color: #3A7A50; }
    .order-status.yellow { background: rgba(13, 38, 24, 0.15); color: #0D2618; }
    .order-status.blue { background: rgba(90,168,122,0.1); color: #3D8B5E; }
    .order-status.red { background: rgba(220,80,80,0.1); color: #CC4444; }
    .order-status.purple { background: rgba(160,120,200,0.1); color: #8866AA; }
    .order-status.indigo { background: rgba(100,140,200,0.1); color: #4477AA; }

    .order-items {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 20px;
    }
    .order-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.9rem;
    }
    .order-item-name {
        color: #6A7A72;
        font-weight: 500;
    }
    .order-item-name strong { color: #0D2618; }
    .order-item-qty {
        color: #8A9A92;
        font-size: 0.8rem;
    }
    .order-item-price {
        text-align: right;
    }
    .order-item-old-price {
        font-size: 0.75rem;
        color: #8A9A92;
        text-decoration: line-through;
    }
    .order-item-final-price {
        font-weight: 600;
        color: #0D2618;
    }
    .order-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 16px;
        border-top: 1px solid #EDE8E0;
    }
    .order-total-label {
        font-weight: 700;
        color: #0D2618;
        font-size: 0.95rem;
    }
    .order-total-value {
        font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        font-weight: 700;
        color: #0D2618;
        font-size: 1.15rem;
    }
    .order-card-footer {
        display: flex;
        justify-content: flex-end;
        margin-top: 20px;
        padding-top: 16px;
        border-top: 1px solid #EDE8E0;
    }
    .btn-detail {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 24px;
        border-radius: 10px;
        border: 1px solid #E0E6E2;
        font-size: 0.85rem;
        font-weight: 600;
        color: #6A7A72;
        transition: all 0.3s ease;
        background: #FFFFFF;
    }
    .btn-detail:hover {
        border-color: #0D2618;
        color: #0D2618;
        background: rgba(13, 38, 24, 0.04);
    }

    .not-found {
        text-align: center;
        padding: 48px 32px;
        background: #FFFFFF;
        border: 1px solid #EDE8E0;
        border-radius: 16px;
        margin-top: 48px;
    }
    .not-found i {
        font-size: 3rem;
        color: #0D2618;
        opacity: 0.3;
        margin-bottom: 16px;
    }
    .not-found h3 {
        font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        font-size: 1.3rem;
        color: #0D2618;
        margin-bottom: 8px;
    }
    .not-found p {
        font-size: 0.9rem;
        color: #8A9A92;
        line-height: 1.6;
    }

    @media (max-width: 768px) {
        .page-hero { padding: 90px 20px 70px; }
        .page-hero::after { height: 40px; }
        .page-hero-leaf { display: none; }
        .tracking-section { padding: 40px 16px; }
        .tracking-form { padding: 32px 20px; }
        .tracking-form .icon-circle { width: 64px; height: 64px; }
        .tracking-form .icon-circle i { font-size: 1.5rem; }
        .order-card { padding: 20px; }
        .result-header { flex-direction: column; align-items: flex-start; gap: 4px; }
    }
</style>
@endpush

@section('content')
<!-- ── PAGE HEADER ────────────────────────────────────────── -->
<section class="page-hero">
    <div style="position:relative; z-index:2; max-width:800px; margin:0 auto;">
        <span class="page-hero-badge">
            <i class="fas fa-box-open" style="font-size:10px; margin-right:6px;"></i>
            Riwayat Pesanan
        </span>
        <h1 class="page-hero-title">
            Riwayat <span class="gold-shimmer">Pesanan</span>
        </h1>
        <div class="page-hero-divider"></div>
        <p class="page-hero-desc">
            Lacak dan lihat semua pesanan Anda dengan memasukkan nomor WhatsApp.
        </p>
    </div>
</section>

<!-- â”€â”€ TRACKING SECTION â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ -->
<section class="tracking-section">
    <div class="tracking-inner fade-up">

        <div class="tracking-form" id="trackingForm">
            <div class="icon-circle">
                <i class="fas fa-box-open"></i>
            </div>

            <form method="POST" action="{{ route('order.history.check') }}" id="trackingFormEl">
                @csrf
                <label for="phone">Nomor WhatsApp</label>
                <div class="input-wrapper">
                    <i class="fas fa-phone-alt input-icon"></i>
                    <input type="tel" name="phone" id="phone"
                           value="{{ $phone ?? old('phone') }}" required
                           placeholder="Contoh: 08123456789"
                           inputmode="tel" autocomplete="tel">
                </div>
                @error('phone')
                    <div style="color:#CC4444;font-size:0.8rem;margin-top:6px;">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn-track">
                    <i class="fas fa-search"></i> Cek Riwayat
                </button>
            </form>

            <div class="info-tip">
                <i class="fas fa-lightbulb"></i> Pastikan nomor WhatsApp yang dimasukkan sesuai dengan nomor yang digunakan saat pemesanan.
            </div>
        </div>

        <!-- â”€â”€ HASIL PENCARIAN â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ -->
        @if(isset($orders))
            @if($orders->count() > 0)
                <div class="result-section fade-up">
                    <div class="result-header">
                        <h2>Ditemukan {{ $orders->count() }} Pesanan</h2>
                        @if(isset($phone))
                            <span><i class="fas fa-phone-alt" style="color:#0D2618;margin-right:4px;"></i>{{ $phone }}</span>
                        @endif
                    </div>

                    <div id="orderList">
                        @foreach($orders as $order)
                            <div class="order-card fade-up">
                                <div class="order-card-top">
                                    <div>
                                        <div class="order-date">{{ $order->created_at->format('d M Y, H:i') }}</div>
                                        <div class="order-number">{{ $order->order_number }}</div>
                                    </div>
                                    <div>
                                        <span class="order-status
                                            @if($order->status_color === 'green') green
                                            @elseif($order->status_color === 'yellow') yellow
                                            @elseif($order->status_color === 'blue') blue
                                            @elseif($order->status_color === 'purple') purple
                                            @elseif($order->status_color === 'indigo') indigo
                                            @elseif($order->status_color === 'red') red
                                            @else green @endif">
                                            {{ $order->status_label }}
                                        </span>
                                    </div>
                                </div>

                                <div class="order-items">
                                    @foreach($order->items as $item)
                                        <div class="order-item">
                                            <span class="order-item-name">
                                                <strong>{{ $item->product_name }}</strong>
                                                <span class="order-item-qty">&times; {{ $item->quantity }}</span>
                                            </span>
                                            <div class="order-item-price">
                                                @if($item->original_price && $item->original_price != $item->price)
                                                    <div class="order-item-old-price">Rp {{ number_format($item->original_price * $item->quantity, 0, ',', '.') }}</div>
                                                @endif
                                                <div class="order-item-final-price">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="order-total">
                                    <span class="order-total-label">Total Belanja</span>
                                    <span class="order-total-value">{{ $order->formatted_total }}</span>
                                </div>

                                <div class="order-card-footer">
                                    <a href="{{ route('order.track.show', $order->order_number) }}" class="btn-detail">
                                        Detail Pesanan <i class="fas fa-arrow-right" style="font-size:0.75rem;"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="not-found fade-up">
                    <i class="fas fa-search"></i>
                    <h3>Tidak Ada Pesanan Ditemukan</h3>
                    <p>Kami tidak dapat menemukan pesanan yang terhubung dengan nomor WhatsApp <strong>{{ $phone }}</strong>. Pastikan nomor yang Anda masukkan benar.</p>
                </div>
            @endif
        @endif

    </div>
</section>
@endsection
