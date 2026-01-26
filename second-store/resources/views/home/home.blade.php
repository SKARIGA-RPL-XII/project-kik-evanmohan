@extends('home.app')

@section('content')

<style>
:root {
    --blue: #4B6CB7;
    --blue-dark: #1F3B6B;
    --blue-soft: #6C8CD5;
    --light-gray: #F2F4F8;
    --soft-gray: #D1D5DB;
    --text-dark: #1E293B;
    --accent: #FFD166;
    --card-bg: #ffffff;
}

/* DARK MODE */
body.dark-mode {
    --light-gray: #0F172A;
    --card-bg: #1E293B;
    --text-dark: #E5E7EB;
    --soft-gray: #374151;
    background: var(--light-gray);
    color: var(--text-dark);
    transition: .4s;
}

body {
    background: var(--light-gray);
    font-family: 'Poppins', sans-serif;
    color: var(--text-dark);
    transition: .4s;
}

/* HERO CAROUSEL */
.hero-bg-full {
    background: linear-gradient(135deg, #3A4F7A, #6B728E);
}

.carousel-wrapper {
    position: relative;
    width: 100%;
    overflow: hidden;
}

.hero-slides-container {
    display: flex;
    width: 100%;
    transition: .6s ease-in-out;
}

.hero-slide {
    min-width: 100%;
}

.hero-banner {
    position: relative;
    height: 525px;
    overflow: hidden;
    color: white;
}

.hero-text h1 {
    font-size: 48px;
    font-weight: 800;
    margin-bottom: 10px;
}

.hero-text small {
    font-size: 14px;
    opacity: 0.9;
}

.hero-price {
    font-size: 22px;
    font-weight: 600;
    color: var(--accent);
}

.hero-img-right {
    position: absolute;
    right: 150px;
    top: 50%;
    width: 340px;
    height: 340px;
    object-fit: cover;
    transform: translateY(-50%);
    border-radius: 18px;
    transition: transform .3s;
}

.hero-img-right:hover {
    transform: translateY(-50%) scale(1.05);
}

/* HERO INDICATORS */
.hero-indicators {
    position: absolute;
    bottom: 75px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
}

.hero-indicators span {
    width: 12px;
    height: 12px;
    background: white;
    border-radius: 50%;
    opacity: .4;
    margin: 0 4px;
    cursor: pointer;
    transition: .3s;
}

.hero-indicators span.active {
    opacity: 1;
    background: var(--accent);
}

/* HERO ARROWS */
.hero-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 50px;
    height: 50px;
    background: white;
    color: var(--blue);
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 22px;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    z-index: 5;
    transition: .3s;
}

.hero-arrow:hover {
    background: #e9e9e9c2;
}

.arrow-left { left: 20px; }
.arrow-right { right: 20px; }

/* CATEGORY WRAPPER */
.category-wrapper {
    background: var(--card-bg);
    padding: 0px 0px;
    border-radius: 16px;
    margin-top: -50px;
    margin-bottom: 30px;
    box-shadow: 0 12px 30px rgba(0,0,0,.08);
    position: relative;
    z-index: 10;
    min-height: 140px;
}

/* HORIZONTAL SCROLL CONTAINER */
.category-carousel-wrapper {
    display: flex;
    gap: 15px;
    overflow-x: auto;
    padding: 50px 50px;
    scroll-behavior: smooth;
}

/* Hide scrollbar */
.category-carousel-wrapper::-webkit-scrollbar { display: none; }
.category-carousel-wrapper { -ms-overflow-style: none; scrollbar-width: none; }

.category-box-link {
    flex: 0 0 auto;
    text-decoration: none;
    color: inherit;
}

.category-box {
    text-align: center;
    padding: 10px;
    border-radius: 12px;
    transition: .35s;
    min-width: 90px;
}

.category-box:hover {
    background: linear-gradient(135deg, var(--blue), var(--blue-soft));
    transform: translateY(-5px) scale(1.03);
    color: white;
}

.category-box img {
    width: 55px;
    height: 55px;
    object-fit: cover;
    border-radius: 12px;
}

/* CATEGORY ARROWS */
.category-arrow-left,
.category-arrow-right {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 40px;
    height: 40px;
    background: white;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    color: var(--blue);
    font-size: 22px;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0,0,0,.15);
    z-index: 11;
    transition: .3s;
}

