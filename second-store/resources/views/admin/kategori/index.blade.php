@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Manajemen Kategori</h6>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">
                        + Tambah Kategori
                    </button>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    @if (session('success'))
                        <div class="alert alert-success mx-3 mt-3">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th class="text-center">Tanggal Dibuat</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($kategoris as $kategori)
                                    <tr>
                                        <td>
                                            @if ($kategori->image)
                                                <img src="{{ asset('storage/' . $kategori->image) }}" width="70" class="rounded">
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>

                                        <td>{{ $kategori->nama_kategori }}</td>
                                        <td>{{ $kategori->deskripsi ?? '-' }}</td>
                                        <td class="text-center">{{ $kategori->created_at->format('d/m/Y') }}</td>

                                        <td class="text-center">
                                            <button class="btn btn-warning btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditKategori{{ $kategori->id }}">
                                                Edit
                                            </button>

                                            <form action="{{ route('admin.kategori.destroy', $kategori->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- MODAL EDIT -->
                                    <div class="modal fade" id="modalEditKategori{{ $kategori->id }}" tabindex="-1"
                                        aria-labelledby="editKategoriLabel{{ $kategori->id }}" aria-hidden="true">

                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Kategori</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <form action="{{ route('admin.kategori.update', $kategori->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Nama Kategori</label>
                                                            <input type="text" name="nama_kategori"
                                                                class="form-control"
                                                                value="{{ $kategori->nama_kategori }}" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Deskripsi</label>
                                                            <textarea name="deskripsi" class="form-control">{{ $kategori->deskripsi }}</textarea>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Gambar</label>
                                                            <input type="file" name="image" class="form-control">

                                                            @if ($kategori->image)
                                                                <img src="{{ asset('storage/' . $kategori->image) }}"
                                                                    class="img-thumbnail mt-2" width="120">
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>

                                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-3">
                                            Belum ada kategori.
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

    <!-- MODAL TAMBAH -->
    <div class="modal fade" id="modalTambahKategori" tabindex="-1"
        aria-labelledby="tambahKategoriLabel" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('admin.kategori.store') }}"
                    method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text" name="nama_kategori" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gambar</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection
