@extends('layouts.admin')
@section('title', 'Manajemen Stok')
@section('page-title', 'Manajemen Stok')
@section('page-subtitle', 'Update stok produk dan catat perubahan')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* â”€â”€ Animations â”€â”€ */
@keyframes fadeUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
.fade-up { animation:fadeUp 0.45s ease forwards; opacity:0; }
.fade-up.d1 { animation-delay:0.06s; }
.fade-up.d2 { animation-delay:0.12s; }
.fade-up.d3 { animation-delay:0.18s; }

/* â”€â”€ Filter â”€â”€ */
.filter-stock {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 20px;
}
.btn-filter-stock {
    padding: 8px 20px;
    border-radius: 50px;
    border: 2px solid #E0E6E2;
    background: transparent;
    font-family: 'Inter', sans-serif;
    font-size: 0.8rem;
    font-weight: 600;
    color: #6A7A72;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-filter-stock:hover {
    border-color: #0D2618;
    color: #0D2618;
}
.btn-filter-stock.active {
    border-color: #0D2618;
    background: rgba(13, 38, 24, 0.08);
    color: #0D2618;
}
.btn-filter-stock.critical { border-color: #C62828; color: #C62828; }
.btn-filter-stock.critical.active { background:rgba(198,40,40,0.08); border-color:#C62828; color:#C62828; }
.btn-filter-stock.low { border-color: #F57F17; color: #F57F17; }
.btn-filter-stock.low.active { background:rgba(245,127,23,0.08); border-color:#F57F17; color:#F57F17; }
.btn-filter-stock.safe { border-color: #2E7D32; color: #2E7D32; }
.btn-filter-stock.safe.active { background:rgba(46,125,50,0.08); border-color:#2E7D32; color:#2E7D32; }
.btn-filter-stock .dot { width:8px; height:8px; border-radius:50%; display:inline-block; }

/* â”€â”€ Card â”€â”€ */
.card {
    background: #FFFFFF;
    border: 1px solid #E0E6E2;
    border-radius: 16px;
    overflow: hidden;
}

/* â”€â”€ Table â”€â”€ */
.table-wrap { overflow-x: auto; }
.table-stock {
    width: 100%;
    border-collapse: collapse;
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
}
.table-stock thead { background: #F5F0EB; }
.table-stock th {
    padding: 14px 16px;
    text-align: left;
    font-weight: 600;
    color: #0D2618;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #E0E6E2;
    white-space: nowrap;
}
.table-stock td {
    padding: 12px 16px;
    color: #1A1A1A;
    border-bottom: 1px solid #E8ECEA;
    vertical-align: middle;
}
.table-stock tbody tr { transition: background 0.2s; }
.table-stock tbody tr:hover { background: rgba(13, 38, 24, 0.03); }

/* â”€â”€ Product cell â”€â”€ */
.product-cell { display:flex; flex-direction:column; gap:2px; }
.product-cell .name { font-weight:600; color:#0D2618; font-size:0.9rem; }
.product-cell .slug { font-size:0.7rem; color:#8A9A92; }

/* â”€â”€ Stock badge â”€â”€ */
.stock-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 50px;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.stock-badge.critical { background:rgba(198,40,40,0.12); color:#C62828; }
.stock-badge.low { background:rgba(245,127,23,0.12); color:#F57F17; }
.stock-badge.safe { background:rgba(46,125,50,0.12); color:#2E7D32; }

/* â”€â”€ Stock number â”€â”€ */
.stock-number { font-size:1.6rem; font-weight:700; line-height:1; }
.stock-number.critical { color:#C62828; }
.stock-number.low { color:#F57F17; }
.stock-number.safe { color:#2E7D32; }
.stock-unit { font-size:0.7rem; color:#8A9A92; display:block; margin-top:2px; }

/* â”€â”€ Update form â”€â”€ */
.stock-form { display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
.stock-form input[type="number"] {
    width: 70px;
    padding: 6px 10px;
    border: 2px solid #E0E6E2;
    border-radius: 8px;
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    color: #0D2618;
    text-align: center;
    transition: all 0.3s ease;
    outline: none;
}
.stock-form input[type="number"]:focus {
    border-color: #0D2618;
    box-shadow: 0 0 0 4px rgba(13, 38, 24, 0.08);
}
.stock-form input[type="text"] {
    flex: 1;
    min-width: 140px;
    padding: 6px 12px;
    border: 2px solid #E0E6E2;
    border-radius: 8px;
    font-family: 'Inter', sans-serif;
    font-size: 0.8rem;
    color: #6A7A72;
    transition: all 0.3s ease;
    outline: none;
}
.stock-form input[type="text"]:focus {
    border-color: #0D2618;
    box-shadow: 0 0 0 4px rgba(13, 38, 24, 0.08);
}
.stock-form input[type="text"]::placeholder {
    color: #8A9A92;
    font-style: italic;
}
.btn-update {
    padding: 6px 16px;
    background: #0D2618;
    color: #FFFFFF;
    border: none;
    border-radius: 8px;
    font-family: 'Inter', sans-serif;
    font-size: 0.75rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-update:hover {
    background: #0D2618;
    transform: scale(1.03);
}

/* â”€â”€ Footer / Pagination â”€â”€ */
.table-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    border-top: 1px solid #E0E6E2;
    background: #FAFAFA;
    border-radius: 0 0 16px 16px;
    flex-wrap: wrap;
    gap: 12px;
}
.table-footer .info {
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    color: #6A7A72;
}
.pagination-wrap { display:flex; gap:6px; align-items:center; }
.pagination-wrap a,
.pagination-wrap span {
    width: 36px; height: 36px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #E0E6E2;
    border-radius: 8px;
    background: #FFFFFF;
    color: #0D2618;
    font-family: 'Inter', sans-serif;
    font-weight: 500;
    font-size: 0.85rem;
    text-decoration: none;
    transition: all 0.3s ease;
}
.pagination-wrap a:hover {
    border-color: #0D2618;
    color: #0D2618;
}
.pagination-wrap .active {
    background: linear-gradient(135deg, #0D2618, #0D2618);
    color: #FFFFFF;
    border-color: #0D2618;
}
.pagination-wrap .disabled {
    opacity: 0.4;
    cursor: not-allowed;
    pointer-events: none;
}

/* â”€â”€ Lihat Website button â”€â”€ */
.btn-website {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #0D2618;
    color: #FFFFFF;
    border: none;
    border-radius: 50px;
    padding: 10px 20px;
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}
.btn-website:hover {
    background: #0D2618;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(13, 38, 24, 0.2);
    color: #FFFFFF;
}
.btn-website svg { transition: transform 0.3s; }
.btn-website:hover svg { transform: translate(2px,-2px); }

/* â”€â”€ Responsive â”€â”€ */
@media (max-width: 1024px) {
    .stock-form { flex-direction:column; align-items:stretch; gap:6px; }
    .stock-form input[type="number"] { width:100%; }
    .stock-form input[type="text"] { min-width:unset; }
    .btn-update { width:100%; justify-content:center; }
}
@media (max-width: 768px) {
    .table-stock { font-size:0.75rem; }
    .table-stock th,
    .table-stock td { padding:10px 12px; white-space:nowrap; }
}
@media (max-width: 480px) {
    .table-footer { flex-direction:column; gap:12px; text-align:center; }
    .pagination-wrap a,
    .pagination-wrap span { width:32px; height:32px; font-size:0.75rem; }
}
</style>
@endpush

@section('content')

<!-- â•â•â• HEADER â•â•â• -->
<div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:24px;">
    <div>
        <h2 style="font-family:'Plus Jakarta Sans', 'Inter', sans-serif; font-size:1.8rem; font-weight:700; color:#0D2618; margin:0;">
            Manajemen Stok
        </h2>
        <p style="font-family:'Inter',sans-serif; font-size:0.9rem; color:#6A7A72; margin:2px 0 0;">
            Update stok produk dan catat perubahan
        </p>
    </div>
    <a href="{{ route('home') }}" target="_blank" class="btn-website">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/>
            <polyline points="15 3 21 3 21 9"/>
            <line x1="10" y1="14" x2="21" y2="3"/>
        </svg>
        Lihat Website
    </a>
</div>

<!-- â•â•â• FILTER â•â•â• -->
<div class="filter-stock fade-up d1">
    <a href="{{ route('admin.stock.index') }}"
       class="btn-filter-stock {{ !request('filter') ? 'active' : '' }}">
        Semua
    </a>
    <a href="{{ route('admin.stock.index', ['filter' => 'critical']) }}"
       class="btn-filter-stock critical {{ request('filter') === 'critical' ? 'active' : '' }}">
        <span class="dot" style="background:#C62828;"></span>
        Kritis (&lt;10)
    </a>
    <a href="{{ route('admin.stock.index', ['filter' => 'low']) }}"
       class="btn-filter-stock low {{ request('filter') === 'low' ? 'active' : '' }}">
        <span class="dot" style="background:#F57F17;"></span>
        Rendah (&lt;20)
    </a>
    <a href="{{ route('admin.stock.index', ['filter' => 'safe']) }}"
       class="btn-filter-stock safe {{ request('filter') === 'safe' ? 'active' : '' }}">
        <span class="dot" style="background:#2E7D32;"></span>
        Aman (&ge;20)
    </a>
</div>

<!-- â•â•â• TABLE â•â•â• -->
<div class="card fade-up d2">
    <div class="table-wrap">
        <table class="table-stock">
            <thead>
                <tr>
                    <th style="width:40px;">No</th>
                    <th>Produk</th>
                    <th>Kategori</th>
                    <th style="text-align:center;">Stok Saat Ini</th>
                    <th style="min-width:300px;">Update Stok</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $i => $product)
                @php
                    $stockClass = $product->stock < 10 ? 'critical' : ($product->stock < 20 ? 'low' : 'safe');
                @endphp
                <tr>
                    <td style="color:#8A9A92; font-weight:500; font-size:0.8rem;">
                        {{ $products->firstItem() + $i }}
                    </td>
                    <td>
                        <div class="product-cell">
                            <span class="name">{{ $product->name }}</span>
                            <span class="slug">{{ $product->slug }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="stock-badge {{ $stockClass }}">
                            {{ $stockClass === 'critical' ? 'Kritis' : ($stockClass === 'low' ? 'Rendah' : 'Aman') }}
                        </span>
                    </td>
                    <td style="text-align:center;">
                        <div class="stock-number {{ $stockClass }}">{{ $product->stock }}</div>
                        <span class="stock-unit">unit</span>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.stock.update', $product) }}" class="stock-form">
                            @csrf @method('PUT')
                            <input type="number" name="new_stock" value="{{ $product->stock }}" min="0" step="1" inputmode="numeric" pattern="[0-9]+">
                            <input type="text" name="note" placeholder="Keterangan opsional..." value="">
                            <button type="submit" class="btn-update">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                                Update
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @if($products->isEmpty())
                <tr>
                    <td colspan="5" style="text-align:center; padding:60px 16px; color:#8A9A92;">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#0D2618" stroke-width="1.5" style="display:block; margin:0 auto 12px;">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                            <rect x="9" y="3" width="6" height="4" rx="1"/>
                        </svg>
                        <div style="font-size:1rem; font-weight:600; color:#0D2618; margin-bottom:4px;">Tidak ada produk</div>
                        <div style="font-size:0.85rem;">Produk dengan stok {{ request('filter') === 'critical' ? 'kritis' : (request('filter') === 'low' ? 'rendah' : 'tersedia') }} tidak ditemukan</div>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
    <div class="table-footer">
        <div class="info">
            Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results
        </div>
        <div class="pagination-wrap">
            @if($products->onFirstPage())
                <span class="disabled">&laquo;</span>
            @else
                <a href="{{ $products->previousPageUrl() }}">&laquo;</a>
            @endif

            @foreach($products->getUrlRange(max(1, $products->currentPage() - 2), min($products->lastPage(), $products->currentPage() + 2)) as $page => $url)
                <a href="{{ $url }}" class="{{ $page === $products->currentPage() ? 'active' : '' }}">{{ $page }}</a>
            @endforeach

            @if($products->hasMorePages())
                <a href="{{ $products->nextPageUrl() }}">&raquo;</a>
            @else
                <span class="disabled">&raquo;</span>
            @endif
        </div>
    </div>
    @endif
</div>

@endsection
