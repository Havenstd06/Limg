@extends('layouts.app')

@section('head')
    <title>Albums — {{ config('app.name', 'Laravel') }} — {{ config('app.description') }}</title>
@endsection

@section('content')
<div class="px-8 pt-6 pb-8 mx-4 bg-white rounded-lg shadow-md dark:bg-midnight sm:container sm:mx-auto sm:w-full">
  <div class="text-black dark:text-gray-300">
    <div class="flex items-center">
      <h2 class="text-4xl font-bold">Albums</h2>
      @auth
      <span class="inline-flex rounded-md shadow-sm">
        <a href="{{ route('album.create') }}" class="inline-flex items-center px-4 py-2 ml-2 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out bg-gray-600 border border-transparent rounded-md hover:bg-gray-500 focus:outline-none focus:border-gray-700 focus:shadow-outline-gray active:bg-gray-700">
        <svg aria-hidden="true" data-prefix="fas" data-icon="plus-circle" class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm144 276c0 6.6-5.4 12-12 12h-92v92c0 6.6-5.4 12-12 12h-56c-6.6 0-12-5.4-12-12v-92h-92c-6.6 0-12-5.4-12-12v-56c0-6.6 5.4-12 12-12h92v-92c0-6.6 5.4-12 12-12h56c6.6 0 12 5.4 12 12v92h92c6.6 0 12 5.4 12 12v56z"/></svg>
          Create
        </a>
      </span>
      @endauth
    </div>
    <p class="font-medium">Discover Public Albums!</p>
  </div>
</div>
<br class="my-10">
<div class="px-4 pt-6 pb-2 bg-white rounded-lg shadow-md md:pb-8 lg:px-8 dark:bg-midnight">
  @livewire('albums-grid')
</div>
@endsection