<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | Admin Bharata Herbal ID</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>

    <style>
        :root {
            --primary-dark:  #122c19; /* Extremely Dark Forest */
            --primary:       #1C4526; /* Brand Primary */
            --primary-light: #284a36; /* Medium Green */
            --gold:          #1C4526; /* Consistent with primary */
            --gold-light:    #315d43;
            --cream:         #faf9f5;
        }
        body, h1, h2, h3, h4, h5, h6, button, input, select, textarea {
            font-family: 'Poppins', sans-serif;
            background: #f8faf9;
            color: #1e2925;
        }
        .font-serif-elegant { font-family: 'Poppins', sans-serif; }
        /* Sidebar styling */
        .sidebar { 
            background: var(--primary-dark); 
            width: 265px; 
            min-height: 100vh; 
            flex-shrink: 0; 
            border-right: 1px solid rgba(197, 160, 89, 0.15);
        }
        .sidebar a { 
            display: flex; 
            align-items: center; 
            gap: .75rem; 
            padding: .7rem 1.25rem; 
            color: #a3c2b2; 
            border-radius: .75rem; 
            margin: .15rem .75rem; 
            font-size: .875rem; 
            font-weight: 500;
            transition: all 0.2s; 
        }
        .sidebar a:hover { 
            background: rgba(255,255,255,0.04); 
            color: white; 
        }
        .sidebar a.active { 
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); 
            color: white; 
            box-shadow: 0 4px 12px rgba(17, 56, 36, 0.25);
            border-left: 3px solid var(--gold);
        }
        .sidebar .nav-section { 
            font-size: .65rem; 
            font-weight: 700; 
            text-transform: uppercase; 
            letter-spacing: .12em; 
            color: rgba(255,255,255,0.25); 
            padding: 1rem 1.25rem .25rem; 
        }
        /* Custom tables */
        .premium-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        .premium-table th {
            background: #f8fafc;
            color: #64748b;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.65rem;
            letter-spacing: 0.08em;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }
        .premium-table td {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            font-size: 0.875rem;
        }
        .premium-table tr:last-child td {
            border-bottom: none;
        }
        .premium-table tr:hover td {
            background-color: #f8faf9;
        }
    </style>
    @stack('styles')
