@extends('layouts.public')
@section('title', 'Pesanan Berhasil')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-12 text-center">
    <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8 lg:p-10">
        <div class="w-14 h-14 rounded-full flex items-center justify-center bg-emerald-50 mx-auto mb-5 border border-emerald-100">
            <span class="text-2xl">🎉</span>
        </div>
        <h1 class="text-3xl md:text-4xl font-bold font-serif-elegant mb-2" style="color: var(--primary);">Pesanan Diterima!</h1>
        <p class="text-slate-400 font-semibold text-xs uppercase tracking-widest mb-1">Nomor Pesanan Anda:</p>
        <div class="text-2xl font-bold mb-8 font-serif-elegant tracking-wide" style="color: var(--gold-dark);">{{ $order->order_number }}</div>

        <div class="text-left space-y-6 mb-10">
            {{-- Rincian Pesanan --}}
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100/60">
                <h3 class="font-bold text-xs uppercase tracking-widest text-slate-400 border-b border-slate-200/50 pb-2 mb-3">📦 Rincian Pesanan</h3>
                @foreach($order->items as $item)
                <div class="flex justify-between text-sm py-2.5 border-b border-slate-100 last:border-0 font-medium">
                    <span class="text-slate-700">{{ $item->product_name }} <span class="text-slate-400 font-normal">× {{ $item->quantity }}</span></span>
                    <div class="text-right">
                        @if($item->original_price && $item->original_price != $item->price)
                        <div class="text-[10px] text-slate-400 line-through">Rp {{ number_format($item->original_price, 0, ',', '.') }}</div>
                        @endif
                        <strong class="text-slate-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong>
                    </div>
                </div>
                @endforeach
                <div class="flex justify-between text-sm py-2.5 border-b border-slate-100 font-medium">
                    <span class="text-slate-600">Ongkos Kirim ({{ $order->shipping_method }})</span>
                    <span class="font-bold text-slate-800">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between font-bold text-lg pt-3 border-t border-slate-200 mt-3">
                    <span class="text-slate-800">Total</span>
                    <span style="color: var(--gold-dark);">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- Alamat --}}
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100/60">
                <h3 class="font-bold text-xs uppercase tracking-widest text-slate-400 border-b border-slate-200/50 pb-2 mb-2">🚚 Alamat Pengiriman</h3>
                <p class="text-sm text-slate-600 leading-relaxed font-medium">
                    {{ $order->address_street }}, {{ $order->address_kecamatan }},
                    {{ $order->address_city }}, {{ $order->address_province }} {{ $order->address_postal }}
                </p>
            </div>

            {{-- Status Pembayaran --}}
            @if($order->payment_method === 'cod')
            {{-- COD: tidak perlu bayar via Midtrans --}}
            <div class="p-6 rounded-2xl bg-amber-50/50 border border-amber-100/60">
                <h3 class="font-bold text-xs uppercase tracking-widest text-amber-800 mb-1">🚪 Pembayaran: COD (Bayar di Tempat)</h3>
                <p class="text-xs text-amber-700 leading-relaxed font-semibold">Siapkan uang tunai sejumlah <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong> saat paket tiba. Kurir akan menghubungi Anda sebelum pengiriman.</p>
            </div>

            @elseif($order->payment_status === 'confirmed')
            {{-- Sudah bayar via Midtrans --}}
            <div class="p-6 rounded-2xl bg-green-50 border border-green-200">
                <h3 class="font-bold text-xs uppercase tracking-widest text-green-800 mb-1">✅ Pembayaran Dikonfirmasi</h3>
                <p class="text-xs text-green-700 font-semibold">Pembayaran Anda telah berhasil diverifikasi. Pesanan akan segera diproses.</p>
            </div>

            @else
            {{-- Belum bayar via Midtrans: tampilkan tombol bayar --}}
            <div class="p-6 rounded-2xl border-2 border-dashed border-amber-300 bg-amber-50/30" id="payment-section">
                <h3 class="font-bold text-sm text-amber-800 mb-1">💳 Selesaikan Pembayaran</h3>
                <p class="text-xs text-amber-700 mb-4 font-medium">
                    Metode: <strong class="uppercase">{{ str_replace('_', ' ', $order->payment_method) }}</strong> —
                    Total: <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                </p>

                @if($order->midtrans_snap_token)
                {{-- Snap token sudah ada --}}
                <button id="pay-button"
                    onclick="payWithSnapToken('{{ $order->midtrans_snap_token }}')"
                    class="w-full py-3.5 rounded-xl font-bold text-white text-sm transition shadow-md hover:shadow-lg hover:opacity-90"
                    style="background: var(--primary);">
                    💳 Bayar Sekarang
                </button>
                @else
                {{-- Snap token belum ada, fetch dulu --}}
                <button id="pay-button" onclick="fetchAndPay()"
                    class="w-full py-3.5 rounded-xl font-bold text-white text-sm transition shadow-md hover:shadow-lg hover:opacity-90"
                    style="background: var(--primary);">
                    💳 Bayar Sekarang
                </button>
                @endif

                <p class="text-[10px] text-amber-600 mt-3 text-center font-medium">
                    Powered by Midtrans Sandbox — Transaksi test tidak memotong uang nyata
                </p>
            </div>
            @endif
        </div>

        {{-- Tombol WA (untuk COD + semua order) --}}
        @php
            $waMsg  = "*PESANAN BARU - Bharata Herbal ID*\n";
            $waMsg .= "No. Pesanan: {$order->order_number}\n\n";
            $waMsg .= "👤 DATA PEMBELI\n";
            $waMsg .= "Nama: {$order->customer_name}\n";
            $waMsg .= "HP/WA: {$order->customer_phone}\n\n";
            $waMsg .= "📦 PRODUK\n";
            foreach ($order->items as $item) {
                $waMsg .= "{$item->product_name} x{$item->quantity} = Rp " . number_format($item->subtotal,0,',','.') . "\n";
            }
            $waMsg .= "\n🚚 PENGIRIMAN\n";
            $waMsg .= "Metode: {$order->shipping_method}\n";
            $waMsg .= "Alamat: {$order->address_street}, {$order->address_kecamatan}, {$order->address_city}, {$order->address_province}\n\n";
            $waMsg .= "💳 PEMBAYARAN: " . strtoupper(str_replace('_', ' ', $order->payment_method)) . "\n\n";
            $waMsg .= "💰 TOTAL\n";
            $waMsg .= "Subtotal: Rp " . number_format($order->subtotal,0,',','.') . "\n";
            $waMsg .= "Ongkir: Rp " . number_format($order->shipping_cost,0,',','.') . "\n";
            $waMsg .= "*TOTAL: Rp " . number_format($order->total_amount,0,',','.') . "*";
            $waNumber = preg_replace('/\D/', '', $settings->wa_number ?? '6281234567890');
            $waUrl = 'https://wa.me/' . $waNumber . '?text=' . urlencode($waMsg);
        @endphp

        <a href="{{ $waUrl }}" target="_blank"
           class="flex items-center justify-center gap-3 w-full py-4 rounded-xl font-bold text-white text-base mb-6 shadow-md hover:shadow-lg hover:bg-emerald-700 transition"
           style="background: #25d366;">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            {{ $order->payment_method === 'cod' ? 'Konfirmasi Pesanan via WhatsApp' : 'Kirim Konfirmasi via WhatsApp' }}
        </a>

        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('order.track.show', $order->order_number) }}"
               class="flex-1 py-3.5 rounded-xl font-bold text-sm text-center text-white transition shadow-md hover:opacity-90"
               style="background: var(--primary);">
                📦 Lihat Status Pesanan
            </a>
            <a href="{{ route('products.index') }}" class="flex-1 py-3.5 rounded-xl border-2 font-bold text-sm text-center transition duration-200" style="border-color: var(--primary); color: var(--primary);">Belanja Lagi</a>
            <a href="{{ route('home') }}" class="flex-1 py-3.5 rounded-xl border border-slate-200 font-bold text-sm text-center text-slate-500 hover:bg-slate-50 transition duration-200">Ke Beranda</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Midtrans Snap JS (Sandbox) --}}
