@extends('layouts.public')
@section('title', 'Form Pemesanan')

@section('content')
<!-- Header Halaman -->
<div class="relative py-24 overflow-hidden bg-white border-b border-slate-100">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-gradient-to-tr from-emerald-50 to-emerald-100 rounded-full blur-3xl opacity-60 pointer-events-none -translate-y-1/2"></div>
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M54.627 0l.83.83v58.34l-.83.83H5.373l-.83-.83V.83l.83-.83h49.254zM53.5 2.127H6.5v55.746h47V2.127z\' fill=\'%23008060\' fill-opacity=\'0.02\' fill-rule=\'evenodd\'/%3E%3C/svg%3E')]"></div>
    
    <div class="relative z-10 max-w-4xl mx-auto px-4 text-center">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold mb-6 tracking-wide shadow-sm" style="background-color: var(--primary-light); color: var(--primary);">
            <div class="w-1.5 h-1.5 rounded-full" style="background-color: var(--primary);"></div>
            Secure Checkout
        </div>
        
        <!-- Heading -->
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight mb-6">
            Penyelesaian Pemesanan
        </h1>
        
        <!-- Description -->
        <p class="text-lg md:text-xl text-slate-600 max-w-2xl mx-auto leading-relaxed">
            Lengkapi formulir terenkripsi di bawah ini untuk memproses pengiriman produk herbal Anda.
        </p>
    </div>
</div>

