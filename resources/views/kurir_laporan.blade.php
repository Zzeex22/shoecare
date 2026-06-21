@extends('master')
@section('title', 'Kinerja Kurir')
@section('page_title', 'Laporan Pendapatan & Rating')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 border-l-8 border-l-freshGreen">
        <p class="text-xs font-bold text-slate-400 uppercase">Total Gaji (Fee Antar)</p>
        <h3 class="text-3xl font-extrabold text-slate-800 mt-1">Rp {{ number_format($total_fee, 0, ',', '.') }}</h3>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 border-l-8 border-l-shoeBlue">
        <p class="text-xs font-bold text-slate-400 uppercase">Total Trip Selesai</p>
        <h3 class="text-3xl font-extrabold text-slate-800 mt-1">{{ $total_antar }} Pesanan</h3>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 border-l-8 border-l-amber-500">
        <p class="text-xs font-bold text-slate-400 uppercase">Rata-rata Rating</p>
        <h3 class="text-3xl font-extrabold text-amber-500 mt-1"><i class="fa-solid fa-star"></i> {{ $avg_rating }} / 5.0</h3>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-6 border-b border-slate-100 bg-slate-50/80"><h3 class="font-extrabold text-slate-700">Riwayat Trip & Ulasan Pelanggan</h3></div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-500 border-b">
                <tr><th class="p-4">TGL/ID</th><th class="p-4">PELANGGAN</th><th class="p-4">FEE KURIR</th><th class="p-4">RATING & ULASAN</th></tr>
            </thead>
            <tbody class="divide-y text-slate-600">
                @forelse($orders as $row)
                <tr class="hover:bg-slate-50 transition">
                    <td class="p-4 font-bold text-shoeBlue">#{{ $row->kode_order }}<br><span class="text-xs text-gray-400 font-normal">{{ date('d M Y', strtotime($row->updated_at)) }}</span></td>
                    <td class="p-4">{{ $row->user->name }}</td>
                    <td class="p-4 font-extrabold text-freshGreen">Rp {{ number_format($row->fee_kurir, 0, ',', '.') }}</td>
                    <td class="p-4">
                        <div class="text-amber-500 text-xs mb-1">@for($i=0; $i<$row->rating_kurir; $i++) <i class="fa-solid fa-star"></i> @endfor</div>
                        <p class="text-xs italic">"{{ $row->ulasan_kurir ?? 'Tidak ada ulasan' }}"</p>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="p-8 text-center text-gray-400">Belum ada trip yang selesai. Ngopi dulu bang! ☕</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection