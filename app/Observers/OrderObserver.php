<?php

namespace App\Observers;

use App\Models\Order;

class OrderObserver
{
    public function updated(Order $order)
    {
        // Cek kalau status baru jadi 'selesai' dan punya customer
        if ($order->wasChanged('status') &&
            $order->status === 'selesai' &&
            $order->customer_id !== null)
        {
            $customer = $order->customer;
            if (!$customer) return;

            // Hitung poin: floor(total_akhir / 15000)
            $totalAkhir = max(0, $order->total_harga - $order->diskon);
            $poinDapat  = (int) floor($totalAkhir / 15000);

            if ($poinDapat > 0) {
                $customer->tambahPoin(
                    $poinDapat,
                    $order->id,
                    "Poin dari order #{$order->id} — Meja {$order->no_meja}"
                );
            }
        }
    }
}