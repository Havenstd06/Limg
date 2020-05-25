<div class="container px-4 mx-auto">
    <div class="flex items-center justify-center py-6 sm:justify-between sm:py-4">
        <div class="flex">
            <a href="{{ route('home') }}">
                <img src="{{ url('images/logo-text-min-p.png') }}" alt="{{ config('app.name') }} Logo" class="h-10 rounded-lg">
            </a>
            <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label id="image-drop"
                class="flex items-center px-2 py-2 ml-3 -mt-1 text-purple-700 bg-white border border-purple-800 rounded-lg shadow-lg hover:bg-purple-600 hover:text-white dark-hover:bg-purple-600 dark-hover:text-white" for="image-upload">
                    <i class="ml-1 far fa-file-image"></i>
                    <span class="ml-1 leading-normal text-center">
                        <strong>Upload</strong>
                    </span>
                    <input class="hidden opacity-0 sm:absolute sm:-ml-3 sm:-mt-15 sm:h-12 sm:w-27 sm:block" id="image-upload" type="file" accept="image/*" name="image" aria-describedby="image" onChange="form.submit()"/>
                </label>
            </form>
        </div>
        @guest
        <div class="hidden sm:flex sm:items-center">
            <a href="{{ route('login') }}" class="mr-4 text-sm font-semibold text-gray-800 hover:text-purple-600 dark:text-gray-200 dark-hover:text-purple-600">{{ __('Login') }}</a>
            <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-semibold text-gray-800 border rounded-lg hover:text-purple-600 hover:border-purple-600 dark:text-gray-200 dark-hover:text-purple-600">{{ __('Register') }}</a>
        </div>
        @else
        <div class="hidden sm:flex sm:items-right">
            <form action="{{ route('settings.update.style', ['user' => $user]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="style" class="flex items-center justify-center pt-3 pr-3 cursor-pointer">
                <div class="relative">
                    <input name="style" id="style" type="checkbox" class="hidden" value="{{ $user->style ? '1' : '0' }}" {{ $user->style ? 'checked' : '' }} onChange="form.submit()"/>
                    <div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner toggle__line"></div>
                    <div class="absolute inset-y-0 left-0 w-6 h-6 bg-white rounded-full shadow toggle__dot"></div>
                </div>
                </label>
            </form>
            <div class="relative leading-none no-underline rounded" data-controller="dropdown">
                <div data-action="click->dropdown#toggle click@window->dropdown#hide" role="button" class="inline-block select-none">
                    <button class="inline-flex items-center px-4 py-1 font-semibold text-gray-700 rounded dark:text-white">
                        <img src="{{ Storage::url(auth()->user()->avatar) }}" class="inline-block w-10 mr-2 -mt-1 -mb-1 -ml-1 border-white border-solid rounded shadow-md">		
                            {{ auth()->user()->username }}
                        <svg class="w-4 h-4 -mr-1 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/> </svg>
                    </button>
                </div>
                <div data-target="dropdown.menu" class="absolute right-0 hidden mt-2">
                <div class="w-40 overflow-hidden bg-white border rounded shadow">
                    <a href="{{ route('profile', auth()->user()->username) }}" class="block py-3 pl-8 text-gray-800 no-underline whitespace-no-wrap bg-white hover:bg-gray-300 dark-hover:bg-gray-300">
                        <i class="fas fa-user"></i> {{ __('Profile') }}
                    </a>
                    <a href="{{ route('settings.index', ['user' => $user]) }}" class="block py-3 pl-8 text-gray-800 no-underline whitespace-no-wrap bg-white hover:bg-gray-300 dark-hover:bg-gray-300">
                        <i class="fas fa-cogs"></i> {{ __('Settings') }}
                    </a>
                    <a href="{{ route('logout') }}" class="block py-3 pl-8 text-gray-800 no-underline whitespace-no-wrap bg-white border-t hover:bg-gray-300 dark-hover:bg-gray-300">
                        <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                    </a>
                </div>
                </div>
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
            <div class="block py-2 bg-white rounded dark:bg-asphalt sm:hidden">
                <div class="flex items-center justify-center">
                    <img src="{{ Storage::url($user->avatar) }}" class="inline-block w-10 mr-4 border-white border-solid rounded-lg">
                    <a href="{{ route('profile', auth()->user()->username) }}" class="mr-4 text-sm font-semibold text-gray-800 dark:text-gray-300 hover:text-purple-600">
                        <i class="fas fa-user"></i> {{ __('Profile') }}
                    </a>
                    <a href="{{ route('settings.index', ['user' => $user]) }}" class="mr-4 text-sm font-semibold text-gray-800 dark:text-gray-300 hover:text-purple-600">
                        <i class="fas fa-cogs"></i> {{ __('Settings') }}
                    </a>
                    <a href="{{ route('logout') }}" class="mr-4 text-sm font-semibold text-gray-800 dark:text-gray-300 hover:text-purple-600"
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

@section('javascripts')
<script>
    var fileInput = document.querySelector('input[type=file]');
    var dropzone = document.querySelector('label#image-drop');

    fileInput.addEventListener('dragenter', function () {
    dropzone.classList.remove('text-purple-700', 'bg-white');
    dropzone.classList.add('text-white', 'bg-purple-600');
    });

    fileInput.addEventListener('dragleave', function () {
    dropzone.classList.remove('text-white', 'bg-purple-600');
    dropzone.classList.add('text-purple-700', 'bg-white');
    });
</script>
@endsection