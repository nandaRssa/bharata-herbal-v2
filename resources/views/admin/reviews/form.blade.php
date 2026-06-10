@extends('layouts.admin')
@section('title', isset($review) ? 'Edit Ulasan' : 'Tambah Ulasan')
@section('page-title', isset($review) ? 'Edit Ulasan' : 'Tambah Ulasan Manual')
@section('page-subtitle', isset($review) ? 'Ubah data ulasan produk' : 'Tambahkan ulasan dari admin')

@section('content')
<div class="max-w-2xl">
    <form method="POST"
          action="{{ isset($review) ? route('admin.reviews.update', $review) : route('admin.reviews.store') }}">
        @csrf
        @if(isset($review)) @method('PUT') @endif

        @if($errors->any())
        <div class="bg-rose-50 border border-rose-200 rounded-2xl p-4 mb-6">
            <ul class="text-rose-700 text-xs font-semibold list-disc pl-5 space-y-1">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 space-y-5">
            <h3 class="font-bold text-base border-b border-slate-100 pb-3" style="color:var(--primary);">Data Ulasan</h3>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Produk *</label>
                <select name="product_id" required
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30">
                    <option value="">— Pilih Produk —</option>
                    @foreach($products as $p)
                    <option value="{{ $p->id }}" {{ old('product_id', $review->product_id ?? '') == $p->id ? 'selected' : '' }}>
                        {{ $p->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Nama Pelanggan *</label>
                <input type="text" name="customer_name" value="{{ old('customer_name', $review->customer_name ?? '') }}" required
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30">
            </div>

            <div x-data="{ rating: {{ old('rating', $review->rating ?? 5) }} }">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Rating *</label>
                <input type="hidden" name="rating" x-model="rating">
                <div class="flex gap-1">
                    @for($s = 1; $s <= 5; $s++)
                    <button type="button" @click="rating = {{ $s }}"
                            class="text-3xl transition"
                            :class="rating >= {{ $s }} ? 'text-amber-400' : 'text-gray-200'">★</button>
                    @endfor
                </div>
                <p class="text-xs text-slate-400 mt-1" x-text="`Rating dipilih: ${rating} bintang`"></p>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Komentar</label>
                <textarea name="comment" rows="3"
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 resize-none">{{ old('comment', $review->comment ?? '') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Balasan Admin</label>
                <textarea name="admin_reply" rows="2"
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 resize-none">{{ old('admin_reply', $review->admin_reply ?? '') }}</textarea>
            </div>

            <div class="flex items-center gap-3">
                <input type="hidden" name="is_visible" value="0">
                <input type="checkbox" name="is_visible" value="1" id="is_visible"
                    {{ old('is_visible', $review->is_visible ?? true) ? 'checked' : '' }}
                    class="w-4 h-4 rounded accent-emerald-600">
                <label for="is_visible" class="text-sm font-semibold text-slate-600">Tampilkan ulasan di halaman produk</label>
            </div>
        </div>

        <div class="flex gap-4 mt-6">
            <button type="submit"
                class="px-8 py-3.5 rounded-xl font-bold text-white text-sm transition shadow-md hover:opacity-90"
                style="background:var(--primary);">
                {{ isset($review) ? '💾 Simpan Perubahan' : '+ Tambah Ulasan' }}
            </button>
            <a href="{{ route('admin.reviews.index') }}"
               class="px-8 py-3.5 rounded-xl border border-slate-200 font-bold text-sm text-slate-500 hover:bg-slate-50 transition text-center">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
