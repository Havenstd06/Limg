@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="flex items-center justify-center">
        <div class="flex flex-col px-8 pt-6 pb-8 mx-4 bg-white rounded shadow-md dark:bg-midnight md:w-1/2 xl:w-1/4">
            <form method="POST" action="{{ route('password.email') }}">
            @csrf
                <div class="mb-4">
                    <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase dark:text-gray-400" for="email">
                        {{ __('E-Mail Address') }}
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 @error('email') border-red-600 @enderror" 
                        id="email" type="text" name="email" value="{{ old('email') }}" placeholder="email@example.com" required autocomplete="email">
                    @error('email')
                        <p class="text-xs italic text-center text-red-600">{{ $message }}</p>
                    @enderror
                    @if (session('status'))
                        <p class="text-xs font-medium text-center text-indigo-600">{{ session('status') }}</p>
                    @endif
                </div>
                <div class="flex items-center justify-center">
                    <button class="px-4 py-2 mr-3 font-bold text-white bg-blue-700 rounded hover:bg-blue-800" type="submit">
                        {{ __('Send Password Reset Link') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
