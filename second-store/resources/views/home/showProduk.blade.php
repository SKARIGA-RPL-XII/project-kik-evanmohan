@extends('home.app')

@section('content')
    <style>
        body {
            background-color: #fafafa;
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --primary: #0066ff;
            --primary-dark: #0050cc;
            --glow: 0 0 12px rgba(0, 102, 255, 0.35);
        }

        .product-detail {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 3px 20px rgba(0, 0, 0, 0.08);
            padding: 30px;
            margin-top: 30px;
        }

        .main-image {
            border-radius: 12px;
            width: 100%;
            max-height: 580px;
            height: auto;
            object-fit: contain;
            background: #f8f9fa;
            box-sizing: border-box;
            cursor: zoom-in;
        }

        .thumbnail-wrapper {
            margin-top: 15px;
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding: 5px 0;
        }

        .thumb-img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            background: #fff;
            border-radius: 10px;
            border: 2px solid #ddd;
            cursor: pointer;
            padding: 4px;
            box-sizing: border-box;
            transition: border 0.2s;
        }

        .thumb-img:hover {
            border-color: var(--primary);
        }

        .thumb-img.active {
            border-color: var(--primary);
            box-shadow: var(--glow);
        }

        .price {
            color: var(--primary);
            font-weight: 700;
            font-size: 1.6rem;
            margin: 12px 0;
        }

        .btn-primary-blue,
        .btn-outline-blue {
            border-radius: 12px;
            font-weight: 600;
            padding: 14px 20px;
            width: 100%;
            transition: all 0.25s ease;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .btn-primary-blue {
            background: linear-gradient(90deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
        }

        .btn-outline-blue {
            border: 2.5px solid var(--primary);
            color: var(--primary);
            background: transparent;
        }

        .btn-primary-blue.enabled,
        .btn-outline-blue.enabled {
            opacity: 1;
            cursor: pointer;
        }

        .btn-primary-blue.enabled:hover,
        .btn-outline-blue.enabled:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0, 102, 255, 0.35);
        }

        .btn-outline-blue.enabled:hover {
            background: var(--primary);
            color: white;
        }

        .btn-favorite {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #fff;
            border: 2px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-favorite:hover {
            transform: scale(1.1);
            box-shadow: var(--glow);
        }

        .btn-favorite.liked {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            transform: scale(1.15);
        }

        .variant-option,
        .size-option {
            padding: 10px 18px;
            border: 2px solid #ddd;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            margin: 5px;
            display: inline-block;
            transition: all 0.25s;
        }

        .variant-option:hover:not(.disabled),
        .size-option:hover:not(.disabled) {
            border-color: var(--primary);
            box-shadow: var(--glow);
        }

        .variant-option.active,
        .size-option.active {
            border-color: var(--primary);
            background: var(--primary);
            color: #fff;
            box-shadow: var(--glow);
            transform: scale(1.08);
        }

        .variant-color {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
            vertical-align: middle;
            border: 2px solid #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        .quantity-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 20px 0;
        }

        .quantity-btn {
            width: 40px;
            height: 40px;
            border: 1.5px solid #ddd;
            border-radius: 8px;
            background: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
            user-select: none;
            transition: 0.25s;
        }

        .quantity-btn:hover {
            border-color: var(--primary);
            box-shadow: var(--glow);
        }

        .quantity-input {
            width: 70px;
            height: 40px;
            text-align: center;
            border: 1.5px solid #ddd;
            border-radius: 8px;
            font-weight: 600;
        }

        .stok-info {
            color: #666;
            font-size: 0.95rem;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('success'))
        <script>
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 2000, showConfirmButton: false });
        </script>
    @endif

    <div class="container">
        <div class="product-detail row">
            <div class="col-md-5">
                <img src="{{ $produk->image ? asset('storage/' . $produk->image) : asset('argon/assets/img/default-product.png') }}"
                    alt="{{ $produk->nama_produk }}" class="main-image" id="mainImage">

                <div class="thumbnail-wrapper" id="thumbnailWrapper"></div>
            </div>

            <div class="col-md-7">
                <div class="d-flex justify-content-between align-items-start">
                    <h3 class="mb-0">{{ $produk->nama_produk }}</h3>
                    <div class="btn-favorite" id="favoriteBtn">
                        <i class="bi bi-heart"></i>
                    </div>
                </div>

                <p class="price" id="dynamicPrice">
                    @if($produk->variants->count() == 0)
                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                    @else
                        Rp {{ number_format($produk->variants->min('harga'), 0, ',', '.') }}
                        @if($produk->variants->min('harga') != $produk->variants->max('harga'))
                            - Rp {{ number_format($produk->variants->max('harga'), 0, ',', '.') }}
                        @endif
                    @endif
                </p>

                <p class="text-muted">{{ $produk->deskripsi ?? 'Tidak ada deskripsi.' }}</p>

                @if($produk->variants->count() > 0)
                    <div class="mb-4">
                        <label class="fw-semibold mb-2 d-block">Pilih Warna</label>
                        <div id="variantWrapper">
                            @foreach($produk->variants as $v)
                                <div class="variant-option" data-variant-id="{{ $v->id }}" data-harga="{{ $v->harga }}"
                                    data-image="{{ $v->image ? asset('storage/' . $v->image) : asset('argon/assets/img/default-product.png') }}">
                                    <span class="variant-color" style="background-color: {{ $v->warna }}"></span>
                                    {{ ucfirst($v->warna) }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mb-4" id="sizeWrapper" style="display:none;">
                    <label class="fw-semibold mb-2 d-block">Pilih Ukuran</label>
                    <div id="sizeOptions"></div>
                </div>

                <form id="addToCartForm" action="{{ route('keranjang.add', $produk->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="variant_id" id="variant_id">
                    <input type="hidden" name="size_id" id="size_id">
                    <input type="hidden" name="qty" id="qty" value="1">
                    <label class="fw-semibold">Kuantitas</label>
                    <div class="quantity-wrapper">
                        <div class="quantity-btn" id="qtyMinus">-</div>
                        <input type="number" class="quantity-input" value="1" min="1" id="qtyDisplay" disabled>
                        <div class="quantity-btn" id="qtyPlus">+</div>
                        <span class="stok-info" id="stokInfo">Tersedia 0</span>
                    </div>
                </form>

                <div class="row mt-4">
                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                        <button id="addToCartBtn" form="addToCartForm" class="btn-primary-blue" disabled>
                            Tambah ke Keranjang
                        </button>
                    </div>
                    <div class="col-12 col-md-6">
                        <form action="{{ route('checkout.buy-now', $produk->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="variant_id" id="buy_variant_id">
                            <input type="hidden" name="size_id" id="buy_size_id">
                            <input type="hidden" name="qty" value="1">
                            <button type="submit" class="btn-outline-blue" id="buyNowBtn" disabled>
                                Beli Sekarang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const variants = @json($produk->variants);
        const mainImage = document.getElementById('mainImage');
        const thumbnailWrapper = document.getElementById('thumbnailWrapper');
        const dynamicPrice = document.getElementById('dynamicPrice');
        const variantOptions = document.querySelectorAll('.variant-option');
        const sizeWrapper = document.getElementById('sizeWrapper');
        const sizeOptionsContainer = document.getElementById('sizeOptions');
        const variantInput = document.getElementById('variant_id');
        const sizeInput = document.getElementById('size_id');
        const buyVariantInput = document.getElementById('buy_variant_id');
        const buySizeInput = document.getElementById('buy_size_id');
        const qtyDisplay = document.getElementById('qtyDisplay');
        const qtyInput = document.getElementById('qty');
        const stokInfo = document.getElementById('stokInfo');
        const addToCartBtn = document.getElementById('addToCartBtn');
        const buyNowBtn = document.getElementById('buyNowBtn');
        const favoriteBtn = document.getElementById('favoriteBtn');

        let isVariantSelected = false;
        let isSizeSelected = false;

        // === CEK STATUS FAVORIT DI AWAL ===
        const isFavorited = {{ Auth::check() && \App\Models\Favorit::where('user_id', auth()->id())->where('produk_id', $produk->id)->exists() ? 'true' : 'false' }};

        if (isFavorited) {
            favoriteBtn.classList.add('liked');
            favoriteBtn.innerHTML = '<i class="bi bi-heart-fill"></i>';
        }

        function updateButtonState() {
            const hasSizes = sizeWrapper.style.display === 'block';
            const ready = isVariantSelected && (!hasSizes || isSizeSelected);
            addToCartBtn.disabled = !ready;
            buyNowBtn.disabled = !ready;
            addToCartBtn.classList.toggle('enabled', ready);
            buyNowBtn.classList.toggle('enabled', ready);
        }

        function generateThumbnails() {
            thumbnailWrapper.innerHTML = '';
            variants.forEach((v, i) => {
                const img = document.createElement('img');
                img.src = v.image ? '{{ asset('storage') }}/' + v.image : '{{ asset('argon/assets/img/default-product.png') }}';
                img.classList.add('thumb-img');
                if (i === 0) img.classList.add('active');
                img.onclick = () => {
                    mainImage.src = img.src;
                    document.querySelectorAll('.thumb-img').forEach(t => t.classList.remove('active'));
                    img.classList.add('active');
                };
                thumbnailWrapper.appendChild(img);
            });
        }

        // ==============================
        // TOMBOL FAVORIT
        // ==============================
        favoriteBtn.addEventListener('click', async function () {
            @if(!Auth::check())
                Swal.fire({
                    icon: 'warning',
                    title: 'Login Diperlukan',
                    text: 'Silakan login untuk menyimpan ke favorit',
                    confirmButtonText: 'Login Sekarang'
                }).then((r) => { if (r.isConfirmed) location.href = "{{ route('login') }}"; });
                return;
            @endif

            const produkId = {{ $produk->id }};
            const isLiked = this.classList.contains('liked');

            try {
                const response = await fetch(`/favorit/${produkId}`, {
                    method: isLiked ? 'DELETE' : 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    if (!isLiked) {
                        this.classList.add('liked');
                        this.innerHTML = '<i class="bi bi-heart-fill"></i>';
                        Swal.fire({ icon: 'success', title: 'Ditambahkan!', text: result.message, timer: 1500, showConfirmButton: false });
                    } else {
                        this.classList.remove('liked');
                        this.innerHTML = '<i class="bi bi-heart"></i>';
                        Swal.fire({ icon: 'info', title: 'Dihapus', text: result.message, timer: 1500, showConfirmButton: false });
                    }
                } else {
                    Swal.fire('Oops!', result.message || 'Terjadi kesalahan', 'error');
                }
            } catch (err) {
                console.error(err);
                Swal.fire('Error', 'Tidak dapat terhubung ke server', 'error');
            }
        });

        // =============================
        // VARIANT LOGIC
        // =============================
        variantOptions.forEach(el => {
            el.addEventListener('click', function () {
                if (this.classList.contains('disabled')) return;

                if (this.classList.contains('active')) {
                    this.classList.remove('active');

                    dynamicPrice.innerHTML = `@if($produk->variants->count() > 0)
                        Rp {{ number_format($produk->variants->min('harga'), 0, ',', '.') }}
                        @if($produk->variants->min('harga') != $produk->variants->max('harga'))
                            - Rp {{ number_format($produk->variants->max('harga'), 0, ',', '.') }}
                        @endif
                    @else
                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                    @endif`;

                    mainImage.src = "{{ $produk->image ? asset('storage/' . $produk->image) : asset('argon/assets/img/default-product.png') }}";

                    variantInput.value = buyVariantInput.value = '';
                    sizeInput.value = buySizeInput.value = '';
                    sizeOptionsContainer.innerHTML = '';
                    sizeWrapper.style.display = 'none';
                    isVariantSelected = isSizeSelected = false;
                    qtyInput.value = qtyDisplay.value = 1;
                    stokInfo.textContent = 'Tersedia 0';

                    updateButtonState();
                    return;
                }

                variantOptions.forEach(o => o.classList.remove('active'));
                this.classList.add('active');

                const variantId = this.dataset.variantId;
                const harga = this.dataset.harga;
                const image = this.dataset.image;

                dynamicPrice.innerHTML = 'Rp ' + Number(harga).toLocaleString('id-ID');
                mainImage.src = image;

                variantInput.value = buyVariantInput.value = variantId;
                isVariantSelected = true;
                isSizeSelected = false;

                sizeInput.value = buySizeInput.value = '';
                sizeOptionsContainer.innerHTML = '';

                const selected = variants.find(x => x.id == variantId);

                if (selected.sizes && selected.sizes.length > 0) {
                    sizeWrapper.style.display = 'block';
                    selected.sizes.forEach(size => {
                        const div = document.createElement('div');
                        div.className = 'size-option';
                        if (size.stok == 0) div.classList.add('disabled');
                        div.textContent = size.size + (size.stok == 0 ? ' (Habis)' : '');
                        div.dataset.sizeId = size.id;
                        div.dataset.stok = size.stok;

                        div.onclick = function () {
                            if (size.stok == 0) return;
                            document.querySelectorAll('.size-option').forEach(s => s.classList.remove('active'));
                            this.classList.add('active');
                            sizeInput.value = buySizeInput.value = size.id;
                            isSizeSelected = true;

                            const stok = parseInt(size.stok);
                            qtyDisplay.max = stok;
                            qtyInput.value = qtyDisplay.value = 1;
                            stokInfo.textContent = `Tersedia ${stok}`;
                            updateButtonState();
                        };
                        sizeOptionsContainer.appendChild(div);
                    });
                } else {
                    sizeWrapper.style.display = 'none';
                    qtyDisplay.max = 9999;
                    qtyInput.value = qtyDisplay.value = 1;
                    stokInfo.textContent = '';
                    isSizeSelected = true;
                }

                updateButtonState();
            });

            el.addEventListener('mouseenter', () => mainImage.src = el.dataset.image);
            el.addEventListener('mouseleave', () => {
                const active = document.querySelector('.variant-option.active');
                mainImage.src = active ? active.dataset.image : "{{ $produk->image ? asset('storage/' . $produk->image) : asset('argon/assets/img/default-product.png') }}";
            });
        });

        // Quantity buttons
        document.getElementById('qtyMinus').onclick = () => {
            if (parseInt(qtyInput.value) > 1) {
                qtyInput.value = --qtyDisplay.value;
            }
        };

        document.getElementById('qtyPlus').onclick = () => {
            const max = parseInt(qtyDisplay.max) || 9999;
            if (parseInt(qtyInput.value) < max) {
                qtyInput.value = ++qtyDisplay.value;
            }
        };

        // ===========================================
        // AUTO DISABLE PRODUK HABIS (TAMBAHAN BARU)
        // ===========================================
        const totalStok = {{ $produk->variants->count() == 0
            ? ($produk->stok ?? 0)
            : $produk->variants->flatMap->sizes->sum('stok') }};

        if (totalStok <= 0) {
            addToCartBtn.disabled = true;
            buyNowBtn.disabled = true;

            addToCartBtn.classList.remove('enabled');
            buyNowBtn.classList.remove('enabled');

            stokInfo.textContent = "Stok Habis";

            document.querySelectorAll('.variant-option').forEach(v => {
                v.classList.add('disabled');
                v.style.opacity = "0.5";
                v.style.cursor = "not-allowed";
                v.onclick = null;
            });
        }

        generateThumbnails();
        updateButtonState();
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11/font/bootstrap-icons.css">
@endsection

