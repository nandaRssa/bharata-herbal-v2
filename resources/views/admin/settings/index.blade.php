@extends('layouts.admin')
@section('title','Pengaturan Toko')
@section('page-title','Pengaturan Toko')
@section('page-subtitle','Kelola informasi toko dan metode pembayaran')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* â”€â”€ Animations â”€â”€ */
@keyframes fadeUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
.fade-up { animation:fadeUp 0.4s ease forwards; opacity:0; }
.fade-up.d1 { animation-delay:0.05s; }
.fade-up.d2 { animation-delay:0.10s; }
.fade-up.d3 { animation-delay:0.15s; }

/* â”€â”€ Card â”€â”€ */
.card { background:#FFFFFF; border:1px solid #E0E6E2; border-radius:16px; overflow:hidden; margin-bottom:20px; }
.card-header {
    display:flex; align-items:center; gap:10px;
    padding:16px 24px; border-bottom:1px solid #E0E6E2;
}
.card-header-icon {
    width:32px; height:32px; border-radius:8px;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.card-header-icon svg { width:16px; height:16px; }
.card-header-title {
    font-family:'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size:1rem; font-weight:700; color:#0D2618; margin:0;
}
.card-body { padding:24px; }

/* â”€â”€ Form fields â”€â”€ */
.fl { margin-bottom:16px; }
.fl:last-child { margin-bottom:0; }
.fl label {
    display:block; font-family:'Inter',sans-serif;
    font-size:0.8rem; font-weight:600; color:#0D2618; margin-bottom:4px;
}
.fl input[type="text"],
.fl input[type="tel"],
.fl textarea {
    width:100%; padding:10px 14px;
    border:2px solid #E0E6E2; border-radius:10px;
    font-family:'Inter',sans-serif; font-size:0.85rem;
    color:#0D2618; background:#FFFFFF;
    transition:all 0.3s ease; outline:none;
}
.fl input[type="text"]:focus,
.fl input[type="tel"]:focus,
.fl textarea:focus {
    border-color:#0D2618; box-shadow:0 0 0 4px rgba(13, 38, 24, 0.08);
}
.fl textarea { resize:vertical; min-height:70px; }

/* â”€â”€ File upload â”€â”€ */
.file-upload {
    border:2px dashed #E0E6E2; border-radius:12px;
    padding:20px; text-align:center; cursor:pointer;
    transition:all 0.3s ease;
}
.file-upload:hover { border-color:#0D2618; }
.file-upload input { display:none; }
.file-upload .icon { display:flex; justify-content:center; color:#0D2618; margin-bottom:8px; }
.file-upload .text { font-family:'Inter',sans-serif; font-size:0.8rem; color:#8A9A92; }
.file-upload .filename { font-family:'Inter',sans-serif; font-size:0.8rem; color:#0D2618; font-weight:600; margin-top:4px; }
.qris-preview { max-height:120px; border-radius:10px; }
.qris-delete-wrap:hover .qris-delete-btn { opacity:1; }
.qris-delete-btn {
    position:absolute; top:4px; right:4px;
    width:24px; height:24px; border-radius:50%;
    border:none; background:rgba(198,40,40,0.85);
    color:#FFFFFF; font-size:1rem; line-height:1;
    cursor:pointer; opacity:0;
    transition:all 0.2s ease;
    display:flex; align-items:center; justify-content:center;
    padding:0;
}
.qris-delete-btn:hover { background:#C62828; transform:scale(1.1); }
.qris-delete-wrap.marked-delete { opacity:0.4; pointer-events:none; }
.qris-delete-wrap.marked-delete::after {
    content:'Akan dihapus'; position:absolute; bottom:6px; right:6px;
    background:rgba(198,40,40,0.85); color:#FFFFFF;
    font-family:'Inter',sans-serif; font-size:0.6rem; font-weight:600;
    padding:2px 8px; border-radius:4px;
}
.helper-text { font-family:'Inter',sans-serif; font-size:0.75rem; color:#8A9A92; margin-top:6px; }

/* â”€â”€ Grid 2 col â”€â”€ */
.grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
@media (max-width:600px) { .grid-2 { grid-template-columns:1fr; } }

/* â”€â”€ Payment method row â”€â”€ */
.pm-row {
    display:flex; align-items:center; justify-content:space-between;
    padding:14px 18px; border:1px solid #E0E6E2; border-radius:12px;
    cursor:pointer; transition:all 0.3s ease;
}
.pm-row:hover { border-color:#0D2618; }
.pm-row.active { border-color:#2E7D32; background:rgba(46,125,50,0.03); }
.pm-left { display:flex; align-items:center; gap:12px; }
.pm-icon {
    width:40px; height:40px; border-radius:10px;
    background:#FFFFFF; border:1px solid #E0E6E2;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.pm-icon svg { width:20px; height:20px; color:#2E7D32; }
.pm-info .name { font-family:'Inter',sans-serif; font-size:0.85rem; font-weight:600; color:#0D2618; }
.pm-info .desc { font-family:'Inter',sans-serif; font-size:0.75rem; color:#8A9A92; margin-top:1px; }
.pm-info .desc .mid { color:#1565C0; font-weight:500; }
.pm-info .desc .cod { color:#F57F17; font-weight:500; }
.pm-right { display:flex; align-items:center; gap:10px; }
.pm-status { font-family:'Inter',sans-serif; font-size:0.7rem; font-weight:600; }
.pm-status.on { color:#2E7D32; }
.pm-status.off { color:#8A9A92; }

/* â”€â”€ Toggle switch â”€â”€ */
.toggle { position:relative; width:44px; height:24px; flex-shrink:0; }
.toggle input { display:none; }
.toggle .track {
    position:absolute; inset:0;
    background:#D4DCD6; border-radius:12px;
    transition:all 0.3s ease; cursor:pointer;
}
.toggle .track.on { background:#0D2618; }
.toggle .thumb {
    position:absolute; top:2px; left:2px;
    width:20px; height:20px; background:#FFFFFF;
    border-radius:50%; transition:all 0.3s ease;
    box-shadow:0 1px 3px rgba(0,0,0,0.15);
}
.toggle .track.on .thumb { transform:translateX(20px); }

/* â”€â”€ Sandbox info â”€â”€ */
.info-box {
    display:flex; align-items:flex-start; gap:10px;
    padding:14px 18px; margin-top:16px;
    background:rgba(21,101,192,0.06);
    border:1px solid rgba(21,101,192,0.25);
    border-radius:12px;
    font-family:'Inter',sans-serif; font-size:0.8rem; color:#1565C0; line-height:1.5;
}
.info-box svg { width:18px; height:18px; flex-shrink:0; margin-top:1px; }
.info-box code {
    background:rgba(21,101,192,0.10); padding:1px 5px;
    border-radius:4px; font-size:0.75rem;
}

/* â”€â”€ Save button â”€â”€ */
.btn-save {
    width:100%; padding:14px;
    background:linear-gradient(135deg,#0D2618,#0D2618);
    color:#FFFFFF; border:none; border-radius:12px;
    font-family:'Inter',sans-serif; font-size:1rem; font-weight:700;
    cursor:pointer; transition:all 0.3s ease;
    display:inline-flex; align-items:center; justify-content:center; gap:10px;
    margin-top:4px;
}
.btn-save:hover {
    transform:scale(1.01);
    box-shadow:0 8px 30px rgba(13, 38, 24, 0.25);
}

/* â”€â”€ Responsive â”€â”€ */
@media (max-width:768px) {
    .card-body { padding:16px; }
    .card-header { padding:14px 16px; }
    .pm-row { padding:12px 14px; }
}
</style>
@endpush

@section('content')

<!-- â•â•â• HEADER â•â•â• -->
<div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:24px;">
    <div>
        <h2 style="font-family:'Plus Jakarta Sans', 'Inter', sans-serif; font-size:1.8rem; font-weight:700; color:#0D2618; margin:0;">
            Pengaturan Toko
        </h2>
        <p style="font-family:'Inter',sans-serif; font-size:0.9rem; color:#6A7A72; margin:2px 0 0;">
            Kelola informasi toko dan metode pembayaran
        </p>
    </div>
    <a href="{{ route('home') }}" target="_blank"
       style="display:inline-flex; align-items:center; gap:8px; background:#0D2618; color:#FFFFFF; border:none; border-radius:50px; padding:10px 20px; font-family:'Inter',sans-serif; font-size:0.85rem; font-weight:600; text-decoration:none; transition:all 0.3s ease;"
       onmouseover="this.style.background='#0D2618'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(13, 38, 24, 0.2)'"
       onmouseout="this.style.background='#0D2618'; this.style.transform='none'; this.style.boxShadow='none'">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/>
            <polyline points="15 3 21 3 21 9"/>
            <line x1="10" y1="14" x2="21" y2="3"/>
        </svg>
        Lihat Website
    </a>
</div>

<div style="max-width:800px;">

<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" x-data="settingsForm()" class="fade-up d1">
    @csrf @method('PUT')

    @if($errors->any())
    <div style="background:rgba(198,40,40,0.06); border:1px solid rgba(198,40,40,0.20); border-radius:12px; padding:16px 20px; margin-bottom:20px;">
        <ul style="margin:0; padding-left:20px; color:#C62828; font-family:'Inter',sans-serif; font-size:0.85rem;">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif

    {{-- â•â•â• INFORMASI TOKO â•â•â• --}}
    <div class="card fade-up d2">
        <div class="card-header">
            <div class="card-header-icon" style="background:rgba(13, 38, 24, 0.08); color:#0D2618;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <h3 class="card-header-title">Informasi Toko</h3>
        </div>
        <div class="card-body">
            <div class="fl">
                <label>Nama Toko <span style="color:#C62828;">*</span></label>
                <input type="text" name="store_name" value="{{ old('store_name', $settings->store_name) }}" required>
            </div>
            <div class="grid-2">
                <div class="fl">
                    <label>Nomor WhatsApp</label>
                    <input type="tel" name="wa_number" value="{{ old('wa_number', $settings->wa_number) }}" placeholder="628xxxxxxxxxx" inputmode="tel" pattern="[0-9\s\-\+]+" title="Nomor WhatsApp hanya boleh berisi angka, spasi, tanda plus, atau tanda minus.">
                </div>
                <div class="fl">
                    <label>Jam Operasional</label>
                    <input type="text" name="operating_hours" value="{{ old('operating_hours', $settings->operating_hours) }}" placeholder="Senin&ndash;Sabtu 08.00&ndash;17.00">
                </div>
            </div>
            <div class="fl">
                <label>Alamat Toko</label>
                <textarea name="store_address" rows="2" placeholder="Jl. Herbal Nusantara No. 8, Jakarta Pusat">{{ old('store_address', $settings->store_address) }}</textarea>
            </div>
        </div>
    </div>

    {{-- â•â•â• QRIS â•â•â• --}}
    <div class="card fade-up d2">
        <div class="card-header">
            <div class="card-header-icon" style="background:rgba(13, 38, 24, 0.12); color:#0D2618;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                    <circle cx="8.5" cy="8.5" r="1.5"/>
                    <polyline points="21 15 16 10 5 21"/>
                </svg>
            </div>
            <h3 class="card-header-title">Gambar QRIS (Opsional)</h3>
        </div>
        <div class="card-body">
            <label style="display:block; font-family:'Inter',sans-serif; font-size:0.8rem; font-weight:600; color:#0D2618; margin-bottom:6px;">
                Upload QRIS
            </label>
            <div class="file-upload" onclick="document.getElementById('qris-input').click()">
                <div class="icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
                        <polyline points="17 8 12 3 7 8"/>
                        <line x1="12" y1="3" x2="12" y2="15"/>
                    </svg>
                </div>
                <div class="text">Klik untuk upload gambar QRIS</div>
                <div class="filename" id="qris-filename">No file chosen</div>
            </div>
            <input type="file" id="qris-input" name="qris_image" accept="image/*" style="display:none;" onchange="document.getElementById('qris-filename').textContent = this.files[0] ? this.files[0].name : 'No file chosen'">
            @if($settings->qris_image)
            <div style="margin-top:12px;position:relative;display:inline-block;">
                <div style="font-family:'Inter',sans-serif; font-size:0.75rem; color:#8A9A92; margin-bottom:6px;">QRIS Saat Ini:</div>
                <div class="qris-delete-wrap" style="position:relative;display:inline-block;">
                    <img src="{{ asset('storage/'.$settings->qris_image) }}" class="qris-preview" style="display:block;">
                    <button type="button" class="qris-delete-btn" title="Hapus QRIS"
                            onclick="(function(btn){ Alpine.store('modal').confirm('Hapus foto QRIS ini?').then(function(ok){ if(!ok) return; btn.closest('.qris-delete-wrap').classList.add('marked-delete'); var h=document.createElement('input'); h.type='hidden'; h.name='delete_qris'; h.value='1'; btn.closest('form').appendChild(h); }); })(this)">
                        &times;
                    </button>
                </div>
            </div>
            @endif
            <div class="helper-text">Upload foto QRIS statis sebagai backup. Pembayaran utama menggunakan Midtrans.</div>
        </div>
    </div>

    {{-- â•â•â• METODE PEMBAYARAN â•â•â• --}}
    <div class="card fade-up d3">
        <div class="card-header" style="justify-content:space-between; flex-wrap:wrap; gap:10px;">
            <div style="display:flex; align-items:center; gap:10px;">
                <div class="card-header-icon" style="background:rgba(13, 38, 24, 0.12); color:#0D2618;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                        <line x1="1" y1="10" x2="23" y2="10"/>
                    </svg>
                </div>
                <h3 class="card-header-title">Metode Pembayaran</h3>
            </div>
            <span style="display:inline-flex; align-items:center; gap:6px; padding:5px 12px; border-radius:50px; font-size:0.7rem; font-weight:600; background:rgba(21,101,192,0.10); color:#1565C0; border:1px solid rgba(21,101,192,0.15);">
                <span style="width:6px; height:6px; border-radius:50%; background:#1565C0; animation:pulseDot 2s ease-in-out infinite;"></span>
                Midtrans Sandbox
            </span>
        </div>
        <div class="card-body">
            <p style="font-family:'Inter',sans-serif; font-size:0.8rem; color:#8A9A92; margin:0 0 16px;">
                Aktifkan atau nonaktifkan metode pembayaran. Metode yang dinonaktifkan tidak akan muncul di halaman checkout customer.
            </p>
            <div style="display:flex; flex-direction:column; gap:10px;">
                @foreach($availablePaymentMethods as $key => $method)
                <div class="pm-row" :class="toggles['{{ $key }}'] ? 'active' : ''" @click="toggles['{{ $key }}'] = !toggles['{{ $key }}']">
                    <div class="pm-left">
                        <div class="pm-icon">
                            <x-icon :name="$method['icon']" class="w-5 h-5" />
                        </div>
                        <div class="pm-info">
                            <div class="name">{{ $method['label'] }}</div>
                            <div class="desc">
                                @if($method['via_midtrans'])
                                <span class="mid">via Midtrans Snap</span>
                                @else
                                <span class="cod">Tanpa gateway &mdash; bayar langsung saat diterima</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="pm-right">
                        <span class="pm-status" :class="toggles['{{ $key }}'] ? 'on' : 'off'" x-text="toggles['{{ $key }}'] ? 'Aktif' : 'Nonaktif'"></span>
                        <input type="hidden" :name="'payment_method_{{ $key }}'" :value="toggles['{{ $key }}'] ? 1 : 0">
                        <div class="toggle">
                            <div class="track" :class="toggles['{{ $key }}'] ? 'on' : ''">
                                <div class="thumb"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- â•â•â• SAVE â•â•â• --}}
    <button type="submit" class="btn-save">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
            <polyline points="17 21 17 13 7 13 7 21"/>
            <polyline points="7 3 7 8 15 8"/>
        </svg>
        Simpan Pengaturan
    </button>
</form>

</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('settingsForm', () => ({
        toggles: @json(collect($availablePaymentMethods)->mapWithKeys(fn($v, $k) => [$k => isset($enabledPaymentMethods[$k])])),
    }));
});
</script>
<style>
@keyframes pulseDot { 0%,100%{opacity:1;} 50%{opacity:0.35;} }
</style>
@endpush
@endsection
