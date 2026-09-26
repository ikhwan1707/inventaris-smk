@extends('layouts.template')

@section('content')
<div class="login-wrapper">
    {{-- Glowing background shapes --}}
    <div class="login-bg-shape login-bg-shape-1"></div>
    <div class="login-bg-shape login-bg-shape-2"></div>

    {{-- Main centered card --}}
    <div class="login-card">

        {{-- Brand Identity --}}
        <a href="{{ url('/') }}" class="login-brand text-decoration-none">
            <i class="bi bi-asterisk"></i>
            <span>Inventaris SMK</span>
        </a>

        <p class="login-subtitle">Verify Your Email Address</p>

        {{-- Icon Badge --}}
        <div class="text-center mb-4">
            <div class="d-inline-flex align-items-center justify-content-center"
                style="width:80px;height:80px;border-radius:50%;background:rgba(99,102,241,0.1);">
                <i class="bi bi-envelope-check" style="font-size:2.5rem;color:#6366f1;"></i>
            </div>
        </div>

        {{-- Resent Alert --}}
        @if (session('resent'))
        <div class="alert alert-success" role="alert">
            <i class="bi bi-check-circle"></i>
            {{ __('A fresh verification link has been sent to your email address.') }}
        </div>
        @endif

        {{-- Info Message --}}
        <p class="text-center text-muted mb-3" style="font-size:0.9rem;">
            {{ __('Before proceeding, please check your email for a verification link.') }}
        </p>

        <p class="text-center text-muted mb-4" style="font-size:0.9rem;">
            {{ __('If you did not receive the email') }},
        </p>

        {{-- Resend Form --}}
        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf

            <button type="submit" class="btn-login" id="btn-submit">
                <span>{{ __('Request Another Link') }}</span>
                <i class="bi bi-arrow-clockwise"></i>
            </button>
        </form>

        {{-- Footer Link --}}
        <p class="login-footer-text mt-3">
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-left"></i> {{ __('Sign Out') }}
            </a>
        </p>

        {{-- Hidden Logout Form --}}
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>

    </div>
</div>
@endsection