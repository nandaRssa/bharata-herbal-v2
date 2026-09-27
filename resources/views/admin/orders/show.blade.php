@extends('layouts.admin')
@section('title', 'Detail Pesanan ' . $order->order_number)
@section('page-title', 'Detail Pesanan')
@section('page-subtitle', $order->order_number)

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
.order-detail-page {
    font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, sans-serif;
    color: #0F172A;
    max-width: 1200px;
    margin: 0 auto;
    padding-bottom: 40px;
}

/* ── Top Bar ────────────────────────────────────────────── */
.detail-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 24px;
    padding-bottom: 20px;
    border-bottom: 1px solid #E2E8F0;
}
.detail-topbar-left {
    display: flex;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
}
.btn-back-clean {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    font-weight: 600;
    color: #475569;
    text-decoration: none;
    transition: all 0.2s ease;
}
.btn-back-clean:hover {
    background: #F8FAFC;
    color: #0F172A;
    border-color: #CBD5E1;
    transform: translateX(-2px);
}
.order-title-num {
    font-size: 1.4rem;
    font-weight: 800;
    color: #0F172A;
    margin: 0;
    letter-spacing: -0.5px;
}
.order-date-sub {
    font-family: 'Inter', sans-serif;
    font-size: 0.82rem;
    color: #64748B;
    margin-top: 2px;
}

