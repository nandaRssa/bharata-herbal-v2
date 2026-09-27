@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan aktivitas toko hari ini')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* â”€â”€ Animations â”€â”€ */
@keyframes fadeUp { from { opacity:0; transform:translateY(24px); } to { opacity:1; transform:translateY(0); } }
.fade-up { animation:fadeUp 0.5s ease forwards; opacity:0; }
.fade-up.d1 { animation-delay:0.08s; }
.fade-up.d2 { animation-delay:0.16s; }
.fade-up.d3 { animation-delay:0.24s; }
.fade-up.d4 { animation-delay:0.32s; }

@keyframes pulseDot { 0%,100%{opacity:1;} 50%{opacity:0.35;} }
.pulse-dot { animation:pulseDot 2s ease-in-out infinite; }

/* â”€â”€ Stats Grid â”€â”€ */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}
.stat-card {
    background: #FFFFFF;
    border: 1px solid #E0E6E2;
    border-radius: 16px;
    padding: 20px 24px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 16px;
}
.stat-card:hover {
    border-color: #0D2618;
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(13, 38, 24, 0.06);
}
.stat-icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.stat-icon.gold { background:rgba(13, 38, 24, 0.10); color:#0D2618; }
.stat-icon.green { background:rgba(46,125,50,0.10); color:#2E7D32; }
.stat-icon.orange { background:rgba(245,127,23,0.10); color:#F57F17; }
.stat-icon.red { background:rgba(198,40,40,0.10); color:#C62828; }
.stat-icon svg { width:22px; height:22px; }
.stat-info { display:flex; flex-direction:column; gap:2px; }
.stat-value {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: 1.6rem;
    font-weight: 700;
    color: #0D2618;
    line-height: 1.2;
}
.stat-value .sub {
    font-size: 0.8rem;
    font-weight: 400;
    color: #6A7A72;
    font-family: 'Inter', sans-serif;
}
.stat-label {
    font-family: 'Inter', sans-serif;
    font-size: 0.8rem;
    color: #6A7A72;
}

/* â”€â”€ Cards â”€â”€ */
.card {
    background: #FFFFFF;
    border: 1px solid #E0E6E2;
    border-radius: 16px;
    overflow: hidden;
}
.card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid #E0E6E2;
    gap: 3px;
}
.card-title {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: 1.2rem;
    font-weight: 700;
    color: #0D2618;
    margin:0;
}
.card-subtitle {
    font-family: 'Inter', sans-serif;
    font-size: 0.8rem;
    color: #6A7A72;
    margin:0;
}
.card-body { padding: 20px 24px; }

/* â”€â”€ Gold link â”€â”€ */
.gold-link {
    font-family: 'Inter', sans-serif;
    font-size: 0.8rem;
    font-weight: 600;
    color: #0D2618;
    text-decoration: none;
    transition: all 0.2s;
    white-space: nowrap;
}
.gold-link:hover { text-decoration: underline; color: #0D2618; }

/* â”€â”€ Top Products â”€â”€ */
.top-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid #E8ECEA;
}
.top-item:last-child { border-bottom: none; }
.top-item .rank {
    width: 28px; height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Inter', sans-serif;
    font-size: 0.75rem;
    font-weight: 700;
    flex-shrink: 0;
}
.top-item .rank.gold { background:#0D2618; color:#FFFFFF; }
.top-item .rank.silver { background:#E0E0E0; color:#0D2618; }
.top-item .rank.bronze { background:#CD7F32; color:#FFFFFF; }
.top-item .rank.muted { background:#F5F0EB; color:#6A7A72; }
.top-item .info { flex:1; min-width:0; }
.top-item .info .name {
    font-family: 'Inter', sans-serif;
    font-size: 0.9rem;
    font-weight: 600;
    color: #0D2618;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.top-item .info .sales {
    font-family: 'Inter', sans-serif;
    font-size: 0.75rem;
    color: #6A7A72;
}
.top-item .total {
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    font-weight: 600;
    color: #0D2618;
    white-space: nowrap;
}

/* â”€â”€ Table â”€â”€ */
.table-wrap { overflow-x: auto; }
.table-recent {
    width: 100%;
    border-collapse: collapse;
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
}
.table-recent thead th {
    padding: 12px 16px;
    text-align: left;
    font-weight: 600;
    color: #6A7A72;
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background: #FAFAFA;
    border-bottom: 1px solid #E0E6E2;
}
.table-recent tbody td {
    padding: 12px 16px;
    color: #1A1A1A;
    border-bottom: 1px solid #E8ECEA;
    vertical-align: middle;
}
.table-recent tbody tr { transition: background 0.2s; }
.table-recent tbody tr:hover { background: rgba(13, 38, 24, 0.03); }

/* â”€â”€ Status Badge â”€â”€ */
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
.badge.blue { background:rgba(21,101,192,0.12); color:#1565C0; }
.badge.blue .dot { background:#1565C0; }
.badge.indigo { background:rgba(63,81,181,0.12); color:#3F51B5; }
.badge.indigo .dot { background:#3F51B5; }
.badge.yellow { background:rgba(245,127,23,0.12); color:#F57F17; }
.badge.yellow .dot { background:#F57F17; }
.badge.purple { background:rgba(156,39,176,0.12); color:#9C27B0; }
.badge.purple .dot { background:#9C27B0; }
.badge.green { background:rgba(46,125,50,0.12); color:#2E7D32; }
.badge.green .dot { background:#2E7D32; }
.badge.red { background:rgba(198,40,40,0.12); color:#C62828; }
.badge.red .dot { background:#C62828; }
.badge.gray { background:rgba(106,122,114,0.12); color:#6A7A72; }
.badge.gray .dot { background:#6A7A72; }
.waktu { font-size:0.8rem; color:#8A9A92; white-space:nowrap; }

/* â”€â”€ Chart + Top grid â”€â”€ */
.grid-2col {
    display: grid;
    grid-template-columns: 1.6fr 1fr;
    gap: 16px;
    margin-bottom: 24px;
}
@media (max-width: 900px) {
    .grid-2col { grid-template-columns: 1fr; }
}

/* â”€â”€ Responsive â”€â”€ */
@media (max-width: 1024px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .table-recent { font-size:0.75rem; }
    .table-recent thead th,
    .table-recent tbody td { padding:10px 12px; white-space:nowrap; }
    .badge { font-size:0.6rem; padding:3px 8px; }
    .card-body { padding:14px 16px; }
}
@media (max-width: 640px) {
    .dash-header h2 { font-size:1.4rem !important; }
    .dash-header p { font-size:0.8rem !important; }
}
@media (max-width: 480px) {
    .stats-grid { grid-template-columns:1fr 1fr; gap:10px; }
    .stat-card { padding:12px 14px; gap:10px; }
    .stat-icon { width:36px; height:36px; }
    .stat-icon svg { width:16px; height:16px; }
    .stat-value { font-size:1rem; word-break:break-word; }
    .stat-label { font-size:0.65rem; }
    .card-body { padding:12px 14px !important; }
    .table-recent thead th,
    .table-recent tbody td { padding:8px 10px; }
}
@media (max-width: 400px) {
    .stat-card { flex-direction:column; align-items:flex-start; gap:6px; }
    .stat-icon { width:32px; height:32px; }
    .stat-icon svg { width:14px; height:14px; }
    .stat-value { font-size:0.9rem; }
    .stat-info { gap:0; }
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
    cursor: pointer;
}
.btn-website:hover {
    background: #0D2618;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(13, 38, 24, 0.2);
    color: #FFFFFF;
}
.btn-website svg { transition: transform 0.3s; }
.btn-website:hover svg { transform: translate(2px, -2px); }
</style>
@endpush

@section('content')

<!-- â•â•â• HEADER â•â•â• -->
<div class="dash-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:24px;">
    <div>
        <h2 style="font-family:'Plus Jakarta Sans', 'Inter', sans-serif; font-size:1.8rem; font-weight:700; color:#0D2618; margin:0;">
            Dashboard
        </h2>
        <p style="font-family:'Inter',sans-serif; font-size:0.9rem; color:#6A7A72; margin:2px 0 0;">
            Ringkasan aktivitas toko hari ini
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

<!-- â•â•â• STAT CARDS â•â•â• -->
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
            <span class="stat-value">{{ $todayOrders }}</span>
            <span class="stat-label">Pesanan Hari Ini</span>
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
            <span class="stat-value">Rp {{ number_format($monthRevenue,0,',','.') }}</span>
            <span class="stat-label">Pendapatan Bulan Ini</span>
        </div>
    </div>
    <div class="stat-card fade-up d3">
        <div class="stat-icon orange">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
            </svg>
        </div>
        <div class="stat-info">
            <span class="stat-value">{{ $pendingOrders }}</span>
            <span class="stat-label">Pesanan Pending</span>
        </div>
    </div>
    <div class="stat-card fade-up d4">
        <div class="stat-icon red">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                <line x1="12" y1="9" x2="12" y2="13"/>
                <line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
        </div>
        <div class="stat-info">
            <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                <span class="stat-value" style="font-size:1.2rem;">{{ $criticalStock }} Kritis</span>
                <span style="color:#8A9A92; font-size:1.2rem;">&middot;</span>
                <span class="stat-value" style="font-size:1.2rem;">{{ $restockNeeded }} Restock</span>
            </div>
            <span class="stat-label">Stok Kritis</span>
        </div>
    </div>
</div>

<!-- â•â•â• CHART + TOP 5 â•â•â• -->
<div class="grid-2col">
    {{-- Chart --}}
    <div class="card fade-up">
        <div class="card-header">
            <div>
                <div class="card-title">Grafik Penjualan</div>
                <div class="card-subtitle">30 hari terakhir</div>
            </div>
            <a href="{{ route('admin.reports.index') }}" class="gold-link">Lihat Laporan &rarr;</a>
        </div>
        <div class="card-body">
            <canvas id="salesChart" height="120"></canvas>
        </div>
    </div>
    {{-- Top 5 --}}
    <div class="card fade-up">
        <div class="card-header">
            <div class="card-title" style="font-size:1rem;">Top 5 Produk Terlaris</div>
        </div>
        <div class="card-body" style="padding:8px 24px;">
            @foreach($topProducts as $i => $p)
            <div class="top-item">
                <div class="rank {{ $i===0?'gold':($i===1?'silver':($i===2?'bronze':'muted')) }}">{{ $i+1 }}</div>
                <div class="info">
                    <div class="name">{{ $p->product_name }}</div>
                    <div class="sales">{{ $p->total_qty }} terjual</div>
                </div>
                <div class="total">Rp {{ number_format($p->total_revenue,0,',','.') }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- â•â•â• RECENT ORDERS â•â•â• -->
<div class="card fade-up" style="margin-bottom:24px;">
    <div class="card-header">
        <div style="display:flex; align-items:center; gap:10px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0D2618" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                <rect x="9" y="3" width="6" height="4" rx="1"/>
            </svg>
            <span class="card-title" style="font-size:1rem;">Pesanan Terbaru</span>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="gold-link">Lihat Semua &rarr;</a>
    </div>
    <div class="table-wrap">
        <table class="table-recent">
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                <tr>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}"
                           style="font-family:'Inter',sans-serif; font-weight:700; font-size:0.8rem; color:#0D2618; text-decoration:none; transition:color 0.2s;"
                           onmouseover="this.style.color='#0D2618'" onmouseout="this.style.color='#0D2618'">
                            {{ $order->order_number }}
                        </a>
                    </td>
                    <td style="font-weight:600; color:#1A1A1A;">{{ $order->customer_name }}</td>
                    <td style="font-weight:700; color:#0D2618;">Rp {{ number_format($order->total_amount,0,',','.') }}</td>
                    <td>
                        <span class="badge {{ $order->status_color }}">
                            <span class="dot"></span>
                            {{ $order->status_label }}
                        </span>
                    </td>
                    <td class="waktu">{{ $order->created_at->diffForHumans() }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding:40px 16px; color:#8A9A92;">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#0D2618" stroke-width="1.5" style="display:block; margin:0 auto 8px;">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                            <rect x="9" y="3" width="6" height="4" rx="1"/>
                        </svg>
                        <div style="font-size:0.9rem;">Belum ada pesanan</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
(function() {
    var ctx = document.getElementById('salesChart').getContext('2d');
    var labels = @json($salesChart->pluck('date'));
    var revenues = @json($salesChart->pluck('revenue'));

    var days = labels.map(function(d) {
        var date = new Date(d + 'T00:00:00');
        return date.getDate();
    });

    var grad = ctx.createLinearGradient(0, 0, 0, 280);
    grad.addColorStop(0, 'rgba(13, 38, 24, 0.20)');
    grad.addColorStop(0.5, 'rgba(13, 38, 24, 0.06)');
    grad.addColorStop(1, 'rgba(13, 38, 24, 0.01)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: days,
            datasets: [{
                label: 'Pendapatan',
                data: revenues,
                borderColor: '#0D2618',
                borderWidth: 2.5,
                backgroundColor: grad,
                fill: true,
                tension: 0.4,
                pointRadius: 0,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#0D2618',
                pointHoverBorderColor: '#FFFFFF',
                pointHoverBorderWidth: 3,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0D2618',
                    titleColor: '#F0EDE8',
                    bodyColor: '#FFFFFF',
                    padding: 12,
                    cornerRadius: 12,
                    titleFont: { family: 'Inter', size: 11, weight: '600' },
                    bodyFont: { family: 'Inter', size: 13, weight: '700' },
                    callbacks: {
                        title: function(items) { return 'Tanggal ' + items[0].label; },
                        label: function(ctx) { return ' Rp ' + Number(ctx.parsed.y).toLocaleString('id-ID'); }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#8A9A92', font: { size: 10, family: 'Inter' }, maxTicksLimit: 15 }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#EDE8E0' },
                    ticks: {
                        color: '#8A9A92',
                        font: { size: 10, family: 'Inter' },
                        callback: function(v) { return 'Rp' + (v / 1000).toFixed(0) + 'k'; }
                    }
                }
            }
        }
    });
})();
</script>
@endpush
