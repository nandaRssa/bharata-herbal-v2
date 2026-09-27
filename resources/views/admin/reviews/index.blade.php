@extends('layouts.admin')
@section('title','Manajemen Ulasan')
@section('page-title','Ulasan Produk')
@section('page-subtitle','Kelola semua ulasan dari pembeli')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* â”€â”€ Animations â”€â”€ */
@keyframes fadeUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
.fade-up { animation:fadeUp 0.4s ease forwards; opacity:0; }
.fade-up.d1 { animation-delay:0.06s; }
.fade-up.d2 { animation-delay:0.12s; }

/* â”€â”€ Card â”€â”€ */
.card { background:#FFFFFF; border:1px solid #E0E6E2; border-radius:16px; overflow:hidden; }

/* â”€â”€ Action bar â”€â”€ */
.action-bar {
    display:flex;
    flex-wrap:wrap;
    align-items:center;
    gap:12px;
    margin-bottom:20px;
}
.search-wrapper {
    display:flex;
    flex:1;
    min-width:200px;
    max-width:400px;
    background:#FFFFFF;
    border:2px solid #E0E6E2;
    border-radius:50px;
    overflow:hidden;
    transition:all 0.3s ease;
}
.search-wrapper:focus-within {
    border-color:#0D2618;
    box-shadow:0 0 0 4px rgba(13, 38, 24, 0.08);
}
.search-wrapper input {
    flex:1;
    padding:10px 18px;
    border:none;
    outline:none;
    font-family:'Inter',sans-serif;
    font-size:0.9rem;
    color:#0D2618;
    background:transparent;
    min-width:80px;
}
.search-wrapper input::placeholder { color:#8A9A92; }
.search-wrapper button {
    padding:10px 18px;
    background:#0D2618;
    color:#FFFFFF;
    border:none;
    font-family:'Inter',sans-serif;
    font-size:0.85rem;
    font-weight:600;
    cursor:pointer;
    transition:all 0.3s ease;
    white-space:nowrap;
}
.search-wrapper button:hover { background:#0D2618; }
.btn-add-review {
    padding:10px 24px;
    background:linear-gradient(135deg,#0D2618,#0D2618);
    color:#FFFFFF;
    border:none;
    border-radius:10px;
    font-family:'Inter',sans-serif;
    font-size:0.85rem;
    font-weight:600;
    cursor:pointer;
    transition:all 0.3s ease;
    display:inline-flex;
    align-items:center;
    gap:8px;
    text-decoration:none;
}
.btn-add-review:hover {
    transform:scale(1.02);
    box-shadow:0 8px 30px rgba(13, 38, 24, 0.2);
    color:#FFFFFF;
}
.btn-reset {
    padding:10px 20px;
    border:2px solid #E0E6E2;
    border-radius:10px;
    background:transparent;
    color:#6A7A72;
    font-family:'Inter',sans-serif;
    font-size:0.85rem;
    font-weight:600;
    cursor:pointer;
    transition:all 0.3s ease;
    text-decoration:none;
}
.btn-reset:hover { border-color:#C62828; color:#C62828; }

/* â”€â”€ Table â”€â”€ */
.table-wrap { overflow-x:auto; }
.table-rv {
    width:100%;
    border-collapse:collapse;
    font-family:'Inter',sans-serif;
    font-size:0.85rem;
}
.table-rv thead { background:#F5F0EB; }
.table-rv th {
    padding:14px 16px;
    text-align:left;
    font-weight:600;
    color:#0D2618;
    font-size:0.75rem;
    text-transform:uppercase;
    letter-spacing:0.5px;
    border-bottom:2px solid #E0E6E2;
    white-space:nowrap;
}
.table-rv td {
    padding:12px 16px;
    color:#1A1A1A;
    border-bottom:1px solid #E8ECEA;
    vertical-align:middle;
}
.table-rv tbody tr { transition:background 0.2s; }
.table-rv tbody tr:hover { background:rgba(13, 38, 24, 0.03); }

/* â”€â”€ Stars â”€â”€ */
.stars { color:#C9A227; letter-spacing:2px; white-space:nowrap; }

/* â”€â”€ Badge â”€â”€ */
.badge {
    display:inline-block;
    padding:4px 12px;
    border-radius:50px;
    font-size:0.7rem;
    font-weight:600;
    text-transform:uppercase;
    letter-spacing:0.5px;
}
.badge-green { background:rgba(46,125,50,0.12); color:#2E7D32; }
.badge-gray { background:rgba(106,122,114,0.12); color:#6A7A72; }

/* â”€â”€ Action buttons â”€â”€ */
.btn-edit {
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:6px 14px;
    background:#0D2618;
    color:#FFFFFF;
    border:none;
    border-radius:6px;
    font-family:'Inter',sans-serif;
    font-size:0.75rem;
    font-weight:600;
    cursor:pointer;
    transition:all 0.3s ease;
    text-decoration:none;
}
.btn-edit:hover { background:#0D2618; transform:scale(1.05); color:#FFFFFF; }
.btn-delete {
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:6px 14px;
    background:transparent;
    color:#C62828;
    border:2px solid rgba(198,40,40,0.25);
    border-radius:6px;
    font-family:'Inter',sans-serif;
    font-size:0.75rem;
    font-weight:600;
    cursor:pointer;
    transition:all 0.3s ease;
}
.btn-delete:hover { background:#C62828; color:#FFFFFF; border-color:#C62828; transform:scale(1.05); }

/* â”€â”€ Toggle button â”€â”€ */
.btn-toggle {
    padding:4px 12px;
    border-radius:50px;
    font-size:0.7rem;
    font-weight:600;
    text-transform:uppercase;
    letter-spacing:0.5px;
    border:none;
    cursor:pointer;
    transition:all 0.3s ease;
}
.btn-toggle.visible { background:rgba(46,125,50,0.12); color:#2E7D32; }
.btn-toggle.visible:hover { background:rgba(46,125,50,0.20); }
.btn-toggle.hidden { background:rgba(106,122,114,0.12); color:#6A7A72; }
.btn-toggle.hidden:hover { background:rgba(106,122,114,0.20); }

/* â”€â”€ Footer / Pagination â”€â”€ */
.table-footer {
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:16px 20px;
    border-top:1px solid #E0E6E2;
    background:#FAFAFA;
    flex-wrap:wrap;
    gap:12px;
}
.table-footer .info { font-family:'Inter',sans-serif; font-size:0.85rem; color:#6A7A72; }
.pagination-wrap { display:flex; gap:6px; align-items:center; }
.pagination-wrap a, .pagination-wrap span {
    width:36px; height:36px;
    display:inline-flex; align-items:center; justify-content:center;
    border:1px solid #E0E6E2; border-radius:8px;
    background:#FFFFFF; color:#0D2618;
    font-family:'Inter',sans-serif; font-weight:500;
    font-size:0.85rem; text-decoration:none; transition:all 0.3s ease;
}
.pagination-wrap a:hover { border-color:#0D2618; color:#0D2618; }
.pagination-wrap .active {
    background:linear-gradient(135deg,#0D2618,#0D2618);
    color:#FFFFFF; border-color:#0D2618;
}
.pagination-wrap .disabled { opacity:0.4; cursor:not-allowed; pointer-events:none; }

/* â”€â”€ Stars â”€â”€ */
.stars { display: inline-flex; gap: 2px; }
.star-filled { color: #F59E0B; font-size: 1.1rem; }
.star-empty { color: #D1D5DB; font-size: 1.1rem; }

/* â”€â”€ Responsive â”€â”€ */
@media (max-width:768px) {
    .action-bar { flex-direction:column; align-items:stretch; }
    .search-wrapper { max-width:100%; border-radius:12px; }
    .btn-add-review { width:100%; justify-content:center; }
    .table-rv { font-size:0.75rem; }
    .table-rv th, .table-rv td { padding:10px 12px; }
}
@media (max-width:480px) {
    .table-footer { flex-direction:column; text-align:center; }
    .pagination-wrap a, .pagination-wrap span { width:32px; height:32px; font-size:0.75rem; }
}
</style>
@endpush

@section('content')

<!-- â•â•â• HEADER â•â•â• -->
<div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:24px;">
    <div>
        <h2 style="font-family:'Plus Jakarta Sans', 'Inter', sans-serif; font-size:1.8rem; font-weight:700; color:#0D2618; margin:0;">
            Ulasan Produk
        </h2>
        <p style="font-family:'Inter',sans-serif; font-size:0.9rem; color:#6A7A72; margin:2px 0 0;">
            Kelola semua ulasan dari pembeli
        </p>
    </div>
    <a href="{{ route('home') }}" target="_blank"
       style="display:inline-flex; align-items:center; gap:8px; background:#0D2618; color:#FFFFFF; border:none; border-radius:50px; padding:10px 20px; font-family:'Inter',sans-serif; font-size:0.85rem; font-weight:600; text-decoration:none; transition:all 0.3s ease;"
       onmouseover="this.style.background='#0D2618'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(13, 38, 24, 0.2)'"
       onmouseout="this.style.background='#0D2618'; this.style.transform='none'; this.style.boxShadow='none'">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/>
            <polyline points="15 3 21 3 21 9"/>
            <line x1="10" y1="14" x2="21" y2="3"/>
        </svg>
        Lihat Website
    </a>
</div>

<!-- â•â•â• SEARCH & ADD â•â•â• -->
<div class="action-bar fade-up d1">
    <form method="GET" action="{{ route('admin.reviews.index') }}" class="search-wrapper" style="max-width:unset; flex:1;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pelanggan atau produk..." autocomplete="off">
        <button type="submit">Cari</button>
    </form>
    @if(request('search'))
    <a href="{{ route('admin.reviews.index') }}" class="btn-reset">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
        Reset
    </a>
    @endif
    <a href="{{ route('admin.reviews.create') }}" class="btn-add-review">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Tambah Ulasan Manual
    </a>
</div>

<!-- â•â•â• TABLE â•â•â• -->
<div class="card fade-up d2">
    <div class="table-wrap">
        <table class="table-rv">
            <thead>
                <tr>
                    <th>Pelanggan</th>
                    <th>Produk</th>
                    <th style="text-align:center;">Rating</th>
                    <th style="min-width:160px;">Komentar</th>
                    <th style="text-align:center;">Tanggal</th>
                    <th style="text-align:center;">Status</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                <tr>
                    <td style="font-weight:600; color:#1A1A1A; white-space:nowrap;">{{ $review->customer_name }}</td>
                    <td style="color:#6A7A72; max-width:160px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $review->product?->name ?? '-' }}</td>
                    <td style="text-align:center; white-space:nowrap;">
                        <span class="stars">{!! str_repeat('<span class="star-filled">&#9733;</span>', $review->rating) !!}{!! str_repeat('<span class="star-empty">&#9734;</span>', 5 - $review->rating) !!}</span>
                    </td>
                    <td style="color:#6A7A72; max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $review->comment ?: '-' }}</td>
                    <td style="text-align:center; font-size:0.8rem; color:#8A9A92; white-space:nowrap;">{{ $review->created_at->format('d M Y') }}</td>
                    <td style="text-align:center;">
                        <form method="POST" action="{{ route('admin.reviews.toggle', $review) }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-toggle {{ $review->is_visible ? 'visible' : 'hidden' }}">
                                {{ $review->is_visible ? 'Tampil' : 'Sembunyikan' }}
                            </button>
                        </form>
                    </td>
                    <td style="text-align:center;">
                        <div style="display:flex; gap:6px; justify-content:center; align-items:center;">
                            <a href="{{ route('admin.reviews.edit', $review) }}" class="btn-edit">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                                Edit
                            </a>
                            <form x-data method="POST" action="{{ route('admin.reviews.destroy', $review) }}" @submit.prevent="Alpine.store('modal').confirm('Hapus ulasan ini?').then(ok => ok && $el.submit())" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-delete">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"/>
                                        <path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/>
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding:60px 16px; color:#8A9A92;">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#0D2618" stroke-width="1.5" style="display:block; margin:0 auto 12px;">
                            <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        <div style="font-size:1rem; font-weight:600; color:#0D2618; margin-bottom:4px;">Belum ada ulasan</div>
                        <div style="font-size:0.85rem;">
                            @if(request('search'))
                            Ulasan tidak ditemukan. Coba kata kunci lain.
                            @else
                            Belum ada ulasan produk saat ini.
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($reviews->hasPages())
    <div class="table-footer">
        <div class="info">
            Showing {{ $reviews->firstItem() }} to {{ $reviews->lastItem() }} of {{ $reviews->total() }} results
        </div>
        <div class="pagination-wrap">
            @if($reviews->onFirstPage())
                <span class="disabled">&laquo;</span>
            @else
                <a href="{{ $reviews->previousPageUrl() }}">&laquo;</a>
            @endif
            @foreach($reviews->getUrlRange(max(1, $reviews->currentPage() - 2), min($reviews->lastPage(), $reviews->currentPage() + 2)) as $page => $url)
                <a href="{{ $url }}" class="{{ $page === $reviews->currentPage() ? 'active' : '' }}">{{ $page }}</a>
            @endforeach
            @if($reviews->hasMorePages())
                <a href="{{ $reviews->nextPageUrl() }}">&raquo;</a>
            @else
                <span class="disabled">&raquo;</span>
            @endif
        </div>
    </div>
    @endif
</div>

@endsection
