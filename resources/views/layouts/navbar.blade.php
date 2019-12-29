<div class="container px-4 mx-auto">
    <div class="flex items-center justify-center py-6 sm:justify-between sm:py-4">
        <div>
            <a href="{{ route('home') }}">
                <img src="@if ($user->style == 1) {{ url('images/logo-text-min-w.png') }} @else {{ url('images/logo-text-min.png') }}@endif" alt="{{ config('app.name') }} Logo" class="h-8 rounded-lg">
            </a>
        </div>

        @guest
        <div class="hidden sm:flex sm:items-center">
            <a href="{{ route('login') }}" class="mr-4 text-sm font-semibold text-gray-800 hover:text-purple-600 dark:text-gray-200 dark-hover:text-purple-600">{{ __('Login') }}</a>
            <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-semibold text-gray-800 border rounded-lg hover:text-purple-600 hover:border-purple-600 dark:text-gray-200 dark-hover:text-purple-600">{{ __('Register') }}</a>
        </div>
        @else
        <div class="hidden sm:flex sm:items-right">
            <div class="relative inline-block dropdown">
                <button class="inline-flex items-center px-4 py-1 font-semibold text-gray-700 rounded dark:text-white">
                    <span class="mr-1">
                        <img src="{{ Storage::url(auth()->user()->avatar) }}" class="inline-block w-10 mr-1 -mt-1 -mb-1 -ml-1 border-white border-solid rounded shadow-md">		
                        {{ auth()->user()->username }}
                    </span>
                    <svg class="w-4 h-4 -mr-2 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/> </svg>
                </button>
                    <ul class="absolute hidden pt-2 text-gray-700 dropdown-menu">
                    <li class="w-36">
                        <a class="block px-4 py-2 whitespace-no-wrap bg-gray-100 hover:bg-gray-400" href="{{ route('profile', auth()->user()->username) }}">
                            <i class="fas fa-user"></i> {{ __('Profile') }}
                        </a>
                    </li>
                    <li class="w-36">
                        <a class="block px-4 py-2 whitespace-no-wrap bg-gray-100 hover:bg-gray-400" href="{{ route('settings.index', ['user' => $user]) }}">
                            <i class="fas fa-cogs"></i> {{ __('Settings') }}
                        </a>
                    </li>
                    <li class="w-36">
                        <a class="block px-4 py-2 whitespace-no-wrap bg-gray-100 hover:bg-gray-400" href="{{ route('logout') }}" 
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
    <div class="block py-2 bg-white border-t-2 dark:bg-midnight sm:hidden">
        <div class="flex flex-col">
            @guest
            <div class="flex items-center justify-between pt-2">
                <a href="{{ route('login') }}" class="ml-3 mr-4 text-sm font-semibold text-gray-800 hover:text-purple-600 dark:text-gray-200 dark-hover:text-purple-600">{{ __('Login') }}</a>
                <a href="{{ route('register') }}" class="px-4 py-1 mr-3 text-sm font-semibold text-gray-800 border rounded-lg hover:text-purple-600 hover:border-purple-600 dark:text-gray-200 dark-hover:text-purple-600">{{ __('Register') }}</a>
            </div>
            @else 
            <div class="block py-2 bg-white sm:hidden">
                <div class="flex items-center justify-center">
                    <img src="{{ Storage::url($user->avatar) }}" class="inline-block w-10 mr-4 border-white border-solid rounded-lg">
                    <a href="{{ route('profile', auth()->user()->username) }}" class="mr-4 text-sm font-semibold text-gray-800 hover:text-purple-600">
                        <i class="fas fa-user"></i> {{ __('Profile') }}
                    </a>
                    <a href="{{ route('settings.index', ['user' => $user]) }}" class="mr-4 text-sm font-semibold text-gray-800 hover:text-purple-600">
                        <i class="fas fa-cogs"></i> {{ __('Settings') }}
                    </a>
                    <a href="{{ route('logout') }}" class="mr-4 text-sm font-semibold text-gray-800 hover:text-purple-600"
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