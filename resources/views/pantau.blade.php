@extends('master')
@section('title', 'Pantau Pesanan')
@section('page_title', 'Live Tracking Pesanan Aktif')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<div class="space-y-8">
    @forelse($orders as $row)
    <div class="bg-white rounded-3xl shadow-lg border-2 border-shoeBlue/20 overflow-hidden relative">
        <div class="absolute top-5 right-6 flex items-center gap-2 z-20">
            <span class="relative flex h-3 w-3"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-freshGreen opacity-75"></span><span class="relative inline-flex rounded-full h-3 w-3 bg-freshGreen"></span></span>
            <span class="text-xs font-bold text-freshGreen bg-white px-2 py-1 rounded-full shadow-sm">LIVE</span>
        </div>

        <div class="p-6 border-b border-gray-100 bg-blue-50/30">
            <span class="text-xs font-bold text-gray-500 uppercase">ID Transaksi</span>
            <span class="font-extrabold text-2xl text-shoeBlue block mb-2">#{{ $row->kode_order }}</span>
            <p class="font-bold text-gray-700 bg-white inline-block px-3 py-1 rounded-lg border border-gray-200"><i class="fa-solid fa-tag text-shoeBlue mr-1"></i> {{ $row->jenis_layanan }}</p>
        </div>

        <!-- FITUR PETA (MUNCUL PAS DIJEMPUT/DIANTAR ATAU TIBA) -->
        @if(in_array($row->status, ['Menunggu Pickup', 'Sedang Diantar', 'Tiba di Tujuan']))
            <div id="map-{{ $row->id }}" class="w-full h-64 border-y border-gray-200 z-10"></div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var map = L.map('map-{{ $row->id }}').setView([-3.5952, 114.3158], 14); // Set default peta
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
                    
                    var lat = -3.5952; var lng = 114.3158;
                    
                    // Kalau masih OTW, icon motor gerak
                    @if($row->status != 'Tiba di Tujuan')
                        var kurirIcon = L.divIcon({ html: '<i class="fa-solid fa-motorcycle text-3xl text-mahogany drop-shadow-md"></i>', className: '', iconSize: [30, 30] });
                        var marker = L.marker([lat, lng], {icon: kurirIcon}).addTo(map).bindPopup("Kurir ShoeCare OTW nih! 🛵").openPopup();
                        
                        setInterval(() => {
                            lat += 0.0001; lng += 0.0001;
                            marker.setLatLng([lat, lng]);
                            map.panTo([lat, lng], {animate: true});
                        }, 1500);
                        
                    // Kalau Kurir udah pencet Sampai, icon berubah jadi rumah & ada notifikasi
                    @else
                        var userIcon = L.divIcon({ html: '<i class="fa-solid fa-house-circle-check text-4xl text-freshGreen drop-shadow-lg"></i>', className: '', iconSize: [40, 40] });
                        L.marker([lat, lng], {icon: userIcon}).addTo(map).bindPopup("<b>Sampai di Lokasi!</b><br>Kurir udah ada di depan rumah kamu nih!").openPopup();
                    @endif
                });
            </script>
        @endif
        
        <div class="p-8">
            <div class="mt-4 bg-gray-50 rounded-2xl p-5 border border-gray-200 flex justify-between items-center">
                <div>
                    <p class="text-sm font-bold text-gray-500">Status Saat Ini:</p>
                    <p class="text-xl font-extrabold text-shoeBlue">{{ $row->status }}</p>
                </div>
            </div>

            <!-- FORM RATING & SELESAI (MUNCUL KALO STATUSNYA SEDANG DIANTAR ATAU TIBA DI TUJUAN) -->
            @if($row->status == 'Sedang Diantar' || $row->status == 'Tiba di Tujuan')
            <div class="mt-6 {{ $row->status == 'Tiba di Tujuan' ? 'bg-green-50 border-green-300' : 'bg-amber-50 border-amber-300' }} border-2 p-6 rounded-2xl transition-all">
                <h3 class="font-black {{ $row->status == 'Tiba di Tujuan' ? 'text-green-800' : 'text-amber-800' }} text-lg mb-2">
                    <i class="fa-solid fa-bell {{ $row->status == 'Tiba di Tujuan' ? 'text-green-500' : 'text-amber-500' }} animate-bounce mr-2"></i>
                    {{ $row->status == 'Tiba di Tujuan' ? 'Kurir Udah Nyaris di Depan rumah kamu!' : 'Barang nya Udah Sampe belum?' }}
                </h3>
                <p class="text-sm text-gray-600 mb-4">Pastikan sepatu/barangmu sudah diterima dengan aman. Kalau udah, selesaikan pesanan dan kasih rating abang kurirnya ya!</p>
                
                <form action="{{ route('pesanan.selesaikan', $row->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kasih Bintang Untuk Kurir (1-5)</label>
                        <select name="rating" required class="w-full border-2 border-gray-200 p-3 rounded-xl bg-white outline-none font-bold text-orange-500">
                            <option value="5">⭐⭐⭐⭐⭐ (Sangat Puas)</option>
                            <option value="4">⭐⭐⭐⭐ (Puas)</option>
                            <option value="3">⭐⭐⭐ (Biasa Aja)</option>
                            <option value="2">⭐⭐ (Kurang)</option>
                            <option value="1">⭐ (Parah)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Ulasan Singkat (Opsional)</label>
                        <input type="text" name="ulasan" placeholder="Cth: Kurirnya ramah bet, mantap!" class="w-full border-2 border-gray-200 p-3 rounded-xl bg-white outline-none">
                    </div>
                    <button type="submit" class="w-full bg-freshGreen text-white py-4 rounded-xl font-extrabold text-lg shadow-lg hover:bg-green-600 transition flex justify-center items-center gap-2">
                        <i class="fa-solid fa-check-double"></i> Pesanan Diterima & Beri Rating
                    </button>
                </form>
            </div>
            @endif

        </div>
    </div>
    @empty
    <div class="bg-white p-12 rounded-3xl shadow-sm text-center border border-gray-200">
        <i class="fa-solid fa-magnifying-glass-location text-6xl text-gray-300 mb-4 block animate-bounce"></i>
        <p class="text-gray-800 font-extrabold text-xl">Tidak ada pesanan yang sedang aktif.</p>
        <a href="{{ route('pesanan.create') }}" class="mt-6 inline-block bg-shoeBlue text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-900 transition shadow-md">Pesan Sekarang</a>
    </div>
    @endforelse
</div>
@endsection