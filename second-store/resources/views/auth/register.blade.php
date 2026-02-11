@extends('layouts.aps')

@push('css')
    <style>
        /* Animasi melayang */
        @keyframes floatingCard {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        body {
            background: radial-gradient(circle, #f8fafc 0%, #cbd5e1 100%) !important;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

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
            /* Shadow tebal sesuai permintaan sebelumnya */
            box-shadow: 0 40px 80px -15px rgba(15, 23, 42, 0.5),
                        0 20px 40px -20px rgba(0, 0, 0, 0.3);
            animation: floatingCard 8s ease-in-out infinite;
            min-height: 750px;
        }

        /* Overlay Gradasi untuk Gambar di Kanan */
        .mask-dark {
            background: linear-gradient(135deg, rgba(20, 20, 20, 0.8) 0%, rgba(0, 0, 0, 0.9) 100%);
            position: absolute; width: 100%; height: 100%; top: 0; left: 0; z-index: 1;
        }

        .btn-register-elegant {
            background-color: #5e72e4; /* Warna khas Argon agar tetap fresh */
            color: #fff;
            border-radius: 1rem;
            font-weight: 700;
            padding: 14px;
            font-size: 1.1rem;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-register-elegant:hover {
            background-color: #324cdd;
            transform: scale(1.02);
            box-shadow: 0 15px 20px -5px rgba(94, 114, 228, 0.4);
        }

        .form-control-lg {
            border-radius: 1rem !important;
            padding: 0.8rem 1.2rem;
            border: 2px solid #f1f5f9;
            background-color: #f8fafc;
            font-size: 0.95rem;
        }

        .form-control-lg:focus {
            background-color: #fff;
            border-color: #5e72e4;
            box-shadow: 0 0 0 4px rgba(94, 114, 228, 0.1);
        }

        @media (max-width: 991.98px) {
            .main-auth-container { animation: none; min-height: auto; background-color: transparent; box-shadow: none; }
            .form-side { background-color: #ffffff; border-radius: 2.5rem; padding: 3rem 2rem !important; box-shadow: 0 30px 60px rgba(0,0,0,0.15); }
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
                        <div class="mb-4">
                            <h2 class="display-5 font-weight-bold text-dark mb-1">Daftar Akun</h2>
                            <p class="text-muted">Silakan isi data untuk bergabung dengan <strong>Second Store</strong>.</p>
                        </div>

                        <form id="registerForm" method="POST" action="{{ route('register.post') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label font-weight-bold text-dark small ml-1">Username</label>
                                <input type="text" name="username" class="form-control form-control-lg" placeholder="Masukkan username" value="{{ old('username') }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label font-weight-bold text-dark small ml-1">Alamat Email</label>
                                <input type="email" name="email" class="form-control form-control-lg" placeholder="nama@email.com" value="{{ old('email') }}" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label font-weight-bold text-dark small ml-1">Password</label>
                                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label font-weight-bold text-dark small ml-1">Konfirmasi</label>
                                    <input type="password" name="password_confirmation" class="form-control form-control-lg" placeholder="Ulangi" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label font-weight-bold text-dark small ml-1">Nomor WhatsApp</label>
                                <input type="text" name="no_hp" class="form-control form-control-lg" placeholder="0812xxxx" value="{{ old('no_hp') }}">
                            </div>

                            <button type="submit" class="btn btn-register-elegant w-100 shadow-lg mb-3">
                                Register Sekarang
                            </button>
                        </form>

                        <div class="text-center">
                            <p class="text-muted small">
                                Sudah punya akun? <a href="{{ route('login') }}" class="text-primary font-weight-bold">Klik untuk Login</a>
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-7 d-none d-lg-block">
                        <div class="h-100 p-4">
                            <div class="h-100 position-relative shadow-lg" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signup-cover.jpg'); background-size: cover; background-position: center; border-radius: 2rem; overflow: hidden;">
                                <span class="mask-dark"></span>
                                <div class="position-relative h-100 d-flex flex-column justify-content-center text-center p-5" style="z-index: 2;">
                                    <h1 class="text-white display-4 font-weight-bolder mb-3">Second Store🤙</h1>
                                    <hr class="horizontal light mt-0 mb-4" style="width: 50px; border-top: 5px solid white; margin: auto; border-radius: 10px;">
                                    <p class="text-white lead px-5">"Daftarkan dirimu sekarang dan nikmati kemudahan berbelanja barang berkualitas dengan harga terbaik."</p>
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

    let isSubmitting = false;
    document.getElementById('registerForm').addEventListener('submit', async function(e){
        e.preventDefault();
        if(isSubmitting) return;
        isSubmitting = true;

        Swal.fire({title:"Mendaftarkan...", didOpen:()=>Swal.showLoading(), allowOutsideClick:false});

        try {
            const res = await fetch("{{ route('register.post') }}", {
                method:'POST',
                headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}', 'Accept':'application/json'},
                body: new FormData(this)
            });
            const data = await res.json();
            Swal.close();

            Toast.fire({
                icon: data.status === 'success' ? 'success' : 'error',
                title: data.message
            });

            if(data.status === 'success'){
                setTimeout(()=>window.location.href = data.redirect, 1500);
            }
        } catch(err){
            Swal.close();
            Toast.fire({icon:'error', title:'Terjadi kesalahan sistem!'});
        }
        isSubmitting = false;
    });
</script>
@endpush
