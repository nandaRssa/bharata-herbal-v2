<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Bharata Herbal ID - Produk herbal premium dari kearifan alam Nusantara. Jamu, kapsul, minyak, dan teh herbal berkualitas tinggi.">
    <title>@yield('title', 'Bharata Herbal ID') | Toko Herbal Premium Indonesia</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #1C4526; /* Main brand color */
            --primary-dark: #122c19; /* Darker shade */
            --primary-light: #e5f0e9; /* Light green for backgrounds */
            --accent-red: #e53935; /* Red for discount */
            --background: #ffffff; /* Clean white background */
            --card-bg: #ffffff; /* White cards */
            --navbar-bg: #ffffff; /* Bottom navbar background */
            --gold: #1C4526; /* Replaced gold with primary for consistency */
            --text-dark: #111827; /* Dark gray for modern SaaS text */
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--background);
            color: var(--text-dark);
        }
        h1, h2, h3, h4, h5, h6, button, input, select, textarea {
            font-family: 'Poppins', sans-serif;
        }
        .font-serif-elegant { font-family: 'Poppins', sans-serif; }
        /* Custom transitions and animations */
        .hover-gold-line {
            position: relative;
        }
        .hover-gold-line::after {
            content: '';
            position: absolute;
            width: 100%;
            transform: scaleX(0);
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: var(--gold);
            transform-origin: bottom right;
            transition: transform 0.25s ease-out;
        }
        .hover-gold-line:hover::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen flex flex-col antialiased">
    <!-- Navbar -->
    <nav class="bg-white/95 backdrop-blur-md shadow-md sticky top-0 z-50 transition-all duration-300 border-b border-gray-100" id="main-nav">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center transition-transform duration-300 group-hover:scale-105" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); border: 1px solid var(--gold);">
                        <span class="text-white font-bold text-xl font-serif-elegant">B</span>
                    </div>
                    <div>
                        <div class="font-bold text-2xl leading-none font-serif-elegant tracking-wide" style="color: var(--primary);">Bharata Herbal</div>
                        <div class="text-[10px] tracking-widest uppercase font-semibold mt-0.5" style="color: var(--gold);">Premium Wellness</div>
                    </div>
                </a>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="font-semibold text-sm hover-gold-line transition duration-150 {{ request()->routeIs('home') ? 'text-slate-900' : 'text-slate-600 hover:text-slate-900' }}">Beranda</a>
                    <a href="{{ route('products.index') }}" class="font-semibold text-sm hover-gold-line transition duration-150 {{ request()->routeIs('products.*') ? 'text-slate-900' : 'text-slate-600 hover:text-slate-900' }}">Produk</a>
                    <a href="{{ route('about') }}" class="font-semibold text-sm hover-gold-line transition duration-150 {{ request()->routeIs('about') ? 'text-slate-900' : 'text-slate-600 hover:text-slate-900' }}">Tentang Kami</a>
                    <a href="{{ route('home') }}#testimoni" class="font-semibold text-sm hover-gold-line transition duration-150 text-slate-600 hover:text-slate-900">Testimoni</a>
                    <a href="{{ route('contact') }}" class="font-semibold text-sm hover-gold-line transition duration-150 {{ request()->routeIs('contact') ? 'text-slate-900' : 'text-slate-600 hover:text-slate-900' }}">Kontak</a>
                    <a href="{{ route('order.history') }}" class="font-semibold text-sm hover-gold-line transition duration-150 {{ request()->routeIs('order.history*') ? 'text-slate-900' : 'text-slate-600 hover:text-slate-900' }}">Riwayat Pesanan</a>
                    
                    <a href="{{ route('products.index') }}" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-lg shadow-sm transition-all duration-300">
                        Pesan Sekarang
                    </a>
                    <!-- Cart Icon Desktop -->
                    <a href="{{ route('cart.index') }}" class="relative flex items-center p-2 rounded-full hover:bg-slate-50 transition duration-300" style="color: var(--primary);">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        @if(collect(session('cart', []))->sum('quantity') > 0)
                        <span class="absolute -top-1 -right-1 inline-flex items-center justify-center w-5 h-5 text-[10px] font-bold leading-none text-white rounded-full animate-pulse shadow-md" style="background: var(--gold);">
                            {{ collect(session('cart', []))->sum('quantity') }}
                        </span>
                        @endif
                    </a>
                </div>

                <!-- Mobile Menu Controls -->
                <div class="flex items-center gap-4 md:hidden">
                    <!-- Cart Mobile -->
                    <a href="{{ route('cart.index') }}" class="relative flex items-center p-2 rounded-full hover:bg-slate-50 transition" style="color: var(--primary);">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        @if(collect(session('cart', []))->sum('quantity') > 0)
                        <span class="absolute -top-1 -right-1 inline-flex items-center justify-center w-5 h-5 text-[10px] font-bold leading-none text-white rounded-full shadow-md" style="background: var(--gold);">
                            {{ collect(session('cart', []))->sum('quantity') }}
                        </span>
                        @endif
                    </a>

                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-btn" class="p-2 rounded-md hover:bg-slate-50 transition" style="color: var(--primary);">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t px-4 py-4 bg-white/95 backdrop-blur-md shadow-inner space-y-2">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg font-semibold hover:bg-slate-50 transition text-slate-700">Beranda</a>
            <a href="{{ route('products.index') }}" class="block px-3 py-2 rounded-lg font-semibold hover:bg-slate-50 transition text-slate-700">Produk</a>
            <a href="{{ route('about') }}" class="block px-3 py-2 rounded-lg font-semibold hover:bg-slate-50 transition text-slate-700">Tentang Kami</a>
            <a href="{{ route('home') }}#testimoni" class="block px-3 py-2 rounded-lg font-semibold hover:bg-slate-50 transition text-slate-700">Testimoni</a>
            <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-lg font-semibold hover:bg-slate-50 transition text-slate-700">Kontak</a>
            <a href="{{ route('order.history') }}" class="block px-3 py-2 rounded-lg font-semibold hover:bg-slate-50 transition text-slate-700">Riwayat Pesanan</a>
            <a href="{{ route('cart.index') }}" class="block px-3 py-2 rounded-lg font-semibold hover:bg-slate-50 transition flex items-center justify-between text-slate-700">
                <span>Keranjang Belanja</span>
                <span class="px-2.5 py-1 text-xs font-bold rounded-full text-white shadow-sm" style="background-color: var(--primary);">
                    {{ collect(session('cart', []))->sum('quantity') }} item
                </span>
            </a>
            <a href="{{ route('products.index') }}" class="block w-full text-center mt-4 px-4 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-sm transition">
                Pesan Sekarang
            </a>
        </div>
    </nav>

    <!-- Flash Messages -->
    <div class="max-w-7xl mx-auto px-4 w-full">
        @if(session('success'))
        <div class="mt-4 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-xl flex items-center gap-3 shadow-sm">
            <svg style="width: 20px; height: 20px; min-width: 20px; max-width: 20px;" class="flex-shrink-0 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
        @endif
        @if(session('error'))
        <div class="mt-4 bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-xl flex items-center gap-3 shadow-sm">
            <svg style="width: 20px; height: 20px; min-width: 20px; max-width: 20px;" class="flex-shrink-0 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <span class="text-sm font-medium">{{ session('error') }}</span>
        </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="relative overflow-hidden text-emerald-50 mt-20 border-t border-emerald-800" style="background: linear-gradient(180deg, var(--primary) 0%, var(--primary-dark) 100%);">
        <!-- Modern SaaS abstract glow -->
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2 w-[800px] h-[400px] bg-white/5 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="md:col-span-2">
                    <h3 class="text-3xl font-bold text-white mb-4 font-serif-elegant tracking-wide">Bharata Herbal ID</h3>
                    <p class="text-sm text-emerald-100/70 mb-6 leading-relaxed max-w-sm">Kearifan Alam Nusantara dalam setiap tetes produk herbal premium kami. Alami, teruji secara klinis, dan terpercaya bagi kesehatan keluarga.</p>
                    <div class="flex gap-4">
                        <span class="px-3.5 py-1.5 rounded-full text-xs font-semibold text-white/90 border border-emerald-800/80 bg-emerald-950/40">🌿 100% Organik</span>
                        <span class="px-3.5 py-1.5 rounded-full text-xs font-semibold text-white/90 border border-emerald-800/80 bg-emerald-950/40">🚚 Pengiriman Cepat</span>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold text-sm tracking-widest text-emerald-100 uppercase mb-5 border-b border-emerald-800/60 pb-3">Navigasi</h4>
                    <ul class="space-y-3.5 text-sm">
                        <li><a href="{{ route('home') }}" class="text-emerald-100/70 hover:text-white transition duration-200">Beranda</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-emerald-100/70 hover:text-white transition duration-200">Produk Kami</a></li>
                        <li><a href="{{ route('about') }}" class="text-emerald-100/70 hover:text-white transition duration-200">Tentang Kami</a></li>
                        <li><a href="{{ route('contact') }}" class="text-emerald-100/70 hover:text-white transition duration-200">Kontak</a></li>
                        <li><a href="{{ route('order.history') }}" class="text-emerald-100/70 hover:text-white transition duration-200">Cek Riwayat Pesanan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-sm tracking-widest text-emerald-100 uppercase mb-5 border-b border-emerald-800/60 pb-3">Layanan</h4>
                    <ul class="space-y-3.5 text-sm text-emerald-100/70">
                        <li class="flex items-center gap-2">💬 Konsultasi WA Gratis</li>
                        <li class="flex items-center gap-2">📦 Packing Aman & Rapih</li>
                        <li class="flex items-center gap-2">⏰ Senin–Sabtu, 08.00–17.00</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-emerald-900 mt-12 pt-8 flex flex-col sm:flex-row justify-between items-center text-sm text-emerald-100/50">
                <p>© {{ date('Y') }} Bharata Herbal ID. Dibuat dengan penuh dedikasi.</p>
                <div class="flex items-center gap-4 mt-4 sm:mt-0">
                    <a href="{{ route('login') }}" class="text-xs text-emerald-100/30 hover:text-emerald-100/70 transition duration-200">Akses Admin</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        // Sticky nav class toggle on scroll
        const nav = document.getElementById('main-nav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                nav.classList.add('shadow-lg');
            } else {
                nav.classList.remove('shadow-lg');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
