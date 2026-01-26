@extends('home.app')

@section('content')

<style>
    :root {
        --blue: #4B6CB7;
        --blue-dark: #1F3B6B;
        --soft-gray: #D1D5DB;
        --text-dark: #1E293B;
        --card-bg: #ffffff;
    }

    body {
        background: #f5f7fa;
        font-family: 'Poppins', sans-serif;
        color: var(--text-dark);
    }

    .section-title {
        font-size: 22px;
        font-weight: 700;
        border-left: 6px solid var(--blue);
        padding-left: 12px;
        color: var(--blue-dark);
    }

    /* PRODUCT CARD STYLE */
    .product-card {
        background: var(--card-bg);
        border-radius: 12px;
        border: 1px solid var(--soft-gray);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: 0.3s ease;
        height: 100%;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.15);
    }

    .product-card img {
        width: 100%;
        height: 200px;
        object-fit: contain; /* Gambar full proporsional */
        background: #FAFAFA;
    }

    .product-info {
        padding: 10px 12px;
        text-align: center;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .product-name {
        font-size: 15px;
        font-weight: 600;
        color: #222;
        height: 38px;
        overflow: hidden;
        margin-bottom: 4px;
    }

    .product-category {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 8px;
    }

    .price-tag {
        font-weight: 700;
        font-size: 16px;
        color: var(--blue);
    }

    .old-price {
        text-decoration: line-through;
        color: var(--soft-gray);
        font-size: 14px;
        margin-left: 5px;
    }

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

    .empty-state {
        text-align: center;
        padding: 120px 20px;
    }

    /* RESPONSIVE: Desktop 5 per baris */
    @media (min-width: 1200px) {
        .col-6.col-md-3 {
            flex: 0 0 20%;
            max-width: 20%;
        }
    }
</style>

<div class="container mt-4 mb-5">

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
            @php
                $sold = $product->sold_count ?? 0;

                if($product->variants->count() > 0){
                    $minHarga = $product->variants->min('harga');
                    $maxHarga = $product->variants->max('harga');
                    $harga = number_format($minHarga,0,',','.') . ($minHarga != $maxHarga ? ' - '. number_format($maxHarga,0,',','.') : '');
                } else {
                    $harga = number_format($product->harga,0,',','.');
                }

                $hargaLama = $product->harga_lama ?? null;
            @endphp

            <div class="col-6 col-md-3">

                <a href="{{ route('produk.show', $product->slug) }}" class="text-decoration-none">

                    <div class="product-card">

                        <!-- Badge Diskon / Best Seller -->
                        @if($product->diskon ?? false)
                            <div class="badge badge-diskon">DISKON</div>
                        @endif
                        @if($sold > 50)
                            <div class="badge badge-best">BEST SELLER</div>
                        @endif

                        <!-- Gambar Produk -->
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300' }}" alt="{{ $product->nama_produk }}">

                        <!-- Info Produk -->
                        <div class="product-info">
                            <div>
                                <h6 class="product-name">{{ Str::limit($product->nama_produk, 50) }}</h6>
                                <p class="product-category">{{ $product->kategori->nama_kategori ?? 'Tanpa Kategori' }}</p>
                            </div>

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
