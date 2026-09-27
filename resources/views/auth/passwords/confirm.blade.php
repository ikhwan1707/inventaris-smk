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

        <p class="login-subtitle">Please confirm your password before continuing</p>

        {{-- Icon Badge --}}
        <div class="text-center mb-4">
            <div class="d-inline-flex align-items-center justify-content-center"
                 style="width:80px;height:80px;border-radius:50%;background:rgba(99,102,241,0.1);">
                <i class="bi bi-shield-lock-fill" style="font-size:2.5rem;color:#6366f1;"></i>
            </div>
        </div>

        {{-- Confirm Password Form --}}
        <form method="POST" action="{{ route('password.confirm') }}" id="confirmForm" class="needs-validation" novalidate>
            @csrf

            {{-- Password --}}
            <div class="login-form-group">
                <label for="password" class="login-form-label">Password</label>
                <div class="login-input-group">
                    <i class="bi bi-shield-lock input-icon"></i>
                    <input type="password"
                           id="password"
                           name="password"
                           class="login-input login-input-password @error('password') is-invalid @enderror"
                           placeholder="••••••••"
                           required autocomplete="current-password" autofocus>
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

            {{-- Submit --}}
            <button type="submit" class="btn-login" id="btn-submit">
                <span>Confirm Password</span>
                <i class="bi bi-arrow-right"></i>
            </button>

        </form>

        {{-- Footer Link --}}
        <p class="login-footer-text">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" id="link-forgot">Forgot Your Password?</a>
            @endif
        </p>

    </div>
</div>
@endsection

@push('scripts')
<script>
    // Toggle show/hide password
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