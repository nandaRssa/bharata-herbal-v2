<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Bharata Herbal ID - Produk herbal premium dari kearifan alam Nusantara. Jamu, kapsul, minyak, dan teh herbal berkualitas tinggi.">
    <title>@yield('title', 'Bharata Herbal ID') | Toko Herbal Premium Indonesia</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}?v=2">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}?v=2">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            /* Welcome Section (tetap) */
            --welcome-bg: #0D2618;
            --welcome-text: #FFFFFF;
            --welcome-accent: #7CC89A;
            --welcome-gold: #D4AF37;

            /* Halaman Lain (clean) */
            --bg-body: #F8FAF7;
            --bg-white: #FFFFFF;
            --primary: #0D2618;
            --primary-dark: #0D2618;
            --primary-light: #2D6B44;
            --primary-soft: #E8F0EC;
            --gold: #C9A227;
            --gold-light: #F5E6A3;
            --heading: #0F172A;
            --text: #475569;
            --text-muted: #94A3B8;
            --border: #E2E8F0;
            --shadow: rgba(0,0,0,0.04);

            /* Legacy aliases (back-compat) */
            --background: #FFFFFF;
            --card-bg: #FFFFFF;
        }
        [x-cloak] { display: none !important; }
        body {
            font-family: 'Plus Jakarta Sans', 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--background);
            color: #334155;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Plus Jakarta Sans', 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        button, input, select, textarea {
            font-family: 'Plus Jakarta Sans', 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        .font-serif-elegant {
            font-family: 'Plus Jakarta Sans', 'Inter', ui-sans-serif, system-ui, sans-serif;
            font-weight: 700;
        }
        /* ── Navbar Premium ──────────────────────────── */
        .navbar {
            background: #0D2618;
            transition: all 0.4s ease;
        }
        .navbar.scrolled {
            background: rgba(13, 38, 24, 0.97);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 4px 30px rgba(0,0,0,0.3);
        }
        .navbar-logo-text {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: #FFFFFF;
            line-height: 1.2;
        }
        .navbar-logo-sub {
            font-size: 0.55rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #A8DDBF;
            font-weight: 500;
        }
        .nav-link {
            position: relative;
            font-size: 0.85rem;
            font-weight: 500;
            color: #A8DDBF;
            text-decoration: none;
            transition: color 0.3s ease;
            padding: 6px 0;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background: #FFFFFF;
            transition: width 0.3s ease;
        }
        .nav-link:hover { color: #FFFFFF; }
        .nav-link:hover::after { width: 100%; }
        .nav-link.active { color: #FFFFFF; }
        .nav-link.active::after { width: 100%; }
        .nav-cta {
            background: #FFFFFF;
            color: #0D2618;
            font-weight: 700;
            font-size: 0.85rem;
            padding: 10px 28px;
            border-radius: 50px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 0 24px rgba(255,255,255,0.3);
        }
        .nav-cta:hover {
            transform: scale(1.05);
            box-shadow: 0 0 40px rgba(255,255,255,0.5);
        }
        .mobile-menu-panel {
            background: #0D2618;
            border-top: 1px solid rgba(168, 221, 191, 0.08);
        }

        /* â”€â”€ Premium Footer â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .bharata-footer { background: #0D2618; }
        .bharata-footer-brand { font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; font-size: 1.6rem; font-weight: 700; color: #FFFFFF; margin-bottom: 4px; }
        .bharata-footer-tagline { font-family: 'Inter', sans-serif; font-size: 0.7rem; color: #A8DDBF; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 12px; font-weight: 500; }
        .bharata-footer-desc { font-family: 'Inter', sans-serif; font-size: 0.85rem; color: #6A7A72; line-height: 1.7; max-width: 320px; margin-bottom: 20px; }
        .bharata-footer-heading { font-family: 'Inter', sans-serif; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 2px; color: #A8DDBF; margin-bottom: 20px; font-weight: 700; }
        .bharata-footer-link { font-family: 'Inter', sans-serif; font-size: 0.85rem; color: #8A9A92; display: block; margin-bottom: 12px; transition: all 0.3s ease; text-decoration: none; }
        .bharata-footer-link:hover { color: #A8DDBF; transform: translateX(4px); }
        .bharata-footer-badge { display: inline-flex; align-items: center; gap: 6px; font-size: 0.7rem; color: #6A7A72; }
        .bharata-footer-badge i { color: #A8DDBF; font-size: 11px; }
        .bharata-footer-copy { font-family: 'Inter', sans-serif; font-size: 0.75rem; color: #6A7A72; padding-top: 8px; position: relative; text-align: center; }
        .bharata-footer-admin { position: absolute; right: 0; top: 50%; transform: translateY(-50%); color: #6A7A72; text-decoration: none; opacity: 0.35; font-size: 0.65rem; transition: opacity 0.3s; }
        .bharata-footer-admin:hover { opacity: 0.7; color: #A8DDBF; }
        @media (max-width: 480px) {
            .bharata-footer-copy { position: static; display: flex; flex-direction: column; align-items: center; gap: 6px; text-align: center; }
            .bharata-footer-admin { position: static; transform: none; opacity: 0.25; font-size: 0.6rem; }
        }
        .bharata-footer-service-item { font-family: 'Inter', sans-serif; font-size: 0.85rem; color: #6A7A72; display: flex; align-items: center; gap: 8px; margin-bottom: 12px; }
        .bharata-footer-service-item i { color: #A8DDBF; font-size: 13px; width: 16px; text-align: center; }
        .bharata-footer-service-hours { font-family: 'Inter', sans-serif; font-size: 0.85rem; color: #6A7A72; margin-top: 16px; display: flex; align-items: center; gap: 8px; }
        .bharata-footer-service-hours i { color: #A8DDBF; font-size: 13px; width: 16px; text-align: center; }
        .bharata-footer-divider { border: 0; border-top: 1px solid rgba(45, 107, 68, 0.3); margin: 40px 0 20px; }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen flex flex-col antialiased">

    <!-- â”€â”€ Navbar Premium â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ -->
    <nav class="navbar sticky top-0 z-50" id="main-nav">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between" style="height:68px;">

                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 flex-shrink-0">
                    <img src="{{ asset('images/logo.png') }}" alt="Bharata Herbal" class="w-11 h-11 rounded-lg object-contain transition-all duration-300" style="filter:brightness(1.1);">
                    <div>
                        <div class="navbar-logo-text">Bharata Herbal</div>
                        <div class="navbar-logo-sub">Premium Wellness</div>
                    </div>
                </a>

                <!-- Desktop Nav -->
                <div class="hidden md:flex items-center gap-7">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                    <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">Produk</a>
                    <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">Tentang</a>
                    <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Kontak</a>
                    <a href="{{ route('order.history') }}" class="nav-link {{ request()->routeIs('order.history*') ? 'active' : '' }}">Riwayat</a>

                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $settings->wa_number ?? '6282244664526') }}?text=Halo%20Bharata%20Herbal%2C%20saya%20ingin%20bertanya..." target="_blank" rel="noopener noreferrer" class="nav-cta">
                        <i class="fab fa-whatsapp" style="font-size:14px;"></i>
                        Hubungi Kami
                    </a>

                    <!-- Cart Icon -->
                    <a href="{{ route('cart.index') }}"
                       class="relative flex items-center p-2 rounded-xl transition duration-200"
                       style="color:#A8DDBF;"
                       title="Keranjang Belanja">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        @if(collect(session('cart', []))->sum('quantity') > 0)
                        <span class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center w-[18px] h-[18px] text-[9px] font-bold text-white rounded-full" style="background:#0D2618;">
                            {{ collect(session('cart', []))->sum('quantity') }}
                        </span>
                        @endif
                    </a>
                </div>

                <!-- Mobile Controls -->
                <div class="flex items-center gap-3 md:hidden">
                    <a href="{{ route('cart.index') }}" class="relative flex items-center p-2 transition" style="color:#A8DDBF;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        @if(collect(session('cart', []))->sum('quantity') > 0)
                        <span class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center w-[18px] h-[18px] text-[9px] font-bold text-white rounded-full" style="background:#0D2618;">
                            {{ collect(session('cart', []))->sum('quantity') }}
                        </span>
                        @endif
                    </a>
                    <button id="mobile-menu-btn"
                            class="flex flex-col gap-1 p-2 bg-none border-none cursor-pointer" aria-label="Toggle menu">
                        <span style="display:block;width:22px;height:2px;background:#FFFFFF;border-radius:2px;transition:all 0.3s;"></span>
                        <span style="display:block;width:22px;height:2px;background:#FFFFFF;border-radius:2px;transition:all 0.3s;"></span>
                        <span style="display:block;width:22px;height:2px;background:#FFFFFF;border-radius:2px;transition:all 0.3s;"></span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden mobile-menu-panel">
            <div class="px-4 py-4 space-y-1">
                <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm transition-all duration-200" style="color:{{ request()->routeIs('home') ? '#FFFFFF' : '#A8DDBF' }};background:{{ request()->routeIs('home') ? 'rgba(255,255,255,0.08)' : 'transparent' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Beranda
                </a>
                <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm transition-all duration-200" style="color:{{ request()->routeIs('products.*') ? '#FFFFFF' : '#A8DDBF' }};background:{{ request()->routeIs('products.*') ? 'rgba(255,255,255,0.08)' : 'transparent' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Produk
                </a>
                <a href="{{ route('about') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm transition-all duration-200" style="color:{{ request()->routeIs('about') ? '#FFFFFF' : '#A8DDBF' }};background:{{ request()->routeIs('about') ? 'rgba(255,255,255,0.08)' : 'transparent' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Tentang Kami
                </a>
                <a href="{{ route('home') }}#testimoni" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm transition-all duration-200" style="color:#A8DDBF;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    Testimoni
                </a>
                <a href="{{ route('contact') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm transition-all duration-200" style="color:{{ request()->routeIs('contact') ? '#FFFFFF' : '#A8DDBF' }};background:{{ request()->routeIs('contact') ? 'rgba(255,255,255,0.08)' : 'transparent' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Kontak
                </a>
                <a href="{{ route('order.history') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm transition-all duration-200" style="color:{{ request()->routeIs('order.history*') ? '#FFFFFF' : '#A8DDBF' }};background:{{ request()->routeIs('order.history*') ? 'rgba(255,255,255,0.08)' : 'transparent' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Riwayat Pesanan
                </a>
                <div class="pt-2 pb-1">
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $settings->wa_number ?? '6282244664526') }}?text=Halo%20Bharata%20Herbal%2C%20saya%20ingin%20bertanya..."
                       target="_blank" rel="noopener noreferrer"
                       class="block w-full text-center px-4 py-3 rounded-xl font-semibold text-sm transition-all duration-200 active:scale-95"
                       style="background:#FFFFFF;color:#0D2618;font-weight:700;box-shadow:0 0 24px rgba(255,255,255,0.2);">
                        <i class="fab fa-whatsapp" style="font-size:14px;margin-right:6px;"></i>
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- â”€â”€ Flash Messages â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ -->
    @if(session('success') || session('error') || session('warning'))
    <div class="max-w-7xl mx-auto px-4 w-full" id="flash-container">
        @if(session('success'))
        <div class="mt-4 animate-slide-down bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-3.5 rounded-xl flex items-center justify-between gap-3 shadow-sm" id="flash-success">
            <div class="flex items-center gap-2.5">
                <svg class="w-5 h-5 flex-shrink-0 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
            <button onclick="document.getElementById('flash-success').remove()" class="text-emerald-500 hover:text-emerald-700 flex-shrink-0 p-0.5 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        @endif
        @if(session('error'))
        <div class="mt-4 animate-slide-down bg-rose-50 border border-rose-200 text-rose-800 px-5 py-3.5 rounded-xl flex items-center justify-between gap-3 shadow-sm" id="flash-error">
            <div class="flex items-center gap-2.5">
                <svg class="w-5 h-5 flex-shrink-0 text-rose-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
            <button onclick="document.getElementById('flash-error').remove()" class="text-rose-500 hover:text-rose-700 flex-shrink-0 p-0.5 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        @endif
        @if(session('warning'))
        <div class="mt-4 animate-slide-down bg-amber-50 border border-amber-200 text-amber-800 px-5 py-3.5 rounded-xl flex items-center justify-between gap-3 shadow-sm" id="flash-warning">
            <div class="flex items-center gap-2.5">
                <svg class="w-5 h-5 flex-shrink-0 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm font-medium">{{ session('warning') }}</span>
            </div>
            <button onclick="document.getElementById('flash-warning').remove()" class="text-amber-500 hover:text-amber-700 flex-shrink-0 p-0.5 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        @endif
    </div>
    @endif

    <!-- â”€â”€ Main Content â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- â”€â”€ Footer â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ -->
    <footer class="bharata-footer">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="padding: 60px 20px 20px;">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">

                <!-- Brand -->
                <div class="md:col-span-2">
                    <div style="display:flex; align-items:center; gap:12px; margin-bottom:8px;">
                        <img src="{{ asset('images/logo.png') }}" alt="Bharata Herbal" style="width:48px; height:48px; border-radius:8px; object-fit:contain;">
                        <div>
                            <div class="bharata-footer-brand">Bharata Herbal</div>
                            <div class="bharata-footer-tagline">Bharata Herbal ID</div>
                        </div>
                    </div>
                    <p class="bharata-footer-desc">
                        Kearifan Alam Nusantara dalam setiap produk herbal premium kami. Alami, teruji secara klinis, dan terpercaya bagi kesehatan keluarga.
                    </p>
                    <div style="display:flex; flex-wrap:wrap; gap:16px;">
                        <span class="bharata-footer-badge"><i class="fas fa-leaf"></i> 100% Organik</span>
                        <span class="bharata-footer-badge"><i class="fas fa-truck"></i> Pengiriman Cepat</span>
                        <span class="bharata-footer-badge"><i class="fas fa-certificate"></i> BPOM Terdaftar</span>
                    </div>
                </div>

                <!-- Navigasi -->
                <div>
                    <div class="bharata-footer-heading">Navigasi</div>
                    <a href="{{ route('home') }}" class="bharata-footer-link">Beranda</a>
                    <a href="{{ route('products.index') }}" class="bharata-footer-link">Produk Kami</a>
                    <a href="{{ route('about') }}" class="bharata-footer-link">Tentang Kami</a>
                    <a href="{{ route('contact') }}" class="bharata-footer-link">Kontak</a>
                    <a href="{{ route('order.history') }}" class="bharata-footer-link">Cek Riwayat Pesanan</a>
                </div>

                <!-- Layanan -->
                <div>
                    <div class="bharata-footer-heading">Layanan</div>
                    <div class="bharata-footer-service-item"><i class="fab fa-whatsapp"></i> Konsultasi WA Gratis</div>
                    <div class="bharata-footer-service-item"><i class="fas fa-box"></i> Packing Aman &amp; Rapi</div>
                    <div class="bharata-footer-service-hours"><i class="fas fa-clock"></i> Senin&ndash;Sabtu, 08.00&ndash;17.00</div>
                </div>
            </div>

            <hr class="bharata-footer-divider">
            <div class="bharata-footer-copy">
                <span>&copy; {{ date('Y') }} Bharata Herbal ID. Dibuat dengan penuh dedikasi.</span>
                <a href="{{ route('login') }}" class="bharata-footer-admin">Admin</a>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const menuBtn = document.getElementById('mobile-menu-btn');
        const menu    = document.getElementById('mobile-menu');
        const spans   = menuBtn ? menuBtn.querySelectorAll('span') : [];

        if (menuBtn && menu) {
            menuBtn.addEventListener('click', function() {
                menu.classList.toggle('hidden');
                spans.forEach(function(s) {
                    s.style.transform = menu.classList.contains('hidden') ? '' : 'scaleX(0.8)';
                });
            });
            // Close menu on link click (delayed so browser can initiate navigation)
            menu.querySelectorAll('a').forEach(function(link) {
                link.addEventListener('click', function() {
                    setTimeout(function() {
                        menu.classList.add('hidden');
                    }, 150);
                });
            });
        }

        // Navbar scroll effect
        const nav = document.getElementById('main-nav');
        window.addEventListener('scroll', function() {
            if (window.scrollY > 40) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        }, { passive: true });

        // Auto-dismiss flash messages after 5s
        setTimeout(() => {
            ['flash-success','flash-error','flash-warning'].forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    el.style.transition = 'opacity 0.4s, transform 0.4s';
                    el.style.opacity = '0';
                    el.style.transform = 'translateY(-6px)';
                    setTimeout(() => el.remove(), 400);
                }
            });
        }, 5000);
    </script>

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
</body>
</html>
