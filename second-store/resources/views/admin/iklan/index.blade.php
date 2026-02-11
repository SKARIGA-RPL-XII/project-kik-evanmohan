@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    .card-modern { border: none !important; border-radius: 16px !important; box-shadow: 0 4px 20px rgba(0,0,0,0.05) !important; background: #fff; }
    .form-control, .form-select { border-radius: 10px !important; padding: 12px 15px !important; border: 1px solid #e2e8f0 !important; background-color: #f8fafc !important; }

    /* IKLAN CARD */
    .iklan-card { border-radius: 15px; overflow: hidden; transition: all 0.3s ease; border: 1px solid #edf2f7; position: relative; }
    .iklan-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important; }
    .img-container { width: 100%; height: 180px; object-fit: cover; background: #f1f5f9; }

    .status-badge { position: absolute; top: 12px; right: 12px; font-size: 10px; font-weight: 800; padding: 5px 12px; border-radius: 50px; text-transform: uppercase; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }

    /* BUTTONS */
    .btn-custom-primary { background-color: #ff855f !important; color: white !important; border: none; border-radius: 10px; font-weight: 600; padding: 12px; transition: opacity 0.2s; }
    .btn-custom-primary:hover { opacity: 0.9; color: white; }

    /* PREVIEW BOX */
    #image-preview-container { display: none; width: 100%; border-radius: 10px; overflow: hidden; margin-top: 10px; border: 2px dashed #cbd5e1; }
</style>

<div class="container-fluid py-4">
    <div class="row g-4">
        {{-- SISI KIRI: FORM INPUT --}}
        <div class="col-lg-4">
            <div class="card card-modern sticky-top" style="top: 20px;">
                <div class="card-header bg-transparent pb-0 border-0">
                    <h5 class="fw-bold text-dark mb-1"><i class="bi bi-megaphone me-2 text-primary"></i>Upload Iklan</h5>
                    <p class="text-sm text-muted">Promosikan produk terbaru Anda di sini.</p>
                </div>
                <div class="card-body pt-0">
                    <form action="{{ route('admin.iklan.store') }}" method="POST" enctype="multipart/form-data" id="formIklan">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold text-xs text-uppercase">Judul Banner</label>
                            <input type="text" name="judul" class="form-control shadow-none" placeholder="Promo Akhir Tahun..." required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-xs text-uppercase">File Banner</label>
                            <input type="file" name="gambar" id="inputGambar" class="form-control shadow-none" accept="image/*" required>
                            <div id="image-preview-container">
                                <img id="image-preview" src="#" alt="Preview" style="width: 100%; height: auto;">
                            </div>
                            <small class="text-muted text-xxs mt-2 d-block text-italic">*Rekomendasi aspek rasio 2:1 (Landscape)</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-xs text-uppercase">Status</label>
                            <select name="status" class="form-select shadow-none" required>
                                <option value="ACTIVE">Langsung Aktifkan</option>
                                <option value="INACTIVE">Simpan sebagai Draft</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-custom-primary w-100 shadow-none">
                            <i class="bi bi-cloud-arrow-up-fill me-2"></i>Publikasikan Banner
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- SISI KANAN: LIST KONTEN --}}
        <div class="col-lg-8">
            <div class="card card-modern">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center border-0">
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Aktifitas Iklan</h5>
                        <p class="text-xs text-muted mb-0">Total {{ $iklans->count() }} banner tersedia</p>
                    </div>
                </div>

                <div class="card-body">
                    @if($iklans->count())
                        <div class="row g-3">
                            @foreach($iklans as $iklan)
                            <div class="col-md-6">
                                <div class="iklan-card bg-white shadow-sm">
                                    <img src="{{ asset('storage/' . $iklan->gambar) }}" class="img-container">

                                    {{-- Status Badge --}}
                                    <span class="status-badge {{ $iklan->status == 'ACTIVE' ? 'bg-success text-white' : 'bg-secondary text-white' }}">
                                        {{ $iklan->status }}
                                    </span>

                                    <div class="p-3">
                                        <h6 class="fw-bold mb-1 text-truncate">{{ $iklan->judul }}</h6>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <span class="text-muted text-xxs">
                                                <i class="bi bi-clock me-1"></i> {{ $iklan->created_at->diffForHumans() }}
                                            </span>

                                            <div class="btn-group">
                                                <form action="{{ route('admin.iklan.destroy', $iklan->id) }}" method="POST" class="m-0">
                                                    @csrf @method('DELETE')
                                                    <button type="button" class="btn btn-link text-danger p-0 btn-hapus" data-judul="{{ $iklan->judul }}">
                                                        <i class="bi bi-trash3-fill fs-6"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <img src="https://illustrations.popsy.co/gray/not-found.svg" style="width: 140px;" class="mb-3 opacity-6">
                            <p class="text-muted text-sm">Belum ada banner promosi yang diunggah.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Preview Gambar Instan
        const inputGambar = document.getElementById('inputGambar');
        const previewContainer = document.getElementById('image-preview-container');
        const previewImage = document.getElementById('image-preview');

        inputGambar.onchange = evt => {
            const [file] = inputGambar.files;
            if (file) {
                previewImage.src = URL.createObjectURL(file);
                previewContainer.style.display = 'block';
            }
        }

        // SweetAlert Konfirmasi Hapus
        document.querySelectorAll('.btn-hapus').forEach(btn => {
            btn.addEventListener('click', function() {
                const judul = this.getAttribute('data-judul');
                const form = this.closest('form');

                Swal.fire({
                    title: 'Hapus Banner?',
                    text: `Konten "${judul}" akan dihapus permanen!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#f5365c',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Loading saat submit form
        document.getElementById('formIklan').addEventListener('submit', function() {
            Swal.fire({
                title: 'Sedang Mengunggah...',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });
        });
    });
</script>
@endsection
