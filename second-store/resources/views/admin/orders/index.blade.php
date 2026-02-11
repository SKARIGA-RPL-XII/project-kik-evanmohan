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
                        <h5 class="mb-0 text-primary font-weight-bold"><i class="fas fa-shopping-cart me-2"></i>Daftar Pemesanan</h5>
                        <p class="text-sm mb-0 text-muted">Kelola data transaksi dan verifikasi pembayaran.</p>
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
                                                <span class="text-xs font-weight-bold">{{ $order->nama }}</span>
                                                <span class="text-xxs text-muted"><i class="fas fa-phone-alt me-1"></i>{{ $order->telepon }}</span>
                                                <p class="text-xxs text-wrap mb-0" style="max-width: 150px;">{{ $order->alamat }}</p>
                                            </div>
                                        </td>
                                        @endif

                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-xs font-weight-bold">{{ $item->product->nama_produk ?? '-' }}</h6>
                                                    <p class="text-xxs text-secondary mb-0">SKU: {{ $item->product->kode_produk ?? '-' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-sm bg-outline-primary text-primary border border-primary px-3">{{ $item->qty }}</span>
                                        </td>
                                        <td class="text-end pe-3">
                                            <span class="text-xs font-weight-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                        </td>

                                        @if($index === 0)
                                        <td rowspan="{{ $itemCount }}" class="text-center align-middle">
                                            <div class="d-flex flex-column">
                                                <span class="text-sm font-weight-bold text-dark">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</span>
                                                <span class="text-xxs text-info font-weight-bold">Ongkir: {{ number_format($order->ongkir, 0, ',', '.') }}</span>
                                                <span class="text-xxs text-secondary uppercase">{{ $order->metode_pengiriman }}</span>
                                            </div>
                                        </td>
                                        <td rowspan="{{ $itemCount }}" class="text-center align-middle">
                                            @if ($order->status == 'PAID')
                                                <span class="badge badge-sm bg-gradient-success">PAID</span>
                                            @elseif ($order->status == 'NOT PAID')
                                                <span class="badge badge-sm bg-gradient-warning">NOT PAID</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-danger">CANCELLED</span>
                                            @endif
                                        </td>
                                        <td rowspan="{{ $itemCount }}" class="text-center align-middle">
                                            <div class="d-flex flex-column align-items-center">
                                                @if ($order->buktiPembayaran)
                                                    <div class="btn-group shadow-none mb-2">
                                                        {{-- Tombol Aksi Detail --}}
                                                        <a href="{{ route('admin.bukti.show', $order->buktiPembayaran->id) }}"
                                                           class="btn btn-link text-info px-2 mb-0"
                                                           data-bs-toggle="tooltip" title="Detail Bukti">
                                                            <i class="bi bi-eye-fill fs-5"></i>
                                                        </a>

                                                        {{-- Form Hapus --}}
                                                        <form action="{{ route('admin.bukti.destroy', $order->buktiPembayaran->id) }}" method="POST" class="d-inline">
                                                            @csrf @method('DELETE')
                                                            <button type="button" class="btn btn-link text-danger px-2 mb-0 btn-delete"
                                                                    data-bs-toggle="tooltip" title="Hapus Bukti">
                                                                <i class="bi bi-trash-fill fs-5"></i>
                                                            </button>
                                                        </form>
                                                    </div>

                                                    @if ($order->buktiPembayaran->status == 'PENDING')
                                                        <span class="badge bg-soft-warning text-warning text-xxs px-2" style="background: #fffbeb;">Pending</span>
                                                    @elseif ($order->buktiPembayaran->status == 'VALID')
                                                        <span class="badge bg-soft-success text-success text-xxs px-2" style="background: #f0fdf4;">Valid</span>
                                                    @else
                                                        <span class="badge bg-soft-danger text-danger text-xxs px-2" style="background: #fef2f2;">Invalid</span>
                                                    @endif
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
                                        <td colspan="7" class="text-center py-5">
                                            <img src="https://illustrations.popsy.co/gray/empty-states.svg" style="width: 150px;" class="mb-3 opacity-6">
                                            <p class="text-muted">Belum ada pesanan yang masuk.</p>
                                        </td>
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
                    <p class="text-xs text-muted">Log data upload bukti pembayaran terbaru.</p>
                </div>
                <div class="card-body px-0 pt-0 pb-2 mt-3">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead class="bg-gray-100">
                                <tr class="text-secondary text-uppercase text-xxs font-weight-bolder opacity-7">
                                    <th class="ps-4">ID</th>
                                    <th>Kode Order</th>
                                    <th class="text-center">Status Verifikasi</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($list as $b)
                                    <tr>
                                        <td class="ps-4"><span class="text-xs font-weight-bold text-dark">#{{ $b->id }}</span></td>
                                        <td><span class="text-xs font-weight-bold text-primary">#{{ $b->order->kode_order ?? '-' }}</span></td>
                                        <td class="text-center">
                                            @if ($b->status == 'PENDING')
                                                <span class="badge badge-sm bg-warning px-3">Pending</span>
                                            @elseif ($b->status == 'VALID')
                                                <span class="badge badge-sm bg-success px-3">Disetujui</span>
                                            @else
                                                <span class="badge badge-sm bg-danger px-3">Ditolak</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group shadow-none">
                                                <a href="{{ route('admin.bukti.show', $b->id) }}"
                                                   class="btn btn-link text-info px-3 mb-0"
                                                   data-bs-toggle="tooltip" title="Lihat Detail">
                                                    <i class="bi bi-eye-fill fs-5"></i>
                                                </a>

                                                <form action="{{ route('admin.bukti.destroy', $b->id) }}" method="POST" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="button" class="btn btn-link text-danger px-3 mb-0 btn-delete"
                                                            data-bs-toggle="tooltip" title="Hapus Data">
                                                        <i class="bi bi-trash-fill fs-5"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">Data tidak ditemukan.</td>
                                    </tr>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Tooltip Bootstrap (Opsional)
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        @if(session('success'))
            Toast.fire({ icon: "success", title: "{{ session('success') }}" });
        @endif

        @if(session('error'))
            Toast.fire({ icon: "error", title: "{{ session('error') }}" });
        @endif

        // Global Delete Handler
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-delete')) {
                const button = e.target.closest('.btn-delete');
                const form = button.closest('form');

                Swal.fire({
                    title: "Hapus Data?",
                    text: "Data ini tidak dapat dikembalikan setelah dihapus!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#f5365c",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: "Ya, Hapus!",
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
