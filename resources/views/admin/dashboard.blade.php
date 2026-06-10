@extends('layouts.admin')
@section('title','Dashboard')
@section('page-title','Dashboard')
@section('page-subtitle','Ringkasan aktivitas toko hari ini')

@section('content')
<!-- Stat Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">
    <!-- Pesanan Hari Ini -->
    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex items-center justify-between" style="border-left: 5px solid var(--primary)">
        <div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pesanan Hari Ini</p>
            <p class="text-2xl font-bold mt-1.5 tracking-wide" style="color: var(--primary)">{{ $todayOrders }}</p>
        </div>
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-2xl bg-emerald-50/40">🛒</div>
    </div>
    <!-- Pendapatan Bulan Ini -->
    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex items-center justify-between" style="border-left: 5px solid #c5a059">
        <div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pendapatan Bulan Ini</p>
            <p class="text-xl font-bold mt-1.5 tracking-wide" style="color: #c5a059">Rp {{ number_format($monthRevenue,0,',','.') }}</p>
        </div>
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-2xl bg-amber-50/40">💰</div>
    </div>
    <!-- Pesanan Pending -->
    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex items-center justify-between" style="border-left: 5px solid #d97706">
        <div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pesanan Pending</p>
            <p class="text-2xl font-bold mt-1.5 tracking-wide" style="color: #d97706">{{ $pendingOrders }}</p>
        </div>
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-2xl bg-amber-50/20">⏳</div>
    </div>
    <!-- Stok Kritis -->
    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm" style="border-left: 5px solid #dc2626">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Stok Kritis</p>
                <div class="flex items-center gap-2 mb-1">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-700">⚠️ {{ $criticalStock }} Produk Stok Kritis</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-700">🔶 {{ $restockNeeded }} Perlu Restock</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-2xl bg-rose-50/40 flex-shrink-0">⚠️</div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8 mb-10">
    <!-- Grafik Penjualan -->
    <div class="xl:col-span-2 bg-white rounded-3xl shadow-sm border border-slate-100 p-6 lg:p-8">
        <div class="flex items-center justify-between mb-6 border-b border-slate-100 pb-3">
            <h2 class="text-xl font-bold font-serif-elegant tracking-wide" style="color: var(--primary);">Grafik Penjualan (30 Hari Terakhir)</h2>
        </div>
        <canvas id="salesChart" height="120"></canvas>
    </div>

    <!-- Top Produk -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 lg:p-8">
        <h2 class="text-xl font-bold font-serif-elegant tracking-wide border-b border-slate-100 pb-3 mb-5" style="color: var(--primary);">🏆 Top 5 Produk Terlaris</h2>
        <div class="space-y-4">
            @foreach($topProducts as $i => $p)
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl text-xs font-bold flex items-center justify-center flex-shrink-0 shadow-sm"
                     style="background: {{ $i === 0 ? 'var(--gold)' : ($i === 1 ? '#94a3b8' : 'var(--primary)') }}; color: white;">
                    {{ $i+1 }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-slate-700 truncate">{{ $p->product_name }}</p>
                    <p class="text-[10px] uppercase tracking-wider text-slate-400 font-semibold mt-0.5">{{ $p->total_qty }} terjual</p>
                </div>
                <div class="text-xs font-bold" style="color: var(--gold-dark);">Rp {{ number_format($p->total_revenue,0,',','.') }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Pesanan Terbaru -->
<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
        <h2 class="text-xl font-bold font-serif-elegant tracking-wide" style="color: var(--primary);">📋 Pesanan Terbaru</h2>
        <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 rounded-lg text-xs font-bold text-white transition shadow-sm hover:shadow" style="background: var(--primary);">
            Lihat Semua Pesanan
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="premium-table">
            <thead>
                <tr>
                    <th class="text-left">No. Pesanan</th>
                    <th class="text-left">Pelanggan</th>
                    <th class="text-left">Total Pembayaran</th>
                    <th class="text-left">Status</th>
                    <th class="text-left">Waktu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                <tr>
                    <td class="font-mono font-bold text-xs">
                        <a href="{{ route('admin.orders.show', $order) }}" class="hover:text-amber-700 transition" style="color: var(--primary);">{{ $order->order_number }}</a>
                    </td>
                    <td class="font-bold text-slate-700">{{ $order->customer_name }}</td>
                    <td class="font-extrabold" style="color: var(--gold-dark);">Rp {{ number_format($order->total_amount,0,',','.') }}</td>
                    <td>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                            @if($order->status_color === 'green') bg-emerald-50 text-emerald-800 border border-emerald-100
                            @elseif($order->status_color === 'yellow') bg-amber-50 text-amber-800 border border-amber-100
                            @elseif($order->status_color === 'red') bg-rose-50 text-rose-800 border border-rose-100
                            @elseif($order->status_color === 'blue') bg-blue-50 text-blue-800 border border-blue-100
                            @else bg-slate-50 text-slate-800 border border-slate-100
                            @endif">
                            {{ $order->status_label }}
                        </span>
                    </td>
                    <td class="text-slate-400 text-xs font-semibold">{{ $order->created_at->diffForHumans() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function() {
    const ctx = document.getElementById('salesChart').getContext('2d');
    const labels = @json($salesChart->pluck('date'));
    const orders = @json($salesChart->pluck('orders'));

    // Gradient fill
    const gradient = ctx.createLinearGradient(0, 0, 0, 280);
    gradient.addColorStop(0, 'rgba(28, 69, 38, 0.18)');
    gradient.addColorStop(1, 'rgba(28, 69, 38, 0.01)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Jumlah Pesanan',
                data: orders,
                borderColor: '#1C4526',
                borderWidth: 2.5,
                backgroundColor: gradient,
                fill: true,
                tension: 0.45,
                pointRadius: 4,
                pointBackgroundColor: '#1C4526',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointHoverRadius: 6,
            }]
        },
        options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1C4526',
                    titleColor: '#fff',
                    bodyColor: '#d1fae5',
                    padding: 10,
                    cornerRadius: 8,
                    callbacks: {
                        label: ctx => ` ${ctx.parsed.y} pesanan`
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#94a3b8', font: { size: 11 }, maxTicksLimit: 10 }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: { color: '#94a3b8', font: { size: 11 }, stepSize: 1 }
                }
            }
        }
    });
})();
</script>
@endpush
