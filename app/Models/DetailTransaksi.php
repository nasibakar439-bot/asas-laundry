<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksis';
    protected $guarded = ['id'];

    // Relasi balik ke model LaundryItem
    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }

    // Relasi balik ke model Transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }
}
