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
<div class="px-4 pt-6 pb-8 bg-white rounded-lg shadow-md lg:px-8 dark:bg-midnight sm:container sm:mx-auto sm:w-full">
  <div class="grid gap-4 xs:lg:grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
    @foreach ($images as $img)          
      <a href="{{ route('image.show', ['image' => $img->pageName]) }}">
        <div class="w-11/12 h-56 mx-2 mx-auto mt-2 overflow-hidden rounded-lg shadow-lg md:w-full md:mt-0 md:my-2 dark:bg-forest bg-gray-50">
            <h2 class="pt-2 mx-4 font-semibold text-gray-800 truncate dark:text-gray-100" title="{{ $img->title }}">
              {{ $img->title }}
            </h2>
            <p class="flex justify-end px-2 mb-2 mr-2 text-sm text-gray-100">
              {{ $img->created_at->format('d/m/Y') }} 
              by {{ $img->user->username }}
            </p>
            <img src="{{ route('image.show', ['image' => $img->fullname]) }}" alt="{{ $img->title ?? $img->user->username }}">
        </div>
      </a>
    @endforeach
  </div>
  <div class="pt-5 text-center">
      {{ $images->links() }}
  </div>
</div>
@endsection