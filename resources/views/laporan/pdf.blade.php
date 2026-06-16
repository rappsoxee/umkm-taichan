<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; background: #fff; }
        .header { background: #7c2d12; color: #fff; padding: 20px 24px; margin-bottom: 20px; }
        .header h1 { font-size: 20px; font-weight: bold; margin-bottom: 4px; }
        .header p { font-size: 11px; opacity: 0.75; }
        .summary { display: flex; gap: 16px; margin: 0 24px 20px; }
        .summary-card { flex: 1; background: #f9f9f9; border-radius: 8px; padding: 12px 16px; border-left: 3px solid #c2780a; }
        .summary-card .label { font-size: 10px; color: #888; text-transform: uppercase; margin-bottom: 4px; }
        .summary-card .value { font-size: 16px; font-weight: bold; color: #1a1a1a; }
        table { width: calc(100% - 48px); margin: 0 24px; border-collapse: collapse; }
        thead tr { background: #1a0f0a; color: #fff; }
        thead th { padding: 9px 12px; text-align: left; font-size: 10px; text-transform: uppercase; letter-spacing: 0.05em; }
        tbody tr:nth-child(even) { background: #f9f6f4; }
        tbody td { padding: 8px 12px; font-size: 11px; border-bottom: 1px solid #eee; }
        .footer { margin: 20px 24px 0; font-size: 10px; color: #aaa; text-align: right; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 10px; font-weight: bold; }
        .badge-selesai { background: #dcfce7; color: #166534; }
        .badge-diproses { background: #dbeafe; color: #1e40af; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Penjualan</h1>
        <p>Sate Taichan & Es Teh Solo &mdash; Periode {{ \Carbon\Carbon::parse($dari)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($sampai)->format('d M Y') }}</p>
    </div>

    <div class="summary">
        <div class="summary-card">
            <div class="label">Total Pendapatan</div>
            <div class="value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
        </div>
        <div class="summary-card">
            <div class="label">Total Transaksi</div>
            <div class="value">{{ $orders->count() }}</div>
        </div>
        <div class="summary-card">
            <div class="label">Rata-rata per Order</div>
            <div class="value">Rp {{ $orders->count() > 0 ? number_format($totalPendapatan / $orders->count(), 0, ',', '.') : 0 }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>Meja</th>
                <th>Item</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $i => $order)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $order->nama_pemesan }}</td>
                <td>Meja {{ $order->no_meja }}</td>
                <td>{{ $order->items->map(fn($i) => $i->product->nama_produk . ' x' . $i->qty)->join(', ') }}</td>
                <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                <td><span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; padding:20px; color:#aaa;">Tidak ada transaksi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada {{ now()->format('d M Y H:i') }}
    </div>
</body>
</html>