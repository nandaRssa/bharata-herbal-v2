@extends('layouts.admin')
@section('title', 'Manajemen Produk')
@section('page-title', 'Manajemen Produk')
@section('page-subtitle', 'Kelola semua produk herbal')
@section('content')
<div class="admin-produk-page">
<div class="admin-produk-container">

    {{-- ── Action Bar ── --}}
    <div class="action-bar">
        <form method="GET" action="{{ route('admin.products.index') }}" class="search-wrapper">
            <span class="search-icon-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#8A9A92" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            </span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk..." id="search-input" autocomplete="off">
            @if(request('search'))
            <a href="{{ route('admin.products.index') }}" class="search-clear-btn" title="Hapus pencarian">✕</a>
            @endif
            <button type="submit">Cari</button>
        </form>
        <a href="{{ route('admin.products.create') }}" class="btn-add-product" id="btn-add-product">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Tambah Produk
        </a>
    </div>

    {{-- ── Bulk Selection Toolbar ── --}}
    <div class="bulk-toolbar" id="bulk-bar">
        <div class="bulk-toolbar-left">
            <span class="bulk-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                <span id="bulk-count">0</span> dipilih
            </span>
            <div class="bulk-divider"></div>
            <button class="btn-bulk-subtle" id="btn-select-all" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><polyline points="9 11 12 14 22 4"/></svg>
                Pilih Semua ({{ $products->total() }})
            </button>
            <button class="btn-bulk-subtle" id="btn-deselect-all" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                Batal
            </button>
        </div>
        <div class="bulk-toolbar-right">
            <button class="btn-bulk-delete-danger" id="btn-delete-selected" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                Hapus Terpilih
            </button>
        </div>
    </div>

    {{-- Hidden bulk delete form --}}
    <form id="bulk-delete-form" method="POST" action="{{ route('admin.products.bulk-destroy') }}" style="display:none;">
        @csrf
    </form>

    {{-- ── Product Table ── --}}
    <div class="table-card">
        <div class="table-wrapper">
            <table class="table-product">
                <thead>
                    <tr>
                        <th style="width:44px; text-align:center;">
                            <input type="checkbox" id="check-all" title="Pilih semua">
                        </th>
                        <th>Produk</th>
                        <th>Harga Jual</th>
                        <th>Diskon</th>
                        <th>Sisa Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td style="text-align:center; padding:0 12px;">
                            <label class="custom-chk">
                                <input type="checkbox" class="product-item-check" value="{{ $product->id }}">
                                <span class="chk-box"></span>
                            </label>
                        </td>
                        <td>
                            <div style="display:flex; align-items:center; gap:12px;">
                                @if($product->images->isNotEmpty())
                                    <img class="product-thumb" src="{{ asset('storage/' . ($product->images->where('is_primary',true)->first() ?? $product->images->first())->image_path) }}" alt="{{ $product->name }}">
                                @else
                                    <div class="product-thumb-placeholder">🌿</div>
                                @endif
                                <div class="product-cell">
                                    <p class="pname">{{ $product->name }}</p>
                                    <p class="pslug">{{ $product->slug }}</p>
                                </div>
                            </div>
                        </td>
                        <td style="font-weight:700; color:#0D2618;">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>
                            @if($product->is_discount_active && $product->discounted_price)
                                <span class="discount-badge">-{{ $product->discount_percentage }}%</span>
                            @else
                                <span class="discount-badge-none">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="stock-text
                                @if($product->stock < 10) low
                                @elseif($product->stock < 20) medium
                                @else high @endif">
                                {{ $product->stock }} unit
                            </span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.products.toggle', $product) }}">
                                @csrf
                                <button type="submit" class="status-badge {{ $product->is_active ? 'active' : 'inactive' }}">
                                    <span class="dot"></span>{{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <div class="action-cell">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn-action-edit">Edit</a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Hapus produk {{ addslashes($product->name) }}?')">
                                    @csrf @method('DELETE')
                                    <button class="btn-action-delete">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="empty-state">
                            <div class="empty-icon">🌿</div>
                            <p style="font-weight:600; color:#0D2618; margin:8px 0 4px;">Belum ada produk terdaftar.</p>
                            <a href="{{ route('admin.products.create') }}" style="color:#0D2618; font-weight:700;">Tambah produk sekarang →</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ── Pagination ── --}}
        @if($products->hasPages())
        <div class="table-footer">
            <p class="info">
                Menampilkan {{ $products->firstItem() }}–{{ $products->lastItem() }} dari {{ $products->total() }} produk
            </p>
            <div class="pagination">
                @if($products->onFirstPage())
                    <span class="disabled">‹</span>
                @else
                    <a href="{{ $products->previousPageUrl() }}">‹</a>
                @endif

                @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                    @if($page == $products->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}">›</a>
                @else
                    <span class="disabled">›</span>
                @endif
            </div>
        </div>
        @endif
    </div>{{-- .table-card --}}

