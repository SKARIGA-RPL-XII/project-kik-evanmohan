@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 shadow-sm border-0">
                {{-- HEADER CARD --}}
                <div class="card-header pb-0 d-flex justify-content-between align-items-center bg-white">
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Variant Produk</h5>
                        <p class="text-sm mb-0 text-muted">Produk: <strong>{{ $product->nama_produk }}</strong></p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.produk.index') }}" class="btn btn-outline-secondary btn-sm btn-round mb-0">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <button class="btn btn-primary btn-sm btn-round shadow-none mb-0"
                                style="background-color:#ff855f; border:none;"
                                data-bs-toggle="modal" data-bs-target="#modalTambahVariant">
                            <i class="fas fa-plus me-1"></i> Tambah Variant
                        </button>
                    </div>
                </div>

                {{-- BODY CARD --}}
                <div class="card-body px-0 pt-0 pb-2 mt-3">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-hover">
                            <thead class="bg-light text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                <tr>
                                    <th class="ps-4" width="100">Gambar</th>
                                    <th class="ps-2">Warna</th>
                                    <th class="ps-2">Harga</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($variants as $v)
                                <tr>
                                    <td class="ps-4">
                                        <img src="{{ $v->image ? asset('storage/' . $v->image) : asset('argon/assets/img/default-product.png') }}"
                                             class="avatar avatar-md border-radius-lg shadow-sm" style="object-fit: cover;">
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0 text-dark">{{ $v->warna }}</p>
                                    </td>
                                    <td>
                                        <span class="text-sm font-weight-bold text-dark">Rp {{ number_format($v->harga, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="btn-group shadow-none">
                                            {{-- TOMBOL KELOLA SIZE --}}
                                            <a href="{{ route('admin.variant.detail', $v->id) }}"
                                               class="btn btn-link text-success px-2 mb-0"
                                               title="Kelola Size & Stok">
                                                <i class="bi bi-box-seam text-lg"></i>
                                            </a>

                                            {{-- TOMBOL EDIT --}}
                                            <button class="btn btn-link text-warning px-2 mb-0"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalEditVariant{{ $v->id }}"
                                                    title="Edit">
                                                <i class="bi bi-pencil-square text-lg"></i>
                                            </button>

                                            {{-- TOMBOL HAPUS --}}
                                            <form action="{{ route('admin.variant.destroy', $v->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-link text-danger px-2 mb-0 btn-hapus"
                                                        data-name="{{ $v->warna }}"
                                                        title="Hapus">
                                                    <i class="bi bi-trash text-lg"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                {{-- MODAL EDIT --}}
                                <div class="modal fade" id="modalEditVariant{{ $v->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg">
                                            <div class="modal-header border-bottom-0">
                                                <h6 class="modal-title font-weight-bold">Edit Variant</h6>
                                                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.variant.update', $v->id) }}" method="POST" enctype="multipart/form-data" class="form-proses">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body py-0">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-control-label">Warna</label>
                                                            <input type="text" name="warna" class="form-control shadow-none" value="{{ $v->warna }}" required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-control-label">Harga (Rp)</label>
                                                            <input type="number" name="harga" class="form-control shadow-none" value="{{ $v->harga }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label class="form-control-label">Ganti Gambar (Opsional)</label>
                                                        <input type="file" name="image" class="form-control shadow-none image-cropper-input">
                                                        @if($v->image)
                                                            <div class="mt-2">
                                                                <small class="text-muted d-block mb-1">Gambar saat ini:</small>
                                                                <img src="{{ asset('storage/' . $v->image) }}" class="rounded shadow-xs" width="60" height="60" style="object-fit: cover;">
                                                            </div>
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
                                    <td colspan="4" class="text-center py-5">
                                        <p class="text-muted mb-0">Belum ada variant untuk produk ini.</p>
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
<div class="modal fade" id="modalTambahVariant" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom-0">
                <h6 class="modal-title font-weight-bold">Tambah Variant Baru</h6>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.produk.variant.store', $product->id) }}" method="POST" enctype="multipart/form-data" class="form-proses">
                @csrf
                <div class="modal-body py-0">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-control-label text-uppercase">Warna</label>
                            <input type="text" name="warna" class="form-control shadow-none" placeholder="Contoh: Hitam" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-control-label text-uppercase">Harga (Rp)</label>
                            <input type="number" name="harga" class="form-control shadow-none" placeholder="Contoh: 150000" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-control-label text-uppercase">Gambar</label>
                            <input type="file" name="image" class="form-control shadow-none image-cropper-input">
                        </div>
                    </div>
                    <div class="alert alert-info border-0 shadow-none mb-4" style="background-color: #e8f4fd;">
                        <p class="text-xs text-dark mb-0">
                            <i class="bi bi-info-circle me-1"></i> Setelah menambahkan variant, Anda perlu mengatur <strong>Size & Stok</strong> melalui tombol aksi di tabel.
                        </p>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-link text-secondary mb-0" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary shadow-none mb-0" style="background-color:#ff855f; border:none;">Simpan Variant</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL CROPPER --}}
<div class="modal fade" id="modalCropImage" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header">
                <h6 class="modal-title font-weight-bold">Sesuaikan Gambar Variant</h6>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0 bg-light" style="overflow: hidden;">
                <div class="img-container">
                    <img id="previewCrop" style="max-width: 100%; display: block;">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-link text-secondary mb-0" data-bs-dismiss="modal">Batal</button>
                <button id="btnCrop" class="btn btn-primary mb-0 shadow-none">Gunakan Gambar</button>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control-label { font-size: 0.7rem; font-weight: 700; color: #525f7f; margin-bottom: 0.5rem; display: block; text-transform: uppercase; }
    .btn-round { border-radius: 50px; }
    .text-lg { font-size: 1.1rem !important; }
    .avatar-md { width: 48px; height: 48px; }
</style>

{{-- Scripts --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
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
            const variantName = this.getAttribute('data-name');
            const form = this.closest('form');
            Swal.fire({
                title: "Hapus Variant?",
                text: "Varian '" + variantName + "' akan dihapus beserta seluruh data stok sizenya!",
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

    // Cropper Logic
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
                    guides: true,
                    autoCropArea: 1,
                });
            };
            reader.readAsDataURL(file);
        });
    });

    document.getElementById('btnCrop').addEventListener('click', function () {
        if (!cropper) return;
        const canvas = cropper.getCroppedCanvas({ width: 800, height: 800 });
        canvas.toBlob(blob => {
            const croppedFile = new File([blob], "variant.jpg", { type: "image/jpeg" });
            const dt = new DataTransfer();
            dt.items.add(croppedFile);
            targetInput.files = dt.files;
            bootstrap.Modal.getInstance(document.getElementById('modalCropImage')).hide();
        }, "image/jpeg", 0.9);
    });
});
</script>
@endsection
