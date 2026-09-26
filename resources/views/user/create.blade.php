@extends('layouts.apps')

@section('content')

{{-- ==========================================
     START: Page Header + Breadcrumb
     ========================================== --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Add User</h1>
        <p class="page-subtitle">Create a new user account</p>
    </div>

    @include('partials.breadcrumb', ['items' => [
        'Settings' => '#',
        'Users'    => route('user.index'),
        'Add'      => '',
    ]])
</div>
{{-- END: Page Header --}}


{{-- ==========================================
     START: Alert
     ========================================== --}}
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle"></i>
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
{{-- END: Alert --}}


{{-- ==========================================
     START: Form Card
     ========================================== --}}
<div class="row g-4 mb-4 justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card border-light shadow-sm p-4">

            <h5 class="card-title mb-4">
                <i class="bi bi-person-plus text-primary"></i> User Information
            </h5>

            <form action="{{ route('user.store') }}" method="POST" id="userForm">
                @csrf

                {{-- =====================
                     Name
                ====================== --}}
                <div class="mb-3">
                    <label for="name" class="form-label-custom">
                        Full Name <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           name="name"
                           id="name"
                           class="form-control-custom @error('name') is-invalid-custom @enderror"
                           value="{{ old('name') }}"
                           placeholder="e.g. John Doe"
                           required
                           autofocus>
                    @error('name')
                        <div class="form-feedback-custom invalid-custom">
                            <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- =====================
                     Email
                ====================== --}}
                <div class="mb-3">
                    <label for="email" class="form-label-custom">
                        Email Address <span class="text-danger">*</span>
                    </label>
                    <input type="email"
                           name="email"
                           id="email"
                           class="form-control-custom @error('email') is-invalid-custom @enderror"
                           value="{{ old('email') }}"
                           placeholder="e.g. john@smk.sch.id"
                           required>
                    @error('email')
                        <div class="form-feedback-custom invalid-custom">
                            <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                        </div>
                    @else
                        <span class="text-muted" style="font-size: 12px;">
                            Must be unique and used for login.
                        </span>
                    @enderror
                </div>

                {{-- =====================
                     Password
                ====================== --}}
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-6">
                        <label for="password" class="form-label-custom">
                            Password <span class="text-danger">*</span>
                        </label>
                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control-custom @error('password') is-invalid-custom @enderror"
                               placeholder="Minimum 6 characters"
                               required>
                        @error('password')
                            <div class="form-feedback-custom invalid-custom">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </div>
                        @else
                            <span class="text-muted" style="font-size: 12px;">
                                Minimum 6 characters.
                            </span>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="password_confirmation" class="form-label-custom">
                            Confirm Password <span class="text-danger">*</span>
                        </label>
                        <input type="password"
                               name="password_confirmation"
                               id="password_confirmation"
                               class="form-control-custom"
                               placeholder="Repeat password"
                               required>
                    </div>
                </div>

                <hr class="my-4">

                {{-- Action Buttons --}}
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('user.index') }}" class="btn-table-action">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                    <button type="submit" class="btn-table-action btn-primary-action">
                        <i class="bi bi-check-lg"></i> Save User
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- Side Info Panel --}}
    <div class="col-12 col-lg-4">
        <div class="card border-light shadow-sm p-4 h-100">
            <h5 class="card-title mb-4">
                <i class="bi bi-info-circle text-primary"></i> Guidelines
            </h5>

            <div class="mb-3">
                <div class="d-flex align-items-start">
                    <div class="me-2" style="color:#6366f1;">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Unique email</div>
                        <div class="text-muted" style="font-size:12px;">
                            Each user must have a unique email address.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-start">
                    <div class="me-2" style="color:#6366f1;">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Strong password</div>
                        <div class="text-muted" style="font-size:12px;">
                            Use at least 6 characters for better security.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-start">
                    <div class="me-2" style="color:#f59e0b;">
                        <i class="bi bi-exclamation-circle-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Confirm password</div>
                        <div class="text-muted" style="font-size:12px;">
                            Re-enter the password to make sure there's no typo.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-start">
                    <div class="me-2" style="color:#ef4444;">
                        <i class="bi bi-x-circle-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Cannot delete self</div>
                        <div class="text-muted" style="font-size:12px;">
                            You cannot delete your own account from the list.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-auto pt-3 border-top">
                <a href="{{ route('user.index') }}"
                   class="text-decoration-none d-block"
                   style="font-size:13px;color:#072F1F;">
                    <i class="bi bi-arrow-right"></i> View all users
                </a>
            </div>
        </div>
    </div>
</div>
{{-- END: Form Card --}}

@endsection