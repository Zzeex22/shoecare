@extends('master')
@section('title', 'Toko Produk')
@section('page_title', 'Toko Perlengkapan Sepatu')

@section('content')
<div class="bg-gradient-to-r from-shoeBlue to-blue-600 rounded-3xl p-8 mb-8 text-white shadow-lg flex items-center justify-between">
    <div><h2 class="text-3xl font-extrabold mb-2"><i class="fa-solid fa-wand-magic-sparkles mr-2"></i> Rawat Sepatumu Sendiri!</h2><p class="text-blue-100">Beli sikat, sabun khusus, sampai parfum original langsung dari aplikasi.</p></div>
    <div class="text-6xl hidden md:block opacity-50"><i class="fa-solid fa-cart-shopping"></i></div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse($produk as $row)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1 flex flex-col">
        @if($row->gambar)
            <img src="{{ asset('storage/' . $row->gambar) }}" class="w-full h-48 object-cover border-b border-gray-100">
        @else
            <div class="h-48 bg-gray-100 flex items-center justify-center text-5xl border-b border-gray-100 text-gray-300"><i class="fa-solid fa-bottle-droplet"></i></div>
        @endif

        <div class="p-5 flex-1 flex flex-col justify-between">
            <div>
                <h3 class="font-extrabold text-gray-800 leading-tight mb-2">{{ $row->nama_produk }}</h3>
                <p class="text-xs text-gray-500 mb-4 line-clamp-2">{{ $row->deskripsi }}</p>
            </div>
            <div>
                <div class="flex items-end justify-between mb-4">
                    <p class="font-extrabold text-lg text-mahogany">Rp {{ number_format($row->harga,0,',','.') }}</p>
                    <span class="text-[10px] font-bold bg-blue-50 text-shoeBlue px-2 py-1 rounded-md border border-blue-200">Sisa: {{ $row->stok }}</span>
                </div>
                <a href="{{ route('toko.checkout', $row->id) }}" class="w-full bg-shoeBlue text-white py-2.5 rounded-xl text-sm font-bold shadow-md hover:bg-blue-900 transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-cart-arrow-down"></i> Checkout
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full bg-white p-12 rounded-3xl shadow-sm text-center border"><i class="fa-solid fa-box-open text-5xl mb-4 block text-gray-300"></i><p class="text-gray-500 font-bold text-lg">Yah, etalase toko masih kosong nih lek.</p></div>
    @endforelse
</div>
@endsection