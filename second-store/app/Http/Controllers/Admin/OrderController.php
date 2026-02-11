<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\BuktiPembayaran;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with([
            'items.product',
            'buktiPembayaran'
        ])->latest()->get();

        // TAMBAHAN — untuk tabel daftar bukti pembayaran
        $list = BuktiPembayaran::with('order')
            ->latest()
            ->get();

        return view('admin.orders.index', compact('orders', 'list'));
    }
}
