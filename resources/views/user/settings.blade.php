@extends('layouts.app')

@section('content')

@if (auth()->user() == $user)
<div class="container mx-auto bg-white shadow-md rounded-lg w-full max-w-lg px-8 pt-6 pb-8">
  <h3 class="sm:text-4xl text-4xl text-center mb-2">
    Settings
  </h3>
  <hr class="mb-6">
  <div class="flex items-center justify-center mb-8">
    <img class="rounded-lg sm:ml-14 ml-12" src="{{ Storage::url($user->avatar) }}" alt="{{ $user->username }}">
    <form action="{{ route('settings.avatar.update', ['user' => $user]) }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="overflow-hidden relative w-32 my-4 ml-12 mx-10">
        <button class="bg-indigo-700 hover:bg-indigo-800 text-white font-bold py-2 sm:px-4 pr-2 w-full inline-flex items-center rounded-lg">
          <span class="ml-2">
            <i class="fas fa-file-import"></i> Upload
          </span>
          <input class="cursor-pointer absolute block opacity-0 pin-r pin-t" type="file" name="avatar" aria-describedby="fileHelp" onChange="form.submit()">
        </button>
      </div>
    </form>
  </div>
  <hr class="pb-4">
  <form method="POST" action="{{ route('settings.password.update', ['user' => $user]) }}">
    @csrf
    <div class="flex flex-wrap -mx-3 mb-6">
      <div class="w-full px-3">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="password">
          {{ __('Current Password') }}
        </label>
        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
        id="password" type="password" name="current_password" autocomplete="current-password" @if($errors->all())value="{{ old('current_password') }}" @endif>
      </div>
    </div>
    <div class="flex flex-wrap -mx-3 @if(!$errors->all())mb-4 @endif">
      <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="password">
          {{ __('New Password') }}
        </label>
        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border @if($errors->all()) border-red-500 @endif rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" 
        placeholder="******************" id="new_password" type="password" name="new_password" autocomplete="current-password">
      </div>
      <div class="w-full md:w-1/2 px-3">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="password">
          {{ __('New Confirm Password') }}
        </label>
        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
        placeholder="******************" id="new_confirm_password" type="password" name="new_confirm_password" autocomplete="current-password">
      </div>
    </div>
    @if ($errors->all())
      <div class="flex items-center mb-4">
        @foreach ($errors->all() as $error)
          <p class="text-red-500 text-xs italic">{{ $error }}</p>
        @endforeach 
      </div>
    @endif
    <div class="md:flex md:items-center">
      <div class="md:w-1/3">
      <button class="text-white font-bold rounded border-b-2 border-indigo-500 hover:border-indigo-600 bg-indigo-700 hover:bg-indigo-800 hover:text-white shadow-md py-2 px-5 inline-flex items-center">
        <i class="fas fa-save mr-2"></i> Save
      </button>
      </div>
      <div class="md:w-2/3"></div>
    </div>
  </form>
</div>
@endif
@endsection