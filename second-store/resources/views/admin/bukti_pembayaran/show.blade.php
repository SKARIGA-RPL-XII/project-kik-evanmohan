@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">

                <div class="card-header pb-0 d-flex justify-content-between align-items-center bg-white">
                    <div>
                        <h5 class="mb-0 text-dark font-weight-bold">Detail Bukti Pembayaran</h5>
                        <p class="text-sm mb-0 text-muted">Verifikasi dokumen transfer pelanggan untuk Order #{{ $bukti->order_id }}</p>
                    </div>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-secondary shadow-none mb-0">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-lg-4">
                            <div class="bg-gray-100 p-3 border-radius-lg mb-4">
                                <h6 class="text-sm font-weight-bold mb-3 text-uppercase">Informasi Pesanan</h6>

                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-sm text-secondary">Order ID:</span>
                                    <span class="text-sm font-weight-bold text-dark">#{{ $bukti->order_id }}</span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-sm text-secondary">Status Saat Ini:</span>
                                    @if($bukti->status == 'PENDING')
                                        <span class="badge bg-warning text-dark">PENDING</span>
                                    @elseif($bukti->status == 'VALID')
                                        <span class="badge bg-success">VALID</span>
                                    @else
                                        <span class="badge bg-danger">INVALID</span>
                                    @endif
                                </div>

                                <hr class="horizontal dark my-3">

                                {{-- ACTION BUTTONS --}}
                                @if($bukti->status == 'PENDING')
                                    <div class="d-flex flex-column gap-2">
                                        <form action="{{ route('admin.bukti.approve', $bukti->id) }}" method="POST" class="form-verify">
                                            @csrf
                                            <button type="button" class="btn btn-success w-100 mb-2 btn-verify" data-type="setujui">
                                                <i class="fas fa-check me-1"></i> Setujui Pembayaran
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.bukti.reject', $bukti->id) }}" method="POST" class="form-verify">
                                            @csrf
                                            <button type="button" class="btn btn-outline-danger w-100 btn-verify" data-type="tolak">
                                                <i class="fas fa-times me-1"></i> Tolak Pembayaran
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="alert alert-info text-white text-xs border-0 shadow-none mb-0">
                                        <i class="fas fa-lock me-1"></i> Bukti pembayaran ini sudah diverifikasi dan tidak dapat diubah lagi.
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-8 text-center text-lg-start">
                            <h6 class="text-sm font-weight-bold mb-3 text-uppercase">Lampiran Bukti Transfer</h6>
                            <div class="border-2 border-dashed border-radius-lg p-3 bg-white shadow-inner">
                                <a href="{{ asset('uploads/bukti/' . $bukti->bukti_pembayaran) }}" target="_blank">
                                    <img src="{{ asset('uploads/bukti/' . $bukti->bukti_pembayaran) }}"
                                         class="img-fluid border-radius-lg shadow"
                                         style="max-width: 100%; height: auto; border: 1px solid #eee;"
                                         alt="Bukti Transfer">
                                </a>
                                <div class="mt-3">
                                    <span class="text-xs text-muted">
                                        <i class="fas fa-search-plus me-1"></i> Klik gambar untuk melihat dalam ukuran penuh
                                    </span>
                                </div>
                            </div>
                        </div>
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
        const verifyButtons = document.querySelectorAll('.btn-verify');

        verifyButtons.forEach(button => {
            button.addEventListener('click', function() {
                const type = this.getAttribute('data-type');
                const isApprove = type === 'setujui';

                Swal.fire({
                    title: isApprove ? "Setujui Pembayaran?" : "Tolak Pembayaran?",
                    text: isApprove
                        ? "Pastikan saldo sudah masuk ke rekening sebelum konfirmasi."
                        : "Data bukti ini akan ditandai sebagai tidak valid.",
                    icon: isApprove ? "question" : "warning",
                    showCancelButton: true,
                    confirmButtonColor: isApprove ? "#2dce89" : "#f5365c",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: isApprove ? "Ya, Setujui" : "Ya, Tolak",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.closest('form').submit();
                    }
                });
            });
        });
    });
</script>
@endpush
