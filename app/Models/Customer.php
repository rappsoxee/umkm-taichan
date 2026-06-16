<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'nama_pelanggan',
        'email',
        'no_telepon',
        'alamat',
        'poin',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function pointLogs()
    {
        return $this->hasMany(PointLog::class);
    }

    // Tambah poin
    public function tambahPoin(int $jumlah, $orderId = null, $keterangan = null)
    {
        $this->increment('poin', $jumlah);
        PointLog::create([
            'customer_id' => $this->id,
            'order_id'    => $orderId,
            'tipe'        => 'masuk',
            'jumlah'      => $jumlah,
            'keterangan'  => $keterangan ?? "Poin dari order #{$orderId}",
        ]);
    }

    // Pakai poin
    public function pakaiPoin(int $jumlah, $orderId = null, $keterangan = null)
    {
        $this->decrement('poin', $jumlah);
        PointLog::create([
            'customer_id' => $this->id,
            'order_id'    => $orderId,
            'tipe'        => 'keluar',
            'jumlah'      => $jumlah,
            'keterangan'  => $keterangan ?? "Redeem poin untuk order #{$orderId}",
        ]);
    }

    // Hitung diskon dari poin yang mau di reedem
    public static function hitungDiskon(int $poin): int
    {
        // 10 poin = Rp 15.000
        return (int) floor($poin / 10) * 15000;
    }
}