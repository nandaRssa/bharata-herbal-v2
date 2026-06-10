<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Area | Bharata Herbal ID</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-dark:  #0a2216;
            --primary:       #1C4526;
            --primary-light: #2c633a;
            --gold:          #c5a059;
            --cream:         #faf8f5;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background: #ffffff;
        }
        h1, h2, h3, .font-serif-elegant {
            font-family: 'Cormorant Garamond', serif;
        }
    </style>
</head>
<body class="antialiased min-h-screen flex text-slate-800">
    <!-- Left Side: Image/Brand (Hidden on Mobile) -->
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden flex-col justify-between p-12" style="background: linear-gradient(145deg, var(--primary) 0%, var(--primary-dark) 100%);">
        
        <!-- Background Pattern / Accents -->
        <div class="absolute inset-0 opacity-[0.05]" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M54.627 0l.83.83v58.34l-.83.83H5.373l-.83-.83V.83l.83-.83h49.254zM53.5 2.127H6.5v55.746h47V2.127z\' fill=\'%23ffffff\' fill-opacity=\'1\' fill-rule=\'evenodd\'/%3E%3C/svg%3E');"></div>
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-white/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-emerald-500/10 rounded-full blur-3xl pointer-events-none translate-x-1/3 translate-y-1/3"></div>

        <!-- Top Logo -->
        <a href="/" class="relative z-10 flex items-center gap-4 group w-max">
            <div class="w-14 h-14 rounded-full flex items-center justify-center bg-white/10 backdrop-blur-md border border-white/20 transition-transform duration-300 group-hover:scale-105">
                <span class="text-white font-bold text-2xl font-serif-elegant">B</span>
            </div>
            <div>
                <div class="font-bold text-2xl text-white tracking-wide font-serif-elegant leading-none">Bharata Herbal</div>
                <div class="text-[10px] tracking-widest uppercase font-medium text-emerald-200 mt-1">Premium Wellness</div>
            </div>
        </a>

        <!-- Main Illustration/Text -->
        <div class="relative z-10 max-w-lg mt-auto mb-16">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 border border-white/10 backdrop-blur-sm text-xs font-bold text-white mb-6">
                <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
                Sistem Terenkripsi
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-6 font-serif-elegant leading-tight">
                Kearifan Alam <br>Nusantara.
            </h1>
            <p class="text-lg text-emerald-100/80 leading-relaxed font-light">
                Kelola pesanan, inventaris produk herbal, dan pantau aktivitas bisnis Anda dari dashboard yang aman dan eksklusif.
            </p>
        </div>

        <!-- Footer Note -->
        <div class="relative z-10 text-emerald-400/60 text-sm flex items-center gap-2 font-medium">
            &copy; {{ date('Y') }} Bharata Herbal ID.
        </div>
    </div>

    <!-- Right Side: Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 relative bg-white lg:bg-slate-50/50">
        <!-- Mobile Logo (visible only on mobile) -->
        <div class="absolute top-8 left-8 lg:hidden flex items-center gap-3">
             <div class="w-10 h-10 rounded-full flex items-center justify-center bg-emerald-50 border border-emerald-100 text-emerald-800">
                <span class="font-bold text-lg font-serif-elegant">B</span>
            </div>
            <div class="font-bold text-xl text-emerald-900 tracking-wide font-serif-elegant">Bharata Herbal</div>
        </div>

        <div class="w-full max-w-md relative z-10 mt-16 lg:mt-0">
            <!-- Form Card Wrapper -->
            <div class="bg-white rounded-[2rem] sm:border sm:border-slate-100 sm:shadow-2xl sm:shadow-slate-200/50 p-8 sm:p-10">
                <div class="mb-8 text-center sm:text-left">
                    <h2 class="text-3xl font-bold text-slate-900 mb-2 font-serif-elegant">Selamat Datang</h2>
                    <p class="text-sm text-slate-500 font-medium">Silakan masuk ke akun admin Anda.</p>
                </div>
                
                {{ $slot }}
                
            </div>
            
            <div class="mt-8 text-center text-xs text-slate-400 font-medium lg:hidden">
                &copy; {{ date('Y') }} Bharata Herbal ID.
            </div>
        </div>
    </div>
</body>
</html>
