@extends('layouts.aps')

@section('content')
<main class="main-content mt-0">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
        style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signup-cover.jpg'); background-position: top;">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 text-center mx-auto">
                    <h1 class="text-white mb-2 mt-5">Selamat Datang Di Second Store🤙</h1>
                    <p class="text-lead text-white">Silakan isi data terlebih dahulu agar Anda dapat mengakses website kami.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                <div class="card z-index-0">
                    <div class="card-header text-center pt-4">
                        <h5>Register</h5>
                    </div>
                    <div class="card-body">
                        <form id="registerForm" method="POST" action="{{ route('register.post') }}">
                            @csrf
                            <div class="mb-3">
                                <input type="text" name="username" class="form-control" placeholder="Username" value="{{ old('username') }}" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="no_hp" class="form-control" placeholder="Nomor Hp" value="{{ old('no_hp') }}">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary w-100">Register</button>
                            </div>
                        </form>
                        <div class="card-footer text-center pt-0 px-lg-2 px-1">
                            <p class="mb-4 text-sm mx-auto">
                                Apakah anda sudah memiliki akun?
                                <a href="{{ route('login') }}" class="text-primary text-gradient font-weight-bold">Login</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

let isSubmitting = false;
document.getElementById('registerForm').addEventListener('submit', async function(e){
    e.preventDefault();
    if(isSubmitting) return;
    isSubmitting = true;

    const formData = new FormData(this);

    Swal.fire({title:"Loading...", didOpen:()=>Swal.showLoading(), allowOutsideClick:false});

    try {
        const res = await fetch("{{ route('register.post') }}", {
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
    } catch(err){
        Swal.close();
        Toast.fire({icon:'error', title:'Terjadi kesalahan!'});
    }

    isSubmitting = false;
});
</script>
@endpush