</head>
<body class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="sidebar fixed top-0 left-0 h-screen overflow-y-auto z-40 hidden lg:flex flex-col">
        <div class="p-6 border-b border-emerald-950 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-lg font-serif-elegant" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); border: 1px solid var(--gold);">
                B
            </div>
            <div>
                <div class="text-base font-bold text-white font-serif-elegant tracking-wide leading-none">Bharata Herbal</div>
                <span class="text-[9px] font-bold uppercase tracking-widest text-slate-400 mt-1 block" style="color: var(--gold-light);">Layanan Admin</span>
            </div>
        </div>

        <nav class="flex-1 py-6">
            <div class="nav-section">Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <div class="nav-section">Katalog</div>
            <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                Daftar Produk
            </a>
            <a href="{{ route('admin.stock.index') }}" class="{{ request()->routeIs('admin.stock.*') ? 'active' : '' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Kelola Stok
            </a>

            <div class="nav-section">Transaksi</div>
            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                Pesanan Masuk
            </a>
            <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Laporan Keuangan
            </a>

            <div class="nav-section">Pelanggan</div>
            <a href="{{ route('admin.reviews.index') }}" class="{{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                Ulasan Produk
            </a>

            <div class="nav-section">Pengaturan</div>
            <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Toko & Bank
            </a>
        </nav>

        <div class="p-4 border-t border-emerald-950/80 bg-black/10">
            <div class="text-xs font-bold text-slate-300 mb-2.5 uppercase tracking-wide truncate">{{ auth()->user()->name ?? 'Admin' }}</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left text-xs text-rose-300 hover:text-rose-100 font-bold transition flex items-center gap-2 py-2 px-3 rounded-lg hover:bg-white/5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Logout Sesi
                </button>
            </form>
        </div>
    </aside>

    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden" onclick="closeSidebar()"></div>

    <!-- Mobile Sidebar -->
    <aside id="mobile-sidebar" class="sidebar fixed top-0 left-0 h-screen overflow-y-auto z-40 flex-col hidden" style="width:265px;">
        <div class="p-6 border-b border-emerald-950 flex items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-lg" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); border: 1px solid var(--gold);">B</div>
                <div>
                    <div class="text-base font-bold text-white tracking-wide leading-none">Bharata Herbal</div>
                    <span class="text-[9px] font-bold uppercase tracking-widest mt-1 block" style="color: var(--gold-light);">Layanan Admin</span>
                </div>
            </div>
            <button onclick="closeSidebar()" class="text-slate-400 hover:text-white p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <nav class="flex-1 py-6">
            <div class="nav-section">Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <div class="nav-section">Katalog</div>
            <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                Daftar Produk
            </a>
            <a href="{{ route('admin.stock.index') }}" class="{{ request()->routeIs('admin.stock.*') ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Kelola Stok
            </a>
            <div class="nav-section">Transaksi</div>
            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                Pesanan Masuk
            </a>
            <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Laporan Keuangan
            </a>
            <div class="nav-section">Pelanggan</div>
            <a href="{{ route('admin.reviews.index') }}" class="{{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                Ulasan Produk
            </a>
            <div class="nav-section">Pengaturan</div>
            <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Toko & Bank
            </a>
        </nav>
        <div class="p-4 border-t border-emerald-950/80">
            <div class="text-xs font-bold text-slate-300 mb-2.5 uppercase tracking-wide truncate">{{ auth()->user()->name ?? 'Admin' }}</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left text-xs text-rose-300 hover:text-rose-100 font-bold transition flex items-center gap-2 py-2 px-3 rounded-lg hover:bg-white/5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Logout Sesi
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 lg:ml-[265px] min-h-screen flex flex-col">
        <!-- Top Bar -->
        <header class="bg-white border-b border-slate-100 px-4 lg:px-8 py-4 lg:py-5 flex items-center justify-between sticky top-0 z-20 shadow-sm/50">
            <div class="flex items-center gap-3">
                <button onclick="openSidebar()" class="lg:hidden p-2 rounded-lg hover:bg-slate-100 transition" style="color: var(--primary);">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div>
                    <h1 class="text-lg lg:text-2xl font-bold tracking-wide" style="color: var(--primary);">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-[10px] uppercase font-bold tracking-widest text-slate-400 mt-0.5 hidden sm:block">@yield('page-subtitle', 'Panel Admin Bharata Herbal ID')</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" target="_blank" class="text-xs font-bold uppercase tracking-wider text-slate-400 hover:text-emerald-800 transition flex items-center gap-1.5">
                    🌐 Lihat Website
                </a>
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-sm" style="background: var(--primary);">
                    {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        <div class="px-8 pt-6">
            @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-100 text-emerald-800 px-5 py-4 rounded-xl flex items-center gap-2.5 shadow-sm text-sm font-medium">
                <svg style="width: 20px; height: 20px; min-width: 20px; max-width: 20px;" class="text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="bg-rose-50 border border-rose-100 text-rose-800 px-5 py-4 rounded-xl flex items-center gap-2.5 shadow-sm text-sm font-medium">
                <svg style="width: 20px; height: 20px; min-width: 20px; max-width: 20px;" class="text-rose-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                {{ session('error') }}
            </div>
            @endif
        </div>

        <div class="p-8 flex-grow">
            @yield('content')
        </div>
    </div>

    @stack('scripts')
    <script>
        function openSidebar() {
            document.getElementById('mobile-sidebar').style.display = 'flex';
            document.getElementById('sidebar-overlay').classList.remove('hidden');
        }
        function closeSidebar() {
            document.getElementById('mobile-sidebar').style.display = 'none';
            document.getElementById('sidebar-overlay').classList.add('hidden');
        }
    </script>
</body>
</html>
