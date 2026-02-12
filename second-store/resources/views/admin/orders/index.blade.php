@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">

                {{-- CARD DAFTAR PEMESANAN --}}
                <div class="card mb-4 border-0 shadow-lg">
                    <div class="card-header bg-white pb-0 d-flex justify-content-between align-items-center border-0">
                        <div>
                            <h5 class="mb-0 font-weight-bold"></i>Daftar Pemesanan</h5>
                            <p class="text-sm mb-0 text-muted">Kelola data transaksi. Menghapus bukti akan menghapus seluruh data order.</p>
                        </div>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary btn-round">
                            <i class="fa fa-rotate-right me-1"></i> Refresh
                        </a>
                    </div>

                    <div class="card-body px-0 pt-0 pb-2 mt-3">
                        <div class="table-responsive p-0">
                            <table class="table table-hover align-items-center mb-0">
                                <thead class="bg-gray-100">
                                    <tr class="text-secondary text-uppercase text-xxs font-weight-bolder opacity-7">
                                        <th class="ps-4">Order & Pelanggan</th>
                                        <th>Alamat Pengiriman</th>
                                        <th>Produk</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-center">Subtotal</th>
                                        <th class="text-center">Total Bayar</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($orders as $order)
                                        @php $itemCount = count($order->items); @endphp
                                        @foreach ($order->items as $index => $item)
                                            <tr>
                                                @if($index === 0)
                                                    <td rowspan="{{ $itemCount }}" class="ps-4 align-top">
                                                        <div class="d-flex flex-column">
                                                            <h6 class="mb-1 text-sm font-weight-bold text-dark">#{{ $order->kode_order }}</h6>
                                                            <span class="text-xs font-weight-bold text-wrap" style="width: 120px;">{{ $order->nama }}</span>
                                                            <span class="text-xxs text-muted"><i class="fas fa-phone-alt me-1"></i>{{ $order->telepon }}</span>
                                                        </div>
                                                    </td>

                                                    <td rowspan="{{ $itemCount }}" class="align-top">
                                                        @if($order->alamat)
                                                            <div class="text-xxs" style="min-width: 180px; white-space: normal; line-height: 1.4;">
                                                                <span class="d-block font-weight-bold text-dark mb-1">{{ $order->alamat->nama_penerima }}</span>
                                                                <span class="text-secondary">
                                                                    {{ $order->alamat->alamat_lengkap }},
                                                                    {{ $order->alamat->kecamatan }},
                                                                    {{ $order->alamat->kota }},
                                                                    {{ $order->alamat->provinsi }}
                                                                </span>
                                                                <div class="mt-1 font-weight-bold text-info">POS: {{ $order->alamat->kode_pos }}</div>
                                                            </div>
                                                        @else
                                                            <span class="text-xxs text-muted font-italic">Alamat tidak diatur</span>
                                                        @endif
                                                    </td>
                                                @endif

                                                <td class="align-middle">
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-xs font-weight-bold">{{ $item->product->nama_produk ?? '-' }}</h6>
                                                            <p class="text-xxs text-secondary mb-0">SKU: {{ $item->product->kode_produk ?? '-' }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <span class="badge badge-sm bg-outline-primary text-primary border border-primary px-3">{{ $item->qty }}</span>
                                                </td>
                                                <td class="text-end pe-3 align-middle">
                                                    <span class="text-xs font-weight-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                                </td>

                                                @if($index === 0)
                                                    <td rowspan="{{ $itemCount }}" class="text-center align-middle">
                                                        <div class="d-flex flex-column">
                                                            <span class="text-sm font-weight-bold text-dark">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</span>
                                                            <span class="text-xxs text-info font-weight-bold">Ongkir: {{ number_format($order->ongkir, 0, ',', '.') }}</span>
                                                        </div>
                                                    </td>
                                                    <td rowspan="{{ $itemCount }}" class="text-center align-middle">
                                                        <span class="badge badge-sm {{ $order->status == 'PAID' ? 'bg-gradient-success' : 'bg-gradient-warning' }}">
                                                            {{ $order->status }}
                                                        </span>
                                                    </td>
                                                    <td rowspan="{{ $itemCount }}" class="text-center align-middle">
                                                        <div class="d-flex flex-column align-items-center">
                                                            @if ($order->buktiPembayaran)
                                                                <div class="btn-group shadow-none mb-2">
                                                                    <a href="{{ route('admin.bukti.show', $order->buktiPembayaran->id) }}"
                                                                        class="btn btn-link text-info px-2 mb-0" data-bs-toggle="tooltip" title="Detail Bukti">
                                                                        <i class="bi bi-eye-fill fs-5"></i>
                                                                    </a>

                                                                    <form action="{{ route('admin.bukti.destroy', $order->buktiPembayaran->id) }}"
                                                                        method="POST" class="d-inline">
                                                                        @csrf @method('DELETE')
                                                                        <button type="button" class="btn btn-link text-danger px-2 mb-0 btn-delete"
                                                                            data-bs-toggle="tooltip" title="Hapus Seluruh Pesanan">
                                                                            <i class="bi bi-trash-fill fs-5"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                                <span class="badge text-xxs px-2" style="background: #f8f9fa; color: #333; border: 1px solid #ddd;">
                                                                    {{ $order->buktiPembayaran->status }}
                                                                </span>
                                                            @else
                                                                <span class="text-xxs text-secondary font-italic opacity-6">No Upload</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-5 text-muted">Belum ada pesanan yang masuk.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                {{-- CARD DAFTAR BUKTI PEMBAYARAN --}}
                <div class="card border-0 shadow-lg mt-4">
                    <div class="card-header bg-white pb-0 border-0">
                        <h6 class="font-weight-bold mb-0 text-dark"><i class="fas fa-file-invoice-dollar me-2 text-success"></i>Daftar Bukti Pembayaran</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2 mt-3">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead class="bg-gray-100">
                                    <tr class="text-secondary text-uppercase text-xxs font-weight-bolder opacity-7">
                                        <th class="ps-4">ID</th>
                                        <th>Kode Order</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($list as $b)
                                        <tr>
                                            <td class="ps-4"><span class="text-xs font-weight-bold text-dark">#{{ $b->id }}</span></td>
                                            <td><span class="text-xs font-weight-bold text-primary">#{{ $b->order->kode_order ?? '-' }}</span></td>
                                            <td class="text-center">
                                                <span class="badge badge-sm {{ $b->status == 'VALID' ? 'bg-success' : 'bg-warning' }}">{{ $b->status }}</span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group shadow-none">
                                                    <a href="{{ route('admin.bukti.show', $b->id) }}" class="btn btn-link text-info px-3 mb-0" title="Lihat">
                                                        <i class="bi bi-eye-fill fs-5"></i>
                                                    </a>
                                                    <form action="{{ route('admin.bukti.destroy', $b->id) }}" method="POST" class="d-inline">
                                                        @csrf @method('DELETE')
                                                        <button type="button" class="btn btn-link text-danger px-3 mb-0 btn-delete" title="Hapus">
                                                            <i class="bi bi-trash-fill fs-5"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center py-4 text-muted">Data tidak ditemukan.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Tooltip Init
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })

            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });

            @if(session('success'))
                Toast.fire({ icon: "success", title: "{{ session('success') }}" });
            @endif

            @if(session('error'))
                Toast.fire({ icon: "error", title: "{{ session('error') }}" });
            @endif

            // Global Delete Handler
            document.addEventListener('click', function (e) {
                if (e.target.closest('.btn-delete')) {
                    const button = e.target.closest('.btn-delete');
                    const form = button.closest('form');

                    Swal.fire({
                        title: "Hapus Pesanan?",
                        text: "PERHATIAN: Menghapus bukti ini juga akan menghapus seluruh data order dan produk di dalamnya secara permanen!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#f5365c",
                        cancelButtonColor: "#6c757d",
                        confirmButtonText: "Ya, Hapus Semua!",
                        cancelButtonText: "Batal",
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                }
            });
        });
    </script>
@endpush
