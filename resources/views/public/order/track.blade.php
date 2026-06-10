@extends('layouts.public')
@section('title', 'Status Pesanan ' . $orderNumber)

@section('content')
<div class="min-h-screen py-10 px-4" style="background: #f5f5f5;">
<div class="max-w-xl mx-auto">

    {{-- Header card --}}
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-5 flex items-center gap-4 border border-gray-100">
        <div class="w-10 h-10 rounded-full flex items-center justify-center text-lg"
             style="background:#e8f5e9;">📦</div>
        <div class="text-center flex-1">
            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">No. Pesanan</div>
            <div class="font-bold text-lg" style="color:#1a5c38;">{{ $orderNumber }}</div>
        </div>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-4 py-3 text-sm font-medium">
        {{ session('success') }}
    </div>
    @endif

    {{-- ─── NOT YET VERIFIED: phone form ─── --}}
    @if(!$order)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <h1 class="text-xl font-bold mb-1" style="color:#1a5c38;">Lacak Status Pesanan</h1>
        <p class="text-gray-500 text-sm mb-6">Masukkan nomor HP yang digunakan saat pemesanan untuk verifikasi.</p>

        @error('phone')
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm">{{ $message }}</div>
        @enderror

        <form method="POST" action="{{ route('order.track.verify', $orderNumber) }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Nomor HP Pembeli</label>
                <input type="tel" name="phone" placeholder="Contoh: 08123456789" required
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-emerald-600/20 focus:border-emerald-600/40 transition">
            </div>
            <button type="submit"
                class="w-full py-3.5 rounded-xl font-bold text-white text-sm transition hover:opacity-90"
                style="background:#1a5c38;">
                🔍 Verifikasi & Lihat Status
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('home') }}" class="text-xs text-gray-400 hover:text-gray-600 transition">← Kembali ke Beranda</a>
        </div>
    </div>

    {{-- ─── VERIFIED: show order detail + timeline ─── --}}
    @else

    {{-- Order info --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4">
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Pelanggan</div>
                <div class="font-semibold text-gray-800">{{ $order->customer_name }}</div>
            </div>
            <div>
                <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Tanggal</div>
                <div class="font-semibold text-gray-800">{{ $order->created_at->format('d M Y') }}</div>
            </div>
            <div>
                <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total Pembayaran</div>
                <div class="font-bold text-lg" style="color:#1a5c38;">{{ $order->formatted_total }}</div>
            </div>
            <div>
                <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Metode Bayar</div>
                <div class="font-semibold text-gray-800">{{ strtoupper($order->payment_method) }}</div>
            </div>
        </div>
    </div>

    {{-- Items --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4">
        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-4">Produk Dipesan</h3>
        <div class="space-y-3">
            @foreach($order->items as $item)
            <div class="flex items-center gap-3">
                @if($item->product && $item->product->images->isNotEmpty())
                <img src="{{ asset('storage/'.$item->product->images->first()->image_path) }}"
                     class="w-12 h-12 rounded-xl object-cover border border-gray-100" alt="">
                @else
                <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center text-xl">🌿</div>
                @endif
                <div class="flex-1">
                    <div class="font-semibold text-sm text-gray-800">{{ $item->product_name }}</div>
                    <div class="text-xs text-gray-400">{{ $item->quantity }} × {{ $item->formatted_price }}</div>
                </div>
                <div class="font-bold text-sm" style="color:#1a5c38;">{{ $item->formatted_subtotal }}</div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Payment CTA for unpaid orders --}}
    @if($order->payment_method !== 'cod' && $order->payment_status === 'pending')
    <div class="p-6 rounded-2xl border-2 border-dashed border-amber-300 bg-amber-50/30 mb-4">
        <h3 class="font-bold text-sm text-amber-800 mb-1">💳 Selesaikan Pembayaran</h3>
        <p class="text-xs text-amber-700 mb-4 font-medium">
            Metode: <strong class="uppercase">{{ str_replace('_', ' ', $order->payment_method) }}</strong> —
            Total: <strong>{{ $order->formatted_total }}</strong>
        </p>

        <button id="pay-button" onclick="fetchAndPay()"
            class="w-full py-3.5 rounded-xl font-bold text-white text-sm transition shadow-md hover:shadow-lg hover:opacity-90"
            style="background: var(--primary);">
            💳 Bayar Sekarang
        </button>

        <p class="text-[10px] text-amber-600 mt-3 text-center font-medium">
            Selesaikan pembayaran dalam 24 jam, jika lewat pesanan otomatis dibatalkan.
        </p>
    </div>
    @elseif($order->payment_method === 'cod')
    <div class="p-6 rounded-2xl bg-amber-50/50 border border-amber-100/60 mb-4">
        <h3 class="font-bold text-xs uppercase tracking-widest text-amber-800 mb-1">🚪 Pembayaran: COD (Bayar di Tempat)</h3>
        <p class="text-xs text-amber-700 leading-relaxed font-semibold">Siapkan uang tunai sejumlah <strong>{{ $order->formatted_total }}</strong> saat paket tiba.</p>
    </div>
    @elseif($order->payment_status === 'confirmed')
    <div class="p-6 rounded-2xl bg-green-50 border border-green-200 mb-4">
        <h3 class="font-bold text-xs uppercase tracking-widest text-green-800 mb-1">✅ Pembayaran Dikonfirmasi</h3>
        <p class="text-xs text-green-700 font-semibold">Pembayaran Anda telah berhasil diverifikasi.</p>
    </div>
    @endif

    {{-- Timeline --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-4">
        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-5">Timeline Pesanan</h3>
        <div class="relative">
            {{-- vertical line --}}
            <div class="absolute left-5 top-0 bottom-0 w-0.5 bg-gray-100" style="z-index:0;"></div>
            <div class="space-y-6">
                @foreach($steps as $step)
                <div class="flex items-start gap-4 relative">
                    {{-- Dot --}}
                    <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 text-lg z-10 border-2
                        {{ $step['active'] ? 'border-emerald-600 bg-emerald-50' : ($step['done'] ? 'border-emerald-400 bg-emerald-50' : 'border-gray-200 bg-white') }}">
                        {{ $step['icon'] }}
                    </div>
                    <div class="pt-1.5">
                        <div class="font-semibold text-sm
                            {{ $step['active'] ? 'text-emerald-700' : ($step['done'] ? 'text-gray-700' : 'text-gray-400') }}">
                            {{ $step['label'] }}
                            @if($step['active'])
                            <span class="ml-2 text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full">Sekarang</span>
                            @endif
                        </div>
                        @if($step['extra'])
                        <div class="text-xs text-gray-500 mt-0.5 font-mono">{{ $step['extra'] }}</div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- WhatsApp CTA --}}
    @if(isset($settings) && $settings?->wa_number)
    @php
        $wa = preg_replace('/[^0-9]/', '', $settings->wa_number);
        if(str_starts_with($wa, '0')) $wa = '62'.substr($wa, 1);
        $waMsg = rawurlencode("Halo admin Bharata Herbal, saya ingin menanyakan pesanan saya dengan No. Pesanan: {$order->order_number}");
    @endphp
    <a href="https://wa.me/{{ $wa }}?text={{ $waMsg }}"
       target="_blank"
       class="flex items-center justify-center gap-2 w-full py-3.5 rounded-xl font-bold text-white text-sm bg-green-500 hover:bg-green-600 transition mb-4">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24z"/>
        </svg>
        Chat Admin via WhatsApp
    </a>
    @endif

    {{-- ─── REVIEW FORM (only if delivered) ─── --}}
    @if($order->order_status === 'delivered')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-sm font-bold mb-1" style="color:#1a5c38;">⭐ Beri Ulasan Produk</h3>
        <p class="text-xs text-gray-400 mb-5">Pesanan sudah diterima? Bantu pembeli lain dengan ulasan Anda.</p>

        @foreach($order->items as $item)
        @if($item->product && !in_array($item->product_id, $existingReviewProductIds))
        <div class="border border-gray-100 rounded-xl p-4 mb-4">
            <div class="font-semibold text-sm text-gray-800 mb-3">{{ $item->product_name }}</div>

            <form method="POST" action="{{ route('order.track.review', $orderNumber) }}" class="space-y-3"
                  x-data="{ rating: 0, hover: 0 }">
                @csrf
                <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                <input type="hidden" name="customer_name" value="{{ $order->customer_name }}">
                <input type="hidden" name="rating" x-model="rating">

                {{-- Star rating --}}
                <div class="flex gap-1">
                    @for($s = 1; $s <= 5; $s++)
                    <button type="button"
                            @mouseenter="hover = {{ $s }}"
                            @mouseleave="hover = 0"
                            @click="rating = {{ $s }}"
                            class="text-2xl transition"
                            :class="(hover || rating) >= {{ $s }} ? 'text-amber-400' : 'text-gray-200'">★</button>
                    @endfor
                </div>

                <textarea name="comment" rows="2" placeholder="Ceritakan pengalaman Anda dengan produk ini..."
                    class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600/20 focus:border-emerald-600/40 transition resize-none"></textarea>

                <button type="submit" :disabled="rating === 0"
                    class="w-full py-2.5 rounded-xl font-bold text-sm text-white disabled:opacity-40 transition hover:opacity-90"
                    style="background:#1a5c38;">
                    Kirim Ulasan
                </button>
            </form>
        </div>
        @elseif($item->product && in_array($item->product_id, $existingReviewProductIds))
        <div class="border border-emerald-100 rounded-xl p-4 mb-4 bg-emerald-50/50 text-xs text-emerald-700 font-semibold">
            ✅ Ulasan untuk <span class="font-bold">{{ $item->product_name }}</span> sudah dikirim. Terima kasih!
        </div>
        @endif
        @endforeach
    </div>
    @endif

    <div class="text-center mt-6">
        <a href="{{ route('home') }}" class="text-xs text-gray-400 hover:text-gray-600 transition">← Kembali ke Beranda</a>
    </div>

    @endif {{-- end if $order --}}

</div>
</div>
@endsection

@push('scripts')
@if(isset($order) && $order->payment_method !== 'cod' && $order->payment_status === 'pending')
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    function payWithSnapToken(token) {
        window.snap.pay(token, {
            onSuccess: function(result) {
                alert('✅ Pembayaran berhasil! Terima kasih.');
                window.location.reload();
            },
            onPending: function(result) {
                alert('⏳ Pembayaran sedang diproses. Cek aplikasi Anda.');
            },
            onError: function(result) {
                alert('❌ Pembayaran gagal. Silakan coba lagi.');
            },
            onClose: function() {}
        });
    }

    function fetchAndPay() {
        const btn = document.getElementById('pay-button');
        btn.disabled = true;
        btn.textContent = '⏳ Memuat...';

        fetch('{{ route("payment.snap-token", $order->id) }}')
            .then(res => res.json())
            .then(data => {
                if (data.token) {
                    payWithSnapToken(data.token);
                } else {
                    alert('Gagal memuat token: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(() => alert('Koneksi gagal. Coba lagi.'))
            .finally(() => {
                btn.disabled = false;
                btn.textContent = '💳 Bayar Sekarang';
            });
    }
</script>
@endif
@endpush
