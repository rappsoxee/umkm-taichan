<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_produk' => 'required',
            'nama_produk' => 'required',
            'harga'       => 'required|numeric',
            'stok'        => 'required|numeric',
            'kategori'    => 'required',
            'deskripsi'   => 'nullable|string|max:500',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('products', 'public');
        }

        Product::create([
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'kategori'    => $request->kategori,
            'deskripsi'   => $request->deskripsi,
            'gambar'      => $gambarPath,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // Return JSON untuk modal edit
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        if (request()->wantsJson()) {
            return response()->json([
                'id'          => $product->id,
                'kode_produk' => $product->kode_produk,
                'nama_produk' => $product->nama_produk,
                'harga'       => $product->harga,
                'stok'        => $product->stok,
                'kategori'    => $product->kategori,
                'deskripsi'   => $product->deskripsi,
                'gambar'      => $product->gambar ? asset('storage/' . $product->gambar) : null,
            ]);
        }

        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_produk'  => 'required',
            'nama_produk'  => 'required',
            'harga'        => 'required|numeric',
            'stok'         => 'required|numeric',
            'kategori'     => 'required',
            'deskripsi'    => 'nullable|string|max:500',
            'gambar'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'hapus_gambar' => 'nullable|boolean',
        ]);

        $product    = Product::findOrFail($id);
        $gambarPath = $product->gambar;

        // Hapus foto kalau dicentang
        if ($request->hapus_gambar) {
            if ($product->gambar) Storage::disk('public')->delete($product->gambar);
            $gambarPath = null;
        }

        // Ganti foto kalau ada upload baru
        if ($request->hasFile('gambar')) {
            if ($product->gambar) Storage::disk('public')->delete($product->gambar);
            $gambarPath = $request->file('gambar')->store('products', 'public');
        }

        $product->update([
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'kategori'    => $request->kategori,
            'deskripsi'   => $request->deskripsi,
            'gambar'      => $gambarPath,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function updateStok(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
            'aksi'   => 'required|in:tambah,kurang',
        ]);

        $product = Product::findOrFail($id);
        if ($request->aksi === 'tambah') {
            $product->increment('stok', $request->jumlah);
        } else {
            if ($product->stok < $request->jumlah) {
                return back()->with('error', 'Stok tidak cukup untuk dikurangi!');
            }
            $product->decrement('stok', $request->jumlah);
        }

        return back()->with('success', "Stok {$product->nama_produk} berhasil diperbarui!");
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->gambar) Storage::disk('public')->delete($product->gambar);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
}