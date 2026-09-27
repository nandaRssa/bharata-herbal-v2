@extends('layouts.admin')
@section('title','Laporan')
@section('page-title','Laporan Penjualan')
@section('page-subtitle','Filter dan export data penjualan')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* â”€â”€ Animations â”€â”€ */
@keyframes fadeUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
.fade-up { animation:fadeUp 0.4s ease forwards; opacity:0; }
.fade-up.d1 { animation-delay:0.05s; }
.fade-up.d2 { animation-delay:0.10s; }
.fade-up.d3 { animation-delay:0.15s; }
.fade-up.d4 { animation-delay:0.20s; }

/* â”€â”€ Card â”€â”€ */
.card {
    background:#FFFFFF;
    border:1px solid #E0E6E2;
    border-radius:16px;
    overflow:hidden;
}
.card-body { padding:20px 24px; }

/* â”€â”€ Stats grid â”€â”€ */
.stats-grid {
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:16px;
    margin-bottom:24px;
}
.stat-card {
    background:#FFFFFF;
    border:1px solid #E0E6E2;
    border-radius:16px;
    padding:20px 24px;
    transition:all 0.3s ease;
    display:flex;
    align-items:center;
    gap:16px;
}
.stat-card:hover {
    border-color:#0D2618;
    transform:translateY(-4px);
    box-shadow:0 8px 30px rgba(13, 38, 24, 0.06);
}
.stat-icon {
    width:48px; height:48px;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    flex-shrink:0;
}
.stat-icon.gold { background:rgba(13, 38, 24, 0.10); color:#0D2618; }
.stat-icon.green { background:rgba(46,125,50,0.10); color:#2E7D32; }
.stat-icon.blue { background:rgba(21,101,192,0.10); color:#1565C0; }
.stat-icon.orange { background:rgba(245,127,23,0.10); color:#F57F17; }
.stat-icon svg { width:22px; height:22px; }
.stat-info { display:flex; flex-direction:column; gap:2px; }
.stat-value {
    font-family:'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size:1.6rem;
    font-weight:700;
    color:#0D2618;
    line-height:1.2;
}
.stat-label { font-family:'Inter',sans-serif; font-size:0.8rem; color:#6A7A72; }

/* â”€â”€ Filter bar â”€â”€ */
.filter-bar {
    display:flex;
    flex-wrap:wrap;
    gap:12px;
    align-items:flex-end;
    margin-bottom:24px;
}
.filter-bar .fg { display:flex; flex-direction:column; gap:4px; }
.filter-bar .fg label {
    font-family:'Inter',sans-serif;
    font-size:0.75rem;
    font-weight:600;
    color:#6A7A72;
}
.filter-bar input[type="date"] {
    padding:10px 14px;
    border:2px solid #E0E6E2;
    border-radius:10px;
    font-family:'Inter',sans-serif;
    font-size:0.85rem;
    color:#0D2618;
    background:#FFFFFF;
    transition:all 0.3s ease;
    outline:none;
}
.filter-bar input[type="date"]:focus {
    border-color:#0D2618;
    box-shadow:0 0 0 4px rgba(13, 38, 24, 0.08);
}
.btn-filter-green {
    padding:10px 24px;
    background:#0D2618;
    color:#FFFFFF;
    border:none;
    border-radius:10px;
    font-family:'Inter',sans-serif;
    font-size:0.85rem;
    font-weight:600;
    cursor:pointer;
    transition:all 0.3s ease;
    display:inline-flex;
    align-items:center;
    gap:8px;
}
.btn-filter-green:hover { background:#0D2618; transform:scale(1.02); }
.btn-export {
    padding:10px 24px;
    background:linear-gradient(135deg,#0D2618,#0D2618);
    color:#FFFFFF;
    border:none;
    border-radius:10px;
    font-family:'Inter',sans-serif;
    font-size:0.85rem;
    font-weight:600;
    cursor:pointer;
    transition:all 0.3s ease;
    display:inline-flex;
    align-items:center;
    gap:8px;
    text-decoration:none;
}
.btn-export:hover {
    transform:scale(1.02);
    box-shadow:0 8px 30px rgba(13, 38, 24, 0.2);
    color:#FFFFFF;
}

/* â”€â”€ Table â”€â”€ */
.table-wrap { overflow-x:auto; }
.table-rpt {
    width:100%;
    border-collapse:collapse;
    font-family:'Inter',sans-serif;
    font-size:0.85rem;
}
.table-rpt thead { background:#F5F0EB; }
.table-rpt th {
    padding:14px 16px;
    text-align:left;
    font-weight:600;
    color:#0D2618;
    font-size:0.75rem;
    text-transform:uppercase;
    letter-spacing:0.5px;
    border-bottom:2px solid #E0E6E2;
    white-space:nowrap;
}
.table-rpt td {
    padding:12px 16px;
    color:#1A1A1A;
    border-bottom:1px solid #E8ECEA;
    vertical-align:middle;
}
.table-rpt tbody tr { transition:background 0.2s; }
.table-rpt tbody tr:hover { background:rgba(13, 38, 24, 0.03); }

/* â”€â”€ Badge â”€â”€ */
.badge {
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:4px 12px;
    border-radius:50px;
    font-size:0.7rem;
    font-weight:600;
    text-transform:uppercase;
    letter-spacing:0.5px;
}
.badge .dot { width:6px; height:6px; border-radius:50%; display:inline-block; }
.badge-green { background:rgba(46,125,50,0.12); color:#2E7D32; }
.badge-green .dot { background:#2E7D32; }
.badge-orange { background:rgba(245,127,23,0.12); color:#F57F17; }
.badge-orange .dot { background:#F57F17; }
.badge-red { background:rgba(198,40,40,0.12); color:#C62828; }
.badge-red .dot { background:#C62828; }

/* â”€â”€ Order link â”€â”€ */
.order-link {
    font-weight:700; font-size:0.8rem; color:#0D2618;
    text-decoration:none; transition:color 0.2s;
}
.order-link:hover { color:#0D2618; }
.no-data { text-align:center; padding:60px 16px; color:#8A9A92; }

/* â”€â”€ Responsive â”€â”€ */
@media (max-width:1024px) { .stats-grid { grid-template-columns:repeat(2,1fr); } }
@media (max-width:768px) {
    .table-rpt { font-size:0.75rem; }
    .table-rpt th, .table-rpt td { padding:10px 12px; white-space:nowrap; }
    .badge { font-size:0.6rem; padding:3px 8px; }
    .card-body { padding:14px 16px; }
}
@media (max-width:640px) {
    .rpt-header h2 { font-size:1.4rem !important; }
    .rpt-header p { font-size:0.8rem !important; }
    .filter-bar .fg { width:100%; }
    .filter-bar input[type="date"] { width:100%; }
    .btn-filter-green, .btn-export { width:100%; justify-content:center; }
}
@media (max-width:480px) {
    .stats-grid { grid-template-columns:1fr 1fr; gap:8px; }
    .stat-card { padding:12px 14px; gap:10px; }
    .stat-icon { width:36px; height:36px; }
    .stat-icon svg { width:16px; height:16px; }
    .stat-value { font-size:1rem; word-break:break-word; }
    .stat-label { font-size:0.65rem; }
    .card-body { padding:12px 14px !important; }
    .table-rpt th, .table-rpt td { padding:8px 10px; }
}
@media (max-width:400px) {
    .stat-card { flex-direction:column; align-items:flex-start; gap:6px; }
    .stat-icon { width:32px; height:32px; }
    .stat-icon svg { width:14px; height:14px; }
    .stat-value { font-size:0.9rem; }
    .stat-info { gap:0; }
}
</style>
@endpush

@section('content')

<!-- â•â•â• HEADER â•â•â• -->
<div class="rpt-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:24px;">
    <div>
        <h2 style="font-family:'Plus Jakarta Sans', 'Inter', sans-serif; font-size:1.8rem; font-weight:700; color:#0D2618; margin:0;">
            Laporan Penjualan
        </h2>
        <p style="font-family:'Inter',sans-serif; font-size:0.9rem; color:#6A7A72; margin:2px 0 0;">
            Filter dan export data penjualan
        </p>
    </div>
    <a href="{{ route('home') }}" target="_blank"
       style="display:inline-flex; align-items:center; gap:8px; background:#0D2618; color:#FFFFFF; border:none; border-radius:50px; padding:10px 20px; font-family:'Inter',sans-serif; font-size:0.85rem; font-weight:600; text-decoration:none; transition:all 0.3s ease;"
       onmouseover="this.style.background='#0D2618'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(13, 38, 24, 0.2)'"
       onmouseout="this.style.background='#0D2618'; this.style.transform='none'; this.style.boxShadow='none'">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/>
            <polyline points="15 3 21 3 21 9"/>
            <line x1="10" y1="14" x2="21" y2="3"/>
        </svg>
        Lihat Website
    </a>
</div>

<!-- â•â•â• FILTER â•â•â• -->
<form method="GET" action="{{ route('admin.reports.index') }}" class="filter-bar fade-up d1">
    <div class="fg">
        <label>Tanggal Mulai</label>
        <input type="date" name="start_date" value="{{ $start }}">
    </div>
    <div class="fg">
        <label>Tanggal Akhir</label>
        <input type="date" name="end_date" value="{{ $end }}">
    </div>
    <button type="submit" class="btn-filter-green">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
        </svg>
        Filter
    </button>
    <a href="{{ route('admin.reports.excel', ['start_date' => $start, 'end_date' => $end]) }}" class="btn-export">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
            <polyline points="7 10 12 15 17 10"/>
            <line x1="12" y1="15" x2="12" y2="3"/>
        </svg>
        Export Excel
    </a>
</form>

<!-- â•â•â• STATS â•â•â• -->
<div class="stats-grid">
    <div class="stat-card fade-up d1">
        <div class="stat-icon gold">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                <line x1="3" y1="6" x2="21" y2="6"/>
                <path d="M16 10a4 4 0 01-8 0"/>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-value">{{ $totalOrders }}</span>
            <span class="stat-label">Total Pesanan</span>
        </div>
    </div>
    <div class="stat-card fade-up d2">
        <div class="stat-icon green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 1v22"/>
                <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-value">Rp {{ number_format($totalRevenue,0,',','.') }}</span>
            <span class="stat-label">Total Pendapatan</span>
        </div>
    </div>
    <div class="stat-card fade-up d3">
        <div class="stat-icon blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-value">{{ $confirmedOrders }}</span>
            <span class="stat-label">Pesanan Dikonfirmasi</span>
        </div>
    </div>
    <div class="stat-card fade-up d4">
        <div class="stat-icon orange">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-value">Rp {{ number_format($averagePerOrder,0,',','.') }}</span>
            <span class="stat-label">Rata-rata per Pesanan</span>
        </div>
    </div>
</div>

<!-- â•â•â• TABLE â•â•â• -->
<div class="card fade-up d2">
    <div class="table-wrap">
        <table class="table-rpt">
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Produk</th>
                    <th style="text-align:right;">Total</th>
                    <th>Pembayaran</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                @php $payColor = $order->payment_status === 'confirmed' ? 'green' : ($order->payment_status === 'failed' ? 'red' : 'orange'); @endphp
                <tr>
                    <td><a href="{{ route('admin.orders.show', $order) }}" class="order-link">{{ $order->order_number }}</a></td>
                    <td style="font-weight:600; color:#1A1A1A;">{{ $order->customer_name }}</td>
                    <td style="color:#8A9A92; font-size:0.8rem;">{{ $order->items->count() }} item</td>
                    <td style="text-align:right; font-weight:700; color:#0D2618; white-space:nowrap;">Rp {{ number_format($order->total_amount,0,',','.') }}</td>
                    <td>
                        <span class="badge badge-{{ $payColor }}">
                            <span class="dot"></span>
                            {{ $order->payment_status_label }}
                        </span>
                    </td>
                    <td style="font-size:0.8rem; color:#6A7A72; white-space:nowrap;">{{ $order->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="no-data">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#0D2618" stroke-width="1.5" style="display:block; margin:0 auto 8px;">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                        <rect x="9" y="3" width="6" height="4" rx="1"/>
                    </svg>
                    <div style="font-weight:600; color:#0D2618; margin-bottom:4px;">Tidak ada data</div>
                    <div style="font-size:0.85rem;">Tidak ada pesanan untuk periode ini.</div>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->count())
    <div style="display:flex; justify-content:space-between; align-items:center; padding:14px 20px; border-top:1px solid #E0E6E2; background:#FAFAFA; flex-wrap:wrap; gap:12px;">
        <div style="font-family:'Inter',sans-serif; font-size:0.85rem; color:#6A7A72;">
            Showing 1 to {{ $orders->count() }} of {{ $orders->count() }} results
        </div>
    </div>
    @endif
</div>

@endsection
