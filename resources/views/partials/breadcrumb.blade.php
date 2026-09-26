{{-- Partial Breadcrumb --}}
{{-- Pakai: @include('partials.breadcrumb', ['items' => ['Label' => 'url', ...]]) --}}

@php
$items = $items ?? [];
@endphp
 <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}" class="text-decoration-none text-muted-green">Dashboard</a>
            </li>
            @foreach($items as $label => $url)
        @if($loop->last || empty($url))
        <li class="breadcrumb-item text-muted-green" aria-current="page">{{ $label }}</li>
        @else
        <li class="breadcrumb-item active text-main"><a href="{{ $url }}">{{ $label }}</a></li>
        @endif
        @endforeach
        </ol>
    </nav>