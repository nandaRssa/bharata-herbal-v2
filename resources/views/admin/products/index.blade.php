@extends('layouts.admin')
@section('title','Manajemen Produk')
@section('page-title','Manajemen Produk')
@section('page-subtitle','Kelola semua produk herbal')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <form method="GET" class="flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk..."
            class="border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-medium w-64 transition duration-200">
        <button class="px-5 py-2.5 rounded-xl font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs transition duration-200">Cari</button>
    </form>
    <a href="{{ route('admin.products.create') }}" class="px-5 py-3 rounded-xl font-bold text-white text-xs transition duration-200 shadow-sm hover:shadow" style="background: var(--primary);">
        ➕ Tambah Produk Baru
    </a>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
    <table class="premium-table">
        <thead>
            <tr>
                <th class="text-left">Produk</th>
                <th class="text-left">Harga Jual</th>
                <th class="text-left">Diskon</th>
                <th class="text-left">Sisa Stok</th>
                <th class="text-left">Status</th>
                <th class="text-left">Aksi Manajemen</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl overflow-hidden bg-slate-50 flex-shrink-0 border border-slate-100">
                            @if($product->images->isNotEmpty())
                            <img src="{{ asset('storage/' . ($product->images->where('is_primary',true)->first() ?? $product->images->first())->image_path) }}" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-2xl opacity-20">🌿</div>
                            @endif
                        </div>
                        <div>
                            <p class="font-bold text-slate-800">{{ $product->name }}</p>
                            <p class="text-[10px] font-semibold text-slate-400 mt-0.5 tracking-wide">{{ $product->slug }}</p>
                        </div>
                    </div>
                </td>
                <td class="font-extrabold" style="color: var(--gold-dark);">Rp {{ number_format($product->price,0,',','.') }}</td>
                <td>
                    @if($product->is_discount_active && $product->discounted_price)
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-100">
                        -{{ $product->discount_percentage }}%
                    </span>
                    @else
                    <span class="text-[10px] text-slate-300 font-semibold">—</span>
                    @endif
                </td>
                <td>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold
                        @if($product->stock < 10) bg-rose-50 text-rose-800 border border-rose-100
                        @elseif($product->stock < 20) bg-amber-50 text-amber-800 border border-amber-100
                        @else bg-emerald-50 text-emerald-800 border border-emerald-100
                        @endif">
                        <span class="w-1.5 h-1.5 rounded-full 
                            @if($product->stock < 10) bg-rose-500
                            @elseif($product->stock < 20) bg-amber-500
                            @else bg-emerald-500
                            @endif"></span>
                        {{ $product->stock }} unit
                    </span>
                </td>
                <td>
                    <form method="POST" action="{{ route('admin.products.toggle', $product) }}">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider cursor-pointer border-none transition hover:opacity-80
                            {{ $product->is_active ? 'bg-emerald-50 text-emerald-800 border border-emerald-100' : 'bg-rose-50 text-rose-800 border border-rose-100' }}">
                            {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                        </button>
                    </form>
                </td>
                <td>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.products.edit', $product) }}" class="px-4 py-2 rounded-lg font-bold text-xs bg-slate-100 text-slate-600 hover:bg-slate-200 transition">Edit</a>
                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Hapus produk ini?')">
                            @csrf @method('DELETE')
                            <button class="px-4 py-2 rounded-lg font-bold text-xs bg-rose-500 text-white hover:bg-rose-600 transition shadow-sm">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="py-16 text-center text-slate-400 font-medium">
                    Belum ada produk terdaftar. <a href="{{ route('admin.products.create') }}" style="color:var(--primary)" class="font-bold underline">Tambah produk sekarang</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($products->hasPages())
    <div class="p-5 border-t border-slate-100">{{ $products->links() }}</div>
    @endif
</div>
@endsection
