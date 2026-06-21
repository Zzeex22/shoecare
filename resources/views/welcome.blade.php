<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ShoeCare - Premium Footwear Solutions</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = { theme: { extend: { colors: { shoeBlue: '#1E3A8A', freshGreen: '#10B981', mahogany: '#C04000' } } } }
    </script>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800">

    <!-- NAVBAR -->
    <nav class="bg-white/90 backdrop-blur-md shadow-sm fixed w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-3">
                    <div class="bg-shoeBlue text-white w-10 h-10 rounded-xl flex items-center justify-center text-xl shadow-lg">
                        <i class="fa-solid fa-shoe-prints"></i>
                    </div>
                    <span class="font-extrabold text-2xl tracking-wide text-shoeBlue">ShoeCare.</span>
                </div>
                <div class="hidden md:flex space-x-8 font-bold text-gray-500">
                    <a href="#profil" class="hover:text-shoeBlue transition">Profil Kami</a>
                    <a href="#visimisi" class="hover:text-shoeBlue transition">Visi Misi</a>
                    <a href="#carakerja" class="hover:text-shoeBlue transition">Cara Kerja</a>
                </div>
                <div class="flex space-x-4 items-center">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-bold text-shoeBlue hover:text-blue-900">Ke Dashboard <i class="fa-solid fa-arrow-right ml-1"></i></a>
                    @else
                        <a href="{{ route('login') }}" class="font-bold text-gray-600 hover:text-shoeBlue">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-shoeBlue text-white px-6 py-2.5 rounded-full font-bold shadow-md hover:bg-blue-900 transition">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden relative">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-blue-100/50 blur-3xl z-0"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-green-100/50 blur-3xl z-0"></div>
        
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-5xl md:text-7xl font-extrabold text-slate-800 tracking-tight mb-6">
                Sepatu Bersih, <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-shoeBlue to-freshGreen">Langkah Lebih Percaya Diri.</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-500 mb-10 max-w-2xl mx-auto">
                Layanan cuci sepatu premium on-demand. Antar-jemput gratis, pantau pesanan secara live, dan dapatkan perawatan terbaik untuk koleksi kesayanganmu.
            </p>
            <div class="flex justify-center gap-4">
                <a href="{{ route('register') }}" class="bg-shoeBlue text-white px-8 py-4 rounded-full font-bold text-lg shadow-xl hover:shadow-2xl hover:-translate-y-1 transition flex items-center gap-2">
                    <i class="fa-solid fa-motorcycle"></i> Pesan Sekarang
                </a>
                <a href="#carakerja" class="bg-white text-shoeBlue border-2 border-shoeBlue px-8 py-4 rounded-full font-bold text-lg hover:bg-blue-50 transition">
                    Lihat Cara Kerja
                </a>
            </div>
        </div>
    </section>

    <!-- PROFIL PERUSAHAAN -->
    <section id="profil" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="w-16 h-16 bg-blue-50 text-shoeBlue rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-sm"><i class="fa-solid fa-building"></i></div>
                    <h2 class="text-3xl font-extrabold text-gray-800 mb-4">Siapa ShoeCare?</h2>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        ShoeCare adalah platform digital pionir di Indonesia yang fokus pada layanan perawatan dan pencucian alas kaki premium. Berawal dari project *System Information Enterprise*, kami berkembang menjadi solusi nyata bagi para *sneakerhead* dan masyarakat urban yang sibuk.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        Kami menggabungkan teknik pencucian profesional dengan teknologi live-tracking "GoJek-style" untuk memberikan pengalaman pelanggan yang aman, cepat, dan transparan.
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100 text-center"><h3 class="text-4xl font-extrabold text-freshGreen mb-2">5K+</h3><p class="text-sm font-bold text-gray-500">Sepatu Dicuci</p></div>
                    <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100 text-center"><h3 class="text-4xl font-extrabold text-shoeBlue mb-2">100%</h3><p class="text-sm font-bold text-gray-500">Garansi Aman</p></div>
                    <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100 text-center"><h3 class="text-4xl font-extrabold text-mahogany mb-2">24h</h3><p class="text-sm font-bold text-gray-500">Layanan Kilat</p></div>
                    <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100 text-center"><h3 class="text-4xl font-extrabold text-yellow-500 mb-2">5.0</h3><p class="text-sm font-bold text-gray-500">Rating Pelanggan</p></div>
                </div>
            </div>
        </div>
    </section>

    <!-- VISI MISI -->
    <section id="visimisi" class="py-20 bg-slate-900 text-white relative">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <span class="text-freshGreen font-bold tracking-wider uppercase text-sm mb-2 block">Tujuan Kami</span>
                <h2 class="text-3xl md:text-4xl font-extrabold">Visi & Misi Perusahaan</h2>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="md:col-span-1 bg-white/10 backdrop-blur-sm p-8 rounded-3xl border border-white/20">
                    <div class="w-12 h-12 bg-freshGreen text-white rounded-full flex items-center justify-center text-xl mb-6 shadow-lg"><i class="fa-solid fa-eye"></i></div>
                    <h3 class="text-xl font-bold mb-3">Visi Kami</h3>
                    <p class="text-gray-300 text-sm leading-relaxed">Menjadi pelopor revolusi digital dalam industri perawatan sepatu di Asia Tenggara, memberikan layanan on-demand yang transparan, mudah diakses, dan ramah lingkungan.</p>
                </div>
                <div class="md:col-span-2 grid sm:grid-cols-2 gap-6">
                    <div class="bg-white/5 p-6 rounded-3xl border border-white/10">
                        <i class="fa-solid fa-mobile-screen text-freshGreen text-2xl mb-4 block"></i>
                        <h4 class="font-bold mb-2">Digitalisasi Layanan</h4>
                        <p class="text-sm text-gray-400">Memberikan kemudahan pemesanan dan pemantauan status pesanan secara *real-time* dari genggaman tangan.</p>
                    </div>
                    <div class="bg-white/5 p-6 rounded-3xl border border-white/10">
                        <i class="fa-solid fa-star text-freshGreen text-2xl mb-4 block"></i>
                        <h4 class="font-bold mb-2">Kualitas Premium</h4>
                        <p class="text-sm text-gray-400">Menggunakan bahan pembersih ramah lingkungan dan teknik khusus untuk menjaga keawetan material sepatu.</p>
                    </div>
                    <div class="bg-white/5 p-6 rounded-3xl border border-white/10">
                        <i class="fa-solid fa-handshake-angle text-freshGreen text-2xl mb-4 block"></i>
                        <h4 class="font-bold mb-2">Pemberdayaan Mitra</h4>
                        <p class="text-sm text-gray-400">Menciptakan lapangan kerja yang adil dan menguntungkan bagi mitra kurir antar-jemput lokal.</p>
                    </div>
                    <div class="bg-white/5 p-6 rounded-3xl border border-white/10">
                        <i class="fa-solid fa-leaf text-freshGreen text-2xl mb-4 block"></i>
                        <h4 class="font-bold mb-2">Eco-Friendly</h4>
                        <p class="text-sm text-gray-400">Berkomitmen untuk mengurangi limbah air dan menggunakan produk yang 100% aman bagi bumi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CARA KERJA -->
    <section id="carakerja" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-shoeBlue font-bold tracking-wider uppercase text-sm mb-2 block">Alur Sistem</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-800">Gimana Cara Pesannya?</h2>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Step 1 -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 text-center relative">
                    <div class="w-10 h-10 bg-shoeBlue text-white rounded-full flex items-center justify-center font-bold text-sm absolute -top-5 left-1/2 transform -translate-x-1/2 border-4 border-gray-50">1</div>
                    <div class="text-5xl text-gray-300 mb-6 mt-4"><i class="fa-solid fa-mobile-button"></i></div>
                    <h3 class="font-bold text-lg mb-2">Buat Pesanan</h3>
                    <p class="text-sm text-gray-500">Pilih jenis layanan, masukkan alamat penjemputan, dan pilih metode pembayaran.</p>
                </div>
                <!-- Step 2 -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 text-center relative">
                    <div class="w-10 h-10 bg-shoeBlue text-white rounded-full flex items-center justify-center font-bold text-sm absolute -top-5 left-1/2 transform -translate-x-1/2 border-4 border-gray-50">2</div>
                    <div class="text-5xl text-gray-300 mb-6 mt-4"><i class="fa-solid fa-motorcycle"></i></div>
                    <h3 class="font-bold text-lg mb-2">Kurir Menjemput</h3>
                    <p class="text-sm text-gray-500">Mitra kurir kami akan mengambil sepatumu sesuai jadwal dan titik lokasi.</p>
                </div>
                <!-- Step 3 -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 text-center relative">
                    <div class="w-10 h-10 bg-shoeBlue text-white rounded-full flex items-center justify-center font-bold text-sm absolute -top-5 left-1/2 transform -translate-x-1/2 border-4 border-gray-50">3</div>
                    <div class="text-5xl text-gray-300 mb-6 mt-4"><i class="fa-solid fa-hands-bubbles"></i></div>
                    <h3 class="font-bold text-lg mb-2">Proses Cuci</h3>
                    <p class="text-sm text-gray-500">Sepatu dicuci menggunakan teknik dan sabun premium. Pantau *live* di aplikasi!</p>
                </div>
                <!-- Step 4 -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 text-center relative">
                    <div class="w-10 h-10 bg-freshGreen text-white rounded-full flex items-center justify-center font-bold text-sm absolute -top-5 left-1/2 transform -translate-x-1/2 border-4 border-gray-50">4</div>
                    <div class="text-5xl text-gray-300 mb-6 mt-4"><i class="fa-solid fa-box-open"></i></div>
                    <h3 class="font-bold text-lg mb-2">Selesai & Diantar</h3>
                    <p class="text-sm text-gray-500">Sepatu bersih, wangi, dan dipacking rapi siap diantarkan kembali ke depan pintumu.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-gray-200 py-10 text-center">
        <p class="text-gray-500 font-medium text-sm">
            &copy; 2026 ShoeCare System. Dibuat untuk Project SI Enterprise. <br>
            <span class="text-xs text-gray-400 mt-1 block">Powered by Laravel</span>
        </p>
    </footer>

</body>
</html>