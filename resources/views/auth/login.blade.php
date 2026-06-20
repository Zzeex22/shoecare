<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login - ShoeCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = { theme: { extend: { colors: { mahogany: '#C04000', shoeBlue: '#1E3A8A', freshGreen: '#10B981' } } } }
    </script>
</head>
<body class="bg-gray-50 h-screen font-sans overflow-hidden flex">

    <!-- BAGIAN KIRI: BRANDING -->
    <div class="hidden lg:flex lg:w-1/2 bg-shoeBlue relative items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-black/20 z-10"></div>
        <!-- Ornamen Background -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-600 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-mahogany rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
        
        <div class="relative z-20 text-center text-white px-12">
            <div class="bg-white/10 w-24 h-24 rounded-2xl flex items-center justify-center text-5xl mx-auto mb-6 backdrop-blur-sm border border-white/20 shadow-2xl">
                <i class="fa-solid fa-shoe-prints text-mahogany"></i>
            </div>
            <h1 class="text-5xl font-black mb-4 tracking-tight">ShoeCare.</h1>
            <p class="text-lg text-blue-100 font-medium">Layanan cuci sepatu on-demand & produk perawatan premium nomor satu.</p>
        </div>
    </div>

    <!-- BAGIAN KANAN: FORM LOGIN -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white relative">
        <div class="max-w-md w-full">
            <!-- Judul Form -->
            <div class="text-center mb-10">
                <div class="lg:hidden bg-shoeBlue w-16 h-16 rounded-xl flex items-center justify-center text-3xl mx-auto mb-4 text-white shadow-lg">
                    <i class="fa-solid fa-shoe-prints"></i>
                </div>
                <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Selamat Datang!</h2>
                <p class="text-gray-500 font-medium">Silakan masuk ke akun ShoeCare Anda.</p>
            </div>

            <!-- Pesan Error Bawaan Laravel -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Input Email -->
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 uppercase tracking-wide mb-2">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" class="pl-11 w-full border-2 border-gray-200 py-3 rounded-xl bg-gray-50 focus:border-mahogany focus:bg-white focus:ring-0 outline-none transition transition-all" placeholder="contoh@email.com">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
                </div>

                <!-- Input Password -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-sm font-bold text-gray-700 uppercase tracking-wide">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs font-bold text-mahogany hover:text-red-700 transition">Lupa Password?</a>
                        @endif
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password" class="pl-11 w-full border-2 border-gray-200 py-3 rounded-xl bg-gray-50 focus:border-mahogany focus:bg-white focus:ring-0 outline-none transition transition-all" placeholder="••••••••">
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="w-5 h-5 rounded border-gray-300 text-mahogany focus:ring-mahogany cursor-pointer">
                    <label for="remember_me" class="ml-2 block text-sm font-medium text-gray-600 cursor-pointer">
                        Ingat Saya
                    </label>
                </div>

                <!-- Tombol Login -->
                <button type="submit" class="w-full bg-mahogany text-white py-4 rounded-xl font-extrabold text-lg shadow-lg shadow-mahogany/30 hover:bg-[#A03000] hover:-translate-y-1 transition transform flex items-center justify-center gap-2">
                    <i class="fa-solid fa-right-to-bracket"></i> Masuk Sekarang
                </button>
            </form>

            <p class="mt-8 text-center text-sm font-medium text-gray-600">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-extrabold text-shoeBlue hover:underline">Daftar di sini</a>
            </p>
        </div>
    </div>
</body>
</html>