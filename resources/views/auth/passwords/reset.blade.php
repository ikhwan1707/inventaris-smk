@extends('layouts.template')

@section('content')
<div class="login-wrapper">
    {{-- Glowing background shapes --}}
    <div class="login-bg-shape login-bg-shape-1"></div>
    <div class="login-bg-shape login-bg-shape-2"></div>

    {{-- Main centered reset card --}}
    <div class="login-card">

        {{-- Brand Identity --}}
        <a href="{{ url('/') }}" class="login-brand text-decoration-none">
            <i class="bi bi-asterisk"></i>
            <span>Inventaris SMK</span>
        </a>

        <p class="login-subtitle">Create a new password for your account</p>

        {{-- Reset Password Form --}}
        <form method="POST" action="{{ route('password.update') }}" id="resetForm" class="needs-validation" novalidate>
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            {{-- Email --}}
            <div class="login-form-group">
                <label for="email" class="login-form-label">Email Address</label>
                <div class="login-input-group">
                    <i class="bi bi-envelope input-icon"></i>
                    <input type="email"
                           id="email"
                           name="email"
                           class="login-input @error('email') is-invalid @enderror"
                           placeholder="name@company.com"
                           value="{{ $email ?? old('email') }}"
                           required autocomplete="email" autofocus>
                </div>
                @error('email')
                    <small class="text-danger d-block mt-1">
                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                    </small>
                @enderror
            </div>

            {{-- New Password --}}
            <div class="login-form-group">
                <label for="password" class="login-form-label">New Password</label>
                <div class="login-input-group">
                    <i class="bi bi-shield-lock input-icon"></i>
                    <input type="password"
                           id="password"
                           name="password"
                           class="login-input login-input-password @error('password') is-invalid @enderror"
                           placeholder="••••••••"
                           required autocomplete="new-password">
                    <button type="button" class="password-toggle-btn" data-toggle="password" data-target="password" aria-label="Show password">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                @error('password')
                    <small class="text-danger d-block mt-1">
                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                    </small>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="login-form-group">
                <label for="password-confirm" class="login-form-label">Confirm New Password</label>
                <div class="login-input-group">
                    <i class="bi bi-shield-check input-icon"></i>
                    <input type="password"
                           id="password-confirm"
                           name="password_confirmation"
                           class="login-input login-input-password"
                           placeholder="••••••••"
                           required autocomplete="new-password">
                    <button type="button" class="password-toggle-btn" data-toggle="password" data-target="password-confirm" aria-label="Show password">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-login" id="btn-submit">
                <span>Reset Password</span>
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
@endsection

@push('scripts')
<script>
    // Toggle show/hide password (both fields)
    document.querySelectorAll('.password-toggle-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const input    = document.getElementById(targetId);
            const icon     = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });
</script>
@endpush