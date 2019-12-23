<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="/images/favicon/site.webmanifest">
    <link rel="mask-icon" href="/images/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="/images/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="/images/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/firacode@2.0.0/distr/fira_code.min.css">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

</head>
<body>
<div id="app">
    <div class="bg-gray-100 w-full min-h-screen m-0">
        <div class="bg-white shadow navbar">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between py-4">
                    <div>
                        <a href="{{ route('home') }}">
                            <img src="{{ url('images/logo-text-min.png') }}" alt="{{ config('app.name') }} Logo" class="rounded-lg h-8">
                        </a> 
                    </div>

                    @guest
                    {{-- large --}}
                    <div class="hidden sm:flex sm:items-center">
                        <a href="{{ route('login') }}" class="text-gray-800 text-sm font-semibold hover:text-purple-600 mr-4">{{ __('Login') }}</a>
                        <a href="{{ route('register') }}" class="text-gray-800 text-sm font-semibold border px-4 py-2 rounded-lg hover:text-purple-600 hover:border-purple-600">{{ __('Register') }}</a>
                    </div>

                    {{-- small --}}
                    <div class="sm:hidden cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-600" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M12.9499909,17 C12.7183558,18.1411202 11.709479,19 10.5,19 C9.29052104,19 8.28164422,18.1411202 8.05000906,17 L3.5,17 C3.22385763,17 3,16.7761424 3,16.5 C3,16.2238576 3.22385763,16 3.5,16 L8.05000906,16 C8.28164422,14.8588798 9.29052104,14 10.5,14 C11.709479,14 12.7183558,14.8588798 12.9499909,16 L20.5,16 C20.7761424,16 21,16.2238576 21,16.5 C21,16.7761424 20.7761424,17 20.5,17 L12.9499909,17 Z M18.9499909,12 C18.7183558,13.1411202 17.709479,14 16.5,14 C15.290521,14 14.2816442,13.1411202 14.0500091,12 L3.5,12 C3.22385763,12 3,11.7761424 3,11.5 C3,11.2238576 3.22385763,11 3.5,11 L14.0500091,11 C14.2816442,9.85887984 15.290521,9 16.5,9 C17.709479,9 18.7183558,9.85887984 18.9499909,11 L20.5,11 C20.7761424,11 21,11.2238576 21,11.5 C21,11.7761424 20.7761424,12 20.5,12 L18.9499909,12 Z M9.94999094,7 C9.71835578,8.14112016 8.70947896,9 7.5,9 C6.29052104,9 5.28164422,8.14112016 5.05000906,7 L3.5,7 C3.22385763,7 3,6.77614237 3,6.5 C3,6.22385763 3.22385763,6 3.5,6 L5.05000906,6 C5.28164422,4.85887984 6.29052104,4 7.5,4 C8.70947896,4 9.71835578,4.85887984 9.94999094,6 L20.5,6 C20.7761424,6 21,6.22385763 21,6.5 C21,6.77614237 20.7761424,7 20.5,7 L9.94999094,7 Z M7.5,8 C8.32842712,8 9,7.32842712 9,6.5 C9,5.67157288 8.32842712,5 7.5,5 C6.67157288,5 6,5.67157288 6,6.5 C6,7.32842712 6.67157288,8 7.5,8 Z M16.5,13 C17.3284271,13 18,12.3284271 18,11.5 C18,10.6715729 17.3284271,10 16.5,10 C15.6715729,10 15,10.6715729 15,11.5 C15,12.3284271 15.6715729,13 16.5,13 Z M10.5,18 C11.3284271,18 12,17.3284271 12,16.5 C12,15.6715729 11.3284271,15 10.5,15 C9.67157288,15 9,15.6715729 9,16.5 C9,17.3284271 9.67157288,18 10.5,18 Z"/>
                        </svg>
                    </div>
                    @else
                    {{-- large --}}
                    <div class="hidden sm:flex sm:items-right">
                        <div class="dropdown inline-block relative">
                            <button class="text-gray-700 font-semibold py-1 px-4 rounded inline-flex items-center">
                                <span class="mr-1">
                                    <img src="{{ Storage::url($user->avatar) }}" class="inline-block rounded-lg shadow-md border-solid border-white -mt-1 w-10 mr-1 -mb-1 -ml-1">		
                                    {{ auth()->user()->username }}
                                </span>
                                <svg class="fill-current h-4 w-4 -mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/> </svg>
                            </button>
                                <ul class="dropdown-menu absolute hidden text-gray-700 pt-2">
                                <li class="w-36">
                                    <a class="rounded-t bg-gray-100 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap" href="{{ route('profile', auth()->user()->username) }}">
                                        <i class="fas fa-user"></i> {{ __('Profile') }}
                                    </a>
                                </li>
                                <li class="w-36">
                                    <a class="rounded-t bg-gray-100 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap" href="{{ route('settings.index', ['user' => $user]) }}">
                                        <i class="fas fa-cogs"></i> {{ __('Settings') }}
                                    </a>
                                </li>
                                <li class="w-36">
                                    <a class="rounded-t bg-gray-100 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap" href="{{ route('logout') }}" 
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                                    </a>
                                </li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                            </ul>
                        </div>
                    </div>
                    @endguest
                </div>
                
                {{-- small --}}
                <div class="block sm:hidden bg-white border-t-2 py-2">
                    <div class="flex flex-col">
                        @guest
                        <div class="flex justify-between items-center pt-2">
                            <a href="{{ route('login') }}" class="text-gray-800 text-sm font-semibold hover:text-purple-600 mr-4 ml-3">{{ __('Login') }}</a>
                            <a href="{{ route('register') }}" class="text-gray-800 text-sm font-semibold border px-4 py-1 rounded-lg hover:text-purple-600 hover:border-purple-600 mr-3">{{ __('Register') }}</a>
                        </div>
                        @else 
                        <div class="block sm:hidden bg-white py-2">
                            <div class="flex items-center justify-center">
                                <img src="{{ Storage::url($user->avatar) }}" class="inline-block rounded-lg border-solid border-white w-10 mr-4">
                                <a href="{{ route('profile', auth()->user()->username) }}" class="text-gray-800 text-sm font-semibold hover:text-purple-600 mr-4">
                                    <i class="fas fa-user"></i> {{ __('Profile') }}
                                </a>
                                <a href="{{ route('settings.index', ['user' => $user]) }}" class="text-gray-800 text-sm font-semibold hover:text-purple-600 mr-4">
                                    <i class="fas fa-cogs"></i> {{ __('Settings') }}
                                </a>
                                <a href="{{ route('logout') }}" class="text-gray-800 text-sm font-semibold hover:text-purple-600 mr-4"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                            </div>
                        </div>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
        <div class="container mx-auto mt-10">
            @yield('content')
        </div>
    </div>
</div> 

<!-- Scripts -->
@include('notify::messages')
<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>


</body>
</html>
