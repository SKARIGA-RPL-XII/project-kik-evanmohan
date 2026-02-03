@extends('layouts.aps')

@section('content')
<main class="main-content  mt-0">
    @if(session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            {{ $errors->first() }}
        </div>
    @endif

    <section>
        <div class="page-header min-vh-100">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-start">
                                <h4 class="font-weight-bolder">Selamat Datang</h4>
                                <p class="mb-0">Masukkan email dan kata sandi Anda untuk masuk</p>
                            </div>
                            <div class="card-body">
                                <form id="loginForm" method="POST" action="{{ route('login.post') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                                    </div>
                                    <div class="mb-3 position-relative">
                                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                                        <span id="togglePassword" style="position:absolute; top:50%; right:10px; cursor:pointer; transform:translateY(-50%);" title="Tampilkan/Sembunyikan Password">👁️</span>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                                        <label class="form-check-label" for="rememberMe">Remember me</label>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success w-100">Login</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-4 text-sm mx-auto">
                                    Apakah anda belum memiliki akun?
                                    <a href="{{ route('register') }}" class="text-primary text-gradient font-weight-bold">Register</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                        <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                            style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-ill.jpg'); background-size: cover;">
                            <span class="mask bg-gradient-primary opacity-6"></span>
                            <h4 class="mt-5 text-white font-weight-bolder position-relative">"Attention is the new currency"</h4>
                            <p class="text-white position-relative">The more effortless the writing looks, the more effort the writer actually put into the process.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('js')
<script>
const Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer);
    toast.addEventListener('mouseleave', Swal.resumeTimer);
  }
});

// ==========================
// Toggle Password (Mata)
// ==========================
const togglePassword = document.getElementById('togglePassword');
const passwordInput = document.querySelector('input[name="password"]');

togglePassword.addEventListener('click', () => {
    if(passwordInput.type === 'password'){
        passwordInput.type = 'text';
        togglePassword.textContent = '🙈'; // icon berubah
    } else {
        passwordInput.type = 'password';
        togglePassword.textContent = '👁️';
    }
});

// ==========================
// Throttle Login + Loading + Toast
// ==========================
let isSubmitting = false;
document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    if (isSubmitting) return;
    isSubmitting = true;

    const formData = new FormData(this);

    Swal.fire({title:"Loading...", didOpen:()=>Swal.showLoading(), allowOutsideClick:false});

    try {
        const res = await fetch("{{ route('login.post') }}", {
            method:'POST',
            headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'},
            body: formData
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
    } catch (err) {
        Swal.close();
        Toast.fire({icon:'error', title:'Terjadi kesalahan!'});
    }

    isSubmitting = false;
});
</script>
@endpush