/* ── Status Pills ───────────────────────────────────────── */
.status-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.3px;
}
.status-pill.blue { background: #EFF6FF; color: #1D4ED8; border: 1px solid #BFDBFE; }
.status-pill.amber { background: #FFFBEB; color: #B45309; border: 1px solid #FDE68A; }
.status-pill.emerald { background: #ECFDF5; color: #047857; border: 1px solid #A7F3D0; }
.status-pill.rose { background: #FFF1F2; color: #BE123C; border: 1px solid #FECDD3; }
.status-pill.purple { background: #FAF5FF; color: #7E22CE; border: 1px solid #E9D5FF; }
.status-pill.slate { background: #F1F5F9; color: #475569; border: 1px solid #E2E8F0; }

.status-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: currentColor;
}

/* ── Layout Grid ────────────────────────────────────────── */
.order-grid {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 24px;
    align-items: start;
}
@media (max-width: 992px) {
    .order-grid {
        grid-template-columns: 1fr;
    }
}

/* ── Minimalist Cards ───────────────────────────────────── */
.min-card {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 24px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
}
.min-card:last-child {
    margin-bottom: 0;
}
.min-card-header {
    padding: 16px 20px;
    border-bottom: 1px solid #F1F5F9;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #FAFAFA;
}
.min-card-title {
    font-size: 0.95rem;
    font-weight: 700;
    color: #0F172A;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.min-card-title i {
    color: #0D2618;
    font-size: 0.9rem;
}
.min-card-body {
    padding: 20px;
}

/* ── Minimalist Items Table ─────────────────────────────── */
.order-items-table {
    width: 100%;
    border-collapse: collapse;
}
.order-items-table th {
    padding: 12px 16px;
    font-family: 'Inter', sans-serif;
    font-size: 0.72rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: #64748B;
    background: #F8FAFC;
    border-bottom: 1px solid #E2E8F0;
    text-align: left;
}
.order-items-table td {
    padding: 16px;
    border-bottom: 1px solid #F1F5F9;
    vertical-align: middle;
    font-size: 0.9rem;
}
.order-items-table tr:last-child td {
    border-bottom: none;
}
.product-item-info {
    display: flex;
    align-items: center;
    gap: 14px;
}
.product-item-thumb {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    object-fit: cover;
    background: #F1F5F9;
    border: 1px solid #E2E8F0;
    flex-shrink: 0;
}
.product-item-thumb-placeholder {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    background: #F1F5F9;
    border: 1px solid #E2E8F0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94A3B8;
    font-size: 1.1rem;
    flex-shrink: 0;
}
.product-item-name {
    font-weight: 600;
    color: #0F172A;
    line-height: 1.35;
    margin-bottom: 2px;
}
.product-item-unitprice {
    font-family: 'Inter', sans-serif;
    font-size: 0.78rem;
    color: #64748B;
}

/* ── Minimalist Summary Breakdown ───────────────────────── */
.order-summary-box {
    background: #F8FAFC;
    border-top: 1px solid #E2E8F0;
    padding: 18px 20px;
}
.summary-line {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 6px 0;
    font-family: 'Inter', sans-serif;
    font-size: 0.88rem;
    color: #475569;
}
.summary-line.total {
    padding-top: 12px;
    margin-top: 6px;
    border-top: 1px dashed #CBD5E1;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 1.15rem;
    font-weight: 800;
    color: #0D2618;
}

/* ── Data Details List ──────────────────────────────────── */
.detail-list {
    display: flex;
    flex-direction: column;
    gap: 14px;
}
.detail-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.detail-label {
    font-family: 'Inter', sans-serif;
    font-size: 0.74rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #64748B;
}
.detail-val {
    font-size: 0.92rem;
    color: #0F172A;
    font-weight: 500;
    line-height: 1.5;
}
.detail-val a {
    color: #0D2618;
    text-decoration: none;
    font-weight: 600;
}
.detail-val a:hover {
    text-decoration: underline;
}

/* ── Action Buttons ─────────────────────────────────────── */
.btn-action-wa {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 12px 20px;
    background: #25D366;
    color: #FFFFFF;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    transition: all 0.2s ease;
    border: none;
    box-shadow: 0 2px 6px rgba(37, 211, 102, 0.25);
}
.btn-action-wa:hover {
    background: #20BA5A;
    color: #FFFFFF;
    box-shadow: 0 4px 12px rgba(37, 211, 102, 0.35);
    transform: translateY(-1px);
}

/* ── Update Form Controls ───────────────────────────────── */
.form-minimal-group {
    margin-bottom: 14px;
}
.form-minimal-group label {
    display: block;
    font-family: 'Inter', sans-serif;
    font-size: 0.76rem;
    font-weight: 600;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
}
.form-minimal-select,
.form-minimal-input {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #CBD5E1;
    border-radius: 10px;
    font-family: 'Inter', sans-serif;
    font-size: 0.88rem;
    color: #0F172A;
    background: #FFFFFF;
    outline: none;
    transition: all 0.2s ease;
}
.form-minimal-select:focus,
.form-minimal-input:focus {
    border-color: #0D2618;
    box-shadow: 0 0 0 3px rgba(13, 38, 24, 0.1);
}
.btn-save-minimal {
    width: 100%;
    padding: 12px 20px;
    background: #0D2618;
    color: #FFFFFF;
    border: none;
    border-radius: 10px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 0.92rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 4px 12px rgba(13, 38, 24, 0.2);
}
.btn-save-minimal:hover {
    background: #17422a;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(13, 38, 24, 0.3);
}

/* ── Customer Note Box ──────────────────────────────────── */
.customer-note-box {
    padding: 14px 18px;
    background: #FFFBEB;
    border-left: 4px solid #F59E0B;
    border-radius: 0 10px 10px 0;
    margin: 16px 20px;
    font-size: 0.85rem;
    color: #78350F;
}
</style>
@endpush

@section('content')
<div class="order-detail-page">

    {{-- Top Bar --}}
    <div class="detail-topbar">
        <div class="detail-topbar-left">
            <a href="{{ route('admin.orders.index') }}" class="btn-back-clean">
                <i class="fas fa-arrow-left" style="font-size:12px;"></i>
                Kembali ke Daftar
            </a>
            <div>
                <h1 class="order-title-num">{{ $order->order_number }}</h1>
                <div class="order-date-sub">
                    Dipesan pada {{ $order->created_at->format('d F Y, H:i') }} WIB
                </div>
            </div>
        </div>

        <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
            {{-- Shipping Status Pill --}}
            @php
                $sc = $order->status_color;
                $pillClass = match($sc) {
                    'green'  => 'emerald',
                    'red'    => 'rose',
                    'yellow' => 'amber',
                    'purple' => 'purple',
                    'blue'   => 'blue',
                    default  => 'slate',
                };
            @endphp
            <span class="status-pill {{ $pillClass }}" title="Status Pengiriman">
                <span class="status-dot"></span>
                {{ $order->status_label }}
            </span>

            {{-- Payment Status Pill --}}
            @php
                $pc = match($order->payment_status) {
                    'confirmed' => 'emerald',
                    'failed'    => 'rose',
                    default     => 'amber',
                };
            @endphp
            <span class="status-pill {{ $pc }}" title="Status Pembayaran">
                <span class="status-dot"></span>
                {{ $order->payment_status_label }}
            </span>
        </div>
    </div>

    {{-- 2-Column Grid --}}
    <div class="order-grid">

        {{-- LEFT COLUMN: Items & Customer --}}
        <div>
            {{-- Card: Produk Dipesan --}}
            <div class="min-card">
                <div class="min-card-header">
                    <h2 class="min-card-title">
                        <i class="fas fa-box"></i>
                        Produk Dipesan
                    </h2>
                    <span style="font-family:'Inter',sans-serif; font-size:0.8rem; color:#64748B; font-weight:500;">
                        {{ $order->items->count() }} item produk
                    </span>
                </div>

                <div style="overflow-x:auto;">
                    <table class="order-items-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th style="text-align:center; width:80px;">Jumlah</th>
                                <th style="text-align:right; width:130px;">Harga Satuan</th>
                                <th style="text-align:right; width:130px;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="product-item-info">
                                        @php
                                            $prodImg = $item->product && $item->product->images->isNotEmpty()
                                                ? ($item->product->images->where('is_primary', true)->first() ?? $item->product->images->first())
                                                : null;
                                        @endphp

                                        @if($prodImg)
                                            <img src="{{ asset('storage/' . $prodImg->image_path) }}" class="product-item-thumb" alt="{{ $item->product_name }}">
                                        @else
                                            <div class="product-item-thumb-placeholder">
                                                <i class="fas fa-leaf"></i>
                                            </div>
                                        @endif

                                        <div>
                                            <div class="product-item-name">{{ $item->product_name }}</div>
                                            @if($item->discount_amount > 0)
                                                <div class="product-item-unitprice" style="color:#DC2626;">
                                                    Hemat Rp {{ number_format($item->discount_amount, 0, ',', '.') }} per unit
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td style="text-align:center;">
                                    <span style="font-family:'Inter',sans-serif; font-weight:600; color:#0F172A;">
                                        {{ $item->quantity }}
                                    </span>
                                </td>

                                <td style="text-align:right;">
                                    <span style="font-family:'Inter',sans-serif; font-weight:500; color:#334155;">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </span>
                                </td>

                                <td style="text-align:right;">
                                    <span style="font-family:'Inter',sans-serif; font-weight:700; color:#0F172A;">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Summary Breakdown --}}
                <div class="order-summary-box">
                    <div class="summary-line">
                        <span>Subtotal Produk</span>
                        <span style="font-weight:600; color:#0F172A;">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-line">
                        <span>Ongkos Kirim ({{ $order->shipping_method ?: 'Standar' }})</span>
                        <span style="font-weight:600; color:#0F172A;">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-line total">
                        <span>Total Pembayaran</span>
                        <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                @if($order->notes)
                <div class="customer-note-box">
                    <strong>Catatan Pembeli:</strong> {{ $order->notes }}
                </div>
                @endif
            </div>

            {{-- Card: Data Pelanggan & Alamat --}}
            <div class="min-card">
                <div class="min-card-header">
                    <h2 class="min-card-title">
                        <i class="fas fa-user-check"></i>
                        Data Pelanggan &amp; Pengiriman
                    </h2>
                </div>
                <div class="min-card-body">
                    <div class="detail-list">
                        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:16px;">
                            <div class="detail-item">
                                <span class="detail-label">Nama Pelanggan</span>
                                <span class="detail-val" style="font-weight:600;">{{ $order->customer_name }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Nomor WhatsApp / HP</span>
                                <span class="detail-val">
                                    <a href="https://wa.me/{{ preg_replace('/\D/','',$order->customer_phone) }}" target="_blank">
                                        <i class="fab fa-whatsapp" style="color:#25D366; margin-right:4px;"></i>
                                        {{ $order->customer_phone }}
                                    </a>
                                </span>
                            </div>
                            @if($order->customer_email)
                            <div class="detail-item">
                                <span class="detail-label">Email</span>
                                <span class="detail-val">{{ $order->customer_email }}</span>
                            </div>
                            @endif
                        </div>

                        <div class="detail-item" style="padding-top:8px; border-top:1px solid #F1F5F9;">
                            <span class="detail-label">Alamat Pengiriman Lengkap</span>
                            <span class="detail-val" style="color:#334155;">
                                {{ $order->address_street }}<br>
                                {{ $order->address_kelurahan ? $order->address_kelurahan.', ' : '' }}{{ $order->address_kecamatan }}<br>
                                {{ $order->address_city }}, {{ $order->address_province }} {{ $order->address_postal }}
                            </span>
                        </div>

                        <div style="display:flex; flex-wrap:wrap; gap:10px; margin-top:6px;">
                            <span class="status-pill blue">
                                <i class="fas fa-shipping-fast" style="font-size:10px;"></i>
                                Kurir: {{ $order->shipping_method ?: 'Ekspedisi Reguler' }}
                            </span>
                            @if($order->tracking_number)
                            <span class="status-pill emerald">
                                <i class="fas fa-barcode" style="font-size:10px;"></i>
                                Resi: {{ $order->tracking_number }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: Status, Form & Actions --}}
        <div>
            {{-- Status Ringkas --}}
            <div class="min-card">
                <div class="min-card-header">
                    <h2 class="min-card-title">
                        <i class="fas fa-info-circle"></i>
                        Informasi Pembayaran
                    </h2>
                </div>
                <div class="min-card-body" style="padding:16px 20px;">
                    <div class="detail-list" style="gap:12px;">
                        <div class="detail-item">
                            <span class="detail-label">Metode Pembayaran</span>
                            <span class="detail-val" style="font-weight:700; color:#0D2618;">
                                {{ strtoupper(str_replace('_',' ',$order->payment_method)) }}
                            </span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Status Bayar</span>
                            <span class="detail-val">
                                <span class="status-pill {{ $pc }}">
                                    <span class="status-dot"></span>
                                    {{ $order->payment_status_label }}
                                </span>
                            </span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Status Kirim</span>
                            <span class="detail-val">
                                <span class="status-pill {{ $pillClass }}">
                                    <span class="status-dot"></span>
                                    {{ $order->status_label }}
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Update Status --}}
            <div class="min-card">
                <div class="min-card-header">
                    <h2 class="min-card-title">
                        <i class="fas fa-sliders-h"></i>
                        Update Status Pesanan
                    </h2>
                </div>
                <div class="min-card-body">
                    <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                        @csrf @method('PUT')

                        <div class="form-minimal-group">
                            <label for="order_status">Status Pengiriman</label>
                            <select id="order_status" name="order_status" class="form-minimal-select">
                                @foreach([
                                    'new' => 'Menunggu Konfirmasi',
                                    'processing' => 'Diproses',
                                    'packing' => 'Sedang Dikemas',
                                    'shipped' => 'Sedang Dikirim',
                                    'delivered' => 'Selesai',
                                    'cancelled' => 'Dibatalkan'
                                ] as $v => $l)
                                <option value="{{ $v }}" {{ $order->order_status === $v ? 'selected' : '' }}>{{ $l }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-minimal-group">
                            <label for="payment_status">Status Pembayaran</label>
                            <select id="payment_status" name="payment_status" class="form-minimal-select">
                                @foreach([
                                    'pending' => 'Menunggu',
                                    'confirmed' => 'Dikonfirmasi (Lunas)',
                                    'failed' => 'Gagal'
                                ] as $v => $l)
                                <option value="{{ $v }}" {{ $order->payment_status === $v ? 'selected' : '' }}>{{ $l }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-minimal-group">
                            <label for="tracking_number">Nomor Resi Pengiriman</label>
                            <input type="text" id="tracking_number" name="tracking_number"
                                   value="{{ $order->tracking_number }}"
                                   placeholder="Contoh: JNE123456789"
                                   class="form-minimal-input">
                        </div>

                        <button type="submit" class="btn-save-minimal">
                            <i class="fas fa-check"></i>
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

            {{-- Quick WhatsApp Action --}}
            @php
                $waMsg = "Halo *{$order->customer_name}*, pesanan Anda ({$order->order_number}) sedang dalam proses. Terima kasih telah berbelanja di Bharata Herbal ID.";
                $waUrl = 'https://wa.me/' . preg_replace('/\D/','',$order->customer_phone) . '?text=' . urlencode($waMsg);
            @endphp
            <div class="min-card">
                <div class="min-card-body" style="padding:16px 20px;">
                    <a href="{{ $waUrl }}" target="_blank" class="btn-action-wa">
                        <i class="fab fa-whatsapp" style="font-size:1.1rem;"></i>
                        Hubungi via WhatsApp
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
