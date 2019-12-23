@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center">
    <div class="bg-white shadow-md rounded md:w-1/4 px-8 pt-6 pb-8 flex flex-col">
        <a href="{{ route('login.discord') }}">
            <div class="mx-4 mb-2">
                <button class="w-full text-white font-bold rounded bg-indigo-600 hover:bg-indigo-700 hover:text-white shadow-md py-2 px-5 flex items-center justify-center">
                    <svg class="w-1/6 mr-2 fill-current" id="Layer_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 245 240">
                        <path class="st0" d="M104.4 103.9c-5.7 0-10.2 5-10.2 11.1s4.6 11.1 10.2 11.1c5.7 0 10.2-5 10.2-11.1.1-6.1-4.5-11.1-10.2-11.1zm36.5 0c-5.7 0-10.2 5-10.2 11.1s4.6 11.1 10.2 11.1c5.7 0 10.2-5 10.2-11.1s-4.5-11.1-10.2-11.1z"/><path class="st0" d="M189.5 20h-134C44.2 20 35 29.2 35 40.6v135.2c0 11.4 9.2 20.6 20.5 20.6h113.4l-5.3-18.5 12.8 11.9 12.1 11.2 21.5 19V40.6c0-11.4-9.2-20.6-20.5-20.6zm-38.6 130.6s-3.6-4.3-6.6-8.1c13.1-3.7 18.1-11.9 18.1-11.9-4.1 2.7-8 4.6-11.5 5.9-5 2.1-9.8 3.5-14.5 4.3-9.6 1.8-18.4 1.3-25.9-.1-5.7-1.1-10.6-2.7-14.7-4.3-2.3-.9-4.8-2-7.3-3.4-.3-.2-.6-.3-.9-.5-.2-.1-.3-.2-.4-.3-1.8-1-2.8-1.7-2.8-1.7s4.8 8 17.5 11.8c-3 3.8-6.7 8.3-6.7 8.3-22.1-.7-30.5-15.2-30.5-15.2 0-32.2 14.4-58.3 14.4-58.3 14.4-10.8 28.1-10.5 28.1-10.5l1 1.2c-18 5.2-26.3 13.1-26.3 13.1s2.2-1.2 5.9-2.9c10.7-4.7 19.2-6 22.7-6.3.6-.1 1.1-.2 1.7-.2 6.1-.8 13-1 20.2-.2 9.5 1.1 19.7 3.9 30.1 9.6 0 0-7.9-7.5-24.9-12.7l1.4-1.6s13.7-.3 28.1 10.5c0 0 14.4 26.1 14.4 58.3 0 0-8.5 14.5-30.6 15.2z"/>
                    </svg>
                    Login with Discord
                </button>
            </div>
        </a>
        <hr class="my-3">
        <form method="POST" action="{{ route('login') }}">
        @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                    {{ __('Username or Email') }}
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 @if ($errors->has('username') || $errors->has('email')) border-red-600 @endif" 
                    id="username" type="text" name="login" value="{{ old('username') ?: old('email') }}" required autocomplete="username" autofocus>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    {{ __('Password') }}
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 @if ($errors->has('username') || $errors->has('email')) border-red-600 @endif" 
                    id="password" type="password" name="password" placeholder="******************" required autocomplete="current-password">

                @if ($errors->has('username') || $errors->has('email'))
                    <p class="text-red-600 text-xs italic">{{ $errors->first('username') ?: $errors->first('email') }}</p>
                @endif
            </div>
            <div class="mb-6">
                <label class="custom-label flex">
                    <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
                        <input type="checkbox" class="hidden" name="remember" id="remember" {{ old('remember') ? 'checked' : 'checked' }}>
                        <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
                    </div>
                    <span class="text-gray-700"> {{ __('Remember Me') }}</span>
                </label>
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-4 mr-3 rounded" type="submit">
                    {{ __('Login') }}
                </button>
                @if (Route::has('password.request'))
                <a class="inline-block align-baseline font-bold text-sm text-blue-700 hover:text-blue-800" href="{{ route('password.request') }}">
                    {{ __('Forgot Password?') }}
                </a>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection
