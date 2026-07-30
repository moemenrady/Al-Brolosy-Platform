@extends('layouts.app')
@section('title', $collectionName)

@section('style')
@section('style')
    <style>
        .collection-container {
            max-width: 1300px;
            margin: auto;
            padding: 40px 20px;
        }

        /* Header */
        .collection-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .collection-header h1 {
            font-size: 2rem;
            font-weight: bold;
        }

        /* ================= GRID ================= */

        /* Desktop default = 3 */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        /* Tablet */
        @media (max-width:1024px) {
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Mobile */
        @media (max-width:600px) {
            .collection-container {
                padding: 20px 12px;
            }

            .product-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }
        }

        /* ================= CARD ================= */

        .product-card {
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
            transition: all .4s ease;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }

        /* ================= IMAGE 9:16 ================= */

        .product-image-wrapper {
            position: relative;
            width: 100%;
            aspect-ratio: 3/4;
            /* 🔥 420x570 تقريباً */
            overflow: hidden;
            background: #f8f8f8;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.4s;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        /* ================= BADGE ================= */

        .sale-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: var(--primary-color);
            color: #fff;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
        }

        /* ================= DETAILS ================= */

        .product-details {
            padding: 15px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .product-name {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 8px;
            line-height: 1.4;
            min-height: 38px;
        }

        .price-box {
            margin-bottom: 12px;
        }

        .original-price {
            text-decoration: line-through;
            font-size: 0.85rem;
            color: #999;
        }

        .current-price {
            font-weight: bold;
            color: var(--primary-color);
            font-size: 1.05rem;
        }

        /* ================= BUTTON ================= */

        .card-actions {
            margin-top: auto;
        }

        .btn-cart {
            width: 100%;
            padding: 10px;
            border-radius: 30px;
            border: 2px solid var(--primary-color);
            background: white;
            color: var(--primary-color);
            font-weight: bold;
            font-size: 0.9rem;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-cart:hover {
            background: var(--primary-color);
            color: white;
        }

        /* ================= MODAL ================= */

        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 2000;
        }

        .modal-content {
            background: #fff;
            padding: 25px;
            border-radius: 14px;
            width: 90%;
            max-width: 400px;
        }

        .modal-content input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
        }

        .modal-content button {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border: none;
            background: var(--primary-color);
            color: white;
            font-weight: bold;
            cursor: pointer;
        }



        /* ================= MODERN BACK BUTTON ================= */

        .back-wrapper {
            margin-bottom: 25px;
        }

        .modern-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 18px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--primary-color);
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
            transition: all .4s ease;
            position: relative;
            overflow: hidden;
        }

        /* hover background animation */
        .modern-back-btn::before {
            content: "";
            position: absolute;
            inset: 0;
            background: var(--primary-color);
            transform: translateX(-100%);
            transition: transform .4s ease;
            z-index: -1;
        }

        .modern-back-btn:hover::before {
            transform: translateX(0);
        }

        .modern-back-btn:hover {
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
        }

        /* arrow animation */
        .modern-back-btn .arrow {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 22px;
            height: 22px;
            transition: transform .3s ease;
        }

        .modern-back-btn svg {
            width: 100%;
            height: 100%;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }

        .modern-back-btn:hover .arrow {
            transform: translateX(-4px);
        }

        /* mobile adjust */
        @media (max-width:600px) {
            .modern-back-btn {
                padding: 8px 14px;
                font-size: 0.8rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="collection-container">
        <div class="back-wrapper">
            <a href="{{ route('home') }}" class="modern-back-btn">
                <span class="arrow">
                    <svg viewBox="0 0 24 24">
                        <path d="M15 18L9 12L15 6" />
                    </svg>
                </span>
                <span class="back-text">Back</span>
            </a>
        </div>
        <div class="collection-header">
            <h1>{{ $collectionName }}</h1>
            <span>{{ $products->count() }} Products</span>
        </div>

        <div class="product-grid">
            @foreach ($products as $product)
                <div class="product-card">

                    <div class="product-image-wrapper">
                        <a href="{{ route('product.show', $product->id) }}">

                            <img src="{{ asset('products/' . $product->image) }}" alt="{{ $product->name }}"
                                class="product-image">

                        </a>

                        {{-- Sale يظهر فقط لو عندك sale_price --}}
                        @if ($product->sale_price && $product->sale_price < $product->price)
                            <div class="sale-badge">Sale</div>
                        @endif
                    </div>

                    <div class="product-details">
                        <div class="product-name">
                            {{ $product->name }}
                        </div>

                        <div class="price-box">
                            @if ($product->sale_price && $product->sale_price < $product->price)
                                <div class="original-price">
                                    LE {{ number_format($product->price, 2) }}
                                </div>
                                <div class="current-price">
                                    LE {{ number_format($product->sale_price, 2) }}
                                </div>
                            @else
                                <div class="current-price">
                                    LE {{ number_format($product->price, 2) }}
                                </div>
                            @endif
                        </div>

                        <div class="card-actions">
                            <button class="btn-cart"
                                onclick="openModal({{ $product->id }}, {{ $product->sale_price ?? $product->price }})">
                                Add To Cart
                            </button>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    </div>


    <!-- Modal -->
    <div id="sizeModal" class="modal">
        <div class="modal-content">
            <h3>Measurement Details</h3>

            <input type="number" id="height" placeholder="Height (cm)">
            <input type="number" id="weight" placeholder="Weight (kg)">
            <input type="number" id="modalQty" value="1" min="1">

            <button onclick="confirmAddToCart()">Confirm</button>
            <button onclick="closeModal()" style="background:#999;margin-top:8px;">Cancel</button>
        </div>
    </div>

    <script>
        let selectedProductId = null;
        let selectedPrice = 0;

        function openModal(productId, price) {
            selectedProductId = productId;
            selectedPrice = price;
            document.getElementById('sizeModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('sizeModal').style.display = 'none';
        }

        function confirmAddToCart() {

            const height = document.getElementById('height').value;
            const weight = document.getElementById('weight').value;
            const qty = document.getElementById('modalQty').value;

            if (!height || !weight) {
                alert("Please enter height and weight");
                return;
            }

            fetch('/cart/api-add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        product_id: selectedProductId,
                        quantity: qty,
                        options: {
                            height: height,
                            weight: weight
                        }
                    })
                })
                .then(res => res.json())
                .then(data => {
                    window.location.href = "{{ route('cart.index') }}";
                })
                .catch(err => {
                    alert("حدث خطأ");
                    console.error(err);
                });

        }
    </script>
@endsection
