<!DOCTYPE html>
<html lang="id">
<head>
    <title>Daftar Akun - ShoeCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = { theme: { extend: { colors: { mahogany: '#C04000', shoeBlue: '#1E3A8A', freshGreen: '#10B981' } } } }
    </script>
</head>
<body class="bg-gray-50 min-h-screen font-sans flex items-center justify-center p-4">

    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 flex overflow-hidden max-w-4xl w-full">
        
        <!-- BAGIAN KIRI: BRANDING REGISTRASI -->
        <div class="hidden md:flex md:w-5/12 bg-mahogany p-10 flex-col justify-between relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-black/20 to-transparent z-10"></div>
            <!-- Ornamen -->
            <i class="fa-solid fa-star text-9xl absolute -bottom-10 -right-10 text-white/10 z-0"></i>
            
            <div class="relative z-20">
                <a href="/" class="flex items-center gap-3 text-white mb-12">
                    <i class="fa-solid fa-shoe-prints text-2xl"></i>
                    <span class="font-black text-xl tracking-wide">ShoeCare.</span>
                </a>
                <h2 class="text-4xl font-black text-white mb-4">Gabung<br>Sekarang!</h2>
                <p class="text-red-100 font-medium text-sm leading-relaxed">
                    Daftar untuk menikmati layanan antar-jemput cuci sepatu, belanja produk premium, dan kumpulkan poin loyalty untuk diskon melimpah.
                </p>
            </div>
            
            <div class="relative z-20 bg-black/20 p-4 rounded-xl backdrop-blur-sm border border-white/10 mt-8">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-gift text-amber-400 text-2xl"></i>
                    <p class="text-white text-xs font-bold leading-tight">Dapatkan Poin Setiap Transaksi Selesai!</p>
                </div>
            </div>
        </div>

        <!-- BAGIAN KANAN: FORM REGISTER -->
        <div class="w-full md:w-7/12 p-8 lg:p-12">
            <div class="text-center md:text-left mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Buat Akun Baru</h2>
                <p class="text-gray-500 font-medium text-sm">Lengkapi data diri di bawah ini dengan benar.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Input Nama -->
                <div>
                    <label for="name" class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" class="pl-11 w-full border-2 border-gray-200 py-3 rounded-xl bg-gray-50 focus:border-shoeBlue focus:bg-white focus:ring-0 outline-none transition transition-all" placeholder="John Doe">
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-500 text-xs" />
                </div>

                <!-- Input Email -->
                <div>
                    <label for="email" class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" class="pl-11 w-full border-2 border-gray-200 py-3 rounded-xl bg-gray-50 focus:border-shoeBlue focus:bg-white focus:ring-0 outline-none transition transition-all" placeholder="contoh@email.com">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500 text-xs" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Input Password -->
                    <div>
                        <label for="password" class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="new-password" class="pl-11 w-full border-2 border-gray-200 py-3 rounded-xl bg-gray-50 focus:border-shoeBlue focus:bg-white focus:ring-0 outline-none transition transition-all" placeholder="Minimal 8 karakter">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-500 text-xs" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Ulangi Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                <i class="fa-solid fa-shield-check"></i>
                            </div>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="pl-11 w-full border-2 border-gray-200 py-3 rounded-xl bg-gray-50 focus:border-shoeBlue focus:bg-white focus:ring-0 outline-none transition transition-all" placeholder="Ketik ulang password">
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-500 text-xs" />
                    </div>
                </div>

                <!-- Tombol Register -->
                <button type="submit" class="w-full bg-shoeBlue text-white py-4 rounded-xl font-extrabold text-lg shadow-lg shadow-blue-900/30 hover:bg-blue-900 hover:-translate-y-1 transition transform mt-2 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-user-plus"></i> Daftar Akun
                </button>
            </form>

            <p class="mt-6 text-center text-sm font-medium text-gray-600">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-extrabold text-mahogany hover:underline">Masuk sekarang</a>
            </p>
        </div>
    </div>

</body>
</html> 