@extends('layouts.app')
@section('content')
<div class="py-12 px-4 max-w-5xl mx-auto">
    <h1 class="text-3xl font-bold text-olive-dark mb-8">My Orders</h1>
     <div class="back-nav px-4 sm:px-6 lg:px-8 mb-4">
            <a href="{{ route('home') }}" class="btn-back">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Back to Home
            </a>
        </div>
    <div class="space-y-4">
        @foreach($orders as $order)
        <a href="{{ route('orders.show', $order->id) }}" 
           class="card-nay p-6 block transition-all duration-300 hover:scale-[1.01] hover:shadow-xl hover:border-gold-soft border border-transparent">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-lg">Order #{{ $order->id }}</h3>
                    <p class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y - h:i A') }}</p>
                </div>
                <div class="text-right">
                    <span class="block font-bold text-lg" style="color: var(--olive-dark)">{{ $order->total }} EGP</span>
                    <span class="text-xs px-2 py-1 rounded-full" style="background: var(--cream)">{{ $order->status }}</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
<style>
    .card-nay {
    background: white;
    border-radius: 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    border: 1px solid rgba(0,0,0,0.05);
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.card-nay:hover {
    box-shadow: 0 10px 30px rgba(78, 81, 70, 0.15);
}
</style>
@endsection