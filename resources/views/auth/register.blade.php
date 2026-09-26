@extends('layouts.template')

@section('content')
<div class="login-wrapper">
    {{-- Glowing background shapes --}}
    <div class="login-bg-shape login-bg-shape-1"></div>
    <div class="login-bg-shape login-bg-shape-2"></div>

    {{-- Main centered register card --}}
    <div class="login-card">

        {{-- Brand Identity --}}
        <a href="{{ url('/') }}" class="login-brand text-decoration-none">
            <i class="bi bi-asterisk"></i>
            <span>Inventaris SMK</span>
        </a>

        <p class="login-subtitle">Create a new account to access the dashboard</p>

        {{-- Register Form --}}
        <form method="POST" action="{{ route('register') }}" id="registerForm" class="needs-validation" novalidate>
            @csrf

            {{-- Name --}}
            <div class="login-form-group">
                <label for="name" class="login-form-label">Full Name</label>
                <div class="login-input-group">
                    <i class="bi bi-person input-icon"></i>
                    <input type="text" id="name" name="name" class="login-input @error('name') is-invalid @enderror"
                        placeholder="e.g. your name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                </div>
                @error('name')
                <small class="text-danger d-block mt-1">
                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                </small>
                @enderror
            </div>

            {{-- Email --}}
            <div class="login-form-group">
                <label for="email" class="login-form-label">Email Address</label>
                <div class="login-input-group">
                    <i class="bi bi-envelope input-icon"></i>
                    <input type="email" id="email" name="email" class="login-input @error('email') is-invalid @enderror"
                        placeholder="name@company.com" value="{{ old('email') }}" required autocomplete="email">
                </div>
                @error('email')
                <small class="text-danger d-block mt-1">
                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                </small>
                @enderror
            </div>

            {{-- Password --}}
            <div class="login-form-group">
                <label for="password" class="login-form-label">Password</label>
                <div class="login-input-group">
                    <i class="bi bi-shield-lock input-icon"></i>
                    <input type="password" id="password" name="password"
                        class="login-input login-input-password @error('password') is-invalid @enderror"
                        placeholder="••••••••" required autocomplete="new-password">
                    <button type="button" class="password-toggle-btn" data-toggle="password" data-target="password"
                        aria-label="Show password">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                @error('password')
                <small class="text-danger d-block mt-1">
                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                </small>
                @enderror
            </div>

            {{-- Password Confirmation --}}
            <div class="login-form-group">
                <label for="password-confirm" class="login-form-label">Confirm Password</label>
                <div class="login-input-group">
                    <i class="bi bi-shield-check input-icon"></i>
                    <input type="password" id="password-confirm" name="password_confirmation"
                        class="login-input login-input-password" placeholder="••••••••" required
                        autocomplete="new-password">
                    <button type="button" class="password-toggle-btn" data-toggle="password"
                        data-target="password-confirm" aria-label="Show password">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-login" id="btn-submit">
                <span>Register Now</span>
                <i class="bi bi-arrow-right"></i>
            </button>

        </form>

        {{-- Footer Link --}}
        <p class="login-footer-text">
            Already have an account? <a href="{{ route('login') }}">Sign in here</a>
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