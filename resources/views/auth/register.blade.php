@extends('layouts.guest')

@section('content')
<div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white shadow-xl overflow-hidden sm:rounded-2xl border border-gray-100">

    <!-- Logo -->
    <div class="login-logo-wrapper">
        <img src="{{ asset('nay_logo.png') }}" alt="Nay Logo" id="login-logo">
    </div>

    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold tracking-tight" style="color: var(--olive-dark)">
            Join Nay
        </h2>

        <p class="text-sm mt-2 text-gray-500">
            Create your account to start shopping
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-5">
            <label class="block text-sm font-medium mb-1" style="color: var(--olive-dark)">
                Full Name
            </label>

            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                class="input-custom block w-full border-gray-300 rounded-lg shadow-sm"
            >

            @error('name')
                <span class="text-xs mt-1" style="color: var(--error-muted)">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-5">
            <label class="block text-sm font-medium mb-1" style="color: var(--olive-dark)">
                Email Address
            </label>

            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                class="input-custom block w-full border-gray-300 rounded-lg shadow-sm"
            >

            @error('email')
                <span class="text-xs mt-1" style="color: var(--error-muted)">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-5">
            <label class="block text-sm font-medium mb-1" style="color: var(--olive-dark)">
                Password
            </label>

            <input
                id="password"
                type="password"
                name="password"
                required
                class="input-custom block w-full border-gray-300 rounded-lg shadow-sm"
            >

            @error('password')
                <span class="text-xs mt-1" style="color: var(--error-muted)">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <label class="block text-sm font-medium mb-1" style="color: var(--olive-dark)">
                Confirm Password
            </label>

            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                class="input-custom block w-full border-gray-300 rounded-lg shadow-sm"
            >
        </div>

        <!-- Register Button -->
        <button
            type="submit"
            class="btn-olive w-full py-3 rounded-lg font-semibold text-lg shadow-lg mb-4"
        >
            Create Account
        </button>

        <div class="text-center mb-6">
            <span class="text-sm text-gray-600">
                Already have an account?
            </span>

            <a href="{{ route('login') }}"
                class="text-sm font-semibold ms-1 hover:underline"
                style="color: var(--olive-dark)">
                Sign in
            </a>
        </div>

        <!-- Divider -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>

            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-400">
                    Or sign up with
                </span>
            </div>
        </div>

        <!-- Google Register -->
        <a href="{{ url('auth/google') }}"
            class="flex items-center justify-center w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-white hover:bg-gray-50 transition-all text-sm font-medium text-gray-700">

            <svg class="w-5 h-5 mr-2" viewBox="0 0 48 48">
                <path fill="#FFC107"
                    d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24s8.955,20,20,20s20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z">
                </path>
            </svg>

            Sign up with Google
        </a>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const logo = document.getElementById("login-logo");
    if (logo) {
        setTimeout(() => {
            logo.classList.add("show");
        }, 150);
    }
});
</script>
@endsection