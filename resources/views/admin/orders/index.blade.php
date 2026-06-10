@extends('layouts.admin')
@section('title','Manajemen Pesanan')
@section('page-title','Manajemen Pesanan')
@section('page-subtitle','Kelola semua pesanan masuk')

@push('styles')
<meta http-equiv="refresh" content="30">
@endpush

@section('content')
<!-- Filter Bar -->
<div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 mb-8 flex flex-wrap gap-4 items-center justify-between">
    <form method="GET" class="flex flex-wrap gap-3 flex-1 items-center">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / no. pesanan..."
            class="border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-medium w-64 transition duration-200">
        
        <select name="status" class="border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-semibold transition duration-200 bg-white">
            <option value="">Semua Status</option>
            @foreach(['new'=>'Pesanan Baru','processing'=>'Diproses','shipped'=>'Dikirim','delivered'=>'Diterima','cancelled'=>'Dibatalkan'] as $v=>$l)
            <option value="{{ $v }}" {{ request('status')===$v?'selected':'' }}>{{ $l }}</option>
            @endforeach
        </select>
        
        <input type="date" name="date" value="{{ request('date') }}"
            class="border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-semibold transition duration-200 bg-white">
        
        <button class="px-5 py-2.5 rounded-xl font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs transition duration-200">Saring</button>
        <a href="{{ route('admin.orders.index') }}" class="px-5 py-2.5 rounded-xl font-bold bg-slate-50 text-slate-400 hover:bg-slate-100 text-xs transition duration-200">Reset</a>
    </form>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
    <table class="premium-table">
        <thead>
            <tr>
                <th class="text-left">No. Pesanan</th>
                <th class="text-left">Pelanggan</th>
                <th class="text-left">Total Pembayaran</th>
                <th class="text-left">Status Bayar</th>
                <th class="text-left">Status Kirim</th>
                <th class="text-left">Tanggal Masuk</th>
                <th class="text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td class="font-mono font-bold text-xs" style="color:var(--primary)">{{ $order->order_number }}</td>
                <td>
                    <div class="font-bold text-slate-700">{{ $order->customer_name }}</div>
                    <div class="text-[10px] font-semibold text-slate-400 mt-0.5 tracking-wide">{{ $order->customer_phone }}</div>
                </td>
                <td class="font-extrabold" style="color:var(--gold-dark)">Rp {{ number_format($order->total_amount,0,',','.') }}</td>
                <td>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                        {{ $order->payment_status === 'confirmed' ? 'bg-emerald-50 text-emerald-800 border border-emerald-100' : ($order->payment_status === 'failed' ? 'bg-rose-50 text-rose-800 border border-rose-100' : 'bg-amber-50 text-amber-800 border border-amber-100') }}">
                        {{ $order->payment_status_label }}
                    </span>
                </td>
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
                <td class="text-slate-400 text-xs font-semibold">{{ $order->created_at->format('d M Y H:i') }}</td>
                <td>
                    <a href="{{ route('admin.orders.show', $order) }}" class="px-4 py-2 rounded-lg font-bold text-xs bg-slate-100 text-slate-600 hover:bg-slate-200 transition">Detail</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="py-16 text-center text-slate-400 font-medium">Belum ada pesanan masuk.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($orders->hasPages())
    <div class="p-5 border-t border-slate-100">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
