<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BuktiPembayaran;
use App\Models\LaporanPesanan;
use App\Models\Order;
use Illuminate\Http\Request;

class BuktiPembayaranController extends Controller
{
    public function index()
    {
        $list = BuktiPembayaran::with('order')
            ->latest()
            ->get();

        return view('admin.bukti_pembayaran.index', compact('list'));
    }

    public function approve($id)
    {
        $bukti = BuktiPembayaran::findOrFail($id);
        $bukti->status = 'VALID';
        $bukti->save();

        // Update status order menjadi PAID
        $order = $bukti->order;
        $order->status = 'PAID';
        $order->save();

        // ============================
        //  🔥 PENGURANGAN STOK PRODUK
        // ============================
        foreach ($order->items as $item) {
            $produk = $item->product; // pastikan relasi 'product' ada di OrderItem
            if ($produk) {
                $produk->stok = $produk->stok - $item->qty;
                if ($produk->stok < 0) {
                    $produk->stok = 0; // cegah stok minus
                }
                $produk->save();
            }
        }

        // Hitung total item
        $totalItem = $order->items->sum('qty');

        // Simpan Laporan
        LaporanPesanan::create([
            'order_id'       => $order->id,
            'kode_order'     => $order->kode_order,
            'nama_pembeli'   => $order->nama,
            'telepon'        => $order->telepon,
            'alamat'         => $order->alamat,
            'total_item'     => $totalItem,
            'total_bayar'    => $order->total_bayar,
            'ongkir'         => $order->ongkir,
            'ekspedisi'      => $order->metode_pengiriman,
            'tanggal_validasi' => now(),
        ]);

        return redirect()->back()->with('success', 'Bukti pembayaran telah divalidasi, stok berkurang, dan laporan pesanan dibuat.');
    }

    public function show($id)
    {
        // Ambil bukti + relasi order
        $bukti = BuktiPembayaran::with('order')->findOrFail($id);

        return view('admin.bukti_pembayaran.show', compact('bukti'));
    }



    public function reject($id)
    {
        $bukti = BuktiPembayaran::findOrFail($id);

        $bukti->status = 'INVALID';
        $bukti->save();

        $order = Order::find($bukti->order_id);
        $order->status = ' NOT PAID';
        $order->save();

        return back()->with('error', 'Bukti pembayaran ditolak.');
    }

    public function destroy($id)
    {
        $bukti = BuktiPembayaran::findOrFail($id);
        $bukti->delete();

        return back()->with('success', 'Bukti pembayaran dihapus.');
    }
}
