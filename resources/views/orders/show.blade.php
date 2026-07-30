@extends('layouts.app')
@section('content')
    <div class="py-12 px-4 max-w-4xl mx-auto">
        <a href="{{ route('orders.index') }}" class="text-gray-500 mb-4 inline-block hover:underline">← Back to Orders</a>

        <div class="card-nay p-8">
            <div class="flex justify-between border-b pb-6 mb-6">
                <h2 class="text-2xl font-bold">Order Details #{{ $order->id }}</h2>
                <div class="text-right">
                    <p>Status: <span class="font-bold text-gold-soft">{{ ucfirst($order->status) }}</span></p>
                    <p>Deposit Paid:
                        <span class="font-bold {{ $order->is_deposited ? 'text-green-600' : 'text-error-muted' }}">
                            {{ $order->is_deposited ? 'Yes (15% Paid)' : 'Not Paid' }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="space-y-4">
                @foreach ($order->items as $item)
                    <div class="flex justify-between items-center bg-bg-soft p-4 rounded-xl">
                        <div>
                            <p class="font-bold">{{ $item->name }}</p>
                            <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                        </div>
                        <p class="font-semibold">{{ $item->price * $item->quantity }} EGP</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 pt-6 border-t border-dashed space-y-2">
                <div class="flex justify-between text-lg">
                    <span>Total Amount</span>
                    <span class="font-bold">{{ $order->total }} EGP</span>
                </div>
                <div class="flex justify-between items-center mt-2">
                    <span>Deposit (15%):</span>
                    @if ($order->is_deposited)
                        <span class="flex items-center text-green-600 font-bold">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            Paid
                        </span>
                    @else
                        <div class="text-right">
                            <span class="block text-error-muted font-bold mb-2">{{ number_format($depositAmount, 2) }}
                                EGP</span>


                           <button id="wa-btn-btn" class="btn-buy" onclick="openWhatsApp()">
    Confirm with Deposit
</button>

<script>
function openWhatsApp() {
    const orderId = {{ $order->id }};
    const phone = "201010542965";
    const text = encodeURIComponent(`Hi, I want to pay the deposit for order #${orderId}  it's (${{ number_format($depositAmount, 2) }} EGP)`);
    const url = `https://wa.me/${phone}?text=${text}`;
    window.open(url, "_blank"); // تفتح الرابط في تاب جديد
}
</script>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div id="orderModal" class="modal-overlay"
        style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
        <div class="modal-content bg-white p-8 rounded-2xl max-w-sm text-center">
            <h3 class="text-xl font-bold mb-4">Complete Payment</h3>
            <p class="mb-6 text-gray-600">Please contact us on WhatsApp to process your 15% deposit for Order
                #{{ $order->id }}.</p>
            <a id="wa-btn"
                href="https://wa.me/201010542965?text=Hi, I want to pay the deposit for order #{{ $order->id }}"
                target="_blank"
                class="bg-green-600 text-white px-6 py-3 rounded-full font-bold hover:bg-green-700 transition-all"
                style="display:inline-block; text-decoration:none;">
                Chat on WhatsApp
            </a>
            <button onclick="document.getElementById('orderModal').style.display='none'"
                class="block mt-4 text-sm text-gray-400 hover:text-black">Cancel</button>
        </div>
    </div>

    <script>
        function openWhatsAppModal() {
            document.getElementById('orderModal').style.display = 'flex';
        }
    </script>
    <style>
        .card-nay {
            background: white;
            border-radius: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .card-nay:hover {
            box-shadow: 0 10px 30px rgba(78, 81, 70, 0.15);
        }

        .btn-buy {
            background: var(--olive-dark);
            /* نفس لون Buy It Now */
            color: white;
            padding: 0.5rem 1.5rem;
            /* px-4 py-2 تقريبا */
            border-radius: 9999px;
            /* rounded-full */
            font-size: 0.875rem;
            /* text-sm */
            font-weight: 700;
            /* font-bold */
            transition: background 0.3s;
            /* hover transition */
            border: none;
            cursor: pointer;
        }

        .btn-buy:hover {
            background: var(--sage);
            /* نفس hover */
        }
    </style>
@endsection
