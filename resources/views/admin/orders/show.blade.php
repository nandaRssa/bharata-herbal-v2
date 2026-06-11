@extends('layouts.admin')
@section('title','Detail Pesanan')
@section('page-title','Detail Pesanan')
@section('page-subtitle','{{ $order->order_number }}')

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    <!-- Kiri: Detail Pesanan -->
    <div class="xl:col-span-2 space-y-6">
        <!-- Info Pelanggan -->
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h3 class="font-bold text-lg mb-4" style="color:var(--primary)">👤 Data Pelanggan</h3>
            <div class="grid grid-cols-2 gap-3 text-sm">
                <div><span class="text-gray-400">Nama</span><p class="font-semibold">{{ $order->customer_name }}</p></div>
                <div><span class="text-gray-400">HP/WA</span>
                    <p class="font-semibold">
                        <a href="https://wa.me/{{ preg_replace('/\D/','',$order->customer_phone) }}" target="_blank" class="text-green-600 hover:underline">{{ $order->customer_phone }}</a>
                    </p>
                </div>
                @if($order->customer_email)
                <div class="col-span-2"><span class="text-gray-400">Email</span><p class="font-semibold">{{ $order->customer_email }}</p></div>
                @endif
            </div>
        </div>

        <!-- Alamat -->
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h3 class="font-bold text-lg mb-4" style="color:var(--primary)">📍 Alamat Pengiriman</h3>
            <p class="text-sm text-gray-600 leading-relaxed">
                {{ $order->address_street }}<br>
                {{ $order->address_kelurahan ? $order->address_kelurahan.', ' : '' }}{{ $order->address_kecamatan }}<br>
                {{ $order->address_city }}, {{ $order->address_province }} {{ $order->address_postal }}
            </p>
            <div class="mt-3 flex gap-3 text-sm">
                <span class="badge badge-blue">{{ $order->shipping_method }}</span>
                @if($order->tracking_number)
                <span class="badge badge-green">Resi: {{ $order->tracking_number }}</span>
                @endif
            </div>
        </div>

        <!-- Item Pesanan -->
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h3 class="font-bold text-lg mb-4" style="color:var(--primary)">📦 Produk Dipesan</h3>
            <table class="w-full text-sm">
                <thead class="border-b">
                    <tr class="text-xs text-gray-400 uppercase">
                        <th class="text-left pb-2">Produk</th>
                        <th class="text-center pb-2">Qty</th>
                        <th class="text-right pb-2">Harga Asli</th>
                        <th class="text-right pb-2">Diskon</th>
                        <th class="text-right pb-2">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr class="border-b border-gray-50">
                        <td class="py-3">{{ $item->product_name }}</td>
                        <td class="py-3 text-center">{{ $item->quantity }}</td>
                        <td class="py-3 text-right">
                            @if($item->original_price && $item->original_price != $item->price)
                            <span class="line-through text-gray-400">Rp {{ number_format($item->original_price,0,',','.') }}</span>
                            <br><span class="text-emerald-700 font-semibold">Rp {{ number_format($item->price,0,',','.') }}</span>
                            @else
                            Rp {{ number_format($item->price,0,',','.') }}
                            @endif
                        </td>
                        <td class="py-3 text-right">
                            @if($item->discount_amount)
                            <span class="text-rose-600 font-semibold">-Rp {{ number_format($item->discount_amount,0,',','.') }}</span>
                            @else
                            <span class="text-gray-300">—</span>
                            @endif
                        </td>
                        <td class="py-3 text-right font-semibold">Rp {{ number_format($item->subtotal,0,',','.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t">
                        <td colspan="3" class="pt-3 text-right text-gray-500">Subtotal</td>
                        <td class="pt-3 text-right font-semibold">Rp {{ number_format($order->subtotal,0,',','.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right text-gray-500">Ongkos Kirim</td>
                        <td class="text-right font-semibold">Rp {{ number_format($order->shipping_cost,0,',','.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right font-bold text-base pt-1" style="color:var(--primary)">TOTAL</td>
                        <td class="text-right font-bold text-base pt-1" style="color:var(--gold)">Rp {{ number_format($order->total_amount,0,',','.') }}</td>
                    </tr>
                </tfoot>
            </table>
            @if($order->notes)
            <div class="mt-4 p-3 bg-gray-50 rounded-lg text-sm text-gray-600">
                <strong>Catatan:</strong> {{ $order->notes }}
            </div>
            @endif
        </div>
    </div>

    <!-- Kanan: Update Status -->
    <div class="space-y-6">
        <!-- Status Saat Ini -->
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h3 class="font-bold text-lg mb-4" style="color:var(--primary)">📊 Status Pesanan</h3>
            <div class="space-y-3 text-sm mb-4">
                <div class="flex justify-between"><span class="text-gray-400">Status</span><span class="badge badge-{{ $order->status_color }}">{{ $order->status_label }}</span></div>
                <div class="flex justify-between"><span class="text-gray-400">Pembayaran</span>
                    <span class="badge {{ $order->payment_status==='confirmed'?'badge-green':($order->payment_status==='failed'?'badge-red':'badge-yellow') }}">{{ $order->payment_status_label }}</span>
                </div>
                <div class="flex justify-between"><span class="text-gray-400">Metode Bayar</span><span class="font-semibold">{{ strtoupper(str_replace('_',' ',$order->payment_method)) }}</span></div>
                <div class="flex justify-between"><span class="text-gray-400">Dibuat</span><span class="font-semibold">{{ $order->created_at->format('d M Y H:i') }}</span></div>
            </div>

            <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                @csrf @method('PUT')
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Update Status</label>
                        <select name="order_status" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                            @foreach(['new'=>'Menunggu Konfirmasi','processing'=>'Diproses','packing'=>'Sedang Dikemas','shipped'=>'Sedang Dikirim','delivered'=>'Selesai','cancelled'=>'Dibatalkan'] as $v=>$l)
                            <option value="{{ $v }}" {{ $order->order_status===$v?'selected':'' }}>{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Status Pembayaran</label>
                        <select name="payment_status" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                            @foreach(['pending'=>'Menunggu','confirmed'=>'Dikonfirmasi','failed'=>'Gagal'] as $v=>$l)
                            <option value="{{ $v }}" {{ $order->payment_status===$v?'selected':'' }}>{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Nomor Resi</label>
                        <input type="text" name="tracking_number" value="{{ $order->tracking_number }}" placeholder="Masukkan nomor resi..."
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                    <button type="submit" class="btn-sm btn-green w-full py-2">💾 Simpan Perubahan</button>
                </div>
            </form>
        </div>

        <!-- Hubungi Pembeli -->
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h3 class="font-bold text-lg mb-3" style="color:var(--primary)">💬 Hubungi Pembeli</h3>
            @php
                $waMsg = "Halo *{$order->customer_name}*, pesanan Anda ({$order->order_number}) sedang dalam proses. Terima kasih telah berbelanja di Bharata Herbal ID! 🌿";
                $waUrl = 'https://wa.me/' . preg_replace('/\D/','',$order->customer_phone) . '?text=' . urlencode($waMsg);
            @endphp
            <a href="{{ $waUrl }}" target="_blank"
               class="flex items-center justify-center gap-2 w-full py-3 rounded-xl font-bold text-white text-sm"
               style="background:#25d366">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                Chat WhatsApp
            </a>
        </div>

        <a href="{{ route('admin.orders.index') }}" class="btn-sm btn-gray w-full text-center py-2 block">← Kembali ke Daftar</a>
    </div>
</div>
@endsection
