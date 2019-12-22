@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center">
    <div class="bg-white shadow-md rounded md:w-1/4 px-8 pt-6 pb-8 flex flex-col">
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
