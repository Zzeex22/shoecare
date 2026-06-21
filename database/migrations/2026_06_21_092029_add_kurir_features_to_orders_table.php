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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('kurir_id')->nullable()->constrained('users')->nullOnDelete();
            $table->integer('fee_kurir')->default(0);
            $table->integer('rating_kurir')->nullable();
            $table->text('ulasan_kurir')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['kurir_id']);
            $table->dropColumn(['kurir_id', 'fee_kurir', 'rating_kurir', 'ulasan_kurir']);
        });
    }
};
