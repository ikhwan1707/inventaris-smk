@extends('layouts.template')
@section('content')
<div class="login-wrapper">
    <!-- Glowing background shapes for modern visual appearance -->
    <div class="login-bg-shape login-bg-shape-1"></div>
    <div class="login-bg-shape login-bg-shape-2"></div>

    <!-- Main centered login card -->
    <div class="login-card">

        <!-- Brand Identity -->
        <a href="" class="login-brand text-decoration-none">
            <i class="bi bi-asterisk"></i>
            <span>Inventaris SMK</span>
        </a>

        <p class="login-subtitle">Please sign in to access your dashboard</p>

        <!-- Login Form -->
        <form action="{{ route('login') }}" method="POST" id="loginForm" class="needs-validation">
            @csrf
            
            <!-- Email Input Group -->
            <div class="login-form-group">
                <label for="email" class="login-form-label">{{ __('E-Mail Address')
                }}</label>
                <div class="login-input-group">
                    <i class="bi bi-envelope input-icon"></i>
                    <input type="email" id="email" class="login-input @error('email') is-invalid @enderror" placeholder="name@company.com" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <!-- Password Input Group -->
            <div class="login-form-group">
                <label for="password" class="login-form-label">{{ __('Password')}}</label>
                <div class="login-input-group">
                    <i class="bi bi-shield-lock input-icon"></i>
                    <input type="password" id="password" name="password" class="login-input login-input-password @error('password') is-invalid @enderror" placeholder="••••••••"
                        required autocomplete="current-password">
                    <button type="button" class="password-toggle-btn" id="toggle-password" aria-label="Show password">
                        <i class="bi bi-eye"></i>
                    </button>

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <!-- Options (Remember me & Forgot Password) -->
            <div class="login-options">
                <label class="custom-control-label">
                    <input type="checkbox" class="custom-checkbox-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span>{{ __('Remember Me') }}</span>
                </label>

                @if (Route::has('password.request'))
                <a class="forgot-password-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-login" id="btn-submit">
                <span>Sign In to Dashboard</span>
                <i class="bi bi-arrow-right"></i>
            </button>

            
        </form>
        <p class="login-footer-text">
            Don't have an account? <a href="{{ route('register') }}" id="link-register">Register Now</a>
        </p>

    </div>
</div>

@endsection