@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center"
            style="background-color: white; border-radius:8px 8px 0 0;">
            <h5 class="mb-0 fw-bold">Manajemen Ekspedisi</h5>

            <button class="btn text-white px-4"
                style="background-color:#ff855f; border-radius:8px;"
                data-bs-toggle="modal" data-bs-target="#addEkspedisiModal">
                + Tambah Ekspedisi
            </button>
        </div>

        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0 text-sm">
                    <thead style="background-color:#f8fafc;">
                        <tr>
                            <th class="ps-4">Kode</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Ongkir</th>
                            <th>Tanggal Dibuat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($ekspedisis as $e)
                        <tr>
                            <td class="ps-4 fw-bold text-primary">{{ $e->kode_ekspedisi }}</td>
                            <td class="fw-semibold">{{ $e->nama }}</td>
                            <td class="text-wrap" style="max-width: 200px;">{{ $e->deskripsi ?? '-' }}</td>
                            <td>Rp {{ number_format($e->ongkir, 0, ',', '.') }}</td>
                            <td>{{ $e->created_at->format('d/m/Y') }}</td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- EDIT --}}
                                    <button class="btn btn-warning btn-sm"
                                            style="border-radius:8px;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editEkspedisiModal{{ $e->id }}">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>

                                    {{-- HAPUS --}}
                                    <form action="{{ route('admin.ekspedisi.destroy', $e->id) }}"
                                          method="POST"
                                          class="form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-hapus"
                                                data-name="{{ $e->nama }}"
                                                style="border-radius:8px;">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- ==================== EDIT MODAL ==================== --}}
                        <div class="modal fade" id="editEkspedisiModal{{ $e->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <form class="modal-content form-proses"
                                      action="{{ route('admin.ekspedisi.update', $e->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Ekspedisi: {{ $e->nama }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <label class="form-label">Nama Ekspedisi</label>
                                        <input type="text" name="nama" class="form-control mb-3"
                                               value="{{ $e->nama }}" required>

                                        <label class="form-label">Deskripsi</label>
                                        <textarea name="deskripsi" class="form-control mb-3" rows="3">{{ $e->deskripsi }}</textarea>

                                        <label class="form-label">Biaya Ongkir (Rp)</label>
                                        <input type="number" name="ongkir" class="form-control mb-3"
                                               value="{{ $e->ongkir }}" required>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


{{-- ==================== TAMBAH EKSPEDISI MODAL ==================== --}}
<div class="modal fade" id="addEkspedisiModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content form-proses" action="{{ route('admin.ekspedisi.store') }}" method="POST">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Ekspedisi Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <label class="form-label">Nama Ekspedisi</label>
                <input type="text" name="nama" class="form-control mb-3" placeholder="Misal: J&T Express" required>

                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control mb-3" placeholder="Opsional" rows="3"></textarea>

                <label class="form-label">Biaya Ongkir (Rp)</label>
                <input type="number" name="ongkir" class="form-control mb-3" placeholder="10000" required>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" style="background-color:#ff855f; border:none;">Simpan Ekspedisi</button>
            </div>
        </form>
    </div>
</div>

{{-- SweetAlert2 Script --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // 1. Toast Notification Setup
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });

    @if (session('success'))
        Toast.fire({
            icon: "success",
            title: "{{ session('success') }}"
        });
    @endif

    // 2. Loading saat Submit Form (Tambah/Edit)
    const forms = document.querySelectorAll('.form-proses');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            Swal.fire({
                title: 'Sedang Menyimpan...',
                text: 'Harap tunggu sebentar',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        });
    });

    // 3. Konfirmasi Hapus Spesifik
    const deleteButtons = document.querySelectorAll('.btn-hapus');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const nama = this.getAttribute('data-name');
            const form = this.closest('form');

            Swal.fire({
                title: "Hapus Ekspedisi?",
                text: "Ekspedisi '" + nama + "' akan dihapus permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menghapus...',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    form.submit();
                }
            });
        });
    });
});
</script>
@endsection
