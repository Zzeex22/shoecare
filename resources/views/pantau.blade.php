@extends('master')
@section('title', 'Pantau Pesanan')
@section('page_title', 'Live Tracking Pesanan Aktif')

@section('content')
<div class="space-y-6">
    @forelse($orders as $row)
    <div class="bg-white rounded-3xl shadow-lg border-2 border-shoeBlue/20 overflow-hidden relative">
        <div class="absolute top-5 right-6 flex items-center gap-2">
            <span class="relative flex h-3 w-3"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-freshGreen opacity-75"></span><span class="relative inline-flex rounded-full h-3 w-3 bg-freshGreen"></span></span>
            <span class="text-xs font-bold text-freshGreen">LIVE</span>
        </div>
        <div class="p-6 border-b border-gray-100 bg-blue-50/30">
            <span class="text-xs font-bold text-gray-500 uppercase">ID Transaksi</span>
            <span class="font-extrabold text-2xl text-shoeBlue block mb-2">#{{ $row->kode_order }}</span>
            <p class="font-bold text-gray-700 bg-white inline-block px-3 py-1 rounded-lg border border-gray-200"><i class="fa-solid fa-tag text-shoeBlue mr-1"></i> {{ $row->jenis_layanan }}</p>
        </div>
        <div class="p-8">
            @php $step = 1; if($row->status == 'Menunggu Pickup') $step = 2; if($row->status == 'Sedang Dicuci') $step = 3; @endphp
            <div class="flex items-center justify-between relative max-w-4xl mx-auto">
                <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-2 bg-gray-100 rounded-full z-0"></div>
                <div class="absolute left-0 top-1/2 transform -translate-y-1/2 h-2 bg-freshGreen rounded-full z-0 transition-all duration-1000" style="width: {{ ($step - 1) * 33.33 }}%"></div>
                <div class="relative z-10 flex flex-col items-center"><div class="w-12 h-12 rounded-full flex items-center justify-center text-xl {{ $step >= 1 ? 'bg-freshGreen text-white shadow-lg ring-4 ring-green-100' : 'bg-gray-200 text-gray-400' }}"><i class="fa-solid fa-clipboard-list"></i></div><span class="text-xs font-bold mt-3 text-center {{ $step >= 1 ? 'text-gray-800' : 'text-gray-400' }}">Order<br>Masuk</span></div>
                <div class="relative z-10 flex flex-col items-center"><div class="w-12 h-12 rounded-full flex items-center justify-center text-xl {{ $step >= 2 ? 'bg-freshGreen text-white shadow-lg ring-4 ring-green-100' : 'bg-gray-200 text-gray-400' }}"><i class="fa-solid fa-motorcycle"></i></div><span class="text-xs font-bold mt-3 text-center {{ $step >= 2 ? 'text-gray-800' : 'text-gray-400' }}">Kurir<br>Jemput</span></div>
                <div class="relative z-10 flex flex-col items-center"><div class="w-12 h-12 rounded-full flex items-center justify-center text-xl {{ $step >= 3 ? 'bg-freshGreen text-white shadow-lg ring-4 ring-green-100' : 'bg-gray-200 text-gray-400' }}"><i class="fa-solid fa-hands-bubbles"></i></div><span class="text-xs font-bold mt-3 text-center {{ $step >= 3 ? 'text-gray-800' : 'text-gray-400' }}">Proses<br>Cuci</span></div>
                <div class="relative z-10 flex flex-col items-center"><div class="w-12 h-12 rounded-full flex items-center justify-center text-xl bg-gray-200 text-gray-400"><i class="fa-solid fa-box-open"></i></div><span class="text-xs font-bold mt-3 text-center text-gray-400">Selesai &<br>Diantar</span></div>
            </div>
            <div class="mt-10 bg-gray-50 rounded-2xl p-5 border border-gray-200 flex justify-between items-center">
                <div><p class="text-sm font-bold text-gray-500">Status Saat Ini:</p><p class="text-lg font-extrabold text-shoeBlue">{{ $row->status }}</p></div>
                <a href="https://wa.me/6281200000000?text=Halo%20Admin%20ShoeCare,%20saya%20mau%20tanya%20status%20pesanan%20saya%20dengan%20Kode:%20{{ $row->kode_order }}" target="_blank" class="bg-green-100 text-green-700 hover:bg-green-200 py-2.5 px-5 rounded-xl text-sm font-bold border border-green-300 transition flex items-center gap-2"><i class="fa-brands fa-whatsapp text-lg"></i> Hubungi Admin</a>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white p-12 rounded-3xl shadow-sm text-center border border-gray-200">
        <i class="fa-solid fa-magnifying-glass-location text-6xl text-gray-300 mb-4 block animate-bounce"></i>
        <p class="text-gray-800 font-extrabold text-xl">Tidak ada pesanan yang sedang aktif.</p>
        <p class="text-gray-500 mt-2">Sepatumu udah bersih semua lek! Atau mau pesan lagi?</p>
        <a href="{{ route('pesanan.create') }}" class="mt-6 inline-block bg-shoeBlue text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-900 transition shadow-md"><i class="fa-solid fa-plus mr-2"></i>Pesan Layanan Sekarang</a>
    </div>
    @endforelse
</div>
@endsection