<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

Route::get('/', function () { return view('welcome'); });

Route::middleware('auth')->group(function () {
    
    // ==========================================
    // DASHBOARD UTAMA
    // ==========================================
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
    // RUTE PELANGGAN (JASA CUCI + LOGIKA REDEEM POIN)
    // ==========================================
    Route::get('/pesan', function () {
        if (auth()->user()->role !== 'pelanggan') return redirect('/dashboard');
        return view('pesan');
    })->name('pesanan.create');

    Route::post('/pesan', function(Request $request) {
        $harga = ($request->jenis_layanan == 'Cuci Reguler') ? 35000 : (($request->jenis_layanan == 'Cuci Express') ? 50000 : 80000);
        $user = auth()->user();

        // JURUS POTONG HARGA PAKAI POIN
        if ($request->has('gunakan_poin') && $user->poin > 0) {
            if ($user->poin >= $harga) {
                $user->decrement('poin', $harga);
                $harga = 0; 
            } else {
                $harga -= $user->poin;
                $user->update(['poin' => 0]); 
            }
        }

        Order::create([
            'user_id' => $user->id,
            'kode_order' => 'SC-' . strtoupper(substr(uniqid(), -5)),
            'jenis_layanan' => $request->jenis_layanan,
            'no_hp_pelanggan' => $request->no_hp,
            'alamat_jemput' => $request->alamat_jemput,
            'catatan_kurir' => $request->catatan,
            'metode_pembayaran' => $request->metode_pembayaran,
            'harga' => $harga,
            'status' => 'Menunggu Konfirmasi'
        ]);
        return redirect()->route('pesanan.pantau')->with('success', 'Pesanan sukses dibuat! Poin berhasil dipakai jika dicentang.');
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
    // RUTE PELANGGAN (TOKO & CHECKOUT + REDEEM POIN)
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
            $user = auth()->user();
            $harga = $produk->harga;

            // JURUS POTONG HARGA PRODUK PAKAI POIN
            if ($request->has('gunakan_poin') && $user->poin > 0) {
                if ($user->poin >= $harga) {
                    $user->decrement('poin', $harga);
                    $harga = 0;
                } else {
                    $harga -= $user->poin;
                    $user->update(['poin' => 0]);
                }
            }
            
            Order::create([
                'user_id' => $user->id,
                'kode_order' => 'PRD-' . strtoupper(substr(uniqid(), -5)),
                'jenis_layanan' => 'Beli Produk: ' . $produk->nama_produk,
                'no_hp_pelanggan' => $request->no_hp,
                'alamat_jemput' => $request->alamat_kirim, 
                'catatan_kurir' => $request->catatan,
                'metode_pembayaran' => $request->metode_pembayaran,
                'harga' => $harga,
                'status' => 'Menunggu Konfirmasi'
            ]);

            return redirect()->route('pesanan.pantau')->with('success', 'Checkout sukses! Poin berhasil digunakan.');
        }
        return back()->with('error', 'Waduh, stok keburu habis lek!');
    })->name('toko.proses_checkout');

    // ==========================================
    // RUTE HALAMAN POIN PELANGGAN
    // ==========================================
    Route::get('/poinku', function () {
        if (auth()->user()->role !== 'pelanggan') return redirect('/dashboard');
        return view('poinku');
    })->name('poin.index');

    // ==========================================
    // RUTE ADMIN / KURIR (UPDATE STATUS + BONUS POIN 10%)
    // ==========================================
    Route::get('/kelola-pesanan', function () {
        if (auth()->user()->role === 'pelanggan') return redirect('/dashboard');
        $orders = Order::with('user')->orderBy('id', 'desc')->get();
        return view('admin_pesanan', compact('orders'));
    })->name('admin.pesanan');

    Route::post('/order/{id}/status', function(Request $request, $id) {
        $order = Order::findOrFail($id);
        $status_lama = $order->status;
        $order->update(['status' => $request->status]);

        // LOGIKA GAIB: KASI BONUS POIN 10% KALO TRANSAKSI SELESAI
        if ($request->status === 'Selesai' && $status_lama !== 'Selesai') {
            $bonus = round($order->harga * 0.1); 
            if ($bonus > 0) {
                $order->user->increment('poin', $bonus);
            }
        }

        return back()->with('success', 'Status berhasil diperbarui! Poin otomatis dikirim ke pelanggan.');
    })->name('admin.order.update');

    Route::get('/kelola-produk', function () {
        if (auth()->user()->role === 'pelanggan') return redirect('/dashboard');
        $produk = Product::orderBy('id', 'desc')->get();
        return view('admin_produk', compact('produk'));
    })->name('admin.produk');

    Route::post('/kelola-produk', function (Request $request) {
        $path = null;
        if ($request->hasFile('gambar')) { $path = $request->file('gambar')->store('produk', 'public'); }
        Product::create([
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'gambar' => $path,
        ]);
        return back()->with('success', 'Produk berhasil ditambahkan beserta fotonya!');
    })->name('admin.produk.store');

    Route::get('/kelola-laporan', function () {
        if (auth()->user()->role === 'pelanggan') return redirect('/dashboard');
        $bulan_ini = date('m'); $tahun_ini = date('Y');
        $omset_bulan_ini = Order::where('status', 'Selesai')->whereMonth('created_at', $bulan_ini)->whereYear('created_at', $tahun_ini)->sum('harga');
        $order_bulan_ini = Order::where('status', 'Selesai')->whereMonth('created_at', $bulan_ini)->whereYear('created_at', $tahun_ini)->count();
        $laporan_bulanan = Order::where('status', 'Selesai')->selectRaw('YEAR(created_at) as tahun, MONTH(created_at) as bulan, COUNT(id) as total_order, SUM(harga) as total_pendapatan')->groupBy('tahun', 'bulan')->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();
        return view('admin_laporan', compact('omset_bulan_ini', 'order_bulan_ini', 'laporan_bulanan'));
    })->name('admin.laporan');

    // ==========================================
    // INVOICE & PROFILE
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