<aside
    class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 backdrop:blur shadow-lg"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('admin.dashboard') }}">
            <img src="public/argon/assets/img/logo.me.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">Second Store🤙</span>
        </a>
        <hr class="horizontal dark mt-0">
        <div class="collapse navbar-collapse h-auto w-auto " id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}"
                        href="{{ route('admin.dashboard') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
                {{-- <li class="nav-item mt-3 d-flex align-items-center">
                    <div class="ps-4">
                        <i class="fab fa-laravel" style="color: #f4645f;"></i>
                    </div>
                    <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Laravel Examples</h6>
                </li> --}}
                {{-- <li class="nav-item">
                    {{-- <a class="nav-link {{ Route::currentRouteName() == 'profile' ? 'active' : '' }}"
                        href="{{ route('profile') }}"> --}}
                        {{-- <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Profile</span>
                    </a>
                </li> --}}
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Pages</h6>
                </li>

                {{-- <li class="nav-item">
                    <a class="nav-link {{  str_contains(request()->url(), 'billing') == true ? 'active' : '' }}"
                        href="{{ route('admin.billing', ['page' => 'billing']) }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Billing</span>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link {{ str_contains(request()->url(), 'kategori') == true ? 'active' : '' }}"
                        href="{{ route('admin.kategori.index', ['page' => 'kategori']) }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-app text-info text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Category</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('produk.index') ? 'active' : '' }}"
                        href="{{ route('admin.produk.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-box-2 text-success text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Products</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('admin/ekspedisi*') ? 'active' : '' }}"
                        href="{{ route('admin.ekspedisi.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-delivery-fast text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Ekspedisi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'admin.payment.index' ? 'active' : '' }}"
                        href="{{ route('admin.payment.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-credit-card text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Metode Pembayaran</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'admin.bukti') ? 'active' : '' }}"
                        href="{{ route('admin.bukti.index') }}">

                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-single-copy-04 text-info text-sm opacity-10"></i>
                        </div>

                        <span class="nav-link-text ms-1">Bukti Pembayaran</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'admin.orders.index' ? 'active' : '' }}"
                        href="{{ route('admin.orders.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-bullet-list-67 text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Manajemen Order</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'admin.laporan.index' ? 'active' : '' }}"
                        href="{{ route('admin.laporan.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-single-copy-04 text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Laporan Perjualan</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'admin.iklan.index' ? 'active' : '' }}"
                        href="{{ route('admin.iklan.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-image text-info text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Iklan</span>
                    </a>
                </li>

                {{-- <li class="nav-item">
                    {{-- <a class="nav-link {{ Route::currentRouteName() == 'virtual-reality' ? 'active' : '' }}"
                        href="{{ route('virtual-reality') }}"> --}}
                        {{-- <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-app text-info text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Virtual Reality</span>
                    </a>
                </li> --}}
                {{-- <li class="nav-item"> --}}
                    {{-- <a class="nav-link {{ Route::currentRouteName() == 'rtl' ? 'active' : '' }}"
                        href="{{ route('rtl') }}"> --}}
                        {{-- <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-world-2 text-danger text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">RTL</span>
                    </a>
                </li> --}}
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'admin-profile' ? 'active' : '' }}"
                        href="{{ route('admin.profile') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ str_contains(request()->url(), 'user-management') == true ? 'active' : '' }}"
                        href="{{ route('admin.management', ['page' => 'user-management']) }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-bullet-list-67 text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">User Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('login') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-single-copy-04 text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Login</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('register') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-collection text-info text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Register</span>
                    </a>
                </li>
            </ul>
        </div>

</aside>
