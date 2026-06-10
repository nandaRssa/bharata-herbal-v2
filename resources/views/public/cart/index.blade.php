@extends('layouts.public')
@section('title', 'Keranjang Belanja')

@section('content')
<!-- Header Halaman -->
<div class="relative py-28 overflow-hidden bg-white border-b border-slate-100">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-gradient-to-tr from-emerald-50 to-emerald-100 rounded-full blur-3xl opacity-60 pointer-events-none -translate-y-1/2"></div>
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M54.627 0l.83.83v58.34l-.83.83H5.373l-.83-.83V.83l.83-.83h49.254zM53.5 2.127H6.5v55.746h47V2.127z\' fill=\'%23008060\' fill-opacity=\'0.02\' fill-rule=\'evenodd\'/%3E%3C/svg%3E')]"></div>
    
    <div class="relative z-10 max-w-4xl mx-auto px-4 text-center">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold mb-6 tracking-wide shadow-sm" style="background-color: var(--primary-light); color: var(--primary);">
            <div class="w-1.5 h-1.5 rounded-full" style="background-color: var(--primary);"></div>
            Shopping Cart
        </div>
        
        <!-- Heading -->
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight mb-6">
            Keranjang Belanja Anda
        </h1>
        
        <!-- Description -->
        <p class="text-lg md:text-xl text-slate-600 max-w-2xl mx-auto leading-relaxed">
            Tinjau kembali pilihan produk herbal Anda sebelum melakukan pengisian formulir pemesanan.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16" x-data="cartPage">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10" x-show="items.length > 0">
        <!-- List Items (Left) -->
        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100/80 overflow-hidden">
                <!-- Header Table (Desktop Only) -->
                <div class="hidden md:grid grid-cols-12 gap-4 p-6 bg-slate-50/70 border-b border-gray-100 font-bold text-xs text-slate-400 uppercase tracking-widest">
                    <div class="col-span-6">Produk</div>
                    <div class="col-span-2 text-center">Harga</div>
                    <div class="col-span-2 text-center">Jumlah</div>
                    <div class="col-span-2 text-right">Subtotal</div>
                </div>

                <!-- Items Loop -->
                <div class="divide-y divide-gray-100">
                    <template x-for="item in items" :key="item.id">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 p-6 items-center">
                            <!-- Info Produk -->
                            <div class="col-span-1 md:col-span-6 flex items-center gap-4">
                                <div class="w-20 h-20 rounded-2xl bg-slate-50 overflow-hidden flex-shrink-0 border border-slate-100">
                                    <template x-if="item.image_path">
                                        <img :src="'/storage/' + item.image_path" :alt="item.name" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!item.image_path">
                                        <div class="w-full h-full flex items-center justify-center text-4xl opacity-20">🌿</div>
                                    </template>
                                </div>
                                <div class="space-y-1">
                                    <a :href="'/produk/' + item.slug" class="font-bold text-lg text-slate-800 hover:text-amber-700 transition duration-150" x-text="item.name"></a>
                                    <div class="text-xs text-slate-400 font-medium md:hidden" x-text="formatRp(item.price)"></div>
                                    <button type="button" @click="removeItem(item)" class="text-xs text-rose-500 hover:text-rose-700 font-bold flex items-center gap-1 mt-2 transition duration-150">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus Item
                                    </button>
                                </div>
                            </div>

                            <!-- Harga (Desktop Only) -->
                            <div class="hidden md:block col-span-2 text-center font-semibold text-slate-600" x-text="formatRp(item.price)"></div>

                            <!-- Qty Selector -->
                            <div class="col-span-1 md:col-span-2 flex justify-start md:justify-center">
                                <div class="flex items-center border border-slate-200 rounded-xl overflow-hidden shadow-inner bg-slate-50/55">
                                    <button type="button" @click="updateQty(item, item.quantity - 1)" class="px-3 py-2 hover:bg-slate-100 font-bold transition select-none text-slate-500">-</button>
                                    <span class="w-8 text-center font-bold text-sm text-slate-700 bg-transparent" x-text="item.quantity"></span>
                                    <button type="button" @click="updateQty(item, item.quantity + 1)" class="px-3 py-2 hover:bg-slate-100 font-bold transition select-none text-slate-500">+</button>
                                </div>
                            </div>

                            <!-- Subtotal -->
                            <div class="col-span-1 md:col-span-2 text-left md:text-right font-bold text-slate-800 text-lg" x-text="formatRp(item.price * item.quantity)"></div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Back to shopping -->
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-emerald-800 transition duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali Belanja Produk Lain
            </a>
        </div>

        <!-- Summary Column (Right) -->
        <div class="lg:col-span-4">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 space-y-6">
                <h3 class="text-xl font-bold font-serif-elegant tracking-wide text-slate-800 border-b border-slate-100 pb-4">Ringkasan Pesanan</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between text-sm text-slate-500 font-medium">
                        <span>Jumlah Barang</span>
                        <strong class="text-slate-800" x-text="`${items.reduce((sum, i) => sum + i.quantity, 0)} Item`"></strong>
                    </div>
                    <div class="flex justify-between text-sm text-slate-500 font-medium">
                        <span>Total Nilai Produk</span>
                        <strong class="text-slate-800" x-text="formatRp(getSubtotal())"></strong>
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-5 flex justify-between font-bold text-xl text-slate-800">
                    <span>Estimasi Total</span>
                    <span style="color: var(--gold-dark);" x-text="formatRp(getTotal())"></span>
                </div>

                <!-- Lanjut Pesan -->
                <a href="{{ route('order.form', ['source' => 'cart']) }}" 
                   class="w-full block text-center text-white font-bold py-4 px-6 rounded-xl transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5"
                   style="background-color: var(--primary);">
                    🛒 Lanjutkan Pemesanan
                </a>
            </div>
        </div>
    </div>

    <!-- Empty State -->
    <div class="text-center py-24 bg-white rounded-3xl shadow-sm border border-gray-100/80 max-w-2xl mx-auto" x-show="items.length === 0" x-transition>
        <div class="text-7xl mb-6">🛒</div>
        <h2 class="text-3xl font-bold font-serif-elegant mb-2" style="color: var(--primary);">Keranjang Belanja Kosong</h2>
        <p class="text-slate-400 max-w-sm mx-auto mb-8 text-sm leading-relaxed">Anda belum menambahkan produk herbal premium kami ke dalam daftar keranjang belanja Anda.</p>
        <a href="{{ route('products.index') }}" class="inline-block px-8 py-4 rounded-xl text-sm font-bold text-white shadow-md hover:shadow-lg transition duration-200" style="background: var(--primary);">
            Mulai Belanja 🌿
        </a>
    </div>
</div>
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
                    alert('Stok tidak mencukupi. Stok maksimal: ' + item.stock);
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
                        window.location.reload();
                    } else {
                        alert(data.message || 'Gagal memperbarui jumlah');
                    }
                } catch (err) {
                    console.error(err);
                    alert('Terjadi kesalahan koneksi.');
                } finally {
                    this.loading = false;
                }
            },
            
            async removeItem(item) {
                if (!confirm('Apakah Anda yakin ingin menghapus ' + item.name + ' dari keranjang?')) return;
                
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
                        window.location.reload();
                    } else {
                        alert(data.message || 'Gagal menghapus produk');
                    }
                } catch (err) {
                    console.error(err);
                    alert('Terjadi kesalahan koneksi.');
                } finally {
                    this.loading = false;
                }
            }
        }));
    });
</script>
@endpush
