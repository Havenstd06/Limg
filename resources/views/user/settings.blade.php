@extends('layouts.app')

@section('head')
<title>{{ $user->username }}'s settings — {{ config('app.name', 'Laravel') }} — {{ config('app.description') }}</title>

<!-- OpenGraph/Twitter -->
<meta data-rh="true" name="description" content="{{ $user->username }}'s Settings" />
<meta data-rh="true" property="og:url" content="{{ url()->current() }}" />
<meta data-rh="true" property="og:description" content="{{ $user->username }}'s Settings" />
<meta data-rh="true" property="og:image" content="{{ url(Storage::url($user->avatar)) }}" />
<meta data-rh="true" property="og:title" content="{{ config('app.name') }}" />
<meta data-rh="true" property="og:website" content="website" />
<meta data-rh="true" property="og:site_name" content="{{ config('app.name') }}.app" />
<meta data-rh="true" name="twitter:image:src" content="{{ url(Storage::url($user->avatar)) }}" />
<meta data-rh="true" property="twitter:description" content="{{ $user->username }}'s Settings" />
<meta data-rh="true" name="twitter:card" content="summary_large_image" />
<meta data-rh="true" name="twitter:creator" content="@HavensYT" />
<meta data-rh="true" name="author" content="Thomas Drumont" />
<meta data-rh="true" name="twitter:site" content="@limg_app" />
<meta data-rh="true" property="twitter:title" content="{{ config('app.name') }}" />

@endsection

@section('content')
<div class="container mx-auto mt-10">
  @if (auth()->user() == $user)
  <div class="max-w-lg px-8 pt-6 pb-8 mx-4 bg-white rounded-lg shadow-md dark:bg-midnight sm:container sm:mx-auto sm:w-full">
    <div class="flex items-center justify-center mb-8">
      <img class="ml-12 rounded-lg shadow-md sm:ml-14 w-38" src="{{ Storage::url($user->avatar) }}" alt="{{ $user->username }}">
      <form action="{{ route('settings.update.avatar', ['user' => $user]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="relative w-32 mx-2 my-4 ml-6 overflow-hidden cursor-pointer sm:ml-12 sm:mx-10">
          <label id="image-drop" class="inline-flex items-center w-24 py-2 pr-2 font-bold text-white bg-indigo-700 rounded-lg cursor-pointer hover:bg-indigo-800 sm:px-4 sm:w-full" for="avatar-upload">
            <div class="ml-2">
              <i class="fas fa-file-import"></i> Upload
            </div>
            <input class="hidden opacity-0 cursor-pointer sm:absolute sm:-ml-4 sm:h-10 sm:w-32 sm:block" id="avatar-upload" type="file" name="avatar" aria-describedby="avatar" onChange="form.submit()">
          </label>
        </div>
      </form>
    </div>
    <div class="sm:hidden">
    <hr>
      <form action="{{ route('settings.update.style', ['user' => $user]) }}" method="POST" enctype="multipart/form-data">
          @csrf
          <label for="style" class="flex items-center justify-center pt-3 pb-3 pr-3 cursor-pointer">
          <div class="relative">
              <input name="style" id="style" type="checkbox" class="hidden" value="{{ $user->style ? '1' : '0' }}" {{ $user->style ? 'checked' : '' }} onChange="form.submit()"/>
              <div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner toggle__line"></div>
              <div class="absolute inset-y-0 left-0 w-6 h-6 bg-white rounded-full shadow toggle__dot"></div>
          </div>
          <span class="pl-4 font-bold text-white dark:text-gray-300">Style</span>
          </label>
      </form>
    </div>
    <hr class="pb-4">
    @if(!auth()->user()->isSocialite())
    <form method="POST" action="{{ route('settings.update.password', ['user' => $user]) }}">
      @csrf
      <div class="flex flex-wrap mb-6 -mx-3">
        <div class="w-full px-3">
          <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase dark:text-gray-400" for="password">
            {{ __('Current Password') }}
          </label>
          <input class="block w-full px-4 py-3 mb-3 leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500" 
          placeholder="******************" id="password" type="password" name="current_password" autocomplete="current-password" @if($errors->all())value="{{ old('current_password') }}" @endif>
        </div>
      </div>
      <div class="flex flex-wrap -mx-3 @if(!$errors->all())mb-3 @endif">
        <div class="w-full px-3 mb-6 md:w-1/2 md:mb-0">
          <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase dark:text-gray-400" for="password">
            {{ __('New Password') }}
          </label>
          <input class="appearance-none block w-full bg-gray-200 text-gray-700 border @if($errors->all()) border-red-500 @endif rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" 
          placeholder="******************" id="new_password" type="password" name="new_password" autocomplete="current-password">
        </div>
        <div class="w-full px-3 md:w-1/2">
          <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase dark:text-gray-400" for="password">
            {{ __('New Confirm Password') }}
          </label>
          <input class="block w-full px-4 py-3 leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500" 
          placeholder="******************" id="new_confirm_password" type="password" name="new_confirm_password" autocomplete="current-password">
        </div>
      </div>
      @if ($errors->all())
        <div class="flex items-center mb-4">
          @foreach ($errors->all() as $error)
            <p class="text-xs italic text-red-500">{{ $error }}</p>
          @endforeach 
        </div>
      @endif
      <div class="flex justify-end">
        <div class="pb-4">
          <button class="inline-flex items-center px-5 py-2 font-bold text-white bg-indigo-700 border-b-2 border-indigo-500 rounded shadow-md hover:border-indigo-600 hover:bg-indigo-800 hover:text-white">
            <i class="mr-2 fas fa-save"></i> Save
          </button>
        </div>
      </div>
    </form>
    @else 
    <div class="flex">
      <i class="text-center text-gray-600">Because you signed in with Discord you have no password options.</i>
    </div>
    @endif
    <form method="POST" action="{{ route('settings.update.token', ['user' => $user]) }}">
      @csrf
      <hr class="pb-4">
      <div class="mb-4">
        <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase dark:text-gray-400" for="password">
          {{ __('Api Token') }}
        </label>
        <div class="flex">
          <input value="{{ $user->api_token }}" class="flex-auto px-3 py-2 leading-tight text-gray-700 bg-gray-200 border rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500" spellcheck="false">
          <button class="inline-flex items-center px-4 py-2 ml-2 font-bold text-white bg-indigo-700 rounded hover:border-indigo-600 hover:bg-indigo-800 hover:text-white">
            <i class="relative inline text-lg fas fa-sync"></i> 
            <p class="ml-2 font-medium">Update Key</p>
          </button>
        </div>
      </div>
    </form>
  </div>
  @endif
</div>
@endsection