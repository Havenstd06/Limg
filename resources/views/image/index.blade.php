@extends('layouts.app')

@section('head')
    <title>Images — {{ config('app.name', 'Laravel') }} — {{ config('app.description') }}</title>
@endsection

@section('content')
<div class="px-8 pt-6 pb-8 mx-4 bg-white rounded-lg shadow-md dark:bg-midnight sm:container sm:mx-auto sm:w-full">
  <div class="text-black dark:text-gray-300">
    <h2 class="text-4xl font-bold">Images</h2>
    <p class="font-medium">Discover Public Images!</p>
  </div>
</div>
<br class="my-10">
<div class="px-4 pt-6 pb-2 bg-white rounded-lg shadow-md md:pb-8 lg:px-8 dark:bg-midnight">
  @livewire('images-grid')
</div>
@endsection