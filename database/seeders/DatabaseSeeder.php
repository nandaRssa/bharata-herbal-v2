<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\StoreSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat User Admin
        User::firstOrCreate(
            ['email' => 'admin@bharataherbal.id'],
            [
                'name' => 'Admin Bharata',
                'password' => Hash::make('password123'),
            ]
        );

        // 2. Buat Pengaturan Awal Toko
        StoreSetting::updateOrCreate(
            ['id' => 1],
            [
                'store_name' => 'Bharata Herbal ID',
                'wa_number' => '6281234567890',
                'store_address' => 'Jl. Herbal Nusantara No. 8, Jakarta Pusat',
                'operating_hours' => 'Senin - Sabtu (08.00 - 17.00)',
            ]
        );

        // 3. Buat Data Produk Default
        $products = [
            [
                'name' => 'Channamax Bharata',
                'description' => 'Membantu mempercepat penyembuhan luka pasca operasi, luka bakar, dan memelihara kesehatan tubuh.',
                'benefits' => ['Mempercepat penyembuhan luka operasi', 'Meningkatkan kadar albumin tubuh', 'Menjaga daya tahan tubuh'],
                'ingredients' => 'Ekstrak Channa striata (Ikan Gabus) berkualitas tinggi.',
                'usage' => '3 x 2 kapsul per hari, diminum 1 jam sebelum makan.',
                'price' => 275000,
                'stock' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Cordymax Bharata',
                'description' => 'Membantu memelihara kesehatan sistem pernapasan dan paru-paru secara alami.',
                'benefits' => ['Menjaga kesehatan paru-paru', 'Meredakan batuk kronis dan sesak napas', 'Meningkatkan stamina tubuh'],
                'ingredients' => 'Ekstrak Cordyceps sinensis pilihan.',
                'usage' => '2 x 2 kapsul per hari.',
                'price' => 295000,
                'stock' => 35,
                'is_active' => true,
            ],
            [
                'name' => 'Minyak Sapu Jagat',
                'description' => 'Minyak gosok herbal untuk meredakan pegal linu, nyeri sendi, perut kembung, dan masuk angin.',
                'benefits' => ['Meredakan nyeri sendi dan otot', 'Menghangatkan tubuh', 'Mengatasi perut kembung'],
                'ingredients' => 'Campuran minyak kelapa murni, minyak sereh, minyak kayu putih, dan ekstrak tanaman herbal.',
                'usage' => 'Oleskan dan gosok merata pada area tubuh yang terasa sakit atau pegal.',
                'price' => 125000,
                'stock' => 8,
                'is_active' => true,
            ],
            [
                'name' => 'Teh Daun Kelor Premium',
                'description' => 'Teh herbal dari daun kelor pilihan kaya antioksidan untuk mendetoksifikasi racun tubuh.',
                'benefits' => ['Sumber antioksidan tinggi', 'Membantu menurunkan kadar gula darah', 'Detoksifikasi alami tubuh'],
                'ingredients' => '100% Daun Kelor (Moringa oleifera) kering berkualitas.',
                'usage' => 'Seduh 1 kantong teh dengan air panas (200ml), diamkan 5 menit. Minum 2x sehari.',
                'price' => 45000,
                'stock' => 15,
                'is_active' => true,
            ],
            [
                'name' => 'Verdilla Bharata',
                'description' => 'Herbal Bharata untuk membantu memelihara kesehatan saluran pernapasan, paru-paru, dan daya tahan tubuh. Produk ini terdaftar BPOM TR213390451 dan bersertifikat halal LPPOM-I5130105710123.',
                'benefits' => ['Membantu melegakan saluran pernapasan', 'Membantu meredakan batuk berdahak dan sesak napas', 'Membantu menjaga daya tahan tubuh', 'Membantu mengurangi peradangan pada saluran napas'],
                'ingredients' => 'Komposisi utama: Andrographis Paniculata Herba Ekstrak. Kemasan botol dus isi 60 kapsul.',
                'usage' => 'Diminum 3 x 2 kapsul, 1 jam sebelum makan. Perbanyak minum air putih dan konsultasikan bila memiliki kondisi medis khusus.',
                'price' => 276000,
                'stock' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Vellare Bharata',
                'description' => 'Herbal Bharata untuk membantu menjaga kesehatan ginjal, saluran kemih, dan membantu proses peluruhan batu ginjal atau batu empedu secara tradisional. Terdaftar BPOM TR223016141 dan halal LPPOM-I5130105710123.',
                'benefits' => ['Membantu melancarkan buang air kecil', 'Membantu menjaga kesehatan ginjal dan saluran kemih', 'Membantu meredakan keluhan kencing batu', 'Membantu mengurangi peradangan saluran kemih'],
                'ingredients' => 'Komposisi utama: Imperata Cylindrica Herba Ekstrak. Kemasan botol dus isi 50 kapsul.',
                'usage' => 'Penggunaan umum 3 x 2 kapsul sebelum makan. Untuk perawatan ringan dapat diminum 2 x 1 kapsul sebelum makan sesuai kebutuhan dan arahan konsultasi.',
                'price' => 276000,
                'stock' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Orthafit Bharata',
                'description' => 'Herbal Bharata untuk membantu memelihara kesehatan ginjal, prostat, dan saluran kemih, termasuk keluhan anyang-anyangan atau infeksi saluran kemih. Terdaftar BPOM TR223013141 dan halal LPPOM-I5130105710123.',
                'benefits' => ['Membantu meredakan anyang-anyangan', 'Membantu melancarkan saluran kemih', 'Membantu menjaga kesehatan ginjal', 'Membantu mencegah pembentukan batu ginjal'],
                'ingredients' => 'Komposisi utama: Orthosiphon Aristatus Herba Ekstrak 300 mg. Kemasan botol dus isi 50 kapsul.',
                'usage' => 'Diminum 3 x 2 kapsul, 1 jam sebelum makan. Simpan di tempat sejuk dan kering.',
                'price' => 276000,
                'stock' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Dekapro Bharata',
                'description' => 'Herbal Bharata untuk membantu mendukung pemulihan jaringan, luka, peradangan, dan keluhan terkait hernia atau varikokel. Terdaftar BPOM TR233008201 dan halal LPPOM-I5130105710123.',
                'benefits' => ['Membantu mendukung regenerasi sel dan jaringan', 'Membantu mempercepat pemulihan luka', 'Membantu mengurangi peradangan', 'Membantu memperkuat jaringan otot yang lemah'],
                'ingredients' => 'Komposisi utama: Holothuria Sp Ekstrak 1000 mg atau ekstrak teripang emas. Kemasan botol dus isi 30 kapsul.',
                'usage' => 'Diminum 3 x 2 kapsul, 1 jam sebelum makan. Tidak dianjurkan untuk ibu hamil atau menyusui tanpa konsultasi dokter.',
                'price' => 296000,
                'stock' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Gerdafost Bharata',
                'description' => 'Herbal Bharata untuk membantu menjaga kesehatan lambung dan pencernaan, termasuk keluhan GERD, maag kronis, mual, kembung, dan nyeri ulu hati. Terdaftar BPOM TR213393381 dan halal LPPOM-I5130105710123.',
                'benefits' => ['Membantu menetralkan asam lambung berlebih', 'Membantu melindungi dinding lambung', 'Membantu mengurangi peradangan saluran cerna', 'Membantu meredakan kembung dan nyeri ulu hati'],
                'ingredients' => 'Komposisi utama: Curcuma Domestica Rhizoma Ekstrak 200 mg dan Aloe Vera Folium Ekstrak 200 mg. Kemasan botol dus isi 50 kapsul.',
                'usage' => 'Diminum 3 x 2 kapsul, 1 jam sebelum makan. Minum dengan air hangat dan perbanyak air putih.',
                'price' => 276000,
                'stock' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Remafost Bharata',
                'description' => 'Herbal Bharata untuk membantu memelihara kesehatan sendi, tulang, dan saraf, terutama pada keluhan radang sendi, rematik, pegal linu, asam urat, dan saraf kejepit. Terdaftar BPOM TR223005011 dan halal LPPOM-I5130105710123.',
                'benefits' => ['Membantu meredakan nyeri sendi dan pegal linu', 'Membantu mengurangi peradangan', 'Membantu menjaga kadar asam urat', 'Membantu mendukung mobilitas sendi'],
                'ingredients' => 'Komposisi utama: Nigella Sativa Semen Ekstrak 200 mg dan Apium Graveolens Herba Ekstrak 200 mg. Kemasan botol dus isi 50 kapsul.',
                'usage' => 'Diminum 3 x 2 kapsul, 1 jam sebelum makan. Wanita hamil dan menyusui sebaiknya berkonsultasi terlebih dahulu.',
                'price' => 276000,
                'stock' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Galrida Bharata',
                'description' => 'Herbal Bharata untuk membantu memelihara kondisi kesehatan sel dan jaringan tubuh serta mendukung daya tahan tubuh. Terdaftar BPOM TR223004971 dan halal LPPOM-I5130105710123.',
                'benefits' => ['Membantu menjaga kesehatan jaringan tubuh', 'Membantu mendukung daya tahan tubuh', 'Membantu melawan radikal bebas', 'Membantu memelihara kondisi tubuh pada keluhan benjolan atau tumor secara tradisional'],
                'ingredients' => 'Komposisi utama: Annona Muricata Herba Ekstrak atau ekstrak daun sirsak. Kemasan botol dus isi 50 kapsul.',
                'usage' => 'Diminum 3 x 2 kapsul sebelum makan. Untuk perawatan dapat diminum 2 x 1 kapsul sebelum makan. Tidak dianjurkan untuk ibu hamil dan menyusui.',
                'price' => 276000,
                'stock' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Libaver Bharata',
                'description' => 'Herbal Bharata untuk membantu menjaga kesehatan hati dan mendukung fungsi liver pada keluhan hepatitis, sakit kuning, asites, atau sirosis secara tradisional. Terdaftar BPOM TR223009931 dan halal LPPOM-I5130105710123.',
                'benefits' => ['Membantu menjaga fungsi liver', 'Membantu mendukung pemulihan pada keluhan hepatitis', 'Membantu menjaga daya tahan tubuh', 'Membantu proses detoksifikasi alami tubuh'],
                'ingredients' => 'Komposisi utama: Curcuma Rhizoma Ekstrak dan Andrographis Paniculata Herba Ekstrak. Kemasan botol dus isi 50 kapsul.',
                'usage' => 'Diminum 3 x 2 kapsul, 1 jam sebelum makan. Jika memiliki darah rendah, sedang hamil, atau menyusui, konsultasikan terlebih dahulu.',
                'price' => 276000,
                'stock' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Antapro Bharata',
                'description' => 'Herbal Bharata untuk membantu memelihara kesehatan jantung, sirkulasi darah, tekanan darah, kolesterol, dan dukungan pemulihan pasca stroke secara tradisional. Terdaftar BPOM TR223041501 dan halal LPPOM-I5130105710123.',
                'benefits' => ['Membantu melancarkan sirkulasi darah', 'Membantu menjaga kesehatan jantung', 'Membantu menstabilkan tekanan darah', 'Membantu mendukung fungsi saraf dan otak'],
                'ingredients' => 'Komposisi utama: Centella Asiatica Herba Ekstrak. Kemasan botol dus isi 50 kapsul.',
                'usage' => 'Diminum 3 x 2 kapsul, 1 jam sebelum makan. Konsultasikan bila sedang memakai obat dokter atau memiliki kondisi medis khusus.',
                'price' => 276000,
                'stock' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Triganos Bharata',
                'description' => 'Herbal Bharata untuk membantu menjaga kesehatan saluran kemih dan area genital, terutama pada keluhan kencing sakit, kencing nanah, gonore, sipilis, herpes genital, atau chlamydia secara tradisional. Terdaftar BPOM TR223023941 dan halal LPPOM-I5130105710123.',
                'benefits' => ['Membantu membersihkan saluran kemih', 'Membantu meredakan nyeri saat buang air kecil', 'Membantu mendukung daya tahan tubuh', 'Membantu mengurangi peradangan pada saluran kemih'],
                'ingredients' => 'Komposisi utama: Orthosiphon Aristatus Herba Ekstrak 200 mg dan Phyllanthus Urinaria Herba Ekstrak 200 mg. Kemasan botol dus isi 50 kapsul.',
                'usage' => 'Diminum 3 x 2 kapsul, 1 jam sebelum makan. Tidak dianjurkan untuk ibu hamil atau menyusui tanpa konsultasi dokter.',
                'price' => 276000,
                'stock' => 50,
                'is_active' => true,
            ],
            [
                'name'        => 'Glucacare Bharata',
                'description' => 'Herbal Bharata untuk membantu memelihara kadar gula darah normal dan mendukung pemulihan pada keluhan diabetes mellitus tipe 1 maupun tipe 2, termasuk luka diabetes. Terdaftar BPOM POM TR 223068651 dan bersertifikat halal.',
                'benefits'    => [
                    'Membantu menurunkan dan mengontrol kadar gula darah',
                    'Membantu mendukung pemulihan luka diabetes basah maupun kering',
                    'Membantu meningkatkan sensitivitas insulin secara alami',
                    'Membantu menjaga stamina dan vitalitas penderita diabetes',
                ],
                'ingredients' => 'Komposisi utama: Tinospora Crispa Caulis Ekstrak (Ekstrak Batang Brotowali) dan Cinnamomum Buramanii Cortex Ekstrak (Ekstrak Kulit Kayu Manis). Kemasan botol dus.',
                'usage'       => 'Diminum 3 x 2 kapsul, 1 jam sebelum makan. Konsultasikan dengan dokter jika sedang menjalani terapi insulin atau obat diabetes resep.',
                'price'       => 276000,
                'stock'       => 50,
                'is_active'   => true,
            ],
            [
                'name'        => 'Femmifresh Bharata',
                'description' => 'Herbal Bharata untuk membantu menjaga kesehatan area kewanitaan, mengatasi keputihan, bau tidak sedap, dan membantu merawat keseimbangan flora vagina secara alami. Terdaftar BPOM POM TR 223045661 dan bersertifikat halal.',
                'benefits'    => [
                    'Membantu mengatasi keputihan dan bau tidak sedap',
                    'Membantu menjaga keseimbangan flora alami area kewanitaan',
                    'Mengandung antibakteri dan antijamur alami dari bahan herbal',
                    'Membantu menjaga kesehatan dan kebersihan area intim',
                ],
                'ingredients' => 'Komposisi utama: Quercus infectoria fructus Ekstrak (Manjakani) 150 mg dan Piper betle folium Ekstrak (Daun Sirih) 200 mg. Kemasan botol dus isi 50 kapsul.',
                'usage'       => 'Diminum 3 x 2 kapsul sebelum makan. Untuk perawatan rutin dapat diminum 2 x 1 kapsul. Simpan di tempat sejuk dan kering.',
                'price'       => 275000,
                'stock'       => 50,
                'is_active'   => true,
            ],
            [
                'name'        => 'Cordepro Bharata',
                'description' => 'Herbal Bharata untuk membantu memelihara kesehatan saluran pernapasan dan paru-paru, termasuk keluhan TBC, flek paru, bronkitis kronis, asma, dan sesak napas. Formulasi multi-herbal dengan 9 bahan aktif. Terdaftar BPOM POM TR 243032711.',
                'benefits'    => [
                    'Membantu melegakan saluran pernapasan dan paru-paru',
                    'Membantu mendukung pemulihan pada keluhan TBC dan flek paru secara tradisional',
                    'Membantu mengurangi gejala batuk kronis dan sesak napas',
                    'Membantu meningkatkan daya tahan tubuh dan stamina',
                ],
                'ingredients' => 'Komposisi utama: Cinnamomum zeylanicum (Kayu Manis), Piper retrofractum (Cabai Jawa), Cyperus rotundus (Rumput Teki), Curcuma zedoaria (Temu Putih), Curcuma xanthorrhiza (Temulawak), Curcuma mangga (Temu Mangga), Centella asiatica (Pegagan), Andrographis paniculata (Sambiloto), Phyllanthus niruri (Meniran). Kemasan botol dus isi 50 kapsul.',
                'usage'       => 'Diminum 3 x 2 kapsul, 1 jam sebelum makan. Tidak menggantikan pengobatan medis (OAT) dari dokter untuk kondisi TBC aktif.',
                'price'       => 395000,
                'stock'       => 50,
                'is_active'   => true,
            ],
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(['name' => $p['name']], $p);
        }

    }
}

