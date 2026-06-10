@extends('layouts.admin')
@section('title','Pengaturan Toko')
@section('page-title','Pengaturan Toko')
@section('page-subtitle','Kelola informasi toko dan metode pembayaran')

@section('content')
<div class="max-w-3xl">
<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" x-data="settingsForm()">
    @csrf @method('PUT')

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
        <ul class="text-red-700 text-sm list-disc pl-4">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif

    {{-- Info Dasar --}}
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
        <h3 class="font-bold text-lg mb-4" style="color:var(--primary)">🏪 Informasi Toko</h3>
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Toko *</label>
                <input type="text" name="store_name" value="{{ old('store_name', $settings->store_name) }}" required
                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor WhatsApp</label>
                <input type="text" name="wa_number" value="{{ old('wa_number', $settings->wa_number) }}" placeholder="628xxxxxxxxxx"
                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Jam Operasional</label>
                <input type="text" name="operating_hours" value="{{ old('operating_hours', $settings->operating_hours) }}" placeholder="Senin-Sabtu 08.00-17.00"
                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Toko</label>
                <textarea name="store_address" rows="2" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-400">{{ old('store_address', $settings->store_address) }}</textarea>
            </div>
        </div>
    </div>

    {{-- QRIS --}}
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
        <h3 class="font-bold text-lg mb-4" style="color:var(--primary)">📷 Gambar QRIS (Opsional)</h3>
        @if($settings->qris_image)
        <div class="mb-3">
            <p class="text-xs text-gray-400 mb-2">QRIS Saat Ini:</p>
            <img src="{{ asset('storage/'.$settings->qris_image) }}" class="h-32 rounded-lg border">
        </div>
        @endif
        <input type="file" name="qris_image" accept="image/*"
            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm cursor-pointer">
        <p class="text-xs text-gray-400 mt-1">Upload foto QRIS statis sebagai backup. Pembayaran utama menggunakan Midtrans.</p>
    </div>

    {{-- Metode Pembayaran Midtrans --}}
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
        <div class="flex items-center justify-between mb-1">
            <h3 class="font-bold text-lg" style="color:var(--primary)">💳 Metode Pembayaran</h3>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse inline-block"></span>
                Midtrans Sandbox
            </span>
        </div>
        <p class="text-xs text-gray-400 mb-5">Aktifkan atau nonaktifkan metode pembayaran. Metode yang dinonaktifkan tidak akan muncul di halaman checkout customer.</p>

        <div class="space-y-3">
            @foreach($availablePaymentMethods as $key => $method)
            <div class="flex items-center justify-between p-4 border rounded-xl cursor-pointer transition-all duration-150"
                :class="toggles['{{ $key }}'] ? 'border-green-200 bg-green-50/40' : 'border-gray-200 bg-gray-50/30'"
                @click="toggles['{{ $key }}'] = !toggles['{{ $key }}']">
                <div class="flex items-center gap-3">
                    <span class="text-xl">{{ $method['icon'] }}</span>
                    <div>
                        <div class="font-semibold text-sm text-gray-800">{{ $method['label'] }}</div>
                        <div class="text-xs text-gray-400 mt-0.5">
                            @if($method['via_midtrans'])
                                <span class="text-blue-500 font-medium">via Midtrans Snap</span>
                            @else
                                <span class="text-amber-600 font-medium">Tanpa gateway — bayar langsung saat diterima</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs font-semibold" :class="toggles['{{ $key }}'] ? 'text-green-600' : 'text-gray-400'">
                        <span x-text="toggles['{{ $key }}'] ? 'Aktif' : 'Nonaktif'"></span>
                    </span>
                    {{-- Hidden input always submitted: 0 = off, 1 = on --}}
                    <input type="hidden" :name="'payment_method_{{ $key }}'" :value="toggles['{{ $key }}'] ? 1 : 0">
                    {{-- Toggle switch --}}
                    <div class="relative pointer-events-none">
                        <div class="w-11 h-6 rounded-full transition-all duration-200"
                            :class="toggles['{{ $key }}'] ? 'bg-green-500' : 'bg-gray-200'">
                            <div class="h-5 w-5 rounded-full bg-white border transition-all duration-200 shadow-sm"
                                :class="toggles['{{ $key }}'] ? 'translate-x-[22px] border-white' : 'translate-x-[2px] border-gray-300'">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4 p-3 bg-amber-50 border border-amber-200 rounded-lg text-xs text-amber-700 leading-relaxed">
            <strong>💡 Info Sandbox:</strong> Saat ini menggunakan Midtrans Sandbox. Transaksi tidak memotong uang nyata.
            Untuk beralih ke Production, ubah <code class="bg-amber-100 px-1 rounded">MIDTRANS_IS_PRODUCTION=true</code> di file <code class="bg-amber-100 px-1 rounded">.env</code>.
        </div>
    </div>

    <div class="flex gap-3">
        <button type="submit" class="btn-sm btn-green px-8 py-2.5">💾 Simpan Pengaturan</button>
    </div>
</form>
</div>
@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('settingsForm', () => ({
        toggles: @json(collect($availablePaymentMethods)->mapWithKeys(fn($v, $k) => [$k => isset($enabledPaymentMethods[$k])])),
        toggle(key) {
            this.toggles[key] = !this.toggles[key];
        }
    }));
});
</script>
@endpush
@endsection
