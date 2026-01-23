@extends('home.app')

@section('content')

<style>
    :root {
        --blue: #0D6EFD;
        --blue-soft: #5A8DEE;
        --blue-dark: #1A325B;
        --gray-light: #F5F7FA;
        --gray-soft: #E5E7EB;
        --text-dark: #2C2C2C;
    }

    body {
        background: var(--gray-light);
        font-family: 'Poppins', sans-serif;
        color: var(--text-dark);
    }

    /* SECTION TITLE */
    .section-title {
        font-size: 22px;
        font-weight: 700;
        border-left: 6px solid var(--blue);
        padding-left: 12px;
        color: var(--blue-dark);
    }

    /* PRODUCT CARD NEW MODERN */
    .product-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e6e8ec;
        box-shadow: 0 3px 10px rgba(0,0,0,0.05);
        overflow: hidden;
        transition: 0.28s ease;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-6px) scale(1.02);
        border-color: var(--blue);
        box-shadow: 0 10px 20px rgba(13,110,253,0.15);
    }

    /* IMAGE WRAPPER */
    .product-img-box {
        background: #ffffff;
        height: 220px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
        border-bottom: 1px solid var(--gray-soft);
    }

    .product-img-box img {
        max-height: 200px;
        width: auto;
        object-fit: contain;
        transition: .3s ease;
    }

    .product-card:hover .product-img-box img {
        transform: scale(1.05);
    }

    /* CONTENT */
    .product-info {
        padding: 15px;
        text-align: center;
    }

    .product-name {
        font-size: 15px;
        font-weight: 600;
        height: 40px;
        overflow: hidden;
        color: #222;
    }

    .product-category {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 6px;
    }

    .price {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--blue);
    }

    /* EMPTY STATE */
    .empty-state {
        text-align: center;
        padding: 120px 20px;
    }
</style>

<div class="container mt-4 mb-5">

    <!-- TITLE -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="section-title">
            Kategori: {{ $kategori->nama_kategori }}
        </h4>

        <a href="/" class="btn btn-outline-secondary btn-sm rounded-pill px-3 shadow-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <p class="text-muted mb-4">
        Ditemukan <strong>{{ $products->total() }}</strong> produk dalam kategori ini.
    </p>

    <div class="row g-4">

        @forelse ($products as $product)
            <div class="col-6 col-md-3">

                <a href="{{ route('produk.show', $product->slug) }}" class="text-decoration-none">

                    <div class="product-card">

                        <div class="product-img-box">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300' }}">
                        </div>

                        <div class="product-info">
                            <h6 class="product-name">{{ $product->nama_produk }}</h6>

                            <p class="product-category">
                                {{ $product->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                            </p>

                            @if($product->variants->count() > 0)
                                <p class="price">
                                    Mulai Rp {{ number_format($product->variants->min('harga'), 0, ',', '.') }}
                                </p>
                            @else
                                <p class="price">
                                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                                </p>
                            @endif
                        </div>

                    </div>

                </a>

            </div>
        @empty

            <div class="empty-state">
                <img src="https://cdn-icons-png.flaticon.com/512/4076/4076504.png" width="130" class="mb-4">
                <h5 class="fw-bold mb-1">Tidak ada produk</h5>
                <p class="text-muted">Kategori ini belum memiliki produk.</p>
            </div>

        @endforelse

    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>

</div>

@endsection
