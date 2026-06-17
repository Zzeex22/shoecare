@extends('master')
@section('title', 'Riwayat Order')
@section('page_title', 'Buku Riwayat Pesanan')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-6 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
        <h3 class="font-bold text-gray-800"><i class="fa-solid fa-book text-shoeBlue mr-2"></i> Catatan Pesanan Selesai / Batal</h3>
    </div>
    <table class="w-full text-left text-sm">
        <thead class="bg-gray-100 text-gray-600">
            <tr><th class="p-4 uppercase text-xs">ID & Waktu</th><th class="p-4 uppercase text-xs">Detail Layanan</th><th class="p-4 uppercase text-xs">Status Akhir</th><th class="p-4 uppercase text-xs text-center">Aksi</th></tr>
        </thead>
        <tbody class="divide-y text-gray-700">
            @forelse($orders as $row)
            <tr class="hover:bg-gray-50">
                <td class="p-4"><span class="font-extrabold text-lg text-shoeBlue block">#{{ $row->kode_order }}</span><span class="text-xs text-gray-500 font-bold"><i class="fa-regular fa-clock"></i> {{ date('d M Y - H:i', strtotime($row->updated_at)) }}</span></td>
                <td class="p-4"><span class="font-bold text-gray-800 block">{{ $row->jenis_layanan }}</span><span class="text-freshGreen font-bold">Rp {{ number_format($row->harga,0,',','.') }}</span></td>
                <td class="p-4">
                    @if($row->status == 'Selesai')
                        <span class="bg-green-100 text-green-700 px-3 py-1.5 rounded-lg text-xs font-bold border border-green-300 flex items-center w-fit gap-1"><i class="fa-solid fa-check-circle"></i> Selesai</span>
                    @else
                        <span class="bg-red-100 text-red-700 px-3 py-1.5 rounded-lg text-xs font-bold border border-red-300 flex items-center w-fit gap-1"><i class="fa-solid fa-times-circle"></i> Dibatalkan</span>
                    @endif
                </td>
                <td class="p-4 text-center">
                    @if($row->status == 'Selesai')
                        <a href="{{ route('invoice.cetak', $row->id) }}" target="_blank" class="inline-flex items-center gap-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-xl text-xs transition border border-gray-300 shadow-sm"><i class="fa-solid fa-print"></i> Cetak Struk</a>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="p-12 text-center text-gray-400 font-medium text-base"><i class="fa-solid fa-folder-open text-4xl mb-3 block opacity-50"></i> Buku riwayat masih kosong.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection