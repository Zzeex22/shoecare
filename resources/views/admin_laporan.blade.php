@extends('master')
@section('title', 'Laporan Bulanan')
@section('page_title', 'Analisis & Rekapitulasi Keuangan')

@section('content')
<!-- CSS KHUSUS PRINT: Biar pas dokumen di-print/save PDF, sidebar dan tombol hilang -->
<style>
    @media print {
        aside, header, .no-print { display: none !important; }
        main { padding: 0 !important; margin: 0 !important; background: white !important; }
        .print-area { box-shadow: none !important; border: none !important; width: 100% !important; }
        body { background: white !important; }
    }
</style>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 print-area">
    <!-- KARTU TOTAL PENDAPATAN -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex justify-between items-center relative overflow-hidden">
        <div class="absolute left-0 top-0 bottom-0 w-2 bg-freshGreen"></div>
        <div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total Pendapatan (Bulan Ini)</p>
            <h3 class="text-3xl font-black text-slate-800 mb-1">Rp {{ number_format($omset_bulan_ini, 0, ',', '.') }}</h3>
            <p class="text-[10px] font-bold text-gray-500"><i class="fa-solid fa-arrow-trend-up text-freshGreen mr-1"></i> Akumulasi dari semua transaksi sukses</p>
        </div>
        <div class="bg-green-50 w-16 h-16 rounded-2xl flex items-center justify-center text-freshGreen text-3xl">
            <i class="fa-solid fa-wallet"></i>
        </div>
    </div>

    <!-- KARTU TRANSAKSI SUKSES -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex justify-between items-center relative overflow-hidden">
        <div class="absolute left-0 top-0 bottom-0 w-2 bg-shoeBlue"></div>
        <div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Transaksi Sukses (Bulan Ini)</p>
            <h3 class="text-3xl font-black text-slate-800 mb-1">{{ $order_bulan_ini }} Transaksi</h3>
            <p class="text-[10px] font-bold text-gray-500"><i class="fa-solid fa-circle-check text-shoeBlue mr-1"></i> Produk & Jasa Cuci berstatus Selesai</p>
        </div>
        <div class="bg-blue-50 w-16 h-16 rounded-2xl flex items-center justify-center text-shoeBlue text-3xl">
            <i class="fa-solid fa-boxes-packing"></i>
        </div>
    </div>
</div>

<!-- TABEL LAPORAN -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 print-area">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h3 class="font-black text-slate-800 text-lg"><i class="fa-solid fa-chart-line text-freshGreen mr-2"></i> Grafik Perkembangan Per Bulan</h3>
        
        <!-- TOMBOL CETAK GLOBAL UNTUK KESELURUHAN DATA -->
        <button onclick="window.print()" class="no-print bg-shoeBlue text-white px-4 py-2 rounded-xl text-sm font-bold shadow-md hover:bg-blue-900 transition flex items-center gap-2">
            <i class="fa-solid fa-print"></i> Cetak Seluruh Dokumen
        </button>
    </div>
    <div class="p-0 overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-400 font-extrabold tracking-wider">
                <tr>
                    <th class="p-4 pl-6">Periode Bulan</th>
                    <th class="p-4">Volume Transaksi</th>
                    <th class="p-4">Total Omset Pendapatan</th>
                    <th class="p-4 pr-6 text-right">Status Laporan</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $nama_bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']; 
                @endphp
                @forelse($laporan_bulanan as $row)
                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                    <td class="p-4 pl-6 font-bold text-slate-700">
                        <i class="fa-regular fa-calendar text-gray-400 mr-2"></i> {{ $nama_bulan[$row->bulan] }} {{ $row->tahun }}
                    </td>
                    <td class="p-4 font-bold text-gray-600">
                        <i class="fa-solid fa-receipt text-gray-400 mr-2"></i> {{ $row->total_order }} Order Selesai
                    </td>
                    <td class="p-4 font-black text-freshGreen text-base">
                        Rp {{ number_format($row->total_pendapatan, 0, ',', '.') }}
                    </td>
                    <td class="p-4 pr-6 flex justify-end gap-2 items-center">
                        <!-- BADGE LAMA (GEMBOK TETAP ADA SEBAGAI STATUS) -->
                        <span class="bg-blue-50 text-shoeBlue px-3 py-1.5 rounded-lg text-xs font-bold border border-blue-100 flex items-center gap-1">
                            <i class="fa-solid fa-lock text-[10px]"></i> Terpembukuan
                        </span>
                        
                        <!-- TOMBOL BARU: BUKA & CETAK PDF BIAR AKTIF -->
                        <button onclick="window.print()" class="no-print bg-gray-100 text-gray-600 px-3 py-1.5 rounded-lg text-xs font-bold border border-gray-200 hover:bg-slate-800 hover:text-white transition flex items-center gap-1 cursor-pointer">
                            <i class="fa-solid fa-file-pdf text-[10px]"></i> Cetak
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-10 text-center text-gray-400 font-bold">
                        <i class="fa-solid fa-folder-open text-5xl mb-3 text-gray-200 block"></i>
                        Belum ada data transaksi yang selesai dibukukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection