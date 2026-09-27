@extends('layouts.public')
@section('title', 'Katalog Produk')

@push('styles')
<style>
/* ── Page Hero (Clean Solid) ────────────────────────────────── */
.catalog-hero {
    background: #0D2618;
    padding: 100px 20px 70px;
    text-align: center;
    position: relative;
}
.catalog-hero-badge {
    display: inline-block;
    background: rgba(168, 221, 191, 0.12);
    color: #A8DDBF;
    border: 1px solid rgba(168, 221, 191, 0.25);
    border-radius: 50px;
    padding: 6px 22px;
    font-size: 0.7rem;
    letter-spacing: 2px;
    text-transform: uppercase;
    font-weight: 600;
    font-family: 'Inter', sans-serif;
    margin-bottom: 20px;
}
.catalog-hero-title {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: clamp(2.2rem, 5vw, 3.5rem);
    font-weight: 700;
    color: #FFFFFF;
    line-height: 1.18;
    margin-bottom: 0;
}
.catalog-hero-title .hero-gold {
    color: #A8DDBF;
}
.catalog-hero-divider {
    width: 60px; height: 3px;
    background: #A8DDBF;
    border-radius: 2px;
    margin: 18px auto;
}
.catalog-hero-desc {
    font-family: 'Inter', sans-serif;
    font-size: 0.95rem;
    color: #D1E5DB;
    max-width: 650px;
    margin: 0 auto;
    line-height: 1.7;
}

/* ── Catalog Content ─────────────────────────────────────────── */
.catalog-content {
    background: #F8FAF7;
    padding: 50px 0 70px;
}

