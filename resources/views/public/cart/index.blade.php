@extends('layouts.public')
@section('title', 'Keranjang Belanja')

@section('content')
<!-- Breadcrumb -->
<div class="bg-white border-b border-slate-100 px-4 py-2.5">
    <nav class="max-w-7xl mx-auto text-xs font-medium text-slate-400 flex items-center gap-1.5">
        <a href="{{ route('home') }}" class="hover:text-[#0D2618] transition duration-150">Beranda</a>
        <span class="text-[#0D2618] font-semibold">/</span>
        <span class="text-slate-600 font-semibold">Keranjang Belanja</span>
    </nav>
</div>

<!-- Cart Page Header -->
<div class="relative overflow-hidden bg-white pt-10 pb-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold mb-5 tracking-wider"
             style="background: rgba(13, 38, 24, 0.12); color: #0D2618; border: 1px solid rgba(13, 38, 24, 0.2);">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            Shopping Cart
        </div>
        <h1 class="font-serif font-bold text-slate-900 leading-tight mb-3 gold-shimmer"
            style="font-size: clamp(2rem, 3.5vw, 2.8rem);">
            Keranjang Belanja Anda
        </h1>
        <p class="text-base text-slate-500 max-w-xl mx-auto leading-relaxed">
            Tinjau kembali pilihan produk herbal Anda sebelum melakukan pengisian formulir pemesanan.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16" x-data="cartPage">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10" x-show="items.length > 0">
        <!-- Left: Cart Items -->
        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100/80 overflow-hidden">
                <!-- Desktop Header -->
                <div class="hidden md:grid grid-cols-12 gap-4 px-6 py-4 border-b text-xs font-bold uppercase tracking-widest"
                     style="border-bottom: 2px solid #0D2618; color: #6A7A72;">
                    <div class="col-span-5">Produk</div>
                    <div class="col-span-2 text-center">Harga</div>
                    <div class="col-span-2 text-center">Jumlah</div>
                    <div class="col-span-3 text-right">Subtotal</div>
                </div>

                <div class="divide-y divide-gray-100">
                    <template x-for="item in items" :key="item.id">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 p-6 items-center">
                            <!-- Info Produk -->
                            <div class="col-span-1 md:col-span-5 flex items-center gap-4">
                                <div class="w-20 h-20 rounded-2xl bg-slate-50 overflow-hidden flex-shrink-0 border border-slate-100">
                                    <template x-if="item.image_path">
                                        <img :src="'{{ asset('storage/') }}/' + item.image_path" :alt="item.name" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!item.image_path">
                                        <div class="w-full h-full flex items-center justify-center opacity-20">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                                        </div>
                                    </template>
                                </div>
                                <div class="space-y-1">
                                    <a :href="'/produk/' + item.slug" class="font-bold text-base text-slate-800 hover:text-[#0D2618] transition duration-150" x-text="item.name"></a>
                                    <div class="flex items-center gap-2">
                                        <template x-if="item.original_price && item.original_price != item.price">
                                            <span class="text-xs text-slate-400 line-through font-medium" x-text="formatRp(item.original_price)"></span>
                                        </template>
                                    </div>
                                    <button type="button" @click="removeItem(item)" class="text-xs text-rose-500 hover:text-rose-700 font-semibold flex items-center gap-1 mt-2 transition duration-150">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </div>
                            </div>

                            <!-- Harga (Desktop) -->
                            <div class="hidden md:block col-span-2 text-center">
                                <div class="font-semibold text-slate-600" x-text="formatRp(item.price)"></div>
                                <template x-if="item.original_price && item.original_price != item.price">
                                    <div class="text-xs text-slate-400 line-through" x-text="formatRp(item.original_price)"></div>
                                </template>
                            </div>

                            <!-- Qty Selector -->
                            <div class="col-span-1 md:col-span-2 flex justify-start md:justify-center">
                                <div class="qty-control" style="display:inline-flex;align-items:center;border:1px solid #D4DCD6;border-radius:10px;overflow:hidden;background:#FFFFFF;">
                                    <button type="button" @click="updateQty(item, item.quantity - 1)"
                                            class="qty-btn" style="width:36px;height:36px;border:none;background:#FFFFFF;color:#0D2618;font-weight:700;font-size:1rem;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.3s ease;">
                                        <svg width="14" height="2" viewBox="0 0 14 2" fill="none"><rect width="14" height="2" rx="1" fill="currentColor"/></svg>
                                    </button>
                                    <span class="qty-display" style="width:44px;text-align:center;border:none;border-left:1px solid #E0E6E2;border-right:1px solid #E0E6E2;font-weight:600;font-size:0.95rem;color:#0D2618;background:#FAFAFA;height:36px;display:flex;align-items:center;justify-content:center;" x-text="item.quantity"></span>
                                    <button type="button" @click="updateQty(item, item.quantity + 1)"
                                            class="qty-btn" style="width:36px;height:36px;border:none;background:#FFFFFF;color:#0D2618;font-weight:700;font-size:1rem;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.3s ease;">
                                        +
                                    </button>
                                </div>
                            </div>

                            <!-- Subtotal -->
                            <div class="col-span-1 md:col-span-3 text-left md:text-right font-bold text-slate-800 text-lg" x-text="formatRp(item.price * item.quantity)"></div>
                        </div>
                    </template>
                </div>
            </div>

            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-[#0D2618] transition duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali Belanja Produk Lain
            </a>
        </div>

        <!-- Right: Summary -->
        <div class="lg:col-span-4">
            <div class="cart-summary" style="background:#FFFFFF;border:1px solid #E0E6E2;border-radius:16px;padding:28px;position:sticky;top:100px;space-y:5;">
                <h3 style="font-family:'Plus Jakarta Sans', 'Inter', sans-serif;font-size:1.2rem;font-weight:700;color:#0D2618;padding-bottom:16px;border-bottom:1px solid #E0E6E2;margin-bottom:20px;">
                    Ringkasan Pesanan
                </h3>

                <div class="summary-row" style="display:flex;justify-content:space-between;margin-bottom:12px;font-size:0.9rem;">
                    <span style="color:#6A7A72;">Jumlah Barang</span>
                    <strong style="font-weight:600;color:#0D2618;" x-text="`${items.reduce((sum, i) => sum + i.quantity, 0)} Item`"></strong>
                </div>
                <div class="summary-row" style="display:flex;justify-content:space-between;margin-bottom:12px;font-size:0.9rem;">
                    <span style="color:#6A7A72;">Total Nilai Produk</span>
                    <strong style="font-weight:600;color:#0D2618;" x-text="formatRp(getSubtotal())"></strong>
                </div>

                <div class="summary-total" style="display:flex;justify-content:space-between;align-items:center;padding-top:16px;border-top:1px solid #E0E6E2;margin-top:16px;">
                    <span style="font-weight:700;color:#0D2618;font-size:1rem;">Estimasi Total</span>
                    <span style="font-family:'Plus Jakarta Sans', 'Inter', sans-serif;font-weight:700;color:#0D2618;font-size:1.3rem;" x-text="formatRp(getTotal())"></span>
                </div>

                <div class="checkout-action">
                    <a href="{{ route('order.form', ['source' => 'cart']) }}"
                       class="btn-checkout">
                        <svg class="btn-checkout-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span>Lanjutkan Pemesanan</span>
                    </a>
                </div>

                <div style="display:flex;align-items:center;justify-content:center;gap:6px;margin-top:12px;font-size:0.7rem;color:#8A9A92;">
                    <svg class="w-3.5 h-3.5" style="color:#2E7D32;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Transaksi aman &amp; terenkripsi
                </div>
            </div>
        </div>
    </div>

    <!-- Empty State -->
    <div class="text-center py-20 max-w-lg mx-auto" x-show="items.length === 0" x-transition>
        <div class="mb-6" style="color:#0D2618;opacity:0.2;">
            <svg class="w-20 h-20 mx-auto" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
        </div>
        <h2 class="font-serif text-2xl font-bold mb-2" style="color:#0D2618;">Keranjang Belanja Kosong</h2>
        <p class="text-slate-400 max-w-sm mx-auto mb-8 text-sm leading-relaxed">Anda belum menambahkan produk herbal premium kami ke dalam daftar keranjang belanja Anda.</p>
        <a href="{{ route('products.index') }}"
           style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg, #0D2618, #0D2618);color:#FFFFFF;padding:14px 32px;border-radius:50px;font-weight:600;font-size:0.95rem;transition:all 0.3s ease;border:none;cursor:pointer;text-decoration:none;">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            Mulai Belanja
        </a>
    </div>
</div>

<style>
    .qty-btn:hover { background: #F5F0EB !important; color: #0D2618 !important; }
    .checkout-action {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        padding: 16px 0;
        margin-top: 16px;
    }
    .btn-checkout {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
        padding: 16px 32px;
        background: linear-gradient(135deg, #0D2618, #0D2618);
        color: #FFFFFF;
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 1rem;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        text-decoration: none;
    }
    .btn-checkout-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #FFFFFF;
    }
    .btn-checkout:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 40px rgba(13, 38, 24, 0.2);
    }
    @media (max-width: 768px) {
        .btn-checkout {
            padding: 16px 24px;
            font-size: 0.95rem;
            max-width: 100%;
        }
        .btn-checkout-icon {
            width: 16px;
            height: 16px;
        }
    }
    @media (min-width: 769px) {
        .btn-checkout {
            max-width: 400px;
            padding: 16px 40px;
        }
    }
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
</style>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('cartPage', () => ({
            items: @json(array_values($cart)),
            loading: false,

            formatRp(n) {
                return 'Rp ' + parseInt(n).toLocaleString('id-ID');
            },

            getSubtotal() {
                return this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            },

            getTotal() {
                return this.getSubtotal();
            },

            async updateQty(item, newQty) {
                if (newQty < 1) return;
                if (newQty > item.stock) {
                    Alpine.store('modal').alert('Stok tidak mencukupi. Stok maksimal: ' + item.stock, 'error');
                    return;
                }

                this.loading = true;
                try {
                    let response = await fetch('{{ route('cart.update') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            product_id: item.id,
                            quantity: newQty
                        })
                    });
                    let data = await response.json();
                    if (response.ok) {
                        item.quantity = newQty;
                    } else {
                        Alpine.store('modal').alert(data.message || 'Gagal memperbarui jumlah', 'error');
                    }
                } catch (err) {
                    console.error(err);
                    Alpine.store('modal').alert('Terjadi kesalahan koneksi.', 'error');
                } finally {
                    this.loading = false;
                }
            },

            async removeItem(item) {
                const confirmed = await Alpine.store('modal').confirm('Apakah Anda yakin ingin menghapus ' + item.name + ' dari keranjang?');
                if (!confirmed) return;

                this.loading = true;
                try {
                    let response = await fetch('{{ route('cart.remove') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            product_id: item.id
                        })
                    });
                    let data = await response.json();
                    if (response.ok) {
                        this.items = this.items.filter(i => i.id !== item.id);
                    } else {
                        Alpine.store('modal').alert(data.message || 'Gagal menghapus produk', 'error');
                    }
                } catch (err) {
                    console.error(err);
                    Alpine.store('modal').alert('Terjadi kesalahan koneksi.', 'error');
                } finally {
                    this.loading = false;
                }
            }
        }));
    });
</script>
@endpush
