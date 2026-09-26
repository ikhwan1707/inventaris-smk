@extends('layouts.apps')

@section('content')

{{-- ==========================================
     START: Page Header + Breadcrumb
     ========================================== --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Add Item</h1>
        <p class="page-subtitle">Create a new inventory item for SMK Informatika Utama Depok</p>
    </div>

    @include('partials.breadcrumb', ['items' => [
        'Master Data' => '#',
        'Item'        => route('barang.index'),
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
                <i class="bi bi-box-seam text-primary"></i> Item Information
            </h5>

            <form action="{{ route('barang.store') }}" method="POST" id="barangForm">
                @csrf

                {{-- =====================
                     Code & Name
                ====================== --}}
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-4">
                        <label for="kode_barang" class="form-label-custom">
                            Item Code <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="kode_barang"
                               id="kode_barang"
                               class="form-control-custom @error('kode_barang') is-invalid-custom @enderror"
                               value="{{ old('kode_barang') }}"
                               placeholder="BRG-001"
                               required
                               autofocus>
                        @error('kode_barang')
                            <div class="form-feedback-custom invalid-custom">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 col-md-8">
                        <label for="nama_barang" class="form-label-custom">
                            Item Name <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="nama_barang"
                               id="nama_barang"
                               class="form-control-custom @error('nama_barang') is-invalid-custom @enderror"
                               value="{{ old('nama_barang') }}"
                               placeholder="e.g. Laptop ASUS"
                               required>
                        @error('nama_barang')
                            <div class="form-feedback-custom invalid-custom">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                {{-- =====================
                     Category, Location, Condition
                ====================== --}}
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-4">
                        <label for="category_id" class="form-label-custom">
                            Category <span class="text-danger">*</span>
                        </label>
                        <select name="category_id"
                                id="category_id"
                                class="form-select-custom @error('category_id') is-invalid-custom @enderror"
                                required>
                            <option value="">-- Select Category --</option>
                            @foreach(\App\Category::orderBy('nama_kategori')->get() as $k)
                                <option value="{{ $k->id }}" {{ old('category_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="form-feedback-custom invalid-custom">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="location_id" class="form-label-custom">
                            Location <span class="text-danger">*</span>
                        </label>
                        <select name="location_id"
                                id="location_id"
                                class="form-select-custom @error('location_id') is-invalid-custom @enderror"
                                required>
                            <option value="">-- Select Location --</option>
                            @foreach(\App\Location::orderBy('nama_ruangan')->get() as $r)
                                <option value="{{ $r->id }}" {{ old('location_id') == $r->id ? 'selected' : '' }}>
                                    {{ $r->nama_ruangan }}
                                </option>
                            @endforeach
                        </select>
                        @error('location_id')
                            <div class="form-feedback-custom invalid-custom">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="condition_id" class="form-label-custom">
                            Condition <span class="text-danger">*</span>
                        </label>
                        <select name="condition_id"
                                id="condition_id"
                                class="form-select-custom @error('condition_id') is-invalid-custom @enderror"
                                required>
                            <option value="">-- Select Condition --</option>
                            @foreach(\App\Condition::orderBy('nama_kondisi')->get() as $c)
                                <option value="{{ $c->id }}" {{ old('condition_id') == $c->id ? 'selected' : '' }}>
                                    {{ $c->nama_kondisi }}
                                </option>
                            @endforeach
                        </select>
                        @error('condition_id')
                            <div class="form-feedback-custom invalid-custom">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                {{-- =====================
                     Quantity, Unit, Year
                ====================== --}}
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-4">
                        <label for="jumlah" class="form-label-custom">
                            Quantity <span class="text-danger">*</span>
                        </label>
                        <input type="number"
                               name="jumlah"
                               id="jumlah"
                               class="form-control-custom @error('jumlah') is-invalid-custom @enderror"
                               value="{{ old('jumlah', 0) }}"
                               min="0"
                               required>
                        @error('jumlah')
                            <div class="form-feedback-custom invalid-custom">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="satuan" class="form-label-custom">
                            Unit <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="satuan"
                               id="satuan"
                               class="form-control-custom @error('satuan') is-invalid-custom @enderror"
                               value="{{ old('satuan') }}"
                               placeholder="Unit / Piece / Set"
                               required>
                        @error('satuan')
                            <div class="form-feedback-custom invalid-custom">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="tahun_pengadaan" class="form-label-custom">
                            Procurement Year
                        </label>
                        <input type="number"
                               name="tahun_pengadaan"
                               id="tahun_pengadaan"
                               class="form-control-custom @error('tahun_pengadaan') is-invalid-custom @enderror"
                               value="{{ old('tahun_pengadaan') }}"
                               min="1900"
                               max="{{ date('Y') }}"
                               placeholder="{{ date('Y') }}">
                        @error('tahun_pengadaan')
                            <div class="form-feedback-custom invalid-custom">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                {{-- =====================
                     Notes
                ====================== --}}
                <div class="mb-3">
                    <label for="keterangan" class="form-label-custom">Notes</label>
                    <textarea name="keterangan"
                              id="keterangan"
                              rows="3"
                              class="form-control-custom @error('keterangan') is-invalid-custom @enderror"
                              placeholder="Optional notes about this item...">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="form-feedback-custom invalid-custom">
                            <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <hr class="my-4">

                {{-- Action Buttons --}}
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('barang.index') }}" class="btn-table-action">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                    <button type="submit" class="btn-table-action btn-primary-action">
                        <i class="bi bi-check-lg"></i> Save Item
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
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Unique item code</div>
                        <div class="text-muted" style="font-size:12px;">
                            Each item code must be unique, e.g. <strong>BRG-001</strong>, <strong>BRG-002</strong>.
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
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Complete information</div>
                        <div class="text-muted" style="font-size:12px;">
                            Fill category, location, and condition to make tracking easier.
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
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Initial quantity</div>
                        <div class="text-muted" style="font-size:12px;">
                            Use <strong>Barang Masuk</strong> menu for stock additions after item creation.
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
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Cannot be deleted if used</div>
                        <div class="text-muted" style="font-size:12px;">
                            Items with transaction history cannot be removed.
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-auto pt-3 border-top">
                <a href="{{ route('barang.index') }}"
                   class="text-decoration-none"
                   style="font-size:13px;color:#072F1F;">
                    <i class="bi bi-arrow-right"></i> View all items
                </a>
            </div>
        </div>
    </div>
</div>
{{-- END: Form Card --}}

@endsection