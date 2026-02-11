@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 shadow-sm border-0">
                {{-- HEADER --}}
                <div class="card-header pb-0 d-flex justify-content-between align-items-center bg-white">
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">Manajemen User</h5>
                        <p class="text-sm mb-0 text-muted">Kelola hak akses, peran, dan informasi pengguna sistem Anda.</p>
                    </div>
                    <button class="btn btn-primary btn-sm btn-round shadow-none mb-0" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
                        <i class="fas fa-plus me-1"></i> Tambah User
                    </button>
                </div>

                {{-- TABLE BODY --}}
                <div class="card-body px-0 pt-0 pb-2 mt-3">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 table-hover">
                            <thead class="bg-light text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                <tr>
                                    <th class="ps-4">Pengguna</th>
                                    <th class="ps-2">Role</th>
                                    <th class="text-center">Tanggal Registrasi</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="position-relative">
                                                    <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('img/default-avatar.png') }}"
                                                         class="avatar avatar-md rounded-circle border shadow-sm"
                                                         style="object-fit: cover;">
                                                </div>
                                                <div class="ms-3">
                                                    <h6 class="mb-0 text-sm font-weight-bold text-dark">{{ $user->username }}</h6>
                                                    <p class="text-xs text-muted mb-0">{{ $user->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm {{ $user->role == 'admin' ? 'bg-gradient-primary' : 'bg-gradient-info' }} px-3">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-secondary text-xs">{{ $user->created_at->format('d M Y') }}</span>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="btn-group shadow-none">
                                                {{-- EDIT --}}
                                                <button class="btn btn-link text-warning px-2 mb-0"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalEditUser{{ $user->id }}" title="Edit User">
                                                    <i class="bi bi-pencil-square text-lg"></i>
                                                </button>

                                                {{-- DELETE --}}
                                                @if(auth()->id() !== $user->id) {{-- Agar tidak menghapus diri sendiri --}}
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline form-hapus">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-link text-danger px-2 mb-0 btn-hapus" title="Hapus User">
                                                        <i class="bi bi-trash text-lg"></i>
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- MODAL EDIT USER --}}
                                    <div class="modal fade" id="modalEditUser{{ $user->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow-lg">
                                                <div class="modal-header">
                                                    <h6 class="modal-title font-weight-bold">Edit Pengguna</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('users.update', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label text-xs font-weight-bold">Username</label>
                                                            <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label text-xs font-weight-bold">Email</label>
                                                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label text-xs font-weight-bold">Role</label>
                                                            <select name="role" class="form-control">
                                                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label text-xs font-weight-bold">Password Baru (Kosongkan jika tidak ganti)</label>
                                                            <input type="password" name="password" class="form-control" placeholder="********">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-link text-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary shadow-none">Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <i class="bi bi-people text-secondary d-block text-xl mb-2"></i>
                                            <span class="text-secondary text-sm font-weight-bold">Belum ada user terdaftar.</span>
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

{{-- MODAL TAMBAH USER --}}
<div class="modal fade" id="modalTambahUser" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header">
                <h6 class="modal-title font-weight-bold">Daftarkan User Baru</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-xs font-weight-bold">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Contoh: budi_admin" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-xs font-weight-bold">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="email@domain.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-xs font-weight-bold">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-xs font-weight-bold">Pilih Role</label>
                        <select name="role" class="form-control" required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link text-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary shadow-none">Simpan User</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SCRIPTS --}}
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

        // DELETE CONFIRMATION
        document.querySelectorAll('.btn-hapus').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form');
                Swal.fire({
                    title: "Hapus User?",
                    text: "User ini tidak akan bisa login kembali!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#f5365c",
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>

<style>
    .avatar-md { width: 45px; height: 45px; }
    .btn-round { border-radius: 50px; }
    .text-lg { font-size: 1.1rem !important; }
    .form-control:focus { border-color: #5e72e4; box-shadow: none; }
</style>
@endsection
