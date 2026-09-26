{{-- Partial Breadcrumb --}}
{{-- Pakai: @include('partials.breadcrumb', ['items' => ['Label' => 'url', ...]]) --}}

@php
$items = $items ?? [];
@endphp

<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-white border">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
        </li>

        @foreach($items as $label => $url)
        @if($loop->last || empty($url))
        <li class="breadcrumb-item active" aria-current="page">{{ $label }}</li>
        @else
        <li class="breadcrumb-item"><a href="{{ $url }}">{{ $label }}</a></li>
        @endif
        @endforeach
    </ol>
</nav>