@extends('master')
@section('title', 'Checkout Produk')
@section('page_title', 'Checkout Pembelian')

@section('content')
<div class="max-w-4xl mx-auto">
    <a href="{{ route('toko.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-shoeBlue font-bold mb-6 transition"><i class="fa-solid fa-arrow-left"></i> Kembali ke Toko</a>

    <div class="grid md:grid-cols-2 gap-8">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden h-fit">
            @if($produk->gambar)
                <img src="{{ asset('storage/' . $produk->gambar) }}" class="w-full h-64 object-cover border-b border-gray-100">
            @else
                <div class="h-64 bg-gray-100 flex items-center justify-center text-7xl text-gray-300"><i class="fa-solid fa-image"></i></div>
            @endif
            <div class="p-6 bg-gray-50">
                <h3 class="font-extrabold text-2xl text-gray-800 mb-2">{{ $produk->nama_produk }}</h3>
                <p class="text-sm text-gray-600 mb-6">{{ $produk->deskripsi }}</p>
                <div class="flex justify-between items-center border-t border-gray-200 pt-4">
                    <span class="text-gray-500 font-bold text-sm uppercase">Harga Barang</span>
                    <span class="font-extrabold text-3xl text-mahogany">Rp {{ number_format($produk->harga,0,',','.') }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <h3 class="font-extrabold text-xl mb-6 text-shoeBlue"><i class="fa-solid fa-truck-fast mr-2"></i>Detail Pengiriman</h3>
            
            <form method="POST" action="{{ route('toko.proses_checkout', $produk->id) }}" class="space-y-5">
                @csrf 
                <div><label class="text-xs font-bold text-gray-500 uppercase">1. No. WhatsApp Aktif</label><input type="number" name="no_hp" required placeholder="0812..." class="mt-1 w-full border-2 border-gray-200 p-3 rounded-xl bg-gray-50 focus:border-shoeBlue focus:bg-white outline-none transition"></div>
                <div><label class="text-xs font-bold text-gray-500 uppercase">2. Metode Pembayaran</label><select name="metode_pembayaran" required class="mt-1 w-full border-2 border-gray-200 p-3 rounded-xl bg-gray-50 focus:border-shoeBlue focus:bg-white outline-none transition"><option value="COD (Bayar di Tempat)">Bayar Tunai / COD</option><option value="QRIS / Transfer Bank">QRIS / Transfer Bank</option></select></div>
                <div><label class="text-xs font-bold text-gray-500 uppercase">3. Alamat Lengkap Pengiriman</label><textarea name="alamat_kirim" required rows="3" class="mt-1 w-full border-2 border-gray-200 p-3 rounded-xl bg-gray-50 focus:border-shoeBlue focus:bg-white outline-none transition" placeholder="Cth: Kost Biru, Kamar 4, Jl. Pancing..."></textarea></div>
                <div><label class="text-xs font-bold text-gray-500 uppercase">4. Pesan Tambahan (Opsional)</label><input type="text" name="catatan" placeholder="Cth: Titip di satpam ya bang" class="mt-1 w-full border-2 border-gray-200 p-3 rounded-xl bg-gray-50 focus:border-shoeBlue focus:bg-white outline-none transition"></div>
                
                @if(Auth::user()->poin > 0)
                <div class="bg-amber-50 border border-amber-300 p-4 rounded-xl flex items-center gap-3">
                    <input type="checkbox" name="gunakan_poin" id="gunakan_poin" class="w-5 h-5 accent-amber-500 cursor-pointer">
                    <label for="gunakan_poin" class="text-sm font-bold text-amber-800 cursor-pointer select-none">
                        <i class="fa-solid fa-gift mr-1 text-amber-600"></i> Tukar {{ number_format(Auth::user()->poin, 0, ',', '.') }} Poin untuk diskon langsung!
                    </label>
                </div>
                @endif
                
                <button type="submit" class="w-full bg-freshGreen text-white py-4 rounded-xl font-extrabold text-lg shadow-lg hover:shadow-xl hover:bg-green-600 hover:-translate-y-1 transition transform mt-4 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-check-circle"></i> Proses Order
                </button>
            </form>
        </div>
    </div>
</div>
@endsection