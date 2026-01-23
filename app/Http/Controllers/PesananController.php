<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function index()
    {
        // Ambil semua pesanan milik user
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('payment.index', compact('orders'));
    }
}
