<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Gembok dilepas, semua data dari form otomatis diizinkan masuk
    protected $guarded = [];

    // Relasi: Setiap Order ini milik 1 User (Pelanggan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}