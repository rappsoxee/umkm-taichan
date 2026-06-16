<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.product')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return redirect()->route('orders.index')->with('success', 'Status pesanan diperbarui!');
    }

    // AJAX: cek order baru sejak last_order_id
    public function checkNew(Request $request)
    {
        $lastId     = (int) $request->query('last_id', 0);
        $newOrders  = Order::with('items.product')
                        ->where('id', '>', $lastId)
                        ->latest()
                        ->get();

        $pendingCount = Order::where('status', 'pending')->count();

        return response()->json([
            'new_orders'    => $newOrders->map(function ($order) {
                return [
                    'id'           => $order->id,
                    'nama_pemesan' => $order->nama_pemesan,
                    'no_meja'      => $order->no_meja,
                    'total_harga'  => $order->total_harga,
                    'status'       => $order->status,
                    'created_at'   => $order->created_at->format('d/m H:i'),
                    'items'        => $order->items->map(fn($i) => [
                        'nama' => $i->product->nama_produk,
                        'qty'  => $i->qty,
                    ]),
                ];
            }),
            'count'         => $newOrders->count(),
            'pending_count' => $pendingCount,
        ]);
    }
}