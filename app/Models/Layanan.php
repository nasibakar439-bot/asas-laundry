<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanans';
    protected $guarded = ['id'];

    // Relasi: 1 Jenis Layanan bisa muncul di banyak detail transaksi
    public function DetailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class, 'layanan_id');
    }
}