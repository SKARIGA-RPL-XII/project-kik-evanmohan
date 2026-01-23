@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<!-- CropperJS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Manajemen Produk</h6>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahProduk">
                    + Tambah Produk
                </button>
            </div>

            <div class="card-body px-0 pt-0 pb-2">
                @if (session('success'))
                    <div class="alert alert-success mx-3 mt-3">{{ session('success') }}</div>
                @endif

                <div class="table-responsive p-3">
                    <table class="table table-hover align-items-center mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Gambar</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Total Varian</th>
                                <th class="text-center">Tanggal Dibuat</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($products as $p)
                                <tr>
                                    <td>
                                        <img src="{{ $p->image ? asset('storage/' . $p->image) : asset('argon/assets/img/default-product.png') }}"
                                             class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                    </td>
                                    <td>{{ $p->nama_produk }}</td>
                                    <td>{{ $p->kategori->nama_kategori ?? '-' }}</td>
                                    <td>{{ $p->variants->count() }} varian</td>
                                    <td class="text-center">{{ $p->created_at->format('d/m/Y') }}</td>
                                    <td class="text-center d-flex justify-content-center">
                                        <a href="{{ route('admin.produk.variant.index', $p->id) }}"
                                           class="btn btn-success btn-sm mx-1">
                                           <i class="bi bi-sliders"></i> Kelola Variant
                                        </a>

                                        <button class="btn btn-warning btn-sm mx-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEditProduk{{ $p->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <form action="{{ route('admin.produk.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm mx-1">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Edit Produk -->
                                <div class="modal fade" id="modalEditProduk{{ $p->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Produk</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <form action="{{ route('admin.produk.update', $p->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Nama Produk</label>
                                                            <input type="text" name="nama_produk" class="form-control" value="{{ $p->nama_produk }}" required>
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Kategori</label>
                                                            <select name="kategori_id" class="form-control" required>
                                                                @foreach ($kategoris as $k)
                                                                    <option value="{{ $k->id }}" {{ $p->kategori_id == $k->id ? 'selected' : '' }}>
                                                                        {{ $k->nama_kategori }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Gambar Produk</label>
                                                            <input type="file" name="image" class="form-control image-cropper-input">
                                                            @if ($p->image)
                                                                <img src="{{ asset('storage/' . $p->image) }}" class="mt-2 rounded" style="width:80px; height:80px; object-fit:cover;">
                                                            @endif
                                                        </div>

                                                        <div class="col-12 mb-3">
                                                            <label class="form-label">Deskripsi</label>
                                                            <textarea name="deskripsi" class="form-control" rows="3">{{ $p->deskripsi }}</textarea>
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
                                    <td colspan="8" class="text-center text-muted py-4">Belum ada produk.</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Produk -->
<div class="modal fade" id="modalTambahProduk" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" name="nama_produk" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="kategori_id" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategoris as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Gambar Produk</label>
                            <input type="file" name="image" class="form-control image-cropper-input">
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Simpan</button>
                </div>

            </form>
        </div>
    </div>
</div>


<!-- =============================== -->
<!-- MODAL CROP GAMBAR -->
<!-- =============================== -->
<div class="modal fade" id="modalCropImage" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Crop Gambar Produk</h5>
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


<!-- =============================== -->
<!-- SCRIPT CROP GAMBAR -->
<!-- =============================== -->
<script>
let cropper;
let targetInput;

// SEMUA INPUT FILE DIAMBIL
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
                viewMode: 1,
                autoCropArea: 1,
                movable: true,
                zoomable: true
            });
        };
        reader.readAsDataURL(file);
    });
});

document.getElementById('btnCrop').addEventListener('click', function () {
    if (!cropper) return;

    const canvas = cropper.getCroppedCanvas({
        width: 600,
        height: 600
    });

    canvas.toBlob(blob => {
        const croppedFile = new File([blob], "cropped.jpg", { type: "image/jpeg" });

        const dt = new DataTransfer();
        dt.items.add(croppedFile);
        targetInput.files = dt.files;

        bootstrap.Modal.getInstance(document.getElementById('modalCropImage')).hide();
    }, "image/jpeg", 0.9);
});
</script>

@endsection
