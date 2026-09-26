@extends('layouts.template')

@section('content')
{{-- ==========================================
START: Authentication Container & Reset Card
========================================== --}}
<div class="login-wrapper">
    {{-- Glowing background shapes for modern visual appearance --}}
    <div class="login-bg-shape login-bg-shape-1"></div>
    <div class="login-bg-shape login-bg-shape-2"></div>

    {{-- Main centered reset card --}}
    <div class="login-card">

        {{-- Brand Identity --}}
        <a href="{{ url('/') }}" class="login-brand text-decoration-none">
            <i class="bi bi-asterisk"></i>
            <span>Inventaris SMK</span>
        </a>

        <p class="login-subtitle">Reset your password to regain access</p>

        {{-- Reset Password Form --}}
        <form method="POST" action="{{ route('password.email') }}" id="resetForm" class="needs-validation" novalidate>
            @csrf

            {{-- Status Alert --}}
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                <i class="bi bi-check-circle"></i>
                {{ session('status') }}
            </div>
            @endif

            {{-- Info Message --}}
            <p class="text-center text-muted mb-4" style="font-size:0.875rem;">
                {{ __('Enter your email address and we will send you a link to reset your password.') }}
            </p>

            {{-- Email Input Group --}}
            <div class="login-form-group">
                <label for="email" class="login-form-label">Email Address</label>
                <div class="login-input-group">
                    <i class="bi bi-envelope input-icon"></i>
                    <input type="email" id="email" name="email" class="login-input @error('email') is-invalid @enderror"
                        placeholder="name@company.com" value="{{ old('email') }}" required autocomplete="email"
                        autofocus>
                </div>
                @error('email')
                <small class="text-danger d-block mt-1">
                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                </small>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn-login" id="btn-submit">
                <span>{{ __('Send Reset Link') }}</span>
                <i class="bi bi-arrow-right"></i>
            </button>

        </form>

        {{-- Footer Link --}}
        <p class="login-footer-text">
            Remember your password?
            <a href="{{ route('login') }}" id="link-login">Back to Login</a>
        </p>

    </div>
</div>
{{-- END: Authentication Container --}}
@endsection