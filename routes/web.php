<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () { return view('welcome'); });

Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->role === 'admin' || $user->role === 'kurir') {
            $total_order = Order::count();
            $order_aktif = Order::whereNotIn('status', ['Selesai', 'Dibatalkan Admin'])->count();
        } else {
            $total_order = Order::where('user_id', $user->id)->count();
            $order_aktif = Order::where('user_id', $user->id)->whereNotIn('status', ['Selesai', 'Dibatalkan Admin'])->count();
        }
        return view('dashboard', compact('total_order', 'order_aktif'));
    })->name('dashboard');

    // ==========================================
    // RUTE PELANGGAN (JASA CUCI)
    // ==========================================
    Route::get('/pesan', function () {
        if (auth()->user()->role !== 'pelanggan') return redirect('/dashboard');
        return view('pesan');
    })->name('pesanan.create');

    Route::post('/pesan', function(Request $request) {
        $harga = ($request->jenis_layanan == 'Cuci Reguler') ? 35000 : (($request->jenis_layanan == 'Cuci Express') ? 50000 : 80000);
        $user = auth()->user();

        if ($request->has('gunakan_poin') && $user->poin > 0) {
            if ($user->poin >= $harga) { $user->decrement('poin', $harga); $harga = 0; } 
            else { $harga -= $user->poin; $user->update(['poin' => 0]); }
        }

        Order::create([
            'user_id' => $user->id, 'kode_order' => 'SC-' . strtoupper(substr(uniqid(), -5)),
            'jenis_layanan' => $request->jenis_layanan, 'no_hp_pelanggan' => $request->no_hp,
            'alamat_jemput' => $request->alamat_jemput, 'catatan_kurir' => $request->catatan,
            'metode_pembayaran' => $request->metode_pembayaran, 'harga' => $harga,
            'status' => 'Menunggu Konfirmasi'
        ]);
        return redirect()->route('pesanan.pantau')->with('success', 'Pesanan sukses dibuat!');
    })->name('pesanan.store');

    Route::get('/pantau', function () {
        if (auth()->user()->role !== 'pelanggan') return redirect('/dashboard');
        $orders = Order::where('user_id', auth()->id())->whereNotIn('status', ['Selesai', 'Dibatalkan Admin'])->orderBy('id', 'desc')->get();
        return view('pantau', compact('orders'));
    })->name('pesanan.pantau');

    Route::get('/riwayat', function () {
        if (auth()->user()->role !== 'pelanggan') return redirect('/dashboard');
        $orders = Order::where('user_id', auth()->id())->whereIn('status', ['Selesai', 'Dibatalkan Admin'])->orderBy('id', 'desc')->get();
        return view('riwayat', compact('orders'));
    })->name('pesanan.riwayat');

    Route::post('/order/{id}/selesaikan', function(Request $request, $id) {
        if (auth()->user()->role !== 'pelanggan') return redirect('/dashboard');
        $order = Order::findOrFail($id);
        $order->update([ 'status' => 'Selesai', 'rating_kurir' => $request->rating, 'ulasan_kurir' => $request->ulasan ]);
        $bonus = round($order->harga * 0.1); 
        if ($bonus > 0) { auth()->user()->increment('poin', $bonus); }
        return redirect()->route('pesanan.riwayat')->with('success', 'Pesanan Selesai! Kamu dapet bonus poin loyalty.');
    })->name('pesanan.selesaikan');

    // ==========================================
    // RUTE PELANGGAN (TOKO PRODUK)
    // ==========================================
    Route::get('/toko', function () {
        if (auth()->user()->role !== 'pelanggan') return redirect('/dashboard');
        $produk = Product::where('stok', '>', 0)->orderBy('id', 'desc')->get();
        return view('toko', compact('produk'));
    })->name('toko.index');

    Route::get('/toko/checkout/{id}', function ($id) {
        if (auth()->user()->role !== 'pelanggan') return redirect('/dashboard');
        $produk = Product::findOrFail($id);
        if ($produk->stok <= 0) return redirect()->route('toko.index')->with('error', 'Stok habis!');
        return view('checkout_produk', compact('produk'));
    })->name('toko.checkout');

    Route::post('/toko/checkout/{id}', function (Request $request, $id) {
        $produk = Product::findOrFail($id);
        if ($produk->stok > 0) {
            $produk->decrement('stok'); 
            $user = auth()->user(); $harga = $produk->harga;

            if ($request->has('gunakan_poin') && $user->poin > 0) {
                if ($user->poin >= $harga) { $user->decrement('poin', $harga); $harga = 0; } 
                else { $harga -= $user->poin; $user->update(['poin' => 0]); }
            }
            
            Order::create([
                'user_id' => $user->id, 'kode_order' => 'PRD-' . strtoupper(substr(uniqid(), -5)),
                'jenis_layanan' => 'Beli Produk: ' . $produk->nama_produk,
                'no_hp_pelanggan' => $request->no_hp, 'alamat_jemput' => $request->alamat_kirim, 
                'catatan_kurir' => $request->catatan, 'metode_pembayaran' => $request->metode_pembayaran,
                'harga' => $harga, 'status' => 'Menunggu Konfirmasi'
            ]);
            return redirect()->route('pesanan.pantau')->with('success', 'Checkout sukses!');
        }
        return back()->with('error', 'Stok habis lek!');
    })->name('toko.proses_checkout');

    Route::get('/poinku', function () {
        if (auth()->user()->role !== 'pelanggan') return redirect('/dashboard');
        return view('poinku');
    })->name('poin.index');

    // ==========================================
    // RUTE ORDER ADMIN & KURIR
    // ==========================================
    Route::get('/kelola-pesanan', function () {
        $user = auth()->user();
        if ($user->role === 'pelanggan') return redirect('/dashboard');
        
        if ($user->role === 'admin') {
            $orders = Order::with('user')->orderBy('id', 'desc')->get();
        } else {
            $orders = Order::with('user')->where('status', '!=', 'Menunggu Konfirmasi')
                ->where(function($query) use ($user) { $query->whereNull('kurir_id')->orWhere('kurir_id', $user->id); })
                ->orderBy('id', 'desc')->get();
        }
        return view('admin_pesanan', compact('orders'));
    })->name('admin.pesanan');

    Route::post('/order/{id}/status', function(Request $request, $id) {
        if (auth()->user()->role === 'pelanggan') return redirect('/dashboard');
        $order = Order::findOrFail($id);
        $isProduct = str_starts_with($order->kode_order, 'PRD');
        $data_update = [];

        if ($request->status === 'Menunggu Pickup' && auth()->user()->role === 'admin') { $data_update['status'] = 'Menunggu Pickup'; }
        if ($request->status === 'Ambil_Tugas' && auth()->user()->role === 'kurir') { $data_update['kurir_id'] = auth()->id(); }

        if (auth()->user()->role === 'kurir' && $order->kurir_id == auth()->id()) {
            if (!$isProduct && $request->status === 'Sedang Dicuci') { $data_update['status'] = 'Sedang Dicuci'; } 
            elseif ($isProduct && $request->status === 'Sedang Diantar') { 
                $data_update['status'] = 'Sedang Diantar'; $data_update['fee_kurir'] = rand(6, 12) * 1000; 
            }
        }

        if (!$isProduct && $request->status === 'Sedang Diantar' && auth()->user()->role === 'admin') {
            $data_update['status'] = 'Sedang Diantar'; $data_update['fee_kurir'] = rand(6, 12) * 1000;
        }

        if (auth()->user()->role === 'kurir' && $order->kurir_id == auth()->id() && $request->status === 'Tiba di Tujuan') {
            $data_update['status'] = 'Tiba di Tujuan';
        }

        if (!empty($data_update)) {
            $order->update($data_update);
            return back()->with('success', 'Status pesanan diperbarui lek!');
        }
        return back()->with('error', 'Aksi diblokir!');
    })->name('admin.order.update');

    Route::get('/kinerja-kurir', function () {
        if (auth()->user()->role !== 'kurir') return redirect('/dashboard');
        $orders = Order::where('kurir_id', auth()->id())->where('status', 'Selesai')->get();
        $total_fee = $orders->sum('fee_kurir');
        $total_antar = $orders->count();
        $avg_rating = $total_antar > 0 ? round($orders->avg('rating_kurir'), 1) : 0;
        return view('kurir_laporan', compact('orders', 'total_fee', 'total_antar', 'avg_rating'));
    })->name('kurir.laporan');

    // ==========================================
    // RUTE KHUSUS ADMIN (CRUD PRODUK LENGKAP)
    // ==========================================
    Route::get('/kelola-produk', function () {
        if (auth()->user()->role !== 'admin') return redirect('/dashboard'); 
        $produk = Product::orderBy('id', 'desc')->get();
        return view('admin_produk', compact('produk'));
    })->name('admin.produk');

    // CREATE PRODUK
    Route::post('/kelola-produk', function (Request $request) {
        if (auth()->user()->role !== 'admin') return redirect('/dashboard');
        $path = null;
        if ($request->hasFile('gambar')) { $path = $request->file('gambar')->store('produk', 'public'); }
        Product::create([
            'nama_produk' => $request->nama_produk, 'deskripsi' => $request->deskripsi,
            'harga' => $request->harga, 'stok' => $request->stok, 'gambar' => $path,
        ]);
        return back()->with('success', 'Produk berhasil ditambahkan!');
    })->name('admin.produk.store');

    // UPDATE PRODUK
    Route::put('/kelola-produk/{id}', function (Request $request, $id) {
        if (auth()->user()->role !== 'admin') return redirect('/dashboard');
        $produk = Product::findOrFail($id);
        
        $data = [
            'nama_produk' => $request->nama_produk, 'deskripsi' => $request->deskripsi,
            'harga' => $request->harga, 'stok' => $request->stok,
        ];

        // Jika upload gambar baru, ganti yang lama
        if ($request->hasFile('gambar')) { 
            if ($produk->gambar) Storage::disk('public')->delete($produk->gambar);
            $data['gambar'] = $request->file('gambar')->store('produk', 'public'); 
        }

        $produk->update($data);
        return back()->with('success', 'Data produk berhasil diperbarui!');
    })->name('admin.produk.update');

    // DELETE PRODUK
    Route::delete('/kelola-produk/{id}', function ($id) {
        if (auth()->user()->role !== 'admin') return redirect('/dashboard');
        $produk = Product::findOrFail($id);
        if ($produk->gambar) Storage::disk('public')->delete($produk->gambar);
        $produk->delete();
        return back()->with('success', 'Produk berhasil dihapus!');
    })->name('admin.produk.destroy');

    Route::get('/kelola-laporan', function () {
        if (auth()->user()->role !== 'admin') return redirect('/dashboard'); 
        $bulan_ini = date('m'); $tahun_ini = date('Y');
        $omset_bulan_ini = Order::where('status', 'Selesai')->whereMonth('created_at', $bulan_ini)->whereYear('created_at', $tahun_ini)->sum('harga');
        $order_bulan_ini = Order::where('status', 'Selesai')->whereMonth('created_at', $bulan_ini)->whereYear('created_at', $tahun_ini)->count();
        $laporan_bulanan = Order::where('status', 'Selesai')->selectRaw('YEAR(created_at) as tahun, MONTH(created_at) as bulan, COUNT(id) as total_order, SUM(harga) as total_pendapatan')->groupBy('tahun', 'bulan')->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();
        return view('admin_laporan', compact('omset_bulan_ini', 'order_bulan_ini', 'laporan_bulanan'));
    })->name('admin.laporan');

    Route::get('/invoice/{id}', function($id) {
        $order = Order::with('user')->findOrFail($id);
        return view('invoice', compact('order'));
    })->name('invoice.cetak');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';   