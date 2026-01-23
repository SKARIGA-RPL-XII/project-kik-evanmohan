{{-- resources/views/user/favorit.blade.php --}}

<style>
    :root {
        --blue: #0D6EFD;
        --blue-dark: #1A325B;
        --blue-soft: #5A8DEE;
        --light-gray: #F8F9FB;
        --soft-gray: #DDE1E7;
        --text-dark: #2C2C2C;
    }

    .fav-title {
        text-align: center;
        font-size: 2rem;
        font-weight: 800;
        color: var(--blue-dark);
        margin: 30px 0 40px;
    }

    .fav-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 24px;
        padding: 0 10px;
    }

    .product-card {
        border-radius: 16px;
        background: white;
        border: 1.5px solid var(--soft-gray);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .product-card:hover {
        transform: translateY(-8px);
        border-color: var(--blue);
        box-shadow: 0 12px 25px rgba(13, 110, 253, 0.18);
    }

    .product-card img {
        width: 100%;
        height: 230px;
        object-fit: cover;
        border-radius: 16px 16px 0 0;
    }

    .remove-fav-btn {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        border: none;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(8px);
        font-size: 22px;
        font-weight: bold;
        color: #666;
        cursor: pointer;
        transition: all 0.25s ease;
        z-index: 10;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .remove-fav-btn:hover {
        background: #ff3b30;
        color: white;
        transform: scale(1.15);
        box-shadow: 0 0 20px rgba(255, 59, 48, 0.6);
    }

    .burst {
        position: absolute;
        width: 140px;
        height: 140px;
        background: radial-gradient(circle, rgba(255, 59, 48, 0.4) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
        z-index: 5;
        animation: burstAnim 0.6s ease-out forwards;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    @keyframes burstAnim {
        0% {
            transform: translate(-50%, -50%) scale(0);
            opacity: 0.9;
        }

        100% {
            transform: translate(-50%, -50%) scale(3);
            opacity: 0;
        }
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
        color: var(--blue-dark);
        margin-bottom: 12px;
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
                    <button type="submit" class="remove-fav-btn" title="Hapus dari favorit">
                        ×
                    </button>
                </form>

                <!-- Gambar Produk -->
                <a href="{{ route('produk.show', $fav->produk->id) }}">
                    <img src="{{ $fav->produk->image
            ? asset('storage/' . $fav->produk->image)
            : asset('assets/images/default-product.png') }}" alt="{{ $fav->produk->nama_produk }}">
                </a>

                <div class="p-4 text-center">
                    <h6 class="fw-bold text-dark mb-2">
                        {{ Str::limit($fav->produk->nama_produk, 50) }}
                    </h6>

                    <p class="text-muted small mb-3">
                        {{ $fav->produk->kategori->nama_kategori ?? 'Umum' }}
                    </p>

                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('produk.show', $fav->produk->slug) }}" class="btn btn-primary btn-sm flex-fill">
                            Lihat Detail
                        </a>
                    </div>
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
            <a href="{{ route('home') }}" class="btn btn-primary px-5 py-3 rounded-pill">
                <i class="bi bi-shop me-2"></i> Mulai Belanja Sekarang
            </a>
        </div>
    @endforelse
</div>

{{-- Efek Burst Saat Hapus Favorit --}}
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
