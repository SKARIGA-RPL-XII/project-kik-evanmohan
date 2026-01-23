@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    <style>
        .carousel-img {
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>

    <div class="container mt-4">

        <!-- ============================= -->
        <!--        FORM TAMBAH IKLAN      -->
        <!-- ============================= -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <strong>Tambah Iklan Baru</strong>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.iklan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Judul Iklan</label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gambar Iklan</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pilih Produk (Opsional)</label>
                        <select name="product_id" class="form-select">
                            <option value="">-- Tanpa Produk --</option>
                            @foreach($produk as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_produk }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Status Iklan</label>
                        <select name="status" class="form-select" required>
                            <option value="ACTIVE">Aktif</option>
                            <option value="INACTIVE">Tidak Aktif</option>
                        </select>
                    </div>


                    <button class="btn btn-primary">Simpan Iklan</button>
                </form>
            </div>
        </div>

        <!-- ============================= -->
        <!--      PREVIEW CAROUSEL IKLAN   -->
        <!-- ============================= -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <strong>Preview Carousel</strong>
            </div>
            <div class="card-body">
                @if ($iklans->count() > 0)
                    <div id="iklanCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($iklans as $key => $iklan)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $iklan->gambar) }}" class="d-block w-100 carousel-img">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>{{ $iklan->judul }}</h5>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#iklanCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#iklanCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                @else
                    <p class="text-muted">Belum ada iklan tersedia</p>
                @endif
            </div>
        </div>

        <!-- ============================= -->
        <!--       LIST IKLAN (TABLE)      -->
        <!-- ============================= -->
        <div class="card">
            <div class="card-header bg-dark text-white">
                <strong>Daftar Semua Iklan</strong>
            </div>
            <div class="card-body">
                @if($iklans->count())
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Gambar</th>
                                <th>Judul</th>
                                <th>Produk Terkait</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($iklans as $iklan)
                                <tr>
                                    <td width="120">
                                        <img src="{{ asset('storage/' . $iklan->gambar) }}" width="100" class="rounded">
                                    </td>
                                    <td>{{ $iklan->judul }}</td>
                                    <td>
                                        @if($iklan->product)
                                            <span class="badge bg-success">
                                                {{ $iklan->product->nama_produk }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">Tidak Ada</span>
                                        @endif
                                    </td>
                                    <td width="150">
                                        <form action="{{ route('admin.iklan.destroy', $iklan->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                @else
                    <p class="text-muted text-center">Belum ada iklan</p>
                @endif
            </div>
        </div>

    </div>
@endsection
