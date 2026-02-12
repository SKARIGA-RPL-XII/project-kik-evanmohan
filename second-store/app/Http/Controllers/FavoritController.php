<?php

namespace App\Http\Controllers;

use App\Models\Favorit;
use Illuminate\Http\Request;

class FavoritController extends Controller
{
    /**
     * Digunakan oleh tombol Heart di Detail Produk (Toggle System)
     */
    public function store(Request $request, $produk_id)
    {
        $userId = auth()->id();

        // Cari apakah sudah ada di favorit
        $fav = Favorit::where('user_id', $userId)
                      ->where('produk_id', $produk_id)
                      ->first();

        if ($fav) {
            $fav->delete();
            return response()->json([
                'success' => true,
                'status' => 'removed',
                'message' => 'Produk dihapus dari favorit'
            ]);
        }

        Favorit::create([
            'user_id' => $userId,
            'produk_id' => $produk_id,
        ]);

        return response()->json([
            'success' => true,
            'status' => 'added',
            'message' => 'Produk ditambahkan ke favorit'
        ]);
    }

    /**
     * Digunakan oleh tombol "X" di Daftar Favorit (Hapus berdasarkan ID Favorit)
     */
    public function destroy($id)
    {
        // Cari berdasarkan ID favorit, bukan ID produk
        $favorit = Favorit::where('id', $id)
                          ->where('user_id', auth()->id())
                          ->first();

        if ($favorit) {
            $favorit->delete();
            return back()->with('success', 'Produk dihapus dari favorit!');
        }

        return back()->with('error', 'Produk gagal dihapus.');
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $tab = $request->query('tab', 'biodata');
        $favorits = $user->favorits()->with(['produk'])->get();

        return view('user.profile', compact('user', 'tab', 'favorits'));
    }
}
