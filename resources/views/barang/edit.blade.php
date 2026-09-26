@extends('layouts.apps')

@section('content')

{{-- ==========================================
     START: Page Header + Breadcrumb
     ========================================== --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Item</h1>
        <p class="page-subtitle">Update item information: {{ $data->nama_barang }}</p>
    </div>

    @include('partials.breadcrumb', ['items' => [
        'Master Data' => '#',
        'Item'        => route('barang.index'),
        'Edit'        => '',
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
                <i class="bi bi-pencil-square text-warning"></i> Item Information
            </h5>

            <form action="{{ route('barang.update', $data->id) }}" method="POST" id="barangForm">
                @csrf
                @method('PUT')

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
                               value="{{ old('kode_barang', $data->kode_barang) }}"
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
                               value="{{ old('nama_barang', $data->nama_barang) }}"
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
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}" {{ old('category_id', $data->category_id) == $k->id ? 'selected' : '' }}>
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
                            @foreach($ruangan as $r)
                                <option value="{{ $r->id }}" {{ old('location_id', $data->location_id) == $r->id ? 'selected' : '' }}>
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
                            @foreach($kondisi as $c)
                                <option value="{{ $c->id }}" {{ old('condition_id', $data->condition_id) == $c->id ? 'selected' : '' }}>
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
                               value="{{ old('jumlah', $data->jumlah) }}"
                               min="0"
                               required>
                        @error('jumlah')
                            <div class="form-feedback-custom invalid-custom">
                                <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                            </div>
                        @else
                            <span class="text-muted" style="font-size: 12px;">
                                Adjust only for corrections. Use <strong>Barang Masuk</strong> for stock additions.
                            </span>
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
                               value="{{ old('satuan', $data->satuan) }}"
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
                               value="{{ old('tahun_pengadaan', $data->tahun_pengadaan) }}"
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
                              placeholder="Optional notes about this item...">{{ old('keterangan', $data->keterangan) }}</textarea>
                    @error('keterangan')
                        <div class="form-feedback-custom invalid-custom">
                            <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- =====================
                     Metadata Info
                ====================== --}}
                <div class="mb-3">
                    <div class="d-flex gap-3 flex-wrap" style="font-size: 12px;">
                        <div class="text-muted">
                            <i class="bi bi-hash"></i> ID:
                            <strong>#ITM-{{ str_pad($data->id, 3, '0', STR_PAD_LEFT) }}</strong>
                        </div>
                        <div class="text-muted">
                            <i class="bi bi-calendar-plus"></i> Created:
                            <strong>{{ $data->created_at->translatedFormat('d M Y, H:i') }}</strong>
                        </div>
                        <div class="text-muted">
                            <i class="bi bi-clock-history"></i> Updated:
                            <strong>{{ $data->updated_at->translatedFormat('d M Y, H:i') }}</strong>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                {{-- Action Buttons --}}
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('barang.index') }}" class="btn-table-action">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                    <button type="submit" class="btn-table-action btn-primary-action">
                        <i class="bi bi-check-lg"></i> Update Item
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
                            Item code must remain unique, e.g. <strong>BRG-001</strong>, <strong>BRG-002</strong>.
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
                            Keep category, location, and condition up to date.
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
                        <div style="font-size: 13px; font-weight:600; color:#072F1F;">Quantity changes</div>
                        <div class="text-muted" style="font-size:12px;">
                            Only edit quantity for corrections. Use <strong>Barang Masuk</strong> for stock additions.
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
                <a href="{{ route('barang.show', $data->id) }}"
                   class="text-decoration-none d-block mb-2"
                   style="font-size:13px;color:#072F1F;">
                    <i class="bi bi-eye"></i> View item detail
                </a>
                <a href="{{ route('barang.index') }}"
                   class="text-decoration-none d-block"
                   style="font-size:13px;color:#072F1F;">
                    <i class="bi bi-arrow-right"></i> View all items
                </a>
            </div>
        </div>
    </div>
</div>
{{-- END: Form Card --}}

@endsection