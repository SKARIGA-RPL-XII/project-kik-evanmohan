@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 shadow-sm border-0">
                {{-- HEADER --}}
                <div class="card-header pb-0 d-flex justify-content-between align-items-center bg-white">
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Manajemen Produk</h5>
                        <p class="text-sm mb-0 text-muted">Kelola daftar produk, kategori, dan varian harga Anda di sini.</p>
                    </div>
                    <button class="btn btn-primary btn-sm btn-round shadow-none mb-0" data-bs-toggle="modal" data-bs-target="#modalTambahProduk">
                        <i class="fas fa-plus me-1"></i> Tambah Produk
                    </button>
                </div>

                {{-- TABLE BODY --}}
                <div class="card-body px-0 pt-0 pb-2 mt-3">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-hover">
                            <thead class="bg-light text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                <tr>
                                    <th class="ps-4">Produk</th>
                                    <th class="ps-2">Kategori</th>
                                    <th class="ps-2">Total Varian</th>
                                    <th class="text-center">Tanggal Dibuat</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($products as $p)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="position-relative">
                                                    <img src="{{ $p->image ? asset('storage/' . $p->image) : asset('argon/assets/img/default-product.png') }}"
                                                         class="avatar avatar-md rounded-3 border shadow-sm"
                                                         style="object-fit: cover;">
                                                </div>
                                                <div class="ms-3">
                                                    <h6 class="mb-0 text-sm font-weight-bold text-dark">{{ $p->nama_produk }}</h6>
                                                    <p class="text-xs text-muted mb-0">ID: #PROD-{{ $p->id }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm bg-gradient-faded-light text-dark border shadow-none px-3">
                                                {{ $p->kategori->nama_kategori ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-layers text-primary me-2 text-xs"></i>
                                                <span class="text-sm font-weight-bold">{{ $p->variants->count() }} <span class="text-muted text-xs">Variant</span></span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-secondary text-xs">{{ $p->created_at->format('d M Y') }}</span>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="btn-group shadow-none">
                                                {{-- KELOLA VARIAN --}}
                                                <a href="{{ route('admin.produk.variant.index', $p->id) }}"
                                                   class="btn btn-link text-success px-2 mb-0" data-bs-toggle="tooltip" title="Kelola Variant">
                                                    <i class="bi bi-sliders text-lg"></i>
                                                </a>

                                                {{-- EDIT --}}
                                                <button class="btn btn-link text-warning px-2 mb-0"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalEditProduk{{ $p->id }}" title="Edit Produk">
                                                    <i class="bi bi-pencil-square text-lg"></i>
                                                </button>

                                                {{-- DELETE --}}
                                                <form action="{{ route('admin.produk.destroy', $p->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-link text-danger px-2 mb-0 btn-hapus" title="Hapus Produk">
                                                        <i class="bi bi-trash text-lg"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- MODAL EDIT PRODUK --}}
                                    <div class="modal fade" id="modalEditProduk{{ $p->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content border-0 shadow-lg">
                                                <div class="modal-header border-bottom-0">
                                                    <h6 class="modal-title font-weight-bold">Edit Detail Produk</h6>
                                                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('admin.produk.update', $p->id) }}" method="POST" enctype="multipart/form-data" class="form-proses">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body py-0">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-control-label">Nama Produk</label>
                                                                <input type="text" name="nama_produk" class="form-control" value="{{ $p->nama_produk }}" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-control-label">Kategori</label>
                                                                <select name="kategori_id" class="form-control shadow-none" required>
                                                                    @foreach ($kategoris as $k)
                                                                        <option value="{{ $k->id }}" {{ $p->kategori_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-control-label">Ganti Gambar Produk</label>
                                                                <input type="file" name="image" class="form-control image-cropper-input">
                                                                <p class="text-xxs text-muted mt-1">*Gambar yang diunggah akan masuk ke mode Crop</p>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-control-label">Deskripsi</label>
                                                                <textarea name="deskripsi" class="form-control" rows="3">{{ $p->deskripsi }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-top-0">
                                                        <button type="button" class="btn btn-link text-secondary mb-0" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary shadow-none mb-0">Update Produk</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <i class="bi bi-box-seam text-secondary d-block text-xl mb-2"></i>
                                            <span class="text-secondary text-sm font-weight-bold">Opps! Belum ada produk tersedia.</span>
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

{{-- MODAL TAMBAH PRODUK --}}
<div class="modal fade" id="modalTambahProduk" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom-0">
                <h6 class="modal-title font-weight-bold">Buat Produk Baru</h6>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data" class="form-proses">
                @csrf
                <div class="modal-body py-0">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-control-label text-xs">Nama Produk</label>
                            <input type="text" name="nama_produk" class="form-control" placeholder="Nama Barang" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-control-label text-xs">Pilih Kategori</label>
                            <select name="kategori_id" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                @foreach ($kategoris as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-control-label text-xs">Upload Gambar</label>
                            <input type="file" name="image" class="form-control image-cropper-input shadow-none">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-control-label text-xs">Deskripsi Singkat</label>
                            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Informasi detail produk..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-link text-secondary mb-0" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary shadow-none mb-0">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL CROPPER --}}
<div class="modal fade" id="modalCropImage" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white border-bottom-0">
                <h6 class="modal-title text-white font-weight-bold">Sesuaikan Ukuran Gambar (1:1)</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body bg-gray-100">
                <div class="img-container">
                    <img id="previewCrop" style="max-width: 100%;">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-link text-secondary mb-0" data-bs-dismiss="modal">Batal</button>
                <button id="btnCrop" class="btn btn-primary shadow-none mb-0">Potong & Gunakan</button>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPTS --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. TOAST NOTIFICATION
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

    // 2. FORM LOADING STATE
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

    // 3. DELETE CONFIRMATION
    document.querySelectorAll('.btn-hapus').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('form');
            Swal.fire({
                title: "Hapus Produk?",
                text: "Semua varian dan histori produk ini akan terhapus!",
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

    // 4. CROPPER JS LOGIC
    let cropper;
    let targetInput;

    document.querySelectorAll('.image-cropper-input').forEach(input => {
        input.addEventListener('change', function (e) {
            targetInput = this;
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (event) {
                document.getElementById('previewCrop').src = event.target.result;
                let modal = new bootstrap.Modal(document.getElementById('modalCropImage'));
                modal.show();

                if (cropper) cropper.destroy();

                cropper = new Cropper(document.getElementById('previewCrop'), {
                    aspectRatio: 1,
                    viewMode: 2,
                    autoCropArea: 1,
                });
            };
            reader.readAsDataURL(file);
        });
    });

    document.getElementById('btnCrop').addEventListener('click', function () {
        if (!cropper) return;
        const canvas = cropper.getCroppedCanvas({ width: 600, height: 600 });
        canvas.toBlob(blob => {
            const croppedFile = new File([blob], "product.jpg", { type: "image/jpeg" });
            const dt = new DataTransfer();
            dt.items.add(croppedFile);
            targetInput.files = dt.files;
            bootstrap.Modal.getInstance(document.getElementById('modalCropImage')).hide();
        }, "image/jpeg", 0.9);
    });
});
</script>

<style>
    .avatar-md { width: 50px; height: 50px; }
    .form-control-label { font-size: 0.75rem; font-weight: 700; color: #525f7f; margin-bottom: 0.5rem; display: block; }
    .btn-round { border-radius: 50px; }
    .text-lg { font-size: 1.1rem !important; }
</style>
@endsection
