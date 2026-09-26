<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Inventaris SMK') }}</title>

    <!-- SEO Optimization -->
    <meta name="description" content="Sistem Informasi Inventaris Barang SMK Informatika Utama Depok">
    <meta name="author" content="Elsa Rusantiana">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Local Third-Party Libraries (100% Offline Compatible) -->
    <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-icons/bootstrap-icons.css') }}">

    <!-- Main Design System & Custom Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    @stack('styles')
</head>

<body>

    <!-- ==========================================
    START: Authentication Container & Login Card
    ========================================== -->
    @yield('content')
    <!-- END: Authentication Container -->

    <!-- Local Bootstrap bundle -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Custom Authentication interactions script -->
    <script src="{{ asset('assets/js/auth.js') }}"></script>

    @stack('scripts')
</body>

</html>