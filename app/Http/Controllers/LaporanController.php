<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Exports\LaporanExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $dari   = $request->dari   ?? now()->startOfMonth()->format('Y-m-d');
        $sampai = $request->sampai ?? now()->format('Y-m-d');

        $orders = Order::with('items.product')
            ->whereBetween('created_at', [
                $dari . ' 00:00:00',
                $sampai . ' 23:59:59'
            ])
            ->where('status', '!=', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalPendapatan = $orders->sum('total_harga');
        $totalOrder      = $orders->count();
        $rataRata        = $totalOrder > 0 ? $totalPendapatan / $totalOrder : 0;

        // ── Produk Terlaris (untuk pie chart & list) ──────────────
        $produkTerlaris = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [
                $dari . ' 00:00:00',
                $sampai . ' 23:59:59'
            ])
            ->where('orders.status', '!=', 'pending')
            ->select('products.nama_produk', DB::raw('SUM(order_items.qty) as total_terjual'), DB::raw('SUM(order_items.subtotal) as total_pendapatan'))
            ->groupBy('products.id', 'products.nama_produk')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();

        $totalTerjualSemua = $produkTerlaris->sum('total_terjual');

        // ── Tren Pendapatan Bulanan (6 bulan terakhir) ────────────
        $trenBulanan = DB::table('orders')
            ->where('status', '!=', 'pending')
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as bulan"),
                DB::raw('SUM(total_harga) as total')
            )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->keyBy('bulan');

        $labelBulanan = [];
        $dataBulanan  = [];
        for ($i = 5; $i >= 0; $i--) {
            $key = now()->subMonths($i)->format('Y-m');
            $labelBulanan[] = now()->subMonths($i)->translatedFormat('M');
            $dataBulanan[]  = (float) ($trenBulanan[$key]->total ?? 0);
        }

        return view('laporan.index', compact(
            'orders', 'dari', 'sampai',
            'totalPendapatan', 'totalOrder', 'rataRata', 'produkTerlaris',
            'totalTerjualSemua', 'labelBulanan', 'dataBulanan'
        ));
    }

    public function exportExcel(Request $request)
    {
        $dari   = $request->dari   ?? now()->startOfMonth()->format('Y-m-d');
        $sampai = $request->sampai ?? now()->format('Y-m-d');
        $filename = 'laporan-penjualan-' . $dari . '-sd-' . $sampai . '.xlsx';
        return Excel::download(new LaporanExport($dari, $sampai), $filename);
    }

    public function exportPdf(Request $request)
    {
        $dari   = $request->dari   ?? now()->startOfMonth()->format('Y-m-d');
        $sampai = $request->sampai ?? now()->format('Y-m-d');

        $orders = Order::with('items.product')
            ->whereBetween('created_at', [
                $dari . ' 00:00:00',
                $sampai . ' 23:59:59'
            ])
            ->where('status', '!=', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalPendapatan = $orders->sum('total_harga');

        $pdf = Pdf::loadView('laporan.pdf', compact('orders', 'dari', 'sampai', 'totalPendapatan'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-penjualan-' . $dari . '-sd-' . $sampai . '.pdf');
    }
}