<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $noMeja = $request->query('meja');

        if ($noMeja) {
            if (session('no_meja') !== $noMeja) {
                session()->forget(['customer_id', 'customer_nama', 'customer_poin', 'no_meja']);
                return redirect("/menu/auth?meja={$noMeja}");
            }
        } else {
            return view('menu.index', [
                'products'     => collect(),
                'kategori'     => collect(),
                'noMeja'       => null,
                'customerId'   => null,
                'customerNama' => null,
                'customerPoin' => 0,
            ]);
        }

        $products = Product::where('stok', '>', 0)->get();
        $kategori = Product::where('stok', '>', 0)
                        ->distinct()
                        ->pluck('kategori')
                        ->filter()
                        ->values();

        $customerId   = session('customer_id');
        $customerNama = session('customer_nama');
        $customerPoin = session('customer_poin', 0);

        return view('menu.index', compact(
            'products', 'kategori', 'noMeja',
            'customerId', 'customerNama', 'customerPoin'
        ));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'nama_pemesan' => 'required|string|max:100',
            'no_meja'      => 'required|string|max:10',
            'items'        => 'required|array|min:1',
            'items.*.id'   => 'required|exists:products,id',
            'items.*.qty'  => 'required|integer|min:1',
            'redeem_poin'  => 'nullable|integer|min:0',
        ]);

        // ✅ FIX #7: Validasi stok semua item SEBELUM proses apapun
        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['id']);
            if ($product->stok < $item['qty']) {
                return response()->json([
                    'success' => false,
                    'message' => "Stok {$product->nama} tidak cukup. Tersisa {$product->stok}.",
                ], 422);
            }
        }

        $totalHarga = 0;
        $itemsData  = [];

        foreach ($request->items as $item) {
            $product  = Product::findOrFail($item['id']);
            $subtotal = $product->harga * $item['qty'];
            $totalHarga += $subtotal;
            $itemsData[] = [
                'product_id'   => $product->id,
                'qty'          => $item['qty'],
                'harga_satuan' => $product->harga,
                'subtotal'     => $subtotal,
            ];
            $product->decrement('stok', $item['qty']);
        }

        // Hitung diskon dari poin redeem
        $customerId    = session('customer_id');
        $redeemPoin    = (int) $request->redeem_poin;
        $diskon        = 0;
        $poinDigunakan = 0;
        $customer      = null;

        if ($customerId && $redeemPoin > 0) {
            $customer   = Customer::findOrFail($customerId);
            $redeemPoin = (int) floor($redeemPoin / 10) * 10;
            $redeemPoin = min($redeemPoin, $customer->poin);

            if ($redeemPoin > 0) {
                $diskon        = Customer::hitungDiskon($redeemPoin);
                $poinDigunakan = $redeemPoin;
                $customer->pakaiPoin($redeemPoin, null, "Redeem poin untuk order di Meja {$request->no_meja}");
                session(['customer_poin' => $customer->fresh()->poin]);
            }
        }

        $order = Order::create([
            'nama_pemesan'   => $request->nama_pemesan,
            'no_meja'        => $request->no_meja,
            'customer_id'    => $customerId,
            'total_harga'    => $totalHarga,
            'diskon'         => $diskon,
            'poin_digunakan' => $poinDigunakan,
            'status'         => 'pending',
        ]);

        if ($poinDigunakan > 0 && $customerId) {
            \App\Models\PointLog::where('customer_id', $customerId)
                ->whereNull('order_id')
                ->latest()
                ->first()
                ?->update(['order_id' => $order->id]);
        }

        foreach ($itemsData as $item) {
            $order->items()->create($item);
        }

        // ✅ FIX #6: Blok tambah poin DIHAPUS dari sini.
        // Poin sekarang HANYA dikasih oleh OrderObserver saat status → 'selesai'.
        // Ini mencegah customer dapat poin double.

        $totalAkhir = max(0, $totalHarga - $diskon);

        return response()->json([
            'success'     => true,
            'message'     => 'Pesanan berhasil dikirim!',
            'order_id'    => $order->id,
            'total_akhir' => $totalAkhir,
            'diskon'      => $diskon,
            'poin_total'  => session('customer_poin', 0),
        ]);
    }

    // ✅ FITUR BARU: Endpoint untuk tracking status order dari sisi customer
    public function orderStatus(Request $request)
    {
        $orderId = $request->query('order_id');

        if (!$orderId) {
            return response()->json(['success' => false, 'message' => 'Order ID tidak ditemukan.'], 400);
        }

        $order = Order::with('items.product')->find($orderId);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Pesanan tidak ditemukan.'], 404);
        }

        // Mapping status ke label & info yang ditampilkan ke customer
        $statusMap = [
            'pending'  => [
                'label' => 'Menunggu Konfirmasi',
                'desc'  => 'Pesanan kamu sedang menunggu dikonfirmasi kasir.',
                'icon'  => 'clock',
                'color' => 'yellow',
            ],
            'proses'   => [
                'label' => 'Sedang Diproses',
                'desc'  => 'Pesanan kamu sedang disiapkan di dapur!',
                'icon'  => 'fire',
                'color' => 'blue',
            ],
            'selesai'  => [
                'label' => 'Pesanan Siap!',
                'desc'  => 'Pesanan kamu sudah siap disajikan. Selamat makan!',
                'icon'  => 'check',
                'color' => 'green',
            ],
            'batal'    => [
                'label' => 'Pesanan Dibatalkan',
                'desc'  => 'Pesanan kamu dibatalkan. Silakan hubungi kasir.',
                'icon'  => 'x',
                'color' => 'red',
            ],
        ];

        $statusInfo = $statusMap[$order->status] ?? [
            'label' => ucfirst($order->status),
            'desc'  => '',
            'icon'  => 'info',
            'color' => 'gray',
        ];

        // Hitung poin yang didapat (hanya tampil kalau sudah selesai)
        $poinDidapat = 0;
        if ($order->status === 'selesai' && $order->customer_id) {
            $customer = Customer::find($order->customer_id);
            session(['customer_poin' => $customer?->poin ?? session('customer_poin', 0)]);
            $poinDidapat = (int) floor($order->total_harga / 15000) + 1;
        }

        return response()->json([
            'success'      => true,
            'order_id'     => $order->id,
            'status'       => $order->status,
            'status_label' => $statusInfo['label'],
            'status_desc'  => $statusInfo['desc'],
            'status_icon'  => $statusInfo['icon'],
            'status_color' => $statusInfo['color'],
            'nama_pemesan' => $order->nama_pemesan,
            'no_meja'      => $order->no_meja,
            'total_akhir'  => max(0, $order->total_harga - $order->diskon),
            'poin_didapat' => $poinDidapat,
            'poin_total'   => session('customer_poin', 0),
            'items'        => $order->items->map(fn($i) => [
                'nama'    => $i->product->nama ?? '-',
                'qty'     => $i->qty,
                'subtotal'=> $i->subtotal,
            ]),
        ]);
    }
}