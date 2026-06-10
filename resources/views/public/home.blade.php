@extends('layouts.public')
@section('title', 'Beranda')

@section('content')

<!-- Hero Section -->
<section class="bg-white pt-24 pb-16 lg:pt-32 lg:pb-24 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center">
            
            <!-- Hero Text -->
            <div class="text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-semibold mb-6" style="background-color: var(--primary-light); color: var(--primary);">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Produk Herbal Terpercaya
                </div>
                
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight mb-6">
                    Temukan Produk Herbal Sesuai Kebutuhan <span style="color: var(--primary);">Kesehatan Anda</span>
                </h1>
                
                <p class="text-lg md:text-xl text-slate-600 mb-8 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    Kami menyediakan berbagai pilihan produk herbal berkualitas untuk membantu mendukung kesehatan dan kesejahteraan Anda sehari-hari. Dipilih dengan standar kualitas tinggi untuk memberikan solusi kesehatan yang terpercaya.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="#produk" class="px-8 py-4 rounded-xl text-base font-bold text-white shadow-lg hover:shadow-xl transition-all duration-300" style="background-color: var(--primary);">
                        Lihat Produk
                    </a>
                    <a href="{{ route('contact') }}" class="px-8 py-4 rounded-xl text-base font-bold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 transition-all duration-300">
                        Hubungi Kami
                    </a>
                </div>
            </div>

            <!-- Hero Image -->
            <div class="relative lg:ml-10">
                <div class="absolute inset-0 bg-gradient-to-tr from-emerald-100 to-transparent rounded-full blur-3xl opacity-50 transform -translate-x-10 translate-y-10"></div>
                <img src="{{ asset('hero_image_new.png') }}" alt="Modern Healthcare Concept" class="relative z-10 w-full h-auto object-contain drop-shadow-xl" style="max-height: 550px;">
            </div>
            
        </div>
    </div>
</section>

<!-- Certification Bar Section -->
<section class="border-y border-slate-100 py-8 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-center text-sm font-semibold text-slate-500 mb-6 uppercase tracking-wider">Dipercaya & Disertifikasi Oleh</p>
        <div class="flex flex-wrap justify-center gap-8 md:gap-16 opacity-70 grayscale hover:grayscale-0 transition-all duration-500">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center border border-slate-200 font-bold text-xs">BPOM</div>
                <span class="font-bold text-slate-700">BPOM RI</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center border border-slate-200 font-bold text-xs text-green-600">HALAL</div>
                <span class="font-bold text-slate-700">Halal Indonesia</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center border border-slate-200 font-bold text-xs text-blue-600">GMP</div>
                <span class="font-bold text-slate-700">Standar Mutu</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center border border-slate-200 font-bold text-xs text-emerald-600">100%</div>
                <span class="font-bold text-slate-700">Herbal Alami</span>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section id="produk" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4">Produk Unggulan Kami</h2>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">Diramu secara khusus menggunakan teknologi modern untuk memberikan khasiat terbaik bagi tubuh Anda.</p>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-8">
            @foreach($products->take(6) as $product)
            <div class="group flex flex-col bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                <a href="{{ route('products.show', $product->slug) }}" class="block relative aspect-square bg-slate-50 overflow-hidden">
                    @if($product->images->isNotEmpty())
                    <img src="{{ asset('storage/' . ($product->images->where('is_primary', true)->first() ?? $product->images->first())->image_path) }}"
                         alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-4xl opacity-20">🌿</div>
                    @endif
                </a>
                <div class="p-4 sm:p-6 flex flex-col flex-grow">
                    <a href="{{ route('products.show', $product->slug) }}" class="block mb-2">
                        <h3 class="font-bold text-sm sm:text-lg text-slate-900 leading-tight group-hover:text-emerald-700 transition">{{ $product->name }}</h3>
                    </a>
                    <p class="hidden sm:block text-sm text-slate-500 mb-4 line-clamp-2">{{ $product->description }}</p>
                    
                    <div class="mt-auto flex items-center justify-between">
                        <div class="font-extrabold text-sm sm:text-lg" style="color: var(--primary);">{{ $product->formatted_price }}</div>
                        <a href="{{ route('products.show', $product->slug) }}" class="p-2 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-xl font-bold text-white bg-slate-900 hover:bg-emerald-700 transition duration-300">
                Lihat Semua Produk
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>
    </div>
</section>

