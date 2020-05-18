@extends('layouts.app')

@section('content')
<div class="px-8 pt-6 pb-8 mx-4 bg-white rounded-lg shadow-md dark:bg-midnight sm:container sm:mx-auto sm:w-full">
  <div class="text-black dark:text-gray-300">
    <h2 class="text-4xl font-bold">Discover</h2>
    <p class="font-medium">Discover Public Images!</p>
  </div>
</div>
<br class="my-10">
<div class="px-8 pt-6 pb-8 mx-4 bg-white rounded-lg shadow-md dark:bg-midnight sm:container sm:mx-auto sm:w-full">
  <div class="flex flex-wrap">
      @foreach ($images as $img)
          <div class="p-3 md:w-1/2 lg:w-1/6">
              <a href="{{ route('image.show', ['image' => $img->name]) }}" class="block h-56 overflow-hidden rounded-lg sm:shadow-lg">
              <h1 class="items-center justify-between h-16 p-3 px-4 text-lg leading-tight bg-white rounded-t dark:text-gray-300 dark:bg-forest lg:flex">{{ $img->title ?? '‌‌' }} <small class="dark:text-gray-400">{{ $img->user->username }}</small></h1>
                  <img class="w-full rounded-b" src="{{ route('image.show', ['image' => $img->fullname]) }}" alt="{{ $img->title ?? $user->username }}">
              </a>
          </div>
      @endforeach
  </div>
  <div class="pt-5 text-center">
      {{ $images->links() }}
  </div>
</div>
@endsection