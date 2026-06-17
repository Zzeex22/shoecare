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
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('kode_order')->unique();
            $table->string('jenis_layanan');
            
            // FITUR BARU: Data kontak & catatan kurir
            $table->string('no_hp_pelanggan');
            $table->text('alamat_jemput');
            $table->string('catatan_kurir')->nullable(); // Boleh kosong
            
            $table->string('metode_pembayaran');
            $table->integer('harga');
            $table->enum('status', ['Menunggu Konfirmasi', 'Menunggu Pickup', 'Sedang Dicuci', 'Selesai', 'Dibatalkan Admin'])->default('Menunggu Konfirmasi');
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