<div class="max-w-3xl mx-auto px-4 py-16" x-data="checkoutForm">

    <!-- Step Indicator -->
    <div class="flex items-center justify-center mb-12">
        @foreach(['Data Diri', 'Alamat', 'Produk', 'Konfirmasi'] as $i => $label)
        <div class="flex items-center">
            <div class="flex flex-col items-center">
                <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 border shadow-sm"
                    :class="step >= {{ $i+1 }} ? 'text-white border-transparent' : 'bg-white border-slate-200 text-slate-400'"
                    :style="step >= {{ $i+1 }} ? 'background: var(--primary);' : ''">
                    @if ($i == 0)
                        👤
                    @elseif ($i == 1)
                        📍
                    @elseif ($i == 2)
                        📦
                    @else
                        ✅
                    @endif
                </div>
                <div class="text-[10px] font-bold uppercase tracking-wider mt-2 text-center"
                    :class="step >= {{ $i+1 }} ? 'text-emerald-800' : 'text-slate-400'">{{ $label }}</div>
            </div>
            @if($i < 3)
            <div class="w-12 sm:w-16 h-1 mx-2 mb-6 rounded-full transition-all duration-300"
                :style="step > {{ $i+1 }} ? 'background: var(--primary)' : 'background: #e2e8f0'"></div>
            @endif
        </div>
        @endforeach
    </div>

    <form method="POST" action="{{ route('order.store') }}">
        @csrf

        @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-5">
            <h4 class="font-bold text-red-700 text-sm mb-2">⚠️ Pesanan gagal diproses. Periksa data berikut:</h4>
            <ul class="text-red-600 text-xs space-y-1 list-disc pl-4">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <p class="text-xs text-red-500 mt-2 font-medium">Klik <strong>Kembali ke Langkah 1</strong> dan periksa kembali semua isian Anda.</p>
        </div>
        @endif

        <!-- Step 1: Data Diri -->
        <div x-show="step === 1" x-transition class="bg-white rounded-3xl shadow-sm border border-gray-100/80 p-8 space-y-6">
            <h2 class="text-2xl font-bold font-serif-elegant border-b border-slate-100 pb-3" style="color: var(--primary);">Data Diri Pelanggan</h2>

            <div class="space-y-5">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Nama Lengkap *</label>
                    <input type="text" name="customer_name" x-model="form.customer_name" required
                        placeholder="Contoh: Rian Pratama"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-medium transition duration-200">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Nomor WhatsApp *</label>
                    <input type="tel" name="customer_phone" x-model="form.customer_phone" required
                        placeholder="Contoh: 08123456789"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-medium transition duration-200">
                    <span class="text-[10px] text-slate-400 font-semibold mt-1.5 block">Diperlukan untuk konfirmasi pengiriman via kurir</span>
                </div>
            </div>
        </div>

        <!-- Step 2: Alamat -->
        <div x-show="step === 2" x-transition class="bg-white rounded-3xl shadow-sm border border-gray-100/80 p-8 space-y-6">
            <h2 class="text-2xl font-bold font-serif-elegant border-b border-slate-100 pb-3" style="color: var(--primary);">Alamat Pengiriman Paket</h2>

            <div class="space-y-5">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Provinsi *</label>
                        <select x-model="selected_prov_id" @change="fetchRegencies()" required
                            class="w-full border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-medium transition duration-200">
                            <option value="">-- Pilih Provinsi --</option>
                            <template x-for="p in provinces" :key="p.id">
                                <option :value="p.id" x-text="p.name"></option>
                            </template>
                        </select>
                        <input type="hidden" name="address_province" x-model="form.address_province">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Kota / Kabupaten *</label>
                        <select x-model="selected_reg_id" @change="fetchDistricts()" required
                            class="w-full border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-medium transition duration-200">
                            <option value="">-- Pilih Kota --</option>
                            <template x-for="r in regencies" :key="r.id">
                                <option :value="r.id" x-text="r.name"></option>
                            </template>
                        </select>
                        <input type="hidden" name="address_city" x-model="form.address_city">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Kecamatan *</label>
                        <select x-model="selected_dist_id" @change="fetchVillages()" required
                            class="w-full border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-medium transition duration-200">
                            <option value="">-- Pilih Kecamatan --</option>
                            <template x-for="d in districts" :key="d.id">
                                <option :value="d.id" x-text="d.name"></option>
                            </template>
                        </select>
                        <input type="hidden" name="address_kecamatan" x-model="form.address_kecamatan">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Kelurahan / Desa</label>
                        <select x-model="form.address_kelurahan"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-medium transition duration-200">
                            <option value="">-- Pilih Kelurahan --</option>
                            <template x-for="v in villages" :key="v.id">
                                <option :value="v.name" x-text="v.name"></option>
                            </template>
                        </select>
                        <input type="hidden" name="address_kelurahan" x-model="form.address_kelurahan">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Kode Pos *</label>
                    <input type="text" name="address_postal" x-model="form.address_postal" required
                        placeholder="12345" maxlength="10"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-medium transition duration-200">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Nama Jalan, Blok, RT/RW, No. Rumah *</label>
                    <textarea name="address_street" x-model="form.address_street" required rows="3"
                        placeholder="Contoh: Jl. Diponegoro No. 123, Blok C4, RT 02/RW 05"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-medium transition duration-200"></textarea>
                </div>
            </div>
        </div>


        <!-- Step 3: Produk & Pengiriman -->
        <div x-show="step === 3" x-transition class="bg-white rounded-3xl shadow-sm border border-gray-100/80 p-8 space-y-6">
            <h2 class="text-2xl font-bold font-serif-elegant border-b border-slate-100 pb-3" style="color: var(--primary);">Daftar Produk & Pengiriman</h2>

            <div class="space-y-4">
                <template x-for="(item, idx) in form.items" :key="idx">
                    <div class="flex gap-3 items-center p-4 rounded-2xl border border-slate-100 bg-slate-50/50">
                        <div class="flex-1">
                            <select :name="'items[' + idx + '][product_id]'" x-model="item.product_id" required
                                class="w-full border border-slate-200 bg-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600/10 text-slate-700 font-medium">
                                <option value="">-- Pilih Produk --</option>
                                @foreach($products as $p)
                                <option value="{{ $p->id }}">{{ $p->name }} — {{ $p->formatted_price }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-20">
                            <input type="number" :name="'items[' + idx + '][quantity]'" x-model.number="item.quantity" min="1" max="100"
                                class="w-full border border-slate-200 bg-white rounded-lg px-3 py-2 text-sm text-center focus:outline-none focus:ring-2 focus:ring-emerald-600/10 text-slate-700 font-bold">
                        </div>
                        <button type="button" @click="removeItem(idx)" class="text-rose-500 hover:text-rose-700 p-2 text-sm font-bold transition">✕</button>
                    </div>
                </template>

                <button type="button" @click="addItem" class="text-sm font-bold flex items-center gap-1.5 transition hover:opacity-85" style="color: var(--primary);">
                    ➕ Tambah Item Produk Lain
                </button>
            </div>

            <!-- Metode Pengiriman -->
            <div class="border-t border-slate-100 pt-6 space-y-4">
                <h3 class="font-bold text-slate-700 text-sm uppercase tracking-wider">🚚 Opsi Kurir Ekspedisi</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach([['JNE','JNE Regular',15000],['JNT','J&T Express',12000],['SICEPAT','SiCepat',13000],['GOSEND','GoSend (Same Day)',25000]] as [$val,$label,$cost])
                    <label class="flex items-center justify-between p-4 border rounded-xl cursor-pointer transition duration-200"
                        :class="form.shipping_method === '{{ $val }}' ? 'border-amber-500 bg-amber-50/30' : 'border-slate-200 hover:border-slate-300'"
                        @click="form.shipping_method='{{ $val }}'; form.shipping_cost={{ $cost }}">
                        <input type="radio" name="shipping_method" value="{{ $val }}" class="sr-only">
                        <div>
                            <div class="font-bold text-slate-800 text-sm">{{ $label }}</div>
                        </div>
                        <div class="font-bold text-emerald-800 text-sm">{{ 'Rp ' . number_format($cost,0,',','.') }}</div>
                    </label>
                    @endforeach
                </div>
                <input type="hidden" name="shipping_cost" x-bind:value="form.shipping_cost">
                <input type="hidden" name="shipping_method" x-bind:value="form.shipping_method">
            </div>

            <!-- Metode Pembayaran -->
            <div class="border-t border-slate-100 pt-6 space-y-5">
                <h3 class="font-bold text-slate-700 text-sm uppercase tracking-wider">💳 Metode Pembayaran</h3>

                @php
                    $eWalletMethods = [];
                    $mBankingMethods = [];
                    $codMethod = null;
                    foreach ($availablePaymentMethods as $key => $method) {
                        if (!isset($enabledPaymentMethods[$key])) continue;
                        if ($method['group'] === 'e_wallet') $eWalletMethods[$key] = $method;
                        elseif ($method['group'] === 'm_banking') $mBankingMethods[$key] = $method;
                        elseif ($key === 'cod') $codMethod = [$key => $method];
                    }
                @endphp

                @if(!empty($eWalletMethods))
                <div>
                    <h4 class="text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-3 flex items-center gap-2">
                        <span>📱</span> E-Wallet & QRIS
                    </h4>
                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-2.5">
                        @foreach($eWalletMethods as $key => $method)
                        <label class="flex flex-col items-center justify-center text-center p-3 border rounded-xl cursor-pointer transition duration-200"
                            :class="form.payment_method === '{{ $key }}' ? 'border-amber-500 bg-amber-50/30 ring-1 ring-amber-500/20' : 'border-slate-200 hover:border-slate-300 hover:bg-slate-50'"
                            @click="form.payment_method='{{ $key }}'">
                            <input type="radio" name="payment_method" value="{{ $key }}" class="sr-only">
                            <span class="text-xl mb-1">{{ $method['icon'] }}</span>
                            <span class="text-[11px] font-bold text-slate-700 leading-tight">{{ $method['label'] }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(!empty($mBankingMethods))
                <div>
                    <h4 class="text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-3 flex items-center gap-2">
                        <span>🏦</span> M-Banking & Bank Transfer
                    </h4>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                        @foreach($mBankingMethods as $key => $method)
                        <label class="flex items-center justify-center text-center p-3 border rounded-xl cursor-pointer transition duration-200"
                            :class="form.payment_method === '{{ $key }}' ? 'border-amber-500 bg-amber-50/30 ring-1 ring-amber-500/20' : 'border-slate-200 hover:border-slate-300 hover:bg-slate-50'"
                            @click="form.payment_method='{{ $key }}'">
                            <input type="radio" name="payment_method" value="{{ $key }}" class="sr-only">
                            <div>
                                <span class="text-lg mb-0.5 block">{{ $method['icon'] }}</span>
                                <span class="text-[11px] font-bold text-slate-700 leading-tight">{{ $method['label'] }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(!empty($codMethod))
                <div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        @foreach($codMethod as $key => $method)
                        <label class="flex items-center justify-center text-center p-3 border rounded-xl cursor-pointer transition duration-200"
                            :class="form.payment_method === '{{ $key }}' ? 'border-amber-500 bg-amber-50/30 ring-1 ring-amber-500/20' : 'border-slate-200 hover:border-slate-300 hover:bg-slate-50'"
                            @click="form.payment_method='{{ $key }}'">
                            <input type="radio" name="payment_method" value="{{ $key }}" class="sr-only">
                            <div>
                                <span class="text-lg mb-0.5 block">{{ $method['icon'] }}</span>
                                <span class="text-[11px] font-bold text-slate-700">{{ $method['label'] }}</span>
                                <div class="text-[10px] text-amber-600 font-medium">Bayar di Tempat</div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endif

                <input type="hidden" name="payment_method" x-bind:value="form.payment_method">
            </div>


            <div class="border-t border-slate-100 pt-6">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Catatan Tambahan (Opsional)</label>
                <textarea name="notes" x-model="form.notes" rows="2" placeholder="Contoh: Kirim setelah jam 5 sore atau titipkan ke satpam"
                    class="w-full border border-slate-200 rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-medium"></textarea>
            </div>
        </div>

        <!-- Step 4: Review -->
        <div x-show="step === 4" x-transition class="bg-white rounded-3xl shadow-sm border border-gray-100/80 p-8 space-y-6">
            <h2 class="text-2xl font-bold font-serif-elegant border-b border-slate-100 pb-3" style="color: var(--primary);">Konfirmasi Data & Pesanan</h2>

            <div class="space-y-5 text-sm">
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100/60">
                    <h3 class="font-bold text-xs uppercase tracking-widest text-slate-400 mb-2">Informasi Penerima</h3>
                    <p class="text-slate-800 font-bold text-base"><span x-text="form.customer_name"></span></p>
                    <p class="text-slate-500 font-medium mt-1">📞 WhatsApp: <span x-text="form.customer_phone"></span></p>
                </div>

                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100/60">
                    <h3 class="font-bold text-xs uppercase tracking-widest text-slate-400 mb-2">Tujuan Pengiriman</h3>
                    <p class="text-slate-700 leading-relaxed font-medium" x-text="form.address_street + ', ' + form.address_kelurahan + ', ' + form.address_kecamatan + ', ' + form.address_city + ', ' + form.address_province + ' ' + form.address_postal"></p>
                </div>

                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100/60 space-y-4">
                    <h3 class="font-bold text-xs uppercase tracking-widest text-slate-400 border-b border-slate-200/50 pb-2">Rincian Pembayaran</h3>
                    <template x-for="item in form.items">
                        <div class="flex justify-between items-center text-slate-600 text-sm font-medium" x-show="item.product_id">
                            <span x-text="(getProduct(item.product_id)?.name || '') + ' (x' + item.quantity + ')'"></span>
                            <span class="font-bold text-slate-800" x-text="formatRp((getProduct(item.product_id)?.price || 0) * item.quantity)"></span>
                        </div>
                    </template>
                    <div class="flex justify-between items-center text-slate-600 text-sm font-medium pt-2 border-t border-slate-200/40">
                        <span>Ongkos Kirim (<span class="font-bold" x-text="form.shipping_method"></span>)</span>
                        <span class="font-bold text-slate-800" x-text="formatRp(form.shipping_cost)"></span>
                    </div>
                    <div class="flex justify-between items-center pt-3 border-t border-slate-200 font-bold text-lg text-slate-800">
                        <span>Total Pembayaran (<span class="capitalize text-slate-700" x-text="getPaymentLabel(form.payment_method)"></span>)</span>
                        <span style="color: var(--primary);" x-text="formatRp(getTotal())"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex flex-col-reverse sm:flex-row justify-between gap-4 mt-8">
            <button type="button" @click="prevStep" x-show="step > 1"
                class="w-full sm:w-auto px-6 py-3.5 rounded-xl font-bold border border-slate-200 text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition">
                ← Kembali
            </button>
            <div x-show="step === 1" class="hidden sm:block flex-grow"></div>

            <button type="button" @click="nextStep" x-show="step < 4"
                class="w-full sm:w-auto px-8 py-3.5 rounded-xl font-bold text-white transition duration-200 shadow-md hover:shadow-lg"
                style="background: var(--primary);">
                Lanjutkan Langkah →
            </button>

            <button type="submit" x-show="step === 4"
                class="w-full sm:w-auto px-10 py-4 rounded-xl text-base font-bold text-white transition duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5"
                style="background: var(--primary);">
                🛒 Selesaikan Pemesanan & Bayar
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('checkoutForm', () => ({
            step: 1,
            totalSteps: 4,
            provinces: [],
            regencies: [],
            districts: [],
            villages: [],
            selected_prov_id: '',
            selected_reg_id: '',
            selected_dist_id: '',
            form: {
                customer_name: '',
                customer_phone: '',
                address_street: '',
                address_kelurahan: '',
                address_kecamatan: '',
                address_city: '',
                address_province: '',
                address_postal: '',
                shipping_method: 'JNE',
                shipping_cost: 15000,
                payment_method: '{{ array_key_first($enabledPaymentMethods) ?? "bank_transfer" }}',
                notes: '',
                items: @json($items)
            },
            paymentLabels: @json(collect($availablePaymentMethods)->mapWithKeys(fn($m, $k) => [$k => $k === 'bank_transfer' ? 'Bank Transfer' : ($k === 'cod' ? 'COD' : $m['label'])])),
            products: @json($products),
            getProduct(id) {
                return this.products.find(p => p.id == id);
            },
            getPaymentLabel(key) {
                return this.paymentLabels[key] || key.replace(/_/g, ' ');
            },
            getSubtotal() {
                return this.form.items.reduce((sum, item) => {
                    const p = this.getProduct(item.product_id);
                    return sum + (p ? p.price * item.quantity : 0);
                }, 0);
            },
            getTotal() {
                return this.getSubtotal() + parseInt(this.form.shipping_cost);
            },
            formatRp(n) {
                return 'Rp ' + parseInt(n).toLocaleString('id-ID');
            },
            addItem() {
                this.form.items.push({ product_id: '', quantity: 1 });
            },
            removeItem(i) {
                if (this.form.items.length > 1) {
                    this.form.items.splice(i, 1);
                }
            },
            async init() {
                try {
                    const res = await fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
                    this.provinces = await res.json();
                } catch(e) { console.error('Gagal memuat provinsi'); }
            },
            async fetchRegencies() {
                this.form.address_province = this.provinces.find(p => p.id === this.selected_prov_id)?.name || '';
                this.regencies = []; this.districts = []; this.villages = [];
                this.selected_reg_id = ''; this.selected_dist_id = '';
                this.form.address_city = ''; this.form.address_kecamatan = ''; this.form.address_kelurahan = '';
                if(this.selected_prov_id) {
                    try {
                        const res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${this.selected_prov_id}.json`);
                        this.regencies = await res.json();
                    } catch(e) {}
                }
            },
            async fetchDistricts() {
                this.form.address_city = this.regencies.find(r => r.id === this.selected_reg_id)?.name || '';
                this.districts = []; this.villages = [];
                this.selected_dist_id = '';
                this.form.address_kecamatan = ''; this.form.address_kelurahan = '';
                if(this.selected_reg_id) {
                    try {
                        const res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${this.selected_reg_id}.json`);
                        this.districts = await res.json();
                    } catch(e) {}
                }
            },
            async fetchVillages() {
                this.form.address_kecamatan = this.districts.find(d => d.id === this.selected_dist_id)?.name || '';
                this.villages = [];
                this.form.address_kelurahan = '';
                if(this.selected_dist_id) {
                    try {
                        const res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${this.selected_dist_id}.json`);
                        this.villages = await res.json();
                    } catch(e) {}
                }
            },
            nextStep() {
                // Validate fields for each step before advancing
                if (this.step === 1) {
                    if (!this.form.customer_name.trim() || !this.form.customer_phone.trim()) {
                        alert('Silakan lengkapi kolom bertanda bintang (*).');
                        return;
                    }
                }
                if (this.step === 2) {
                    if (!this.selected_prov_id || !this.selected_reg_id || !this.selected_dist_id || !this.form.address_street.trim() || !this.form.address_postal.trim()) {
                        alert('Silakan lengkapi alamat pengiriman Anda secara lengkap (Pilih provinsi, kota, kecamatan, dan isi jalan serta kode pos).');
                        return;
                    }
                }
                if (this.step === 3) {
                    const hasInvalid = this.form.items.some(item => !item.product_id || item.quantity < 1);
                    if (hasInvalid) {
                        alert('Silakan pilih produk yang valid dan tentukan jumlahnya.');
                        return;
                    }
                }
                if (this.step < this.totalSteps) {
                    this.step++;
                }
            },
            prevStep() {
                if (this.step > 1) {
                    this.step--;
                }
            }
        }));
    });
</script>
@endpush
