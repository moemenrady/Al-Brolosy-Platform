@extends('layouts.app')

@section('title', 'Order Success')

@section('style')
<style>
    .success-wrapper {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        min-height: 70vh;
        padding: 2rem;
        animation: fadeInScale 0.8s cubic-bezier(0.23, 1, 0.32, 1) forwards;
    }

    @keyframes fadeInScale {
        0% { opacity: 0; transform: scale(0.8) translateY(20px);}
        60% { opacity: 1; transform: scale(1.05) translateY(-10px);}
        100% { opacity: 1; transform: scale(1) translateY(0);}
    }

    .success-icon {
        font-size: 100px;
        color: #1a4139;
        margin-bottom: 1rem;
        animation: bounce 1s ease-in-out;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
        40% {transform: translateY(-20px);}
        60% {transform: translateY(-10px);}
    }

    .success-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1a4139;
        margin-bottom: 0.5rem;
    }

    .success-message {
        font-size: 1.1rem;
        color: #624641;
        margin-bottom: 2rem;
    }

    .btn-home {
        padding: 12px 28px;
        background-color: #1a4139;
        color: white;
        font-weight: 700;
        font-size: 16px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-home:hover {
        opacity: 0.9;
        transform: scale(1.05);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .success-title {
            font-size: 1.6rem;
        }
        .success-message {
            font-size: 1rem;
        }
        .success-icon {
            font-size: 80px;
        }
    }
</style>
@endsection

@section('content')
<div class="success-wrapper">
    <div class="success-icon">
        <i class="fa-solid fa-circle-check"></i>
    </div>
    <div class="success-title">Thank You!</div>
    <div class="success-message">
        Your order has been successfully placed.<br>
        It will reach you within a short time.
    </div>
    <a href="{{ route('home.create') }}">
        <button class="btn-home">Back to Home</button>
    </a>
</div>
@endsection
