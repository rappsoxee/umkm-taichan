<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'nama_pemesan',
        'no_meja',
        'customer_id',
        'total_harga',
        'diskon',
        'poin_digunakan',
        'status',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Total setelah diskon
    public function getTotalAkhirAttribute(): int
    {
        return max(0, $this->total_harga - $this->diskon);
    }
}