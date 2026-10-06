@extends('layouts.public')
@section('title', $product->name)

@php
    $formattedWa = $settings->wa_number ?? '6282244664526';
    if (str_starts_with($formattedWa, '0')) {
        $formattedWa = '62' . substr($formattedWa, 1);
    }
    $formattedWa = preg_replace('/[^0-9]/', '', $formattedWa);
    $displayPrice = $product->formatted_discounted_price ?? $product->formatted_price;
    $waMessage = rawurlencode("Halo Bharata Herbal ID, saya tertarik dengan produk " . $product->name . " (Harga: " . $displayPrice . "). Apakah produk ini ready stock? Saya ingin berkonsultasi lebih lanjut.");
    $primaryImg = $product->images->where('is_primary', true)->first() ?? $product->images->first();
@endphp

@push('styles')
<style>
.gold-shimmer {
    background: linear-gradient(90deg, #0D2618 0%, #0D2618 30%, #0D2618 50%, #0D2618 70%, #0D2618 100%);
    background-size: 200% auto;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: shimmer 4s ease-in-out infinite;
}
@keyframes shimmer {
    0%, 100% { background-position: 0% center; }
    50% { background-position: 100% center; }
}
.detail-rating {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
}
.detail-rating .stars { display: flex; align-items: center; gap: 2px; }
.detail-rating .stars i { font-size: 0.85rem; }
.detail-rating .stars .fa-star,
.detail-rating .stars .fa-star-half-alt { color: #C9A227; }
.detail-rating .stars .far.fa-star { color: #D4DCD6; }
.detail-rating .rating-value {
    font-family: 'Inter', sans-serif;
    font-size: 0.9rem;
    font-weight: 700;
    color: #0D2618;
}
.detail-rating .rating-separator { color: #D4DCD6; font-size: 0.8rem; }
.detail-rating .rating-sold {
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    font-weight: 500;
    color: #6A7A72;
}
.related-card-hover:hover { border-color: #0D2618; transform: translateY(-4px); box-shadow: 0 12px 40px rgba(13, 38, 24, 0.06); }
.bottom-bar {
    position: fixed;
    inset-inline: 0;
    bottom: 0;
    z-index: 40;
    background: #FFFFFF;
    border-top: 1px solid #E2E8F0;
    box-shadow: 0 -4px 20px rgba(0,0,0,0.07);
    padding: 10px 16px;
}
.bottom-bar-inner {
    display: flex;
    align-items: center;
    gap: 10px;
    max-width: 640px;
    margin: 0 auto;
}
.bottom-bar-wa {
    flex-shrink: 0;
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #E2E8F0;
    transition: background 0.2s;
}
.bottom-bar-wa:hover { background: #F8FAFC; }
.bottom-bar-btn {
    flex: 1;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-weight: 700;
    font-size: 0.85rem;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 0 16px;
    white-space: nowrap;
}
.bottom-bar-btn:disabled { opacity: 0.4; cursor: not-allowed; }
.bottom-bar-icon {
    width: 18px;
    height: 18px;
    flex-shrink: 0;
    display: block;
}
.btn-cart {
    background: linear-gradient(135deg, #0D2618, #0D2618);
    color: #FFFFFF;
}
.btn-cart:hover { transform: scale(1.02); box-shadow: 0 4px 15px rgba(13, 38, 24, 0.2); }
.btn-buy {
    background: #0D2618;
    color: #FFFFFF;
}
.btn-buy:hover { transform: scale(1.02); box-shadow: 0 4px 15px rgba(13, 38, 24, 0.2); }
@media (max-width: 480px) {
    .bottom-bar { padding: 8px 12px; }
    .bottom-bar-btn { font-size: 0.78rem; padding: 0 10px; gap: 6px; }
    .bottom-bar-icon { width: 16px; height: 16px; }
    .bottom-bar-wa { width: 40px; height: 40px; }
    .bottom-bar-wa svg { width: 18px; height: 18px; }
}

/* â”€â”€ Related Product Cards â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
.related-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}
.related-card {
    display: flex;
    flex-direction: column;
    background: #FFFFFF;
    border: 1px solid #E0E6E2;
    border-radius: 12px;
    padding: 12px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 12px rgba(0,0,0,0.03);
    height: 100%;
    min-height: 220px;
    text-decoration: none;
}
.related-card:hover {
    transform: translateY(-4px);
    border-color: #0D2618;
    box-shadow: 0 8px 30px rgba(13, 38, 24, 0.08);
}
.related-card-image {
    aspect-ratio: 1/1;
    background: #F5F0EB;
    border-radius: 8px;
    overflow: hidden;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}
.related-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}
.related-card:hover .related-card-image img {
    transform: scale(1.08);
}
.related-card-image .fallback {
    font-size: 3rem;
    color: #8A9A92;
    opacity: 0.5;
}
.related-card-badge {
    position: absolute;
    top: 6px;
    right: 6px;
    background: linear-gradient(135deg, #0D2618, #0D2618);
    color: #FFFFFF;
    font-weight: 700;
    font-size: 0.6rem;
    padding: 2px 10px;
    border-radius: 4px;
    font-family: 'Inter', sans-serif;
}
.related-card-name {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: 0.85rem;
    font-weight: 600;
    color: #0D2618;
    margin: 8px 0 4px;
    line-height: 1.2;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 2.4rem;
}
.related-card-benefits {
    margin: 4px 0 8px;
    flex: 1;
}
.related-card-benefits li {
    font-family: 'Inter', sans-serif;
    font-size: 0.65rem;
    color: #6A7A72;
    list-style: none;
    padding: 1px 0;
    display: flex;
    align-items: center;
    gap: 4px;
}
.related-card-benefits li::before {
    content: '\2713';
    color: #0D2618;
    font-weight: 700;
    font-size: 0.6rem;
}
.related-card-prices {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 1px;
}
.related-card-old {
    font-family: 'Inter', sans-serif;
    font-size: 0.65rem;
    color: #8A9A92;
    text-decoration: line-through;
}
.related-card-price {
    font-family: 'Inter', sans-serif;
    font-size: 0.9rem;
    font-weight: 700;
    color: #0D2618;
}
.related-card-rating {
    display: flex;
    align-items: center;
    gap: 4px;
    flex-wrap: wrap;
    margin: 2px 0 6px;
    min-height: 0;
}
.related-card-rating .stars { display: flex; align-items: center; gap: 1px; }
.related-card-rating .stars i { font-size: 0.6rem; }
.related-card-rating .stars .fa-star,
.related-card-rating .stars .fa-star-half-alt { color: #C9A227; }
.related-card-rating .stars .far.fa-star { color: #D4DCD6; }
.related-card-rating .rating-value {
    font-family: 'Inter', sans-serif;
    font-size: 0.7rem;
    font-weight: 600;
    color: #0D2618;
}
.related-card-rating .rating-separator { color: #D4DCD6; font-size: 0.5rem; }
.related-card-rating .rating-sold {
    font-family: 'Inter', sans-serif;
    font-size: 0.6rem;
    color: #6A7A72;
}
.related-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 4px;
    padding-top: 8px;
    border-top: 1px solid #E8ECEA;
}
.related-card-arrow {
    width: 28px;
    height: 28px;
    border: 1px solid #D4DCD6;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    font-size: 0.7rem;
    flex-shrink: 0;
    color: #0D2618;
}
.related-card:hover .related-card-arrow {
    background: linear-gradient(135deg, #0D2618, #0D2618);
    border-color: #0D2618;
    color: #FFFFFF;
    transform: scale(1.05);
}
@media (max-width: 768px) {
    .related-grid { gap: 10px; }
    .related-card { padding: 10px; min-height: 180px; }
    .related-card-name { font-size: 0.75rem; min-height: 2rem; }
    .related-card-price { font-size: 0.8rem; }
    .related-card-old { font-size: 0.6rem; }
    .related-card-benefits { display: none; }
    .related-card-badge { font-size: 0.5rem; padding: 2px 8px; top: 4px; right: 4px; }
    .related-card-arrow { width: 24px; height: 24px; font-size: 0.6rem; }
    .related-card-footer { padding-top: 6px; }
    .related-card-rating .stars i { font-size: 0.5rem; }
    .related-card-rating .rating-value { font-size: 0.6rem; }
    .related-card-rating .rating-sold { font-size: 0.5rem; }
}
@media (min-width: 768px) {
    .related-grid { grid-template-columns: repeat(3, 1fr); gap: 16px; }
    .related-card { padding: 14px; min-height: 240px; }
    .related-card-name { font-size: 0.9rem; }
    .related-card-price { font-size: 0.95rem; }
    .related-card-benefits li { font-size: 0.7rem; }
}
@media (min-width: 1024px) {
    .related-grid { grid-template-columns: repeat(4, 1fr); gap: 20px; }
    .related-card { padding: 16px; min-height: 280px; }
    .related-card-name { font-size: 1rem; }
    .related-card-price { font-size: 1.05rem; }
    .related-card-benefits li { font-size: 0.75rem; }
}
@media (min-width: 1280px) {
    .related-grid { gap: 24px; }
    .related-card { padding: 20px; }
}
@media (min-width: 1024px) {
    .detail-rating .stars i { font-size: 1rem; }
    .detail-rating .rating-value { font-size: 1rem; }
    .detail-rating .rating-sold { font-size: 0.9rem; }
}
</style>
@endpush
@section('content')
{{-- Main wrapper Ã¢â‚¬â€œ add bottom padding so content is not hidden behind sticky bar --}}
<div class="pb-24">

    {{-- Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬ BREADCRUMB Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬ --}}
    <div class="bg-white border-b border-slate-100 px-4 py-2.5">
        <nav class="max-w-7xl mx-auto text-xs font-medium text-slate-400 flex items-center gap-1.5">
            <a href="{{ route('home') }}" class="hover:text-[#0D2618] transition duration-150">Beranda</a>
            <span class="text-[#0D2618] font-semibold">/</span>
            <a href="{{ route('products.index') }}" class="hover:text-[#0D2618] transition duration-150">Produk</a>
            <span class="text-[#0D2618] font-semibold">/</span>
            <span class="text-slate-600 font-semibold truncate max-w-[200px]">{{ $product->name }}</span>
        </nav>
    </div>

    {{-- Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬ PRODUCT DETAIL CARD Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬ --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-14">

            {{-- Ã¢â€â‚¬Ã¢â€â‚¬ LEFT: Photo gallery Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬ --}}
            <div class="lg:col-span-5"
                 x-data="{ active: '{{ $primaryImg?->image_path }}' }">

                {{-- Main photo --}}
                <div class="rounded-2xl overflow-hidden bg-white border border-gray-100 shadow-sm aspect-square relative">
                    @if($product->images->isNotEmpty())
                        <img :src="'/storage/' + active"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center opacity-20"><svg class="w-24 h-24 text-emerald-700" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg></div>
                    @endif
                    @if($product->discounted_price)
                    <div class="absolute top-4 right-4 text-xs font-bold px-3 py-1.5 rounded-lg shadow-md z-10"
                         style="background: linear-gradient(135deg, #0D2618, #0D2618); color: #FFFFFF;">
                        -{{ $product->discount_percentage }}%
                    </div>
                    @endif
                </div>

                {{-- Thumbnail strip --}}
                @if($product->images->count() > 1)
                <div class="flex gap-2 mt-3 flex-wrap">
                    @foreach($product->images as $img)
                    <button @click="active = '{{ $img->image_path }}'"
                            class="w-16 h-16 rounded-xl overflow-hidden border-2 transition focus:outline-none flex-shrink-0"
                            :class="active === '{{ $img->image_path }}'
                                ? 'border-[#0D2618] ring-2 ring-yellow-100'
                                : 'border-slate-100 hover:border-[#0D2618]'">
                        <img src="{{ asset('storage/'.$img->image_path) }}" alt="" class="w-full h-full object-cover">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Ã¢â€â‚¬Ã¢â€â‚¬ RIGHT: Product info Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬ --}}
            <div class="lg:col-span-7 flex flex-col gap-5">

                {{-- Product badge --}}
                <span class="text-xs font-semibold uppercase tracking-widest" style="color: #0D2618;">Bharata Herbal</span>

                {{-- Price (prominent Ã¢â‚¬â€œ shown first like Shopee mobile) --}}
                <div class="bg-[#F5F0EB]/60 rounded-2xl px-5 py-4 border border-[#E0E6E2]/60">
                    @if($product->discounted_price)
                    <div class="flex items-center gap-3">
                        <div class="text-3xl font-extrabold" style="color: #0D2618;">
                            {{ $product->formatted_discounted_price }}
                        </div>
                        <div class="text-base text-slate-400 line-through font-medium">{{ $product->formatted_price }}</div>
                    </div>
                    <div class="mt-1 inline-block font-bold text-[10px] px-2 py-0.5 rounded" style="color: #0D2618;">
                        Hemat {{ $product->discount_percentage }}%
                    </div>
                    @else
                    <div class="text-3xl font-extrabold" style="color: #0D2618;">
                        {{ $product->formatted_price }}
                    </div>
                    @endif
                </div>

                {{-- Product name --}}
                <h1 class="text-2xl md:text-3xl font-bold leading-snug text-slate-800">
                    {{ $product->name }}
                </h1>

                {{-- Rating & Sales --}}
                <div class="detail-rating">
                    @if($product->rating)
                    <div class="stars">
                        @include('partials.product-stars', ['rating' => $product->rating])
                    </div>
                    <span class="rating-value">{{ number_format($product->rating, 1) }}</span>
                    @endif
                    @if($product->rating && $product->sales_count > 0)
                    <span class="rating-separator">|</span>
                    @endif
                    @if($product->sales_count > 0)
                    <span class="rating-sold">{{ $product->sales_count }}+ terjual</span>
                    @endif
                </div>

                {{-- Stock badge --}}
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Stok:</span>
                    @if($product->stock > 0)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                            Tersedia ({{ $product->stock }} unit)
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-800 border border-rose-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 inline-block"></span>
                            Stok Habis
                        </span>
                    @endif
                </div>

                {{-- Ã¢â€â‚¬Ã¢â€â‚¬ Accordion / Tab sections Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬ --}}
                <div class="mt-2 rounded-2xl border border-slate-100 bg-white shadow-sm overflow-hidden"
                     x-data="{ tab: 'desc' }">

                    {{-- Tab headers --}}
                    <div class="flex border-b border-slate-100 text-sm font-semibold overflow-x-auto">
                        @foreach([
                            ['id'=>'desc','label'=>'Deskripsi'],
                            ['id'=>'benefits','label'=>'Manfaat'],
                            ['id'=>'usage','label'=>'Cara Pakai'],
                            ['id'=>'ingredients','label'=>'Komposisi'],
                        ] as $t)
                        <button @click="tab = '{{ $t['id'] }}'"
                                :class="tab === '{{ $t['id'] }}' ? 'border-b-2' : 'text-slate-400 hover:text-slate-600'"
                                class="px-5 py-3.5 whitespace-nowrap transition focus:outline-none flex-shrink-0 font-bold"
                                style="{{ "tab === '{$t['id']}' ? 'border-color: #0D2618; color: #0D2618' : ''" }}">
                            {{ $t['label'] }}
                        </button>
                        @endforeach
                    </div>

                    {{-- Tab content --}}
                    <div class="p-5">
                        {{-- Deskripsi --}}
                        <div x-show="tab === 'desc'" x-cloak>
                            <p class="text-slate-600 leading-relaxed text-sm">
                                {{ $product->description ?: 'Belum ada deskripsi untuk produk ini.' }}
                            </p>
                        </div>

                        {{-- Manfaat --}}
                        <div x-show="tab === 'benefits'" x-cloak>
                            @if($product->benefits && count($product->benefits) > 0)
                            <ul class="space-y-2.5">
                                @foreach($product->benefits as $benefit)
                                <li class="flex items-start gap-2.5 text-slate-600 text-sm">
                                    <span class="mt-0.5 flex-shrink-0 text-emerald-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                    {{ $benefit }}
                                </li>
                                @endforeach
                            </ul>
                            @else
                            <p class="text-slate-400 text-sm">Belum ada data manfaat.</p>
                            @endif
                        </div>

                        {{-- Cara Pakai --}}
                        <div x-show="tab === 'usage'" x-cloak>
                            @if($product->usage)
                            <p class="text-slate-600 leading-relaxed text-sm">{{ $product->usage }}</p>
                            @else
                            <p class="text-slate-400 text-sm">Belum ada informasi cara pemakaian.</p>
                            @endif
                        </div>

                        {{-- Komposisi --}}
                        <div x-show="tab === 'ingredients'" x-cloak>
                            @if($product->ingredients)
                            <p class="text-slate-600 leading-relaxed text-sm">{{ $product->ingredients }}</p>
                            @else
                            <p class="text-slate-400 text-sm">Belum ada data komposisi bahan.</p>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- END tabs --}}

            </div>
            {{-- END right col --}}
        </div>

        {{-- Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬ RELATED PRODUCTS Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬ --}}
        @if($related->isNotEmpty())
        <div class="mt-14 border-t border-slate-100 pt-10">
            <h2 class="font-serif text-2xl font-bold mb-6 gold-shimmer" style="color:#0D2618;">Produk Terkait</h2>
            <div class="related-grid">
                @foreach($related as $rel)
                <a href="{{ route('products.show', $rel->slug) }}" class="related-card">
                    <div class="related-card-image">
                        @if($rel->images->isNotEmpty())
                        <img src="{{ asset('storage/'.$rel->images->first()->image_path) }}" alt="{{ $rel->name }}">
                        @else
                        <i class="fas fa-leaf fallback"></i>
                        @endif
                        @if($rel->discounted_price)
                        <span class="related-card-badge">-{{ $rel->discount_percentage }}%</span>
                        @endif
                    </div>

                    <h4 class="related-card-name">{{ $rel->name }}</h4>

                    <div class="related-card-rating">
                        @if($rel->rating)
                        <div class="stars">
                            @include('partials.product-stars', ['rating' => $rel->rating])
                        </div>
                        <span class="rating-value">{{ number_format($rel->rating, 1) }}</span>
                        @endif
                        @if($rel->rating && $rel->sales_count > 0)
                        <span class="rating-separator">&middot;</span>
                        @endif
                        @if($rel->sales_count > 0)
                        <span class="rating-sold">{{ $rel->sales_count }}+ terjual</span>
                        @endif
                    </div>

                    @if($rel->benefits)
                    <ul class="related-card-benefits">
                        @foreach(array_slice($rel->benefits, 0, 3) as $benefit)
                        <li>{{ $benefit }}</li>
                        @endforeach
                    </ul>
                    @endif

                    <div class="related-card-footer">
                        <div class="related-card-prices">
                            @if($rel->discounted_price)
                            <span class="related-card-old">{{ $rel->formatted_price }}</span>
                            <span class="related-card-price">{{ $rel->formatted_discounted_price }}</span>
                            @else
                            <span class="related-card-price">{{ $rel->formatted_price }}</span>
                            @endif
                        </div>
                        <span class="related-card-arrow">
                            <i class="fas fa-arrow-right" style="font-size:14px;"></i>
                        </span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬ REVIEWS SECTION Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬ --}}
        <div class="mt-10 border-t border-slate-100 pt-8">
            <h2 class="font-serif text-xl font-bold mb-5 gold-shimmer" style="color:#0D2618;">
                <svg class="w-5 h-5 inline" fill="currentColor" viewBox="0 0 20 20" style="color:#0D2618;"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg> Ulasan Pembeli
                @if($reviews->count() > 0)
                <span class="text-sm font-normal text-gray-400 ml-2">({{ $reviews->count() }} ulasan)</span>
                @endif
            </h2>

            @if($reviews->isEmpty())
            <div class="bg-white rounded-2xl border border-dashed border-gray-200 py-10 text-center text-gray-400 text-sm">
                Belum ada ulasan untuk produk ini. Jadilah yang pertama!
            </div>
            @else
            <div class="space-y-4">
                @foreach($reviews as $review)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-white text-sm flex-shrink-0"
                             style="background: var(--primary);">
                            {{ strtoupper(substr($review->customer_name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-semibold text-sm text-slate-800">{{ $review->customer_name }}</div>
                            <div class="flex items-center gap-0.5 mt-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                <x-icon name="star" class="w-4 h-4 {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-200' }}" />
                                @endfor
                                <span class="text-xs text-gray-400 ml-1.5">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    @if($review->comment)
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $review->comment }}</p>
                    @endif
                    @if($review->admin_reply)
                    <div class="mt-3 bg-emerald-50 border border-emerald-100 rounded-xl px-4 py-3 text-xs text-emerald-800 font-medium">
                        <span class="font-bold">Admin:</span> {{ $review->admin_reply }}
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            @endif
        </div>
        {{-- END reviews --}}

    </div>
    {{-- END max-w --}}
</div>
{{-- END pb-24 --}}


{{-- ═══════════════════════════════════════════════════════════════
     BOTTOM STICKY ACTION BAR (Shopee-style)
     Uses Alpine.js x-data for modal control + cart AJAX
     ═══════════════════════════════════════════════════════════════ --}}
<div x-data="{
        qty: 1,
        maxStock: {{ $product->stock }},
        loading: false,
        mode: '',       /* 'cart' or 'buy' */
        showModal: false,
        toastMessage: '',
        showToast: false,
        open(m) { this.mode = m; this.qty = 1; this.showModal = true; },
        increment() { if (this.qty < this.maxStock) this.qty++; },
        decrement() { if (this.qty > 1) this.qty--; },
        async addToCart() {
            if (this.maxStock <= 0) return;
            this.loading = true;
            try {
                let res = await fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ product_id: {{ $product->id }}, quantity: this.qty })
                });
                let data = await res.json();
                this.showModal = false;
                if (res.ok) { 
                    this.toastMessage = data.message || 'Produk berhasil ditambahkan ke keranjang.';
                    this.showToast = true;
                    setTimeout(() => { location.reload(); }, 1500);
                }
                else        { Alpine.store('modal').alert(data.message || 'Gagal menambahkan ke keranjang', 'error'); }
            } catch(e) { Alpine.store('modal').alert('Terjadi kesalahan koneksi.', 'error'); }
            finally { this.loading = false; }
        },
        buyNow() {
            window.location.href = '{{ route('order.form') }}?produk={{ $product->slug }}&qty=' + this.qty;
        }
     }"
     class="fixed inset-x-0 bottom-0 z-30">

    {{-- Ã¢â€â‚¬Ã¢â€â‚¬ QTY Modal / Drawer Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬ --}}
    <div x-show="showModal"
         x-cloak
         class="fixed inset-0 z-[60] flex items-end"
         @keydown.escape.window="showModal = false">

        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"
             @click="showModal = false"></div>

        {{-- Drawer --}}
        <div class="relative w-full bg-white rounded-t-3xl shadow-2xl z-[70] px-5 pt-5 pb-8"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-full"
             x-transition:enter-end="translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-y-0"
             x-transition:leave-end="translate-y-full">

            {{-- Handle --}}
            <div class="w-10 h-1 rounded-full bg-slate-200 mx-auto mb-5"></div>

            {{-- Product mini info --}}
            <div class="flex items-center gap-3 mb-6">
                @if($primaryImg)
                <img src="{{ asset('storage/'.$primaryImg->image_path) }}"
                     alt="{{ $product->name }}"
                     class="w-16 h-16 object-cover rounded-xl border border-slate-100 flex-shrink-0">
                @endif
                <div>
                    <div class="font-bold text-base leading-tight text-slate-800 line-clamp-2">{{ $product->name }}</div>
                    <div class="text-lg font-extrabold mt-0.5" style="color: var(--primary);">
                        {{ $product->formatted_discounted_price ?? $product->formatted_price }}
                    </div>
                    @if($product->discounted_price)
                    <div class="text-xs text-slate-400 line-through">{{ $product->formatted_price }}</div>
                    @endif
                </div>
            </div>

            {{-- Qty Selector --}}
            <div class="flex items-center justify-between mb-5">
                <span class="text-sm font-semibold text-slate-500">Jumlah</span>
                <div class="flex items-center gap-0 border border-slate-200 rounded-xl overflow-hidden shadow-sm">
                    <button type="button" @click="decrement"
                            class="w-10 h-10 text-lg font-bold bg-slate-50 hover:bg-slate-100 transition select-none flex items-center justify-center">
                        &minus;
                    </button>
                    <span x-text="qty" class="w-12 text-center font-bold text-slate-700 text-base select-none"></span>
                    <button type="button" @click="increment"
                            class="w-10 h-10 text-lg font-bold bg-slate-50 hover:bg-slate-100 transition select-none flex items-center justify-center">
                        +
                    </button>
                </div>
                <span class="text-xs font-medium text-slate-400">Stok: {{ $product->stock }}</span>
            </div>

            {{-- Confirm Button --}}
            <button
                @click="mode === 'cart' ? addToCart() : buyNow()"
                :disabled="loading || maxStock <= 0"
                class="w-full py-4 rounded-2xl font-bold text-base transition shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                :style="mode === 'cart'
                    ? 'background: linear-gradient(135deg, #0D2618, #0D2618); color: #FFFFFF;'
                    : 'background: #0D2618; color: #FFFFFF;'">
                <span x-show="loading">
                    <svg class="w-5 h-5 inline animate-spin" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Memproses...
                </span>
                <span x-show="!loading && mode === 'cart'">
                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg> Tambah ke Keranjang
                </span>
                <span x-show="!loading && mode === 'buy'">
                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg> Beli Sekarang
                </span>
            </button>

            @if($product->stock <= 0)
            <p class="text-center text-rose-500 font-semibold text-sm mt-3">Stok produk ini sudah habis.</p>
            @endif
        </div>
    </div>

    {{-- Ã¢â€â‚¬Ã¢â€â‚¬ Bottom Bar Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬Ã¢â€â‚¬ --}}
    <div class="bottom-bar">
        <div class="bottom-bar-inner">
            {{-- WhatsApp Chat icon --}}
            <a href="https://wa.me/{{ $formattedWa }}?text={{ $waMessage }}"
               target="_blank" rel="noopener noreferrer"
               class="bottom-bar-wa"
               title="Konsultasi via WhatsApp">
                <svg class="w-5 h-5" fill="#25D366" viewBox="0 0 24 24">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.6.95 3.488 1.459 5.407 1.461 5.485.002 9.957-4.469 9.96-9.953.001-2.657-1.034-5.155-2.914-7.038C17.22 1.74 14.725.703 12.01.703c-5.49 0-9.96 4.47-9.963 9.954-.001 1.96.512 3.878 1.488 5.614l-.976 3.565 3.659-.96.439.26zM18.867 15.42c-.308-.154-1.82-.9-2.1-.1-2.28-.1-2.464-.2-.28-.154.22-.164.22-.3.51-.54.308-.24.154-.45.077-.6-.078-.15-.7-1.693-.962-2.32-.25-.6-.51-.52-.7-.52-.178-.008-.385-.01-.595-.01-.21 0-.553.08-.84.394-.288.314-1.1.1.8-1.077 1.1-.8 2.225.8 2.225.438.3.615.1.754-.06.138-.162.3-.54.43-.807.13-.268.064-.5-.03-.7-.09-.2-.77-1.854-1.055-2.54-.27-.66-.548-.57-.7-.58-.145-.007-.312-.008-.478-.008-.166 0-.435.06-.663.29-.228.23-.87.85-.87 2.07s.89 2.4 1.014 2.57c.125.17 1.754 2.678 4.25 3.758.59.256 1.055.41 1.41.52.597.19 1.14.162 1.57.1.477-.07 1.46-.596 1.666-1.17.206-.576.206-1.07.144-1.17-.06-.1-.23-.15-.54-.3z"/>
                </svg>
            </a>

            {{-- Add to Cart --}}
            <button @click="open('cart')" :disabled="maxStock <= 0" class="bottom-bar-btn btn-cart">
                <svg class="bottom-bar-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                <span>Keranjang</span>
            </button>

            {{-- Buy Now --}}
            <button @click="open('buy')" :disabled="maxStock <= 0" class="bottom-bar-btn btn-buy">
                <svg class="bottom-bar-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span>Beli Sekarang</span>
            </button>
        </div>
    </div>
    {{-- END bottom bar --}}

    {{-- Toast Notification --}}
    <div x-show="showToast" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-4"
         class="fixed bottom-24 left-1/2 -translate-x-1/2 z-[80] bg-white rounded-xl shadow-xl border border-emerald-100 px-5 py-3 flex items-center gap-3 whitespace-nowrap">
        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="text-sm font-semibold text-slate-800" x-text="toastMessage"></span>
    </div>

</div>
{{-- END Alpine wrapper --}}

@endsection

