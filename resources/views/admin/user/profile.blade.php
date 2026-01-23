@extends('layouts.navbar.auth.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    <!-- Bagian Background Oranye -->
    <div class="min-height-100 border-radius-xl mt-4"
        style="background-image: url('{{ asset('assets/images/gambar.jpg') }}'); background-position-y: 50%;">
    </div>

    <!-- Card Profil Naik ke Area Oranye -->
    <div class="card shadow-lg mx-4 card-profile-bottom profile-card-position">
        <div class="card-body p-3">
            <div class="row gx-4 align-items-center">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('assets/images/gambar.jpg') }}"
                            alt="profile_image" class="profile-image border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ auth()->user()->firstname ?? 'Firstname' }} {{ auth()->user()->lastname ?? 'Lastname' }}
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm text-secondary">
                            Public Relations
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                    <div class="nav-wrapper position-relative end-0">
                        <ul class="nav nav-pills nav-fill p-1" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active d-flex align-items-center justify-content-center"
                                    data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="true">
                                    <i class="ni ni-app"></i>
                                    <span class="ms-2">App</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center justify-content-center" data-bs-toggle="tab"
                                    href="javascript:;" role="tab" aria-selected="false">
                                    <i class="ni ni-email-83"></i>
                                    <span class="ms-2">Messages</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center justify-content-center" data-bs-toggle="tab"
                                    href="javascript:;" role="tab" aria-selected="false">
                                    <i class="ni ni-settings-gear-65"></i>
                                    <span class="ms-2">Settings</span>
                                </a>
                            </li>
                        </ul>
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
                    <form role="form" method="POST" action="{{ route('admin.profile') }}" enctype="multipart/form-data">
                        @csrf
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
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-control-label">Email address</label>
                                    <input class="form-control" type="email" name="email"
                                        value="{{ old('email', auth()->user()->email) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-control-label">First name</label>
                                    <input class="form-control" type="text" name="firstname"
                                        value="{{ old('firstname', auth()->user()->firstname) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-control-label">Last name</label>
                                    <input class="form-control" type="text" name="lastname"
                                        value="{{ old('lastname', auth()->user()->lastname) }}">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-control-label">Profile Picture</label>
                                <input type="file" name="photo" class="form-control">
                            </div>

                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm text-muted">Contact Information</p>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-control-label">Address</label>
                                    <input class="form-control" type="text" name="address"
                                        value="{{ old('address', auth()->user()->address) }}">
                                </div>
                            </div>

                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm text-muted">About me</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-control-label">About me</label>
                                    <textarea class="form-control" name="about"
                                        rows="3">{{ old('about', auth()->user()->about) }}</textarea>
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
                                    <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('assets/images/gambar.jpg') }}"
                                        class="profile-image img-fluid border-2 border-white" alt="Profile Picture">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-5 text-center">
                        <h5 class="fw-bold">
                            {{ auth()->user()->firstname ?? 'Firstname' }} {{ auth()->user()->lastname ?? 'Lastname' }}
                        </h5>
                        <p class="text-muted mb-2">
                            {{ auth()->user()->address ?? 'Malang, Indonesia' }}
                        </p>
                        <p class="text-sm">
                            <i class="ni business_briefcase-24 mr-2"></i> Solution Manager - Creative Tim
                        </p>
                        <p class="text-sm">
                            <i class="ni education_hat mr-2"></i> University of Racing
                        </p>
                        <div class="mt-3">
                            <a href="javascript:;" class="btn btn-sm btn-info">Connect</a>
                            <a href="javascript:;" class="btn btn-sm btn-dark">Message</a>
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
