<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('theme/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/css/animate.css') }}">

    <link rel="stylesheet" href="{{ asset('theme/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/css/magnific-popup.css') }}">

    <link rel="stylesheet" href="{{ asset('theme/css/aos.css') }}">

    <link rel="stylesheet" href="{{ asset('theme/css/ionicons.min.css') }}">

    <link rel="stylesheet" href="{{ asset('theme/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/css/icomoon.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/css/style.css') }}">
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
</head>

<body>
    @include('includes.nav')
    @yield('contents')
    @include('includes.footer')
</body>
</html>
