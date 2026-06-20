@extends('master')
@section('title', 'Poin ShoeCare Saya')
@section('page_title', 'Member Loyalty Program')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Banner Poin Utama -->
    <div class="bg-gradient-to-r from-amber-400 to-orange-500 rounded-3xl p-8 mb-8 text-white shadow-xl relative overflow-hidden flex items-center justify-between">
        <div class="absolute -right-10 -top-10 text-9xl opacity-20"><i class="fa-solid fa-star"></i></div>
        <div class="relative z-10">
            <p class="font-bold text-amber-100 uppercase tracking-widest text-sm mb-1">Saldo Poin ShoeCare</p>
            <h2 class="text-5xl font-black mb-2 flex items-center gap-3">
                <i class="fa-solid fa-coins animate-bounce"></i> {{ number_format(Auth::user()->poin, 0, ',', '.') }}
            </h2>
            <p class="text-sm font-medium bg-white/20 inline-block px-3 py-1 rounded-full border border-white/30">
                1 Poin setara dengan potongan Rp 1
            </p>
        </div>
        <div class="relative z-10 hidden sm:block">
            <a href="{{ route('pesanan.create') }}" class="bg-white text-orange-600 px-6 py-3 rounded-full font-extrabold shadow-lg hover:bg-orange-50 transition block text-center">Pakai Poin Sekarang</a>
        </div>
    </div>

    <!-- Penjelasan Sistem Poin untuk Dosen/User -->
    <div class="grid md:grid-cols-2 gap-6">
        <!-- Cara Dapat Poin -->
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <div class="w-14 h-14 bg-green-50 text-freshGreen rounded-2xl flex items-center justify-center text-2xl mb-5 shadow-sm border border-green-100"><i class="fa-solid fa-sack-dollar"></i></div>
            <h3 class="font-extrabold text-xl text-gray-800 mb-3">Gimana Cara Dapet Poin?</h3>
            <ul class="space-y-4 text-gray-600 text-sm">
                <li class="flex gap-3">
                    <i class="fa-solid fa-circle-check text-freshGreen mt-0.5"></i>
                    <span>Setiap pesanan Jasa Cuci Sepatu yang berstatus <strong>Selesai</strong> otomatis memberikanmu <em>Cashback</em> 10% dalam bentuk poin.</span>
                </li>
                <li class="flex gap-3">
                    <i class="fa-solid fa-circle-check text-freshGreen mt-0.5"></i>
                    <span>Setiap pembelian Produk Pembersih dari Toko kami juga akan memberikan bonus poin.</span>
                </li>
                <li class="flex gap-3">
                    <i class="fa-solid fa-circle-check text-freshGreen mt-0.5"></i>
                    <span>Makin sering nyuci dan belanja, makin banyak poin yang numpuk!</span>
                </li>
            </ul>
        </div>

        <!-- Cara Pakai Poin -->
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <div class="w-14 h-14 bg-blue-50 text-shoeBlue rounded-2xl flex items-center justify-center text-2xl mb-5 shadow-sm border border-blue-100"><i class="fa-solid fa-tags"></i></div>
            <h3 class="font-extrabold text-xl text-gray-800 mb-3">Cara Tukar Poin Buat Diskon</h3>
            <ul class="space-y-4 text-gray-600 text-sm">
                <li class="flex gap-3">
                    <div class="w-6 h-6 rounded-full bg-shoeBlue text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">1</div>
                    <span>Pilih menu <strong>Buat Pesanan</strong> atau beli barang di <strong>Toko Produk</strong>.</span>
                </li>
                <li class="flex gap-3">
                    <div class="w-6 h-6 rounded-full bg-shoeBlue text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">2</div>
                    <span>Isi form pengiriman seperti biasa. Di bagian paling bawah (sebelum tombol order), centang kotak <strong>"Gunakan Poin"</strong>.</span>
                </li>
                <li class="flex gap-3">
                    <div class="w-6 h-6 rounded-full bg-shoeBlue text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">3</div>
                    <span>Harga pesananmu otomatis dipotong sesuai dengan jumlah poin yang kamu miliki saat sistem memproses orderannya. Gampang kan?</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection