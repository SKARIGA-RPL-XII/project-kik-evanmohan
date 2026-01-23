@extends('home.app')

@section('content')

    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Poppins', sans-serif;
        }

        .payment-card {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            border: 1px solid #eee;
        }

        .payment-title {
            font-size: 20px;
            font-weight: 600;
            color: #222;
        }

        .label-box {
            background: #f8f9fc;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #e4e7ec;
            margin-bottom: 10px;
        }

        .bank-box {
            background: #fff8e6;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #ffd28a;
            color: #8a5200;
        }

        .upload-box {
            border: 2px dashed #d0d0d0;
            padding: 25px;
            border-radius: 12px;
            background: #fafafa;
            transition: 0.3s;
        }

        .upload-box:hover {
            border-color: #ff6d00;
            background: #fff5ec;
        }

        .btn-pay {
            background: #ff6d00;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            color: white;
        }

        .btn-cancel-pay {
            border: 1px solid #dc3545;
            color: #dc3545;
            padding: 6px 15px;
            border-radius: 8px;
            background: white;
        }
    </style>

    <div class="container mt-4 mb-5">
        <div class="payment-card">

            <div class="d-flex justify-content-between align-items-center">
                <h4 class="payment-title">Pembayaran Pesanan</h4>

                @if(!$pesanan->buktiPembayaran)
                    <button class="btn-cancel-pay" data-bs-toggle="modal" data-bs-target="#batalModal">
                        Batal Pembayaran
                    </button>
                @endif
            </div>

            <div class="mt-3">
                <div class="label-box">
                    <strong>Kode Order:</strong> {{ $pesanan->kode_order }}
                </div>

                <div class="label-box">
                    <strong>Total Bayar:</strong>
                    <span class="text-danger fw-bold">
                        Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}
                    </span>
                </div>

                <div class="label-box">
                    <strong>Metode Pengiriman:</strong> {{ $pesanan->metode_pengiriman }}
                </div>

                <div class="label-box">
                    <strong>Status Pembayaran:</strong>
                    <span class="badge bg-{{ $pesanan->buktiPembayaran ? 'success' : 'danger' }}">
                        {{ $pesanan->buktiPembayaran->status ?? 'NOT PAID' }}
                    </span>
                </div>
            </div>

            <div class="bank-box mt-4">
                <h6 class="fw-bold mb-1">Transfer ke:</h6>
                <p class="mb-0">BANK BCA - <strong>1234567890</strong></p>
                <p class="mb-0">a.n. <strong>Toko Laravel</strong></p>
            </div>

            @if(!$pesanan->buktiPembayaran)

                <form action="{{ route('payment.upload', $pesanan->id) }}" method="POST" enctype="multipart/form-data"
                    class="mt-4">
                    @csrf

                    <div class="upload-box text-center">
                        <p class="mt-2">Upload Bukti Pembayaran</p>
                        <input type="file" name="bukti_pembayaran" id="foto_bukti" class="form-control mt-2" required
                            onchange="enablePayButton()">
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('payment.index') }}" class="btn btn-secondary w-50">Kembali</a>

                        <button type="submit" id="btnSudahBayar" class="btn-pay w-50" disabled>
                            Sudah Bayar
                        </button>
                    </div>
                </form>

            @else

                <div class="alert alert-success mt-4">
                    Bukti pembayaran telah dikirim! Menunggu verifikasi admin.
                </div>

                <img src="{{ asset('uploads/bukti/' . $pesanan->buktiPembayaran->bukti_pembayaran) }}"
                    class="img-fluid mt-3 rounded shadow" width="320">
            @endif

        </div>
    </div>

    <div class="modal fade" id="batalModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px;">

                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Pembatalan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p>Yakin ingin membatalkan pembayaran?</p>
                    <p class="text-danger fw-bold">Tindakan ini tidak dapat dibatalkan.</p>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>

                    <form action="{{ route('payment.cancel', $pesanan->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        function enablePayButton() {
            const file = document.getElementById('foto_bukti');
            const btn = document.getElementById('btnSudahBayar');
            if (file.files.length > 0) btn.disabled = false;
        }
    </script>

@endsection
