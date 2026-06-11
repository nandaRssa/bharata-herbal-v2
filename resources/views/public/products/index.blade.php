@extends('layouts.public')
@section('title', 'Produk Herbal')

@section('content')
<!-- Header Halaman -->
<div class="relative py-28 overflow-hidden bg-white border-b border-slate-100">
    <!-- Abstract blurred shapes for background -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-gradient-to-tr from-emerald-50 to-emerald-100 rounded-full blur-3xl opacity-60 pointer-events-none -translate-y-1/2"></div>
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M54.627 0l.83.83v58.34l-.83.83H5.373l-.83-.83V.83l.83-.83h49.254zM53.5 2.127H6.5v55.746h47V2.127z\' fill=\'%23008060\' fill-opacity=\'0.02\' fill-rule=\'evenodd\'/%3E%3C/svg%3E')]"></div>
    
    <div class="relative z-10 max-w-4xl mx-auto px-4 text-center">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold mb-6 tracking-wide shadow-sm" style="background-color: var(--primary-light); color: var(--primary);">
            <div class="w-1.5 h-1.5 rounded-full" style="background-color: var(--primary);"></div>
            Katalog Produk
        </div>
        
        <!-- Heading -->
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight mb-6">
            Temukan Produk Herbal Sesuai Kebutuhan Anda
        </h1>
        
        <!-- Description -->
        <p class="text-lg md:text-xl text-slate-600 max-w-2xl mx-auto leading-relaxed">
            Berbagai pilihan produk herbal berkualitas untuk mendukung kesehatan, kebugaran, dan kesejahteraan Anda setiap hari.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <!-- Search Bar -->
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-12 border border-gray-100/70">
        <form method="GET" action="{{ route('products.index') }}" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1 relative flex items-center">
                <span class="absolute left-4 text-emerald-800/50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </span>
                <input type="text" name="search" placeholder="Cari produk herbal unggulan kami..." value="{{ request('search') }}"
                    class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-600/10 focus:border-emerald-700/30 text-slate-700 font-medium transition duration-200">
            </div>
            <button type="submit" class="px-8 py-3.5 rounded-xl font-bold text-white transition duration-200 shadow-md hover:shadow-lg" style="background: var(--primary);">
                Cari Produk
            </button>
            @if(request('search'))
                <a href="{{ route('products.index') }}" class="px-6 py-3.5 rounded-xl font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 transition duration-200 text-center flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Hasil Produk -->
    @if($products->isEmpty())
    <div class="text-center py-24 bg-white rounded-2xl border border-dashed border-gray-200">
        <div class="text-6xl mb-4">🌿</div>
        <h3 class="text-2xl font-bold text-slate-700">Produk Tidak Ditemukan</h3>
        <p class="text-slate-400 mt-2 max-w-xs mx-auto">Silakan coba menggunakan kata kunci pencarian yang lain.</p>
        <a href="{{ route('products.index') }}" class="mt-6 inline-block px-6 py-2.5 rounded-lg text-sm font-bold text-white shadow-sm" style="background: var(--primary);">Reset Katalog</a>
    </div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        @foreach($products as $product)
        <a href="{{ route('products.show', $product->slug) }}" class="group flex flex-col h-full bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl border border-slate-100 transition-all duration-300 transform hover:-translate-y-1">
            <!-- Image Section -->
            <div class="relative overflow-hidden flex-shrink-0 aspect-square bg-slate-50">
                @if($product->images->isNotEmpty())
                <img src="{{ asset('storage/' . ($product->images->where('is_primary', true)->first() ?? $product->images->first())->image_path) }}"
                     alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                @else
                <div class="w-full h-full flex items-center justify-center text-6xl opacity-30">🌿</div>
                @endif
                @if($product->discounted_price)
                <div class="absolute top-3 left-3 bg-rose-500 text-white text-[10px] font-bold px-2 py-1 rounded-lg shadow-md z-10">
                    -{{ $product->discount_percentage }}%
                </div>
                @endif
                <div class="absolute inset-0 bg-emerald-900/0 group-hover:bg-emerald-900/5 transition duration-300"></div>
            </div>
            
            <div class="p-5 flex flex-col flex-grow">
                <!-- Product Name -->
                <h3 class="font-bold text-lg leading-snug line-clamp-2 text-slate-800 group-hover:text-emerald-700 transition duration-200 mb-2">
                    {{ $product->name }}
                </h3>
                
                <!-- Benefits -->
                @if($product->benefits)
                <div class="flex flex-wrap gap-1.5 mb-4">
                    @foreach(array_slice($product->benefits, 0, 2) as $benefit)
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-emerald-50 text-emerald-800 border border-emerald-100 uppercase tracking-wide">{{ $benefit }}</span>
                    @endforeach
                </div>
                @endif
                
                <!-- Price & CTA Action -->
                <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        @if($product->discounted_price)
                        <div class="text-lg font-extrabold" style="color: var(--primary);">{{ $product->formatted_discounted_price }}</div>
                        <div class="text-xs text-slate-400 line-through font-medium">{{ $product->formatted_price }}</div>
                        @else
                        <div class="font-extrabold text-lg text-emerald-600">{{ $product->formatted_price }}</div>
                        @endif
                    </div>
                    <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-16 border-t border-gray-100 pt-8">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
