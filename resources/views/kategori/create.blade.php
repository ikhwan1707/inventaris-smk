@extends('layouts.apps')

@section('content')

{{-- ==========================================
     START: Page Header + Breadcrumb
     ========================================== --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Add Category</h1>
        <p class="page-subtitle">Create a new category for inventory items</p>
    </div>

    @include('partials.breadcrumb', ['items' => [
    'Master Data' => '#',
    'Category' => route('kategori.index'),
    'Add'         => '',
    ]])
</div>
{{-- EN
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
                <i class="bi bi-tags text-success"></i> Category Information
            </h5>

            <form action="{{ route('kategori.store') }}" method="POST" id="kategoriForm">
                @csrf

                {{-- Category Name --}}
                <div class="mb-3">
                    <label for="nama_kategori" class="form-label-custom">
                        Category Name <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           name="nama_kategori"
                           id="nama_kategori"
                           class="form-control-custom @error('nama_kategori') is-invalid-custom @enderror"
                           value="{{ old('nama_kategori') }}"
                           placeholder="e.g. Computer Devices"
                           required
                           autofocus>
                    @error('nama_kategori')
                        <div class="form-feedback-custom invalid-custom">
                            <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                        </div>
                    @else
                        <span class="text-muted" style="font-size: 12px;">
                            Use a clear and descriptive name, e.g. <strong>Computer Devices</strong>,
                            <strong>Lab Equipment</strong>, or <strong>Office Supplies</strong>.
                        </span>
                    @enderror
                </div>

                <hr class="my-4">

                {{-- Action Buttons --}}
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('kategori.index') }}" class="btn-table-action">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                    <button type="submit" class="btn-table-action btn-primary-action">
                        <i class="bi bi-check-lg"></i> Save Category
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
                    <div class="me-2" style="color:#B4F105;">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Use unique names</div>
                        <div class="text-muted" style="font-size:12px;">
                            Each category name must be unique to avoid confusion.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-start">
                    <div class="me-2" style="color:#B4F105;">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Keep it short</div>
                        <div class="text-muted" style="font-size:12px;">
                            Use concise names (max 100 characters) for better display.
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
                            Categories with linked items cannot be removed.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-auto pt-3 border-top">
                <a href="{{ route('kategori.index') }}"
                   class="text-decoration-none"
                   style="font-size:13px;color:#072F1F;">
                    <i class="bi bi-arrow-right"></i> View all categories
                </a>
            </div>
        </div>
    </div>
</div>
{{-- END: Form Card --}}

@endsection