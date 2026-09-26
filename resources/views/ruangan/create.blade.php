@extends('layouts.apps')

@section('content')

{{-- ==========================================
     START: Page Header + Breadcrumb
     ========================================== --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Add Location</h1>
        <p class="page-subtitle">Create a new location for inventory items</p>
    </div>

    @include('partials.breadcrumb', ['items' => [
        'Master Data' => '#',
        'Location'    => route('ruangan.index'),
        'Add'         => '',
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
                <i class="bi bi-door-open text-primary"></i> Location Information
            </h5>

            <form action="{{ route('ruangan.store') }}" method="POST" id="ruanganForm">
                @csrf

                {{-- Location Name --}}
                <div class="mb-3">
                    <label for="nama_ruangan" class="form-label-custom">
                        Location Name <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           name="nama_ruangan"
                           id="nama_ruangan"
                           class="form-control-custom @error('nama_ruangan') is-invalid-custom @enderror"
                           value="{{ old('nama_ruangan') }}"
                           placeholder="e.g. Computer Lab 1"
                           required
                           autofocus>
                    @error('nama_ruangan')
                        <div class="form-feedback-custom invalid-custom">
                            <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                        </div>
                    @else
                        <span class="text-muted" style="font-size: 12px;">
                            Use a clear location name, e.g. <strong>Computer Lab 1</strong>,
                            <strong>Teacher Room</strong>, or <strong>Library</strong>.
                        </span>
                    @enderror
                </div>

                <hr class="my-4">

                {{-- Action Buttons --}}
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('ruangan.index') }}" class="btn-table-action">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                    <button type="submit" class="btn-table-action btn-primary-action">
                        <i class="bi bi-check-lg"></i> Save Location
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
                    <div class="me-2" style="color:#0ea5e9;">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Use unique names</div>
                        <div class="text-muted" style="font-size:12px;">
                            Each location name must be unique to avoid confusion.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-start">
                    <div class="me-2" style="color:#0ea5e9;">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Keep it descriptive</div>
                        <div class="text-muted" style="font-size:12px;">
                            Include room type and number for better identification.
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
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Cannot be deleted if used</div>
                        <div class="text-muted" style="font-size:12px;">
                            Locations with linked items cannot be removed.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-auto pt-3 border-top">
                <a href="{{ route('ruangan.index') }}"
                   class="text-decoration-none"
                   style="font-size:13px;color:#072F1F;">
                    <i class="bi bi-arrow-right"></i> View all locations
                </a>
            </div>
        </div>
    </div>
</div>
{{-- END: Form Card --}}

@endsection