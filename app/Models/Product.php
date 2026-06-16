<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_produk',
        'gambar',
        'nama_produk',
        'harga',
        'stok',
        'kategori',
        'deskripsi',
    ];
}