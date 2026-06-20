@extends('master')
@section('title', 'Kelola Pesanan')
@section('page_title', 'Live Order Management')

@section('content')
<div class="grid grid-cols-1 gap-6">
    @forelse($orders as $row)
        @php $isProduct = str_starts_with($row->kode_order, 'PRD'); @endphp
        
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex flex-col md:flex-row justify-between gap-6">
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-2">
                    <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-lg text-xs font-extrabold border"><i class="fa-solid fa-hashtag"></i> {{ $row->kode_order }}</span>
                    <span class="text-xs font-bold text-gray-400"><i class="fa-regular fa-calendar mr-1"></i> {{ date('d M Y', strtotime($row->created_at)) }}</span>
                </div>
                <h3 class="font-extrabold text-xl text-slate-800">{{ $row->user->name }} <span class="text-sm font-medium text-gray-500">({{ $row->no_hp_pelanggan }})</span></h3>
                
                <div class="mt-3 grid grid-cols-2 gap-4 text-sm">
                    <div class="bg-slate-50 p-3 rounded-xl border">
                        <p class="text-xs text-gray-400 font-bold mb-1">{{ $isProduct ? 'ALAMAT PENGIRIMAN' : 'ALAMAT JEMPUT' }}</p>
                        <p class="font-semibold text-slate-700"><i class="fa-solid fa-location-dot text-red-500 mr-1"></i> {{ $row->alamat_jemput }}</p>
                        @if($row->catatan_kurir) <p class="text-xs text-orange-600 mt-2 font-medium bg-orange-50 p-1.5 rounded-md border border-orange-200"><i class="fa-solid fa-clipboard-check mr-1"></i> {{ $row->catatan_kurir }}</p> @endif
                    </div>
                    <div class="bg-slate-50 p-3 rounded-xl border">
                        <p class="text-xs text-gray-400 font-bold mb-1">DETAIL LAYANAN</p>
                        <p class="font-bold text-shoeBlue"><i class="fa-solid fa-tag mr-1"></i> {{ $row->jenis_layanan }}</p>
                        <p class="text-freshGreen font-extrabold text-lg mt-1">Rp {{ number_format($row->harga,0,',','.') }}</p>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-64 flex flex-col justify-center border-l border-slate-100 pl-6 space-y-2">
                @if($row->status == 'Menunggu Konfirmasi')
                    <form action="{{ route('admin.order.update', $row->id) }}" method="POST"><@csrf <input type="hidden" name="status" value="Menunggu Pickup"><button class="w-full bg-freshGreen text-white py-2.5 rounded-xl text-sm font-bold shadow-md hover:bg-green-600"><i class="fa-solid {{ $isProduct ? 'fa-box-open' : 'fa-motorcycle' }} mr-1"></i> {{ $isProduct ? 'Proses Pengemasan' : 'Tugaskan Kurir' }}</button></form>
                @elseif($row->status == 'Menunggu Pickup')
                    <form action="{{ route('admin.order.update', $row->id) }}" method="POST"><@csrf <input type="hidden" name="status" value="Sedang Dicuci"><button class="w-full bg-blue-500 text-white py-2.5 rounded-xl text-sm font-bold shadow-md hover:bg-blue-600"><i class="fa-solid {{ $isProduct ? 'fa-truck-fast' : 'fa-hands-bubbles' }} mr-1"></i> {{ $isProduct ? 'Kirim Produk ke User' : 'Mulai Cuci' }}</button></form>
                @elseif($row->status == 'Sedang Dicuci')
                    <form action="{{ route('admin.order.update', $row->id) }}" method="POST"><@csrf <input type="hidden" name="status" value="Selesai"><button class="w-full bg-slate-800 text-white py-2.5 rounded-xl text-sm font-bold shadow-md hover:bg-slate-900"><i class="fa-solid fa-flag-checkered mr-1"></i> Selesaikan Transaksi</button></form>
                @else
                    <div class="bg-gray-100 text-gray-500 py-2.5 rounded-xl text-sm font-bold text-center border"><i class="fa-solid fa-check-circle text-green-500 mr-1"></i> Selesai</div>
                @endif

                <div class="grid grid-cols-2 gap-2 mt-2">
                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', $row->no_hp_pelanggan) }}" target="_blank" class="bg-green-50 text-green-600 border border-green-200 py-2 rounded-xl text-xs font-bold flex items-center justify-center gap-1 hover:bg-green-100"><i class="fa-brands fa-whatsapp text-sm"></i> WA</a>
                    <a href="{{ route('invoice.cetak', $row->id) }}" target="_blank" class="bg-gray-50 text-gray-600 border border-gray-200 py-2 rounded-xl text-xs font-bold flex items-center justify-center gap-1 hover:bg-gray-100"><i class="fa-solid fa-print"></i> Struk</a>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white p-10 rounded-2xl shadow-sm text-center border"><p class="text-gray-400 font-bold text-lg"><i class="fa-solid fa-inbox text-3xl mb-2 block"></i> Belum ada orderan masuk hari ini.</p></div>
    @endforelse
</div>
@endsection