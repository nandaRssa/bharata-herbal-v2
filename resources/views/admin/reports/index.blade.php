@extends('layouts.admin')
@section('title','Laporan')
@section('page-title','Laporan Penjualan')
@section('page-subtitle','Filter dan export data penjualan')

@section('content')
<!-- Filter -->
<div class="bg-white rounded-2xl shadow-sm p-5 mb-6">
    <form method="GET" class="flex flex-wrap gap-3 items-end">
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal Mulai</label>
            <input type="date" name="start_date" value="{{ $start }}" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal Akhir</label>
            <input type="date" name="end_date" value="{{ $end }}" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
        </div>
        <button type="submit" class="px-4 py-2 rounded-lg text-sm font-bold text-white transition" style="background:#1C4526;">Filter</button>
        <div class="flex gap-2 flex-wrap items-center">
            <a href="{{ route('admin.reports.excel', ['start_date' => $start, 'end_date' => $end]) }}"
               class="flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition"
               title="Export data Excel sesuai filter tanggal yang dipilih">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                Export Excel
            </a>
        </div>
    </form>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
    <div class="stat-card">
        <p class="text-xs text-gray-400 uppercase tracking-wide">Total Pesanan</p>
        <p class="text-3xl font-bold mt-1" style="color:var(--primary);font-family:'Cormorant Garamond',serif">{{ $totalOrders }}</p>
    </div>
    <div class="stat-card" style="border-left-color:var(--gold)">
        <p class="text-xs text-gray-400 uppercase tracking-wide">Total Pendapatan</p>
        <p class="text-2xl font-bold mt-1" style="color:var(--gold);font-family:'Cormorant Garamond',serif">Rp {{ number_format($totalRevenue,0,',','.') }}</p>
        <p class="text-xs text-gray-400">Pesanan dikonfirmasi</p>
    </div>
    <div class="stat-card" style="border-left-color:#52B788">
        <p class="text-xs text-gray-400 uppercase tracking-wide">Rata-rata per Pesanan</p>
        <p class="text-2xl font-bold mt-1" style="color:#52B788;font-family:'Cormorant Garamond',serif">
            Rp {{ $totalOrders > 0 ? number_format($totalRevenue/$totalOrders,0,',','.') : '0' }}
        </p>
    </div>
</div>

<!-- Tabel Laporan -->
<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead style="background:#f8fdf9">
            <tr class="text-xs text-gray-500 uppercase border-b">
                <th class="text-left py-3 px-4">No. Pesanan</th>
                <th class="text-left py-3 px-4">Pelanggan</th>
                <th class="text-left py-3 px-4">Produk</th>
                <th class="text-left py-3 px-4">Total</th>
                <th class="text-left py-3 px-4">Pembayaran</th>
                <th class="text-left py-3 px-4">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr class="table-row border-b border-gray-50">
                <td class="py-3 px-4 font-mono text-xs font-semibold" style="color:var(--primary)">{{ $order->order_number }}</td>
                <td class="py-3 px-4">{{ $order->customer_name }}</td>
                <td class="py-3 px-4 text-xs text-gray-500">{{ $order->items->count() }} item</td>
                <td class="py-3 px-4 font-bold" style="color:var(--gold)">Rp {{ number_format($order->total_amount,0,',','.') }}</td>
                <td class="py-3 px-4">
                    <span class="badge {{ $order->payment_status==='confirmed'?'badge-green':($order->payment_status==='failed'?'badge-red':'badge-yellow') }}">
                        {{ $order->payment_status_label }}
                    </span>
                </td>
                <td class="py-3 px-4 text-xs text-gray-400">{{ $order->created_at->format('d M Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="6" class="py-12 text-center text-gray-400">Tidak ada data untuk periode ini.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
