<?php

namespace App\Http\Controllers;

use App\Models\Favorit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Halaman edit profil
    public function edit(Request $request)
    {
        $user = Auth::user();
        $tab = $request->query('tab', 'biodata'); // tab aktif default biodata
        $favorits = $user->favorits()->with(['produk', 'variant', 'size'])->get();

        return view('user.profile', compact('user', 'tab', 'favorits'));
    }

    // Update profil
    public function update(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email'    => 'required|email|max:255',
            'no_hp'    => 'required|string|max:20',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5000',
        ]);

        $user = Auth::user();

        // Cek apakah ada file baru
        if ($request->file('image')) {
            // Hapus image lama jika ada
            if ($user->image && Storage::exists('public/' . $user->image)) {
                Storage::delete('public/' . $user->image);
            }

            // Simpan file baru
            $user->image = $request->file('image')->store('users', 'public');
        }

        // Update data lain
        $user->username = $request->username;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function profile(Request $request)
{
    $tab = $request->get('tab', 'biodata');

    $user = auth()->user();

    // ambil data favorit user
    $favorits = Favorit::where('user_id', $user->id)
                ->with('product')
                ->get();

    // ambil alamat
    $alamats = $user->alamats;

    return view('user.profile-tabs', compact('tab', 'user', 'alamats', 'favorits'));
}

}
