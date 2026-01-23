<?php

namespace App\Http\Controllers;

use App\Models\Favorit;
use Illuminate\Http\Request;

class FavoritController extends Controller
{
    /**
     * Tambah ke favorit berdasarkan variant & size
     */
    public function store(Request $request)
    {
        $data = [
            'user_id' => auth()->id(),
            'produk_id' => $request->produk_id,
        ];

        Favorit::firstOrCreate($data);

        return response()->json([
            'success' => true,
            'message' => 'Produk ditambahkan ke favorit'
        ]);
    }


    /**
     * Hapus favorit berdasarkan produk + variant + size
     */
    public function destroy(Request $request)
    {
        Favorit::where('user_id', auth()->id())
            ->where('produk_id', $request->produk_id)
            ->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk dihapus dari favorit'
            ]);
        }

        return back()->with('success', 'Produk dihapus dari favorit!');
    }



    /**
     * List semua favorit user
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $tab = $request->query('tab', 'biodata');
        $favorits = $user->favorits()->with(['produk'])->get();

        return view('user.profile', compact('user', 'tab', 'favorits'));
    }
}
