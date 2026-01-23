<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Iklan;
use App\Models\Product;
use Illuminate\Http\Request;

class IklanController extends Controller
{
    public function index()
    {
        $produk = Product::all();

        // Ambil semua iklan
        $iklans = Iklan::with('product')->latest()->get();

        return view('admin.iklan.index', compact('produk', 'iklans'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.iklan.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'nullable|string',
            'gambar' => 'required|image|mimes:jpg,jpeg,png',
            'produk_id' => 'nullable|exists:products,id',
            'status' => 'required|in:ACTIVE,INACTIVE',
        ]);

        $path = $request->file('gambar')->store('iklan', 'public');

        Iklan::create([
            'judul' => $request->judul,
            'gambar' => $path,
            'produk_id' => $request->produk_id,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.iklan.index')->with('success', 'Iklan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $iklan = Iklan::findOrFail($id);
        $products = Product::all();
        return view('admin.iklan.index', compact('iklan', 'products'));
    }

    public function update(Request $request, $id)
    {
        $iklan = Iklan::findOrFail($id);

        $request->validate([
            'judul' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png',
            'produk_id' => 'nullable|exists:products,id',
            'status' => 'required|in:ACTIVE,INACTIVE',
        ]);

        $data = $request->only(['judul', 'produk_id', 'status']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('iklan', 'public');
        }

        $iklan->update($data);

        return redirect()->route('admin.iklan.index')->with('success', 'Iklan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $iklan = Iklan::findOrFail($id);
        $iklan->delete();

        return back()->with('success', 'Iklan berhasil dihapus.');
    }
}
