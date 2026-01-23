<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\Ekspedisi;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Keranjang;
use App\Models\PaymentMethod;
use App\Models\ProductVariant;
use App\Models\ProductVariantSize;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    private function generateKodeOrder()
    {
        return 'ORD-' . strtoupper(uniqid());
    }

    // =============================
    // 1. BUY NOW / CHECKOUT SINGLE
    // =============================
    public function buyNow(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $qty = $request->qty ?? 1;

        $variant = $request->variant_id ? ProductVariant::find($request->variant_id) : null;
        $size    = $request->size_id ? ProductVariantSize::find($request->size_id) : null;

        $harga_satuan = $variant?->harga ?? $product->harga;

        session(['checkout_items' => [[
            'cart_id'      => null,
            'product_id'   => $product->id,
            'nama_produk'  => $product->nama_produk,
            'image'        => $product->image,

            'variant_id'   => $variant?->id,
            'size_id'      => $size?->id,

            'variant_name' => $variant?->warna,
            'size_name'    => $size?->size,

            'variant'      => $variant,
            'size'         => $size,

            'qty'          => $qty,
            'harga_satuan' => $harga_satuan,
            'subtotal'     => $qty * $harga_satuan,
        ]]]);

        return redirect()->route('checkout.page');
    }

    // =============================
    // 2. CHECKOUT DARI KERANJANG
    // =============================
    public function checkoutCart(Request $request)
    {
        $selected = json_decode($request->items, true);

        if (!is_array($selected) || empty($selected)) {
            return redirect()->route('keranjang.index')->with('error', 'Pilih minimal satu produk.');
        }

        $ids = collect($selected)->pluck('id');

        $cartItems = Keranjang::whereIn('id', $ids)
            ->with(['product', 'variant', 'size'])
            ->get();

        $items = $cartItems->map(function ($cart) use ($selected) {
            $selectedItem = collect($selected)->firstWhere('id', $cart->id);
            $qty = $selectedItem['qty'] ?? $cart->qty;

            return [
                'cart_id'      => $cart->id,
                'product_id'   => $cart->product_id,
                'nama_produk'  => $cart->product->nama_produk,
                'image'        => $cart->product->image,

                'variant_id'   => $cart->variant_id,
                'size_id'      => $cart->size_id,

                'variant_name' => $cart->variant?->warna,
                'size_name'    => $cart->size?->size,

                'variant'      => $cart->variant,
                'size'         => $cart->size,

                'qty'          => $qty,
                'harga_satuan' => $cart->harga_satuan,
                'subtotal'     => $qty * $cart->harga_satuan,
            ];
        })->all();

        session(['checkout_items' => $items]);

        return redirect()->route('checkout.page');
    }

    // =============================
    // 3. HALAMAN CHECKOUT
    // =============================
    public function page()
    {
        $checkout = session('checkout_items', []);

        if (empty($checkout)) {
            return redirect()->route('keranjang.index')->with('error', 'Tidak ada item untuk checkout.');
        }

        $items = collect($checkout);
        $ekspedisi = Ekspedisi::all();
        $paymentMethods = PaymentMethod::where('aktif', 1)->get();

        $alamatUtama = Alamat::where('user_id', auth()->id())
            ->where('is_utama', true)
            ->first();

        $alamats = Alamat::where('user_id', auth()->id())->get();

        return view('checkout.checkout', [
            'items'          => $items,
            'total_barang'   => $items->sum('qty'),
            'total_harga'    => $items->sum(fn($i) => $i['subtotal']),
            'ekspedisi'      => $ekspedisi,
            'paymentMethods' => $paymentMethods,
            'alamatUtama'    => $alamatUtama,
            'alamats'        => $alamats
        ]);
    }

    // =================================
    // 4. PROSES CHECKOUT
    // =================================
    public function store(Request $request)
    {
        $request->validate([
            'metode_pengiriman' => 'required|exists:ekspedisi,id',
            'metode_pembayaran' => 'required|exists:payment_methods,id',
            'ongkir'            => 'required|numeric',
        ]);

        $cart = collect(session('checkout_items', []));

        if ($cart->isEmpty()) {
            return redirect()->back()->with('error', 'Checkout gagal, tidak ada item.');
        }

        $exp = Ekspedisi::findOrFail($request->metode_pengiriman);
        $paymentMethod = PaymentMethod::findOrFail($request->metode_pembayaran);

        $alamatUtama = Alamat::where('user_id', auth()->id())
            ->where('is_utama', true)
            ->first();

        $items = $cart->map(fn($i) => [
            'cart_id'       => $i['cart_id'] ?? null,
            'product_id'    => $i['product_id'],
            'variant_id'    => $i['variant_id'] ?? null,
            'size_id'       => $i['size_id'] ?? null,
            'qty'           => $i['qty'],
            'harga'         => $i['harga_satuan'],
            'subtotal'      => $i['subtotal'],
            'image'         => $i['image'],
        ]);

        $total_barang = $items->sum('qty');
        $total_harga  = $items->sum('subtotal');
        $ongkir       = $request->ongkir;
        $total_bayar  = $total_harga + $ongkir;

        $order = Order::create([
            'user_id'           => auth()->id(),
            'alamat_id'         => $alamatUtama?->id,  // ✔ FIX
            'nama'              => auth()->user()->username,
            'telepon'           => auth()->user()->no_hp,
            'total_barang'      => $total_barang,
            'total_harga'       => $total_harga,
            'ongkir'            => $ongkir,
            'total_bayar'       => $total_bayar,
            'metode_pengiriman' => $exp->nama,
            'metode_pembayaran' => $paymentMethod->nama_metode,
            'kode_order'        => $this->generateKodeOrder(),
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item['product_id'],
                'variant_id' => $item['variant_id'] ?? null,
                'size_id'    => $item['size_id'] ?? null,
                'qty'        => $item['qty'],
                'harga'      => $item['harga'],
                'subtotal'   => $item['subtotal'],
            ]);
        }

        $cartIds = $items->pluck('cart_id')->filter()->toArray();
        if (!empty($cartIds)) {
            Keranjang::where('user_id', auth()->id())
                ->whereIn('id', $cartIds)
                ->delete();
        }

        session()->forget('checkout_items');

        if ($paymentMethod->tipe === 'BANK') {
            return redirect()->route('payment.bayar', $order->id);
        }

        if ($paymentMethod->tipe === 'cod') {
            $order->status_pembayaran = 'COD';
            $order->save();
            return redirect()->route('payment.index')->with('success', 'Pesanan COD berhasil dibuat!');
        }

        return redirect()->route('payment.index')->with('success', 'Pesanan berhasil dibuat!');
    }
}
