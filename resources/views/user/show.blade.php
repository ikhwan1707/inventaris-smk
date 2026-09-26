@extends('layouts.apps')

@section('content')

{{-- ==========================================
     START: Page Header + Breadcrumb
     ========================================== --}}
<div class="page-header">
    <div>
        <h1 class="page-title">User Detail</h1>
        <p class="page-subtitle">Detailed information of {{ $data->name }}</p>
    </div>

    @include('partials.breadcrumb', ['items' => [
        'Settings' => '#',
        'Users'    => route('user.index'),
        'Detail'   => '',
    ]])
</div>
{{-- END: Page Header --}}


{{-- ==========================================
     START: Alert
     ========================================== --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
{{-- END: Alert --}}


{{-- ==========================================
     START: Detail Card
     ========================================== --}}
<div class="row g-4 mb-4">
    <div class="col-12 col-lg-8">
        <div class="card border-light shadow-sm p-4 h-100">

            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <h5 class="card-title mb-0">
                    <i class="bi bi-info-circle text-primary"></i> User Information
                </h5>
                @if($data->id == auth()->id())
                    <span class="badge-table success">
                        <i class="bi bi-person-check-fill"></i> You
                    </span>
                @endif
            </div>

            {{-- Detail Table --}}
            <div class="table-responsive">
                <table class="table-custom">
                    <tbody>
                        <tr>
                            <th width="220" style="background:#f8f9fa;">User ID</th>
                            <td>
                                <span class="badge-table" style="background:#e5e7eb;color:#072F1F;">
                                    #USR-{{ str_pad($data->id, 3, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th style="background:#f8f9fa;">Full Name</th>
                            <td>
                                <div class="table-user-cell">
                                    <div class="table-user-avatar"
                                         style="background:#6366f1;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <div>
                                        <div class="table-user-name">{{ $data->name }}</div>
                                        <div class="table-user-sub">
                                            Registered user
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th style="background:#f8f9fa;">Email Address</th>
                            <td>
                                <i class="bi bi-envelope text-muted-green"></i>
                                {{ $data->email }}
                            </td>
                        </tr>
                        <tr>
                            <th style="background:#f8f9fa;">Registered At</th>
                            <td>
                                <i class="bi bi-calendar-plus text-muted-green"></i>
                                {{ $data->created_at->translatedFormat('d F Y, H:i') }} WIB
                            </td>
                        </tr>
                        <tr>
                            <th style="background:#f8f9fa;">Last Updated</th>
                            <td>
                                <i class="bi bi-clock-history text-muted-green"></i>
                                {{ $data->updated_at->translatedFormat('d F Y, H:i') }} WIB
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <hr class="my-4">

            {{-- Action Buttons --}}
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <a href="{{ route('user.index') }}" class="btn-table-action">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                <div class="d-flex gap-2">
                    <a href="{{ route('user.edit', $data->id) }}"
                       class="btn-table-action btn-primary-action">
                        <i class="bi bi-pencil"></i> Edit User
                    </a>
                </div>
            </div>

        </div>
    </div>

    {{-- Side Info Panel --}}
    <div class="col-12 col-lg-4">
        <div class="card border-light shadow-sm p-4 h-100">
            <h5 class="card-title mb-4">
                <i class="bi bi-lightbulb text-warning"></i> Quick Info
            </h5>

            <div class="mb-3">
                <div class="d-flex align-items-start">
                    <div class="me-2" style="color:#6366f1;">
                        <i class="bi bi-person-circle"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">
                            {{ $data->name }}
                        </div>
                        <div class="text-muted" style="font-size:12px;">
                            Registered user account.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-start">
                    <div class="me-2" style="color:#0ea5e9;">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">
                            {{ $data->email }}
                        </div>
                        <div class="text-muted" style="font-size:12px;">
                            Login email address.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-start">
                    <div class="me-2" style="color:#22c55e;">
                        <i class="bi bi-calendar-check-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">
                            {{ $data->created_at->diffForHumans() }}
                        </div>
                        <div class="text-muted" style="font-size:12px;">
                            User was first registered.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-start">
                    <div class="me-2" style="color:#f59e0b;">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">
                            {{ $data->updated_at->diffForHumans() }}
                        </div>
                        <div class="text-muted" style="font-size:12px;">
                            Last time updated.
                        </div>
                    </div>
                </div>
            </div>

            @if($data->id == auth()->id())
                <div class="alert alert-info mb-0" style="font-size: 12px;">
                    <i class="bi bi-info-circle-fill"></i>
                    This is your own account.
                </div>
            @else
                <div class="alert alert-success mb-0" style="font-size: 12px;">
                    <i class="bi bi-check-circle-fill"></i>
                    Active user account.
                </div>
            @endif
        </div>
    </div>
</div>
{{-- END: Detail Card --}}

@endsection