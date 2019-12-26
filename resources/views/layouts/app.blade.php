<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="/images/favicon/site.webmanifest">
    <link rel="mask-icon" href="/images/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="/images/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="/images/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

</head>

<body class="flex flex-col h-full">

<header class="navbar">
    @include('layouts.navbar')
</header>
<div id="content" class="bg-gray-100 w-full sm:p-8 p-3 flex-1">
    <div class="container mx-auto mt-10">
        @yield('content')
    </div>
</div> 
@include('layouts.footer')

<!-- Scripts -->
@include('notify::messages')
@include('sweetalert::alert')
@yield('javascripts')
<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
<script type="module" src="{{ mix('js/instantpage.js') }}" defer></script>

</body>
</html>
