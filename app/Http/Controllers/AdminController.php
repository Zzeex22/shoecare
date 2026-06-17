<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminController extends Controller
{
    // Menampilkan dashboard admin dengan semua data pesanan
    public function index()
    {
        // Tarik data order sekaligus tarik data user yang mesan (relasi)
        $orders = Order::with('user')->orderBy('id', 'desc')->get();
        return view('dashboard_admin', compact('orders'));
    }

    // Memproses perubahan status pesanan
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}