<!-- Why Choose Us & Benefits Section -->
<section class="py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            
            <div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6">Mengapa Memilih Bharata Herbal?</h2>
                <p class="text-lg text-slate-600 mb-8 leading-relaxed">Kami berdedikasi untuk menyediakan produk kesehatan alami yang aman, efektif, dan diproduksi dengan standar kualitas tertinggi untuk mendukung gaya hidup sehat Anda.</p>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0" style="background-color: var(--primary-light); color: var(--primary);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">Terdaftar BPOM</h4>
                            <p class="text-xs text-slate-500 mt-1">Legalitas resmi dan terjamin keamanannya.</p>
                        </div>
                    </div>
                    
                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0" style="background-color: var(--primary-light); color: var(--primary);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">Sertifikat Halal</h4>
                            <p class="text-xs text-slate-500 mt-1">100% halal diproduksi sesuai syariat.</p>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0" style="background-color: var(--primary-light); color: var(--primary);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">Bahan Alami</h4>
                            <p class="text-xs text-slate-500 mt-1">Ekstrak murni tanpa pengawet buatan.</p>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0" style="background-color: var(--primary-light); color: var(--primary);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">Kualitas Terpercaya</h4>
                            <p class="text-xs text-slate-500 mt-1">Jutaan pelanggan puas di seluruh Indonesia.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="grid grid-cols-2 gap-4">
                    <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Clinic" class="rounded-2xl object-cover h-64 w-full shadow-lg">
                    <img src="https://images.unsplash.com/photo-1550831107-1553da8c8464?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Herbal Ingredients" class="rounded-2xl object-cover h-64 w-full shadow-lg mt-8">
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4">Kata Mereka Tentang Kami</h2>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">Bukti nyata dari pelanggan yang telah merasakan manfaat produk Bharata Herbal.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['name' => 'Bapak Budi Santoso', 'role' => 'Karyawan Swasta', 'rating' => 5, 'text' => 'Setelah rutin mengkonsumsi Bharata Lambung, masalah asam lambung saya sangat jarang kambuh. Bisa kembali fokus bekerja tanpa khawatir rasa perih. Sangat direkomendasikan!'],
                ['name' => 'Ibu Siti Aminah', 'role' => 'Ibu Rumah Tangga', 'rating' => 5, 'text' => 'Produk Orthafit benar-benar luar biasa. Nyeri sendi lutut yang sering saya rasakan berangsur menghilang. Sekarang bisa kembali aktif beraktivitas setiap hari.'],
                ['name' => 'Rudi Hermawan', 'role' => 'Wiraswasta', 'rating' => 5, 'text' => 'Saya punya riwayat kolesterol tinggi, namun sejak menggunakan produk herbal Bharata secara teratur, hasilnya lebih stabil dan badan terasa jauh lebih ringan.'],
            ] as $t)
            <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100 flex flex-col justify-between">
                <div>
                    <div class="flex text-amber-400 mb-4">
                        @for($i = 0; $i < $t['rating']; $i++) 
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <p class="text-slate-600 leading-relaxed mb-8">"{{ $t['text'] }}"</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-emerald-700 font-bold bg-emerald-100">
                        {{ substr($t['name'], 0, 1) }}
                    </div>
                    <div>
                        <div class="font-bold text-slate-900">{{ $t['name'] }}</div>
                        <div class="text-sm text-slate-500">{{ $t['role'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Call To Action Section -->
<section class="relative py-28 overflow-hidden bg-slate-50 border-t border-slate-100">
    <div class="absolute inset-0" style="background: linear-gradient(135deg, var(--primary-light) 0%, #ffffff 100%);"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-emerald-100 rounded-full blur-[100px] opacity-60 pointer-events-none"></div>
    
    <div class="relative z-10 max-w-4xl mx-auto px-4 text-center">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold mb-6 tracking-wide shadow-sm bg-white border border-slate-100" style="color: var(--primary);">
            <div class="w-1.5 h-1.5 rounded-full" style="background-color: var(--primary);"></div>
            Mulai Sekarang
        </div>
        
        <h2 class="text-3xl md:text-5xl font-extrabold text-slate-900 mb-6 leading-tight tracking-tight">
            Temukan Produk Herbal Sesuai Kebutuhan Anda
        </h2>
        <p class="text-lg md:text-xl text-slate-600 mb-10 max-w-2xl mx-auto leading-relaxed">
            Jelajahi berbagai pilihan produk herbal berkualitas yang dirancang untuk mendukung kesehatan dan kesejahteraan Anda setiap hari.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('products.index') }}" class="px-8 py-4 rounded-xl text-base font-bold text-white shadow-lg hover:shadow-xl transition-all duration-300" style="background-color: var(--primary);">
                Lihat Produk
            </a>
            <a href="{{ route('contact') }}" class="px-8 py-4 rounded-xl text-base font-bold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 transition-all duration-300 shadow-sm">
                Hubungi Kami
            </a>
        </div>
    </div>
</section>

@endsection
