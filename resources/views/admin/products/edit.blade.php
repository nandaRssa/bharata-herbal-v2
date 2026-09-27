@extends('layouts.admin')
@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')
@section('page-subtitle', 'Perbarui informasi produk: ' . $product->name)

@push('styles')
@include('admin.partials.form-styles')
@endpush

@section('content')
<div class="admin-form-page">
<div class="admin-form-container">

    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Errors --}}
        @if($errors->any())
        <div class="form-error fade-up fade-up-1">
            <ul>
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
        @endif

        {{-- ═══ INFORMASI DASAR ═════════════════════════════ --}}
        <div class="form-card fade-up fade-up-1">
            <div class="form-card-header">
                <h3>Informasi Dasar</h3>
            </div>
            <div class="form-grid">
                <div class="full-col form-group">
                    <label>Nama Produk <span class="required">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required placeholder="Masukkan nama produk" class="form-control">
                </div>

                <div class="full-col form-group">
                    <label>Status Produk</label>
                    <select name="is_active" class="form-control">
                        <option value="1" {{ old('is_active', $product->is_active) ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ !old('is_active', $product->is_active) ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Harga Jual (Rp) <span class="required">*</span></label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0" step="1" inputmode="numeric" pattern="[0-9]+" placeholder="0" class="form-control font-bold">
                </div>

                <div class="form-group">
                    <label>Sisa Stok <span class="required">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0" step="1" inputmode="numeric" pattern="[0-9]+" placeholder="0" class="form-control font-bold">
                </div>

                <div class="full-col form-group">
                    <label>Deskripsi Lengkap</label>
                    <textarea name="description" rows="4" class="form-control" placeholder="Tulis deskripsi produk secara lengkap...">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="full-col form-group">
                    <label>Komposisi Bahan</label>
                    <textarea name="ingredients" rows="3" class="form-control" placeholder="Tulis komposisi bahan produk...">{{ old('ingredients', $product->ingredients) }}</textarea>
                </div>

                <div class="full-col form-group">
                    <label>Cara Pemakaian</label>
                    <textarea name="usage" rows="3" class="form-control" placeholder="Tulis cara pemakaian produk...">{{ old('usage', $product->usage) }}</textarea>
                </div>
            </div>
        </div>

        {{-- ═══ DISKON PRODUK ═══════════════════════════════ --}}
        <div class="form-card fade-up fade-up-2"
             x-data="{ discountEnabled: {{ old('is_discount_active', $product->is_discount_active) ? 'true' : 'false' }} }">
            <div class="form-card-header">
                <h3>Diskon Produk</h3>
            </div>

            <div class="toggle-group" style="margin-bottom:20px;">
                <input type="checkbox" name="is_discount_active" value="1" id="is_discount_active"
                       {{ old('is_discount_active', $product->is_discount_active) ? 'checked' : '' }} x-model="discountEnabled">
                <label for="is_discount_active">Aktifkan Diskon</label>
            </div>

            <div class="discount-fields" :class="discountEnabled ? '' : 'disabled'">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Tipe Diskon</label>
                        <select name="discount_type" :disabled="!discountEnabled" class="form-control">
                            <option value="">Pilih Tipe</option>
                            <option value="percentage" {{ old('discount_type', $product->discount_type) == 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                            <option value="fixed" {{ old('discount_type', $product->discount_type) == 'fixed' ? 'selected' : '' }}>Nominal (Rp)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nilai Diskon</label>
                        <input type="number" name="discount_value" value="{{ old('discount_value', $product->discount_value) }}" min="0" step="1"
                               inputmode="numeric" pattern="[0-9]+" :disabled="!discountEnabled" placeholder="0" class="form-control font-bold">
                        <div id="discount-warning" class="form-warning"><span id="discount-warning-text"></span></div>
                    </div>
                    <div class="form-group">
                        <label>Mulai</label>
                        <input type="datetime-local" name="discount_start_at"
                               value="{{ old('discount_start_at', $product->discount_start_at ? $product->discount_start_at->format('Y-m-d\TH:i') : '') }}"
                               :disabled="!discountEnabled" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Berakhir</label>
                        <input type="datetime-local" name="discount_end_at"
                               value="{{ old('discount_end_at', $product->discount_end_at ? $product->discount_end_at->format('Y-m-d\TH:i') : '') }}"
                               :disabled="!discountEnabled" class="form-control">
                    </div>
                </div>
            </div>
            <input type="hidden" name="timezone_offset" id="timezone_offset" value="0">
        </div>

        {{-- ═══ MANFAAT UTAMA ════════════════════════════════ --}}
        <div class="form-card fade-up fade-up-3" id="benefits-section">
            <div class="form-card-header">
                <h3>Manfaat Utama Produk</h3>
            </div>

            <div class="benefits-container" id="benefits-list">
                @php $benefitsData = old('benefits', $product->benefits ?? []); @endphp
                @foreach(array_filter($benefitsData) as $b)
                <span class="benefit-chip">
                    <span>{{ $b }}</span>
                    <button type="button" class="remove" onclick="this.parentElement.remove(); reindexBenefits();">&times;</button>
                    <input type="hidden" name="benefits[]" value="{{ $b }}">
                </span>
                @endforeach
            </div>

            <div style="display:flex;gap:10px;margin-top:8px;">
                <input type="text" id="benefit-input" placeholder="Contoh: Meredakan sakit kepala..."
                       class="form-control" style="flex:1;max-width:400px;"
                       onkeydown="if(event.key==='Enter'){ event.preventDefault(); addBenefit(); }">
                <button type="button" class="benefit-add-btn" onclick="addBenefit()">
                    <i class="fas fa-plus" style="font-size:0.7rem;"></i> Tambah
                </button>
            </div>

            <input type="hidden" name="benefits[]" value="" id="benefit-fallback">
        </div>

        @push('scripts')
        <script>
        function addBenefit() {
            var inp = document.getElementById('benefit-input');
            var val = inp.value.trim();
            if (!val) return;
            var list = document.getElementById('benefits-list');
            var chip = document.createElement('span');
            chip.className = 'benefit-chip';
            chip.innerHTML = '<span>' + val.replace(/</g,'&lt;').replace(/>/g,'&gt;') + '</span>'
                + '<button type=\"button\" class=\"remove\" onclick=\"this.parentElement.remove(); reindexBenefits();\">&times;</button>'
                + '<input type=\"hidden\" name=\"benefits[]\" value=\"' + val.replace(/"/g,'&quot;') + '\">';
            list.appendChild(chip);
            inp.value = '';
            inp.focus();
            cleanFallback();
        }
        function reindexBenefits() {
            cleanFallback();
        }
        function cleanFallback() {
            var list = document.getElementById('benefits-list');
            if (!list) return;
            var fb = document.getElementById('benefit-fallback');
            if (fb) fb.disabled = list.children.length > 0;
        }
        cleanFallback();
        </script>
        @endpush

        {{-- ═══ FOTO SAAT INI ═══════════════════════════════ --}}
        @if($product->images->isNotEmpty())
        <div class="form-card fade-up fade-up-4">
            <div class="form-card-header">
                <h3>Foto Saat Ini</h3>
            </div>
            <div class="existing-photos">
                @foreach($product->images as $img)
                <div class="existing-photo-item">
                    <img src="{{ asset('storage/' . $img->image_path) }}" alt="Foto produk">
                    @if($img->is_primary)
                    <span class="badge-primary">Utama</span>
                    @endif
                    <button type="button" class="delete-btn" title="Hapus foto"
                            onclick="(function(btn){ Alpine.store('modal').confirm('Hapus foto ini? Foto akan dihapus setelah menyimpan perubahan.').then(function(ok){ if(!ok) return; btn.closest('.existing-photo-item').classList.add('marked-delete'); var h=document.createElement('input'); h.type='hidden'; h.name='deleted_images[]'; h.value='{{ $img->id }}'; btn.closest('form').appendChild(h); }); })(this)">
                        &times;
                    </button>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ═══ TAMBAH FOTO BARU ════════════════════════════ --}}
        <div class="form-card fade-up fade-up-4">
            <div class="form-card-header">
                <h3>Tambah Foto Baru <span style="font-family:'Inter',sans-serif;font-weight:400;font-size:0.85rem;color:#8A9A92;">(maks. 5)</span></h3>
            </div>
            <label class="upload-area" style="display:block;">
                <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                <p class="upload-text">Klik untuk pilih foto</p>
                <p class="upload-hint">JPG, PNG &bull; maks. 2MB per file</p>
                <input type="file" name="images[]" multiple accept="image/*" style="display:none;" onchange="previewImages(this)">
            </label>
            <div id="image-previews" class="upload-preview"></div>
        </div>

        {{-- ═══ TOMBOL AKSI ═════════════════════════════════ --}}
        <div class="form-actions fade-up fade-up-5">
            <button type="submit" class="btn-save">
                <i class="fas fa-check"></i> Perbarui Produk
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn-cancel">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>

</div>
</div>
@endsection

@push('scripts')
<script>
function previewImages(input) {
    var container = document.getElementById('image-previews');
    if (!container) return;
    container.innerHTML = '';
    if (input.files) {
        Array.from(input.files).forEach(function(file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var div = document.createElement('div');
                div.className = 'preview-item';
                div.innerHTML = '<img src="' + e.target.result + '" alt="Preview">' +
                                '<button type="button" class="remove-img" onclick="this.parentElement.remove()">&times;</button>';
                container.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }
}
(function() {
    var tzEl = document.getElementById('timezone_offset');
    if (tzEl) tzEl.value = new Date().getTimezoneOffset();

    var typeEl = document.querySelector('[name="discount_type"]');
    var valEl = document.querySelector('[name="discount_value"]');
    var priceEl = document.querySelector('[name="price"]');
    var warnEl = document.getElementById('discount-warning');
    var warnText = document.getElementById('discount-warning-text');

    function fmt(n) { return 'Rp ' + parseInt(n).toLocaleString('id-ID'); }

    function validate() {
        if (!typeEl || !valEl || !valEl.value) { if (warnEl) warnEl.classList.remove('show'); return; }
        var val = parseInt(valEl.value);
        var price = parseInt(priceEl ? priceEl.value : 0);
        if (typeEl.value === 'percentage' && val > 100) {
            valEl.setCustomValidity('Diskon persen tidak boleh melebihi 100%.');
            if (warnEl) { warnEl.classList.add('show'); warnEl.querySelector('span').textContent = 'Diskon persen tidak boleh melebihi 100%'; }
        } else if (typeEl.value === 'fixed' && val > price) {
            valEl.setCustomValidity('Diskon nominal tidak boleh melebihi harga asli.');
            if (warnEl) { warnEl.classList.add('show'); warnEl.querySelector('span').textContent = 'Diskon nominal tidak boleh melebihi ' + fmt(price); }
        } else {
            valEl.setCustomValidity('');
            if (warnEl) warnEl.classList.remove('show');
        }
    }
    if (typeEl) typeEl.addEventListener('change', validate);
    if (valEl) valEl.addEventListener('input', validate);
    if (priceEl) priceEl.addEventListener('input', validate);
    validate();
})();
</script>
@endpush
