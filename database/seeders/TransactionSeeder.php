<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        // Data pelanggan
        $customers = [
            ['nama_pelanggan' => 'Rafli Pasha',   'email' => 'rafli@gmail.com',   'no_telepon' => '081234567001', 'alamat' => 'Jl. Merdeka No. 1, Solo'],
            ['nama_pelanggan' => 'Muhammad Nur Rizky',    'email' => 'rizky@gmail.com',   'no_telepon' => '081234567002', 'alamat' => 'Jl. Sudirman No. 5, Solo'],
            ['nama_pelanggan' => 'Hilmy Yazid',    'email' => 'hilmy@gmail.com',   'no_telepon' => '081234567003', 'alamat' => 'Jl. Diponegoro No. 12, Solo'],
            ['nama_pelanggan' => 'Raya Restu',    'email' => 'raya@gmail.com',   'no_telepon' => '081234567004', 'alamat' => 'Jl. Ahmad Yani No. 8, Solo'],
            ['nama_pelanggan' => 'Rofif Ardiwan',  'email' => 'rofif@gmail.com', 'no_telepon' => '081234567005', 'alamat' => 'Jl. Gatot Subroto No. 3, Solo'],
        ];

        foreach ($customers as $c) {
            Customer::firstOrCreate(['no_telepon' => $c['no_telepon']], $c);
        }

        $customerIds = Customer::pluck('id')->toArray();

        // Data transaksi 7 hari terakhir
        $transaksiData = [
            // Hari ini
            [
                'tanggal' => Carbon::today(),
                'customer_id' => $customerIds[0],
                'status' => 'lunas',
                'items' => [
                    ['product_id' => 1, 'qty' => 5],
                    ['product_id' => 2, 'qty' => 5],
                    ['product_id' => 5, 'qty' => 3],
                ],
            ],
            [
                'tanggal' => Carbon::today(),
                'customer_id' => null,
                'status' => 'lunas',
                'items' => [
                    ['product_id' => 4, 'qty' => 3],
                    ['product_id' => 7, 'qty' => 3],
                ],
            ],
            // Kemarin
            [
                'tanggal' => Carbon::yesterday(),
                'customer_id' => $customerIds[1],
                'status' => 'lunas',
                'items' => [
                    ['product_id' => 1, 'qty' => 4],
                    ['product_id' => 8, 'qty' => 4],
                    ['product_id' => 3, 'qty' => 5],
                ],
            ],
            [
                'tanggal' => Carbon::yesterday(),
                'customer_id' => $customerIds[2],
                'status' => 'belum_lunas',
                'items' => [
                    ['product_id' => 4, 'qty' => 2],
                    ['product_id' => 2, 'qty' => 2],
                ],
            ],
            // 2 hari lalu
            [
                'tanggal' => Carbon::today()->subDays(2),
                'customer_id' => $customerIds[3],
                'status' => 'lunas',
                'items' => [
                    ['product_id' => 1, 'qty' => 6],
                    ['product_id' => 5, 'qty' => 6],
                    ['product_id' => 9, 'qty' => 4],
                ],
            ],
            // 3 hari lalu
            [
                'tanggal' => Carbon::today()->subDays(3),
                'customer_id' => null,
                'status' => 'lunas',
                'items' => [
                    ['product_id' => 1, 'qty' => 3],
                    ['product_id' => 3, 'qty' => 8],
                    ['product_id' => 7, 'qty' => 3],
                ],
            ],
            [
                'tanggal' => Carbon::today()->subDays(3),
                'customer_id' => $customerIds[4],
                'status' => 'lunas',
                'items' => [
                    ['product_id' => 4, 'qty' => 4],
                    ['product_id' => 8, 'qty' => 4],
                ],
            ],
            // 4 hari lalu
            [
                'tanggal' => Carbon::today()->subDays(4),
                'customer_id' => $customerIds[0],
                'status' => 'lunas',
                'items' => [
                    ['product_id' => 1, 'qty' => 5],
                    ['product_id' => 2, 'qty' => 5],
                    ['product_id' => 6, 'qty' => 3],
                ],
            ],
            // 5 hari lalu
            [
                'tanggal' => Carbon::today()->subDays(5),
                'customer_id' => $customerIds[1],
                'status' => 'lunas',
                'items' => [
                    ['product_id' => 1, 'qty' => 7],
                    ['product_id' => 5, 'qty' => 7],
                    ['product_id' => 10, 'qty' => 5],
                ],
            ],
            // 6 hari lalu
            [
                'tanggal' => Carbon::today()->subDays(6),
                'customer_id' => $customerIds[2],
                'status' => 'lunas',
                'items' => [
                    ['product_id' => 4, 'qty' => 3],
                    ['product_id' => 9, 'qty' => 3],
                    ['product_id' => 3, 'qty' => 6],
                ],
            ],
        ];

        foreach ($transaksiData as $data) {
            // Hitung total
            $total = 0;
            $items = [];
            foreach ($data['items'] as $item) {
                $product  = Product::find($item['product_id']);
                if (!$product) continue;
                $subtotal = $product->harga * $item['qty'];
                $total   += $subtotal;
                $items[]  = [
                    'product_id'   => $product->id,
                    'qty'          => $item['qty'],
                    'harga_satuan' => $product->harga,
                    'subtotal'     => $subtotal,
                ];
            }

            // Generate invoice unik
            $prefix  = 'INV-' . Carbon::parse($data['tanggal'])->format('Ymd') . '-';
            $last    = Transaction::where('no_invoice', 'like', $prefix . '%')->latest()->first();
            $number  = $last ? ((int) substr($last->no_invoice, -4)) + 1 : 1;
            $invoice = $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);

            $transaction = Transaction::create([
                'no_invoice'        => $invoice,
                'tanggal_transaksi' => $data['tanggal'],
                'customer_id'       => $data['customer_id'],
                'total_harga'       => $total,
                'status_pembayaran' => $data['status'],
                'catatan'           => null,
            ]);

            foreach ($items as $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $item['product_id'],
                    'qty'            => $item['qty'],
                    'harga_satuan'   => $item['harga_satuan'],
                    'subtotal'       => $item['subtotal'],
                ]);
            }
        }
    }
}