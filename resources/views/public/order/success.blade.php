@extends('layouts.public')
@section('title', 'Pesanan Berhasil')

@push('styles')
<style>
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
@endpush
@section('content')
<div class="max-w-2xl mx-auto px-4 pt-12 pb-12 text-center">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 sm:p-8 lg:p-10 p-5">
        <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-5"
             style="background: linear-gradient(135deg, #0D2618, #0D2618);">
            <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h1 class="text-2xl md:text-3xl font-bold text-slate-900 mb-1">Pesanan Diterima!</h1>
        <p class="text-slate-400 font-medium text-xs uppercase tracking-widest mb-1">Nomor Pesanan Anda:</p>
        <div class="text-xl font-bold mb-6 tracking-wide font-mono gold-shimmer">{{ $order->order_number }}</div>

        <div class="text-left space-y-6 mb-10">
            {{-- Rincian Pesanan --}}
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100/60">
                <h3 class="font-bold text-xs uppercase tracking-widest text-slate-400 border-b border-slate-200/50 pb-2 mb-3"><svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg> Rincian Pesanan</h3>
                @foreach($order->items as $item)
                <div class="flex justify-between text-sm py-2.5 border-b border-slate-100 last:border-0 font-medium">
                    <span class="text-slate-700">{{ $item->product_name }} <span class="text-slate-400 font-normal">Ãƒ- {{ $item->quantity }}</span></span>
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
                    <span style="color: #0D2618;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- Alamat --}}
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100/60">
                <h3 class="font-bold text-xs uppercase tracking-widest text-slate-400 border-b border-slate-200/50 pb-2 mb-2"><svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2-1m5 1a2 2 0 100 4 2 2 0 000-4zm8 0a2 2 0 100 4 2 2 0 000-4zm0 0V9l-3-3m0 0h-3m3 0v3"/></svg> Alamat Pengiriman</h3>
                <p class="text-sm text-slate-600 leading-relaxed font-medium">
                    {{ $order->address_street }}, {{ $order->address_kecamatan }},
                    {{ $order->address_city }}, {{ $order->address_province }} {{ $order->address_postal }}
                </p>
            </div>

            {{-- Status Pembayaran --}}
            @if($order->payment_method === 'cod')
            <div class="p-6 rounded-2xl border" style="background:rgba(13, 38, 24, 0.06);border-color:rgba(13, 38, 24, 0.2);">
                <h3 class="font-bold text-xs uppercase tracking-widest mb-1" style="color:#0D2618;"><svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg> Pembayaran: COD (Bayar di Tempat)</h3>
                <p class="text-xs leading-relaxed font-semibold" style="color:#6A7A72;">Siapkan uang tunai sejumlah <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong> saat paket tiba. Kurir akan menghubungi Anda sebelum pengiriman.</p>
            </div>

            @elseif($order->payment_status === 'confirmed')
            <div class="p-6 rounded-2xl border" style="background:rgba(13, 38, 24, 0.06);border-color:rgba(13, 38, 24, 0.2);">
                <h3 class="font-bold text-xs uppercase tracking-widest mb-1" style="color:#0D2618;"><svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Pembayaran Dikonfirmasi</h3>
                <p class="text-xs font-semibold" style="color:#6A7A72;">Pembayaran Anda telah berhasil diverifikasi. Pesanan akan segera diproses.</p>
            </div>

            @else
            <div class="p-6 rounded-2xl border-2 border-dashed" id="payment-section" style="border-color:rgba(13, 38, 24, 0.3);background:rgba(13, 38, 24, 0.04);">
                <div class="flex items-center justify-between flex-wrap gap-2 mb-3">
                    <h3 class="font-bold text-sm" style="color:#0D2618;">
                        <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg> Selesaikan Pembayaran
                    </h3>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        Menunggu Pembayaran
                    </span>
                </div>

                <p class="text-xs mb-3 font-medium" style="color:#6A7A72;">
                    Metode: <strong class="uppercase text-slate-800">{{ str_replace('_', ' ', $order->payment_method) }}</strong> &ndash;
                    Total: <strong class="text-slate-900 font-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                </p>

                <div id="payment-status-notice" class="p-3.5 rounded-xl bg-amber-50/90 border border-amber-200/80 text-xs text-amber-800 mb-4 flex items-start gap-2.5">
                    <svg class="w-4 h-4 flex-shrink-0 mt-0.5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div class="leading-relaxed">
                        Jendela pembayaran dibuka otomatis. Jika ingin membayar nanti, Anda dapat menutup jendela pembayaran dan menyelesaikannya kapan saja.
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-2.5">
                    @if($order->midtrans_snap_token)
                    <button id="pay-button"
                        onclick="payWithSnapToken('{{ $order->midtrans_snap_token }}')"
                        class="flex-1 py-3.5 px-4 rounded-xl font-bold text-sm transition shadow-md hover:shadow-lg flex items-center justify-center gap-2"
                        style="background: linear-gradient(135deg, #0D2618, #0D2618); color: #FFFFFF;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        Bayar Sekarang
                    </button>
                    @else
                    <button id="pay-button" onclick="fetchAndPay()"
                        class="flex-1 py-3.5 px-4 rounded-xl font-bold text-sm transition shadow-md hover:shadow-lg flex items-center justify-center gap-2"
                        style="background: linear-gradient(135deg, #0D2618, #0D2618); color: #FFFFFF;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        Bayar Sekarang
                    </button>
                    @endif

                    <a href="{{ route('order.track.show', $order->order_number) }}"
                        class="py-3.5 px-5 rounded-xl font-bold text-sm text-center border border-slate-300 text-slate-700 bg-white hover:bg-slate-50 transition flex items-center justify-center gap-2 shadow-sm">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Bayar Nanti
                    </a>
                </div>

                <button type="button" onclick="checkStatusNow()" id="check-status-btn"
                    class="w-full mt-2.5 py-2.5 px-3 rounded-xl border border-dashed border-slate-300 text-xs font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition flex items-center justify-center gap-2">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Sudah bayar di aplikasi? Cek status sekarang
                </button>

                <p class="text-[11px] mt-2.5 text-center text-slate-500 font-medium">
                    Pesanan Anda tersimpan aman. Selesaikan pembayaran sebelum batas waktu 24 jam.
                </p>
            </div>
            @endif
        </div>

        {{-- Tombol WA (untuk COD + semua order) --}}
        @php
            $waMsg  = "*PESANAN BARU - Bharata Herbal ID*\n";
            $waMsg .= "No. Pesanan: {$order->order_number}\n\n";
            $waMsg .= "DATA PEMBELI\n";
            $waMsg .= "Nama: {$order->customer_name}\n";
            $waMsg .= "HP/WA: {$order->customer_phone}\n\n";
            $waMsg .= "PRODUK\n";
            foreach ($order->items as $item) {
                $waMsg .= "{$item->product_name} x{$item->quantity} = Rp " . number_format($item->subtotal,0,',','.') . "\n";
            }
            $waMsg .= "\nPENGIRIMAN\n";
            $waMsg .= "Metode: {$order->shipping_method}\n";
            $waMsg .= "Alamat: {$order->address_street}, {$order->address_kecamatan}, {$order->address_city}, {$order->address_province}\n\n";
            $waMsg .= "PEMBAYARAN: " . strtoupper(str_replace('_', ' ', $order->payment_method)) . "\n\n";
            $waMsg .= "TOTAL\n";
            $waMsg .= "Subtotal: Rp " . number_format($order->subtotal,0,',','.') . "\n";
            $waMsg .= "Ongkir: Rp " . number_format($order->shipping_cost,0,',','.') . "\n";
            $waMsg .= "*TOTAL: Rp " . number_format($order->total_amount,0,',','.') . "*";
            $waNumber = preg_replace('/\D/', '', $settings->wa_number ?? '6282244664526');
            $waUrl = 'https://wa.me/' . $waNumber . '?text=' . urlencode($waMsg);
        @endphp

        <a href="{{ $waUrl }}" target="_blank"
           class="flex items-center justify-center gap-2 sm:gap-3 w-full py-3 sm:py-4 px-4 rounded-xl font-bold text-white text-sm sm:text-base mb-6 shadow-md hover:shadow-lg transition text-center leading-snug"
           style="background: #25d366;">
            <svg class="w-5 h-5 sm:w-6 sm:h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            <span>{{ $order->payment_method === 'cod' ? 'Konfirmasi Pesanan via WhatsApp' : 'Kirim Konfirmasi via WhatsApp' }}</span>
        </a>

        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('order.track.show', $order->order_number) }}"
               class="flex-1 py-3.5 rounded-xl font-bold text-sm text-center transition shadow-md hover:shadow-lg"
               style="background: linear-gradient(135deg, #0D2618, #0D2618); color: #FFFFFF;">
                <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg> Lihat Status Pesanan
            </a>
            <a href="{{ route('products.index') }}" class="flex-1 py-3.5 rounded-xl border-2 font-bold text-sm text-center transition duration-200" style="border-color: #0D2618; color: #0D2618;">Belanja Lagi</a>
            <a href="{{ route('home') }}" class="flex-1 py-3.5 rounded-xl border border-slate-200 font-bold text-sm text-center text-slate-500 hover:bg-slate-50 transition duration-200">Ke Beranda</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@if($order->payment_method !== 'cod' && $order->payment_status !== 'confirmed')
