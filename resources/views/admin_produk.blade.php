@extends('master')
@section('title', 'Kelola Produk')
@section('page_title', 'Manajemen Toko & Produk')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- KOLOM KIRI: FORM TAMBAH PRODUK -->
    <div class="lg:col-span-1">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 sticky top-24">
            <h3 class="font-black text-shoeBlue text-lg mb-4 flex items-center"><i class="fa-solid fa-square-plus mr-2 text-freshGreen text-xl"></i> Tambah Produk Baru</h3>
            
            <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nama Produk</label>
                    <input type="text" name="nama_produk" required class="w-full border border-gray-300 p-2.5 rounded-xl bg-gray-50 focus:bg-white outline-none focus:border-shoeBlue focus:ring-2 focus:ring-shoeBlue/20 transition">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Deskripsi Singkat</label>
                    <textarea name="deskripsi" rows="2" class="w-full border border-gray-300 p-2.5 rounded-xl bg-gray-50 focus:bg-white outline-none focus:border-shoeBlue focus:ring-2 focus:ring-shoeBlue/20 transition"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Harga (Rp)</label>
                        <input type="number" name="harga" required class="w-full border border-gray-300 p-2.5 rounded-xl bg-gray-50 focus:bg-white outline-none focus:border-shoeBlue">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Stok Awal</label>
                        <input type="number" name="stok" required class="w-full border border-gray-300 p-2.5 rounded-xl bg-gray-50 focus:bg-white outline-none focus:border-shoeBlue">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Foto Produk</label>
                    <input type="file" name="gambar" accept="image/*" class="w-full border border-gray-300 p-2 rounded-xl bg-white text-sm">
                </div>
                <button type="submit" class="w-full bg-freshGreen text-white py-3 rounded-xl font-bold shadow-md hover:bg-green-600 transition flex justify-center items-center gap-2 mt-2">
                    <i class="fa-solid fa-upload"></i> Simpan Produk
                </button>
            </form>
        </div>
    </div>

    <!-- KOLOM KANAN: LIST PRODUK -->
    <div class="lg:col-span-2">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($produk as $row)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden group flex flex-col justify-between">
                <div>
                    <!-- Foto Produk -->
                    <div class="h-48 w-full bg-gray-100 relative overflow-hidden">
                        @if($row->gambar)
                            <img src="{{ asset('storage/' . $row->gambar) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400"><i class="fa-solid fa-box-open text-4xl"></i></div>
                        @endif
                        <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold shadow-sm border border-gray-200">
                            Stok: <span class="{{ $row->stok > 0 ? 'text-freshGreen' : 'text-red-500' }}">{{ $row->stok }}</span>
                        </div>
                    </div>
                    <!-- Detail Produk -->
                    <div class="p-5">
                        <h4 class="font-extrabold text-lg text-slate-800 line-clamp-1">{{ $row->nama_produk }}</h4>
                        <p class="text-xs text-gray-500 mt-1 line-clamp-2 h-8">{{ $row->deskripsi }}</p>
                        <p class="font-black text-shoeBlue text-xl mt-3">Rp {{ number_format($row->harga, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="px-5 pb-5 grid grid-cols-2 gap-3">
                    <button onclick="bukaModal('modal-edit-{{ $row->id }}')" class="bg-amber-100 text-amber-700 py-2 rounded-xl text-sm font-bold border border-amber-200 hover:bg-amber-500 hover:text-white transition">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </button>
                    
                    <form action="{{ route('admin.produk.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Yakin mau menghapus produk ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full bg-red-50 text-red-600 py-2 rounded-xl text-sm font-bold border border-red-200 hover:bg-red-500 hover:text-white transition">
                            <i class="fa-solid fa-trash-can"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>

            <!-- MODAL EDIT KHUSUS UNTUK PRODUK INI -->
            <div id="modal-edit-{{ $row->id }}" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden animate-[pulse_0.2s_ease-in-out]">
                    <div class="bg-amber-50 border-b border-amber-200 p-4 flex justify-between items-center">
                        <h3 class="font-black text-amber-800"><i class="fa-solid fa-pen-to-square mr-2"></i> Edit Produk</h3>
                        <button type="button" onclick="tutupModal('modal-edit-{{ $row->id }}')" class="text-amber-700 hover:text-red-500 font-bold text-xl">&times;</button>
                    </div>
                    
                    <form action="{{ route('admin.produk.update', $row->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                        @csrf @method('PUT')
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Nama Produk</label>
                            <input type="text" name="nama_produk" value="{{ $row->nama_produk }}" required class="w-full border border-gray-300 p-2.5 rounded-xl bg-gray-50 outline-none focus:border-amber-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Deskripsi Singkat</label>
                            <textarea name="deskripsi" rows="2" class="w-full border border-gray-300 p-2.5 rounded-xl bg-gray-50 outline-none focus:border-amber-500">{{ $row->deskripsi }}</textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Harga (Rp)</label>
                                <input type="number" name="harga" value="{{ $row->harga }}" required class="w-full border border-gray-300 p-2.5 rounded-xl bg-gray-50 outline-none focus:border-amber-500">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Stok Awal</label>
                                <input type="number" name="stok" value="{{ $row->stok }}" required class="w-full border border-gray-300 p-2.5 rounded-xl bg-gray-50 outline-none focus:border-amber-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Update Foto <span class="text-xs text-gray-400 font-normal">(Opsional, biarkan kosong jika tidak ganti)</span></label>
                            <input type="file" name="gambar" accept="image/*" class="w-full border border-gray-300 p-2 rounded-xl bg-white text-sm">
                        </div>
                        
                        <div class="pt-4 flex gap-3">
                            <button type="button" onclick="tutupModal('modal-edit-{{ $row->id }}')" class="w-1/3 bg-gray-100 text-gray-600 font-bold py-3 rounded-xl hover:bg-gray-200">Batal</button>
                            <button type="submit" class="w-2/3 bg-amber-500 text-white font-bold py-3 rounded-xl shadow-md hover:bg-amber-600"><i class="fa-solid fa-save mr-1"></i> Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
            @empty
            <div class="md:col-span-2 bg-gray-50 p-10 rounded-2xl border-2 border-dashed border-gray-200 text-center">
                <i class="fa-solid fa-box-open text-5xl text-gray-300 mb-3"></i>
                <h4 class="font-bold text-gray-500">Belum ada produk di etalase.</h4>
                <p class="text-sm text-gray-400">Gunakan form di sebelah kiri untuk menambah produk baru.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- SCRIPT UNTUK MODAL -->
<script>
    function bukaModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }
    function tutupModal(id) {
        document.getElementById(id).classList.add('hidden');
    }
</script>
@endsection