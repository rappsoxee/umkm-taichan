<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointLog extends Model
{
    protected $fillable = [
        'customer_id',
        'order_id',
        'tipe',
        'jumlah',
        'keterangan',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}