<script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
    data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    var isSandbox = {{ config('midtrans.is_production') ? 'false' : 'true' }};

    function onFinish(result, method) {
        if (method === 'onSuccess') {
            var btn = document.getElementById('pay-button');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<svg class="w-4 h-4 inline animate-spin" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Memverifikasi Pembayaran...';
            }

            fetch('{{ route("payment.confirm") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(result)
            })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if (window.Alpine && Alpine.store('modal')) {
                    Alpine.store('modal').alert('Pembayaran berhasil dikonfirmasi! Pesanan Anda sedang diproses.', 'success');
                }
                setTimeout(function() { window.location.reload(); }, 1200);
            })
            .catch(function() {
                setTimeout(function() { window.location.reload(); }, 1500);
            });
        } else if (method === 'onPending') {
            var notice = document.getElementById('payment-status-notice');
            if (notice) {
                notice.innerHTML = '<svg class="w-4 h-4 flex-shrink-0 mt-0.5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><div class="leading-relaxed"><strong>Instruksi pembayaran diterima.</strong> Silakan selesaikan pembayaran sesuai petunjuk yang diberikan. Status akan otomatis diperbarui setelah pembayaran diterima.</div>';
                notice.className = 'p-3.5 rounded-xl bg-blue-50/90 border border-blue-200/80 text-xs text-blue-800 mb-4 flex items-start gap-2.5';
            }
        } else if (method === 'onClose') {
            var notice = document.getElementById('payment-status-notice');
            if (notice) {
                notice.innerHTML = '<svg class="w-4 h-4 flex-shrink-0 mt-0.5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg><div class="leading-relaxed"><strong>Pembayaran belum diselesaikan.</strong> Pesanan Anda tetap tersimpan aman. Anda dapat melanjutkan pembayaran kapan saja dengan menekan tombol <strong>Bayar Sekarang</strong> di bawah atau memilih <strong>Bayar Nanti</strong>.</div>';
                notice.className = 'p-3.5 rounded-xl bg-amber-50/90 border border-amber-200/80 text-xs text-amber-800 mb-4 flex items-start gap-2.5';
            }
        }
    }

    function payWithSnapToken(token) {
        if (!window.snap) {
            console.error('Midtrans Snap belum siap');
            return;
        }
        window.snap.pay(token, {
            onSuccess: function(result)  { onFinish(result, 'onSuccess'); },
            onPending: function(result)  { onFinish(result, 'onPending'); },
            onError: function(result)    { onFinish(result, 'onError'); },
            onClose: function()          { onFinish({}, 'onClose'); }
        });
    }

    function fetchAndPay() {
        const btn = document.getElementById('pay-button');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<svg class="w-4 h-4 inline animate-spin" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Memuat...';
        }

        fetch('{{ route("payment.snap-token", $order->id) }}')
            .then(res => res.json())
            .then(data => {
                if (data.token) {
                    payWithSnapToken(data.token);
                } else if (window.Alpine && Alpine.store('modal')) {
                    Alpine.store('modal').alert('Gagal memuat token: ' + (data.error || 'Unknown error'), 'error');
                }
            })
            .catch(err => {
                if (window.Alpine && Alpine.store('modal')) {
                    Alpine.store('modal').alert('Koneksi gagal. Coba lagi.', 'error');
                }
            })
            .finally(() => {
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg> Bayar Sekarang';
                }
            });
    }

    // Manual check status pembayaran
    function checkStatusNow() {
        const btn = document.getElementById('check-status-btn');
        if (btn) btn.innerHTML = '<svg class="w-3.5 h-3.5 inline animate-spin" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Memeriksa status...';

        fetch('{{ route("order.check-status", $order->order_number) }}')
            .then(r => r.json())
            .then(data => {
                if (data.paid) {
                    if (window.Alpine && Alpine.store('modal')) {
                        Alpine.store('modal').alert('Pembayaran berhasil diverifikasi! Pesanan sedang diproses.', 'success');
                    }
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    if (btn) btn.innerHTML = '<svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Belum terdeteksi &mdash; Cek lagi';
                }
            })
            .catch(() => {
                if (btn) btn.innerHTML = '<svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Coba cek lagi';
            });
    }

    // Auto-polling setiap 4 detik untuk mendeteksi pembayaran dari HP secara otomatis
    var pollInterval = setInterval(function() {
        fetch('{{ route("order.check-status", $order->order_number) }}')
            .then(r => r.json())
            .then(data => {
                if (data.paid) {
                    clearInterval(pollInterval);
                    if (window.Alpine && Alpine.store('modal')) {
                        Alpine.store('modal').alert('Pembayaran berhasil terdeteksi! Terima kasih.', 'success');
                    }
                    setTimeout(() => window.location.reload(), 1000);
                }
            })
            .catch(() => {});
    }, 4000);

    // Otomatis munculkan pop-up Snap saat halaman pertama kali dibuka
    var hasAutoOpened = false;
    function triggerAutoPayment() {
        if (hasAutoOpened) return;
        hasAutoOpened = true;
        @if($order->midtrans_snap_token)
            payWithSnapToken('{{ $order->midtrans_snap_token }}');
        @else
            fetchAndPay();
        @endif
    }

    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        setTimeout(triggerAutoPayment, 600);
    } else {
        window.addEventListener('load', function() {
            setTimeout(triggerAutoPayment, 600);
        });
    }
</script>
@endif
@endpush

