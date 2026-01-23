{{-- resources/views/payment/index.blade.php --}}
@extends('home.app')

@section('content')
<style>
    body {
        background-color: #f5f7fa;
        font-family: 'Poppins', sans-serif;
    }

    .order-card {
        background: #fff;
        border-radius: 14px;
        padding: 20px;
        margin-bottom: 22px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.07);
        border: 1px solid #eee;
        transition: .2s;
    }

    .order-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
    }

    .order-id {
        font-size: 18px;
        font-weight: 600;
        color: #333;
    }

    .status-badge {
        padding: 7px 12px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
    }

    .badge-paid {
        background: #0263e0;
        color: white;
    }

    .badge-pending {
        background: #0263e0;
        color: white;
    }

    .btn-tokped-pay {
        background: #595959;
        color: white;
        border-radius: 10px;
        padding: 10px 22px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        text-decoration: none;
        transition: .2s;
    }

    .btn-tokped-pay:hover {
        background: #3d3d3d;
    }

    .btn-tokped-cancel {
        background: red;
        border: 1px solid #ff0000;
        color: white;
        border-radius: 10px;
        padding: 10px 22px;
        font-size: 14px;
        font-weight: 600;
        transition: .2s;
    }

    .btn-tokped-cancel:hover {
        background: #cc0000;
    }

    .product-item {
        padding: 10px 0;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .product-item img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
    }

    .collapse-btn {
        background: none;
        border: none;
        color: #007bff;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        padding: 5px 0;
        transition: .2s;
    }

    .collapse-btn:hover {
        color: #0056c7;
    }

    .empty-orders {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 60vh;
        text-align: center;
    }

    .empty-orders img {
        max-width: 150px;
        opacity: .8;
        margin-bottom: 20px;
    }

    .product-details {
        font-size: 14px;
        color: #555;
    }
</style>

<div class="container payment-container">
    <h2 class="my-5 text-center">Riwayat Pembayaran</h2>

    {{-- EMPTY STATE --}}
    @if($orders->count() == 0)
        <div class="empty-orders">
            <img src="{{ asset('assets/images/riwayat.png') }}" alt="Empty">
            <h3 class="fw-bold mt-3" style="color:#333;">Riwayat Pembayaran Kosong</h3>
            <p style="color:#666; font-size:15px;">
                Belum ada transaksi pembayaran yang tercatat.
            </p>
            <a href="{{ route('home') }}"
               class="btn btn-primary px-4 py-2"
               style="border-radius:10px; font-weight:600;">
                Mulai Belanja
            </a>
        </div>
    @endif

    {{-- ORDER LIST --}}
    @foreach($orders as $order)
        <div class="order-card">

            <div class="order-header">
                <div class="order-id">Order #{{ $order->kode_order }}</div>

                @if($order->status == 'PAID')
                    <span class="status-badge badge-paid">Sudah Dibayar</span>

                @elseif($order->status == 'CANCELED')
                    <span class="status-badge" style="background:#dc3545; color:white;">Dibatalkan</span>

                @else
                    <span class="status-badge badge-pending">Belum Dibayar</span>
                @endif
            </div>

            <p><strong>Total Bayar:</strong> Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</p>
            <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y - H:i') }}</p>

            <button class="collapse-btn" data-bs-toggle="collapse" data-bs-target="#detail-{{ $order->id }}">
                Lihat Detail Produk ▼
            </button>

            <div id="detail-{{ $order->id }}" class="collapse mt-3">
                @foreach($order->items as $item)
                    <div class="product-item">
                        <img src="{{ $item->product->image ? asset('storage/'.$item->product->image) : 'https://via.placeholder.com/60' }}" alt="{{ $item->product->nama_produk }}">
                        <div>
                            <div>{{ $item->product->nama_produk }}</div>
                            @if($item->variant || $item->size)
                                <div class="product-details">
                                    @if($item->variant)
                                        Variant: {{ $item->variant }}
                                    @endif
                                    @if($item->size)
                                        | Size: {{ $item->size }}
                                    @endif
                                </div>
                            @endif
                            <div>{{ $item->qty }} × Rp {{ number_format($item->harga, 0, ',', '.') }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($order->status == 'NOT PAID')
                <div class="mt-3 d-flex gap-2 justify-content-end">

                    <a href="{{ route('payment.bayar', $order->id) }}" class="btn-tokped-pay">
                        Bayar Sekarang
                    </a>

                    <button class="btn-tokped-cancel" data-bs-toggle="modal" data-bs-target="#cancelModal-{{ $order->id }}">
                        Batal Pemesanan
                    </button>

                </div>
            @endif

        </div>

        {{-- MODAL PEMBATALAN --}}
        <div class="modal fade" id="cancelModal-{{ $order->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 12px;">

                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Pembatalan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin membatalkan pesanan <strong>#{{ $order->kode_order }}</strong>?</p>
                        <p class="text-danger fw-bold">Tindakan ini tidak bisa dibatalkan.</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Tidak
                        </button>

                        <form action="{{ route('payment.cancel', $order->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    @endforeach
</div>
@endsection
