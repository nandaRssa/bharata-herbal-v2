@extends('layouts.admin')
@section('title','Tambah Produk')
@section('page-title','Tambah Produk Baru')
@section('page-subtitle','Isi form di bawah untuk menambahkan produk')

@section('content')
<div class="max-w-3xl">
<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
    @csrf

    @if($errors->any())
    <div class="bg-rose-50 border border-rose-200 rounded-2xl p-4 mb-6 shadow-sm">
        <ul class="text-rose-700 text-xs font-semibold list-disc pl-5 space-y-1">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 mb-6">
        <h3 class="font-bold text-lg font-serif-elegant border-b border-slate-100 pb-3 mb-5" style="color: var(--primary);">Informasi Dasar</h3>
        <div class="space-y-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Nama Produk *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-medium transition duration-200">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Status Produk</label>
                    <select name="is_active" class="w-full border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-medium transition duration-200">
                        <option value="1" selected>Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Harga Jual (Rp) *</label>
                    <input type="number" name="price" value="{{ old('price') }}" required min="0"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-bold transition duration-200">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Sisa Stok Awal *</label>
                    <input type="number" name="stock" value="{{ old('stock',0) }}" required min="0"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-bold transition duration-200">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Deskripsi Lengkap</label>
                    <textarea name="description" rows="4" class="w-full border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-medium transition duration-200">{{ old('description') }}</textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Komposisi Bahan</label>
                    <textarea name="ingredients" rows="2" class="w-full border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-medium transition duration-200">{{ old('ingredients') }}</textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Cara Pemakaian</label>
                    <textarea name="usage" rows="2" class="w-full border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-medium transition duration-200">{{ old('usage') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Manfaat Dinamis -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 mb-6" x-data="{ benefits: {{ json_encode(old('benefits', [''])) }} }">
        <h3 class="font-bold text-lg font-serif-elegant border-b border-slate-100 pb-3 mb-5" style="color: var(--primary);">Manfaat Utama Produk</h3>
        <template x-for="(b, i) in benefits" :key="i">
            <div class="flex gap-3 mb-3">
                <input type="text" :name="'benefits[' + i + ']'" x-model="benefits[i]" placeholder="Contoh: Meredakan sakit kepala, menetralkan asam lambung..."
                    class="flex-1 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-medium">
                <button type="button" @click="benefits.splice(i,1)" class="px-3.5 py-3 rounded-xl font-bold bg-rose-500 hover:bg-rose-600 text-white transition text-xs shadow-sm" x-show="benefits.length > 1">✕</button>
            </div>
        </template>
        <button type="button" @click="benefits.push('')" class="text-xs font-bold uppercase tracking-wider transition hover:opacity-85 mt-2 block" style="color: var(--primary);">
            ➕ Tambah Baris Manfaat
        </button>
    </div>

    <!-- Upload Foto -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 mb-8">
        <h3 class="font-bold text-lg font-serif-elegant border-b border-slate-100 pb-3 mb-4" style="color: var(--primary);">Unggah Foto Produk (Maks. 5)</h3>
        <input type="file" name="images[]" multiple accept="image/*" id="images"
            class="w-full border border-slate-200 rounded-xl px-4 py-3.5 text-xs text-slate-400 font-bold bg-slate-50 cursor-pointer">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wide mt-3 leading-relaxed">
            Foto pertama otomatis dijadikan foto utama. format: JPG, PNG. Maksimal 2MB per file.
        </p>
    </div>

    <div class="flex gap-4">
        <button type="submit" class="px-8 py-3.5 rounded-xl font-bold text-white text-sm transition duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5" style="background: var(--primary);">
            💾 Simpan Produk Baru
        </button>
        <a href="{{ route('admin.products.index') }}" class="px-8 py-3.5 rounded-xl border border-slate-200 font-bold text-sm text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition duration-200 text-center">
            Batal
        </a>
    </div>
</form>
</div>
@endsection
