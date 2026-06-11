@extends('layouts.public')
@section('title', 'Riwayat Pesanan')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-16">
    <div class="text-center mb-10">
        <h1 class="text-3xl md:text-4xl font-bold font-serif-elegant mb-3" style="color: var(--primary);">Riwayat Pesanan</h1>
        <p class="text-slate-500 font-medium">Lacak dan lihat semua pesanan Anda sebelumnya dengan memasukkan nomor WhatsApp Anda.</p>
    </div>

    <!-- Form Pencarian -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 mb-10">
        <form method="POST" action="{{ route('order.history.check') }}" class="flex flex-col md:flex-row gap-4">
            @csrf
            <div class="flex-grow">
                <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Nomor WhatsApp</label>
                <input type="tel" name="phone" id="phone" value="{{ $phone ?? old('phone') }}" required placeholder="Contoh: 08123456789"
                    class="w-full border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-600/30 text-slate-700 font-medium transition duration-200">
                @error('phone')
                    <span class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</span>
                @enderror
            </div>
            <div class="md:self-end">
                <button type="submit" class="w-full md:w-auto px-8 py-3.5 rounded-xl font-bold text-white transition duration-200 shadow-md hover:shadow-lg" style="background: var(--primary);">
                    Cek Riwayat
                </button>
            </div>
        </form>
    </div>

    <!-- Hasil Pencarian -->
    @if(isset($orders))
        @if($orders->count() > 0)
            <div class="space-y-6">
                <h2 class="text-xl font-bold text-slate-800 border-b border-slate-100 pb-3">Ditemukan {{ $orders->count() }} Pesanan</h2>
                @foreach($orders as $order)
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 hover:shadow-md transition duration-300">
                        <div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mb-4 pb-4 border-b border-slate-50">
                            <div>
                                <div class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-1">{{ $order->created_at->format('d M Y, H:i') }}</div>
                                <div class="text-lg font-bold font-serif-elegant" style="color: var(--primary);">{{ $order->order_number }}</div>
                            </div>
                            <div>
                                <span class="px-3.5 py-1.5 rounded-full text-xs font-bold
                                    @if($order->status_color === 'green') bg-emerald-100 text-emerald-800
                                    @elseif($order->status_color === 'yellow') bg-amber-100 text-amber-800
                                    @elseif($order->status_color === 'blue') bg-blue-100 text-blue-800
                                    @elseif($order->status_color === 'purple') bg-purple-100 text-purple-800
                                    @elseif($order->status_color === 'indigo') bg-indigo-100 text-indigo-800
                                    @elseif($order->status_color === 'red') bg-rose-100 text-rose-800
                                    @else bg-slate-100 text-slate-800 @endif">
                                    {{ $order->status_label }}
                                </span>
                            </div>
                        </div>

                        <div class="space-y-3 mb-6">
                            @foreach($order->items as $item)
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-slate-600 font-medium">{{ $item->product_name }} <span class="text-slate-400">× {{ $item->quantity }}</span></span>
                                    <div class="text-right">
                                        @if($item->original_price && $item->original_price != $item->price)
                                        <div class="text-[10px] text-slate-400 line-through">Rp {{ number_format($item->original_price * $item->quantity, 0, ',', '.') }}</div>
                                        @endif
                                        <span class="font-semibold text-slate-700">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            @endforeach
                            <div class="flex justify-between items-center pt-3 border-t border-slate-50">
                                <span class="text-sm font-bold text-slate-800">Total Belanja</span>
                                <span class="font-bold text-slate-800">{{ $order->formatted_total }}</span>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('order.track.show', $order->order_number) }}" class="inline-block px-5 py-2.5 rounded-lg border border-slate-200 text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition">
                                Detail Pesanan &rarr;
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-amber-50 border border-amber-100 rounded-2xl p-8 text-center">
                <div class="text-4xl mb-3">🔍</div>
                <h3 class="font-bold text-amber-800 mb-1">Tidak Ada Pesanan Ditemukan</h3>
                <p class="text-sm text-amber-700/80">Kami tidak dapat menemukan pesanan yang terhubung dengan nomor WhatsApp {{ $phone }}. Pastikan nomor yang Anda masukkan benar.</p>
            </div>
        @endif
    @endif
</div>
@endsection
