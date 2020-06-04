<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full @guest mode-dark @endguest @auth @if (auth()->user()->style == 1) mode-dark @endif @endauth">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Title & Meta -->
        @section('head')
        <title>{{ config('app.name', 'Laravel') }} — {{ config('app.description') }}</title>

        <!-- OpenGraph/Twitter -->
        <meta data-rh="true" name="description" content="{{ config('app.description') }}" />
        <meta data-rh="true" property="og:url" content="{{ url()->current() }}" />
        <meta data-rh="true" property="og:description" content="{{ config('app.description') }}" />
        <meta data-rh="true" property="og:image" content="{{ asset('images/cover.png') }}" />
        <meta data-rh="true" property="og:title" content="{{ config('app.name') }}" />
        <meta data-rh="true" property="og:website" content="website" />
        <meta data-rh="true" property="og:site_name" content="{{ config('app.name') }}.app" />
        <meta data-rh="true" name="twitter:image:src" content="{{ asset('images/cover.png') }}" />
        <meta data-rh="true" property="twitter:description" content="{{ config('app.description') }}" />
        <meta data-rh="true" name="twitter:card" content="summary_large_image" />
        <meta data-rh="true" name="twitter:creator" content="@HavensYT" />
        <meta data-rh="true" name="author" content="Thomas Drumont" />
        <meta data-rh="true" name="twitter:site" content="@limg_app" />
        <meta data-rh="true" property="twitter:title" content="{{ config('app.name') }}" />
        @show


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

        <!-- Scripts -->
        <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
        <script type="text/javascript" src="{{ mix('js/all.js') }}"></script>

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
        @notify_css
        @livewireStyles
    </head>

    <body class="flex flex-col h-full">

    <header class="bg-gray-100 dark:shadow-lg navbar dark:bg-midnight">
        @include('layouts.navbar')
    </header>
    <div id="content" class="flex-1 w-full p-3 bg-gray-50 dark:bg-asphalt sm:p-8">
        @yield('content')
    </div> 
    @include('layouts.footer')

    <!-- Scripts -->
    @notify_js
    @notify_render
    @livewireScripts
    @yield('javascripts')

    </body>
</html>
