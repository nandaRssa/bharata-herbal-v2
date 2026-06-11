@extends('layouts.public')
@section('title', $product->name)

@php
    $formattedWa = $settings->wa_number ?? '';
    if (str_starts_with($formattedWa, '0')) {
        $formattedWa = '62' . substr($formattedWa, 1);
    }
    $formattedWa = preg_replace('/[^0-9]/', '', $formattedWa);
    $displayPrice = $product->formatted_discounted_price ?? $product->formatted_price;
    $waMessage = rawurlencode("Halo Bharata Herbal ID, saya tertarik dengan produk " . $product->name . " (Harga: " . $displayPrice . "). Apakah produk ini ready stock? Saya ingin berkonsultasi lebih lanjut.");
    $primaryImg = $product->images->where('is_primary', true)->first() ?? $product->images->first();
@endphp

@section('content')
{{-- Main wrapper – add bottom padding so content is not hidden behind sticky bar --}}
<div class="pb-24">

    {{-- ─── BREADCRUMB ─────────────────────────────────────────── --}}
    <div class="bg-white border-b border-gray-100 px-4 py-2.5">
        <nav class="max-w-7xl mx-auto text-xs font-semibold text-slate-400 flex items-center gap-1.5">
            <a href="{{ route('home') }}" class="hover:text-emerald-700 transition">Beranda</a>
            <span>/</span>
            <a href="{{ route('products.index') }}" class="hover:text-emerald-700 transition">Produk</a>
            <span>/</span>
            <span class="text-slate-600 truncate max-w-[160px]">{{ $product->name }}</span>
        </nav>
    </div>

    {{-- ─── PRODUCT DETAIL CARD ────────────────────────────────── --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-14">

            {{-- ── LEFT: Photo gallery ──────────────────────────── --}}
            <div class="lg:col-span-5"
                 x-data="{ active: '{{ $primaryImg?->image_path }}' }">

                {{-- Main photo --}}
                <div class="rounded-2xl overflow-hidden bg-white border border-gray-100 shadow-sm aspect-square relative">
                    @if($product->images->isNotEmpty())
                        <img :src="'/storage/' + active"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-8xl opacity-20">🌿</div>
                    @endif
                    @if($product->discounted_price)
                    <div class="absolute top-4 left-4 bg-rose-500 text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow-md z-10">
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
                                ? 'border-emerald-600 ring-2 ring-emerald-100'
                                : 'border-slate-100 hover:border-slate-300'">
                        <img src="{{ asset('storage/'.$img->image_path) }}" alt="" class="w-full h-full object-cover">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- ── RIGHT: Product info ──────────────────────────── --}}
            <div class="lg:col-span-7 flex flex-col gap-5">

                {{-- Price (prominent – shown first like Shopee mobile) --}}
                <div class="bg-emerald-50/60 rounded-2xl px-5 py-4 border border-emerald-100/60">
                    @if($product->discounted_price)
                    <div class="flex items-center gap-3">
                        <div class="text-3xl font-extrabold" style="color: var(--primary);">
                            {{ $product->formatted_discounted_price }}
                        </div>
                        <div class="text-base text-slate-400 line-through font-medium">{{ $product->formatted_price }}</div>
                    </div>
                    <div class="mt-1 inline-block bg-rose-500 text-white text-[10px] font-bold px-2 py-0.5 rounded">
                        Hemat {{ $product->discount_percentage }}%
                    </div>
                    @else
                    <div class="text-3xl font-extrabold" style="color: var(--primary);">
                        {{ $product->formatted_price }}
                    </div>
                    @endif
                </div>

                {{-- Product name --}}
                <h1 class="text-2xl md:text-3xl font-bold leading-snug text-slate-800">
                    {{ $product->name }}
                </h1>

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

                {{-- ── Accordion / Tab sections ─────────────────── --}}
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
                                :class="tab === '{{ $t['id'] }}' ? 'border-b-2 text-emerald-700' : 'text-slate-400 hover:text-slate-600'"
                                class="px-5 py-3.5 whitespace-nowrap transition focus:outline-none flex-shrink-0"
                                style="{{ "tab === '{$t['id']}' ? 'border-color: var(--primary)' : ''" }}">
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

        {{-- ─── RELATED PRODUCTS ─────────────────────────────────── --}}
        @if($related->isNotEmpty())
        <div class="mt-14 border-t border-slate-100 pt-10">
            <h2 class="text-2xl font-bold mb-6" style="color: var(--primary);">Produk Terkait</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($related as $rel)
                <a href="{{ route('products.show', $rel->slug) }}"
                   class="group flex flex-col bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md border border-gray-100 transition-all duration-300 hover:-translate-y-0.5">
                    <div class="aspect-square overflow-hidden bg-slate-50 relative">
                        @if($rel->images->isNotEmpty())
                        <img src="{{ asset('storage/'.$rel->images->first()->image_path) }}"
                             alt="{{ $rel->name }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-4xl opacity-20">🌿</div>
                        @endif
                        @if($rel->discounted_price)
                        <div class="absolute top-2 left-2 bg-rose-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded shadow-md z-10">
                            -{{ $rel->discount_percentage }}%
                        </div>
                        @endif
                    </div>
                    <div class="p-3 flex flex-col flex-1">
                        <h4 class="font-semibold text-sm text-slate-700 leading-tight line-clamp-2 mb-1">{{ $rel->name }}</h4>
                        <div class="mt-auto">
                            @if($rel->discounted_price)
                            <div class="font-extrabold text-sm" style="color: var(--primary);">{{ $rel->formatted_discounted_price }}</div>
                            <div class="text-[10px] text-slate-400 line-through">{{ $rel->formatted_price }}</div>
                            @else
                            <div class="font-extrabold text-sm" style="color: var(--primary);">{{ $rel->formatted_price }}</div>
                            @endif
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ─── REVIEWS SECTION ──────────────────────────────────── --}}
        <div class="mt-10 border-t border-slate-100 pt-8">
            <h2 class="text-xl font-bold mb-5" style="color: var(--primary);">
                ⭐ Ulasan Pembeli
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
                                <span class="text-sm {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-200' }}">★</span>
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
════════════════════════════════════════════════════════════════ --}}
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
                else        { alert(data.message || 'Gagal menambahkan ke keranjang'); }
            } catch(e) { alert('Terjadi kesalahan koneksi.'); }
            finally { this.loading = false; }
        },
        buyNow() {
            window.location.href = '{{ route('order.form') }}?produk={{ $product->slug }}&qty=' + this.qty;
        }
     }"
     class="fixed inset-x-0 bottom-0 z-50">

    {{-- ── QTY Modal / Drawer ────────────────────────────────────── --}}
    <div x-show="showModal"
         x-cloak
         class="fixed inset-0 z-40 flex items-end"
         @keydown.escape.window="showModal = false">

        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"
             @click="showModal = false"></div>

        {{-- Drawer --}}
        <div class="relative w-full bg-white rounded-t-3xl shadow-2xl z-50 px-5 pt-5 pb-8"
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
                        −
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
                class="w-full py-4 rounded-2xl font-bold text-white text-base transition shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                style="background: var(--primary);"
                x-text="loading ? 'Memproses...' : (mode === 'cart' ? '🛒  Tambah ke Keranjang' : '⚡  Beli Sekarang')">
            </button>

            @if($product->stock <= 0)
            <p class="text-center text-rose-500 font-semibold text-sm mt-3">Stok produk ini sudah habis.</p>
            @endif
        </div>
    </div>

    {{-- ── Bottom Bar ────────────────────────────────────────────── --}}
    <div class="bg-white border-t border-slate-200 shadow-[0_-4px_20px_rgba(0,0,0,0.07)] flex items-center px-4 py-3 gap-3">

        {{-- WhatsApp Chat icon --}}
        <a href="https://wa.me/{{ $formattedWa }}?text={{ $waMessage }}"
           target="_blank" rel="noopener noreferrer"
           class="flex-shrink-0 w-12 h-12 rounded-xl flex items-center justify-center border border-slate-200 hover:bg-slate-50 transition"
           title="Konsultasi via WhatsApp">
            <svg class="w-6 h-6" fill="#25D366" viewBox="0 0 24 24">
                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.6.95 3.488 1.459 5.407 1.461 5.485.002 9.957-4.469 9.96-9.953.001-2.657-1.034-5.155-2.914-7.038C17.22 1.74 14.725.703 12.01.703c-5.49 0-9.96 4.47-9.963 9.954-.001 1.96.512 3.878 1.488 5.614l-.976 3.565 3.659-.96.439.26zM18.867 15.42c-.308-.154-1.82-.9-2.1-.1-2.28-.1-2.464-.2-.28-.154.22-.164.22-.3.51-.54.308-.24.154-.45.077-.6-.078-.15-.7-1.693-.962-2.32-.25-.6-.51-.52-.7-.52-.178-.008-.385-.01-.595-.01-.21 0-.553.08-.84.394-.288.314-1.1.1.8-1.077 1.1-.8 2.225.8 2.225.438.3.615.1.754-.06.138-.162.3-.54.43-.807.13-.268.064-.5-.03-.7-.09-.2-.77-1.854-1.055-2.54-.27-.66-.548-.57-.7-.58-.145-.007-.312-.008-.478-.008-.166 0-.435.06-.663.29-.228.23-.87.85-.87 2.07s.89 2.4 1.014 2.57c.125.17 1.754 2.678 4.25 3.758.59.256 1.055.41 1.41.52.597.19 1.14.162 1.57.1.477-.07 1.46-.596 1.666-1.17.206-.576.206-1.07.144-1.17-.06-.1-.23-.15-.54-.3z"/>
            </svg>
        </a>

        {{-- Add to Cart --}}
        <button
            @click="open('cart')"
            :disabled="maxStock <= 0"
            class="flex-1 h-12 flex items-center justify-center gap-2 font-bold text-sm rounded-xl border-2 transition disabled:opacity-40 disabled:cursor-not-allowed hover:bg-emerald-50"
            style="border-color: var(--primary); color: var(--primary);">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            Keranjang
        </button>

        {{-- Buy Now --}}
        <button
            @click="open('buy')"
            :disabled="maxStock <= 0"
            class="flex-1 h-12 flex items-center justify-center gap-2 text-white font-bold text-sm rounded-xl transition shadow-md hover:shadow-lg disabled:opacity-40 disabled:cursor-not-allowed"
            style="background: var(--primary);">
            ⚡ Beli Sekarang
        </button>

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
         class="fixed bottom-24 left-1/2 -translate-x-1/2 z-[60] bg-white rounded-xl shadow-xl border border-emerald-100 px-5 py-3 flex items-center gap-3 whitespace-nowrap">
        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="text-sm font-semibold text-slate-800" x-text="toastMessage"></span>
    </div>

</div>
{{-- END Alpine wrapper --}}

@endsection
