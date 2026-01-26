<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use Illuminate\Http\Request;
use App\Models\AlamatUser;
use Illuminate\Support\Facades\Auth;

class AlamatController extends Controller
{
    /**
     * Menampilkan semua alamat milik user
     */
    public function index()
    {
        $alamats = Alamat::where('user_id', auth()->id())->get();

        return view('user.alamat', compact('alamats'));
    }


    /**
     * Menyimpan alamat baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_penerima' => 'required|string|max:100',
            'alamat_lengkap' => 'required|string',
            'patokan' => 'nullable|string',
            'kecamatan' => 'required|string|max:100',
            'kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kode_pos' => 'required|string|max:10'
        ]);

        Alamat::create([
            'user_id' => Auth::id(),
            'nama_penerima' => $request->nama_penerima,
            'alamat_lengkap' => $request->alamat_lengkap,
            'patokan' => $request->patokan,
            'kecamatan' => $request->kecamatan,
            'kota' => $request->kota,
            'provinsi' => $request->provinsi,
            'kode_pos' => $request->kode_pos
        ]);

        return back()->with('success', 'Alamat berhasil ditambahkan');
    }

    /**
     * Update alamat
     */
    public function update(Request $request, $id)
    {
        $alamat = Alamat::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'nama_penerima' => 'required|string|max:100',
            'alamat_lengkap' => 'required|string',
            'patokan' => 'nullable|string',
            'kecamatan' => 'required|string|max:100',
            'kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kode_pos' => 'required|string|max:10'
        ]);

        $alamat->update($request->all());

        return back()->with('success', 'Alamat berhasil diperbarui');
    }

    /**
     * Hapus alamat
     */
    public function destroy($id)
    {
        $alamat = Alamat::where('user_id', Auth::id())->findOrFail($id);
        $alamat->delete();

        return back()->with('success', 'Alamat berhasil dihapus');
    }

    /**
     * Set sebagai alamat utama
     */
    public function setPrimary($id)
    {
        $userId = Auth::id();

        // set semua alamat user menjadi non-utama
        Alamat::where('user_id', $userId)->update([
            'is_utama' => false
        ]);

        // atur alamat yang dipilih menjadi utama
        Alamat::where('user_id', $userId)
            ->where('id', $id)
            ->update([
                'is_utama' => true
            ]);

        return back()->with('success', 'Alamat utama diperbarui');
    }
}
