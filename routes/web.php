<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

// ==========================================
// HALAMAN LANDING PAGE (DEPAN)
// ==========================================
Route::get('/', function () { 
    return view('welcome'); 
});

// ==========================================
// GRUP RUTE YANG WAJIB LOGIN
// ==========================================
Route::middleware('auth')->group(function () {
    
    // 1. DASHBOARD UTAMA
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
        Order::create([
            'user_id' => auth()->id(),
            'kode_order' => 'SC-' . strtoupper(substr(uniqid(), -5)),
            'jenis_layanan' => $request->jenis_layanan,
            'no_hp_pelanggan' => $request->no_hp,
            'alamat_jemput' => $request->alamat_jemput,
            'catatan_kurir' => $request->catatan,
            'metode_pembayaran' => $request->metode_pembayaran,
            'harga' => $harga,
            'status' => 'Menunggu Konfirmasi'
        ]);
        return redirect()->route('pesanan.pantau')->with('success', 'Pesanan berhasil dibuat! Kurir segera meluncur.');
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

    // ==========================================
    // RUTE PELANGGAN (TOKO & CHECKOUT)
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
            
            Order::create([
                'user_id' => auth()->id(),
                'kode_order' => 'PRD-' . strtoupper(substr(uniqid(), -5)),
                'jenis_layanan' => 'Beli Produk: ' . $produk->nama_produk,
                'no_hp_pelanggan' => $request->no_hp,
                'alamat_jemput' => $request->alamat_kirim, 
                'catatan_kurir' => $request->catatan,
                'metode_pembayaran' => $request->metode_pembayaran,
                'harga' => $produk->harga,
                'status' => 'Menunggu Konfirmasi'
            ]);

            return redirect()->route('pesanan.pantau')->with('success', 'Berhasil membeli ' . $produk->nama_produk . '! Pesanan produkmu segera dikirim.');
        }
        return back()->with('error', 'Waduh, stok keburu habis lek!');
    })->name('toko.proses_checkout');

    // ==========================================
    // RUTE ADMIN / KURIR (KELOLA)
    // ==========================================
    Route::get('/kelola-pesanan', function () {
        if (auth()->user()->role === 'pelanggan') return redirect('/dashboard');
        $orders = Order::with('user')->orderBy('id', 'desc')->get();
        return view('admin_pesanan', compact('orders'));
    })->name('admin.pesanan');

    Route::post('/order/{id}/status', function(Request $request, $id) {
        Order::findOrFail($id)->update(['status' => $request->status]);
        return back()->with('success', 'Status pesanan berhasil diupdate!');
    })->name('admin.order.update');

    Route::get('/kelola-produk', function () {
        if (auth()->user()->role === 'pelanggan') return redirect('/dashboard');
        $produk = Product::orderBy('id', 'desc')->get();
        return view('admin_produk', compact('produk'));
    })->name('admin.produk');

    Route::post('/kelola-produk', function (Request $request) {
        $path = null;
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('produk', 'public');
        }

        Product::create([
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'gambar' => $path,
        ]);
        return back()->with('success', 'Produk berhasil ditambahkan beserta fotonya!');
    })->name('admin.produk.store');

    // ==========================================
    // RUTE UMUM (INVOICE & PROFILE)
    // ==========================================
    Route::get('/invoice/{id}', function($id) {
        $order = Order::with('user')->findOrFail($id);
        return view('invoice', compact('order'));
    })->name('invoice.cetak');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';