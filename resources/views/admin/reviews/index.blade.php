@extends('layouts.admin')
@section('title','Manajemen Ulasan')
@section('page-title','Ulasan Produk')
@section('page-subtitle','Kelola semua ulasan dari pembeli')

@section('content')
<div class="flex items-center justify-between mb-6">
    <a href="{{ route('admin.reviews.create') }}"
       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-sm text-white transition shadow-sm hover:opacity-90"
       style="background: var(--primary);">
        + Tambah Ulasan Manual
    </a>
</div>

{{-- Search --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 mb-6">
    <form method="GET" class="flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pelanggan atau produk..."
            class="flex-1 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30">
        <button class="px-5 py-2.5 rounded-xl font-bold text-sm bg-slate-100 text-slate-600 hover:bg-slate-200 transition">Cari</button>
        <a href="{{ route('admin.reviews.index') }}" class="px-5 py-2.5 rounded-xl font-bold text-sm bg-slate-50 text-slate-400 hover:bg-slate-100 transition">Reset</a>
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <table class="premium-table">
        <thead>
            <tr>
                <th>Pelanggan</th>
                <th>Produk</th>
                <th>Rating</th>
                <th>Komentar</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reviews as $review)
            <tr>
                <td class="font-semibold text-slate-700">{{ $review->customer_name }}</td>
                <td class="text-slate-600 text-sm">{{ $review->product?->name ?? '—' }}</td>
                <td>
                    <div class="flex gap-0.5">
                        @for($i = 1; $i <= 5; $i++)
                        <span class="text-base {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-200' }}">★</span>
                        @endfor
                    </div>
                </td>
                <td class="text-slate-500 text-sm max-w-xs truncate">{{ $review->comment ?: '—' }}</td>
                <td class="text-slate-400 text-xs">{{ $review->created_at->format('d M Y') }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.reviews.toggle', $review) }}">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider transition
                            {{ $review->is_visible
                                ? 'bg-emerald-50 text-emerald-800 border border-emerald-200 hover:bg-emerald-100'
                                : 'bg-slate-100 text-slate-500 border border-slate-200 hover:bg-slate-200' }}">
                            {{ $review->is_visible ? 'Tampil' : 'Disembunyikan' }}
                        </button>
                    </form>
                </td>
                <td>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.reviews.edit', $review) }}"
                            class="px-3 py-1.5 rounded-lg text-xs font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 transition">Edit</a>
                        <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}"
                              onsubmit="return confirm('Hapus ulasan ini?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="px-3 py-1.5 rounded-lg text-xs font-bold bg-rose-50 text-rose-600 hover:bg-rose-100 transition">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="py-16 text-center text-slate-400">Belum ada ulasan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($reviews->hasPages())
    <div class="p-5 border-t border-slate-100">{{ $reviews->links() }}</div>
    @endif
</div>
@endsection
