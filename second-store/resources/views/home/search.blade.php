@extends('home.app')

@section('content')
<style>
    :root {
        --blue: #4B6CB7;
        --blue-dark: #1F3B6B;
        --blue-soft: #6C8CD5;
        --soft-gray: #D1D5DB;
        --text-dark: #1E293B;
        --accent: #FFD166;
        --card-bg: #ffffff;
    }

    body {
        background: #f5f7fa;
        font-family: 'Poppins', sans-serif;
        color: var(--text-dark);
    }

    /* PRODUCT CARD */
    .product-card {
        border-radius: 0;
        background: var(--card-bg);
        border: 1px solid var(--soft-gray);
        transition: .4s cubic-bezier(.4,0,.2,1);
        position: relative;
        overflow: hidden;
        height: 380px; /* sama seperti homepage */
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.25);
        border-color: var(--blue);
    }

    .product-card img {
        width: 100%;
        height: 230px; /* sama seperti homepage */
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

    .old-price {
        text-decoration: line-through;
        color: var(--soft-gray);
        font-size: 14px;
        margin-left: 5px;
    }

    /* BADGE DISKON / BEST SELLER */
    .badge {
        position: absolute;
        top: 10px;
        padding: 4px 10px;
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

    .section-title {
        font-size: 22px;
        font-weight: 700;
        border-left: 6px solid var(--blue);
        padding-left: 12px;
        color: var(--blue-dark);
        margin-bottom: 20px;
    }

    /* EMPTY STATE CENTER */
    .empty-search {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 50vh;
        text-align: center;
    }

    .empty-search img {
        max-width: 180px;
        margin-bottom: 20px;
    }

    /* RESPONSIVE GRID UNTUK SEBARIS 5 PRODUK */
    @media (min-width: 1200px){
        .col-md-2 { flex: 0 0 20%; max-width: 20%; }
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

<div class="container my-5">
    <h3 class="fw-bold mb-4">
        Hasil Pencarian untuk: <span style="color: var(--blue);">"{{ $keyword }}"</span>
    </h3>

    {{-- EMPTY STATE --}}
    @if($products->count() == 0)
        <div class="empty-search">
            <img src="{{ asset('assets/images/card_search.png') }}" alt="Empty">
            <h4 class="fw-bold">Produk Tidak Ditemukan</h4>
            <p class="text-muted mb-4" style="font-size: 15px;">
                Tidak ada hasil untuk pencarian: <b>"{{ $keyword }}"</b><br>
                Coba gunakan kata kunci lain.
            </p>
            <a href="{{ route('home') }}" class="btn btn-primary px-4 py-2" style="border-radius:12px;">
                Kembali Belanja
            </a>
        </div>
    @endif

    {{-- LIST PRODUK --}}
    @if($products->count() > 0)
        <h4 class="section-title">Hasil Produk</h4>
        <div class="row">
            @foreach ($products as $product)
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
                        <div class="product-card h-100">

                            @if($product->diskon ?? false)
                                <div class="badge badge-diskon">DISKON</div>
                            @endif
                            @if($sold > 50)
                                <div class="badge badge-best">BEST SELLER</div>
                            @endif

                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300x220?text=No+Image' }}" alt="{{ $product->nama_produk }}">

                            <div class="p-2 text-center">
                                <h6 class="fw-semibold mb-1">{{ $namaPendek }}</h6>
                                <p class="text-muted small mt-1">{{ $product->kategori->nama_kategori ?? 'Tanpa Kategori' }}</p>
                                <div class="price-tag">
                                    Rp {{ $harga }}
                                    @if($product->diskon && $hargaLama)
                                        <span class="old-price">Rp {{ number_format($hargaLama,0,',','.') }}</span>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection
