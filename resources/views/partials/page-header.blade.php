{{-- Pakai: @include('partials.page-header', ['title' => 'Data Kategori', 'icon' => 'tags']) --}}

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">
        <i class="fas fa-{{ $icon ?? 'list' }}"></i> {{ $title ?? 'Judul' }}
    </h3>
    @isset($action)
    {!! $action !!}
    @endisset
</div>