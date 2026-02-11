@extends('layouts.aps')

@push('css')
    <style>
        /* Animasi mengambang halus */
        @keyframes floatingCard {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }

        body {
            background: radial-gradient(circle, #f8fafc 0%, #cbd5e1 100%) !important;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        /* Container dibuat Full Width agar layout tidak terlihat kecil */
        .container-wide {
            width: 95%;
            max-width: 1400px;
            margin: auto;
            padding: 2rem 0;
        }

        .main-auth-container {
            background-color: #ffffff;
            border-radius: 2.5rem;
            overflow: hidden;
            border: none;
            /* Shadow lebih dalam untuk kesan mewah */
            box-shadow: 0 35px 70px -15px rgba(30, 41, 59, 0.4);
            animation: floatingCard 8s ease-in-out infinite;
            min-height: 750px; /* Membuat card lebih tinggi/besar */
        }

        /* Overlay Gradasi */
        .mask-grey {
            background: linear-gradient(135deg, rgba(51, 65, 85, 0.8) 0%, rgba(15, 23, 42, 0.9) 100%);
            position: absolute; width: 100%; height: 100%; top: 0; left: 0; z-index: 1;
        }

        .btn-dark-elegant {
            background-color: #1e293b;
            color: #fff;
            border-radius: 1rem;
            font-weight: 700;
            padding: 16px;
            font-size: 1.1rem;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-dark-elegant:hover {
            background-color: #0f172a;
            transform: scale(1.02);
            box-shadow: 0 15px 20px -5px rgba(0, 0, 0, 0.2);
        }

        .form-control-lg {
            border-radius: 1rem !important;
            padding: 1rem 1.2rem;
            border: 2px solid #f1f5f9;
            background-color: #f8fafc;
            font-size: 1.05rem;
        }

        .form-control-lg:focus {
            background-color: #fff;
            border-color: #64748b;
            box-shadow: 0 0 0 4px rgba(100, 116, 139, 0.1);
        }

        .form-label {
            margin-left: 5px;
            margin-bottom: 8px;
        }

        @media (max-width: 991.98px) {
            .main-auth-container {
                animation: none;
                min-height: auto;
                background-color: transparent;
                box-shadow: none;
            }
            .form-side {
                background-color: #ffffff;
                border-radius: 2.5rem;
                padding: 4rem 2rem !important;
                box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            }
        }
    </style>
@endpush

@section('content')
<div class="container-wide">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card main-auth-container">
                <div class="row g-0 h-100">

                    <div class="col-lg-5 d-flex flex-column justify-content-center p-5 p-xl-6 form-side">
                        <div class="mb-5">
                            <h2 class="display-5 font-weight-bold text-dark mb-2">Login</h2>
                            <p class="text-muted lead">Selamat datang kembali di <strong>Second Store</strong>.</p>
                        </div>

                        <form id="loginForm" method="POST" action="{{ route('login.post') }}">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label font-weight-bold text-dark">Alamat Email</label>
                                <input type="email" name="email" class="form-control form-control-lg" placeholder="nama@email.com" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label font-weight-bold text-dark">Password</label>
                                <div class="position-relative">
                                    <input type="password" name="password" id="passwordInput" class="form-control form-control-lg" placeholder="Masukkan password" required>
                                    <span id="togglePassword" style="position:absolute; top:50%; right:20px; cursor:pointer; transform:translateY(-50%); color: #64748b; z-index: 10;">
                                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M16 8s-3-5.5-8-5.5S0 8s0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                                    <label class="form-check-label text-muted" for="rememberMe">Ingat saya</label>
                                </div>
                                <a href="#" class="text-sm text-dark font-weight-bold">Lupa Password?</a>
                            </div>

                            <button type="submit" class="btn btn-dark-elegant w-100 shadow-lg">
                                Masuk Sekarang
                            </button>
                        </form>

                        <div class="text-center mt-5">
                            <p class="text-muted">
                                Belum memiliki akun? <a href="{{ route('register') }}" class="text-primary font-weight-bold">Daftar sekarang</a>
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-7 d-none d-lg-block">
                        <div class="h-100 p-4">
                            <div class="h-100 position-relative shadow-lg" style="background-image: url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=2070&auto=format&fit=crop'); background-size: cover; background-position: center; border-radius: 2rem; overflow: hidden;">
                                <span class="mask-grey"></span>
                                <div class="position-relative h-100 d-flex flex-column justify-content-center text-center p-5" style="z-index: 2;">
                                    <h1 class="text-white display-4 font-weight-bolder mb-3">Second Store</h1>
                                    <hr class="horizontal light mt-0 mb-4" style="width: 50px; border-top: 5px solid white; margin: auto; border-radius: 10px;">
                                    <p class="text-white lead px-5">"Pilih Barang Yang ingin Anda Beli Sebelum Stock Habis. Kualitas Bintang Lima, Harga Kaki Lima."</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });

        // Toggle Password
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('passwordInput');
        const eyeOpenSVG = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16"><path d="M16 8s-3-5.5-8-5.5S0 8s0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/></svg>`;
        const eyeClosedSVG = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16"><path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z"/><path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/><path d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8q.086.13.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z"/></svg>`;

        togglePassword.addEventListener('click', () => {
            const isPass = passwordInput.type === 'password';
            passwordInput.type = isPass ? 'text' : 'password';
            togglePassword.innerHTML = isPass ? eyeClosedSVG : eyeOpenSVG;
        });

        // Form Submit
        document.getElementById('loginForm').addEventListener('submit', async function (e) {
            e.preventDefault();
            Swal.fire({ title: "Memproses...", didOpen: () => Swal.showLoading(), allowOutsideClick: false });

            try {
                const res = await fetch("{{ route('login.post') }}", {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                    body: new FormData(this)
                });
                const data = await res.json();
                Swal.close();
                Toast.fire({ icon: data.status === 'success' ? 'success' : 'error', title: data.message });
                if (data.status === 'success') setTimeout(() => window.location.href = data.redirect, 1500);
            } catch (err) {
                Swal.close();
                Toast.fire({ icon: 'error', title: 'Terjadi kesalahan sistem!' });
            }
        });
    </script>
@endpush
