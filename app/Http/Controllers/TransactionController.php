<?php
namespace App\Http\Controllers;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('customer')->latest()->get();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $customers = Customer::orderBy('nama_pelanggan')->get();
        $products  = Product::where('stok', '>', 0)->orderBy('nama_produk')->get();
        return view('transactions.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id'       => 'nullable|exists:customers,id',
            'tanggal_transaksi' => 'required|date',
            'metode_pembayaran' => 'required|in:tunai,qris',
            'status_pembayaran' => 'required|in:lunas,belum_lunas',
            'catatan'           => 'nullable|string',
            'products'          => 'required|array|min:1',
            'products.*.id'     => 'required|exists:products,id',
            'products.*.qty'    => 'required|integer|min:1',
        ]);

        $total = 0;
        $items = [];
        foreach ($request->products as $item) {
            $product = Product::findOrFail($item['id']);
            if ($product->stok < $item['qty']) {
                return back()->with('error', "Stok {$product->nama_produk} tidak cukup! Sisa: {$product->stok}")->withInput();
            }
            $subtotal = $product->harga * $item['qty'];
            $total   += $subtotal;
            $items[]  = [
                'product'      => $product,
                'qty'          => $item['qty'],
                'harga_satuan' => $product->harga,
                'subtotal'     => $subtotal,
            ];
        }

        $transaction = Transaction::create([
            'no_invoice'        => Transaction::generateInvoice(),
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'customer_id'       => $request->customer_id,
            'metode_pembayaran' => $request->metode_pembayaran,
            'total_harga'       => $total,
            'status_pembayaran' => $request->status_pembayaran,
            'catatan'           => $request->catatan,
        ]);

        foreach ($items as $item) {
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'product_id'     => $item['product']->id,
                'qty'            => $item['qty'],
                'harga_satuan'   => $item['harga_satuan'],
                'subtotal'       => $item['subtotal'],
            ]);
            $item['product']->decrement('stok', $item['qty']);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan! Invoice: ' . $transaction->no_invoice);
    }

    public function show($id)
    {
        $transaction = Transaction::with('customer', 'items.product')->findOrFail($id);
        return view('transactions.show', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $request->validate([
            'status_pembayaran' => 'required|in:lunas,belum_lunas',
        ]);
        $transaction->update(['status_pembayaran' => $request->status_pembayaran]);
        return response()->json(['success' => true, 'status' => $transaction->status_pembayaran]);
    }

    public function destroy($id)
    {
        $transaction = Transaction::with('items.product')->findOrFail($id);
        foreach ($transaction->items as $item) {
            $item->product->increment('stok', $item->qty);
        }
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus!');
    }
}