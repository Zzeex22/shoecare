@extends('master')
@section('title', 'Buat Pesanan')
@section('page_title', 'Form Pemesanan Antar-Jemput')

@section('content')
<div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 max-w-3xl">
    <h3 class="font-extrabold text-2xl mb-1 text-shoeBlue"><i class="fa-solid fa-hands-bubbles mr-2"></i>Mau Cuci Sepatu?</h3>
    <p class="text-sm text-gray-500 mb-6 font-medium">Isi form di bawah, kurir kami langsung meluncur.</p>
    
    <form method="POST" action="{{ route('pesanan.store') }}" class="space-y-5">
        @csrf 
        <div><label class="text-xs font-bold text-gray-500 uppercase">1. Pilih Layanan</label><select name="jenis_layanan" required class="mt-1 w-full border-2 border-gray-200 p-3 rounded-xl bg-gray-50 focus:border-shoeBlue focus:bg-white outline-none"><option value="Cuci Reguler">Cuci Reguler - Rp 35.000</option><option value="Cuci Express">Cuci Express - Rp 50.000 (1 Hari)</option><option value="Premium Treatment">Premium Treatment - Rp 80.000</option></select></div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="text-xs font-bold text-gray-500 uppercase">2. No. WhatsApp</label><input type="number" name="no_hp" required placeholder="0812..." class="mt-1 w-full border-2 border-gray-200 p-3 rounded-xl bg-gray-50 focus:border-shoeBlue focus:bg-white outline-none"></div>
            <div><label class="text-xs font-bold text-gray-500 uppercase">3. Pembayaran</label><select name="metode_pembayaran" required class="mt-1 w-full border-2 border-gray-200 p-3 rounded-xl bg-gray-50 focus:border-shoeBlue focus:bg-white outline-none"><option value="COD (Cash)">Bayar Tunai / COD</option><option value="QRIS / Transfer">QRIS / E-Wallet</option></select></div>
        </div>
        <div><label class="text-xs font-bold text-gray-500 uppercase">4. Alamat Penjemputan</label><textarea name="alamat_jemput" required rows="3" class="mt-1 w-full border-2 border-gray-200 p-3 rounded-xl bg-gray-50 focus:border-shoeBlue focus:bg-white outline-none" placeholder="Cth: Kost Biru, Jl. Pancing"></textarea></div>
        <div><label class="text-xs font-bold text-gray-500 uppercase">5. Catatan Kurir (Opsional)</label><input type="text" name="catatan" placeholder="Cth: Pager dikunci, ketuk aja" class="mt-1 w-full border-2 border-gray-200 p-3 rounded-xl bg-gray-50 focus:border-shoeBlue focus:bg-white outline-none"></div>
        <button type="submit" class="w-full bg-mahogany text-white py-4 rounded-xl font-extrabold text-lg shadow-lg hover:shadow-xl hover:-translate-y-1 transition transform mt-4 flex items-center justify-center gap-2">
            <i class="fa-solid fa-paper-plane"></i> Order Sekarang
        </button>
    </form>
</div>
@endsection