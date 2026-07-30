@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('style')
    <style>
        :root {
            --olive-dark: #4E5146;
            --sage: #8F957D;
            --bg-soft: #F3F4EF;
            --text-main: #2B2E26;
            --cream: #E6E1D5;
            --gold-soft: #CBBF9A;
            --error-muted: #A55C5C;
            --white: #ffffff;
        }

        body {
            background-color: var(--bg-soft);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
        }

        .cart-container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        h1,
        h2,
        h3 {
            font-family: 'Playfair Display', serif;
            color: var(--olive-dark);
            margin-bottom: 1.5rem;
        }

        /* Layout Structure */
        .cart-wrapper {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 30px;
            align-items: start;
        }

        .cart-item:hover {
            background: rgba(0, 0, 0, 0.015);
        }

        .cart-item:hover .item-img {
            transform: scale(1.03);
        }

        .item-img {
            transition: transform .25s ease;
        }

        .item-title-link h3:hover {
            text-decoration: underline;
        }

        .cart-item-link,
        .item-title-link {
            text-decoration: none;
            color: inherit;
        }

        /* Cart Items Section */
        .cart-items-card {
            background: var(--white);
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        }

        .cart-item {
            display: grid;
            grid-template-columns: 100px 1fr auto;
            gap: 20px;
            padding: 20px 0;
            border-bottom: 1px solid var(--cream);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .item-img {
            width: 100px;
            height: 130px;
            object-fit: cover;
            border-radius: 8px;
            background: var(--bg-soft);
        }

        .item-info h3 {
            font-size: 1.2rem;
            margin-bottom: 5px;
            font-family: 'Inter', sans-serif;
            /* For better readability in product names */
            font-weight: 600;
        }

        .item-price {
            color: var(--sage);
            font-weight: 600;
            margin-bottom: 10px;
        }

        /* Controls */
        .item-actions {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 10px;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            border: 1.5px solid var(--cream);
            border-radius: 25px;
            padding: 2px 12px;
            background: var(--bg-soft);
        }

        .qty-btn {
            background: none;
            border: none;
            color: var(--olive-dark);
            font-size: 1.2rem;
            cursor: pointer;
            padding: 5px 10px;
            transition: color 0.2s;
        }

        .qty-btn:hover:not(:disabled) {
            color: var(--sage);
        }

        .qty-btn:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        .qty-val {
            min-width: 30px;
            text-align: center;
            font-weight: 600;
        }

        .remove-btn {
            background: none;
            border: none;
            color: var(--error-muted);
            cursor: pointer;
            font-size: 0.85rem;
            text-decoration: underline;
            opacity: 0.8;
        }

        .remove-btn:hover {
            opacity: 1;
        }

        /* Summary Card */
        .summary-card {
            background: var(--olive-dark);
            color: var(--cream);
            padding: 30px;
            border-radius: 12px;
            position: sticky;
            top: 20px;
        }

        .summary-card h2 {
            color: var(--gold-soft);
            margin-bottom: 25px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 0.95rem;
        }

        .summary-total {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid rgba(230, 225, 213, 0.2);
            display: flex;
            justify-content: space-between;
            font-size: 1.3rem;
            font-weight: bold;
        }

        .checkout-btn {
            width: 100%;
            background: var(--gold-soft);
            color: var(--olive-dark);
            border: none;
            padding: 16px;
            border-radius: 30px;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 25px;
            transition: transform 0.2s, background 0.2s;
        }

        .checkout-btn:hover {
            background: #d9cead;
            transform: translateY(-2px);
        }

        /* Empty Cart State */
        .empty-cart {
            text-align: center;
            padding: 60px 20px;
            background: var(--white);
            border-radius: 12px;
            grid-column: 1 / -1;
        }

        .empty-cart i {
            font-size: 4rem;
            color: var(--cream);
            display: block;
            margin-bottom: 20px;
        }

        .back-link {
            color: var(--sage);
            text-decoration: none;
            display: inline-block;
            margin-bottom: 30px;
            font-weight: 500;
        }

        /* Responsive */
        @media (max-width: 850px) {
            .cart-wrapper {
                grid-template-columns: 1fr;
            }

            .cart-item {
                grid-template-columns: 80px 1fr;
            }

            .item-total-side {
                grid-column: 2;
                text-align: left !important;
            }
        }

        .item-measurements {
            display: flex;
            gap: 10px;
            margin: 8px 0 4px;
        }

        .measure-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 20px;
            background: var(--bg-soft);
            border: 1px solid var(--cream);
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--olive-dark);
        }

        .measure-label {
            background: var(--olive-dark);
            color: var(--cream);
            font-size: 0.65rem;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 10px;
            line-height: 1;
        }

        .measure-value {
            opacity: 0.85;
        }
    </style>
@endsection

