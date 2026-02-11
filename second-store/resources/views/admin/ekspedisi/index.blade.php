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
                        <h5 class="mb-0 font-weight-bold text-dark">Manajemen Ekspedisi</h5>
                        <p class="text-sm mb-0 text-muted">Atur layanan pengiriman dan biaya ongkos kirim.</p>
                    </div>
                    <button class="btn btn-primary btn-sm btn-round shadow-none mb-0"
                            style="background-color:#ff855f; border:none;"
                            data-bs-toggle="modal" data-bs-target="#addEkspedisiModal">
                        <i class="fas fa-plus me-1"></i> Tambah Ekspedisi
                    </button>
                </div>

                {{-- BODY CARD --}}
                <div class="card-body px-0 pt-0 pb-2 mt-3">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-hover">
                            <thead class="bg-light text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                <tr>
                                    <th class="ps-4">Kode</th>
                                    <th class="ps-2">Nama Ekspedisi</th>
                                    <th class="ps-2">Deskripsi</th>
                                    <th class="ps-2">Ongkir</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ekspedisis as $e)
                                <tr>
                                    <td class="ps-4">
                                        <span class="text-xs font-weight-bold text-primary text-uppercase">{{ $e->kode_ekspedisi }}</span>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0 text-dark">{{ $e->nama }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0 text-wrap" style="max-width: 200px;">
                                            {{ $e->deskripsi ?? '-' }}
                                        </p>
                                    </td>
                                    <td>
                                        <span class="text-sm font-weight-bold text-dark">Rp {{ number_format($e->ongkir, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs">{{ $e->created_at->format('d/m/Y') }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="btn-group shadow-none">
                                            {{-- TOMBOL EDIT --}}
                                            <button class="btn btn-link text-warning px-2 mb-0"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editEkspedisiModal{{ $e->id }}"
                                                    title="Edit">
                                                <i class="bi bi-pencil-square text-lg"></i>
                                            </button>

                                            {{-- TOMBOL HAPUS --}}
                                            <form action="{{ route('admin.ekspedisi.destroy', $e->id) }}" method="POST" class="d-inline form-delete">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-link text-danger px-2 mb-0 btn-hapus"
                                                        data-name="{{ $e->nama }}"
                                                        title="Hapus">
                                                    <i class="bi bi-trash text-lg"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                {{-- MODAL EDIT --}}
                                <div class="modal fade" id="editEkspedisiModal{{ $e->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg">
                                            <div class="modal-header border-bottom-0">
                                                <h6 class="modal-title font-weight-bold">Perbarui Ekspedisi</h6>
                                                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.ekspedisi.update', $e->id) }}" method="POST" class="form-proses">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body py-0">
                                                    <div class="form-group mb-3">
                                                        <label class="form-control-label">Nama Ekspedisi</label>
                                                        <input type="text" name="nama" class="form-control shadow-none" value="{{ $e->nama }}" required>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="form-control-label">Deskripsi</label>
                                                        <textarea name="deskripsi" class="form-control shadow-none" rows="3">{{ $e->deskripsi }}</textarea>
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label class="form-control-label">Biaya Ongkir (Rp)</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text bg-gray-100 border-end-0 text-xs">Rp</span>
                                                            <input type="number" name="ongkir" class="form-control shadow-none ps-2" value="{{ $e->ongkir }}" required>
                                                        </div>
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="addEkspedisiModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom-0">
                <h6 class="modal-title font-weight-bold">Tambah Ekspedisi Baru</h6>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.ekspedisi.store') }}" method="POST" class="form-proses">
                @csrf
                <div class="modal-body py-0">
                    <div class="form-group mb-3">
                        <label class="form-control-label">Nama Ekspedisi</label>
                        <input type="text" name="nama" class="form-control shadow-none" placeholder="Contoh: JNE Reguler" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-control-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control shadow-none" rows="3" placeholder="Informasi tambahan pengiriman..."></textarea>
                    </div>
                    <div class="form-group mb-4">
                        <label class="form-control-label">Biaya Ongkir (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-gray-100 border-end-0 text-xs">Rp</span>
                            <input type="number" name="ongkir" class="form-control shadow-none ps-2" placeholder="15000" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-link text-secondary mb-0" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary shadow-none mb-0" style="background-color:#ff855f; border:none;">Simpan Ekspedisi</button>
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
                title: 'Memproses Data...',
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
                title: "Hapus Ekspedisi?",
                text: "Layanan '" + nama + "' tidak akan tersedia lagi untuk pengiriman.",
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
    .form-control-label { font-size: 0.75rem; font-weight: 700; color: #525f7f; margin-bottom: 0.5rem; display: block; }
    .btn-round { border-radius: 50px; }
    .text-lg { font-size: 1.1rem !important; }
    .input-group-text { border-radius: 8px 0 0 8px !important; }
    .input-group .form-control { border-radius: 0 8px 8px 0 !important; }
</style>
@endsection
