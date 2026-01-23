@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<div class="container mt-4">

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail Bukti Pembayaran</h5>

            <!-- TOMBOL KEMBALI -->
            <a href="{{ route('admin.bukti.index') }}" class="btn btn-secondary btn-sm">
                ← Kembali
            </a>
        </div>

        <div class="card-body">

            <p><strong>Order ID:</strong> #{{ $bukti->order_id }}</p>

            <p><strong>Status:</strong>
                @if($bukti->status == 'PENDING')
                    <span class="badge bg-warning">PENDING</span>
                @elseif($bukti->status == 'VALID')
                    <span class="badge bg-success">VALID</span>
                @else
                    <span class="badge bg-danger">INVALID</span>
                @endif
            </p>

            <hr>

            <h6>Bukti Pembayaran:</h6>
            <img src="{{ asset('uploads/bukti/' . $bukti->bukti_pembayaran) }}"
                 class="img-fluid rounded"
                 style="max-width: 350px;">

            <hr>

            {{-- HANYA TAMPIL JIKA STATUS MASIH PENDING --}}
            @if($bukti->status == 'PENDING')

                <form action="{{ route('admin.bukti.approve', $bukti->id) }}"
                      method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-success">Setujui</button>
                </form>

                <form action="{{ route('admin.bukti.reject', $bukti->id) }}"
                      method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-danger">Tolak</button>
                </form>

            @else
                <div class="alert alert-info mt-3">
                    Bukti pembayaran sudah diverifikasi dan tidak dapat diubah lagi.
                </div>
            @endif

        </div>
    </div>

</div>
@endsection
