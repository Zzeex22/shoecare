@extends('master')
@section('title', 'Laporan Bulanan')
@section('page_title', 'Analisis & Rekapitulasi Keuangan')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 border-l-8 border-l-freshGreen flex items-center justify-between">
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pendapatan (Bulan Ini)</p>
            <h3 class="text-3xl font-extrabold text-slate-800 mt-1">Rp {{ number_format($omset_bulan_ini, 0, ',', '.') }}</h3>
            <p class="text-xs text-slate-500 mt-2"><i class="fa-solid fa-arrow-trend-up text-freshGreen"></i> Akumulasi dari semua transaksi sukses</p>
        </div>
        <div class="text-4xl text-freshGreen/30 bg-freshGreen/10 p-4 rounded-xl"><i class="fa-solid fa-wallet"></i></div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 border-l-8 border-l-shoeBlue flex items-center justify-between">
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Transaksi Sukses (Bulan Ini)</p>
            <h3 class="text-3xl font-extrabold text-slate-800 mt-1">{{ $order_bulan_ini }} Transaksi</h3>
            <p class="text-xs text-slate-500 mt-2"><i class="fa-solid fa-circle-check text-shoeBlue"></i> Produk & Jasa Cuci berstatus Selesai</p>
        </div>
        <div class="text-4xl text-shoeBlue/30 bg-shoeBlue/10 p-4 rounded-xl"><i class="fa-solid fa-boxes-packing"></i></div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-6 border-b border-slate-100 bg-slate-50/80 flex items-center gap-2">
        <h3 class="font-extrabold text-slate-700 text-lg"><i class="fa-solid fa-chart-line text-freshGreen mr-1"></i> Grafik Perkembangan Per Bulan</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-500 border-b border-slate-200">
                <tr>
                    <th class="p-4 uppercase text-xs font-bold">Periode Bulan</th>
                    <th class="p-4 uppercase text-xs font-bold">Volume Transaksi</th>
                    <th class="p-4 uppercase text-xs font-bold">Total Omset Pendapatan</th>
                    <th class="p-4 uppercase text-xs font-bold text-center">Status Laporan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-600">
                @php
                    // Array bantu untuk mengubah angka bulan ke nama bahasa Indonesia
                    $nama_bulan = [
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                        7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                    ];
                @endphp

                @forelse($laporan_bulanan as $row)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="p-4 font-bold text-slate-800">
                        <i class="fa-regular fa-calendar-check text-slate-400 mr-2"></i>
                        {{ $nama_bulan[$row->bulan] }} {{ $row->tahun }}
                    </td>
                    <td class="p-4 font-semibold text-slate-700">
                        <i class="fa-solid fa-receipt text-slate-400 mr-1"></i> {{ $row->total_order }} Order Selesai
                    </td>
                    <td class="p-4 font-extrabold text-freshGreen text-base">
                        Rp {{ number_format($row->total_pendapatan, 0, ',', '.') }}
                    </td>
                    <td class="p-4 text-center">
                        <span class="bg-blue-50 border border-blue-200 text-shoeBlue px-3 py-1 rounded-full text-xs font-bold">
                            <i class="fa-solid fa-lock mr-1"></i> Terpembukuan
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-12 text-center text-slate-400 font-medium">
                        <i class="fa-solid fa-chart-bar text-4xl mb-3 block opacity-40"></i>
                        Belum ada data keuangan bulanan yang tercatat lek.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection