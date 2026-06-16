<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'no_invoice',
        'tanggal_transaksi',
        'customer_id',
        'metode_pembayaran',
        'total_harga',
        'status_pembayaran',
        'catatan',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public static function generateInvoice()
    {
        $prefix = 'INV-' . date('Ymd') . '-';
        $last = self::where('no_invoice', 'like', $prefix . '%')->latest()->first();
        $number = $last ? ((int) substr($last->no_invoice, -4)) + 1 : 1;
        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}