/* â”€â”€ Search Bar â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
.search-container {
    display: flex;
    flex-wrap: wrap;
    max-width: 600px;
    margin: 0 auto 48px auto;
    background: #FFFFFF;
    border: 2px solid #D4DCD6;
    border-radius: 60px;
    padding: 4px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
}
.search-container:focus-within {
    border-color: #0D2618;
    box-shadow: 0 8px 40px rgba(13, 38, 24, 0.10);
}
.search-input-wrap {
    flex: 1;
    display: flex;
    align-items: center;
    min-width: 120px;
}
.search-input-wrap input {
    flex: 1;
    background: transparent;
    border: none;
    padding: 14px 24px;
    color: #0D2618;
    font-family: 'Inter', sans-serif;
    font-size: 0.95rem;
    outline: none;
    min-width: 60px;
}
.search-input-wrap input::placeholder {
    color: #8A9A92;
    font-style: italic;
}
.search-container button {
    background: linear-gradient(135deg, #0D2618, #0D2618);
    border: none;
    border-radius: 50px;
    padding: 12px 32px;
    color: #FFFFFF;
    font-weight: 600;
    font-family: 'Inter', sans-serif;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}
.search-container button:hover {
    transform: scale(1.03);
    box-shadow: 0 8px 30px rgba(13, 38, 24, 0.25);
}
.search-container .btn-reset {
    background: transparent;
    color: #8A9A92;
    padding: 12px 16px;
    font-weight: 500;
    flex-shrink: 0;
    display: flex;
    align-items: center;
}
.search-container .btn-reset:hover {
    color: #0D2618;
    transform: none;
    box-shadow: none;
}

/* â”€â”€ Product Grid â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
.product-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
    padding: 0 4px;
}
.product-card {
    background: #FFFFFF;
    border: 1px solid #E0E6E2;
    border-radius: 12px;
    padding: 12px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.03);
    display: flex;
    flex-direction: column;
    height: 100%;
    min-height: 220px;
    text-decoration: none;
}
.product-card:hover {
    transform: translateY(-4px);
    border-color: #0D2618;
    box-shadow: 0 8px 30px rgba(13, 38, 24, 0.08);
}

.product-image {
    aspect-ratio: 1/1;
    background: #F5F0EB;
    border-radius: 8px;
    overflow: hidden;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}
.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}
.product-card:hover .product-image img {
    transform: scale(1.08);
}
.product-image .fallback-icon {
    font-size: 3rem;
    color: #8A9A92;
    opacity: 0.5;
}
.badge-discount {
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
.product-name {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: 0.85rem;
    font-weight: 600;
    color: #0D2618;
    margin: 8px 0 4px 0;
    line-height: 1.2;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 2.4rem;
}
.product-benefits {
    margin: 4px 0 8px 0;
    flex: 1;
}
.product-benefits li {
    font-family: 'Inter', sans-serif;
    font-size: 0.65rem;
    color: #6A7A72;
    list-style: none;
    padding: 1px 0;
    display: flex;
    align-items: center;
    gap: 4px;
}
.product-benefits li::before {
    content: '\2713';
    color: #0D2618;
    font-weight: 700;
    font-size: 0.6rem;
}
.product-rating {
    display: flex;
    align-items: center;
    gap: 4px;
    flex-wrap: wrap;
    margin: 2px 0 6px;
    min-height: 0;
}
.product-rating .stars { display: flex; align-items: center; gap: 1px; }
.product-rating .stars i { font-size: 0.6rem; }
.product-rating .stars .fa-star,
.product-rating .stars .fa-star-half-alt { color: #C9A227; }
.product-rating .stars .far.fa-star { color: #D4DCD6; }
.product-rating .rating-value {
    font-family: 'Inter', sans-serif;
    font-size: 0.7rem;
    font-weight: 600;
    color: #0D2618;
}
.product-rating .rating-separator { color: #D4DCD6; font-size: 0.5rem; }
.product-rating .rating-sold {
    font-family: 'Inter', sans-serif;
    font-size: 0.6rem;
    color: #6A7A72;
}
.product-price-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 4px;
    padding-top: 8px;
    border-top: 1px solid #E8ECEA;
}
.product-prices {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 1px;
}
.product-price-old {
    font-family: 'Inter', sans-serif;
    font-size: 0.65rem;
    color: #8A9A92;
    text-decoration: line-through;
}
.product-price {
    font-family: 'Inter', sans-serif;
    font-size: 0.9rem;
    font-weight: 700;
    color: #0D2618;
}
.product-arrow {
    width: 28px;
    height: 28px;
    border: 1px solid #D4DCD6;
    border-radius: 50%;
    background: transparent;
    color: #0D2618;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.7rem;
    flex-shrink: 0;
    text-decoration: none;
}
.product-arrow:hover {
    background: linear-gradient(135deg, #0D2618, #0D2618);
    color: #FFFFFF;
    border-color: #0D2618;
    transform: scale(1.05);
}

/* â”€â”€ Empty State â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 0;
    color: #6A7A72;
}
.empty-state i {
    font-size: 2.5rem;
    color: #0D2618;
    margin-bottom: 16px;
    display: block;
}
.empty-state h3 {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: 1.3rem;
    color: #0D2618;
    margin-bottom: 8px;
}
.empty-state p {
    font-size: 0.9rem;
    color: #8A9A92;
}

/* â”€â”€ Pagination â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
.pagination-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
    margin-top: 48px;
    padding-top: 32px;
    border-top: 1px solid #E0E6E2;
}
.pagination-info {
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    color: #6A7A72;
}
.pagination-numbers {
    display: flex;
    gap: 8px;
}
.pagination-numbers a,
.pagination-numbers span {
    width: 40px;
    height: 40px;
    border: 1px solid #D4DCD6;
    border-radius: 8px;
    background: #FFFFFF;
    color: #0D2618;
    font-family: 'Inter', sans-serif;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
}
.pagination-numbers a:hover {
    border-color: #0D2618;
    color: #0D2618;
}
.pagination-numbers span.active {
    background: linear-gradient(135deg, #0D2618, #0D2618);
    color: #FFFFFF;
    border-color: #0D2618;
}
.pagination-numbers .nav-btn {
    background: transparent;
    border: none;
    color: #6A7A72;
    width: auto;
    padding: 0 8px;
    cursor: pointer;
    transition: color 0.3s ease;
}
.pagination-numbers .nav-btn:hover {
    color: #0D2618;
}

/* â”€â”€ Responsive â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
@media (max-width: 768px) {
    .catalog-hero { padding: 90px 20px 70px; }
    .catalog-hero::after { height: 40px; }
    .catalog-hero-leaf { display: none; }
    .search-container { border-radius: 20px; padding: 8px; margin-left: 16px; margin-right: 16px; }
    .search-input-wrap { width: 100%; }
    .search-input-wrap input { padding: 12px 16px; }
    .search-container button { justify-content: center; padding: 10px 24px; width: 100%; }
    .search-container .btn-reset { padding: 12px 12px; }
    .product-grid { gap: 10px; }
    .product-card { padding: 10px; min-height: 180px; }
    .product-card .product-name { font-size: 0.75rem; min-height: 2rem; }
    .product-card .product-price { font-size: 0.8rem; }
    .product-card .product-price-old { font-size: 0.6rem; }
    .product-card .product-benefits { display: none; }
    .product-card .badge-discount { font-size: 0.5rem; padding: 2px 8px; top: 4px; right: 4px; }
    .product-card .product-arrow { width: 24px; height: 24px; font-size: 0.6rem; }
    .product-card .product-price-wrapper { padding-top: 6px; }
    .product-card .product-rating .stars i { font-size: 0.5rem; }
    .product-card .product-rating .rating-value { font-size: 0.6rem; }
    .product-card .product-rating .rating-sold { font-size: 0.5rem; }
}
@media (min-width: 768px) {
    .product-grid { grid-template-columns: repeat(3, 1fr); gap: 16px; }
    .product-card { padding: 14px; min-height: 240px; }
    .product-card .product-name { font-size: 0.9rem; }
    .product-card .product-price { font-size: 0.95rem; }
    .product-card .product-benefits li { font-size: 0.7rem; }
}
@media (min-width: 1024px) {
    .product-grid { grid-template-columns: repeat(4, 1fr); gap: 20px; }
    .product-card { padding: 16px; min-height: 280px; }
    .product-card .product-name { font-size: 1rem; }
    .product-card .product-price { font-size: 1.05rem; }
    .product-card .product-benefits li { font-size: 0.75rem; }
    .product-card .product-rating .stars i { font-size: 0.7rem; }
    .product-card .product-rating .rating-value { font-size: 0.75rem; }
    .product-card .product-rating .rating-sold { font-size: 0.65rem; }
}
@media (min-width: 1280px) {
    .product-grid { gap: 24px; }
    .product-card { padding: 20px; }
}
@media (max-width: 480px) {
    .search-container button span { display: none; }
    .search-container button { padding: 12px 16px; }
}

/* â”€â”€ Fade-up Animation â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
.fade-up {
    opacity: 0;
    transform: translateY(24px);
    transition: opacity 0.6s ease, transform 0.6s ease;
}
.fade-up.visible {
    opacity: 1;
    transform: translateY(0);
}
</style>
@endpush

@section('content')

<!-- ── Page Hero ────────────────────────────────────────────────── -->
<section class="catalog-hero">
    <div style="position:relative; z-index:2; max-width:800px; margin:0 auto;">
        <span class="catalog-hero-badge">
            <i class="fas fa-store" style="font-size:10px; margin-right:6px;"></i>
            Katalog Produk
        </span>
        <h1 class="catalog-hero-title">
            Katalog <span class="hero-gold">Produk Herbal</span>
        </h1>
        <div class="catalog-hero-divider"></div>
        <p class="catalog-hero-desc">
            Berbagai pilihan produk herbal berkualitas untuk mendukung kesehatan, kebugaran, dan kesejahteraan Anda setiap hari.
        </p>
    </div>
</section>

<!-- â”€â”€ Catalog Content â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ -->
<section class="catalog-content" id="catalog-content">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Search Bar -->
        <form method="GET" action="{{ route('products.index') }}" class="search-container" onsubmit="sessionStorage.setItem('scrollY', window.scrollY)">
            <div class="search-input-wrap">
                <input type="text" name="search" placeholder="Cari produk herbal..." value="{{ request('search') }}" autocomplete="off">
                @if(request('search'))
                <a href="{{ route('products.index') }}" class="btn-reset" onclick="sessionStorage.setItem('scrollY', window.scrollY)">
                    <i class="fas fa-times"></i>
                </a>
                @endif
            </div>
            <button type="submit">
                <i class="fas fa-search"></i>
                <span>Cari</span>
            </button>
        </form>

        <!-- Product Grid -->
        @if($products->isEmpty())
        <div class="empty-state">
            <i class="fas fa-search"></i>
            <h3>Produk Tidak Ditemukan</h3>
            <p>Coba gunakan kata kunci pencarian yang lain.</p>
        </div>
        @else
        <div class="product-grid">
            @foreach($products as $i => $product)
            <a href="{{ route('products.show', $product->slug) }}" class="product-card fade-up" style="transition-delay:{{ min($i, 7) * 0.06 }}s">
                <div class="product-image">
                    @if($product->images->isNotEmpty())
                    <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}">
                    @else
                    <i class="fas fa-leaf fallback-icon"></i>
                    @endif
                    @if($product->discounted_price)
                    <span class="badge-discount">-{{ $product->discount_percentage }}%</span>
                    @endif
                </div>

                <h3 class="product-name">{{ $product->name }}</h3>

                <div class="product-rating">
                    @if($product->rating)
                    <div class="stars">
                        @include('partials.product-stars', ['rating' => $product->rating])
                    </div>
                    <span class="rating-value">{{ number_format($product->rating, 1) }}</span>
                    @endif
                    @if($product->rating && $product->sales_count > 0)
                    <span class="rating-separator">Â·</span>
                    @endif
                    @if($product->sales_count > 0)
                    <span class="rating-sold">{{ $product->sales_count }}+ terjual</span>
                    @endif
                </div>

                @if($product->benefits)
                <ul class="product-benefits">
                    @foreach(array_slice($product->benefits, 0, 3) as $benefit)
                    <li>{{ $benefit }}</li>
                    @endforeach
                </ul>
                @else
                <ul class="product-benefits"><li style="color:#D4DCD6;font-size:0.7rem;">&nbsp;</li></ul>
                @endif

                <div class="product-price-wrapper">
                    <div class="product-prices">
                        @if($product->discounted_price)
                        <span class="product-price-old">{{ $product->formatted_price }}</span>
                        <span class="product-price">{{ $product->formatted_discounted_price }}</span>
                        @else
                        <span class="product-price">{{ $product->formatted_price }}</span>
                        @endif
                    </div>
                    <span class="product-arrow">
                        <i class="fas fa-arrow-right" style="font-size:14px;"></i>
                    </span>
                </div>
            </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pagination-container fade-up">
            <div class="pagination-info">
                Menampilkan {{ $products->firstItem() }}&ndash;{{ $products->lastItem() }} dari {{ $products->total() }} produk
            </div>
            <div class="pagination-numbers">
                @if($products->onFirstPage())
                <span class="nav-btn" style="opacity:0.4"><i class="fas fa-chevron-left"></i></span>
                @else
                <a href="{{ $products->previousPageUrl() }}" class="nav-btn"><i class="fas fa-chevron-left"></i></a>
                @endif

                @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                    @if($page == $products->currentPage())
                    <span class="active">{{ $page }}</span>
                    @else
                    <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if($products->hasMorePages())
                <a href="{{ $products->nextPageUrl() }}" class="nav-btn"><i class="fas fa-chevron-right"></i></a>
                @else
                <span class="nav-btn" style="opacity:0.4"><i class="fas fa-chevron-right"></i></span>
                @endif
            </div>
        </div>
        @endif
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    /* â”€â”€ Scroll Reveal â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    var revealElements = document.querySelectorAll('.fade-up');
    if (revealElements.length > 0 && 'IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0, rootMargin: '80px 0px 80px 0px' });
        revealElements.forEach(function(el) { observer.observe(el); });
    } else {
        revealElements.forEach(function(el) { el.classList.add('visible'); });
    }
    // Fallback: mark visible after 300ms if still hidden
    setTimeout(function() {
        revealElements.forEach(function(el) {
            if (!el.classList.contains('visible')) {
                el.classList.add('visible');
            }
        });
    }, 300);

    /* Scroll logic: restore position when search/filter reloads */
    var savedY = sessionStorage.getItem('scrollY');
    if (savedY !== null) {
        window.scrollTo(0, parseInt(savedY));
        sessionStorage.removeItem('scrollY');
    }
});
</script>
@endpush