@section('content')
    <div class="cart-container">
        <a href="{{ route('home') }}" class="back-link">← Continue Shopping</a>

        <div class="cart-wrapper" id="cart-layout">
            <div id="cart-items-list" class="cart-items-card">
                <p style="text-align: center; padding: 40px;">Curating your selection...</p>
            </div>

            <div id="checkout-summary" class="summary-card">
                <h2>Order Summary</h2>
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span id="cart-subtotal">LE 0.00</span>
                </div>
                <div class="summary-row">
                    <span>Estimated Shipping</span>
                    <span>Calculated at next step</span>
                </div>
                <div class="summary-total">
                    <span>Total</span>
                    <span id="final-total">LE 0.00</span>
                </div>

                <form action="{{ route('checkout.show') }}" method="GET">
                    <button type="submit" class="checkout-btn">CHECKOUT</button>
                </form>

                <p style="font-size: 0.75rem; text-align: center; margin-top: 15px; opacity: 0.7;">
                    Secure payment & worldwide shipping available.
                </p>
            </div>
        </div>
    </div>

    <script>
        const CSRF_TOKEN = '{{ csrf_token() }}';
        const API_ROUTES = {
            index: '{{ route('cart.indexApi') }}',
            update: '{{ url('cart/api-update') }}',
            remove: '{{ url('cart/api-remove') }}'
        };

        async function fetchCart() {
            try {
                const response = await fetch(API_ROUTES.index);
                const data = await response.json();
                renderCart(data.items, data.total);
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('cart-items-list').innerHTML =
                    '<p style="color:var(--error-muted)">Unable to load cart.</p>';
            }
        }

        function renderCart(items, total) {
            const list = document.getElementById("cart-items-list");
            const summary = document.getElementById("checkout-summary");

            if (!items || items.length === 0) {
                summary.style.display = "none";
                list.innerHTML = `
                <div class="empty-cart">
                    <div style="font-size: 50px; margin-bottom: 20px;">🌿</div>
                    <h3>Your cart is empty</h3>
                    <p>It seems you haven't added any pieces to your collection yet.</p>
                    <a href="{{ route('home') }}" class="checkout-btn" style="display:inline-block; width:auto; padding: 12px 40px; text-decoration:none; margin-top:20px;">Explore Collections</a>
                </div>`;
                return;
            }

            summary.style.display = "block";
            list.innerHTML = "";
            items.forEach(item => {
                const p = item.product;
                const price = Number(item.price_snapshot);
                const itemTotal = price * item.quantity;

                const itemDiv = document.createElement("div");
                itemDiv.className = "cart-item";
                itemDiv.innerHTML = `
            <a href="/products/${p.id}" class="cart-item-link">
                <img src="/products/${p.image}" class="item-img" alt="${p.name}">
            </a>
                <div class="item-info">
                    <h3>${p.name}</h3>
                    <div class="item-price">LE ${price.toFixed(2)}</div>
                   <div class="item-measurements">
                                <span class="measure-chip">
                                    <span class="measure-label">H</span>
                                    <span class="measure-value">${item.options?.height} cm</span>
                                </span>

                                <span class="measure-chip">
                                    <span class="measure-label">W</span>
                                    <span class="measure-value">${item.options?.weight} kg</span>
                                </span>
                    </div>

                   <div class="item-actions">
                        <div class="quantity-selector">
                            <button class="qty-btn" onclick="updateQty(${item.id}, 'dec')" ${item.quantity <= 1 ? 'disabled' : ''}>&minus;</button>
                            <span class="qty-val">${item.quantity}</span>
                            <button class="qty-btn" onclick="updateQty(${item.id}, 'inc')">+</button>
                        </div>
                        <button class="remove-btn" onclick="removeItem(${item.id})">Remove</button>
                    </div>
                </div>
                <div class="item-total-side" style="text-align: right; font-weight: bold; color: var(--olive-dark);">
                    LE ${itemTotal.toFixed(2)}
                </div>
            `;
                list.appendChild(itemDiv);
            });

            const formattedTotal = `LE ${Number(total).toFixed(2)}`;
            document.getElementById("cart-subtotal").textContent = formattedTotal;
            document.getElementById("final-total").textContent = formattedTotal;
        }

        // دالة updateQty ستستقبل الآن الـ item_id
        async function updateQty(itemId, type) {
            const response = await fetch(`${API_ROUTES.update}/${itemId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify({
                    type
                })
            });
            const data = await response.json();
            renderCart(data.items, data.total);
        }

        // دالة removeItem ستستقبل الآن الـ item_id
        async function removeItem(itemId) {
            if (!confirm("Remove this item from your selection?")) return;
            const response = await fetch(`${API_ROUTES.remove}/${itemId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                }
            });
            const data = await response.json();
            renderCart(data.items, data.total);
        }
        document.addEventListener('DOMContentLoaded', fetchCart);
    </script>
@endsection
