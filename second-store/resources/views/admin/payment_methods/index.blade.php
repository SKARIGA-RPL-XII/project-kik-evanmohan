@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center bg-white" style="border-radius:8px 8px 0 0;">
                <h6 class="fw-bold text-dark">Manajemen Metode Pembayaran</h6>
                <button class="btn text-white btn-sm px-4"
                        style="background-color:#ff855f; border-radius:8px;"
                        data-bs-toggle="modal" data-bs-target="#modalTambahPayment">
                    + Tambah Metode
                </button>
            </div>

            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0 text-sm">
                        <thead style="background-color:#f8fafc;">
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">Nama Metode</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tipe</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No Rekening / Akun</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Atas Nama</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($methods as $pm)
                            <tr>
                                <td class="ps-4">
                                    <p class="text-sm font-weight-bold mb-0 text-dark">{{ $pm->nama_metode }}</p>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border text-xxs" style="border-radius: 6px;">{{ $pm->tipe }}</span>
                                </td>
                                <td><p class="text-sm mb-0 text-dark fw-bold">{{ $pm->no_rekening ?? '-' }}</p></td>
                                <td><p class="text-sm mb-0">{{ $pm->atas_nama ?? '-' }}</p></td>
                                <td>
                                    @if ($pm->aktif)
                                        <span class="badge bg-success text-xxs" style="border-radius: 6px;">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary text-xxs" style="border-radius: 6px;">Nonaktif</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-warning btn-sm px-3 m-0"
                                                style="border-radius:8px; background-color:#f57c00; border:none; color:white;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditPayment{{ $pm->id }}">
                                            Edit
                                        </button>

                                        <form action="{{ route('admin.payment.destroy', $pm->id) }}" method="POST" class="m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm px-3 m-0 btn-hapus"
                                                    data-name="{{ $pm->nama_metode }}"
                                                    style="border-radius:8px; background-color:#d32f2f; border:none;">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            {{-- ==================== MODAL EDIT (MENGIKUTI STYLE PRODUK) ==================== --}}
                            <div class="modal fade" id="modalEditPayment{{ $pm->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-title fw-bold text-dark">Edit Metode Pembayaran</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <form class="form-proses" action="{{ route('admin.payment.update', $pm->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body pb-0">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold text-xs text-dark text-uppercase" style="letter-spacing: 0.5px;">Nama Metode</label>
                                                    <input type="text" name="nama_metode" class="form-control border-secondary-light"
                                                           value="{{ $pm->nama_metode }}" placeholder="Contoh: Bank BCA" required style="border-radius: 8px;">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-bold text-xs text-dark text-uppercase" style="letter-spacing: 0.5px;">Tipe</label>
                                                    <select name="tipe" class="form-control border-secondary-light" required style="border-radius: 8px;">
                                                        <option value="BANK" {{ $pm->tipe == 'BANK' ? 'selected' : '' }}>BANK</option>
                                                        <option value="E-WALLET" {{ $pm->tipe == 'E-WALLET' ? 'selected' : '' }}>E-WALLET</option>
                                                        <option value="COD" {{ $pm->tipe == 'COD' ? 'selected' : '' }}>COD</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-bold text-xs text-dark text-uppercase" style="letter-spacing: 0.5px;">No Rekening / Akun</label>
                                                    <input type="text" name="no_rekening" class="form-control border-secondary-light"
                                                           value="{{ $pm->no_rekening }}" placeholder="Masukkan nomor..." style="border-radius: 8px;">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-bold text-xs text-dark text-uppercase" style="letter-spacing: 0.5px;">Atas Nama</label>
                                                    <input type="text" name="atas_nama" class="form-control border-secondary-light"
                                                           value="{{ $pm->atas_nama }}" placeholder="Nama pemilik..." style="border-radius: 8px;">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-bold text-xs text-dark text-uppercase" style="letter-spacing: 0.5px;">Status Aktif</label>
                                                    <select name="aktif" class="form-control border-secondary-light" style="border-radius: 8px;">
                                                        <option value="1" {{ $pm->aktif ? 'selected' : '' }}>Aktif</option>
                                                        <option value="0" {{ !$pm->aktif ? 'selected' : '' }}>Nonaktif</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="modal-footer border-0 d-flex justify-content-end gap-2 pb-4">
                                                <button type="button" class="btn btn-sm px-4 fw-bold"
                                                        style="background-color:#7b919e; color:white; border-radius:8px;"
                                                        data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-sm px-4 fw-bold"
                                                        style="background-color:#ff855f; color:white; border-radius:8px;">
                                                    Simpan Perubahan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Belum ada metode pembayaran.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ==================== MODAL TAMBAH (STYLE SAMA DENGAN EDIT) ==================== --}}
<div class="modal fade" id="modalTambahPayment" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-dark">Tambah Metode Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form class="form-proses" action="{{ route('admin.payment.store') }}" method="POST">
                @csrf
                <div class="modal-body pb-0">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-xs text-dark text-uppercase" style="letter-spacing: 0.5px;">Nama Metode</label>
                        <input type="text" name="nama_metode" class="form-control border-secondary-light" placeholder="Contoh: OVO / Dana" required style="border-radius: 8px;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-xs text-dark text-uppercase" style="letter-spacing: 0.5px;">Tipe</label>
                        <select name="tipe" class="form-control border-secondary-light" required style="border-radius: 8px;">
                            <option value="BANK">BANK</option>
                            <option value="E-WALLET">E-WALLET</option>
                            <option value="COD">COD</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-xs text-dark text-uppercase" style="letter-spacing: 0.5px;">No Rekening / Akun</label>
                        <input type="text" name="no_rekening" class="form-control border-secondary-light" placeholder="Masukkan nomor..." style="border-radius: 8px;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-xs text-dark text-uppercase" style="letter-spacing: 0.5px;">Atas Nama</label>
                        <input type="text" name="atas_nama" class="form-control border-secondary-light" placeholder="Nama pemilik akun..." style="border-radius: 8px;">
                    </div>
                </div>

                <div class="modal-footer border-0 d-flex justify-content-end gap-2 pb-4">
                    <button type="button" class="btn btn-sm px-4 fw-bold"
                            style="background-color:#7b919e; color:white; border-radius:8px;"
                            data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm px-4 fw-bold text-white"
                            style="background-color:#ff855f; border-radius:8px;">
                        Simpan Metode
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script SweetAlert2 & Efek Loading --}}
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

    // Loading saat klik Simpan
    const forms = document.querySelectorAll('.form-proses');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            Swal.fire({
                title: 'Sedang Menyimpan...',
                text: 'Harap tunggu sebentar',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => { Swal.showLoading(); }
            });
        });
    });

    // Pop-up Hapus
    const deleteButtons = document.querySelectorAll('.btn-hapus');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const nama = this.getAttribute('data-name');
            const form = this.closest('form');
            Swal.fire({
                title: "Hapus Metode?",
                text: "Metode '" + nama + "' akan dihapus selamanya.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d32f2f",
                cancelButtonColor: "#7b919e",
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
@endsection
