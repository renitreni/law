<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Law Practice Management System - Manage cases, clients, courts, and documents efficiently.">
    <meta name="robots" content="noindex, nofollow">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Law Practice Management') }} - Sign In</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('spark-admin/assets/images/favicon.ico') }}">

    <!-- Spark Admin CSS -->
    <link rel="stylesheet" href="{{ asset('spark-admin/assets/libs/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('spark-admin/assets/libs/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('spark-admin/assets/css/main.css') }}">

    @yield('styles')
</head>
<body>
    @yield('content')

    <!-- Spark Admin JS -->
    <script src="{{ asset('spark-admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('spark-admin/assets/js/auth.js') }}"></script>

    @yield('scripts')
</body>
</html>