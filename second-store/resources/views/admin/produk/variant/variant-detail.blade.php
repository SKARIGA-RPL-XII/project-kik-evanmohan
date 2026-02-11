@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            {{-- CARD INFO VARIANT --}}
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <img src="{{ $variant->image ? asset('storage/' . $variant->image) : asset('argon/assets/img/default-product.png') }}"
                                 class="border-radius-lg shadow"
                                 style="width: 100px; height: 100px; object-fit: cover;">
                        </div>
                        <div class="col">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb bg-transparent mb-1 pb-0 pt-1 px-0 me-sm-6 me-5">
                                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.produk.index') }}">Produk</a></li>
                                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.produk.variant.index', $variant->product->id) }}">Variant</a></li>
                                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Size & Stok</li>
                                </ol>
                            </nav>
                            <h5 class="font-weight-bolder mb-0">{{ $variant->product->nama_produk }} ({{ $variant->warna }})</h5>
                            <p class="text-sm mb-0 mt-1">
                                <span class="badge badge-sm bg-gradient-success">Harga: Rp {{ number_format($variant->harga, 0, ',', '.') }}</span>
                                <span class="badge badge-sm bg-gradient-info ms-1">Total Stok: {{ $variant->sizes->sum('stok') }}</span>
                            </p>
                        </div>
                        <div class="col-auto text-end">
                            <a href="{{ route('admin.produk.variant.index', $variant->product->id) }}" class="btn btn-outline-secondary btn-sm btn-round mb-0">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button class="btn btn-primary btn-sm btn-round shadow-none mb-0"
                                    style="background-color:#ff855f; border:none;"
                                    data-bs-toggle="modal" data-bs-target="#modalTambahSize">
                                <i class="fas fa-plus me-1"></i> Tambah Size
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABEL SIZE --}}
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header pb-0 bg-white">
                    <h6 class="font-weight-bold text-dark">Daftar Ukuran & Stok Tersedia</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-hover">
                            <thead class="bg-light text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                <tr>
                                    <th class="ps-4">Size / Ukuran</th>
                                    <th class="ps-2">Jumlah Stok</th>
                                    <th class="ps-2">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($variant->sizes as $size)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm font-weight-bold">{{ $size->size }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0 text-dark">{{ $size->stok }} unit</p>
                                    </td>
                                    <td>
                                        @if($size->stok <= 5)
                                            <span class="badge badge-dot me-4">
                                                <i class="bg-warning"></i>
                                                <span class="text-dark text-xs">Stok Tipis</span>
                                            </span>
                                        @else
                                            <span class="badge badge-dot me-4">
                                                <i class="bg-success"></i>
                                                <span class="text-dark text-xs">Tersedia</span>
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="btn-group shadow-none">
                                            {{-- TOMBOL EDIT --}}
                                            <button class="btn btn-link text-warning px-2 mb-0"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalEditSize{{ $size->id }}"
                                                    title="Edit Stok">
                                                <i class="bi bi-pencil-square text-lg"></i>
                                            </button>

                                            {{-- TOMBOL HAPUS --}}
                                            <form action="{{ route('admin.variant.size.destroy', $size->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-link text-danger px-2 mb-0 btn-hapus"
                                                        data-name="{{ $size->size }}"
                                                        title="Hapus">
                                                    <i class="bi bi-trash text-lg"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                {{-- MODAL EDIT SIZE --}}
                                <div class="modal fade" id="modalEditSize{{ $size->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered shadow-lg">
                                        <div class="modal-content border-0">
                                            <div class="modal-header border-bottom-0">
                                                <h6 class="modal-title font-weight-bold">Update Stok & Size</h6>
                                                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.variant.size.update', $size->id) }}" method="POST" class="form-proses">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body py-0">
                                                    <div class="mb-3">
                                                        <label class="form-control-label">Size / Ukuran</label>
                                                        <input type="text" name="size" class="form-control shadow-none" value="{{ $size->size }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-control-label">Jumlah Stok</label>
                                                        <input type="number" name="stok" class="form-control shadow-none" value="{{ $size->stok }}" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-top-0">
                                                    <button type="button" class="btn btn-link text-secondary mb-0" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary shadow-none mb-0">Update Data</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <p class="text-muted mb-0">Belum ada size yang ditambahkan.</p>
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

{{-- MODAL TAMBAH SIZE --}}
<div class="modal fade" id="modalTambahSize" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom-0">
                <h6 class="modal-title font-weight-bold">Tambah Size & Stok Baru</h6>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.variant.size.store', $variant->id) }}" method="POST" class="form-proses">
                @csrf
                <div class="modal-body py-0">
                    <div class="mb-3">
                        <label class="form-control-label">Nama Size</label>
                        <input type="text" name="size" class="form-control shadow-none" placeholder="Contoh: XL, 42, atau All Size" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-control-label">Jumlah Stok Awal</label>
                        <input type="number" name="stok" class="form-control shadow-none" placeholder="0" required>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-link text-secondary mb-0" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary shadow-none mb-0" style="background-color:#ff855f; border:none;">Simpan Size</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .form-control-label { font-size: 0.7rem; font-weight: 700; color: #525f7f; margin-bottom: 0.5rem; display: block; text-transform: uppercase; }
    .btn-round { border-radius: 50px; }
    .text-lg { font-size: 1.1rem !important; }
</style>

{{-- SweetAlert2 Script --}}
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
                title: 'Sedang Memproses...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => { Swal.showLoading(); }
            });
        });
    });

    // Konfirmasi Hapus
    document.querySelectorAll('.btn-hapus').forEach(button => {
        button.addEventListener('click', function() {
            const sizeName = this.getAttribute('data-name');
            const form = this.closest('form');
            Swal.fire({
                title: "Hapus Size " + sizeName + "?",
                text: "Data stok untuk ukuran ini akan dihapus secara permanen!",
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
@endsection
