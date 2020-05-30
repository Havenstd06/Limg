<div class="container px-4 mx-auto">
    <div class="flex items-center justify-center py-6 sm:justify-between sm:py-4">
        <div class="flex">
            <a href="{{ route('home') }}">
                <img src="{{ url('images/logo-text-min-p.png') }}" alt="{{ config('app.name') }} Logo" class="h-10 rounded-lg">
            </a>
            <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
                @csrf 
                <label class="flex items-center px-2 py-1 mt-1 ml-3 text-purple-700 transition duration-300 ease-out bg-white border border-purple-800 rounded-lg shadow-lg cursor-pointer hover:bg-purple-600 hover:text-white dark-hover:bg-purple-600 dark-hover:text-white" for="image-upload">
                    <i class="ml-1 far fa-file-image"></i>
                    <span class="ml-1 leading-normal text-center">
                        <strong>Upload</strong>
                    </span>
                    <input class="hidden" id="image-upload" type="file" accept="image/*" name="image" aria-describedby="image" onChange="form.submit()"/>         
                </label>
            </form>
            <a href="{{ route('image.index') }}" class="flex items-center px-2 py-1 mt-1 ml-3 font-bold text-purple-700 transition duration-300 ease-out bg-white border border-purple-800 rounded-lg shadow-lg cursor-pointer hover:bg-purple-600 hover:text-white dark-hover:bg-purple-600 dark-hover:text-white">
                <i class="mr-1 far fa-images"></i>
                Images
            </a>
        </div>
        @guest
        <div class="hidden sm:flex sm:items-center">
            <a href="{{ route('login') }}" class="mr-4 text-sm font-semibold text-gray-800 hover:text-purple-600 dark:text-gray-200 dark-hover:text-purple-600">{{ __('Login') }}</a>
            <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-semibold text-gray-800 border rounded-lg hover:text-purple-600 hover:border-purple-600 dark:text-gray-200 dark-hover:text-purple-600">{{ __('Register') }}</a>
        </div>
        @else
        <div class="hidden sm:flex sm:items-right">
            <form action="{{ route('settings.update.style', ['user' => auth()->user()]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="style" class="flex items-center justify-center pt-3 pr-3 cursor-pointer">
                <div class="relative">
                    <input name="style" id="style" type="checkbox" class="hidden" value="{{ auth()->user()->style ? '1' : '0' }}" {{ auth()->user()->style ? 'checked' : '' }} onChange="form.submit()"/>
                    <div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner toggle__line"></div>
                    <div class="absolute inset-y-0 left-0 w-6 h-6 bg-white rounded-full shadow toggle__dot"></div>
                </div>
                </label>
            </form>
            <div class="relative inline-block" x-data="{open: false}">
                <button @click="open = !open" class="inline-flex items-center px-4 py-1 font-medium text-gray-700 rounded dark:text-white focus:outline-none">
                    <img src="{{ url(auth()->user()->avatar) }}" class="inline-block w-10 mr-2 -mt-1 -mb-1 -ml-1 border-white border-solid rounded shadow-md">		
                        {{ auth()->user()->username }}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" :class="{'rotate-180': open}" class="inline-block w-6 h-6 text-gray-500 transform fill-current"><path fill-rule="evenodd" d="M15.3 10.3a1 1 0 011.4 1.4l-4 4a1 1 0 01-1.4 0l-4-4a1 1 0 011.4-1.4l3.3 3.29 3.3-3.3z"/></svg>
                </button>

                <ul x-show="open" x-cloak @click.away="open = false" class="absolute z-50 w-40 py-1 mt-2 text-indigo-600 bg-white rounded shadow"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform -translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-end="opacity-0 transform -translate-y-3"
                >
                <li>
                    <a href="{{ route('user.profile', ['user' => auth()->user()]) }}" class="block py-2 pl-6 text-gray-800 no-underline whitespace-no-wrap bg-white hover:bg-gray-300 dark-hover:bg-gray-300">
                        <i class="fas fa-user"></i> {{ __('Profile') }}
                    </a>      
                </li>
                <li>
                    <a href="{{ route('user.gallery', ['user' => auth()->user()]) }}" class="block py-2 pl-6 text-gray-800 no-underline whitespace-no-wrap bg-white hover:bg-gray-300 dark-hover:bg-gray-300">
                        <i class="far fa-images"></i> {{ __('Gallery') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('settings.index', ['user' => auth()->user()]) }}" class="block py-2 pl-6 text-gray-800 no-underline whitespace-no-wrap bg-white hover:bg-gray-300 dark-hover:bg-gray-300">
                        <i class="fas fa-cogs"></i> {{ __('Settings') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="block py-2 pl-6 text-gray-800 no-underline whitespace-no-wrap bg-white border-t hover:bg-gray-300 dark-hover:bg-gray-300">
                        <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </li>
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
            <div class="block py-2 bg-white rounded dark:bg-asphalt sm:hidden">
                <div class="flex items-center justify-center">
                    <img src="{{ url($user->avatar) }}" class="w-10 mx-4 border-white border-solid rounded-lg">
                    <a href="{{ route('user.profile', ['user' => auth()->user()]) }}" class="mr-4 text-xs font-semibold text-gray-800 dark:text-gray-300 hover:text-purple-600">
                        {{ __('Profile') }}
                    </a>
                    <a href="{{ route('user.gallery', ['user' => auth()->user()]) }}" class="mr-4 text-xs font-semibold text-gray-800 dark:text-gray-300 hover:text-purple-600">
                        {{ __('Gallery') }}
                    </a>
                    <a href="{{ route('settings.index', ['user' => auth()->user()]) }}" class="mr-4 text-xs font-semibold text-gray-800 dark:text-gray-300 hover:text-purple-600">
                        {{ __('Settings') }}
                    </a>
                    <a href="{{ route('logout') }}" class="mr-4 text-xs font-semibold text-gray-800 dark:text-gray-300 hover:text-purple-600"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                </div>
            </div>
            @endguest
        </div>
    </div>
</div>