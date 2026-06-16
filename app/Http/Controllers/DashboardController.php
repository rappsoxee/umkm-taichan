<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ===== 4 METRIK WAJIB SESUAI SOAL UAS =====
        // Total Produk
        $totalProduk = Product::count();

        // Total Pelanggan
        $totalPelanggan = Customer::count();

        // Total Penjualan (jumlah transaksi/order yang sudah diproses, bukan pending)
        $totalPenjualan = Order::where('status', '!=', 'pending')->count();

        // Total Pendapatan (keseluruhan, bukan hanya hari ini)
        $totalPendapatan = Order::where('status', '!=', 'pending')->sum('total_harga');

        // ===== METRIK TAMBAHAN (existing) =====
        // Total penjualan hari ini
        $pendapatanHariIni = Order::whereDate('created_at', today())
            ->where('status', '!=', 'pending')
            ->sum('total_harga');

        // Jumlah order hari ini
        $orderHariIni = Order::whereDate('created_at', today())->count();

        // Order pending (belum diproses)
        $orderPending = Order::where('status', 'pending')->count();

        // Produk terlaris top 5
        $produkTerlaris = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.nama_produk', DB::raw('SUM(order_items.qty) as total_terjual'))
            ->groupBy('products.id', 'products.nama_produk')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();

        // Pendapatan 7 hari terakhir
        $pendapatan7Hari = Order::where('status', '!=', 'pending')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('SUM(total_harga) as total')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Order 10 terakhir
        $orderTerbaru = Order::with('items.product')
            ->latest()
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'totalProduk',
            'totalPelanggan',
            'totalPenjualan',
            'totalPendapatan',
            'pendapatanHariIni',
            'orderHariIni',
            'orderPending',
            'produkTerlaris',
            'pendapatan7Hari',
            'orderTerbaru'
        ));
    }
}