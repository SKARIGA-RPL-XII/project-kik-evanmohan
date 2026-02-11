<!DOCTYPE html>
<html>
<head>
    <title>Toko Online</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="{{ asset('./argon/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('./argon/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{ asset('./argon/assets/css/argon-dashboard.css') }}" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="container mt-5">
    @yield('content')
</div>

<script src="{{ asset('./argon/assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('./argon/assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('./argon/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('./argon/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
<script>
var win = navigator.platform.indexOf('Win') > -1;
if (win && document.querySelector('#sidenav-scrollbar')) {
    var options = { damping: '0.5' }
    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
}
</script>
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="{{ asset('./argon/assets/js/argon-dashboard.js') }}"></script>

@stack('js')
</body>
</html>
