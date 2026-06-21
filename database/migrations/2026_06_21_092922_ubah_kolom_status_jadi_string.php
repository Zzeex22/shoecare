<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Pakai perintah Raw SQL biar aman ngubah ENUM ke VARCHAR
        DB::statement("ALTER TABLE orders MODIFY status VARCHAR(255) DEFAULT 'Menunggu Konfirmasi'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kosongkan aja lek
    }
};