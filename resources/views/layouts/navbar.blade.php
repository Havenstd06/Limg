<div class="container mx-auto px-4">
    <div class="flex items-center sm:justify-between justify-center sm:py-4 py-6">
        <div>
            <a href="{{ route('home') }}">
                <img src="{{ url('images/logo-text-min.png') }}" alt="{{ config('app.name') }} Logo" class="rounded-lg h-8">
            </a> 
        </div>

        @guest
        <div class="hidden sm:flex sm:items-center">
            <a href="{{ route('login') }}" class="text-gray-800 text-sm font-semibold hover:text-purple-600 mr-4">{{ __('Login') }}</a>
            <a href="{{ route('register') }}" class="text-gray-800 text-sm font-semibold border px-4 py-2 rounded-lg hover:text-purple-600 hover:border-purple-600">{{ __('Register') }}</a>
        </div>
        @else
        <div class="hidden sm:flex sm:items-right">
            <div class="dropdown inline-block relative">
                <button class="text-gray-700 font-semibold py-1 px-4 rounded inline-flex items-center">
                    <span class="mr-1">
                        <img src="{{ Storage::url(auth()->user()->avatar) }}" class="inline-block rounded shadow-md border-solid border-white -mt-1 w-10 mr-1 -mb-1 -ml-1">		
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