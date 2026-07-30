@extends('layouts.app')

@section('style')
    <style>
        :root {
            --olive-dark: #4E5146;
            --sage: #8F957D;
            --bg-soft: #F3F4EF;
            --cream: #E6E1D5;
            --gold-soft: #CBBF9A;
            --text-main: #2B2E26;
            --shadow-sm: 0 4px 6px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 15px 35px rgba(0, 0, 0, 0.08);
        }

        /* --- Animations --- */
        @keyframes slideUpFade {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes popIn {
            0% {
                opacity: 0;
                transform: scale(0.9);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* --- Layout --- */
        .checkout-wrapper {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 40px;
            max-width: 1100px;
            margin: 50px auto;
            padding: 0 20px;
            align-items: start;
            /* Important for sticky summary */
            animation: slideUpFade 0.6s ease-out forwards;
        }

        .checkout-form,
        .order-summary {
            background: #fff;
            padding: 35px;
            border-radius: 20px;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(230, 225, 213, 0.5);
        }

        .order-summary {
            position: sticky;
            top: 30px;
            /* Keeps summary visible on scroll for desktop */
        }

        h2 {
            font-family: 'Playfair Display', serif;
            color: var(--olive-dark);
            margin-bottom: 25px;
            font-size: 1.8rem;
            position: relative;
        }

        h2::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -8px;
            width: 50px;
            height: 3px;
            background: var(--sage);
            border-radius: 2px;
        }

        /* --- Form Elements --- */
        .input-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        input {
            width: 100%;
            padding: 16px;
            margin-bottom: 15px;
            border: 1.5px solid var(--cream);
            border-radius: 12px;
            font-size: 1rem;
            color: var(--text-main);
            background: #FAFAFA;
            transition: all 0.3s ease;
        }

        input::placeholder {
            color: #A0A0A0;
        }

        input:focus {
            background: #FFF;
            border-color: var(--sage);
            outline: none;
            box-shadow: 0 0 0 4px rgba(143, 149, 125, 0.15);
            transform: translateY(-2px);
        }

        /* --- Buttons --- */
        .btn-primary {
            width: 100%;
            padding: 18px;
            background: var(--olive-dark);
            color: #fff;
            border: none;
            border-radius: 30px;
            font-size: 1.1rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: var(--shadow-sm);
            margin-top: 10px;
        }

        .btn-primary:hover {
            background: var(--sage);
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(143, 149, 125, 0.3);
        }

        .btn-primary:active {
            transform: translateY(1px);
        }

        /* --- Order Items --- */
        .order-item {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            align-items: center;
            padding: 10px;
            border-radius: 12px;
            transition: background 0.3s;
        }

        .order-item:hover {
            background: var(--bg-soft);
        }

        .order-item img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: var(--shadow-sm);
        }

        .order-item-details {
            flex: 1;
            font-size: 0.95rem;
        }

        .order-item-details .item-name {
            font-weight: 700;
            color: var(--olive-dark);
            font-size: 1.05rem;
            margin-bottom: 4px;
        }

        /* --- Summary Row --- */
        .summary-row {
            display: flex;
            justify-content: space-between;
            font-size: 1.05rem;
            margin-bottom: 12px;
            color: var(--text-main);
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--olive-dark);
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px dashed var(--cream);
        }

        /* --- Modal --- */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(43, 46, 38, 0.6);
            backdrop-filter: blur(5px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal-overlay.active {
            display: flex;
            opacity: 1;
        }

        .modal-content {
            background: #fff;
            padding: 40px;
            border-radius: 24px;
            max-width: 450px;
            width: 90%;
            text-align: center;
            box-shadow: var(--shadow-lg);
            animation: popIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }

        .modal-content h3 {
            color: var(--olive-dark);
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            margin-bottom: 15px;
        }

        .modal-content p {
            color: var(--text-main);
            margin-bottom: 25px;
            line-height: 1.6;
        }

        /* --- Responsive Design (Mobile & Tablet) --- */
        @media (max-width: 900px) {
            .checkout-wrapper {
                grid-template-columns: 1fr;
                gap: 30px;
                padding: 0 15px;
                margin: 30px auto;
            }

            .order-summary {
                position: relative;
                top: 0;
                order: -1;
                /* Puts the order summary above the form on mobile */
            }

            .input-row {
                grid-template-columns: 1fr;
                /* Stack inputs on small screens */
                gap: 0;
            }
        }

        /* إضافة في قسم الـ <style> */

        /* أنيميشن احتفالي للمودال */
        @keyframes modernBounce {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }

            70% {
                transform: scale(1.05);
                opacity: 1;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* تأثير النبض لزرار الواتساب ليجذب الانتباه */
        @keyframes pulse-green {
            0% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
            }

            70% {
                box-shadow: 0 0 0 15px rgba(37, 211, 102, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
            }
        }

        .modal-content {
            animation: modernBounce 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            border: 3px solid var(--sage);
        }

        .btn-whatsapp {
            background-color: #25D366 !important;
            animation: pulse-green 2s infinite;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .deposit-highlight {
            background: #fdfae9;
            padding: 15px;
            border-radius: 12px;
            border-left: 5px solid var(--gold-soft);
            margin: 20px 0;
            font-size: 1.1rem;
        }

        .deposit-highlight strong {
            color: #d4af37;
            font-size: 1.4rem;
        }
    </style>
@endsection
@section('content')
    @if (session()->has('show_modal'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const orderId = @json(session('order_id'));
                const totalAmount = @json(session('total_amount'));
                const depositAmount = @json(session('deposit_amount'));
                const customerName = @json(session('customer_name'));
                const phoneNumber = "201033009513"; // Your dedicated business number

                const modal = document.getElementById('orderModal');
                const waBtn = document.getElementById('wa-btn');

                if (modal && orderId) {
                    // Triggering the active class for that smooth pop-in animation
                    modal.classList.add('active');

                    // Crafting a high-end, structured WhatsApp message
                    const message =
                        ` *NEW ORDER CONFIRMATION* #${orderId}\n` +
                        `--------------------------\n` +
                        ` *Customer:* ${customerName}\n` +
                        ` *Total Amount:* ${totalAmount.toFixed(2)} EGP\n` +
                        ` *Required Deposit (15%):* ${depositAmount.toFixed(2)} EGP\n` +
                        `--------------------------\n` +
                        `Need To Pay Deposit To Confirm My Order. send me the payment details! `;

                    waBtn.href = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
                }
            });
        </script>
    @endif

    <div class="checkout-wrapper">
        <form id="checkout-form" action="{{ route('checkout.submit') }}" method="POST" class="checkout-form">
            @csrf
            <h2>Shipping Information</h2>

            <div class="input-row">
                <input type="text" name="first_name" placeholder="First Name" required>
                <input type="text" name="last_name" placeholder="Last Name" required>
            </div>

            <div class="input-row">
                <input type="text" name="phone" placeholder="Phone Number" required>
                <input type="email" name="email" placeholder="Email (Optional)">
            </div>

            <input type="text" name="address" placeholder="Full Address (Street, Building, etc.)" required>

            <div class="input-row">
                <input type="text" name="city" placeholder="City" required>
                <input type="text" name="governorate" placeholder="Governorate" required>
            </div>

            <div class="input-row">
                <input type="text" name="apartment" placeholder="Apartment / Flat (Optional)">
                <input type="text" name="postal_code" placeholder="Postal Code (Optional)">
            </div>

            <button type="submit" class="btn-primary">CONFIRM MY ORDER ➔</button>
        </form>

        <div class="order-summary">
            <h2>Order Summary</h2>
            @foreach ($cart->items as $item)
                <div class="order-item">
                    <img src="{{ asset('products/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                    <div class="order-item-details">
                        <span class="item-name">{{ $item->product->name }}</span>
                        <div style="display: flex; justify-content: space-between; margin-top: 5px;">
                            <span>{{ $item->quantity }}x LE {{ number_format($item->price_snapshot, 2) }}</span>
                            <strong>LE {{ number_format($item->price_snapshot * $item->quantity, 2) }}</strong>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="summary-total"
                style="border-top: 1px solid var(--cream); margin-top: 15px; padding-top: 15px; font-size: 1.1rem; border-bottom: none;">
                <span style="font-weight: normal;">Subtotal:</span>
                <span>LE {{ number_format($cart->total(), 2) }}</span>
            </div>

            <div class="summary-row" style="color: var(--sage); font-weight: bold;">
                <span>Deposit to confirm (15%):</span>
                <span>LE {{ number_format($cart->total() * 0.15, 2) }}</span>
            </div>

            <div class="summary-total">
                <span>Total:</span>
                <span>LE {{ number_format($cart->total(), 2) }}</span>
            </div>
        </div>
    </div>

    <div id="orderModal" class="modal-overlay">
        <div class="modal-content">
            <div style="font-size: 4.5rem; margin-bottom: 15px; filter: drop-shadow(0 5px 15px rgba(0,0,0,0.1));">🎉</div>
            <h3>Yay! Order Received!</h3>
            <p>We're so excited to get your order ready. To secure your items and start the shipping process, a small
                deposit is required:</p>

            <div class="deposit-highlight">
                You Have To Pay:<br>
                <strong>LE {{ session('deposit_amount') ? number_format(session('deposit_amount'), 2) : '0.00' }}</strong>
            </div>

            <p style="font-size: 0.95rem; color: #555; margin-bottom: 30px;">
                Tap the button below to chat with us on WhatsApp. We’ll help you finalize the payment in seconds! ⚡
            </p>

            <a id="wa-btn" href="#" target="_blank" class="btn-primary btn-whatsapp"
                style="text-decoration:none; width: 100%;">
                <svg width="22" height="22" fill="white" viewBox="0 0 24 24" style="margin-right: 8px;">
                    <path
                        d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.319 1.592 5.448 0 9.886-4.438 9.889-9.886.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.735-.98zm11.367-7.312c-.31-.156-1.834-.905-2.112-1.006-.279-.101-.481-.156-.684.156-.202.311-.785 1.006-.962 1.211-.177.206-.353.23-.663.074-.31-.156-1.31-.483-2.495-1.54-.922-.822-1.544-1.837-1.724-2.149-.181-.312-.019-.481.136-.636.14-.139.31-.361.466-.541.156-.181.208-.311.31-.52.102-.208.052-.389-.026-.544-.078-.156-.684-1.649-.938-2.259-.247-.595-.499-.514-.684-.523-.176-.009-.379-.011-.582-.011-.203 0-.532.076-.811.381-.278.305-1.064 1.042-1.064 2.542 0 1.5 1.089 2.946 1.241 3.15.152.204 2.145 3.275 5.195 4.59.725.313 1.291.5 1.731.64.728.231 1.391.198 1.915.12.584-.087 1.834-.75 2.088-1.474.253-.724.253-1.343.177-1.474-.076-.131-.278-.206-.588-.362z" />
                </svg>
                CONFIRM ON WHATSAPP
            </a>
        </div>
    </div>
@endsection
