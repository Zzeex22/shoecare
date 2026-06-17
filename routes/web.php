<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\AdminController;

// Halaman Landing Page (Halaman Depan)
Route::get('/', function () {
    return view('welcome');
});

// Grup Rute yang wajib Login (Middleware Auth)
Route::middleware('auth')->group(function () {
    
    // Rute cerdas: Kalau yang login admin/kurir, lempar ke panel admin. Kalau bukan, lempar ke panel pelanggan.
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin' || auth()->user()->role === 'kurir') {
            return app(AdminController::class)->index();
        }
        return app(PelangganController::class)->index();
    })->name('dashboard');

    // Rute untuk proses form (Aksi)
    Route::post('/pesan', [PelangganController::class, 'store'])->name('pesanan.store');
    Route::post('/order/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.order.update');

    // Rute bawaan Breeze untuk ganti password/profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';