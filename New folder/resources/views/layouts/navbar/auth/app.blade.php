<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('argon/assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('argon/assets/img/favicon.png') }}">
    <title>Toko Online</title>

    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <!-- Argon CSS -->
    <link href="{{ asset('argon/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('argon/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link id="pagestyle" href="{{ asset('argon/assets/css/argon-dashboard.css') }}" rel="stylesheet" />
</head>

<body class="{{ $class ?? '' }}">

    {{-- TAMBAHAN: FULLSCREEN LOADER --}}
    <div id="globalLoader">
        <div class="loader-wrapper">
            <div class="spinner-border text-light" style="width: 3rem; height: 3rem" role="status"></div>
            <div class="loader-text">Loading...</div>
        </div>
    </div>

    <style>
        #globalLoader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(5px);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            z-index: 999999;
            opacity: 1;
            transition: opacity .4s ease;
        }

        #globalLoader.hide {
            opacity: 0;
            pointer-events: none;
        }

        .loader-wrapper {
            text-align: center;
            animation: fadeIn .4s ease;
        }

        .loader-text {
            margin-top: 12px;
            color: #fff;
            font-size: 18px;
            font-weight: 500;
            letter-spacing: 1px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <script>
        /* Loader hilang setelah halaman selesai */
        window.addEventListener("load", () => {
            setTimeout(() => {
                document.getElementById("globalLoader").classList.add("hide");
            }, 300);
        });

        /* Loader muncul ketika klik link pindah halaman */
        document.addEventListener("DOMContentLoaded", () => {
            const links = document.querySelectorAll("a:not([target='_blank'])");

            links.forEach(link => {
                link.addEventListener("click", function () {
                    const href = this.getAttribute("href");

                    if (!href || href.startsWith("#") || href.startsWith("javascript")) return;

                    document.getElementById("globalLoader").classList.remove("hide");
                });
            });
        });
    </script>

    {{-- END LOADER --}}

    {{-- BAGIAN TAMPILAN UNTUK GUEST --}}
    @guest
        @yield('content')
    @endguest

    {{-- BAGIAN UNTUK USER LOGIN --}}
    @auth
        @if (in_array(request()->route()->getName(), ['login', 'register', 'sign-in-static', 'sign-up-static']))
            @yield('content')
        @else
            <div class="min-height-300 bg-primary position-absolute w-100"></div>

            @if (auth()->user()->role === 'admin')
                @include('layouts.navbar.auth.sidenav')
            @endif

            <main class="main-content border-radius-lg">
                @include('layouts.navbar.auth.topnav')
                <div class="container-fluid py-4">
                    @yield('content')
                </div>
            </main>

            @include('components.fixed-plugin')
        @endif
    @endauth

    <!-- Core JS -->
    <script src="{{ asset('argon/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('argon/assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('argon/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('argon/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>

    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = { damping: '0.5' }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>

    <script src="{{ asset('argon/assets/js/argon-dashboard.js') }}"></script>
    @stack('js')
</body>

</html>
