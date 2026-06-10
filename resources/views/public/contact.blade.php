@extends('layouts.public')
@section('title', 'Hubungi Kontak Kami')

@section('content')
<!-- Header Halaman -->
<div class="relative py-28 overflow-hidden bg-white border-b border-slate-100">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-gradient-to-tr from-emerald-50 to-emerald-100 rounded-full blur-3xl opacity-60 pointer-events-none -translate-y-1/2"></div>
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M54.627 0l.83.83v58.34l-.83.83H5.373l-.83-.83V.83l.83-.83h49.254zM53.5 2.127H6.5v55.746h47V2.127z\' fill=\'%23008060\' fill-opacity=\'0.02\' fill-rule=\'evenodd\'/%3E%3C/svg%3E')]"></div>
    
    <div class="relative z-10 max-w-4xl mx-auto px-4 text-center">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold mb-6 tracking-wide shadow-sm" style="background-color: var(--primary-light); color: var(--primary);">
            <div class="w-1.5 h-1.5 rounded-full" style="background-color: var(--primary);"></div>
            Get In Touch
        </div>
        
        <!-- Heading -->
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight mb-6">
            Hubungi Layanan Kami
        </h1>
        
        <!-- Description -->
        <p class="text-lg md:text-xl text-slate-600 max-w-2xl mx-auto leading-relaxed">
            Tim terapis & admin kami siap menjawab segala keluhan dan pertanyaan pesanan Anda.
        </p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-16">
        <!-- Info Kontak -->
        <div class="space-y-6">
            <h2 class="text-3xl font-bold font-serif-elegant" style="color: var(--primary);">Informasi Kontak</h2>

            @if($settings->wa_number)
            <div class="bg-white rounded-2xl p-5 flex items-center gap-4 border border-slate-100 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white text-xl shadow-sm" style="background: #25d366;">
                    📱
                </div>
                <div>
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-400">WhatsApp</div>
                    <a href="https://wa.me/{{ preg_replace('/\D/','', $settings->wa_number) }}" class="font-bold text-slate-700 hover:text-emerald-800 transition">{{ $settings->wa_number }}</a>
                </div>
            </div>
            @endif

            @if($settings->store_address)
            <div class="bg-white rounded-2xl p-5 flex items-center gap-4 border border-slate-100 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white text-xl shadow-sm" style="background: var(--primary);">
                    📍
                </div>
                <div>
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-400">Alamat Showroom</div>
                    <p class="text-slate-600 text-xs font-medium leading-relaxed mt-0.5">{{ $settings->store_address }}</p>
                </div>
            </div>
            @endif

            @if($settings->operating_hours)
            <div class="bg-white rounded-2xl p-5 flex items-center gap-4 border border-slate-100 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white text-xl shadow-sm" style="background: var(--gold);">
                    ⏰
                </div>
                <div>
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-400">Jam Operasional</div>
                    <p class="text-slate-600 text-xs font-semibold mt-0.5">{{ $settings->operating_hours }}</p>
                </div>
            </div>
            @endif

            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm space-y-4">
                <h3 class="font-bold text-xs uppercase tracking-widest text-slate-400 border-b border-slate-100 pb-2 flex items-center gap-2">
                    💳 Metode Pembayaran Digital
                </h3>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">Kami menerima pembayaran digital melalui <strong class="text-blue-600">Midtrans</strong> — proses checkout aman dan terenkripsi.</p>
                <div class="flex flex-wrap gap-2">
                    @foreach($availablePaymentMethods as $key => $method)
                        @if(isset($enabledPaymentMethods[$key]) && $method['via_midtrans'])
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-slate-50 border border-slate-200 text-slate-700">
                            <span>{{ $method['icon'] }}</span>
                            @if($key === 'bank_transfer') Bank Transfer
                            @elseif($key === 'brimo') BRImo
                            @else{{ $method['label'] }}
                            @endif
                        </span>
                        @endif
                    @endforeach
                    @if(isset($enabledPaymentMethods['cod']))
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-amber-50 border border-amber-200 text-amber-700">
                        <span>🚪</span> COD (Bayar di Tempat)
                    </span>
                    @endif
                </div>
                <div class="pt-2 text-[10px] text-slate-400 font-medium border-t border-slate-100">🛡️ Transaksi diproses melalui Midtrans Snap — pembayaran langsung terverifikasi.</div>
            </div>
        </div>

        <!-- CTA WhatsApp -->
        <div class="flex flex-col justify-center">
            <div class="bg-white rounded-3xl p-8 lg:p-10 text-center border border-slate-100 shadow-sm">
                <div class="w-16 h-16 rounded-full flex items-center justify-center bg-emerald-50 mx-auto mb-6">
                    <span class="text-3xl">💬</span>
                </div>
                <h3 class="text-2xl font-bold font-serif-elegant mb-3" style="color: var(--primary);">Konsultasi & Layanan Cepat</h3>
                <p class="text-slate-400 mb-8 text-xs leading-relaxed max-w-xs mx-auto">Kami menyambut baik kritik, saran, atau sekadar konsultasi keluhan penyakit secara personal dan rahasia.</p>
                @if($settings->wa_number)
                <a href="https://wa.me/{{ preg_replace('/\D/','', $settings->wa_number) }}?text=Halo%20Bharata%20Herbal%2C%20saya%20ingin%20bertanya..."
                   target="_blank" class="flex items-center justify-center gap-2 w-full py-4 rounded-xl font-bold text-white shadow-md hover:shadow-lg transition duration-200" style="background: #25d366;">
                    Chat WhatsApp Sekarang
                </a>
                @endif
                <div class="mt-8 pt-6 border-t border-slate-100 text-xs text-slate-400 font-semibold flex items-center justify-between">
                    <span>Atau kunjungi katalog kami</span>
                    <a href="{{ route('products.index') }}" class="font-bold hover:underline" style="color: var(--primary);">Semua Produk →</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
