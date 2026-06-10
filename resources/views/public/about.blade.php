@extends('layouts.public')
@section('title', 'Tentang Kami')

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
            Profil Perusahaan
        </div>
        
        <!-- Heading -->
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight mb-6">
            Tentang Bharata Herbal
        </h1>
        
        <!-- Description -->
        <p class="text-lg md:text-xl text-slate-600 max-w-2xl mx-auto leading-relaxed">
            Menyediakan berbagai produk herbal berkualitas untuk mendukung kesehatan dan kesejahteraan masyarakat Indonesia melalui pilihan produk yang terpercaya dan terstandarisasi.
        </p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-20">
    <!-- Grid Kisah Kami -->
    <div class="grid md:grid-cols-2 gap-12 items-center">
        <div>
            <h2 class="text-3xl md:text-4xl font-bold font-serif-elegant mb-6" style="color: var(--primary);">Kisah Kami</h2>
            <p class="text-slate-600 leading-relaxed mb-4 text-sm md:text-base">Bharata Herbal ID lahir dari kecintaan mendalam terhadap kekayaan tanaman obat Nusantara. Kami percaya bahwa tanah Indonesia menyimpan rahasia kesehatan alami yang tak ternilai harganya.</p>
            <p class="text-slate-600 leading-relaxed text-sm md:text-base">Didirikan untuk melestarikan tradisi jamu Indonesia, kami menghadirkan racikan herbal premium yang diformulasikan secara higienis menggunakan teknologi mutakhir tanpa menghilangkan esensi kemurnian khasiat aslinya.</p>
        </div>
        <div class="grid grid-cols-2 gap-4">
            @foreach([['🌿','Bahan Alami','100% dari alam Nusantara'],['🔬','Teruji Klinis','Formulasi ilmiah modern'],['🏆','Premium Gold','Kualitas & keaslian terjamin'],['🚚','Kirim Cepat','Layanan kurir ke seluruh wilayah']] as [$icon,$title,$desc])
            <div class="bg-white rounded-2xl p-5 text-center border border-slate-100 shadow-sm hover:shadow-md transition duration-300">
                <div class="text-3xl mb-3">{{ $icon }}</div>
                <div class="font-bold text-sm text-slate-800">{{ $title }}</div>
                <div class="text-xs text-slate-400 mt-1.5 leading-relaxed">{{ $desc }}</div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Visi Misi Banner -->
    <div class="text-center py-16 px-8 rounded-3xl relative overflow-hidden bg-slate-50 border border-slate-100 shadow-sm">
        <div class="absolute inset-0" style="background: linear-gradient(135deg, var(--primary-light) 0%, #ffffff 100%);"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] bg-emerald-100 rounded-full blur-[80px] opacity-60 pointer-events-none"></div>
        
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold mb-4 tracking-wide bg-white shadow-sm" style="color: var(--primary);">
                <div class="w-1.5 h-1.5 rounded-full" style="background-color: var(--primary);"></div>
                Visi & Misi Utama
            </div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">Komitmen bagi Masyarakat</h2>
            <p class="text-slate-600 max-w-2xl mx-auto text-base md:text-lg leading-relaxed">Menjadi penyedia ramuan herbal terpercaya yang memadukan kearifan lokal Nusantara dengan standarisasi global, demi meningkatkan imunitas dan kualitas hidup masyarakat Indonesia.</p>
        </div>
    </div>

    <!-- Komitmen Kualitas -->
    <div>
        <h2 class="text-3xl font-bold mb-10 text-center font-serif-elegant" style="color: var(--primary);">Standar Kualitas & Keamanan</h2>
        <div class="grid md:grid-cols-3 gap-8">
            @foreach([
                'Seleksi Bahan Baku' => 'Kami hanya memanen dan menyortir tanaman herbal terbaik langsung dari mitra petani lokal dengan kualitas tanah organik prima.',
                'Proses Higienis' => 'Diproduksi di fasilitas modern berstandar GMP dengan sistem filtrasi debu dan suhu terkontrol untuk menjaga sterilisasi kapsul.',
                'Quality Control' => 'Melalui serangkaian pengujian laboratorium internal sebelum mendapatkan persetujuan izin edar BPOM dan sertifikat Halal.'
            ] as $title => $desc)
            <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition duration-300">
                <div class="w-10 h-10 rounded-full mb-5 flex items-center justify-center text-white font-bold text-sm shadow-sm" style="background: var(--gold);">✓</div>
                <h3 class="font-bold text-lg mb-2 text-slate-800">{{ $title }}</h3>
                <p class="text-xs text-slate-500 leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
