@extends('master')
@section('title', 'Kelola Produk')
@section('page_title', 'Manajemen Etalase Produk')

@section('content')
<div class="grid md:grid-cols-3 gap-8">
    <div class="md:col-span-1 bg-white p-6 rounded-2xl shadow-sm border border-gray-200 h-fit">
        <h3 class="font-bold text-lg mb-4 text-slate-800"><i class="fa-solid fa-plus-circle text-freshGreen mr-1"></i> Tambah Produk</h3>
        <form method="POST" action="{{ route('admin.produk.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div><label class="text-xs font-bold text-gray-500 uppercase">Foto Produk</label><input type="file" name="gambar" accept="image/*" class="w-full border-2 border-gray-200 p-2 rounded-lg bg-gray-50 text-sm outline-none focus:border-freshGreen mt-1"></div>
            <div><label class="text-xs font-bold text-gray-500 uppercase">Nama Produk</label><input type="text" name="nama_produk" required class="w-full border-2 border-gray-200 p-2.5 rounded-lg bg-gray-50 text-sm outline-none focus:border-freshGreen mt-1"></div>
            <div><label class="text-xs font-bold text-gray-500 uppercase">Deskripsi Singkat</label><textarea name="deskripsi" rows="2" class="w-full border-2 border-gray-200 p-2.5 rounded-lg bg-gray-50 text-sm outline-none focus:border-freshGreen mt-1"></textarea></div>
            <div class="grid grid-cols-2 gap-3">
                <div><label class="text-xs font-bold text-gray-500 uppercase">Harga (Rp)</label><input type="number" name="harga" required class="w-full border-2 border-gray-200 p-2.5 rounded-lg bg-gray-50 text-sm outline-none focus:border-freshGreen mt-1"></div>
                <div><label class="text-xs font-bold text-gray-500 uppercase">Stok</label><input type="number" name="stok" required class="w-full border-2 border-gray-200 p-2.5 rounded-lg bg-gray-50 text-sm outline-none focus:border-freshGreen mt-1"></div>
            </div>
            <button type="submit" class="w-full bg-freshGreen text-white py-3 rounded-xl font-bold hover:bg-green-600 shadow-md transition mt-2"><i class="fa-solid fa-save mr-1"></i> Simpan Produk</button>
        </form>
    </div>

    <div class="md:col-span-2 bg-white rounded-2xl shadow-sm border overflow-hidden">
        <div class="p-5 border-b bg-gray-50"><h3 class="font-bold text-gray-800"><i class="fa-solid fa-boxes-stacked mr-1"></i> Daftar Produk & Stok</h3></div>
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-100 text-gray-600"><tr><th class="p-4 uppercase text-xs">Produk</th><th class="p-4 uppercase text-xs">Harga</th><th class="p-4 uppercase text-xs">Sisa Stok</th></tr></thead>
            <tbody class="divide-y text-gray-700">
                @forelse($produk as $row)
                <tr class="hover:bg-gray-50">
                    <td class="p-4 flex items-center gap-4">
                        @if($row->gambar)
                            <img src="{{ asset('storage/' . $row->gambar) }}" class="w-12 h-12 rounded-lg object-cover border border-gray-200">
                        @else
                            <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400"><i class="fa-solid fa-image"></i></div>
                        @endif
                        <div>
                            <p class="font-bold text-gray-800">{{ $row->nama_produk }}</p>
                            <p class="text-xs text-gray-500 truncate max-w-xs">{{ $row->deskripsi }}</p>
                        </div>
                    </td>
                    <td class="p-4 font-bold text-freshGreen">Rp {{ number_format($row->harga,0,',','.') }}</td>
                    <td class="p-4"><span class="px-3 py-1 rounded-full text-xs font-bold border {{ $row->stok > 0 ? 'bg-blue-50 border-blue-200 text-blue-700' : 'bg-red-50 border-red-200 text-red-700' }}">{{ $row->stok }} Pcs</span></td>
                </tr>
                @empty
                <tr><td colspan="3" class="p-8 text-center text-gray-400 font-medium"><i class="fa-solid fa-box-open text-2xl mb-2 block"></i> Belum ada produk.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection