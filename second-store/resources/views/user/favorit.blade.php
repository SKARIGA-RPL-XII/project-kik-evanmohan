<style>
    :root {
        --gray-dark: #374151;       /* pengganti blue-dark */
        --gray: #6B7280;            /* pengganti blue */
        --gray-soft: #D1D5DB;       /* soft border */
        --text-dark: #1E293B;
        --accent: #FFD166;
        --card-bg: #ffffff;
    }

    .fav-title {
        text-align: center;
        font-size: 2rem;
        font-weight: 800;
        color: var(--gray-dark);
        margin: 30px 0 40px;
    }

    .fav-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 24px;
        padding: 0 10px;
    }

    .product-card {
        border-radius: 0;
        background: var(--card-bg);
        border: 1px solid var(--gray-soft);
        transition: .4s cubic-bezier(.4,0,.2,1);
        position: relative;
        overflow: hidden;
        height: 400px;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.25);
        border-color: var(--gray);
    }

    .product-card img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        background: #FAFAFA;
    }

    /* PRICE TAG */
    .price-tag {
        font-weight: 700;
        font-size: 16px;
        color: var(--gray);
        margin-top: 5px;
    }

    .old-price {
        text-decoration: line-through;
        color: var(--gray-soft);
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
        background: linear-gradient(135deg,#6B7280,#9CA3AF); /* abu-abu */
        right: 0;
        left:auto;
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }

    /* REMOVE FAVORIT BUTTON */
    .remove-fav-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        border: none;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(8px);
        font-size: 22px;
        font-weight: bold;
        color: #666;
        cursor: pointer;
        transition: all 0.25s ease;
        z-index: 11;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .remove-fav-btn:hover {
        background: #9CA3AF; /* abu-abu saat hover */
        color: white;
        transform: scale(1.15);
        box-shadow: 0 0 20px rgba(156,163,175,0.6);
    }

    .burst {
        position: absolute;
        width: 140px;
        height: 140px;
        background: radial-gradient(circle, rgba(156,163,175,0.4) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
        z-index: 5;
        animation: burstAnim 0.6s ease-out forwards;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    @keyframes burstAnim {
        0% { transform: translate(-50%, -50%) scale(0); opacity: 0.9; }
        100% { transform: translate(-50%, -50%) scale(3); opacity: 0; }
    }

    .empty-fav {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 65vh;
        text-align: center;
        color: #666;
    }

    .empty-fav img {
        max-width: 220px;
        margin-bottom: 24px;
        opacity: 0.8;
    }

    .empty-fav h4 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--gray-dark);
        margin-bottom: 12px;
    }

    /* Tombol lihat detail diganti abu-abu */
    .product-card .btn {
        background-color: var(--gray);
        border-color: var(--gray);
        color: white;
    }

    .product-card .btn:hover {
        background-color: var(--gray-dark);
        border-color: var(--gray-dark);
        color: white;
    }

    .empty-fav .btn {
        background-color: var(--gray);
        border-color: var(--gray);
        color: white;
    }

    .empty-fav .btn:hover {
        background-color: var(--gray-dark);
        border-color: var(--gray-dark);
        color: white;
    }
</style>

<div class="container py-4">
    <h2 class="fav-title">
        <i class="bi bi-heart-fill text-danger me-2"></i>
        Produk Favorit Saya
    </h2>

    @forelse(auth()->user()->favorits as $fav)
        <div class="fav-grid">
            <div class="product-card">

                <!-- Tombol Hapus + Efek Burst -->
                <form action="{{ route('favorit.destroy', $fav->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="remove-fav-btn" title="Hapus dari favorit">×</button>
                </form>

                <!-- Badge Diskon / Best Seller -->
                @php
                    $product = $fav->produk;
                    $sold = $product->sold_count ?? 0;
                @endphp
                @if($product->diskon ?? false)
                    <div class="badge badge-diskon">DISKON</div>
                @endif
                @if($sold > 50)
                    <div class="badge badge-best">BEST SELLER</div>
                @endif

                <!-- Gambar Produk -->
                <a href="{{ route('produk.show', $product->slug) }}">
                    <img src="{{ $product->image
                        ? asset('storage/' . $product->image)
                        : asset('assets/images/default-product.png') }}" alt="{{ $product->nama_produk }}">
                </a>

                <div class="p-3 text-center">
                    <h6 class="fw-semibold mb-1">{{ Str::limit($product->nama_produk, 50) }}</h6>
                    <p class="text-muted small mb-2">{{ $product->kategori->nama_kategori ?? 'Umum' }}</p>

                    @php
                        if($product->variants->count() > 0){
                            $minHarga = $product->variants->min('harga');
                            $maxHarga = $product->variants->max('harga');
                            $harga = number_format($minHarga,0,',','.') . ($minHarga != $maxHarga ? ' - '. number_format($maxHarga,0,',','.') : '' );
                        } else {
                            $harga = number_format($product->harga,0,',','.');
                        }
                        $hargaLama = $product->harga_lama ?? null;
                    @endphp

                    <div class="price-tag">
                        Rp {{ $harga }}
                        @if($product->diskon && $hargaLama)
                            <span class="old-price">Rp {{ number_format($hargaLama,0,',','.') }}</span>
                        @endif
                    </div>

                    <a href="{{ route('produk.show', $product->slug) }}" class="btn btn-sm mt-2 px-4 py-1">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="empty-fav">
            <img src="{{ asset('assets/images/Favorit.png') }}" alt="Belum ada favorit">
            <h4>Belum Ada Produk Favorit</h4>
            <p class="mb-4">
                Yuk tambahkan produk yang kamu suka dengan klik ikon ❤️ di halaman produk!
            </p>
            <a href="{{ route('home') }}" class="btn px-5 py-3 rounded-pill">
                <i class="bi bi-shop me-2"></i> Mulai Belanja Sekarang
            </a>
        </div>
    @endforelse
</div>

<script>
    document.querySelectorAll('.remove-fav-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            const card = this.closest('.product-card');
            const burst = document.createElement('div');
            burst.classList.add('burst');
            card.appendChild(burst);

            setTimeout(() => {
                burst.remove();
                card.style.opacity = '0';
                card.style.transform = 'scale(0.9)';
                setTimeout(() => card.remove(), 300);
            }, 600);
        });
    });
</script>
