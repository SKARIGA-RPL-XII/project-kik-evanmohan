@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
{{-- Load Ikon Bootstrap untuk konsistensi --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 shadow-sm border-0">
                {{-- HEADER CARD --}}
                <div class="card-header pb-0 d-flex justify-content-between align-items-center bg-white">
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Manajemen Kategori</h5>
                        <p class="text-sm mb-0 text-muted">Kelola kategori produk untuk memudahkan pengelompokan stok.</p>
                    </div>
                    <button class="btn btn-primary btn-sm btn-round shadow-none mb-0" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">
                        <i class="fas fa-plus me-1"></i> Tambah Kategori
                    </button>
                </div>

                {{-- BODY CARD --}}
                <div class="card-body px-0 pt-0 pb-2 mt-3">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-hover">
                            <thead class="bg-light text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                <tr>
                                    <th class="ps-4">Ikon</th>
                                    <th class="ps-2">Nama Kategori</th>
                                    <th class="ps-2">Deskripsi</th>
                                    <th class="text-center">Dibuat Pada</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kategoris as $kategori)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                @if ($kategori->image)
                                                    <img src="{{ asset('storage/' . $kategori->image) }}"
                                                         class="avatar avatar-md rounded-3 border shadow-xs"
                                                         style="object-fit: cover;">
                                                @else
                                                    <div class="avatar avatar-md rounded-3 bg-gray-100 border shadow-xs d-flex align-items-center justify-content-center">
                                                        <i class="bi bi-tag text-secondary text-lg"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0 text-dark">{{ $kategori->nama_kategori }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs text-secondary mb-0" style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                {{ $kategori->deskripsi ?? '-' }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-secondary text-xs">{{ $kategori->created_at->format('d M Y') }}</span>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="btn-group shadow-none">
                                                {{-- TOMBOL EDIT --}}
                                                <button class="btn btn-link text-warning px-2 mb-0"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalEditKategori{{ $kategori->id }}"
                                                        title="Edit Kategori">
                                                    <i class="bi bi-pencil-square text-lg"></i>
                                                </button>

                                                {{-- TOMBOL HAPUS --}}
                                                <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-link text-danger px-2 mb-0 btn-delete" title="Hapus Kategori">
                                                        <i class="bi bi-trash text-lg"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- MODAL EDIT KATEGORI --}}
                                    <div class="modal fade" id="modalEditKategori{{ $kategori->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow-lg">
                                                <div class="modal-header border-bottom-0">
                                                    <h6 class="modal-title font-weight-bold">Edit Kategori</h6>
                                                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST" enctype="multipart/form-data" class="form-proses">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body py-0">
                                                        <div class="form-group mb-3">
                                                            <label class="form-control-label">Nama Kategori</label>
                                                            <input type="text" name="nama_kategori" class="form-control shadow-none" value="{{ $kategori->nama_kategori }}" required>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="form-control-label">Deskripsi</label>
                                                            <textarea name="deskripsi" class="form-control shadow-none" rows="3">{{ $kategori->deskripsi }}</textarea>
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="form-control-label d-block">Ganti Gambar</label>
                                                            <input type="file" name="image" class="form-control shadow-none mb-2">
                                                            @if ($kategori->image)
                                                                <small class="text-xs text-muted">Gambar saat ini: <a href="{{ asset('storage/' . $kategori->image) }}" target="_blank">Lihat</a></small>
                                                            @endif
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
                                        <td colspan="5" class="text-center py-5">
                                            <i class="bi bi-folder2-open text-secondary d-block text-xl mb-2"></i>
                                            <span class="text-secondary text-sm font-weight-bold">Opps! Belum ada kategori tersedia.</span>
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

{{-- MODAL TAMBAH KATEGORI --}}
<div class="modal fade" id="modalTambahKategori" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom-0">
                <h6 class="modal-title font-weight-bold">Tambah Kategori Baru</h6>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.kategori.store') }}" method="POST" enctype="multipart/form-data" class="form-proses">
                @csrf
                <div class="modal-body py-0">
                    <div class="form-group mb-3">
                        <label class="form-control-label">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control shadow-none" placeholder="Misal: Perabot Kantor" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-control-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control shadow-none" rows="3" placeholder="Penjelasan singkat..."></textarea>
                    </div>
                    <div class="form-group mb-4">
                        <label class="form-control-label">Unggah Gambar/Ikon</label>
                        <input type="file" name="image" class="form-control shadow-none">
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-link text-secondary mb-0" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary shadow-none mb-0">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SCRIPT --}}
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

        // Loading saat proses form
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
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form');
                Swal.fire({
                    title: "Hapus Kategori?",
                    text: "Produk yang menggunakan kategori ini akan kehilangan relasinya!",
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
    .avatar-md { width: 52px; height: 52px; }
    .shadow-xs { box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
    .form-control-label { font-size: 0.75rem; font-weight: 700; color: #525f7f; margin-bottom: 0.5rem; display: block; }
    .btn-round { border-radius: 50px; }
    .text-lg { font-size: 1.15rem !important; }
    .btn-link:hover { opacity: 0.8; }
</style>
@endsection
