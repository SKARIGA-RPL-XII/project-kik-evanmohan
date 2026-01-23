<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // List keranjang user
    public function index()
    {
        $user = Auth::user();

        $items = Keranjang::with(['product', 'variant', 'size'])
                    ->where('user_id', $user->id)
                    ->get();

        $total = $items->sum(fn($i) => $i->qty * $i->harga_satuan);

        return view('keranjang.index', compact('items', 'total'));
    }

    // Tambah produk ke keranjang
    public function add(Request $request, $productId)
    {
        $user = Auth::user();
        $product = Product::findOrFail($productId);

        $request->validate([
            'qty'        => 'nullable|integer|min:1',
            'variant_id' => 'nullable|exists:product_variants,id',
            'size_id'    => 'nullable|exists:product_variant_sizes,id',
        ]);

        $qty = $request->qty ?? 1;

        // Ambil variant jika ada
        $variant = $request->variant_id
            ? ProductVariant::find($request->variant_id)
            : null;

        // Ambil size jika ada
        $size = $request->size_id
            ? ProductVariantSize::find($request->size_id)
            : null;

        // Tentukan harga
        $price = $variant
            ? $variant->harga
            : ($product->price ?? 0);

        // Cek apakah item sudah ada (cocok product + variant + size)
        $existing = Keranjang::where('user_id', $user->id)
                            ->where('product_id', $product->id)
                            ->where('variant_id', $request->variant_id)
                            ->where('size_id', $request->size_id)
                            ->first();

        if ($existing) {
            // Jika item sama, tambahkan qty
            $existing->qty += $qty;
            $existing->save();
        } else {
            Keranjang::create([
                'user_id'      => $user->id,
                'product_id'   => $product->id,
                'variant_id'   => $request->variant_id,
                'size_id'      => $request->size_id,
                'qty'          => $qty,
                'harga_satuan' => $price,
            ]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    // Update qty
    public function update(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|integer|min:1',
        ]);

        $item = Keranjang::findOrFail($id);
        if ($item->user_id != Auth::id()) abort(403);

        $item->qty = $request->qty;
        $item->save();

        return redirect()->route('keranjang.index')->with('success', 'Keranjang diperbarui.');
    }

    // Hapus item
    public function remove($id)
    {
        $item = Keranjang::findOrFail($id);
        if ($item->user_id != Auth::id()) abort(403);

        $item->delete();

        return redirect()->route('keranjang.index')->with('success', 'Produk dihapus dari keranjang.');
    }

    // Kosongkan keranjang
    public function clear()
    {
        Keranjang::where('user_id', Auth::id())->delete();

        return redirect()->route('keranjang.index')->with('success', 'Keranjang dikosongkan.');
    }
}
