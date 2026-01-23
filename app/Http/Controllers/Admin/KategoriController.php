<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    // Menampilkan semua kategori
    public function index()
    {
        $kategoris = Kategori::latest()->get();
        return view('admin.kategori.index', compact('kategoris'));
    }

    // Menampilkan form create
    public function create()
    {
        $kategoris = Kategori::latest()->get();
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function edit(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategoris = Kategori::latest()->get();

        return view('admin.kategori.index', compact('kategoris', 'kategori'));
    }

    // Simpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required',
            'deskripsi' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['nama_kategori', 'deskripsi']);

        // Generate slug
        $data['slug'] = Str::slug($request->nama_kategori);

        // Upload image jika ada
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('kategori', 'public');
        }

        Kategori::create($data);

        return redirect('/admin/kategori')->with('success', 'Kategori berhasil ditambahkan!');
    }

    // public function edit(string $id)
    // {
    //     $kategori = Kategori::findOrFail($id);
    //     return view('admin.kategori.index', compact('kategoris'));
    // }

    // Update kategori
    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required',
            'deskripsi' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'nama_kategori' => $request->nama_kategori,
            'deskripsi'     => $request->deskripsi,
            'slug'          => Str::slug($request->nama_kategori),
        ];

        // Jika upload image baru
        if ($request->hasFile('image')) {
            if ($kategori->image) {
                Storage::disk('public')->delete($kategori->image);
            }

            $data['image'] = $request->file('image')->store('kategori', 'public');
        }

        $kategori->update($data);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    // Hapus kategori
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        if ($kategori->image) {
            Storage::disk('public')->delete($kategori->image);
        }

        $kategori->delete();

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
