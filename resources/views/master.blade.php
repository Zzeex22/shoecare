<!DOCTYPE html>
<html lang="id">
<head>
    <title>@yield('title') - ShoeCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Tambahkan CDN FontAwesome di sini lek -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = { theme: { extend: { colors: { mahogany: '#C04000', shoeBlue: '#1E3A8A', freshGreen: '#10B981', darkSlate: '#1E293B' } } } }
    </script>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden font-sans">
    
    <aside class="w-64 {{ Auth::user()->role == 'admin' ? 'bg-darkSlate text-slate-300' : 'bg-white border-r border-gray-200' }} flex flex-col justify-between shadow-lg z-10">
        <div>
            <!-- LOGO HEADER -->
            <div class="p-6 border-b {{ Auth::user()->role == 'admin' ? 'border-slate-700' : 'border-gray-100' }} flex items-center gap-3">
                <div class="{{ Auth::user()->role == 'admin' ? 'bg-freshGreen' : 'bg-shoeBlue' }} text-white w-10 h-10 rounded-xl flex items-center justify-center text-xl shadow-md">
                    <i class="fa-solid fa-shoe-prints"></i>
                </div>
                <div>
                    <h1 class="font-extrabold text-lg tracking-wide {{ Auth::user()->role == 'admin' ? 'text-white' : 'text-shoeBlue' }}">ShoeCare.</h1>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ Auth::user()->role }} Area</p>
                </div>
            </div>

            <!-- MENU SIDEBAR -->
            <nav class="p-4 mt-2 space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition {{ request()->routeIs('dashboard') ? (Auth::user()->role == 'admin' ? 'bg-freshGreen text-white shadow-md' : 'bg-blue-50 text-shoeBlue border-l-4 border-shoeBlue') : 'hover:bg-gray-100 hover:text-gray-800' }}">
                    <i class="fa-solid fa-chart-pie w-5 text-center"></i> Dashboard
                </a>
                
                @if(Auth::user()->role == 'admin' || Auth::user()->role == 'kurir')
                    <a href="{{ route('admin.pesanan') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition {{ request()->routeIs('admin.pesanan') ? 'bg-freshGreen text-white shadow-md' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-motorcycle w-5 text-center"></i> Kelola Pesanan
                    </a>
                    <a href="{{ route('admin.produk') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition {{ request()->routeIs('admin.produk') ? 'bg-freshGreen text-white shadow-md' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-box-open w-5 text-center"></i> Kelola Produk
                    </a>
                @else
                    <a href="{{ route('pesanan.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition {{ request()->routeIs('pesanan.create') ? 'bg-blue-50 text-shoeBlue border-l-4 border-shoeBlue' : 'hover:bg-gray-100 hover:text-gray-800' }}">
                        <i class="fa-solid fa-plus w-5 text-center"></i> Buat Pesanan
                    </a>
                    <a href="{{ route('pesanan.pantau') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition {{ request()->routeIs('pesanan.pantau') ? 'bg-blue-50 text-shoeBlue border-l-4 border-shoeBlue' : 'hover:bg-gray-100 hover:text-gray-800' }}">
                        <i class="fa-solid fa-location-dot w-5 text-center"></i> Pantau Pesanan
                    </a>
                    <a href="{{ route('toko.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition {{ request()->routeIs('toko.index') ? 'bg-blue-50 text-shoeBlue border-l-4 border-shoeBlue' : 'hover:bg-gray-100 hover:text-gray-800' }}">
                        <i class="fa-solid fa-store w-5 text-center"></i> Toko Produk
                    </a>
                    <a href="{{ route('pesanan.riwayat') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition {{ request()->routeIs('pesanan.riwayat') ? 'bg-blue-50 text-shoeBlue border-l-4 border-shoeBlue' : 'hover:bg-gray-100 hover:text-gray-800' }}">
                        <i class="fa-solid fa-clock-rotate-left w-5 text-center"></i> Riwayat Order
                    </a>
                @endif
            </nav>
        </div>
        
        <div class="p-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf 
                <button type="submit" class="w-full text-center py-2.5 rounded-xl transition text-sm font-bold border flex items-center justify-center gap-2 {{ Auth::user()->role == 'admin' ? 'bg-slate-800 border-slate-600 text-slate-300 hover:bg-red-500 hover:text-white hover:border-red-500' : 'bg-red-50 border-red-200 text-red-600 hover:bg-red-500 hover:text-white' }}">
                    <i class="fa-solid fa-power-off"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="bg-white/90 backdrop-blur-md shadow-sm border-b px-8 py-5 flex items-center justify-between sticky top-0 z-10">
            <h2 class="text-xl font-bold text-gray-800">@yield('page_title')</h2>
            <span class="bg-gray-100 text-gray-600 px-4 py-2 rounded-full text-sm font-bold border border-gray-200">
                <i class="fa-regular fa-user mr-1"></i> Hai, {{ explode(' ', Auth::user()->name)[0] }}
            </span>
        </header>

        <div class="p-8 max-w-7xl mx-auto w-full">
            @if(session('success'))
                <div class="px-5 py-4 rounded-xl mb-6 font-bold shadow-sm bg-green-100 text-green-700 border border-green-300 flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-xl"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="px-5 py-4 rounded-xl mb-6 font-bold shadow-sm bg-red-100 text-red-700 border border-red-300 flex items-center gap-3">
                    <i class="fa-solid fa-circle-xmark text-xl"></i> {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</body>
</html>