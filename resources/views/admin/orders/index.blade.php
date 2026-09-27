@extends('layouts.admin')
@section('title','Manajemen Pesanan')
@section('page-title','Manajemen Pesanan')
@section('page-subtitle','Kelola semua pesanan masuk')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* â”€â”€ Animations â”€â”€ */
@keyframes fadeUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
.fade-up { animation:fadeUp 0.45s ease forwards; opacity:0; }
.fade-up.d1 { animation-delay:0.06s; }
.fade-up.d2 { animation-delay:0.12s; }
.fade-up.d3 { animation-delay:0.18s; }
.fade-up.d4 { animation-delay:0.24s; }

@keyframes pulseDot { 0%,100%{opacity:1;} 50%{opacity:0.35;} }
.pulse-dot { animation:pulseDot 2s ease-in-out infinite; }

/* â”€â”€ Action Bar â”€â”€ */
.action-bar {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
}
.search-wrapper {
    display: flex;
    flex: 1;
    min-width: 200px;
    max-width: 350px;
    background: #FFFFFF;
    border: 2px solid #E0E6E2;
    border-radius: 50px;
    overflow: hidden;
    transition: all 0.3s ease;
}
.search-wrapper:focus-within {
    border-color: #0D2618;
    box-shadow: 0 0 0 4px rgba(13, 38, 24, 0.08);
}
.search-wrapper input {
    flex: 1;
    padding: 10px 18px;
    border: none;
    outline: none;
    font-family: 'Inter', sans-serif;
    font-size: 0.9rem;
    color: #0D2618;
    background: transparent;
    min-width: 80px;
}
.search-wrapper input::placeholder { color: #8A9A92; }
.search-wrapper .search-icon {
    display: flex;
    align-items: center;
    padding: 0 4px 0 16px;
    color: #8A9A92;
    flex-shrink: 0;
}
.search-wrapper button {
    padding: 10px 18px;
    background: #0D2618;
    color: #FFFFFF;
    border: none;
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
}
.search-wrapper button:hover { background: #0D2618; }

.filter-group {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}
.filter-group select,
.filter-group input[type="date"] {
    padding: 10px 16px;
    border: 2px solid #C8D0CB;
    border-radius: 10px;
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    color: #0D2618;
    background: #FFFFFF;
    transition: all 0.3s ease;
    outline: none;
    cursor: pointer;
    min-width: 140px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.filter-group input[type="date"]::-webkit-calendar-picker-indicator {
    opacity: 0.6;
    cursor: pointer;
}
.filter-group select:focus,
.filter-group input[type="date"]:focus {
    border-color: #0D2618;
    box-shadow: 0 0 0 4px rgba(13, 38, 24, 0.08);
}
.btn-filter {
    padding: 10px 24px;
    background: linear-gradient(135deg, #0D2618, #0D2618);
    color: #FFFFFF;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
.btn-filter:hover {
    transform: scale(1.02);
    box-shadow: 0 8px 30px rgba(13, 38, 24, 0.2);
}
.btn-reset {
    padding: 10px 20px;
    border: 2px solid #C8D0CB;
    border-radius: 10px;
    background: transparent;
    color: #4A5A52;
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-reset:hover {
    border-color: #C62828;
    color: #C62828;
}

/* â”€â”€ Card â”€â”€ */
.card {
    background: #FFFFFF;
    border: 1px solid #E0E6E2;
    border-radius: 16px;
    overflow: hidden;
}

/* â”€â”€ Table â”€â”€ */
.table-wrap { overflow-x: auto; }
.table-orders {
    width: 100%;
    border-collapse: collapse;
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
}
.table-orders thead { background: #F5F0EB; }
.table-orders th {
    padding: 14px 16px;
    text-align: left;
    font-weight: 600;
    color: #0D2618;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #E0E6E2;
    white-space: nowrap;
}
.table-orders td {
    padding: 12px 16px;
    color: #1A1A1A;
    border-bottom: 1px solid #E8ECEA;
    vertical-align: middle;
}
.table-orders tbody tr { transition: background 0.2s; }
.table-orders tbody tr:hover { background: rgba(13, 38, 24, 0.03); }

/* â”€â”€ Customer cell â”€â”€ */
.customer-cell { display:flex; flex-direction:column; gap:2px; }
.customer-cell .name { font-weight:600; color:#0D2618; font-size:0.9rem; }
.customer-cell .phone { font-size:0.75rem; color:#8A9A92; }

/* â”€â”€ Order number â”€â”€ */
.order-num {
    font-family: 'Inter', sans-serif;
    font-weight: 700;
    font-size: 0.8rem;
    color: #0D2618;
    text-decoration: none;
    transition: color 0.2s;
    white-space: nowrap;
}
.order-num:hover { color: #0D2618; }

/* â”€â”€ Total â”€â”€ */
.total-amount {
    font-weight: 700;
    color: #0D2618;
    white-space: nowrap;
}

/* â”€â”€ Date cell â”€â”€ */
.date-cell { white-space:nowrap; }
.date-cell .d { font-size:0.8rem; color:#6A7A72; }
.date-cell .t { font-size:0.7rem; color:#8A9A92; }

/* â”€â”€ Unified badges â”€â”€ */
.badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px;
    border-radius: 50px;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.badge .dot { width:6px; height:6px; border-radius:50%; display:inline-block; }
.badge-green { background:rgba(46,125,50,0.12); color:#2E7D32; }
.badge-green .dot { background:#2E7D32; }
.badge-orange { background:rgba(245,127,23,0.12); color:#F57F17; }
.badge-orange .dot { background:#F57F17; }
.badge-red { background:rgba(198,40,40,0.12); color:#C62828; }
.badge-red .dot { background:#C62828; }
.badge-blue { background:rgba(21,101,192,0.12); color:#1565C0; }
.badge-blue .dot { background:#1565C0; }
.badge-indigo { background:rgba(63,81,181,0.12); color:#3F51B5; }
.badge-indigo .dot { background:#3F51B5; }
.badge-purple { background:rgba(156,39,176,0.12); color:#9C27B0; }
.badge-purple .dot { background:#9C27B0; }
.badge-gray { background:rgba(106,122,114,0.12); color:#6A7A72; }
.badge-gray .dot { background:#6A7A72; }

/* â”€â”€ Detail button â”€â”€ */
.btn-detail {
    padding: 6px 16px;
    background: #0D2618;
    color: #FFFFFF;
    border: none;
    border-radius: 6px;
    font-family: 'Inter', sans-serif;
    font-size: 0.75rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-detail:hover {
    background: #0D2618;
    transform: scale(1.05);
    color: #FFFFFF;
}
.btn-detail svg { transition: transform 0.25s; }
.btn-detail:hover svg { transform: scale(1.15); }

/* â”€â”€ Footer / Pagination â”€â”€ */
.table-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    border-top: 1px solid #E0E6E2;
    background: #FAFAFA;
    border-radius: 0 0 16px 16px;
    flex-wrap: wrap;
    gap: 12px;
}
.table-footer .info {
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    color: #6A7A72;
}
.pagination-wrap { display:flex; gap:6px; align-items:center; }
.pagination-wrap a,
.pagination-wrap span {
    width: 36px; height: 36px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #E0E6E2;
    border-radius: 8px;
    background: #FFFFFF;
    color: #0D2618;
    font-family: 'Inter', sans-serif;
    font-weight: 500;
    font-size: 0.85rem;
    text-decoration: none;
    transition: all 0.3s ease;
}
.pagination-wrap a:hover {
    border-color: #0D2618;
    color: #0D2618;
}
.pagination-wrap .active {
    background: linear-gradient(135deg, #0D2618, #0D2618);
    color: #FFFFFF;
    border-color: #0D2618;
}
.pagination-wrap .disabled {
    opacity: 0.4;
    cursor: not-allowed;
    pointer-events: none;
}

/* â”€â”€ Lihat Website button â”€â”€ */
.btn-website {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #0D2618;
    color: #FFFFFF;
    border: none;
    border-radius: 50px;
    padding: 10px 20px;
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}
.btn-website:hover {
    background: #0D2618;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(13, 38, 24, 0.2);
    color: #FFFFFF;
}
.btn-website svg { transition: transform 0.3s; }
.btn-website:hover svg { transform: translate(2px,-2px); }

/* â”€â”€ Responsive â”€â”€ */
@media (max-width: 1024px) {
    .table-orders { font-size:0.75rem; }
    .table-orders th,
    .table-orders td { padding:10px 12px; white-space:nowrap; }
}
@media (max-width: 768px) {
    .action-bar { flex-direction:column; align-items:stretch; }
    .search-wrapper { max-width:100%; border-radius:12px; }
    .filter-group { flex-direction:column; align-items:stretch; gap:8px; width:100%; }
    .filter-group select,
    .filter-group input[type="date"] { width:100%; }
    .btn-filter,
    .btn-reset { width:100%; justify-content:center; padding:12px; }
    .table-orders { font-size:0.7rem; }
    .table-orders th,
    .table-orders td { padding:8px 10px; }
    .badge { font-size:0.6rem; padding:2px 8px; }
    .btn-detail { padding:4px 10px; font-size:0.65rem; }
}
@media (max-width: 480px) {
    .table-footer { flex-direction:column; gap:12px; text-align:center; }
    .pagination-wrap a,
    .pagination-wrap span { width:32px; height:32px; font-size:0.75rem; }
}
</style>
@endpush

@section('content')

<!-- â• â• â•  HEADER â• â• â•  -->
<div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:24px;">
    <div>
        <h2 style="font-family:'Plus Jakarta Sans', 'Inter', sans-serif; font-size:1.8rem; font-weight:700; color:#0D2618; margin:0;">
            Daftar Pesanan
        </h2>
        <p style="font-family:'Inter',sans-serif; font-size:0.9rem; color:#6A7A72; margin:2px 0 0;">
            Kelola semua pesanan masuk
        </p>
    </div>
    <a href="{{ route('home') }}" target="_blank" class="btn-website">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/>
            <polyline points="15 3 21 3 21 9"/>
            <line x1="10" y1="14" x2="21" y2="3"/>
        </svg>
        Lihat Website
    </a>
</div>

<!-- â•â•â• SEARCH & FILTER â•â•â• -->
<form method="GET" action="{{ route('admin.orders.index') }}" class="action-bar fade-up d1">
    <div class="search-wrapper">
        <span class="search-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/>
                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
        </span>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / no. pesanan..." autocomplete="off">
        <button type="submit">Cari</button>
    </div>
    <div class="filter-group">
        <select name="status">
            <option value="">Semua Status</option>
            @foreach(['new'=>'Pesanan Baru','processing'=>'Diproses','packing'=>'Dikemas','shipped'=>'Dikirim','delivered'=>'Diterima','cancelled'=>'Dibatalkan'] as $v=>$l)
            <option value="{{ $v }}" {{ request('status')===$v?'selected':'' }}>{{ $l }}</option>
            @endforeach
        </select>
        <input type="date" name="date" value="{{ request('date') }}">
        <button type="submit" class="btn-filter">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
            </svg>
            Saring
        </button>
        @if(request()->anyFilled(['search','status','date']))
        <a href="{{ route('admin.orders.index') }}" class="btn-reset">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
            Reset
        </a>
        @endif
    </div>
</form>

<!-- â•â•â• TABLE â•â•â• -->
<div class="card fade-up d2">
    <div class="table-wrap">
        <table class="table-orders">
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Pelanggan</th>
                    <th style="text-align:right;">Total</th>
                    <th>Status Bayar</th>
                    <th>Status Kirim</th>
                    <th>Tanggal</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                @php
                    $payColor = $order->payment_status === 'confirmed' ? 'green' : ($order->payment_status === 'failed' ? 'red' : 'orange');
                @endphp
                <tr>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="order-num">
                            {{ $order->order_number }}
                        </a>
                    </td>
                    <td>
                        <div class="customer-cell">
                            <span class="name">{{ $order->customer_name }}</span>
                            <span class="phone">{{ $order->customer_phone }}</span>
                        </div>
                    </td>
                    <td style="text-align:right;">
                        <span class="total-amount">Rp {{ number_format($order->total_amount,0,',','.') }}</span>
                    </td>
                    <td>
                        <span class="badge badge-{{ $payColor }}">
                            <span class="dot {{ $payColor === 'green' ? '' : 'pulse-dot' }}"></span>
                            {{ $order->payment_status_label }}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-{{ $order->status_color === 'green' ? 'green' : ($order->status_color === 'red' ? 'red' : ($order->status_color === 'yellow' ? 'orange' : ($order->status_color === 'purple' ? 'purple' : ($order->status_color === 'indigo' ? 'indigo' : ($order->status_color === 'blue' ? 'blue' : 'gray'))))) }}">
                            <span class="dot"></span>
                            {{ $order->status_label }}
                        </span>
                    </td>
                    <td>
                        <div class="date-cell">
                            <div class="d">{{ $order->created_at->format('d M Y') }}</div>
                            <div class="t">{{ $order->created_at->format('H:i') }}</div>
                        </div>
                    </td>
                    <td style="text-align:center;">
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn-detail">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding:60px 16px; color:#8A9A92;">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#0D2618" stroke-width="1.5" style="display:block; margin:0 auto 12px;">
                            <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <div style="font-size:1rem; font-weight:600; color:#0D2618; margin-bottom:4px;">Belum ada pesanan</div>
                        <div style="font-size:0.85rem;">
                            @if(request()->anyFilled(['search','status','date']))
                            Pesanan tidak ditemukan. Coba ubah filter pencarian.
                            @else
                            Belum ada pesanan masuk saat ini.
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
    <div class="table-footer">
        <div class="info">
            Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} results
        </div>
        <div class="pagination-wrap">
            @if($orders->onFirstPage())
                <span class="disabled">&laquo;</span>
            @else
                <a href="{{ $orders->previousPageUrl() }}">&laquo;</a>
            @endif

            @foreach($orders->getUrlRange(max(1, $orders->currentPage() - 2), min($orders->lastPage(), $orders->currentPage() + 2)) as $page => $url)
                <a href="{{ $url }}" class="{{ $page === $orders->currentPage() ? 'active' : '' }}">{{ $page }}</a>
            @endforeach

            @if($orders->hasMorePages())
                <a href="{{ $orders->nextPageUrl() }}">&raquo;</a>
            @else
                <span class="disabled">&raquo;</span>
            @endif
        </div>
    </div>
    @endif
</div>

@endsection
