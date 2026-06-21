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
                    @if(Auth::user()->role == 'admin')
                        <form action="{{ route('admin.order.update', $row->id) }}" method="POST">
                            @csrf <input type="hidden" name="status" value="Menunggu Pickup">
                            <button class="w-full bg-freshGreen text-white py-2.5 rounded-xl text-sm font-bold shadow-md hover:bg-green-600">
                                <i class="fa-solid fa-check-double mr-1"></i> Terima & Konfirmasi Pesanan
                            </button>
                        </form>
                    @endif
                    
                @elseif($row->status == 'Menunggu Pickup')
                    @if(is_null($row->kurir_id))
                        @if(Auth::user()->role == 'kurir')
                            <form action="{{ route('admin.order.update', $row->id) }}" method="POST">
                                @csrf <input type="hidden" name="status" value="Ambil_Tugas">
                                <button class="w-full bg-orange-500 text-white py-2.5 rounded-xl text-sm font-bold shadow-md hover:bg-orange-600">
                                    <i class="fa-solid fa-hand-holding-hand mr-1"></i> Ambil Tugas Antar-Jemput
                                </button>
                            </form>
                        @else
                            <div class="bg-gray-100 text-gray-500 py-2.5 rounded-xl text-sm font-bold text-center border border-gray-200">
                                <i class="fa-solid fa-spinner animate-spin mr-1"></i> Menunggu Diambil Kurir
                            </div>
                        @endif
                    @else
                        @if(Auth::user()->id == $row->kurir_id)
                            @if(!$isProduct)
                                <form action="{{ route('admin.order.update', $row->id) }}" method="POST">
                                    @csrf <input type="hidden" name="status" value="Sedang Dicuci">
                                    <button class="w-full bg-blue-500 text-white py-2.5 rounded-xl text-sm font-bold shadow-md hover:bg-blue-600">
                                        <i class="fa-solid fa-hotel mr-1"></i> Sepatu Tiba di Toko (Mulai Cuci)
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.order.update', $row->id) }}" method="POST">
                                    @csrf <input type="hidden" name="status" value="Sedang Diantar">
                                    <button class="w-full bg-amber-500 text-white py-2.5 rounded-xl text-sm font-bold shadow-md hover:bg-amber-600">
                                        <i class="fa-solid fa-truck-fast mr-1"></i> Kirim Produk ke User
                                    </button>
                                </form>
                            @endif
                        @else
                            <div class="bg-gray-100 text-gray-400 py-2.5 rounded-xl text-sm font-medium text-center border">
                                <i class="fa-solid fa-user-lock mr-1"></i> Diambil Kurir Lain
                            </div>
                        @endif
                    @endif
                    
                @elseif($row->status == 'Sedang Dicuci')
                    @if(Auth::user()->role == 'admin')
                        <form action="{{ route('admin.order.update', $row->id) }}" method="POST">
                            @csrf <input type="hidden" name="status" value="Sedang Diantar">
                            <button class="w-full bg-amber-500 text-white py-2.5 rounded-xl text-sm font-bold shadow-md hover:bg-amber-600">
                                <i class="fa-solid fa-truck-ramp-box mr-1"></i> Cuci Selesai, Serahkan Kurir
                            </button>
                        </form>
                    @else
                        <div class="bg-blue-50 text-blue-600 py-2.5 rounded-xl text-sm font-bold text-center border border-blue-200">
                            <i class="fa-solid fa-soap animate-spin mr-1"></i> Sepatu Sedang Dicuci Admin
                        </div>
                    @endif
                    
                <!-- LOGIKA BARU UNTUK KURIR PENCET "SUDAH SAMPAI" -->
                @elseif($row->status == 'Sedang Diantar')
                    @if(Auth::user()->role == 'kurir' && Auth::user()->id == $row->kurir_id)
                        <form action="{{ route('admin.order.update', $row->id) }}" method="POST">
                            @csrf <input type="hidden" name="status" value="Tiba di Tujuan">
                            <button class="w-full bg-freshGreen text-white py-2.5 rounded-xl text-sm font-bold shadow-md hover:bg-green-600">
                                <i class="fa-solid fa-location-dot mr-1"></i> Saya Sudah Sampai Tujuan!
                            </button>
                        </form>
                    @else
                        <div class="bg-amber-50 text-amber-600 py-2.5 rounded-xl text-sm font-bold text-center border border-amber-200">
                            <i class="fa-solid fa-motorcycle animate-pulse mr-1"></i> Sedang Diantar Kurir
                        </div>
                    @endif
                    
                @elseif($row->status == 'Tiba di Tujuan')
                    <div class="bg-blue-50 text-blue-600 py-2.5 rounded-xl text-sm font-bold text-center border border-blue-200">
                        <i class="fa-solid fa-bell animate-bounce mr-1"></i> Menunggu User Menyelesaikan Pesanan
                    </div>

                @else
                    <div class="bg-gray-100 text-gray-500 py-2.5 rounded-xl text-sm font-bold text-center border border-gray-200">
                        <i class="fa-solid fa-check-circle text-green-500 mr-1"></i> Transaksi Selesai
                    </div>
                @endif

                <div class="grid grid-cols-2 gap-2 mt-2">
                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', $row->no_hp_pelanggan) }}" target="_blank" class="bg-green-50 text-green-600 border border-green-200 py-2 rounded-xl text-xs font-bold flex items-center justify-center gap-1 hover:bg-green-100"><i class="fa-brands fa-whatsapp text-sm"></i> WA</a>
                    <a href="{{ route('invoice.cetak', $row->id) }}" target="_blank" class="bg-gray-50 text-gray-600 border border-gray-200 py-2 rounded-xl text-xs font-bold flex items-center justify-center gap-1 hover:bg-gray-100"><i class="fa-solid fa-print"></i> Struk</a>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white p-10 rounded-2xl shadow-sm text-center border border-gray-200">
            <p class="text-gray-400 font-bold text-lg"><i class="fa-solid fa-inbox text-3xl mb-2 block"></i> Belum ada orderan yang perlu diurus.</p>
        </div>
    @endforelse
</div>
@endsection