@if($order->payment_method !== 'cod' && $order->payment_status !== 'confirmed')
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    function payWithSnapToken(token) {
        window.snap.pay(token, {
            onSuccess: function(result) {
                fetch('{{ route("payment.confirm") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(result)
                })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (data.status === 'ok') {
                        alert('✅ Pembayaran berhasil! Terima kasih.');
                        window.location.reload();
                    } else {
                        alert('✅ Pembayaran berhasil. Tunggu konfirmasi...');
                        window.location.reload();
                    }
                })
                .catch(function() {
                    alert('✅ Pembayaran berhasil! Terima kasih.');
                    window.location.reload();
                });
            },
            onPending: function(result) {
                alert('⏳ Pembayaran sedang diproses. Cek email/aplikasi Anda untuk menyelesaikan pembayaran.');
            },
            onError: function(result) {
                alert('❌ Pembayaran gagal. Silakan coba lagi.');
            },
            onClose: function() {
                // User menutup popup tanpa bayar — tidak apa-apa
            }
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
                    btn.disabled = false;
                    btn.textContent = '💳 Bayar Sekarang';
                } else {
                    alert('Gagal memuat token: ' + (data.error || 'Unknown error'));
                    btn.disabled = false;
                    btn.textContent = '💳 Bayar Sekarang';
                }
            })
            .catch(err => {
                alert('Koneksi gagal. Pastikan server berjalan dan coba lagi.');
                btn.disabled = false;
                btn.textContent = '💳 Bayar Sekarang';
            });
    }
</script>
@endif
@endpush
