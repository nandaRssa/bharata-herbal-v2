@extends('layouts.admin')
@section('title','Edit Produk')
@section('page-title','Edit Produk')
@section('page-subtitle','Perbarui informasi produk: ' . $product->name)

@section('content')
<div class="max-w-3xl">
    <form id="update-product-form" method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
        @csrf 
        @method('PUT')

        @if($errors->any())
        <div class="bg-rose-50 border border-rose-200 rounded-2xl p-4 mb-6 shadow-sm">
            <ul class="text-rose-700 text-xs font-semibold list-disc pl-5 space-y-1">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
        @endif

        <!-- Informasi Dasar -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 mb-6">
            <h3 class="font-bold text-lg font-serif-elegant border-b border-slate-100 pb-3 mb-5" style="color: var(--primary);">Informasi Dasar</h3>
            <div class="space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Nama Produk *</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                            class="w-full border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-medium transition duration-200">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Status Produk</label>
                        <select name="is_active" class="w-full border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-medium transition duration-200">
                            <option value="1" {{ old('is_active', $product->is_active) ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ !old('is_active', $product->is_active) ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Harga Jual (Rp) *</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-bold transition duration-200">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Sisa Stok *</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-bold transition duration-200">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Deskripsi Lengkap</label>
                        <textarea name="description" rows="4" class="w-full border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-medium transition duration-200">{{ old('description', $product->description) }}</textarea>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Komposisi Bahan</label>
                        <textarea name="ingredients" rows="2" class="w-full border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-medium transition duration-200">{{ old('ingredients', $product->ingredients) }}</textarea>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Cara Pemakaian</label>
                        <textarea name="usage" rows="2" class="w-full border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-medium transition duration-200">{{ old('usage', $product->usage) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Diskon Produk -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 mb-6">
            <h3 class="font-bold text-lg font-serif-elegant border-b border-slate-100 pb-3 mb-5" style="color: var(--primary);">Diskon Produk</h3>
            <div class="space-y-5">
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_discount_active" value="1" id="is_discount_active" {{ old('is_discount_active', $product->is_discount_active) ? 'checked' : '' }}
                        class="w-5 h-5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    <label for="is_discount_active" class="text-sm font-bold text-slate-600">Aktifkan Diskon</label>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Tipe Diskon</label>
                        <select name="discount_type" class="w-full border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-medium transition duration-200">
                            <option value="">Pilih Tipe</option>
                            <option value="percentage" {{ old('discount_type', $product->discount_type) == 'percentage' ? 'selected' : '' }}>Persen (%)</option>
                            <option value="fixed" {{ old('discount_type', $product->discount_type) == 'fixed' ? 'selected' : '' }}>Nominal (Rp)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Nilai Diskon</label>
                        <input type="number" name="discount_value" value="{{ old('discount_value', $product->discount_value) }}" min="0"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-bold transition duration-200">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Mulai</label>
                        <input type="datetime-local" name="discount_start_at" value="{{ old('discount_start_at', $product->discount_start_at ? $product->discount_start_at->format('Y-m-d\TH:i') : '') }}"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-medium transition duration-200">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Berakhir</label>
                        <input type="datetime-local" name="discount_end_at" value="{{ old('discount_end_at', $product->discount_end_at ? $product->discount_end_at->format('Y-m-d\TH:i') : '') }}"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-medium transition duration-200">
                    </div>
                </div>
                <input type="hidden" name="timezone_offset" id="timezone_offset" value="0">
            </div>
        </div>

        <script>
        (function(){
            var el=document.getElementById('timezone_offset'); if(el) el.value=new Date().getTimezoneOffset();
            var typeEl = document.querySelector('[name="discount_type"]');
            var valEl = document.querySelector('[name="discount_value"]');
            var priceEl = document.querySelector('[name="price"]');
            function validateDiscount() {
                if (!typeEl || !valEl || !valEl.value) return;
                var val = parseInt(valEl.value);
                var price = parseInt(priceEl ? priceEl.value : 0);
                if (typeEl.value === 'percentage' && val > 100) { valEl.setCustomValidity('Diskon persen tidak boleh melebihi 100%.'); }
                else if (typeEl.value === 'fixed' && val > price) { valEl.setCustomValidity('Diskon nominal tidak boleh melebihi harga asli produk.'); }
                else { valEl.setCustomValidity(''); }
            }
            if (typeEl) { typeEl.addEventListener('change', validateDiscount); }
            if (valEl) { valEl.addEventListener('input', validateDiscount); }
            if (priceEl) { priceEl.addEventListener('input', validateDiscount); }
            validateDiscount();
        })();
        </script>

        <!-- Manfaat Dinamis -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 mb-6"
             x-data="{ benefits: {{ json_encode(old('benefits', $product->benefits ?? [''])) }} }">
            <h3 class="font-bold text-lg font-serif-elegant border-b border-slate-100 pb-3 mb-5" style="color: var(--primary);">Manfaat Utama Produk</h3>
            <template x-for="(b, i) in benefits" :key="i">
                <div class="flex gap-3 mb-3">
                    <input type="text" :name="'benefits[' + i + ']'" x-model="benefits[i]" placeholder="Contoh: Mengobati nyeri sendi..."
                        class="flex-1 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-medium">
                    <button type="button" @click="benefits.splice(i,1)" class="px-3.5 py-3 rounded-xl font-bold bg-rose-500 hover:bg-rose-600 text-white transition text-xs shadow-sm" x-show="benefits.length > 1">✕</button>
                </div>
            </template>
            <button type="button" @click="benefits.push('')" class="text-xs font-bold uppercase tracking-wider transition hover:opacity-85 mt-2 block" style="color: var(--primary);">
                ➕ Tambah Baris Manfaat
            </button>
        </div>

        <!-- Foto Existing -->
        @if($product->images->isNotEmpty())
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 mb-6">
            <h3 class="font-bold text-lg font-serif-elegant border-b border-slate-100 pb-3 mb-5" style="color: var(--primary);">Foto Saat Ini</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                @foreach($product->images as $img)
                <div class="relative group aspect-square rounded-2xl overflow-hidden border border-slate-100 bg-slate-50">
                    <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-full object-cover">
                    @if($img->is_primary)
                    <span class="absolute top-2 left-2 text-[8px] tracking-widest uppercase px-2 py-0.5 rounded-full font-bold text-white shadow-sm" style="background: var(--gold);">Utama</span>
                    @endif
                    <!-- valid HTML5 form submit button pointing to the form defined outside -->
                    <button type="submit" form="delete-image-form-{{ $img->id }}" class="absolute top-2 right-2 w-6 h-6 bg-rose-500 text-white rounded-full text-xs font-bold shadow-md hover:bg-rose-600 transition flex items-center justify-center">✕</button>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Upload Foto Baru -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 mb-8">
            <h3 class="font-bold text-lg font-serif-elegant border-b border-slate-100 pb-3 mb-4" style="color: var(--primary);">Tambah Foto Baru (Maks. 5)</h3>
            <input type="file" name="images[]" multiple accept="image/*"
                class="w-full border border-slate-200 rounded-xl px-4 py-3.5 text-xs text-slate-400 font-bold bg-slate-50 cursor-pointer">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wide mt-3 leading-relaxed">
                format: JPG, PNG. Maksimal 2MB per file.
            </p>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="px-8 py-3.5 rounded-xl font-bold text-white text-sm transition duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5" style="background: var(--primary);">
                💾 Simpan Perubahan Produk
            </button>
            <a href="{{ route('admin.products.index') }}" class="px-8 py-3.5 rounded-xl border border-slate-200 font-bold text-sm text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition duration-200 text-center">
                Batal
            </a>
        </div>
    </form>
</div>

<!-- Forms for deleting product images defined outside to prevent HTML nesting bugs -->
@if($product->images->isNotEmpty())
    @foreach($product->images as $img)
    <form id="delete-image-form-{{ $img->id }}" method="POST" action="{{ route('admin.products.image.delete', $img) }}" class="hidden" onsubmit="return confirm('Hapus foto ini?')">
        @csrf
        @method('DELETE')
    </form>
    @endforeach
@endif
@endsection
