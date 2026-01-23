@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<div class="row mt-4 mx-4">
    <div class="col-12">

        <div class="card mb-4">

            <div class="card-header pb-0">
                <h6>Daftar Bukti Pembayaran</h6>
            </div>

            <div class="card-body px-0 pt-0 pb-2">

                @if (session('success'))
                    <div class="alert alert-success mx-3 mt-3">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger mx-3 mt-3">{{ session('error') }}</div>
                @endif

                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode Order</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($list as $b)
                                <tr>
                                    <td>{{ $b->id }}</td>

                                    {{-- Tampilkan kode order --}}
                                    <td>#
                                        {{ $b->order->kode_order ?? '-' }}
                                    </td>

                                    <td>
                                        @if ($b->status == 'PENDING')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif ($b->status == 'VALID')
                                            <span class="badge bg-success">Disetujui</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>

                                    <td class="text-center">

                                        {{-- Detail --}}
                                        <a href="{{ route('admin.bukti.show', $b->id) }}"
                                           class="btn btn-primary btn-sm">
                                            Detail
                                        </a>

                                        {{-- Hapus --}}
                                        <form action="{{ route('admin.bukti.destroy', $b->id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Hapus bukti ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Hapus</button>
                                        </form>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">
                                        Belum ada bukti pembayaran.
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
