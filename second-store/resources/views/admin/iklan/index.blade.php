@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    /* --- EFEK ULTRA BLUR SAAT MODAL (Opsional jika kedepan pakai modal) --- */
    body.modal-open #sidenav-main, body.modal-open .main-content {
        filter: blur(15px);
        transition: filter 0.3s ease;
    }

    /* --- LAYOUT STYLE --- */
    .card-modern {
        border: none !important;
        border-radius: 16px !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05) !important;
        background: #fff;
    }

    .form-control, .form-select {
        border-radius: 10px !important;
        padding: 12px 15px !important;
        border: 1px solid #e2e8f0 !important;
        background-color: #f8fafc !important;
    }

    /* --- IKLAN CARD ITEM (PENGGANTI TABEL) --- */
    .iklan-card {
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
        border: 1px solid #edf2f7;
    }

    .iklan-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important;
    }

    .img-container {
        width: 100%;
        height: 160px;
        object-fit: cover;
        border-bottom: 1px solid #edf2f7;
    }

    .status-pill {
        font-size: 10px;
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 0.5px;
        padding: 5px 12px;
        border-radius: 20px;
    }

    /* --- BUTTONS --- */
    .btn-custom-primary {
        background-color: #ff855f !important;
        color: white !important;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        padding: 12px;
    }

    .btn-outline-danger-custom {
        color: #dc3545;
        border: 1px solid #dc3545;
        background: transparent;
        border-radius: 8px;
        font-size: 13px;
        padding: 6px 12px;
        transition: all 0.2s;
    }

    .btn-outline-danger-custom:hover {
        background: #dc3545;
        color: white;
    }
</style>

<div class="container-fluid py-4">
    <div class="row g-4">

        <div class="col-lg-4 col-md-5">
            <div class="card card-modern h-100">
                <div class="card-header bg-transparent pb-0 border-0">
                    <h5 class="fw-bold text-dark mb-1">Upload Iklan</h5>
                    <p class="text-sm text-muted">Tambahkan banner promosi baru ke aplikasi.</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.iklan.store') }}" method="POST" enctype="multipart/form-data" id="formIklan">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold text-xs text-uppercase">Judul Banner</label>
                            <input type="text" name="judul" class="form-control" placeholder="Masukkan judul iklan..." required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-xs text-uppercase">File Gambar</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*" required>
                            <small class="text-muted text-xs mt-1 d-block">*Rekomendasi ukuran: 1200 x 600 px</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-xs text-uppercase">Status Tayang</label>
                            <select name="status" class="form-select" required>
                                <option value="ACTIVE">Aktif Sekarang</option>
                                <option value="INACTIVE">Simpan Sebagai Draft</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-custom-primary w-100 shadow-sm">
                            <i class="bi bi-plus-lg me-2"></i>Simpan & Publikasikan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8 col-md-7">
            <div class="card card-modern h-100">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center border-0">
                    <h5 class="fw-bold text-dark mb-0">Manajemen Konten Iklan</h5>
                    <span class="badge bg-soft-primary text-primary px-3 py-2" style="background:#e0e7ff;">{{ $iklans->count() }} Total</span>
                </div>

                <div class="card-body">
                    @if($iklans->count())
                        <div class="row g-3">
                            @foreach($iklans as $iklan)
                            <div class="col-xl-6 col-12">
                                <div class="iklan-card bg-white">
                                    <img src="{{ asset('storage/' . $iklan->gambar) }}" class="img-container">
                                    <div class="p-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="fw-bold mb-0 text-truncate" style="max-width: 70%;">{{ $iklan->judul }}</h6>
                                            <span class="status-pill {{ $iklan->status == 'ACTIVE' ? 'bg-success text-white' : 'bg-secondary text-white' }}">
                                                {{ $iklan->status }}
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <small class="text-muted text-xs">
                                                <i class="bi bi-calendar3 me-1"></i> {{ $iklan->created_at->format('d/m/Y') }}
                                            </small>

                                            <form action="{{ route('admin.iklan.destroy', $iklan->id) }}" method="POST" class="m-0">
                                                @csrf @method('DELETE')
                                                <button type="button" class="btn-outline-danger-custom btn-hapus" data-judul="{{ $iklan->judul }}">
                                                    <i class="bi bi-trash3 me-1"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <img src="https://illustrations.popsy.co/gray/not-found.svg" style="width: 150px;" class="mb-3">
                            <p class="text-muted">Belum ada konten iklan yang ditambahkan.</p>
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
        // SweetAlert Konfirmasi Hapus
        document.querySelectorAll('.btn-hapus').forEach(btn => {
            btn.addEventListener('click', function() {
                const judul = this.getAttribute('data-judul');
                const form = this.closest('form');

                Swal.fire({
                    title: 'Hapus Iklan?',
                    text: `Konten "${judul}" akan dihapus permanen!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
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
                title: 'Sedang Memproses...',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });
        });
    });
</script>
@endsection
