@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 shadow-sm border-0">
                {{-- HEADER CARD --}}
                <div class="card-header pb-0 d-flex justify-content-between align-items-center bg-white">
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Metode Pembayaran</h5>
                        <p class="text-sm mb-0 text-muted">Kelola akun bank, e-wallet, dan opsi COD untuk pelanggan.</p>
                    </div>
                    <button class="btn btn-primary btn-sm btn-round shadow-none mb-0"
                            style="background-color:#ff855f; border:none;"
                            data-bs-toggle="modal" data-bs-target="#modalTambahPayment">
                        <i class="fas fa-plus me-1"></i> Tambah Metode
                    </button>
                </div>

                {{-- BODY CARD --}}
                <div class="card-body px-0 pt-0 pb-2 mt-3">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-hover">
                            <thead class="bg-light text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                <tr>
                                    <th class="ps-4">Nama Metode</th>
                                    <th class="ps-2">Tipe</th>
                                    <th class="ps-2">No. Rekening / Akun</th>
                                    <th class="ps-2">Atas Nama</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($methods as $pm)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-sm font-weight-bold mb-0 text-dark">{{ $pm->nama_metode }}</p>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm bg-gradient-faded-light text-dark border text-xxs" style="color: #525f7f !important;">
                                            {{ $pm->tipe }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-sm font-weight-bold text-dark">{{ $pm->no_rekening ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0">{{ $pm->atas_nama ?? '-' }}</p>
                                    </td>
                                    <td class="text-center align-middle">
                                        @if ($pm->aktif)
                                            <span class="badge badge-sm bg-success text-xxs px-2" style="border-radius: 6px;">Aktif</span>
                                        @else
                                            <span class="badge badge-sm bg-secondary text-xxs px-2" style="border-radius: 6px;">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="btn-group shadow-none">
                                            {{-- TOMBOL EDIT --}}
                                            <button class="btn btn-link text-warning px-2 mb-0"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalEditPayment{{ $pm->id }}"
                                                    title="Edit">
                                                <i class="bi bi-pencil-square text-lg"></i>
                                            </button>

                                            {{-- TOMBOL HAPUS --}}
                                            <form action="{{ route('admin.payment.destroy', $pm->id) }}" method="POST" class="d-inline form-delete">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-link text-danger px-2 mb-0 btn-hapus"
                                                        data-name="{{ $pm->nama_metode }}"
                                                        title="Hapus">
                                                    <i class="bi bi-trash text-lg"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                {{-- MODAL EDIT --}}
                                <div class="modal fade" id="modalEditPayment{{ $pm->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg">
                                            <div class="modal-header border-bottom-0">
                                                <h6 class="modal-title font-weight-bold">Edit Metode Pembayaran</h6>
                                                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.payment.update', $pm->id) }}" method="POST" class="form-proses">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body py-0">
                                                    <div class="form-group mb-3">
                                                        <label class="form-control-label">Nama Metode</label>
                                                        <input type="text" name="nama_metode" class="form-control shadow-none" value="{{ $pm->nama_metode }}" required>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-control-label">Tipe</label>
                                                            <select name="tipe" class="form-select shadow-none">
                                                                <option value="BANK" {{ $pm->tipe == 'BANK' ? 'selected' : '' }}>BANK</option>
                                                                <option value="E-WALLET" {{ $pm->tipe == 'E-WALLET' ? 'selected' : '' }}>E-WALLET</option>
                                                                <option value="COD" {{ $pm->tipe == 'COD' ? 'selected' : '' }}>COD</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-control-label">Status Aktif</label>
                                                            <select name="aktif" class="form-select shadow-none">
                                                                <option value="1" {{ $pm->aktif ? 'selected' : '' }}>Aktif</option>
                                                                <option value="0" {{ !$pm->aktif ? 'selected' : '' }}>Nonaktif</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="form-control-label">No. Rekening / Akun</label>
                                                        <input type="text" name="no_rekening" class="form-control shadow-none" value="{{ $pm->no_rekening }}">
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label class="form-control-label">Atas Nama</label>
                                                        <input type="text" name="atas_nama" class="form-control shadow-none" value="{{ $pm->atas_nama }}">
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-top-0">
                                                    <button type="button" class="btn btn-link text-secondary mb-0" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary shadow-none mb-0">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <p class="text-muted mb-0">Belum ada metode pembayaran yang terdaftar.</p>
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
</div>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modalTambahPayment" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom-0">
                <h6 class="modal-title font-weight-bold">Tambah Metode Baru</h6>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.payment.store') }}" method="POST" class="form-proses">
                @csrf
                <div class="modal-body py-0">
                    <div class="form-group mb-3">
                        <label class="form-control-label">Nama Metode</label>
                        <input type="text" name="nama_metode" class="form-control shadow-none" placeholder="Contoh: Bank Mandiri / Dana" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-control-label">Tipe Pembayaran</label>
                        <select name="tipe" class="form-select shadow-none" required>
                            <option value="BANK">BANK</option>
                            <option value="E-WALLET">E-WALLET</option>
                            <option value="COD">COD</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-control-label">No. Rekening / Nomor Akun</label>
                        <input type="text" name="no_rekening" class="form-control shadow-none" placeholder="1234xxxxxx">
                    </div>
                    <div class="form-group mb-4">
                        <label class="form-control-label">Atas Nama</label>
                        <input type="text" name="atas_nama" class="form-control shadow-none" placeholder="Masukkan nama pemilik akun">
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-link text-secondary mb-0" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary shadow-none mb-0" style="background-color:#ff855f; border:none;">Simpan Metode</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SCRIPTS --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });

    @if (session('success'))
        Toast.fire({ icon: "success", title: "{{ session('success') }}" });
    @endif

    // Loading Submit
    document.querySelectorAll('.form-proses').forEach(form => {
        form.addEventListener('submit', function() {
            Swal.fire({
                title: 'Sedang Menyimpan...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => { Swal.showLoading(); }
            });
        });
    });

    // Konfirmasi Hapus
    document.querySelectorAll('.btn-hapus').forEach(button => {
        button.addEventListener('click', function() {
            const nama = this.getAttribute('data-name');
            const form = this.closest('form');

            Swal.fire({
                title: "Hapus Metode?",
                text: "Pelanggan tidak akan bisa lagi menggunakan '" + nama + "' untuk bertransaksi.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#f5365c",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({ title: 'Menghapus...', allowOutsideClick: false, showConfirmButton: false, didOpen: () => { Swal.showLoading(); } });
                    form.submit();
                }
            });
        });
    });
});
</script>

<style>
    .form-control-label { font-size: 0.75rem; font-weight: 700; color: #525f7f; margin-bottom: 0.5rem; display: block; text-transform: uppercase; }
    .btn-round { border-radius: 50px; }
    .text-lg { font-size: 1.1rem !important; }
    .form-select { border: 1px solid #d2d6da; border-radius: 8px; padding: 0.5rem 0.75rem; font-size: 0.875rem; }
    .badge-sm { padding: 0.45em 0.75em; }
</style>
@endsection