</div>
</div>
@endsection


@push('styles')

<style>
/* â”€â”€â”€ Premium Admin Product Management â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
.admin-produk-page {
    background: linear-gradient(180deg, #F5F0EB 0%, #EDE8E0 100%);
    min-height: 100vh;
    padding: 30px 24px;
    margin: -24px -28px;
}
.admin-produk-container {
    max-width: 1400px;
    margin: 0 auto;
}

/* â”€â”€â”€ Animations â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes statusPulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}
.fade-up {
    animation: fadeUp 0.6s ease forwards;
    opacity: 0;
}
.fade-up-1 { animation-delay: 0.1s; }
.fade-up-2 { animation-delay: 0.2s; }
.fade-up-3 { animation-delay: 0.3s; }

/* â”€â”€â”€ Action Bar / Search â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
.action-bar {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
}
.search-wrapper {
    display: flex;
    align-items: center;
    flex: 1;
    min-width: 200px;
    max-width: 420px;
    background: #FFFFFF;
    border: 2px solid #E0E6E2;
    border-radius: 50px;
    overflow: hidden;
    transition: all 0.3s ease;
}
.search-wrapper:focus-within {
    border-color: #0D2618;
    box-shadow: 0 0 0 4px rgba(13, 38, 24, 0.08);
}
.search-icon-wrap {
    display: flex;
    align-items: center;
    padding-left: 16px;
    flex-shrink: 0;
}
.search-wrapper input {
    flex: 1;
    padding: 10px 12px;
    border: none;
    outline: none;
    font-family: 'Inter', sans-serif;
    font-size: 0.9rem;
    color: #0D2618;
    background: transparent;
    min-width: 120px;
}
.search-wrapper input::placeholder { color: #8A9A92; }
.search-clear-btn {
    padding: 6px 12px;
    color: #8A9A92;
    text-decoration: none;
    font-size: 0.9rem;
    line-height: 1;
    flex-shrink: 0;
}
.search-clear-btn:hover { color: #0D2618; }
.search-wrapper button {
    padding: 10px 22px;
    background: #0D2618;
    color: #FFFFFF;
    border: none;
    font-family: 'Inter', sans-serif;
    font-size: 0.82rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s ease;
    white-space: nowrap;
    flex-shrink: 0;
}
.search-wrapper button:hover { background: #1a3d28; }

.btn-add-product {
    background: linear-gradient(135deg, #0D2618, #0D2618);
    color: #FFFFFF;
    padding: 10px 24px;
    border-radius: 50px;
    border: none;
    font-weight: 600;
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
    text-decoration: none;
}
.btn-add-product:hover {
    transform: scale(1.02);
    box-shadow: 0 8px 30px rgba(13, 38, 24, 0.2);
    text-decoration: none;
    color: #FFFFFF;
}

/* â”€â”€â”€ Premium Table â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
.table-card {
    background: #FFFFFF;
    border: 1px solid #E0E6E2;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.02);
}
.table-wrapper {
    overflow-x: auto;
    padding: 0 4px;
}
.table-product {
    width: 100%;
    border-collapse: collapse;
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
}
.table-product thead { background: #F5F0EB; }
.table-product th {
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
.table-product td {
    padding: 12px 16px;
    color: #1A1A1A;
    border-bottom: 1px solid #E8ECEA;
    vertical-align: middle;
}
.table-product tbody tr { transition: background 0.2s ease; }
.table-product tbody tr:hover { background: rgba(13, 38, 24, 0.03); }

/* Product cell */
.product-cell {
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.product-cell .pname {
    font-weight: 600;
    color: #0D2618;
    font-size: 0.9rem;
    font-family: 'Inter', sans-serif;
}
.product-cell .pslug {
    font-size: 0.7rem;
    color: #8A9A92;
    font-family: 'Inter', sans-serif;
}
.product-thumb {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    object-fit: cover;
    border: 1px solid #F0F2F0;
    flex-shrink: 0;
}
.product-thumb-placeholder {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: #F5F0EB;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border: 1px solid #F0F2F0;
}

/* Discount badge */
.discount-badge {
    display: inline-block;
    padding: 2px 10px;
    border-radius: 50px;
    font-size: 0.7rem;
    font-weight: 700;
    background: linear-gradient(135deg, #0D2618, #0D2618);
    color: #FFFFFF;
}
.discount-badge-none {
    display: inline-block;
    padding: 2px 10px;
    border-radius: 50px;
    font-size: 0.7rem;
    font-weight: 600;
    background: #E0E6E2;
    color: #5A6A62;
}

/* Status badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px;
    border-radius: 50px;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    font-family: 'Inter', sans-serif;
}
.status-badge .dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    display: inline-block;
}
.status-badge.active {
    background: rgba(46, 125, 50, 0.12);
    color: #2E7D32;
}
.status-badge.active .dot {
    background: #2E7D32;
    animation: statusPulse 2s ease-in-out infinite;
}
.status-badge.inactive {
    background: rgba(198, 40, 40, 0.12);
    color: #C62828;
}
.status-badge.inactive .dot {
    background: #C62828;
}

/* Stock */
.stock-text {
    font-weight: 600;
    font-size: 0.85rem;
}
.stock-text.high { color: #2E7D32; }
.stock-text.medium { color: #F57F17; }
.stock-text.low { color: #C62828; }

/* Action buttons */
.action-cell {
    display: flex;
    gap: 8px;
    align-items: center;
}
.btn-action-edit {
    padding: 6px 14px;
    background: #0D2618;
    color: #FFFFFF;
    border: none;
    border-radius: 6px;
    font-family: 'Inter', sans-serif;
    font-size: 0.7rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    text-decoration: none;
}
.btn-action-edit:hover {
    background: #0D2618;
    transform: scale(1.05);
    color: #FFFFFF;
    text-decoration: none;
}
.btn-action-delete {
    padding: 6px 14px;
    background: transparent;
    color: #C62828;
    border: 1px solid #C62828;
    border-radius: 6px;
    font-family: 'Inter', sans-serif;
    font-size: 0.7rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.btn-action-delete:hover {
    background: #C62828;
    color: #FFFFFF;
    transform: scale(1.05);
}

/* â”€â”€â”€ Pagination / Table Footer â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
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
.pagination {
    display: flex;
    gap: 6px;
    align-items: center;
}
.pagination a,
.pagination span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border: 1px solid #E0E6E2;
    border-radius: 8px;
    background: #FFFFFF;
    color: #0D2618;
    font-family: 'Inter', sans-serif;
    font-weight: 500;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}
.pagination a:hover {
    border-color: #0D2618;
    color: #0D2618;
    background: #F0F5F1;
    text-decoration: none;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(13, 38, 24, 0.1);
}
.pagination .active {
    background: linear-gradient(135deg, #0D2618, #0D2618);
    color: #FFFFFF;
    border-color: #0D2618;
}
.pagination .disabled {
    opacity: 1;
    cursor: not-allowed;
    pointer-events: none;
    border-color: #D4DCD6;
    color: #A0AFA7;
    background: #F5F7F5;
}

/* â”€â”€â”€ Empty State â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
.empty-state {
    padding: 60px 20px;
    text-align: center;
}
.empty-icon {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    background: #F5F0EB;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
}

/* â”€â”€â”€ Responsive â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
@media (max-width: 768px) {
    .admin-produk-page {
        margin: -24px -16px;
        padding: 16px;
    }
    .action-bar {
        flex-direction: column;
        align-items: stretch;
    }
    .search-wrapper {
        max-width: 100%;
        border-radius: 12px;
    }
    .search-wrapper input { padding: 12px 16px; }
    .btn-add-product {
        width: 100%;
        justify-content: center;
        padding: 12px;
    }
    .table-product { font-size: 0.75rem; }
    .table-product th,
    .table-product td {
        padding: 10px 12px;
        white-space: nowrap;
    }
    .product-cell .pslug { font-size: 0.6rem; }
    .product-thumb { width: 32px; height: 32px; }
    .btn-action-edit,
    .btn-action-delete { padding: 4px 10px; font-size: 0.65rem; }
    .table-footer {
        flex-direction: column;
        gap: 12px;
        text-align: center;
    }
    .pagination a,
    .pagination span {
        width: 32px;
        height: 32px;
        font-size: 0.75rem;
    }
    .table-wrapper {
        -webkit-overflow-scrolling: touch;
    }
    .table-wrapper::-webkit-scrollbar {
        height: 6px;
    }
    .table-wrapper::-webkit-scrollbar-track {
        background: #F0F2F0;
        border-radius: 3px;
    }
    .table-wrapper::-webkit-scrollbar-thumb {
        background: #C8D0CB;
        border-radius: 3px;
    }
    .table-wrapper::-webkit-scrollbar-thumb:hover {
        background: #8A9A92;
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .admin-produk-page {
        margin: -24px -20px;
        padding: 24px 20px;
    }
}

/* ─── Harmonious Bulk Selection Toolbar ─────────── */
.bulk-toolbar {
    display: none;
    background: #FFFFFF;
    border: 1px solid #D6E2DB;
    border-left: 4px solid #0D2618;
    border-radius: 14px;
    padding: 10px 18px;
    margin-bottom: 18px;
    box-shadow: 0 4px 16px rgba(13, 38, 24, 0.05);
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    animation: bulkSlideDown 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}
.bulk-toolbar.active {
    display: flex;
}
@keyframes bulkSlideDown {
    from { opacity: 0; transform: translateY(-8px); }
    to   { opacity: 1; transform: translateY(0); }
}
.bulk-toolbar-left {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}
.bulk-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #0D2618;
    color: #FFFFFF;
    font-family: 'Inter', sans-serif;
    font-size: 0.82rem;
    font-weight: 600;
    padding: 6px 14px;
    border-radius: 50px;
}
.bulk-badge i {
    color: #A8DDBF;
    font-size: 0.85rem;
}
.bulk-divider {
    width: 1px;
    height: 22px;
    background: #E2E8F0;
}
.btn-bulk-subtle {
    background: #F8FAF7;
    border: 1px solid #DDE5E0;
    color: #475569;
    font-family: 'Inter', sans-serif;
    font-size: 0.82rem;
    font-weight: 600;
    padding: 6px 14px;
    border-radius: 8px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
}
.btn-bulk-subtle:hover {
    background: #FFFFFF;
    color: #0D2618;
    border-color: #0D2618;
}
.bulk-toolbar-right {
    display: flex;
    align-items: center;
}
.btn-bulk-delete-danger {
    background: #FFF1F2;
    color: #E11D48;
    border: 1px solid #FECDD3;
    font-family: 'Inter', sans-serif;
    font-size: 0.82rem;
    font-weight: 700;
    padding: 7px 18px;
    border-radius: 50px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
}
.btn-bulk-delete-danger:hover {
    background: #E11D48;
    color: #FFFFFF;
    border-color: #E11D48;
    box-shadow: 0 4px 14px rgba(225, 29, 72, 0.25);
    transform: translateY(-1px);
}

/* Custom Checkbox */
.custom-chk {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    margin: 0;
    position: relative;
    width: 20px;
    height: 20px;
}
.custom-chk input {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
    margin: 0;
}
.custom-chk .chk-box {
    width: 18px;
    height: 18px;
    border: 2px solid #C4D1C9;
    border-radius: 5px;
    background: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}
.custom-chk:hover .chk-box {
    border-color: #0D2618;
    box-shadow: 0 0 0 3px rgba(13, 38, 24, 0.08);
}
.custom-chk input:checked ~ .chk-box {
    background: #0D2618;
    border-color: #0D2618;
}
.custom-chk input:checked ~ .chk-box::after {
    content: '';
    width: 4px;
    height: 8px;
    border: solid #FFFFFF;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg) translate(-1px, -1px);
    display: block;
}
.custom-chk input:indeterminate ~ .chk-box {
    background: #0D2618;
    border-color: #0D2618;
}
.custom-chk input:indeterminate ~ .chk-box::after {
    content: '';
    width: 8px;
    height: 2px;
    background: #FFFFFF;
    border: none;
    transform: none;
    display: block;
}
.table-product tbody tr.is-selected {
    background-color: #F2F8F4 !important;
}
.table-product tbody tr.is-selected td {
    border-bottom-color: #D6E8DE;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkAll          = document.getElementById('check-all');
    const itemChecks        = document.querySelectorAll('.product-item-check');
    const bulkBar           = document.getElementById('bulk-bar');
    const bulkCount         = document.getElementById('bulk-count');
    const btnSelectAll      = document.getElementById('btn-select-all');
    const btnDeselectAll    = document.getElementById('btn-deselect-all');
    const btnDeleteSelected = document.getElementById('btn-delete-selected');
    const bulkForm          = document.getElementById('bulk-delete-form');

    /* ── Row highlight ── */
    function syncRowHighlight(cb) {
        const tr = cb.closest('tr');
        if (tr) tr.classList.toggle('is-selected', cb.checked);
    }

    /* ── Update toolbar & header checkbox ── */
    function updateBulkBar() {
        const checked = document.querySelectorAll('.product-item-check:checked');
        const count   = checked.length;
        itemChecks.forEach(syncRowHighlight);
        if (count > 0) {
            bulkBar.classList.add('active');
            bulkCount.textContent = count;
        } else {
            bulkBar.classList.remove('active');
        }
        if (checkAll) {
            checkAll.checked       = (count === itemChecks.length && itemChecks.length > 0);
            checkAll.indeterminate = (count > 0 && count < itemChecks.length);
        }
    }

    /* ── Header checkbox ── */
    if (checkAll) {
        checkAll.addEventListener('change', function() {
            itemChecks.forEach(cb => { cb.checked = checkAll.checked; });
            updateBulkBar();
        });
    }

    itemChecks.forEach(cb => cb.addEventListener('change', updateBulkBar));

    /* ── Toolbar buttons ── */
    if (btnSelectAll) {
        btnSelectAll.addEventListener('click', function() {
            itemChecks.forEach(cb => { cb.checked = true; });
            updateBulkBar();
        });
    }
    if (btnDeselectAll) {
        btnDeselectAll.addEventListener('click', function() {
            itemChecks.forEach(cb => { cb.checked = false; });
            if (checkAll) { checkAll.checked = false; checkAll.indeterminate = false; }
            updateBulkBar();
        });
    }

    /* ────────────────────────────────────────────────
       DRAG-TO-SELECT
       Klik + seret pada kolom checkbox untuk sweep.
       Threshold 6px mencegah klik biasa menyentuh baris lain.
    ──────────────────────────────────────────────── */
    let isDragging    = false;  // true = threshold terlewati, sweep aktif
    let isDragPending = false;  // true = mousedown di kolom checkbox
    let dragIntent    = null;   // true = centang, false = hapus centang
    let lastTouched   = null;   // baris terakhir saat sweep
    let dragOriginX   = 0;
    let dragOriginY   = 0;
    const DRAG_THRESHOLD = 6;

    /* Scroll vars - deklarasi lebih awal agar tersedia di mousemove */
    const SCROLL_ZONE = 80;
    const SCROLL_MAX  = 16;
    let scrollRafId   = null;
    let scrollSpeed   = 0;

    function getCbFromRow(row) {
        return row ? row.querySelector('.product-item-check') : null;
    }

    function getRowFromTarget(el) {
        const td = el.closest('td');
        if (!td) return null;
        const tr = td.closest('tr');
        if (!tr || !tr.closest('tbody')) return null;
        const cells = Array.from(tr.querySelectorAll('td'));
        if (cells.indexOf(td) !== 0) return null; // hanya kolom checkbox
        return tr;
    }

    /* Blokir click pada label baris agar tidak double-toggle */
    document.querySelectorAll('tbody .custom-chk').forEach(function(label) {
        label.addEventListener('click', function(e) { e.preventDefault(); });
    });

    /* Cursor pointer di sel checkbox */
    itemChecks.forEach(cb => {
        const td = cb.closest('td');
        if (td) td.style.cursor = 'pointer';
    });

    document.addEventListener('mousedown', function(e) {
        const row = getRowFromTarget(e.target);
        if (!row) return;
        const cb = getCbFromRow(row);
        if (!cb) return;

        dragIntent    = !cb.checked;
        isDragPending = true;
        isDragging    = false;
        lastTouched   = row;
        dragOriginX   = e.clientX;
        dragOriginY   = e.clientY;

        cb.checked = dragIntent;
        syncRowHighlight(cb);
        updateBulkBar();
        e.preventDefault();
    });

    document.addEventListener('mousemove', function(e) {
        /* Aktifkan sweep setelah melewati threshold */
        if (isDragPending && !isDragging) {
            const dx = Math.abs(e.clientX - dragOriginX);
            const dy = Math.abs(e.clientY - dragOriginY);
            if (dx > DRAG_THRESHOLD || dy > DRAG_THRESHOLD) {
                isDragging = true;
            }
        }

        /* Auto-scroll saat mendekati tepi viewport */
        if (!isDragging) { stopAutoScroll(); return; }
        const y     = e.clientY;
        const viewH = window.innerHeight;
        let newSpeed = 0;
        if (y < SCROLL_ZONE) {
            newSpeed = -Math.round((1 - y / SCROLL_ZONE) * SCROLL_MAX);
        } else if (y > viewH - SCROLL_ZONE) {
            newSpeed = Math.round(((y - (viewH - SCROLL_ZONE)) / SCROLL_ZONE) * SCROLL_MAX);
        }
        scrollSpeed = newSpeed;
        if (newSpeed !== 0 && !scrollRafId) {
            scrollRafId = requestAnimationFrame(autoScrollLoop);
        } else if (newSpeed === 0) {
            stopAutoScroll();
        }
    });

    document.addEventListener('mouseover', function(e) {
        if (!isDragging) return;
        const row = getRowFromTarget(e.target);
        if (!row || row === lastTouched) return;
        lastTouched = row;
        const cb = getCbFromRow(row);
        if (!cb) return;
        cb.checked = dragIntent;
        syncRowHighlight(cb);
        updateBulkBar();
    });

    document.addEventListener('mouseup', function() {
        isDragPending = false;
        isDragging    = false;
        dragIntent    = null;
        lastTouched   = null;
        stopAutoScroll();
    });

    window.addEventListener('blur', function() {
        isDragPending = false;
        isDragging    = false;
        stopAutoScroll();
    });

    function autoScrollLoop() {
        if (!isDragging || scrollSpeed === 0) { scrollRafId = null; return; }
        window.scrollBy(0, scrollSpeed);
        scrollRafId = requestAnimationFrame(autoScrollLoop);
    }

    function stopAutoScroll() {
        scrollSpeed = 0;
        if (scrollRafId) { cancelAnimationFrame(scrollRafId); scrollRafId = null; }
    }

    /* ── Hapus terpilih ── */
    if (btnDeleteSelected) {
        btnDeleteSelected.addEventListener('click', function() {
            const checked = document.querySelectorAll('.product-item-check:checked');
            if (checked.length === 0) return;
            const msg = 'Hapus ' + checked.length + ' produk terpilih secara permanen? Semua foto produk terkait juga akan dihapus.';
            if (window.Alpine && Alpine.store('modal')) {
                Alpine.store('modal').confirm(msg).then(ok => { if (ok) submitBulk(); });
            } else if (confirm(msg)) {
                submitBulk();
            }
        });
    }

    function submitBulk() {
        bulkForm.querySelectorAll('input[name="product_ids[]"]').forEach(el => el.remove());
        document.querySelectorAll('.product-item-check:checked').forEach(cb => {
            const h = document.createElement('input');
            h.type  = 'hidden';
            h.name  = 'product_ids[]';
            h.value = cb.value;
            bulkForm.appendChild(h);
        });
        bulkForm.submit();
    }
});
</script>
@endpush
