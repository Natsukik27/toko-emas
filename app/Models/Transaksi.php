<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'berat',
        'harga_per_gram',
        'total_harga',
        'pelanggan'
    ];
    // Tabel yang digunakan oleh model ini
    protected $table = 'transaksis'; // Pastikan ini sesuai dengan nama tabel di database
    // Relasi dengan model Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id'); // 'produk_id' adalah foreign key di tabel 'transaksi'
    }
}
