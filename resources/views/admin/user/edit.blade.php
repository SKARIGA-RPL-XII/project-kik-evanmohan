@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    <!-- Bagian Background Oranye -->
    <div class="min-height-100 border-radius-xl mt-4"
        style="background-image: url('{{ asset('assets/images/gambar.jpg') }}'); background-position-y: 50%;">
    </div>

    <!-- Card Profil -->
    <div class="card shadow-lg mx-4 card-profile-bottom profile-card-position">
        <div class="card-body p-3">
            <div class="row gx-4 align-items-center">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="{{ asset('assets/images/gambar.jpg') }}" alt="profile_image"
                            class="profile-image border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ auth()->user()->username ?? 'User' }}
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm text-secondary">
                            {{ auth()->user()->role ?? 'Customer' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert -->
    <div id="alert">
        @include('components.alert')
    </div>

    <!-- Konten Utama -->
    <div class="container-fluid py-4">
        <div class="row">
            <!-- Kartu Form Profil -->
            <div class="col-lg-8 mb-4">
                <div class="card h-100">
                    <form role="form" method="POST" action="{{ route('admin.user.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0 fw-bold">Edit Profile</p>
                                <button type="submit" class="btn btn-sm btn-primary ms-auto">Save</button>
                            </div>
                        </div>

                        <div class="card-body">
                            <p class="text-uppercase text-sm text-muted">User Information</p>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-control-label">Username</label>
                                    <input class="form-control" type="text" name="username"
                                        value="{{ old('username', auth()->user()->username) }}">
                                    @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-control-label">Email</label>
                                    <input class="form-control" type="email" name="email"
                                        value="{{ old('email', auth()->user()->email) }}">
                                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm text-muted">Contact Information</p>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-control-label">Nomor HP</label>
                                    <input class="form-control" type="text" name="no_hp"
                                        value="{{ old('no_hp', auth()->user()->no_hp) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-control-label">Alamat</label>
                                    <input class="form-control" type="text" name="alamat"
                                        value="{{ old('alamat', auth()->user()->alamat) }}">
                                </div>
                            </div>

                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm text-muted">Password</p>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-control-label">Password Baru</label>
                                    <input class="form-control" type="password" name="password">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-control-label">Konfirmasi Password</label>
                                    <input class="form-control" type="password" name="password_confirmation">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Kartu Info User -->
            <div class="col-lg-4">
                <div class="card card-profile h-100">
                    <img src="{{ asset('assets/images/gambar.jpg') }}" alt="Image placeholder"
                        class="card-img-top banner-crop">
                    <div class="row justify-content-center">
                        <div class="col-4 col-lg-4 order-lg-4">
                            <div class="mt-n4 d-flex justify-content-center">
                                <a href="javascript:;">
                                    <img src="{{ asset('assets/images/gambar.jpg') }}"
                                        class="profile-image img-fluid border-2 border-white" alt="Profile Picture">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-5 text-center">
                        <h5 class="fw-bold">{{ auth()->user()->username ?? 'User' }}</h5>
                        <p class="text-muted mb-2">{{ auth()->user()->email ?? 'example@mail.com' }}</p>
                        <p class="text-sm">
                            <i class="ni ni-mobile-button"></i> {{ auth()->user()->no_hp ?? 'Belum diisi' }}
                        </p>
                        <p class="text-sm">
                            <i class="ni ni-pin-3"></i> {{ auth()->user()->alamat ?? 'Belum diisi' }}
                        </p>
                        <div class="mt-3">
                            <a href="{{ route('admin.user.edit') }}" class="btn btn-sm btn-info">Edit Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>

    <style>
        .profile-card-position {
            margin-top: -80px !important;
            z-index: 10;
            position: relative;
        }

        .profile-image {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease;
        }

        .profile-image:hover {
            transform: scale(1.05);
        }

        .banner-crop {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .page-header {
            border-radius: 15px;
        }
    </style>
@endsection
