@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<div class="row mt-4 mx-4">
    <div class="col-12">

        <div class="card mb-4">

            <!-- Header -->
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Manajemen Metode Pembayaran</h6>

                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPayment">
                    + Tambah Metode
                </button>
            </div>

            <div class="card-body px-0 pt-0 pb-2">

                @if (session('success'))
                    <div class="alert alert-success mx-3 mt-3">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th>Nama Metode</th>
                                <th>Tipe</th>
                                <th>No Rekening / Akun</th>
                                <th>Atas Nama</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($methods as $pm)
                                <tr>
                                    <td>{{ $pm->nama_metode }}</td>
                                    <td>{{ $pm->tipe }}</td>
                                    <td>{{ $pm->no_rekening ?? '-' }}</td>
                                    <td>{{ $pm->atas_nama ?? '-' }}</td>

                                    <td>
                                        @if ($pm->aktif)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <!-- Edit -->
                                        <button class="btn btn-warning btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEditPayment{{ $pm->id }}">
                                            Edit
                                        </button>

                                        <!-- Hapus -->
                                        <form action="{{ route('admin.payment.destroy', $pm->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus metode ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="modalEditPayment{{ $pm->id }}" tabindex="-1"
                                    aria-hidden="true">

                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Metode Pembayaran</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <form action="{{ route('admin.payment.update', $pm->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="modal-body">

                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Metode</label>
                                                        <input type="text"
                                                               name="nama_metode"
                                                               class="form-control"
                                                               value="{{ $pm->nama_metode }}"
                                                               required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Tipe</label>
                                                        <select name="tipe" class="form-control" required>
                                                            <option value="BANK" {{ $pm->tipe == 'BANK' ? 'selected' : '' }}>BANK</option>
                                                            <option value="E-WALLET" {{ $pm->tipe == 'E-WALLET' ? 'selected' : '' }}>E-WALLET</option>
                                                            <option value="COD" {{ $pm->tipe == 'COD' ? 'selected' : '' }}>COD</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">No Rekening / Akun</label>
                                                        <input type="text"
                                                               name="no_rekening"
                                                               class="form-control"
                                                               value="{{ $pm->no_rekening }}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Atas Nama</label>
                                                        <input type="text"
                                                               name="atas_nama"
                                                               class="form-control"
                                                               value="{{ $pm->atas_nama }}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Status</label>
                                                        <select name="aktif" class="form-control">
                                                            <option value="1" {{ $pm->aktif ? 'selected' : '' }}>Aktif</option>
                                                            <option value="0" {{ !$pm->aktif ? 'selected' : '' }}>Nonaktif</option>
                                                        </select>
                                                    </div>

                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button"
                                                            class="btn btn-secondary"
                                                            data-bs-dismiss="modal">
                                                        Batal
                                                    </button>

                                                    <button type="submit" class="btn btn-primary">
                                                        Simpan
                                                    </button>
                                                </div>

                                            </form>

                                        </div>
                                    </div>
                                </div>

                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-3">
                                        Belum ada metode pembayaran.
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

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambahPayment" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Tambah Metode Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admin.payment.store') }}" method="POST">
                @csrf

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Nama Metode</label>
                        <input type="text" name="nama_metode" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tipe</label>
                        <select name="tipe" class="form-control" required>
                            <option value="BANK">BANK</option>
                            <option value="E-WALLET">E-WALLET</option>
                            <option value="COD">COD</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No Rekening / Akun</label>
                        <input type="text" name="no_rekening" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Atas Nama</label>
                        <input type="text" name="atas_nama" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection
