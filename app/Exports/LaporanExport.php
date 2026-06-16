<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $dari;
    protected $sampai;

    public function __construct($dari, $sampai)
    {
        $this->dari   = $dari;
        $this->sampai = $sampai;
    }

    public function collection()
    {
        return Order::with('items.product')
            ->whereBetween('created_at', [
                $this->dari . ' 00:00:00',
                $this->sampai . ' 23:59:59'
            ])
            ->where('status', '!=', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return ['No', 'Tanggal', 'Nama Pemesan', 'No Meja', 'Item', 'Total', 'Status'];
    }

    public function map($order): array
    {
        static $no = 0;
        $no++;

        $items = $order->items->map(function ($item) {
            return $item->product->nama_produk . ' x' . $item->qty;
        })->implode(', ');

        return [
            $no,
            $order->created_at->format('d/m/Y H:i'),
            $order->nama_pemesan,
            'Meja ' . $order->no_meja,
            $items,
            'Rp ' . number_format($order->total_harga, 0, ',', '.'),
            ucfirst($order->status),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'Laporan Penjualan';
    }
}