<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    // LIST
    public function index()
    {
        $methods = PaymentMethod::orderBy('id', 'DESC')->get();
        return view('admin.payment_methods.index', compact('methods'));
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'nama_metode' => 'required|string|max:255',
            'tipe'        => 'required|string',
            'no_rekening' => 'nullable|string',
            'atas_nama'   => 'nullable|string',
        ]);

        PaymentMethod::create([
            'nama_metode' => $request->nama_metode,
            'tipe'        => $request->tipe,
            'no_rekening' => $request->no_rekening,
            'atas_nama'   => $request->atas_nama,
            'aktif'       => 1,
        ]);

        return back()->with('success', 'Metode pembayaran berhasil ditambahkan.');
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_metode' => 'required|string|max:255',
            'tipe'        => 'required|string',
            'no_rekening' => 'nullable|string',
            'atas_nama'   => 'nullable|string',
            'aktif'       => 'required|boolean',
        ]);

        $method = PaymentMethod::findOrFail($id);

        $method->update([
            'nama_metode' => $request->nama_metode,
            'tipe'        => $request->tipe,
            'no_rekening' => $request->no_rekening,
            'atas_nama'   => $request->atas_nama,
            'aktif'       => $request->aktif,
        ]);

        return back()->with('success', 'Metode pembayaran berhasil diperbarui.');
    }

    // DELETE
    public function destroy($id)
    {
        PaymentMethod::findOrFail($id)->delete();

        return back()->with('success', 'Metode pembayaran berhasil dihapus.');
    }
}
