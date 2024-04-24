<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="Meshari Al Humaidi stands out as a premier law firm adept at managing client cases throughout the Kingdom of Saudi Arabia. It is renowned for its team of seasoned lawyers with extensive expertise in legal practice. We treasure our clients, and our services are our strength. Your trust in us is our pleasure.">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="Meshari Alhumaidi Law Firm">
    <meta property="og:description" content="Meshari Al Humaidi stands out as a premier law firm adept at managing client cases throughout the Kingdom of Saudi Arabia. It is renowned for its team of seasoned lawyers with extensive expertise in legal practice. We treasure our clients, and our services are our strength. Your trust in us is our pleasure.">
    <meta property="og:image" content="{{ asset('images/icon.png') }}">
    <meta property="og:url" content="https://mesharialhumlaw.com/">
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