.category-arrow-left:hover,
.category-arrow-right:hover { background: #e9e9e9c2; }

.category-arrow-left { left: 10px; }
.category-arrow-right { right: 10px; }

/* PRODUCT CARD BESAR, SEBARIS 5 PRODUK */
.product-card {
    border-radius: 0;
    background: var(--card-bg);
    border: 1px solid var(--soft-gray);
    transition: .4s;
    position: relative;
    overflow: hidden;
    height: 380px; /* lebih besar */
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.25);
    border-color: var(--blue);
}

.product-card img {
    width: 100%;
    height: 230px;
    object-fit: cover;
    background: #FAFAFA;
}

/* PRICE TAG */
.price-tag {
    font-weight: 700;
    font-size: 16px;
    color: var(--blue);
    margin-top: 5px;
}

/* DISCOUNT / BEST SELLER BADGE */
.badge {
    position: absolute;
    top: 10px;
    padding: 4px 10px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 700;
    color: white;
    z-index: 10;
}

.badge-diskon {
    background: linear-gradient(135deg,#EF4444,#F97316);
    left: 0;
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
}

.badge-best {
    background: linear-gradient(135deg,#10B981,#22C55E);
    right: 0;
    left:auto;
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
}

/* OLD PRICE STRIKETHROUGH */
.old-price {
    text-decoration: line-through;
    color: var(--soft-gray);
    font-size: 14px;
    margin-left: 5px;
}

/* SECTION TITLE */
.section-title {
    font-size: 22px;
    font-weight: 700;
    border-left: 6px solid var(--blue);
    padding-left: 12px;
    color: var(--blue-dark);
}

/* RESPONSIVE */
@media (max-width: 768px){
    .hero-banner { height: auto; padding: 80px 20px 120px; text-align: center; }
    .hero-text { position: static !important; transform: none !important; max-width: 100%; }
    .hero-text h1 { font-size: 34px; }
    .hero-img-right { position: relative; width: 260px; height: 260px; margin: 30px auto 0; right: auto; top: auto; transform: none; }
    .category-carousel-wrapper { padding: 0 20px; }
}

/* RESPONSIVE GRID UNTUK SEBARIS 5 PRODUK */
@media (min-width: 1200px){
    .col-md-2 { flex: 0 0 20%; max-width: 20%; } /* 5 produk sebaris */
}
@media (min-width: 992px) and (max-width: 1199px){
    .col-md-2 { flex: 0 0 25%; max-width: 25%; }
}
@media (min-width: 768px) and (max-width: 991px){
    .col-md-2 { flex: 0 0 33.3333%; max-width: 33.3333%; }
}
@media (max-width: 767px){
    .col-md-2 { flex: 0 0 50%; max-width: 50%; }
}
</style>

{{-- DARK MODE TOGGLE --}}
<div class="position-fixed top-0 end-0 m-3" style="cursor:pointer; z-index:99;" onclick="toggleDark()">🌙</div>

{{-- HERO CAROUSEL --}}
@if(count($iklans) > 0)
<div class="hero-bg-full">
    <div class="position-relative mb-4">
        <div class="hero-arrow arrow-left" onclick="prevSlide()">❮</div>
        <div class="hero-arrow arrow-right" onclick="nextSlide()">❯</div>

        <div class="carousel-wrapper">
            <div class="hero-slides-container" id="heroSlides">
                @foreach($iklans as $ads)
                <div class="hero-slide">
                    <div class="hero-banner">
                        <div class="hero-text position-absolute" style="top:50%;left:150px;transform:translateY(-50%);max-width:420px;">
                            <small>Selamat Datang Di Second Store 🤙</small>
                            <h1>Pilih Barang<br>Yang Bagus</h1>
                            <div class="hero-price">Kepoin Barang Kita 😊👌</div>
                            <a href="#produkTerbaru" class="btn btn-light mt-3 px-4 py-2 fw-semibold">Shop Now →</a>
                        </div>
                        <img src="{{ $ads->gambar ? asset('storage/' . $ads->gambar) : 'https://via.placeholder.com/360' }}" class="hero-img-right">
                    </div>
                </div>
                @endforeach
            </div>
            <div class="hero-indicators" id="heroDots">
                @foreach($iklans as $index => $d)
                <span onclick="goToSlide({{ $index }})" class="{{ $index === 0 ? 'active' : '' }}"></span>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

{{-- CATEGORY --}}
<div class="container category-wrapper">
    <div class="category-carousel-wrapper" id="categoryCarouselWrapper">
        @foreach ($kategori as $cat)
        <a href="{{ route('product.searchByKategori', $cat->slug) }}" class="category-box-link">
            <div class="category-box">
                <img src="{{ $cat->image ? asset('storage/' . $cat->image) : 'https://via.placeholder.com/60' }}">
                <p class="fw-semibold small mt-2">{{ $cat->nama_kategori }}</p>
            </div>
        </a>
        @endforeach
    </div>
    <div class="category-arrow-left" onclick="scrollCategory('left')">❮</div>
    <div class="category-arrow-right" onclick="scrollCategory('right')">❯</div>
</div>

{{-- PRODUK TERBARU --}}
<div class="container mt-4" id="produkTerbaru">
    <h4 class="section-title">Produk Terbaru</h4>
    <div class="row">
        @forelse ($products as $product)
        @php
            $namaPendek = strlen($product->nama_produk) > 18 ? substr($product->nama_produk, 0, 18) . '...' : $product->nama_produk;
            if($product->variants->count() > 0){
                $minHarga = $product->variants->min('harga');
                $maxHarga = $product->variants->max('harga');
                $harga = number_format($minHarga,0,',','.') . ($minHarga != $maxHarga ? ' - '. number_format($maxHarga,0,',','.') : '');
            } else {
                $harga = number_format($product->harga,0,',','.');
            }
            $sold = $product->sold_count ?? 0;
            $hargaLama = $product->harga_lama ?? null;
        @endphp

        <div class="col-6 col-md-2 mb-4">
            <a href="{{ route('produk.show', $product->slug) }}" class="text-decoration-none text-dark">
                <div class="product-card h-100 position-relative">

                    @if($product->diskon ?? false)
                    <div class="badge badge-diskon">DISKON</div>
                    @endif
                    @if($sold > 50)
                    <div class="badge badge-best">BEST SELLER</div>
                    @endif

                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300x220?text=No+Image' }}">

                    <div class="p-2 text-center">
                        <h6 class="fw-semibold mb-1">{{ $namaPendek }}</h6>
                        <div class="price-tag">
                            Rp {{ $harga }}
                            @if($product->diskon && $hargaLama)
                                <span class="old-price">Rp {{ number_format($hargaLama,0,',','.') }}</span>
                            @endif
                        </div>
                        <p class="text-muted small mt-1">{{ $product->kategori->nama_kategori ?? 'Tanpa Kategori' }}</p>
                    </div>

                </div>
            </a>
        </div>
        @empty
        <p class="text-center">Belum ada produk.</p>
        @endforelse
    </div>
</div>

<script>
/* HERO SLIDES */
let index = 0;
const slides = document.querySelectorAll(".hero-slide");
const container = document.getElementById("heroSlides");
const dots = document.querySelectorAll("#heroDots span");

function goToSlide(i){
    index = i;
    container.style.transform = "translateX(" + (-index * 100) + "%)";
    dots.forEach(d => d.classList.remove("active"));
    dots[index].classList.add("active");
}
function nextSlide(){ index = (index + 1) % slides.length; goToSlide(index); }
function prevSlide(){ index = (index - 1 + slides.length) % slides.length; goToSlide(index); }
setInterval(nextSlide, 4000);

/* CATEGORY SCROLL */
function scrollCategory(direction){
    const wrapper = document.getElementById('categoryCarouselWrapper');
    const scrollAmount = 150;
    if(direction === 'left'){
        wrapper.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    } else {
        wrapper.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    }
}

/* DARK MODE TOGGLE */
function toggleDark(){
    document.body.classList.toggle('dark-mode');
    localStorage.setItem('dark', document.body.classList.contains('dark-mode'));
}
if(localStorage.getItem('dark') === 'true'){
    document.body.classList.add('dark-mode');
}
</script>

@endsection
