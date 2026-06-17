<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class PelangganController extends Controller
{
    // Menampilkan halaman dashboard pelanggan beserta riwayat pesanannya
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->orderBy('id', 'desc')->get();
        return view('dashboard_pelanggan', compact('orders'));
    }

    // Memproses data pesanan baru yang dikirim dari form
    public function store(Request $request)
    {
        $request->validate([
            'jenis_layanan' => 'required',
            'alamat_jemput' => 'required',
            'metode_pembayaran' => 'required',
        ]);

        // Kalkulasi harga otomatis sesuai jenis layanan
        $harga = 0;
        if($request->jenis_layanan == 'Cuci Reguler') $harga = 35000;
        elseif($request->jenis_layanan == 'Cuci Express') $harga = 50000;
        elseif($request->jenis_layanan == 'Premium Treatment') $harga = 80000;

        // Generate Kode Order Unik (Contoh: SC-A1B2C)
        $kode = 'SC-' . strtoupper(substr(uniqid(), -5));

        // Simpan ke database
        Order::create([
            'user_id' => Auth::id(),
            'kode_order' => $kode,
            'jenis_layanan' => $request->jenis_layanan,
            'alamat_jemput' => $request->alamat_jemput,
            'metode_pembayaran' => $request->metode_pembayaran,
            'harga' => $harga,
            'status' => 'Menunggu Konfirmasi'
        ]);

        return back()->with('success', 'Pesanan berhasil dibuat! Kurir akan segera meluncur.');
    }
}