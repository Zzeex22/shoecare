<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Kolom apa aja yang boleh diisi langsung (Mass Assignment)
    protected $fillable = [
        'user_id',
        'kode_order',
        'jenis_layanan',
        'alamat_jemput',
        'metode_pembayaran',
        'harga',
        'status',
    ];

    // Relasi: Setiap Order ini milik 1 User (Pelanggan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}