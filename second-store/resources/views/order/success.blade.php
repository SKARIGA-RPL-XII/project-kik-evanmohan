<h2>Pesanan Berhasil!</h2>

<p>ID Order: {{ $order->id }}</p>
<p>Total Bayar: Rp {{ number_format($order->total_bayar) }}</p>

@foreach($order->items as $i)
    <p>{{ $i->product->nama_produk }} x {{ $i->qty }}</p>
@endforeach
