@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5>Variant Produk: <strong>{{ $product->nama_produk }}</strong></h5>
                </div>

                <div>
                    <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahVariant">
                        + Tambah Variant
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="90">Gambar</th>
                                <th>Warna</th>
                                <th>Harga</th>
                                <th width="240" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($variants as $v)
                                <tr>
                                    <td>
                                        <img src="{{ $v->image ? asset('storage/' . $v->image) : asset('argon/assets/img/default-product.png') }}"
                                             width="60" height="60" class="rounded shadow-sm" style="object-fit: cover;">
                                    </td>
                                    <td class="fw-semibold">{{ $v->warna }}</td>
                                    <td>Rp {{ number_format($v->harga, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.variant.detail', $v->id) }}" class="btn btn-success btn-sm">
                                            <i class="bi bi-rulers"></i> Kelola Size
                                        </a>

                                        <button class="btn btn-warning btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#modalEditVariant{{ $v->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <form action="{{ route('admin.variant.destroy', $v->id) }}" method="POST" class="d-inline form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm btn-hapus" data-name="{{ $v->warna }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <div class="modal fade" id="modalEditVariant{{ $v->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.variant.update', $v->id) }}" method="POST" enctype="multipart/form-data" class="form-proses">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5>Edit Variant</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label>Warna</label>
                                                            <input type="text" name="warna" class="form-control" value="{{ $v->warna }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Harga</label>
                                                            <input type="number" name="harga" class="form-control" value="{{ $v->harga }}" required>
                                                        </div>
                                                        <div class="col-12">
                                                            <label>Gambar (opsional)</label>
                                                            <input type="file" name="image" class="form-control image-cropper-input">
                                                            @if($v->image)
                                                                <img src="{{ asset('storage/' . $v->image) }}" class="mt-2 rounded" width="80" height="80" style="object-fit: cover;">
                                                            @endif
                                                        </div>
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
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">Belum ada varian untuk produk ini</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahVariant" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.produk.variant.store', $product->id) }}" method="POST" enctype="multipart/form-data" class="form-proses">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Variant Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Warna</label>
                            <input type="text" name="warna" class="form-control" placeholder="Contoh: Merah" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Harga</label>
                            <input type="number" name="harga" class="form-control" placeholder="65000" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Gambar Variant</label>
                            <input type="file" name="image" class="form-control image-cropper-input">
                        </div>
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

<div class="modal fade" id="modalCropImage" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crop Gambar Variant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <img id="previewCrop" style="width:100%; max-height:500px; object-fit:contain;">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button id="btnCrop" class="btn btn-primary">Gunakan Gambar</button>
            </div>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // 1. SWEETALERT TOAST
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

    // 2. FORM LOADING
    const forms = document.querySelectorAll('.form-proses');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            Swal.fire({
                title: 'Memproses...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => { Swal.showLoading(); }
            });
        });
    });

    // 3. DELETE CONFIRMATION
    const deleteButtons = document.querySelectorAll('.btn-hapus');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const variantName = this.getAttribute('data-name');
            const form = this.closest('form');
            Swal.fire({
                title: "Hapus Variant?",
                text: "Varian " + variantName + " akan dihapus beserta seluruh data stok sizenya!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
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
                    viewMode: 1
                });
            };
            reader.readAsDataURL(file);
        });
    });

    document.getElementById('btnCrop').addEventListener('click', function () {
        if (!cropper) return;
        const canvas = cropper.getCroppedCanvas({ width: 600, height: 600 });
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
