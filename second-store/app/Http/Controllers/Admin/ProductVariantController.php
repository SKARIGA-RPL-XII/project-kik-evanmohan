<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductVariantController extends Controller
{
    /**
     * INDEX – halaman semua variant untuk satu produk
     */
    public function index($productId)
    {
        $product = Product::with('variants.sizes')->findOrFail($productId);

        return view('admin.produk.variant.variant', [
            'product' => $product,
            'variants' => $product->variants
        ]);
    }

    /**
     * DETAIL – halaman khusus satu variant dengan semua size-nya
     */
    public function detail($variantId)
    {
        $variant = ProductVariant::with('sizes', 'product')->findOrFail($variantId);

        return view('admin.produk.variant.variant-detail', [
            'variant' => $variant
        ]);
    }

    /**
     * STORE – tambah variant warna
     */
    public function store(Request $request, $productId)
    {
        $request->validate([
            'warna' => 'required|max:50',
            'harga' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $request->file('image')
            ? $request->file('image')->store('variant', 'public')
            : null;

        ProductVariant::create([
            'product_id' => $productId,
            'warna' => $request->warna,
            'harga' => $request->harga,
            'image' => $imagePath,
        ]);

        return back()->with('success', 'Variant warna berhasil ditambahkan');
    }

    /**
     * UPDATE – update variant warna
     */
    public function update(Request $request, $id)
    {
        $variant = ProductVariant::findOrFail($id);

        $request->validate([
            'warna' => 'required|max:50',
            'harga' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update image
        if ($request->hasFile('image')) {
            if ($variant->image) {
                Storage::disk('public')->delete($variant->image);
            }
            $variant->image = $request->file('image')->store('variant', 'public');
        }

        $variant->update([
            'warna' => $request->warna,
            'harga' => $request->harga,
        ]);

        return back()->with('success', 'Variant warna berhasil diperbarui');
    }

    /**
     * DESTROY – hapus variant warna beserta size-nya
     */
    public function destroy($id)
    {
        $variant = ProductVariant::with('sizes')->findOrFail($id);

        if ($variant->image) {
            Storage::disk('public')->delete($variant->image);
        }

        foreach ($variant->sizes as $size) {
            $size->delete();
        }

        $variant->delete();

        return back()->with('success', 'Variant warna beserta size berhasil dihapus');
    }

    /**
     * STORE SIZE – tambah size untuk variant tertentu
     */
    public function storeSize(Request $request, $variantId)
    {
        $request->validate([
            'size' => 'required|max:50',
            'stok' => 'required|integer|min:0',
        ]);

        ProductVariantSize::create([
            'variant_id' => $variantId,
            'size' => $request->size,
            'stok' => $request->stok,
        ]);

        return back()->with('success', 'Size berhasil ditambahkan');
    }

    /**
     * UPDATE SIZE
     */
    public function updateSize(Request $request, $id)
    {
        $size = ProductVariantSize::findOrFail($id);

        $request->validate([
            'size' => 'required|max:50',
            'stok' => 'required|integer|min:0',
        ]);

        $size->update([
            'size' => $request->size,
            'stok' => $request->stok,
        ]);

        return back()->with('success', 'Size berhasil diperbarui');
    }

    /**
     * DESTROY SIZE
     */
    public function destroySize($id)
    {
        $size = ProductVariantSize::findOrFail($id);
        $size->delete();

        return back()->with('success', 'Size berhasil dihapus');
    }
}
