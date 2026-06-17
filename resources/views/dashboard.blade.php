@extends('master')
@section('title', 'Dashboard')
@section('page_title', 'Ringkasan Sistem')

@section('content')
<div class="grid grid-cols-2 gap-6 mb-6">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 border-l-8 border-l-shoeBlue">
        <p class="text-gray-500 font-bold text-sm">TOTAL SEMUA PESANAN</p>
        <h3 class="text-4xl font-extrabold text-gray-800 mt-2">{{ $total_order }}</h3>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 border-l-8 border-l-freshGreen">
        <p class="text-gray-500 font-bold text-sm">PESANAN AKTIF (PROSES)</p>
        <h3 class="text-4xl font-extrabold text-gray-800 mt-2">{{ $order_aktif }}</h3>
    </div>
</div>
<div class="bg-blue-50 p-6 rounded-2xl border border-blue-100">
    <h3 class="text-lg font-bold text-shoeBlue mb-2">Selamat Datang di ShoeCare System</h3>
    <p class="text-gray-600">Gunakan menu di sebelah kiri untuk melakukan navigasi ke fitur yang Anda butuhkan.</p>
</div>
@endsection