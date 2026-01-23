<?php

namespace App\Http\Controllers;

use App\Models\BuktiPembayaran;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PembayaranController extends Controller
{
    // =========================
    // HALAMAN BAYAR
    // =========================
    public function bayar($id)
    {
        $pesanan = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('payment.bayar', compact('pesanan'));
    }

    // =========================
    // LIST PEMBAYARAN
    // =========================
    public function list()
{
    $orders = Order::with(['items.product']) // <- tambahkan ini
        ->where('user_id', Auth::id())
        ->orderBy('created_at', 'desc')
        ->get();

    return view('payment.index', compact('orders'));
}


    // =========================
    // BATALKAN PEMBAYARAN
    // =========================
    public function cancel($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($order->status === 'PAID') {
            return redirect()->back()->with('error', 'Pesanan yang sudah dibayar tidak dapat dibatalkan.');
        }

        $order->status = 'CANCELLED';
        $order->save();

        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    // =========================
    // UPLOAD BUKTI PEMBAYARAN
    // =========================
    public function uploadBukti(Request $request, $orderId)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        // Cek pesanan milik user
        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (! $request->hasFile('bukti_pembayaran')) {
            return redirect()->back()->with('error', 'File bukti tidak ditemukan.');
        }

        // Upload file
        $file = $request->file('bukti_pembayaran');
        $filename = time() . '_' . Str::random(6) . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());

        $destination = public_path('uploads/bukti');
        if (! file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        $file->move($destination, $filename);

        // SIMPAN KE TABLE bukti_pembayarans (FIX ERROR)
        BuktiPembayaran::updateOrCreate(
            ['order_id' => $order->id],   // kondisi pencarian
            [
                'order_id' => $order->id, // 🔥 WAJIB — FIX ERROR 1364
                'bukti_pembayaran' => $filename,
                'status' => 'PENDING',
            ]
        );

        // Update status order
        $order->status = 'PAID';
        $order->save();

        return redirect()->route('payment.index')->with('success', 'Bukti pembayaran berhasil dikirim.');
    }
}
