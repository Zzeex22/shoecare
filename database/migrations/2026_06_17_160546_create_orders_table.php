<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel users (Menandakan pesanan ini punya siapa)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            $table->string('kode_order')->unique();
            $table->string('jenis_layanan');
            $table->text('alamat_jemput');
            $table->string('metode_pembayaran');
            $table->integer('harga');
            
            // Status pesanan yang alurnya mirip aplikasi ojol
            $table->enum('status', [
                'Menunggu Konfirmasi', 
                'Menunggu Pickup', 
                'Sedang Dicuci', 
                'Selesai', 
                'Dibatalkan Admin'
            ])->default('Menunggu Konfirmasi');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};