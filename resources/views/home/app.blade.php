<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Second Store</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/0698b5b56f.js" crossorigin="anonymous"></script>

    <style>
        body {
            background-color: #fafafa;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding-top: 100px;
            color: #212529 !important;
        }

        :root {
            --grey: #6c757d;
            --dark-grey: #495057;
            --light-grey: #e9ecef;
        }

        /* NAVBAR WRAPPER */
        .navbar-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: linear-gradient(90deg, var(--grey), var(--dark-grey));
            color: #212529 !important;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        /* TOP NAVBAR */
        .top-navbar {
            width: 100%;
            padding: 8px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
        }

        .top-navbar a {
            color: #fff !important;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
        }

        .top-navbar a:hover {
            color: #000 !important;
        }

        .top-navbar span {
            margin: 0 5px;
            color: #fff;
        }

        /* PERBAIKAN DROPDOWN AKUN SAYA */
        .top-navbar .dropdown-menu a {
            color: #212529 !important;
            /* Warna teks item dropdown menjadi hitam/dark-grey */
        }

        .top-navbar .dropdown-menu a:hover {
            color: #fff !important;
            /* Warna teks saat hover */
            background-color: var(--dark-grey);
            /* Latar belakang saat hover */
        }

        .top-navbar .dropdown-menu .dropdown-divider {
            border-top-color: var(--light-grey);
        }
        /* END: PERBAIKAN DROPDOWN AKUN SAYA */

        /* MAIN NAVBAR */
        .main-navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 30px;
            width: 100%;
            max-width: 1200px;
        }

        .main-navbar .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .main-navbar .logo img {
            height: 45px;
        }

        .main-navbar .logo h4 {
            margin: 0;
            font-weight: bold;
            color: #fff;
        }

        .main-navbar .search-bar {
            flex: 1;
            margin: 0 20px;
            position: relative;
        }

        .main-navbar .search-bar input {
            width: 100%;
            padding: 10px 14px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .main-navbar .search-bar button {
            position: absolute;
            right: 3px;
            top: 3px;
            bottom: 3px;
            width: 45px;
            border: none;
            background: var(--dark-grey);
            color: #fff !important;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .icons {
            display: flex;
            align-items: center;
            gap: 20px;
            position: relative;
        }

        .icons a {
            text-decoration: none;
            color: #fff !important;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 12px;
        }

        .icons a:hover {
            color: #000 !important;
        }

        .icons .badge {
            background: red;
            color: #fff;
            font-size: 10px;
            font-weight: 600;
            position: absolute;
            top: -5px;
            right: -10px;
            padding: 2px 5px;
            border-radius: 50%;
        }

        /* ===================== */
        /* MINI CART DROPDOWN */
        /* ===================== */
        .cart-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            width: 420px;
            max-height: 520px;
            background: #fff;
            border-radius: 8px;
            /* ✅ KEMBALI: Defaultnya disembunyikan */
            display: none;

            flex-direction: column;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 3000;
            overflow: hidden;
        }

        /* ✅ KEMBALI: Menggunakan class 'active' untuk menampilkan saat hover (dipicu oleh JS) */
        .cart-dropdown.active {
            display: flex;
        }

        .cart-header {
            background: #f5f5f5;
            padding: 12px 15px;
            font-weight: 600;
            font-size: 14px;
            border-bottom: 1px solid #eee;
        }

        .cart-items {
            max-height: 350px;
            overflow-y: auto;
        }

        .cart-item {
            display: flex;
            gap: 12px;
            padding: 12px 15px;
            border-bottom: 1px solid #f2f2f2;
        }

        .cart-item img {
            width: 55px;
            height: 55px;
            border-radius: 6px;
            object-fit: cover;
        }

        .top-nav-cart {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
        }

        .cart-name {
            font-size: 13px;
            font-weight: 600;
            color: #333;
        }

        .cart-price {
            color: #000;
            font-size: 13px;
            font-weight: 600;
        }

        .cart-variant {
            color: #666;
            font-size: 13px;
            font-weight: 600;
        }

        .more-items {
            /* padding: 10px 15px; */
            font-size: 13px;
            color: #888;
        }

        .cart-footer {
            /* padding: 15px; */
            background: #fff;
            border-top: 1px solid #eee;
            text-align: center;
        }

        .bottom-modal-cart {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            border-top: 1px solid #eee;
        }

        .cart-footer button {
            background: var(--dark-grey);
            border: none;
            color: #fff;
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
        }

        /* ====================== */

        @media (max-width: 992px) {
            .main-navbar {
                flex-direction: column;
                gap: 10px;
            }

            .main-navbar .search-bar {
                width: 100%;
                margin: 0;
            }

            .main-navbar .icons {
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .top-navbar {
                flex-direction: column;
                gap: 3px;
                text-align: center;
            }

            .top-navbar div:first-child {
                flex-wrap: wrap;
                justify-content: center;
            }
        }

        .content {
            min-height: 70vh;
        }

        footer {
            margin-top: 50px;
            background: linear-gradient(90deg, var(--grey), var(--dark-grey));
            color: #fff !important;
            padding: 40px 0;
        }

        footer a {
            color: #fff !important;
            font-weight: 500;
            text-decoration: none;
        }

        footer a:hover {
            color: #000 !important;
        }
    </style>
</head>

<body>

    <nav class="navbar-wrapper">
        <div class="top-navbar container">
            <div class="d-flex flex-wrap align-items-center gap-2">
                <a href="#"><i class="bi bi-info-circle me-1"></i>Tentang Kami</a>
                <span>|</span>
                <a href="#"><i class="bi bi-question-circle me-1"></i>Bantuan</a>
                <span>|</span>
                <a href="#"><i class="bi bi-telephone me-1"></i>Hubungi Kami</a>
            </div>

            <div class="dropdown">
                @auth
                <a class="dropdown-toggle text-white d-flex align-items-center" href="#" id="userDropdown" role="button"
                    data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->username ?? 'Pengguna' }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a href="{{ route('profile.edit') ?? '#' }}" class="dropdown-item profil-dropdown">Akun Saya</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <form action="{{ route('logout') ?? '#' }}" method="POST" class="m-0 p-0">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </ul>
                @else
                <a href="{{ route('login') ?? '#' }}">Masuk</a> |
                <a href="{{ route('register') ?? '#' }}">Daftar</a>
                @endauth
            </div>
        </div>

        <div class="main-navbar container">
            <a href="{{ route('home') ?? '#' }}" class="logo">
                <img src="{{ asset('assets/images/logo.png') ?? '' }}" alt="Logo">
                <h4>Second Store</h4>
            </a>

            <div class="search-bar position-relative">
                <form action="{{ route('product.search') ?? '#' }}" method="GET">
                    <input type="text" name="search" placeholder="Cari produk..." required>
                    <button type="submit"><i class="bi bi-search"></i></button>
                </form>
            </div>

            <div class="icons">
                @auth
                <div class="position-relative">
                    <a href="{{ route('keranjang.index') ?? '#' }}" class="icon-link" id="cartIcon">
                        <i class="bi bi-cart3 fs-5"></i>
                        <span>Keranjang</span>
                        @if(isset($cartCount) && $cartCount > 0)
                        <span class="badge">{{ $cartCount }}</span>
                        @endif
                    </a>

                    <div class="cart-dropdown" id="cartDropdown">

                        @if(isset($cartItems) && count($cartItems) > 0)

                        <div class="cart-header">Baru Ditambahkan</div>

                        <div class="cart-items">
                            @foreach($cartItems as $item)
                            <div class="cart-item">
                                <img src="{{ $item->variant->image ? asset('storage/' . $item->variant->image) : asset('assets/images/default-product.png') }}"
                                    alt="Produk">

                                <div class="w-100">
                                    <div class="top-nav-cart">
                                        <div class="cart-name">
                                            {{ Str::limit($item->product->nama_produk, 40) }}
                                        </div>
                                        <div class="cart-price">
                                            Rp{{ number_format($item->variant->harga, 0, ',', '.') }}
                                        </div>
                                    </div>
                                    <div class="bottom-nav-cart">
                                        <div class="cart-variant">
                                            {{ $item->variant->warna }}, {{ $item->size->size }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="bottom-modal-cart">

                            <div class="more-items">
                                {{ count($cartItems) }} Produk Lainnya
                            </div>

                            <div class="cart-footer">
                                <button onclick="window.location.href='{{ route('keranjang.index') ?? '#' }}'">
                                    Tampilkan Keranjang Belanja
                                </button>
                            </div>
                        </div>

                        @else
                        <div class="p-3 text-center">Keranjang kosong</div>
                        @endif
                    </div>
                </div>

                <a href="{{ route('payment.index') ?? '#' }}" class="icon-link">
                    <i class="bi bi-clock-history fs-5"></i>
                    <span>Riwayat</span>
                </a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="content">
        @yield('content')
    </main>

    <footer>
        <div class="container">
            <div class="row text-start">
                <div class="col-md-3 mb-3">
                    <h6>INFORMASI</h6>
                    <a href="#">Tentang Kami</a><br>
                    <a href="#">Kebijakan Privasi</a><br>
                    <a href="#">Syarat & Ketentuan</a>
                </div>

                <div class="col-md-3 mb-3">
                    <h6>LAYANAN</h6>
                    <a href="#">Hubungi Kami</a><br>
                    <a href="#">Pengembalian Barang</a><br>
                    <a href="#">Bantuan</a>
                </div>

                <div class="col-md-3 mb-3">
                    <h6>EKSTRA</h6>
                    <a href="#">Promo</a><br>
                    <a href="#">Diskon</a><br>
                    <a href="#">Voucher</a>
                </div>

                <div class="col-md-3 mb-3">
                    <h6>AKUN</h6>
                    <a href="#">Akun Saya</a><br>
                    <a href="#">Keranjang</a><br>
                    <a href="#">Riwayat Belanja</a>
                </div>
            </div>

            <div class="text-center mt-4">
                &copy; {{ date('Y') }} Second Store
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle mini cart dropdown
        document.addEventListener('DOMContentLoaded', function () {
            const cartIcon = document.getElementById('cartIcon');
            const cartDropdown = document.getElementById('cartDropdown');

            // ✅ KEMBALI: Logika hover untuk membuka/menutup mini cart.
            if (cartIcon && cartDropdown) {
                cartIcon.addEventListener('mouseenter', () => cartDropdown.classList.add('active'));
                cartIcon.addEventListener('mouseleave', () => cartDropdown.classList.remove('active'));
                cartDropdown.addEventListener('mouseenter', () => cartDropdown.classList.add('active'));
                cartDropdown.addEventListener('mouseleave', () => cartDropdown.classList.remove('active'));
            }

            // Inisialisasi dropdown Bootstrap secara manual jika diperlukan (optional)
            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
            var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl)
            })
        });
    </script>

</body>

</html>
