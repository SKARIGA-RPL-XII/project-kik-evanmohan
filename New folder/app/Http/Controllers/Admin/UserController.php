<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Tampilkan halaman edit profil user yang sedang login.
     */
    public function edit()
    {
        $user = Auth::user(); // ambil data user yang sedang login
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Proses update profil user.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'required|string|max:50|unique:users,username,' . $user->id,
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'password' => 'nullable|min:6|confirmed',
        ]);

        // Update data
        $user->email = $validated['email'];
        $user->username = $validated['username'];
        $user->no_hp = $validated['no_hp'] ?? $user->no_hp;
        $user->alamat = $validated['alamat'] ?? $user->alamat;

        // Jika password diisi, ubah juga
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
