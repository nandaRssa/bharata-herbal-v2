@extends('layouts.admin')
@section('title', isset($review) ? 'Edit Ulasan' : 'Tambah Ulasan')
@section('page-title', isset($review) ? 'Edit Ulasan' : 'Tambah Ulasan Manual')
@section('page-subtitle', isset($review) ? 'Ubah data ulasan produk' : 'Tambahkan ulasan dari admin')

@push('styles')
@include('admin.partials.form-styles')
<style>
/* Rating stars inline override */
.rating-star {
    font-size: 1.8rem;
    cursor: pointer;
    transition: all 0.2s ease;
    background: none;
    border: none;
    padding: 0 2px;
    line-height: 1;
}
.rating-star:hover {
    transform: scale(1.2);
}
.rating-hint {
    font-family: 'Inter', sans-serif;
    font-size: 0.8rem;
    color: #8A9A92;
    margin-top: 4px;
}
</style>
@endpush

@section('content')
<div class="admin-form-page">
<div class="admin-form-container">

    <form method="POST"
          action="{{ isset($review) ? route('admin.reviews.update', $review) : route('admin.reviews.store') }}">
        @csrf
        @if(isset($review)) @method('PUT') @endif

        {{-- Errors --}}
        @if($errors->any())
        <div class="form-error fade-up fade-up-1">
            <ul>
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
        @endif

        {{-- ═══ DATA ULASAN ═════════════════════════════════ --}}
        <div class="form-card fade-up fade-up-1">
            <div class="form-card-header">
                <h3>Data Ulasan</h3>
            </div>
            <div class="form-grid">
                <div class="full-col form-group">
                    <label>Produk <span class="required">*</span></label>
                    <select name="product_id" required class="form-control">
                        <option value="">- Pilih Produk -</option>
                        @foreach($products as $p)
                        <option value="{{ $p->id }}" {{ old('product_id', $review->product_id ?? '') == $p->id ? 'selected' : '' }}>
                            {{ $p->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="full-col form-group">
                    <label>Nama Pelanggan <span class="required">*</span></label>
                    <input type="text" name="customer_name" value="{{ old('customer_name', $review->customer_name ?? '') }}" required
                           placeholder="Masukkan nama pelanggan" class="form-control">
                </div>

                <div class="full-col form-group" x-data="{ rating: {{ old('rating', $review->rating ?? 5) }} }">
                    <label>Rating <span class="required">*</span></label>
                    <input type="hidden" name="rating" x-model="rating">
                    <div style="display:flex;gap:4px;margin-top:4px;">
                        @for($s = 1; $s <= 5; $s++)
                        <button type="button" @click="rating = {{ $s }}"
                                class="rating-star"
                                :style="rating >= {{ $s }} ? 'color:#C9A227;' : 'color:#E0E6E2;'">
                            <i class="fas fa-star"></i>
                        </button>
                        @endfor
                    </div>
                    <div class="rating-hint" x-text="`Rating dipilih: ${rating} bintang`"></div>
                </div>

                <div class="full-col form-group">
                    <label>Komentar</label>
                    <textarea name="comment" rows="3" class="form-control" placeholder="Tulis komentar ulasan...">{{ old('comment', $review->comment ?? '') }}</textarea>
                </div>

                <div class="full-col form-group">
                    <label>Balasan Admin</label>
                    <textarea name="admin_reply" rows="2" class="form-control" placeholder="Tulis balasan admin...">{{ old('admin_reply', $review->admin_reply ?? '') }}</textarea>
                </div>

                <div class="full-col">
                    <div class="toggle-group">
                        <input type="hidden" name="is_visible" value="0">
                        <input type="checkbox" name="is_visible" value="1" id="is_visible"
                               {{ old('is_visible', $review->is_visible ?? true) ? 'checked' : '' }}>
                        <label for="is_visible">Tampilkan ulasan di halaman produk</label>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══ TOMBOL AKSI ═════════════════════════════════ --}}
        <div class="form-actions fade-up fade-up-2">
            <button type="submit" class="btn-save">
                <i class="fas {{ isset($review) ? 'fa-check' : 'fa-plus' }}"></i>
                {{ isset($review) ? 'Simpan Perubahan' : 'Tambah Ulasan' }}
            </button>
            <a href="{{ route('admin.reviews.index') }}" class="btn-cancel">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>

</div>
</div>
@endsection
