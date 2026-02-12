<style>
    :root {
        --gray-dark: #374151;
        --gray: #6B7280;
        --gray-soft: #D1D5DB;
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

    /* GRID SYSTEM - 4 KOLOM MENYAMPING */
    .fav-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
        padding: 0 10px;
    }

    /* Responsive Grid */
    @media (max-width: 1200px) { .fav-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 992px) { .fav-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 576px) { .fav-grid { grid-template-columns: 1fr; } }

    .product-card {
        border-radius: 12px;
        background: var(--card-bg);
        border: 1px solid var(--gray-soft);
        transition: .4s cubic-bezier(.4, 0, .2, 1);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border-color: var(--gray);
    }

    .product-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background: #FAFAFA;
    }

    .price-tag {
        font-weight: 700;
        font-size: 15px;
        color: var(--gray-dark);
        margin-top: 5px;
    }

    .old-price {
        text-decoration: line-through;
        color: var(--gray-soft);
        font-size: 13px;
        margin-left: 5px;
    }

    .badge {
        position: absolute;
        top: 10px;
        padding: 4px 10px;
        font-size: 10px;
        font-weight: 700;
        color: white;
        z-index: 10;
        text-transform: uppercase;
    }

    .badge-diskon {
        background: linear-gradient(135deg, #EF4444, #F97316);
        left: 0;
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
    }

    .badge-best {
        background: linear-gradient(135deg, #6B7280, #9CA3AF);
        right: 0;
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
    }

    .remove-fav-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: none;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(4px);
        font-size: 20px;
        color: #666;
        cursor: pointer;
        transition: all 0.2s ease;
        z-index: 11;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .remove-fav-btn:hover {
        background: #EF4444;
        color: white;
        transform: rotate(90deg);
    }

    .empty-fav {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 50vh;
        text-align: center;
    }

    .empty-fav img {
        max-width: 220px;
        margin-bottom: 24px;
        opacity: 0.8;
    }

    .btn-detail {
        background-color: var(--gray);
        color: white !important;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        transition: 0.3s;
        text-decoration: none;
        display: block;
        width: 100%;
        border: none;
        text-align: center;
    }

    .btn-detail:hover {
        background-color: var(--gray-dark);
    }
</style>

<div class="container py-4">
    <h2 class="fav-title">
        <i class="bi bi-heart-fill text-danger me-2"></i>
        Produk Favorit Saya
    </h2>

    {{-- Gunakan variabel $favorits yang dikirim dari controller --}}
    @if($favorits && $favorits->count() > 0)
        <div class="fav-grid">
            @foreach($favorits as $fav)
                @php
                    $product = $fav->produk;
                    // Proteksi jika produk dihapus admin tapi masih ada di favorit user
                    if(!$product) continue;

                    $sold = $product->sold_count ?? 0;
                @endphp
                <div class="product-card">
                    {{-- Form Delete mengarah ke ID Favorit --}}
                    <form action="{{ route('favorit.destroy', $fav->id) }}" method="POST" class="form-delete">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="remove-fav-btn btn-delete-confirm" title="Hapus dari favorit">
                            &times;
                        </button>
                    </form>

                    @if($product->diskon)
                        <div class="badge badge-diskon">DISKON</div>
                    @endif
                    @if($sold > 50)
                        <div class="badge badge-best">BEST SELLER</div>
                    @endif

                    <a href="{{ route('produk.show', $product->slug) }}">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('assets/images/default-product.png') }}"
                            alt="{{ $product->nama_produk }}">
                    </a>

                    <div class="p-3 text-center d-flex flex-column flex-grow-1">
                        <h6 class="fw-bold mb-1" style="font-size: 14px; color: var(--text-dark);">
                            {{ Str::limit($product->nama_produk, 40) }}
                        </h6>
                        <p class="text-muted small mb-2">{{ $product->kategori->nama_kategori ?? 'Umum' }}</p>

                        <div class="mt-auto">
                            @php
                                if ($product->variants && $product->variants->count() > 0) {
                                    $minHarga = $product->variants->min('harga');
                                    $maxHarga = $product->variants->max('harga');
                                    $hargaStr = number_format($minHarga, 0, ',', '.');
                                    if ($minHarga != $maxHarga)
                                        $hargaStr .= ' - ' . number_format($maxHarga, 0, ',', '.');
                                } else {
                                    $hargaStr = number_format($product->harga, 0, ',', '.');
                                }
                            @endphp

                            <div class="price-tag mb-3">
                                Rp {{ $hargaStr }}
                                @if($product->diskon && $product->harga_lama)
                                    <span class="old-price">Rp {{ number_format($product->harga_lama, 0, ',', '.') }}</span>
                                @endif
                            </div>

                            <a href="{{ route('produk.show', $product->slug) }}" class="btn btn-detail py-2">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-fav">
            <img src="{{ asset('assets/images/Favorit.png') }}" alt="Belum ada favorit">
            <h4 class="fw-bold text-dark">Daftar Favorit Kosong</h4>
            <p class="text-muted mb-4">Sepertinya kamu belum menambahkan produk apapun ke daftar favoritmu.</p>
            <a href="{{ route('home') }}" class="btn btn-dark px-5 py-2 rounded-pill">
                <i class="bi bi-shop me-2"></i> Mulai Belanja
            </a>
        </div>
    @endif
</div>

{{-- SweetAlert2 Script --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.btn-delete-confirm');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                const form = this.closest('.form-delete');
                const card = this.closest('.product-card');

                Swal.fire({
                    title: "Hapus Favorit?",
                    text: "Produk ini akan dihapus dari daftar favorit Anda.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#374151",
                    cancelButtonColor: "#D1D5DB",
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Batal",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Animasi feedback visual
                        card.style.transition = '0.4s';
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.9)';

                        // Submit form setelah animasi sedikit berjalan
                        setTimeout(() => {
                            form.submit();
                        }, 300);
                    }
                });
            });
        });

        // Tampilkan notifikasi jika ada session success
        @if(session('success'))
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
        @endif
    });
</script>
