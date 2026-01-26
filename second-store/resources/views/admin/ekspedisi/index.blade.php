@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')

<div class="container mt-4">

    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center"
            style="background-color:color:white; border-radius:8px 8px 0 0;">
            <h5 class="mb-0 fw-bold">Manajemen Ekspedisi</h5>

            <a href="#" class="btn text-white px-4"
                style="background-color:#ff855f; border-radius:8px;"
                data-bs-toggle="modal" data-bs-target="#addEkspedisiModal">
                + Tambah Ekspedisi
            </a>
        </div>

        <div class="card-body px-0 pt-0 pb-2">

            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0 text-sm">
                    <thead style="background-color:#f8fafc;">
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Ongkir</th>
                            <th>Tanggal Dibuat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($ekspedisis as $e)
                        <tr>
                            <td>{{ $e->kode_ekspedisi }}</td>
                            <td>{{ $e->nama }}</td>
                            <td>{{ $e->deskripsi }}</td>
                            <td>Rp {{ number_format($e->ongkir) }}</td>
                            <td>{{ $e->created_at->format('d/m/Y') }}</td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">

                                    {{-- EDIT --}}
                                    <button class="btn btn-warning btn-sm"
                                            style="border-radius:8px;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editEkspedisiModal{{ $e->id }}">
                                        Edit
                                    </button>

                                    {{-- HAPUS --}}
                                    <form action="{{ route('admin.ekspedisi.destroy', $e->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus ekspedisi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" style="border-radius:8px;">
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                        {{-- ==================== EDIT MODAL ==================== --}}
                        <div class="modal fade" id="editEkspedisiModal{{ $e->id }}">
                            <div class="modal-dialog">
                                <form class="modal-content"
                                      action="{{ route('admin.ekspedisi.update', $e->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Ekspedisi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        {{-- <label class="form-label">Kode Ekspedisi</label>
                                        <input type="text" name="kode_ekspedisi" class="form-control mb-2"
                                               value="{{ $e->kode_ekspedisi }}" required> --}}

                                        <label class="form-label">Nama</label>
                                        <input type="text" name="nama" class="form-control mb-2"
                                               value="{{ $e->nama }}" required>

                                        <label class="form-label">Deskripsi</label>
                                        <textarea name="deskripsi" class="form-control mb-2">{{ $e->deskripsi }}</textarea>

                                        <label class="form-label">Ongkir</label>
                                        <input type="number" name="ongkir" class="form-control mb-2"
                                               value="{{ $e->ongkir }}" required>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>
    </div>
</div>


{{-- ==================== TAMBAH EKSPEDISI MODAL ==================== --}}
<div class="modal fade" id="addEkspedisiModal">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('admin.ekspedisi.store') }}" method="POST">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title">Tambah Ekspedisi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                {{-- <label class="form-label">Kode Ekspedisi</label>
                <input type="text" name="kode_ekspedisi" class="form-control mb-2" required> --}}

                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control mb-2" required>

                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control mb-2"></textarea>

                <label class="form-label">Ongkir</label>
                <input type="number" name="ongkir" class="form-control mb-2" required>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

@endsection
