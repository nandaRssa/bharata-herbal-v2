<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | Admin Bharata Herbal ID</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}?v=2">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}?v=2">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>

    <style>
        :root {
            --primary-dark:  #0D2618;
            --primary:       #0D2618;
            --primary-light: #2D6B44;
            --green-dark:    #0D2618;
            --green-medium:  #0D2618;
            --green-light:   #2D5A3E;
            --bg-body:       #F8FAF7;
            --bg-off:        #F8FAF7;
            --bg-dark:       #E8F0EC;
            --text-dark:     #0F172A;
            --text-soft:     #2D2D2D;
            --text-muted:    #94A3B8;
            --border:        #E2E8F0;
            --border-muted:  #D4DCD6;
            --sidebar-w:     256px;
        }
        *, *::before, *::after { box-sizing: border-box; }
        input::-ms-reveal, input::-ms-clear { display: none !important; }
        body {
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif;
            background: #f1f5f2;
            color: #1e2925;
            margin: 0;
        }
        h1,h2,h3,h4,h5,h6,button,input,select,textarea {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        }
        .font-serif-elegant { font-family: 'Inter', sans-serif; font-weight: 700; }

        /* â”€â”€ Sidebar â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            overflow-y: auto;
            background: var(--primary-dark);
            border-right: 1px solid rgba(255,255,255,0.06);
            z-index: 40;
            display: flex;
            flex-direction: column;
            transition: transform 0.26s cubic-bezier(.4,0,.2,1);
        }
        /* Desktop: always visible */
        @media (min-width: 1024px) {
            .sidebar { transform: none !important; }
        }
        /* Mobile: slide off screen by default */
        @media (max-width: 1023px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: .625rem;
            padding: .6rem 1rem;
            color: #a3c2b2;
            border-radius: .625rem;
            margin: .1rem .625rem;
            font-size: .8125rem;
            font-weight: 500;
            transition: all 0.16s;
            text-decoration: none;
            white-space: nowrap;
        }
        .sidebar a:hover { background: rgba(255,255,255,0.07); color: #e2f0e8; }
        .sidebar a.active {
            background: linear-gradient(135deg, rgba(44,99,58,0.9) 0%, rgba(28,69,38,0.7) 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.18);
            border-left: 2px solid rgba(255,255,255,0.3);
        }
        .sidebar .nav-section {
            font-size: .6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .14em;
            color: rgba(255,255,255,0.5);
            padding: .875rem 1rem .25rem;
        }

        /* â”€â”€ Overlay â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        #sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 35;
            display: none;
            opacity: 0;
            transition: opacity 0.22s;
        }
        #sidebar-overlay.visible { opacity: 1; }

        /* â”€â”€ Prevent white flash on fade-up & x-cloak â”€â”€ */
        [x-cloak] { display: none !important; }
        .fade-up { opacity: 0; }

        /* â”€â”€ Top bar â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .topbar {
            background: #ffffff;
            border-bottom: 1px solid #e8edf0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            position: sticky;
            top: 0;
            z-index: 20;
        }

        /* â”€â”€ Main wrapper â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .admin-main {
            margin-left: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            width: 100%;
        }
        @media (min-width: 1024px) {
            .admin-main { margin-left: var(--sidebar-w); width: calc(100% - var(--sidebar-w)); }
        }

        /* â”€â”€ Responsive table helper â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }

        /* â”€â”€ Form input base â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .form-input {
            width: 100%;
            border: 1px solid #e2e8f0;
            border-radius: .75rem;
            padding: .625rem 1rem;
            font-size: .875rem;
            color: #374151;
            font-family: 'Inter', sans-serif;
            transition: border-color 0.15s, box-shadow 0.15s;
            background: white;
        }
        .form-input:focus {
            outline: none;
            border-color: #0D2618;
            box-shadow: 0 0 0 3px rgba(13, 38, 24, 0.1);
        }
        .form-label {
            display: block;
            font-size: .7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .09em;
            color: #94a3b8;
            margin-bottom: .375rem;
        }

        /* â”€â”€ Icon animations & hover effects â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .sidebar a svg {
            transition: transform 0.25s ease, opacity 0.25s ease;
        }
        .sidebar a:hover svg {
            transform: scale(1.15);
            opacity: 0.9;
        }
        .sidebar a.active svg {
            transform: scale(1.05);
        }

        /* Button hover lift â€” all buttons & pill/rounded links in admin content */
        .admin-main button,
        .admin-main a[class*="rounded"] {
            transition: transform 0.2s ease, box-shadow 0.2s ease !important;
        }
        .admin-main button:hover,
        .admin-main a[class*="rounded"]:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .admin-main button:active,
        .admin-main a[class*="rounded"]:active {
            transform: translateY(0) scale(0.97);
        }
        /* Icon subtle animation in content area */
        .admin-main button svg,
        .admin-main a[class*="rounded"] svg {
            transition: transform 0.25s ease;
        }
        .admin-main button:hover svg,
        .admin-main a[class*="rounded"]:hover svg {
            transform: scale(1.2);
        }
        /* Topbar link hover */
        .topbar a {
            transition: all 0.2s ease;
        }
        .topbar a:hover {
            transform: translateY(-1px);
        }

        /* Nav link indicator pulse */
        @keyframes navPulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }
        .sidebar a.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 20px;
            background: rgba(255,255,255,0.6);
            border-radius: 0 3px 3px 0;
            animation: navPulse 2s ease-in-out infinite;
        }
        .sidebar a {
            position: relative;
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- â”€â”€ Overlay â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ -->
    <div id="sidebar-overlay" onclick="closeSidebar()"></div>

    <!-- â”€â”€ Sidebar â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ -->
    <aside class="sidebar" id="main-sidebar">
        <div class="p-5 border-b border-white/5 flex items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Bharata Herbal" class="w-10 h-10 rounded-xl object-contain flex-shrink-0">
                <div>
                    <div class="text-sm font-bold text-white tracking-tight leading-none">Bharata Herbal</div>
                    <span class="text-[9px] uppercase tracking-widest mt-0.5 block font-medium" style="color: #A8DDBF;">Premium Wellness</span>
                </div>
            </div>
            <!-- Close button â€” mobile only -->
            <button onclick="closeSidebar()" class="lg:hidden text-slate-400 hover:text-white p-1 transition flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <nav class="flex-1 py-4 overflow-y-auto">
            <div class="nav-section">Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <div class="nav-section">Katalog</div>
            <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                Daftar Produk
            </a>
            <a href="{{ route('admin.stock.index') }}" class="{{ request()->routeIs('admin.stock.*') ? 'active' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Kelola Stok
            </a>

            <div class="nav-section">Transaksi</div>
            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                Pesanan Masuk
            </a>
            <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Laporan Keuangan
            </a>

            <div class="nav-section">Pelanggan</div>
            <a href="{{ route('admin.reviews.index') }}" class="{{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                Ulasan Produk
            </a>

            <div class="nav-section">Pengaturan</div>
            <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Toko &amp; Pembayaran
            </a>
            <a href="{{ route('admin.security.index') }}" class="{{ request()->routeIs('admin.security.*') ? 'active' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                Privasi &amp; Keamanan
            </a>
        </nav>

        <!-- User info -->
        <div class="p-4 border-t border-white/5">
            <a href="{{ route('admin.security.index') }}" class="flex items-center gap-2.5 mb-3 p-1.5 -m-1.5 rounded-lg hover:bg-white/5 transition group" title="Buka Pengaturan Akun & Keamanan">
                <div class="w-7 h-7 rounded-lg flex items-center justify-center text-white text-xs font-bold bg-white/10 flex-shrink-0 group-hover:bg-emerald-600 transition">
                    {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="min-w-0 flex-1">
                    <div class="text-xs font-semibold text-slate-300 truncate group-hover:text-white transition">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <div class="text-[10px] text-slate-400">Pengaturan Akun &rarr;</div>
                </div>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full text-left text-xs text-rose-400 hover:text-rose-200 font-semibold transition flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-white/5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- ── Main Content Area ────────────────────────────────────── -->
    <div class="admin-main">

        <!-- Top Bar -->
        <header class="topbar px-4 lg:px-7 py-3.5 flex items-center justify-between">
            <div class="flex items-center gap-3 min-w-0">
                <!-- Hamburger — mobile only -->
                <button onclick="openSidebar()"
                        class="lg:hidden p-2 rounded-xl hover:bg-slate-100 transition flex-shrink-0"
                        style="color: var(--primary);" aria-label="Buka menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div class="min-w-0">
                    <h1 class="text-base lg:text-lg font-bold tracking-tight truncate" style="color: var(--primary);">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-[10px] uppercase font-semibold tracking-widest text-slate-400 hidden sm:block">@yield('page-subtitle', 'Panel Admin Bharata Herbal ID')</p>
                </div>
            </div>
            <div class="flex items-center gap-3 flex-shrink-0">
                <a href="{{ route('home') }}" target="_blank"
                   class="hidden sm:flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-emerald-800 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Lihat Website
                </a>
                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-xs font-bold flex-shrink-0"
                     style="background: var(--primary);">
                    {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        <div class="px-4 lg:px-7 pt-4">
            @if(session('success'))
            <div class="animate-slide-down bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center justify-between gap-3 text-sm font-medium mb-1" id="admin-flash-success">
                <div class="flex items-center gap-2.5 min-w-0">
                    <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span class="truncate">{{ session('success') }}</span>
                </div>
                <button onclick="document.getElementById('admin-flash-success').remove()" class="text-emerald-400 hover:text-emerald-600 transition flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            @endif
            @if(session('error'))
            <div class="animate-slide-down bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl flex items-center justify-between gap-3 text-sm font-medium mb-1" id="admin-flash-error">
                <div class="flex items-center gap-2.5 min-w-0">
                    <svg class="w-4 h-4 text-rose-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                    <span class="truncate">{{ session('error') }}</span>
                </div>
                <button onclick="document.getElementById('admin-flash-error').remove()" class="text-rose-400 hover:text-rose-600 transition flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            @endif
        </div>

        <!-- Page Content -->
        <div class="px-4 lg:px-7 py-6 flex-grow">
            @yield('content')
        </div>

        <!-- â”€â”€ Footer â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ -->
        <footer style="background: #0D2618; padding: 40px 20px 20px;">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8" style="margin-bottom:0;">
                    <div class="md:col-span-2">
                        <div style="display:flex; align-items:center; gap:12px; margin-bottom:8px;">
                            <img src="{{ asset('images/logo.png') }}" alt="Bharata Herbal" style="width:40px; height:40px; border-radius:6px; object-fit:contain;">
                            <div>
                                <div style="font-family:'Plus Jakarta Sans', 'Inter', sans-serif; font-size:1.3rem; font-weight:700; color:#FFFFFF;">Bharata Herbal</div>
                                <div style="font-family:'Inter',sans-serif; font-size:0.6rem; color:#A8DDBF; letter-spacing:2px; text-transform:uppercase; font-weight:500;">Bharata Herbal ID</div>
                            </div>
                        </div>
                        <p style="font-family:'Inter',sans-serif; font-size:0.8rem; color:#A8C0B0; line-height:1.6; max-width:300px; margin-bottom:16px;">
                            Kearifan Alam Nusantara dalam setiap produk herbal premium kami.
                        </p>
                        <div style="display:flex; flex-wrap:wrap; gap:12px;">
                            <span style="display:inline-flex; align-items:center; gap:5px; font-size:0.65rem; color:#A8C0B0;"><i class="fas fa-leaf" style="color:#A8DDBF;font-size:10px;"></i> 100% Organik</span>
                            <span style="display:inline-flex; align-items:center; gap:5px; font-size:0.65rem; color:#A8C0B0;"><i class="fas fa-truck" style="color:#A8DDBF;font-size:10px;"></i> Pengiriman Cepat</span>
                            <span style="display:inline-flex; align-items:center; gap:5px; font-size:0.65rem; color:#A8C0B0;"><i class="fas fa-certificate" style="color:#A8DDBF;font-size:10px;"></i> BPOM Terdaftar</span>
                        </div>
                    </div>
                    <div>
                        <div style="font-family:'Inter',sans-serif; font-size:0.7rem; text-transform:uppercase; letter-spacing:2px; color:#A8DDBF; margin-bottom:12px; font-weight:700;">Navigasi</div>
                        <a href="{{ route('home') }}" style="font-family:'Inter',sans-serif; font-size:0.8rem; color:#A8DDBF; display:block; margin-bottom:8px; transition:all 0.3s; text-decoration:none;" onmouseover="this.style.color='#FFFFFF'" onmouseout="this.style.color='#A8DDBF'">Beranda</a>
                        <a href="{{ route('products.index') }}" style="font-family:'Inter',sans-serif; font-size:0.8rem; color:#A8DDBF; display:block; margin-bottom:8px; transition:all 0.3s; text-decoration:none;" onmouseover="this.style.color='#FFFFFF'" onmouseout="this.style.color='#A8DDBF'">Produk Kami</a>
                    </div>
                    <div>
                        <div style="font-family:'Inter',sans-serif; font-size:0.7rem; text-transform:uppercase; letter-spacing:2px; color:#A8DDBF; margin-bottom:12px; font-weight:700;">Layanan</div>
                        <div style="font-family:'Inter',sans-serif; font-size:0.8rem; color:#A8C0B0; display:flex; align-items:center; gap:6px; margin-bottom:8px;"><i class="fab fa-whatsapp" style="color:#A8DDBF;font-size:11px;"></i> Konsultasi WA Gratis</div>
                        <div style="font-family:'Inter',sans-serif; font-size:0.8rem; color:#A8C0B0; display:flex; align-items:center; gap:6px;"><i class="fas fa-clock" style="color:#A8DDBF;font-size:11px;"></i> Senin&ndash;Sabtu, 08.00&ndash;17.00</div>
                    </div>
                </div>
                <hr style="border:0; border-top:1px solid rgba(45,107,68,0.3); margin:24px 0 12px;">
                <div style="font-family:'Inter',sans-serif; font-size:0.7rem; color:#A8C0B0; text-align:center;">&copy; {{ date('Y') }} Bharata Herbal ID. Dibuat dengan penuh dedikasi.</div>
            </div>
        </footer>
    </div>

    {{-- Global Alert/Confirm Modal --}}
    <div x-data x-show="$store.modal.open" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
         @keydown.escape.window="$store.modal.close()">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="$store.modal.close()"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-sm w-full p-6 text-center">
            <template x-if="$store.modal.type === 'confirm'">
                <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-amber-100 flex items-center justify-center">
                    <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                </div>
            </template>
            <template x-if="$store.modal.type === 'error'">
                <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-red-100 flex items-center justify-center">
                    <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
            </template>
            <template x-if="$store.modal.type === 'success'">
                <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-green-100 flex items-center justify-center">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
            </template>
            <template x-if="!$store.modal.type || $store.modal.type === 'info'">
                <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-blue-100 flex items-center justify-center">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </template>
            <h3 class="text-lg font-bold text-gray-900 mb-2" x-text="$store.modal.title"></h3>
            <p class="text-sm text-gray-600 mb-6" x-text="$store.modal.message"></p>
            <div class="flex gap-3 justify-center">
                <template x-if="$store.modal.type === 'confirm'">
                    <button @click="$store.modal.confirmAction()" class="px-6 py-2.5 bg-emerald-700 text-white rounded-xl font-semibold text-sm hover:bg-emerald-800 transition">Ya, Saya Yakin</button>
                </template>
                <button @click="$store.modal.close()" class="px-6 py-2.5 rounded-xl font-semibold text-sm transition"
                        :class="$store.modal.type === 'confirm' ? 'bg-gray-100 text-gray-700 hover:bg-gray-200' : 'bg-emerald-700 text-white hover:bg-emerald-800'"
                        x-text="$store.modal.type === 'confirm' ? 'Batal' : 'OK'"></button>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('modal', {
            open: false,
            title: '',
            message: '',
            type: 'info',
            _resolve: null,
            alert(message, type = 'info') {
                this.title = 'Perhatian';
                this.message = message;
                this.type = type;
                this._resolve = null;
                this.open = true;
            },
            confirm(message) {
                return new Promise(resolve => {
                    this.title = 'Konfirmasi';
                    this.message = message;
                    this.type = 'confirm';
                    this._resolve = resolve;
                    this.open = true;
                });
            },
            close() {
                this.open = false;
                if (this._resolve) { this._resolve(false); this._resolve = null; }
            },
            confirmAction() {
                if (this._resolve) { this._resolve(true); this._resolve = null; }
                this.close();
            }
        });
    });
    </script>

    @stack('scripts')

    <script>
    function openSidebar() {
        const sidebar = document.getElementById('main-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        sidebar.classList.add('open');
        overlay.style.display = 'block';
        requestAnimationFrame(() => overlay.classList.add('visible'));
        document.body.style.overflow = 'hidden';
    }
    function closeSidebar() {
        const sidebar = document.getElementById('main-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        sidebar.classList.remove('open');
        overlay.classList.remove('visible');
        setTimeout(() => { overlay.style.display = 'none'; }, 220);
        document.body.style.overflow = '';
    }
    // Auto-dismiss flash
    setTimeout(() => {
        ['admin-flash-success','admin-flash-error'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.style.transition = 'opacity 0.3s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 300);
            }
        });
    }, 5000);
    </script>
</body>
</html>
