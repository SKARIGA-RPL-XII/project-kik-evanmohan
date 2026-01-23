@extends('home.app')

@section('content')
<style>
    :root {
        --blue: #0D6EFD;
        --blue-dark: #1A325B;
        --soft-gray: #DDE1E7;
        --text-dark: #2C2C2C;
    }

    body {
        background: #f5f7fa;
        font-family: 'Poppins', sans-serif;
        color: var(--text-dark);
    }

    /* PRODUCT CARD */
    .product-card {
        border-radius: 15px;
        background: white;
        border: 1px solid var(--soft-gray);
        transition: .3s;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-5px);
        border-color: var(--blue);
        box-shadow: 0 6px 16px rgba(13, 110, 253, 0.15);
    }

    .product-card img {
        width: 100%;
        height: 220px;
        object-fit: contain;
        border-radius: 15px 15px 0 0;
    }

    .price {
        color: var(--blue);
        font-size: 1.2rem;
        font-weight: 700;
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
                <div class="col-6 col-md-3 mb-4">
                    <a href="{{ route('produk.show', $product->slug) }}" class="text-decoration-none text-dark">
                        <div class="product-card h-100">

                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300x220?text=No+Image' }}" alt="{{ $product->nama_produk }}">

                            <div class="p-3 text-center">
                                <h6 class="fw-semibold">{{ Str::limit($product->nama_produk, 50) }}</h6>
                                <p class="text-muted small">{{ $product->kategori->nama_kategori ?? 'Tanpa Kategori' }}</p>

                                @if($product->variants->count() > 0)
                                    <p class="price">Mulai dari Rp {{ number_format($product->variants->min('harga'), 0, ',', '.') }}</p>
                                @else
                                    <p class="price">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                                @endif
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
