<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="Law Practice Management System - Manage cases, clients, courts, and documents efficiently.">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="Law Practice Management">
    <meta property="og:description" content="Law Practice Management System - Manage cases, clients, courts, and documents efficiently.">
    <meta property="og:image" content="{{ asset('images/icon.png') }}">
    <meta property="og:url" content="{{ url('/') }}">
    <link rel="stylesheet" href="{{ asset('theme/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('styles')
    @livewireStyles
</head>

<body id="guest-body">
    @include('includes.nav')
    @yield('contents')
    @include('includes.footer')
    @livewireScripts
</body>

</html>
