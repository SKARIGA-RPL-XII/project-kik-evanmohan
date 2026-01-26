<?php

namespace App\Http\Controllers;

use App\Models\Iklan;
use App\Models\Kategori;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // $iklans = Iklan::where('status', 'ACTIVE')->get();
        // $products = Product::latest()->get();
        // $kategori = Kategori::all();

        $search = $request->search;

        $products = Product::when($search, function ($q) use ($search) {
            return $q->where('nama_produk', 'like', "%{$search}%");
        })
            ->latest()
            ->get();


        // kirim semua data lain juga
        return view('home.home', [
            'kategori' => Kategori::all(),
            'products' => $products,
            'iklans'   => Iklan::all(),
        ]);

        // return view('home.home', compact('iklans', 'products', 'kategori'));
    }


    public function search(Request $request)
    {
        $keyword = $request->search;

        $products = Product::where('nama_produk', 'like', "%{$keyword}%")
            ->orWhere('deskripsi', 'like', "%{$keyword}%")
            ->latest()
            ->paginate(12); // tampil per 12 item

        return view('home.search', compact('products', 'keyword'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function searchByKategori($slug)
    {
        // cari kategori berdasarkan slug
        $kategori = Kategori::where('slug', $slug)->first();

        if (!$kategori) {
            return redirect()->back()->with('error', 'Kategori tidak ditemukan');
        }

        // ambil produk berdasarkan kategori
        $products = Product::where('kategori_id', $kategori->id)
            ->latest()
            ->paginate(12);

        return view('home.search_kategori', [
            'products'     => $products,
            'kategori'     => $kategori,
            'kategoriList' => Kategori::all(),
            'iklans'       => Iklan::all(),
        ]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
