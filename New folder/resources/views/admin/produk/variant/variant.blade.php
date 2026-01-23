@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

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

                                        <form action="{{ route('admin.variant.destroy', $v->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus varian {{ $v->warna }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Edit Variant -->
                                <div class="modal fade" id="modalEditVariant{{ $v->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.variant.update', $v->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5>Edit Variant</h5>
                                                    <button class="btn-close" data-bs-dismiss="modal"></button>
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
                                                            <input type="file" name="image" class="form-control">
                                                            @if($v->image)
                                                                <img src="{{ asset('storage/' . $v->image) }}" class="mt-2 rounded" width="100" height="100" style="object-fit: cover;">
                                                            @endif
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

<!-- Modal Tambah Variant -->
<div class="modal fade" id="modalTambahVariant" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.produk.variant.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Variant Baru</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Warna</label>
                            <input type="text" name="warna" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Harga</label>
                            <input type="number" name="harga" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Gambar Variant</label>
                            <input type="file" name="image" class="form-control">
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
@endsection
