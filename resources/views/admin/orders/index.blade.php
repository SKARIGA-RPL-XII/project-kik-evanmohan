@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<div class="row mt-4 mx-4">
    <div class="col-12">

        <div class="card mb-4 shadow-sm">

            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Pemesanan</h5>

                {{-- Tombol Refresh --}}
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fa fa-rotate-right"></i> Refresh
                </a>
            </div>

            <div class="card-body px-0 pt-0 pb-2">

                {{-- Flash Message --}}
                @if (session('success'))
                    <div class="alert alert-success mx-3 mt-3">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger mx-3 mt-3">{{ session('error') }}</div>
                @endif

                <div class="table-responsive p-0">

                    <table class="table table-striped align-items-center mb-0">
                        <thead class="bg-light">
                            <tr class="text-center">
                                <th>Kode Pesanan</th>
                                <th>Nama Pembeli</th>
                                <th>Alamat</th>
                                <th>No TLP</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Qty</th>
                                <th>Harga Satuan</th>
                                <th>Subtotal</th>
                                <th>Ongkir</th>
                                <th>Total Bayar</th>
                                <th>Ekspedisi</th>
                                <th>Status Bayar</th>
                                <th>Verifikasi Manual</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($orders as $order)
                                @foreach ($order->items as $item)
                                    <tr class="text-center">

                                        <td><strong>#{{ $order->kode_order }}</strong></td>

                                        <td class="text-start">
                                            <strong>{{ $order->nama }}</strong>
                                        </td>

                                        <td class="text-start">{{ $order->alamat }}</td>
                                        <td>{{ $order->telepon }}</td>

                                        <td>{{ $item->product->kode_produk ?? '-' }}</td>
                                        <td>{{ $item->product->nama_produk ?? '-' }}</td>

                                        <td>
                                            <span class="badge bg-primary">{{ $item->qty }}</span>
                                        </td>

                                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>

                                        <td>Rp {{ number_format($order->ongkir, 0, ',', '.') }}</td>
                                        <td><strong>Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</strong></td>

                                        <td>{{ $order->metode_pengiriman }}</td>

                                        {{-- STATUS PEMBAYARAN --}}
                                        <td>
                                            @if ($order->status == 'PAID')
                                                <span class="badge bg-success px-3 py-2">PAID</span>
                                            @elseif ($order->status == 'NOT PAID')
                                                <span class="badge bg-warning text-dark px-3 py-2">NOT PAID</span>
                                            @else
                                                <span class="badge bg-danger px-3 py-2">CANCELLED</span>
                                            @endif
                                        </td>

                                        {{-- VERIFIKASI BUKTI --}}
                                        <td>

                                            @if ($order->buktiPembayaran)

                                                {{-- STATUS VERIFIKASI --}}
                                                @if ($order->buktiPembayaran->status == 'PENDING')
                                                    <span class="badge bg-warning text-dark mb-1">Pending</span>

                                                @elseif ($order->buktiPembayaran->status == 'VALID')
                                                    <span class="badge bg-success mb-1">Valid</span>

                                                @else
                                                    <span class="badge bg-danger mb-1">Invalid</span>
                                                @endif

                                                <br>

                                                {{-- Tombol Validasi --}}
                                                <a href="{{ route('admin.bukti.show', $order->buktiPembayaran->id) }}"
                                                   class="btn btn-sm btn-primary mt-1">
                                                    <i class="fa fa-check-circle"></i> Validasi Bukti
                                                </a>

                                            @else
                                                <span class="badge bg-secondary">Tidak Ada</span>
                                            @endif

                                        </td>

                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="14" class="text-center py-4 text-muted">
                                        Belum ada pesanan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>

            </div>
        </div>

    </div>
</div>
@endsection
