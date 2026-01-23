@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="row mt-4 mx-4">
    <div class="col-12">

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5>Variant: <strong>{{ $variant->warna }}</strong></h5>
                    <small class="text-muted">Produk: {{ $variant->product->nama_produk }}</small>
                </div>

                <div>
                    <a href="{{ route('admin.produk.variant.index', $variant->product->id) }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali ke Variant
                    </a>
                </div>
            </div>

            <div class="card-body">

                <div class="row mb-4">
                    <div class="col-md-4">
                        <img src="{{ $variant->image ? asset('storage/' . $variant->image) : asset('argon/assets/img/default-product.png') }}"
                             class="img-fluid rounded" style="object-fit: cover;">
                    </div>
                    <div class="col-md-8">
                        <h5>Harga: Rp {{ number_format($variant->harga, 0, ',', '.') }}</h5>
                        <h6>Total Stok: {{ $variant->sizes->sum('stok') }}</h6>
                    </div>
                </div>

                <div class="mb-3">
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahSize">
                        + Tambah Size
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th>Size</th>
                                <th>Stok</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($variant->sizes as $size)
                                <tr>
                                    <td>{{ $size->size }}</td>
                                    <td>{{ $size->stok }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditSize{{ $size->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="{{ route('admin.variant.size.destroy', $size->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus size ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Edit Size -->
                                <div class="modal fade" id="modalEditSize{{ $size->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.variant.size.update', $size->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5>Edit Size</h5>
                                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Size</label>
                                                        <input type="text" name="size" class="form-control" value="{{ $size->size }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Stok</label>
                                                        <input type="number" name="stok" class="form-control" value="{{ $size->stok }}" required>
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

                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">Belum ada size untuk variant ini</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</div>

<!-- Modal Tambah Size -->
<div class="modal fade" id="modalTambahSize" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.variant.size.store', $variant->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5>Tambah Size untuk {{ $variant->warna }}</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Size</label>
                        <input type="text" name="size" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
