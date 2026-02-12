<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BuktiPembayaran;
use App\Models\LaporanPesanan;
use App\Models\Order;
use Illuminate\Support\Facades\DB; // Tambahkan ini
use Illuminate\Support\Facades\Storage;
use App\Models\ProductVariantSize;
use Illuminate\Http\Request;

class BuktiPembayaranController extends Controller
{
    /**
     * Menampilkan semua bukti pembayaran
     */
    public function index()
    {
        $list = BuktiPembayaran::with(['order.alamat']) // pastikan alamat eager load
            ->latest()
            ->get();

        return view('admin.bukti_pembayaran.index', compact('list'));
    }

    /**
     * Approve bukti pembayaran dan kurangi stok
     */
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
        // 🔥 PENGURANGAN STOK PRODUK
        // ============================
        foreach ($order->items as $item) {
            if (!$item->size) {
                continue; // jika tidak ada size, skip
            }

            if ($item->size->stok < $item->qty) {
                return back()->with(
                    'error',
                    'Stok tidak cukup untuk size ' . $item->size->size
                );
            }

            // kurangi stok
            $item->size->decrement('stok', $item->qty);
        }

        // Hitung total item
        $totalItem = $order->items->sum('qty');

        // Ambil alamat order jika ada
        $alamat = $order->alamat;

        // Simpan Laporan Pesanan dengan snapshot alamat lengkap
        LaporanPesanan::create([
            'order_id'         => $order->id,
            'kode_order'       => $order->kode_order,
            'nama_pembeli'     => $order->nama,
            'telepon'          => $order->telepon,
            'alamat'           => $alamat ? ($alamat->alamat_lengkap ?? '-') : '-',
            'kota'             => $alamat->kota ?? '-',
            'provinsi'         => $alamat->provinsi ?? '-',
            'kode_pos'         => $alamat->kode_pos ?? '-',
            'total_item'       => $totalItem,
            'total_bayar'      => $order->total_bayar,
            'ongkir'           => $order->ongkir,
            'ekspedisi'        => $order->metode_pengiriman,
            'tanggal_validasi' => now(),
        ]);

        return redirect()->back()->with(
            'success',
            'Bukti pembayaran telah divalidasi, stok berkurang, dan laporan pesanan dibuat.'
        );
    }

    /**
     * Tampilkan detail bukti pembayaran
     */
    public function show($id)
    {
        $bukti = BuktiPembayaran::with(['order.alamat'])->findOrFail($id);

        return view('admin.bukti_pembayaran.show', compact('bukti'));
    }

    /**
     * Tolak bukti pembayaran
     */
    public function reject($id)
    {
        $bukti = BuktiPembayaran::findOrFail($id);

        $bukti->status = 'INVALID';
        $bukti->save();

        $order = Order::find($bukti->order_id);
        $order->status = 'NOT PAID';
        $order->save();

        return back()->with('error', 'Bukti pembayaran ditolak.');
    }

    /**
     * Hapus bukti pembayaran
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            // 1. Cari data bukti pembayaran
            $bukti = BuktiPembayaran::findOrFail($id);

            // 2. Ambil referensi Order-nya
            $order = Order::with('items')->find($bukti->order_id);

            // 3. Hapus file fisik bukti pembayaran dari storage (Opsional)
            if ($bukti->bukti_transfer && Storage::disk('public')->exists($bukti->bukti_transfer)) {
                Storage::disk('public')->delete($bukti->bukti_transfer);
            }

            // 4. Hapus Bukti Pembayaran
            $bukti->delete();

            // 5. Hapus Order dan Item-nya
            if ($order) {
                // Hapus item-item order terlebih dahulu
                $order->items()->delete();
                // Hapus order-nya
                $order->delete();
            }

            DB::commit();
            return back()->with('success', 'Seluruh data pesanan dan bukti pembayaran berhasil dihapus permanen.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
