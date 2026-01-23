@extends('home.app')

@section('content')
    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Poppins', sans-serif;
        }
        .cart-container { margin-top: 40px; }
        .cart-box {
            background: #fff; border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 20px; margin-bottom: 20px;
        }
        .cart-header {
            display: flex; align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px; margin-bottom: 15px;
        }
        .cart-item-main {
            display: flex; align-items: center;
            padding: 15px 0; border-bottom: 1px solid #f0f0f0;
        }
        .cart-item-main:last-child { border-bottom: none; }
        .cart-item-main img {
            border-radius: 10px; width: 75px; height: 75px;
            object-fit: cover; margin-right: 15px;
        }
        .cart-item-info { flex: 1; }
        .cart-item-info h6 {
            font-size: 15px; margin-bottom: 5px;
        }
        .cart-item-actions { display: flex; align-items: center; gap: 8px; }
        .qty-btn {
            background: #eee; border: none;
            border-radius: 6px; width: 30px; height: 30px;
            font-weight: bold; cursor: pointer;
        }
        .summary-card {
            background: #fff; border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 25px;
        }
        .checkout-btn {
            background-color: #0338d6; color: white;
            border: none; border-radius: 8px;
            padding: 12px; font-weight: 600;
            width: 100%; margin-bottom: 10px;
        }
        .checkout-btn:disabled { background-color: #1188ea; cursor: not-allowed; }
        .clear-btn {
            border: 1px solid #ff4d4d; color: #ff4d4d;
            background: transparent; border-radius: 8px;
            padding: 12px; font-weight: 500; width: 100%;
        }
        .clear-btn:hover { background: #ff4d4d; color: white; }
        .empty-cart-box {
            background: white; border-radius: 20px;
            padding: 45px 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        /* small tweak for SweetAlert2 orange icon background if needed */
        .swal2-icon.swal2-warning { background: linear-gradient(180deg,#ff8a00,#ff6600) !important; color: white !important; }
    </style>

    <div class="container cart-container">
        <h4 class="mb-4 fw-bold">Keranjang</h4>

        @if ($items->isEmpty())
            {{-- KERANJANG KOSONG --}}
            <div class="row">
                <div class="col-lg-8">
                    <div class="empty-cart-box">
                        <img src="{{ asset('assets/images/empty_cart.png') }}" width="170" class="mb-3">
                        <h4 class="fw-bold">Wah, keranjang belanjamu kosong</h4>
                        <p class="text-muted mb-4">Yuk, isi dengan barang-barang impianmu!</p>
                        <a href="{{ route('home') }}" class="btn btn-primary px-4 py-2" style="border-radius:12px;">
                            Mulai Belanja
                        </a>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="summary-card">
                        <h5 class="fw-bold">Ringkasan belanja</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <strong>Total</strong><span>-</span>
                        </div>
                        <hr>
                        <button class="checkout-btn mt-4" disabled>Beli</button>
                    </div>
                </div>
            </div>
        @else

            {{-- HEADER PILIH SEMUA --}}
            <div class="cart-header">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="checkAll">
                    <label class="form-check-label ms-2 fw-semibold">Pilih Semua</label>
                </div>
            </div>

            <div class="row">

                {{-- LIST ITEM --}}
                <div class="col-lg-8">
                    <div class="cart-box">

                        @foreach($items as $it)
                            <div class="cart-item-main">

                                {{-- CHECKBOX + STOCK --}}
                                <input class="form-check-input item-check me-3"
                                    type="checkbox"
                                    value="{{ $it->id }}"
                                    data-price="{{ $it->harga_satuan }}"
                                    data-qty="{{ $it->qty }}"
                                    data-variant="{{ $it->variant_id }}"
                                    data-size="{{ $it->size }}"
                                    data-stock="{{ $it->size ? $it->size->stok : ($it->variant ? $it->variant->stok : $it->product->stok) }}">

                                {{-- GAMBAR --}}
                                <img src="
                                    @if($it->image)
                                        {{ asset('storage/' . $it->image) }}
                                    @else
                                        {{ $it->variant->image ? asset('storage/' . $it->variant->image) : asset('argon/assets/img/default-product.png') }}
                                    @endif
                                " alt="Produk">

                                {{-- INFO --}}
                                <div class="cart-item-info">
                                    <h6>{{ $it->product->nama_produk }}</h6>

                                    @if($it->variant)
                                        <small>Warna: <strong>{{ $it->variant->warna }}</strong></small>
                                    @endif

                                    @if($it->size)
                                        <div><small>Ukuran: <strong>{{ $it->size->size }}</strong></small></div>
                                    @endif

                                    <div class="text-success mt-1 fw-semibold">
                                        Rp {{ number_format($it->harga_satuan, 0, ',', '.') }}
                                    </div>
                                </div>

                                {{-- QTY + DELETE --}}
                                <div class="cart-item-actions">

                                    <button class="qty-btn decrease" data-id="{{ $it->id }}">-</button>

                                    <input type="number"
                                           class="form-control form-control-sm text-center qty-input"
                                           min="1"
                                           value="{{ $it->qty }}"
                                           style="width: 60px;">

                                    <button class="qty-btn increase" data-id="{{ $it->id }}">+</button>

                                    <button class="btn btn-sm btn-outline-danger delete-btn"
                                        data-url="{{ route('keranjang.remove', $it->id) }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                            </div>
                        @endforeach

                    </div>
                </div>

                {{-- RINGKASAN --}}
                <div class="col-lg-4">
                    <div class="summary-card">
                        <h5>Ringkasan Belanja</h5>

                        <div class="d-flex justify-content-between mb-2">
                            <strong>Total Barang:</strong>
                            <span id="totalItems">0</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <strong>Total Harga:</strong>
                            <span id="totalPrice">Rp 0</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-2">
                            <strong>Subtotal:</strong>
                            <span id="subtotal">Rp 0</span>
                        </div>

                        <hr>

                        <form action="{{ route('checkout.cart') }}" method="POST">
                            @csrf
                            <input type="hidden" name="items" id="selectedItems">
                            <button type="submit" class="checkout-btn" id="buyBtn" disabled>
                                Checkout Produk Terpilih
                            </button>
                        </form>

                        <button class="clear-btn" id="clearAllBtn">
                            Kosongkan Keranjang
                        </button>
                    </div>
                </div>

            </div>

        @endif
    </div>

    <!-- SweetAlert2 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    {{-- JAVASCRIPT --}}
    <script>
        // --- Utility: SweetAlert2 options for orange theme ---
        const swalConfirmOptions = {
            showCancelButton: true,
            confirmButtonText: 'Ya, lanjutkan',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            focusCancel: true,
            customClass: {
                popup: 'swal2-popup',
                confirmButton: 'swal2-confirm',
                cancelButton: 'swal2-cancel'
            },
            buttonsStyling: false,
            // apply inline styles for orange look (fallback)
            didOpen: (popup) => {
                const c = popup.querySelector('.swal2-confirm');
                if (c) {
                    c.style.background = '#ff6600';
                    c.style.color = '#fff';
                    c.style.border = 'none';
                    c.style.padding = '8px 18px';
                    c.style.borderRadius = '8px';
                    c.style.fontWeight = '600';
                }
                const b = popup.querySelector('.swal2-cancel');
                if (b) {
                    b.style.background = '#eef0f2';
                    b.style.color = '#333';
                    b.style.border = 'none';
                    b.style.padding = '8px 18px';
                    b.style.borderRadius = '8px';
                }
            }
        };

        // --- basic elements and summary logic (kept intact) ---
        const checkAll = document.getElementById('checkAll');
        const itemChecks = document.querySelectorAll('.item-check');
        const qtyInputs = document.querySelectorAll('.qty-input');

        checkAll?.addEventListener('change', function () {
            itemChecks.forEach(c => c.checked = checkAll.checked);
            updateSummary();
        });

        function updateSummary() {
            let totalQty = 0;
            let totalPrice = 0;

            itemChecks.forEach(c => {
                if (c.checked) {
                    let qty = parseInt(c.dataset.qty);
                    let price = parseInt(c.dataset.price);
                    totalQty += qty;
                    totalPrice += qty * price;
                }
            });

            document.getElementById('totalItems').innerText = totalQty;
            document.getElementById('totalPrice').innerText = "Rp " + totalPrice.toLocaleString('id-ID');
            document.getElementById('subtotal').innerText = "Rp " + totalPrice.toLocaleString('id-ID');
            document.getElementById('buyBtn').disabled = totalQty === 0;

            const checkedCount = document.querySelectorAll('.item-check:checked').length;
            checkAll.checked = checkedCount === itemChecks.length;
        }

        itemChecks.forEach(c => {
            c.addEventListener('change', updateSummary);
        });

        function gatherSelectedItems() {
            let arr = [];

            itemChecks.forEach(c => {
                if (c.checked) {
                    arr.push({
                        id: c.value,
                        qty: c.dataset.qty,
                        variant_id: c.dataset.variant,
                        size: c.dataset.size
                    });
                }
            });

            document.getElementById('selectedItems').value = JSON.stringify(arr);
        }

        document.getElementById('buyBtn')?.addEventListener('click', gatherSelectedItems);

        // ==================================================
        //   QTY BUTTONS -> use SweetAlert for stock warning
        // ==================================================
        document.querySelectorAll('.increase').forEach((btn, index) => {
            btn.addEventListener('click', () => {
                let input = qtyInputs[index];
                let checkbox = itemChecks[index];

                let current = parseInt(input.value);
                let stock = parseInt(checkbox.dataset.stock);

                if (current < stock) {
                    input.value = current + 1;
                    checkbox.dataset.qty = input.value;
                    updateSummary();
                } else {
                    // sweetalert orange-themed warning
                    Swal.fire({
                        icon: 'warning',
                        title: 'Stok Tidak Cukup',
                        html: `Jumlah yang dipilih melebihi stok tersedia (<strong>${stock}</strong>).`,
                        confirmButtonText: 'Mengerti',
                        confirmButtonColor: '#ff6600',
                        customClass: { popup: 'swal2-popup' }
                    });
                }
            });
        });

        document.querySelectorAll('.decrease').forEach((btn, index) => {
            btn.addEventListener('click', () => {
                let input = qtyInputs[index];
                let checkbox = itemChecks[index];

                if (input.value > 1) {
                    input.value = parseInt(input.value) - 1;
                    checkbox.dataset.qty = input.value;
                    updateSummary();
                }
            });
        });

        // ==================================================
        //   DELETE ITEM -> SweetAlert confirmation
        // ==================================================
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const url = btn.dataset.url;

                Swal.fire({
                    title: 'Hapus Produk?',
                    html: 'Produk ini akan dihapus dari keranjang.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#ff6600',
                    reverseButtons: true,
                    backdrop: true,
                    allowOutsideClick: false,
                    didOpen: (popup) => {
                        // small custom style
                        const confirmBtn = popup.querySelector('.swal2-confirm');
                        if (confirmBtn) confirmBtn.style.borderRadius = '8px';
                        const cancelBtn = popup.querySelector('.swal2-cancel');
                        if (cancelBtn) cancelBtn.style.borderRadius = '8px';
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // redirect to delete route
                        window.location.href = url;
                    }
                });
            });
        });

        // ==================================================
        //   CLEAR ALL -> SweetAlert confirmation
        // ==================================================
        document.getElementById('clearAllBtn')?.addEventListener('click', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Kosongkan Keranjang?',
                html: 'Semua produk akan dihapus secara permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Kosongkan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#ff6600',
                reverseButtons: true,
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // navigate to clear route
                    window.location.href = "{{ route('keranjang.clear') }}";
                }
            });
        });

        // small accessibility: update summary if qty inputs changed manually
        document.querySelectorAll('.qty-input').forEach((input, index) => {
            input.addEventListener('change', () => {
                let val = parseInt(input.value) || 1;
                const checkbox = itemChecks[index];
                const stock = parseInt(checkbox.dataset.stock);
                if (val < 1) val = 1;
                if (val > stock) {
                    // cap and show sweetalert
                    input.value = stock;
                    checkbox.dataset.qty = stock;
                    updateSummary();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Stok Terbatas',
                        html: `Maksimal jumlah untuk produk ini adalah <strong>${stock}</strong>.`,
                        confirmButtonText: 'Mengerti',
                        confirmButtonColor: '#ff6600'
                    });
                } else {
                    input.value = val;
                    checkbox.dataset.qty = input.value;
                    updateSummary();
                }
            });
        });

    </script>
@endsection
