<!DOCTYPE html>
<html>

<head>
    <title>Toko Online</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('./argon/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('./argon/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('./argon/assets/css/argon-dashboard.css') }}" rel="stylesheet" />
</head>

<body>


    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="{{ asset('./argon/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('./argon/assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('./argon/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('./argon/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('./argon/assets/js/argon-dashboard.js') }}    "></script>
    @stack('js');
</body>

</html>
