<?php require 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShoeCare - Platform Jasa Cuci Sepatu Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { 
            theme: { 
                extend: { 
                    colors: { 
                        mahogany: { DEFAULT: '#C04000', hover: '#A03500', light: '#E65C1A' }, 
                        shoeBlue: { DEFAULT: '#1E3A8A', light: '#3B82F6', pale: '#EFF6FF' } 
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                } 
            } 
        }
    </script>
    <!-- Animasi CSS Sederhana -->
    <style>
        .fade-in-up { animation: fadeInUp 0.8s ease-out forwards; opacity: 0; transform: translateY(20px); }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
        .bg-grid { background-image: radial-gradient(#cbd5e1 1px, transparent 1px); background-size: 24px 24px; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased overflow-x-hidden">

    <!-- NAVBAR -->
    <nav class="bg-white/90 backdrop-blur-md shadow-sm fixed w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <!-- Ikon Logo Sementara (Bisa diganti dengan desain logo vector gelembung sabun & sepatu) -->
                <div class="bg-shoeBlue text-white p-2 rounded-lg text-xl">👟</div>
                <span class="font-extrabold text-2xl text-shoeBlue tracking-tight">ShoeCare.</span>
            </div>
            <div class="hidden md:flex space-x-8 font-semibold text-sm text-gray-600">
                <a href="#beranda" class="hover:text-mahogany transition">Beranda</a>
                <a href="#layanan" class="hover:text-mahogany transition">Layanan</a>
                <a href="#keunggulan" class="hover:text-mahogany transition">Keunggulan</a>
                <a href="#cara-kerja" class="hover:text-mahogany transition">Cara Kerja</a>
            </div>
            <div>
                <a href="login.php" class="bg-mahogany text-white px-6 py-2.5 rounded-full font-bold shadow-md hover:bg-mahogany-hover hover:shadow-lg transition-all transform hover:-translate-y-0.5">Mulai Pesan &rarr;</a>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section id="beranda" class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 bg-shoeBlue-pale bg-grid overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
            <div class="fade-in-up">
                <span class="inline-block py-1 px-3 rounded-full bg-blue-100 text-shoeBlue font-bold text-xs uppercase tracking-wider mb-4 border border-blue-200">
                    Startup Digital #1 di Medan
                </span>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-shoeBlue leading-tight">
                    Rawat Sepatu Kesayanganmu Tanpa Harus <span class="text-mahogany">Repot Mencuci.</span>
                </h1>
                <p class="mt-6 text-lg text-gray-600 leading-relaxed max-w-lg">
                    Sibuk kuliah atau kerja? Takut sepatu rusak jika dicuci sendiri? ShoeCare hadir menawarkan layanan cuci sepatu yang praktis, aman, dan profesional dengan sistem antar-jemput.
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="login.php" class="bg-mahogany text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-mahogany-hover transition shadow-lg flex items-center gap-2">
                        <span>🛵</span> Pesan Layanan Sekarang
                    </a>
                </div>
            </div>
            <!-- Ruang untuk Ilustrasi Vector/Maskot -->
            <div class="relative fade-in-up delay-100 hidden md:block">
                <div class="absolute inset-0 bg-blue-200 rounded-full blur-3xl opacity-50"></div>
                <div class="relative bg-white p-8 rounded-3xl shadow-2xl border border-gray-100 transform rotate-2 hover:rotate-0 transition duration-500 text-center">
                    <span class="text-9xl block mb-4">✨👟</span>
                    <h3 class="font-bold text-gray-800 text-xl">Premium Footwear Solutions</h3>
                    <p class="text-sm text-gray-500 mt-2">Kebersihan, Kepercayaan, Keamanan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION TARGET AUDIENS & KEUNGGULAN -->
    <section id="keunggulan" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16 fade-in-up">
                <h2 class="text-3xl font-extrabold text-shoeBlue mb-4">Mengapa Memilih ShoeCare?</h2>
                <p class="text-gray-600">Didesain khusus untuk mahasiswa, pelajar, pekerja muda, dan pecinta sneakers yang menginginkan efisiensi waktu.</p>
            </div>
            
            <div class="grid md:grid-cols-4 gap-8">
                <!-- Card 1 -->
                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 hover:shadow-xl transition fade-in-up">
                    <div class="w-14 h-14 bg-blue-100 text-shoeBlue rounded-xl flex items-center justify-center text-2xl mb-4">💎</div>
                    <h3 class="font-bold text-xl mb-2 text-gray-800">Profesional & Aman</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Pencucian dilakukan oleh tenaga ahli dengan peralatan dan sabun khusus yang menjaga material sepatu agar tidak rusak.</p>
                </div>
                <!-- Card 2 -->
                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 hover:shadow-xl transition fade-in-up delay-100">
                    <div class="w-14 h-14 bg-orange-100 text-mahogany rounded-xl flex items-center justify-center text-2xl mb-4">🛵</div>
                    <h3 class="font-bold text-xl mb-2 text-gray-800">Layanan Antar-Jemput</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Tidak perlu keluar rumah. Kurir kami akan menjemput sepatu kotor dan mengantarkannya kembali dalam keadaan bersih.</p>
                </div>
                <!-- Card 3 -->
                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 hover:shadow-xl transition fade-in-up delay-200">
                    <div class="w-14 h-14 bg-green-100 text-green-600 rounded-xl flex items-center justify-center text-2xl mb-4">💸</div>
                    <h3 class="font-bold text-xl mb-2 text-gray-800">Harga Terjangkau</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Kami menawarkan layanan premium dengan harga yang pas dan sangat wajar untuk kantong mahasiswa.</p>
                </div>
                <!-- Card 4 -->
                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 hover:shadow-xl transition fade-in-up delay-200">
                    <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center text-2xl mb-4">📱</div>
                    <h3 class="font-bold text-xl mb-2 text-gray-800">Berbasis Digital</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Pemesanan dan pemantauan status cuci sepatu dilakukan secara praktis melalui platform aplikasi web kami.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION LAYANAN -->
    <section id="layanan" class="py-20 bg-shoeBlue text-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold mb-4">Layanan Perawatan Kami</h2>
                <p class="text-blue-200">Pilih paket yang paling sesuai dengan kebutuhan sepatu kesayanganmu.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Reguler -->
                <div class="bg-white text-gray-800 p-8 rounded-3xl shadow-lg relative overflow-hidden transform hover:-translate-y-2 transition duration-300">
                    <h3 class="text-2xl font-bold text-shoeBlue mb-2">Cuci Reguler</h3>
                    <p class="text-gray-500 text-sm mb-6">Pembersihan standar untuk sepatu pemakaian sehari-hari.</p>
                    <div class="text-3xl font-extrabold mb-6">Rp 35.000 <span class="text-sm font-normal text-gray-400">/pasang</span></div>
                    <ul class="space-y-3 mb-8 text-sm font-medium text-gray-600">
                        <li class="flex items-center gap-2"><span class="text-green-500">✔</span> Cuci Midsole & Outsole</li>
                        <li class="flex items-center gap-2"><span class="text-green-500">✔</span> Cuci Upper & Insole</li>
                        <li class="flex items-center gap-2"><span class="text-green-500">✔</span> Pewangi Anti Bakteri</li>
                        <li class="flex items-center gap-2"><span class="text-gray-400">✔</span> Estimasi 3 Hari Selesai</li>
                    </ul>
                    <a href="login.php" class="block text-center w-full bg-blue-100 text-shoeBlue font-bold py-3 rounded-xl hover:bg-blue-200 transition">Pilih Paket</a>
                </div>

                <!-- Express -->
                <div class="bg-white text-gray-800 p-8 rounded-3xl shadow-2xl relative overflow-hidden transform scale-105 border-4 border-mahogany hover:-translate-y-2 transition duration-300">
                    <div class="absolute top-0 right-0 bg-mahogany text-white text-xs font-bold px-3 py-1 rounded-bl-lg uppercase">Paling Laris</div>
                    <h3 class="text-2xl font-bold text-shoeBlue mb-2">Cuci Express</h3>
                    <p class="text-gray-500 text-sm mb-6">Butuh cepat? Sepatu bersih kilat tanpa antre panjang.</p>
                    <div class="text-3xl font-extrabold text-mahogany mb-6">Rp 50.000 <span class="text-sm font-normal text-gray-400">/pasang</span></div>
                    <ul class="space-y-3 mb-8 text-sm font-medium text-gray-600">
                        <li class="flex items-center gap-2"><span class="text-green-500">✔</span> Semua fitur Cuci Reguler</li>
                        <li class="flex items-center gap-2"><span class="text-green-500">✔</span> Prioritas Pengerjaan</li>
                        <li class="flex items-center gap-2"><span class="text-green-500">✔</span> 1 Hari Langsung Selesai</li>
                    </ul>
                    <a href="login.php" class="block text-center w-full bg-mahogany text-white font-bold py-3 rounded-xl hover:bg-mahogany-hover transition shadow-lg">Pilih Paket Express</a>
                </div>

                <!-- Premium & Produk -->
                <div class="bg-white text-gray-800 p-8 rounded-3xl shadow-lg relative overflow-hidden transform hover:-translate-y-2 transition duration-300">
                    <h3 class="text-2xl font-bold text-shoeBlue mb-2">Premium Care</h3>
                    <p class="text-gray-500 text-sm mb-6">Perawatan ekstra untuk sepatu bahan khusus (Leather/Suede).</p>
                    <div class="text-3xl font-extrabold mb-6">Rp 80.000 <span class="text-sm font-normal text-gray-400">/pasang</span></div>
                    <ul class="space-y-3 mb-8 text-sm font-medium text-gray-600">
                        <li class="flex items-center gap-2"><span class="text-green-500">✔</span> Deep Cleaning Detail</li>
                        <li class="flex items-center gap-2"><span class="text-green-500">✔</span> Chemical Khusus Material</li>
                        <li class="flex items-center gap-2"><span class="text-green-500">✔</span> Mink Oil / Suede Protector</li>
                        <li class="flex items-center gap-2"><span class="text-green-500">✔</span> Gratis Penjualan Produk Mini</li>
                    </ul>
                    <a href="login.php" class="block text-center w-full bg-blue-100 text-shoeBlue font-bold py-3 rounded-xl hover:bg-blue-200 transition">Pilih Paket Premium</a>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION CARA KERJA -->
    <section id="cara-kerja" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-extrabold text-center text-shoeBlue mb-16">Alur Layanan Kami</h2>
            <div class="flex flex-col md:flex-row justify-center items-center gap-8 md:gap-4 text-center">
                <div class="flex-1 px-4">
                    <div class="w-20 h-20 bg-white shadow-xl rounded-2xl flex items-center justify-center text-3xl font-bold text-shoeBlue mx-auto mb-6 transform rotate-3">📱</div>
                    <h4 class="font-bold text-lg mb-2 text-gray-800">1. Pesan di Web</h4>
                    <p class="text-gray-500 text-sm">Login, pilih layanan, dan masukkan alamat lengkap.</p>
                </div>
                <div class="hidden md:block text-gray-300 text-2xl font-bold">&rarr;</div>
                <div class="flex-1 px-4">
                    <div class="w-20 h-20 bg-white shadow-xl rounded-2xl flex items-center justify-center text-3xl font-bold text-mahogany mx-auto mb-6 transform -rotate-3">🛵</div>
                    <h4 class="font-bold text-lg mb-2 text-gray-800">2. Kurir Menjemput</h4>
                    <p class="text-gray-500 text-sm">Kurir kami mendatangi lokasi untuk mengambil sepatu kotor.</p>
                </div>
                <div class="hidden md:block text-gray-300 text-2xl font-bold">&rarr;</div>
                <div class="flex-1 px-4">
                    <div class="w-20 h-20 bg-white shadow-xl rounded-2xl flex items-center justify-center text-3xl font-bold text-shoeBlue mx-auto mb-6 transform rotate-3">✨</div>
                    <h4 class="font-bold text-lg mb-2 text-gray-800">3. Proses Pencucian</h4>
                    <p class="text-gray-500 text-sm">Sepatu dicuci profesional dan dipantau via dashboard.</p>
                </div>
                <div class="hidden md:block text-gray-300 text-2xl font-bold">&rarr;</div>
                <div class="flex-1 px-4">
                    <div class="w-20 h-20 bg-white shadow-xl rounded-2xl flex items-center justify-center text-3xl font-bold text-green-500 mx-auto mb-6 transform -rotate-3">🎁</div>
                    <h4 class="font-bold text-lg mb-2 text-gray-800">4. Diantar Kembali</h4>
                    <p class="text-gray-500 text-sm">Sepatu bersih, wangi, dan aman sampai kembali ke tanganmu.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-shoeBlue text-white pt-16 pb-8 border-t border-blue-900">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-8 mb-12">
            <div>
                <div class="flex items-center space-x-2 mb-4">
                    <span class="text-2xl">👟</span>
                    <span class="font-extrabold text-2xl tracking-tight">ShoeCare.</span>
                </div>
                <p class="text-blue-200 text-sm leading-relaxed pr-4">Startup layanan pencucian dan perawatan sepatu berbasis digital. Solusi modern untuk langkah kaki yang lebih percaya diri.</p>
            </div>
            <div>
                <h4 class="font-bold text-lg mb-4 text-white">Layanan</h4>
                <ul class="space-y-2 text-sm text-blue-200">
                    <li><a href="#" class="hover:text-white transition">Cuci Reguler</a></li>
                    <li><a href="#" class="hover:text-white transition">Cuci Express</a></li>
                    <li><a href="#" class="hover:text-white transition">Premium Care</a></li>
                    <li><a href="#" class="hover:text-white transition">Produk Perawatan</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-lg mb-4 text-white">Hubungi Kami</h4>
                <ul class="space-y-2 text-sm text-blue-200">
                    <li>📍 Universitas Islam Negeri Sumatera Utara, Medan</li>
                    <li>📞 0812-XXXX-XXXX</li>
                    <li>✉️ cs@shoecare-startup.com</li>
                </ul>
            </div>
        </div>
        <div class="text-center text-sm text-blue-300 border-t border-blue-800 pt-8">
            &copy; 2026 Perencanaan Startup ShoeCare - Program Studi Sistem Informasi UINSU.
        </div>
    </footer>

</body>
</html>