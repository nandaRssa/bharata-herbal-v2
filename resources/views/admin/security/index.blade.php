@extends('layouts.admin')
@section('title', 'Privasi & Keamanan Admin')
@section('page-title', 'Privasi & Keamanan')
@section('page-subtitle', 'Kelola akun administrator dan perbarui kata sandi')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* ── Animations ── */
@keyframes fadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
.fade-up { animation:fadeUp 0.4s ease forwards; opacity:0; }
.fade-up.d1 { animation-delay:0.05s; }
.fade-up.d2 { animation-delay:0.10s; }
.fade-up.d3 { animation-delay:0.15s; }

/* ── Card ── */
.sec-card { background:#FFFFFF; border:1px solid #E0E6E2; border-radius:16px; overflow:hidden; margin-bottom:24px; box-shadow:0 1px 3px rgba(0,0,0,0.02); }
.sec-card-header {
    display:flex; align-items:center; justify-content:space-between;
    padding:18px 24px; border-bottom:1px solid #E0E6E2; background:#FAFCFA;
}
.sec-header-left { display:flex; align-items:center; gap:12px; }
.sec-header-icon {
    width:36px; height:36px; border-radius:10px;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.sec-header-icon svg { width:18px; height:18px; }
.sec-header-title {
    font-family:'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size:1.05rem; font-weight:700; color:#0D2618; margin:0;
}
.sec-header-subtitle {
    font-family:'Inter',sans-serif; font-size:0.75rem; color:#6A7A72; margin:2px 0 0;
}
.sec-card-body { padding:24px; }

/* ── Form Fields ── */
.form-group { margin-bottom:18px; }
.form-group:last-child { margin-bottom:0; }
.form-group label {
    display:block; font-family:'Inter',sans-serif;
    font-size:0.82rem; font-weight:600; color:#0D2618; margin-bottom:6px;
}
.input-wrap {
    position:relative; display:flex; align-items:center;
}
.input-wrap input {
    width:100%; padding:11px 14px;
    border:1.5px solid #E0E6E2; border-radius:10px;
    font-family:'Inter',sans-serif; font-size:0.875rem;
    color:#0D2618; background:#FFFFFF;
    transition:all 0.25s ease; outline:none;
}
.input-wrap input:focus {
    border-color:#0D2618; box-shadow:0 0 0 4px rgba(13, 38, 24, 0.08);
}
.input-wrap.has-icon input { padding-left:40px; }
.input-wrap.has-toggle input { padding-right:42px; }
input::-ms-reveal,
input::-ms-clear {
    display: none !important;
}
.input-icon-left {
    position:absolute; left:14px; color:#8A9A92; pointer-events:none;
    display:flex; align-items:center; justify-content:center;
}
.input-icon-left svg { width:17px; height:17px; }
.toggle-pwd-btn {
    position:absolute; right:10px; background:none; border:none;
    color:#8A9A92; cursor:pointer; padding:6px; border-radius:6px;
    display:flex; align-items:center; justify-content:center;
    transition:color 0.2s ease;
}
.toggle-pwd-btn:hover { color:#0D2618; }
.toggle-pwd-btn svg { width:18px; height:18px; }

.field-error {
    font-family:'Inter',sans-serif; font-size:0.75rem; color:#C62828;
    margin-top:5px; display:flex; align-items:center; gap:4px;
}

/* ── Badges & Alerts ── */
.admin-badge {
    display:inline-flex; align-items:center; gap:6px;
    padding:4px 12px; border-radius:50px;
    font-family:'Inter',sans-serif; font-size:0.72rem; font-weight:700;
    background:rgba(13, 38, 24, 0.08); color:#0D2618; border:1px solid rgba(13, 38, 24, 0.15);
}
.alert-success {
    display:flex; align-items:center; gap:10px;
    background:rgba(46,125,50,0.08); border:1px solid rgba(46,125,50,0.25);
    border-radius:12px; padding:12px 18px; margin-bottom:20px;
    font-family:'Inter',sans-serif; font-size:0.83rem; color:#2E7D32; font-weight:500;
}
.alert-success svg { width:18px; height:18px; flex-shrink:0; }

/* ── Security Tips Box ── */
.sec-tip-box {
    background:#F4F8F5; border:1px solid #D6E4DB; border-radius:12px;
    padding:16px; margin-top:20px;
}
.sec-tip-title {
    font-family:'Inter',sans-serif; font-size:0.8rem; font-weight:700;
    color:#0D2618; display:flex; align-items:center; gap:6px; margin-bottom:8px;
}
.sec-tip-list {
    margin:0; padding-left:18px; font-family:'Inter',sans-serif;
    font-size:0.75rem; color:#52665B; line-height:1.6;
}

/* ── Buttons ── */
.btn-primary-admin {
    display:inline-flex; align-items:center; justify-content:center; gap:8px;
    padding:11px 22px; background:#0D2618; color:#FFFFFF; border:none;
    border-radius:10px; font-family:'Inter',sans-serif; font-size:0.875rem;
    font-weight:600; cursor:pointer; transition:all 0.25s ease;
}
.btn-primary-admin:hover {
    background:#163F28; transform:translateY(-1px);
    box-shadow:0 6px 18px rgba(13, 38, 24, 0.2);
}

.btn-secondary-admin {
    display:inline-flex; align-items:center; justify-content:center; gap:8px;
    padding:11px 20px; background:#F0F4F1; color:#0D2618; border:1px solid #D4DCD6;
    border-radius:10px; font-family:'Inter',sans-serif; font-size:0.875rem;
    font-weight:600; cursor:pointer; transition:all 0.2s ease;
}
.btn-secondary-admin:hover { background:#E4ECE6; }

/* ── Responsive ── */
@media (max-width:768px) {
    .sec-card-header { padding:14px 18px; }
    .sec-card-body { padding:18px; }
}
</style>
@endpush

@section('content')

<div style="max-width:860px; margin:0 auto;">

    <!-- ── Header ── -->
    <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:24px;">
        <div>
            <h2 style="font-family:'Plus Jakarta Sans', 'Inter', sans-serif; font-size:1.8rem; font-weight:700; color:#0D2618; margin:0;">
                Privasi &amp; Keamanan
            </h2>
            <p style="font-family:'Inter',sans-serif; font-size:0.9rem; color:#6A7A72; margin:3px 0 0;">
                Kelola kredensial akun administrator dan perlindungan keamanan sistem
            </p>
        </div>
        <div class="admin-badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
            Administrator Utama
        </div>
    </div>

    <!-- ── Alert Sukses Profil ── -->
    @if(session('success_profile'))
    <div class="alert-success fade-up">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"/>
        </svg>
        <span>{{ session('success_profile') }}</span>
    </div>
    @endif

    <!-- ── Alert Sukses Password ── -->
    @if(session('success_password'))
    <div class="alert-success fade-up">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"/>
        </svg>
        <span>{{ session('success_password') }}</span>
    </div>
    @endif

    <!-- ── KARTU 1: INFORMASI PROFIL & AKUN ── -->
    <div class="sec-card fade-up d1">
        <div class="sec-card-header">
            <div class="sec-header-left">
                <div class="sec-header-icon" style="background:rgba(13, 38, 24, 0.08); color:#0D2618;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <div>
                    <h3 class="sec-header-title">Informasi Akun Admin</h3>
                    <p class="sec-header-subtitle">Nama dan alamat email yang digunakan untuk masuk ke panel admin</p>
                </div>
            </div>
            <div class="hidden sm:flex items-center gap-2 text-xs text-slate-500 font-medium font-sans">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                Aktif
            </div>
        </div>
        <div class="sec-card-body">
            <form method="POST" action="{{ route('admin.security.profile') }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <!-- Nama Admin -->
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <div class="input-wrap has-icon">
                            <span class="input-icon-left">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                            </span>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required placeholder="Administrator">
                        </div>
                        @error('name')
                        <div class="field-error">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Email Admin -->
                    <div class="form-group">
                        <label for="email">Alamat Email (Login ID)</label>
                        <div class="input-wrap has-icon">
                            <span class="input-icon-left">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                    <polyline points="22,6 12,13 2,6"/>
                                </svg>
                            </span>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required placeholder="Masukkan alamat email">
                        </div>
                        @error('email')
                        <div class="field-error">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-between pt-3 border-t border-slate-100 flex-wrap gap-3">
                    <span class="text-xs text-slate-400 font-sans">
                        Terdaftar sejak: <strong>{{ $user->created_at ? $user->created_at->format('d M Y') : '2026' }}</strong>
                    </span>
                    <button type="submit" class="btn-primary-admin">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Simpan Perubahan Profil
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ── KARTU 2: GANTI KATA SANDI ── -->
    <div class="sec-card fade-up d2" x-data="{ showCur: false, showNew: false, showConf: false }">
        <div class="sec-card-header">
            <div class="sec-header-left">
                <div class="sec-header-icon" style="background:rgba(217, 119, 6, 0.12); color:#D97706;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0110 0v4"/>
                    </svg>
                </div>
                <div>
                    <h3 class="sec-header-title">Perbarui Kata Sandi</h3>
                    <p class="sec-header-subtitle">Pastikan menggunakan kombinasi huruf dan angka yang kuat demi keamanan sistem</p>
                </div>
            </div>
            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 border border-amber-200/60 font-sans">
                Keamanan
            </span>
        </div>
        <div class="sec-card-body">
            <form method="POST" action="{{ route('admin.security.password') }}">
                @csrf
                @method('PUT')

                <!-- Kata Sandi Saat Ini -->
                <div class="form-group">
                    <label for="current_password">Kata Sandi Saat Ini <span style="color:#C62828;">*</span></label>
                    <div class="input-wrap has-icon has-toggle">
                        <span class="input-icon-left">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0110 0v4"/>
                            </svg>
                        </span>
                        <input :type="showCur ? 'text' : 'password'" id="current_password" name="current_password" required placeholder="Masukkan kata sandi lama Anda">
                        <button type="button" class="toggle-pwd-btn" @click="showCur = !showCur" :title="showCur ? 'Sembunyikan' : 'Tampilkan'">
                            <svg x-show="!showCur" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg x-show="showCur" style="display:none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/>
                                <line x1="1" y1="1" x2="23" y2="23"/>
                            </svg>
                        </button>
                    </div>
                    @error('current_password')
                    <div class="field-error">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <!-- Kata Sandi Baru -->
                    <div class="form-group">
                        <label for="password">Kata Sandi Baru <span style="color:#C62828;">*</span></label>
                        <div class="input-wrap has-icon has-toggle">
                            <span class="input-icon-left">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 2l-2 2m-1.5 1.5L10 13l-4 4-2-2-4 4 1.5 1.5L6 16l4-4 7.5-7.5M21 2l-2-2-4 4 2 2 4-4z"/>
                                </svg>
                            </span>
                            <input :type="showNew ? 'text' : 'password'" id="password" name="password" required placeholder="Minimal 8 karakter (huruf & angka)">
                            <button type="button" class="toggle-pwd-btn" @click="showNew = !showNew" :title="showNew ? 'Sembunyikan' : 'Tampilkan'">
                                <svg x-show="!showNew" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                </svg>
                                <svg x-show="showNew" style="display:none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/>
                                <line x1="1" y1="1" x2="23" y2="23"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                        <div class="field-error">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Konfirmasi Kata Sandi Baru -->
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Kata Sandi Baru <span style="color:#C62828;">*</span></label>
                        <div class="input-wrap has-icon has-toggle">
                            <span class="input-icon-left">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                            </span>
                            <input :type="showConf ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi kata sandi baru">
                            <button type="button" class="toggle-pwd-btn" @click="showConf = !showConf" :title="showConf ? 'Sembunyikan' : 'Tampilkan'">
                                <svg x-show="!showConf" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                </svg>
                                <svg x-show="showConf" style="display:none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/>
                                <line x1="1" y1="1" x2="23" y2="23"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tips Keamanan -->
                <div class="sec-tip-box">
                    <div class="sec-tip-title">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>
                        </svg>
                        Pedoman Keamanan Kata Sandi:
                    </div>
                    <ul class="sec-tip-list">
                        <li>Panjang minimal <strong>8 karakter</strong></li>
                        <li>Wajib mengombinasikan <strong>huruf</strong> dan <strong>angka</strong></li>
                        <li>Disarankan tidak menggunakan kata sandi yang sama dengan akun pribadi lainnya</li>
                        <li>Setelah mengganti password, Anda akan langsung menggunakan password baru ini untuk login berikutnya</li>
                    </ul>
                </div>

                <div class="pt-5 mt-4 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="btn-primary-admin" style="background:#0D2618;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0110 0v4"/>
                        </svg>
                        Perbarui Kata Sandi
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection
