@extends('layouts.app')

@section('content')

@isNotPublic($image)

<div class="container mx-auto lg:w-1/3 w-1/2">
  <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
    <div class="flex">
      <div class="py-1 pr-3">
        <i class="fas fa-info-circle fa-2x"></i>
      </div>
      <div>
        <p class="font-bold">This image is private</p>
        <p class="text-sm">The user has chosen to put his image in private.</p>
      </div>
    </div>
  </div>
</div>
@else 

@if ($image->title != null)
    <h3 class="text-4xl">{{ $image->title }}</h3>
@endif

@ownsImage($image)
  <form role="form" method="POST" action="{{ route('image.infos', ['image' => $image->name]) }}">
    @csrf
    <div class="flex items-center my-6">
      <label class="mx-4">
        <input class="w-64" type="text" name="title" value="{{ $image->title }}" placeholder="Give a title to your image">
      </label>
      <label class="custom-label flex mx-4">
        <div class="bg-white shadow w-6 h-6 p-1 flex justify-center items-center mr-2">
          <input type="checkbox" class="hidden" name="is_public" value="{{ $image->is_public ? '1' : '0' }}" {{ $image->is_public ? 'checked' : '' }}>
          <svg class="hidden w-4 h-4 text-green-600 pointer-events-none" viewBox="0 0 172 172"><g fill="none" stroke-width="none" stroke-miterlimit="10" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode:normal"><path d="M0 172V0h172v172z"/><path d="M145.433 37.933L64.5 118.8658 33.7337 88.0996l-10.134 10.1341L64.5 139.1341l91.067-91.067z" fill="currentColor" stroke-width="1"/></g></svg>
        </div>
        <span class="text-gray-700"> {{ __('Public') }}</span>
      </label>
      <button type="submit" class="mx-4">Submit</button>
    </div>
  </form>
@endownsImage

<br><br>
<img src="{{ route('image.show', ['image' => $image->fullname]) }}" class="w-2/5">
<br><br>
<a href="{{ route('image.download', ['image' => $image->name]) }}">
  <button class="text-gray-800"><i class="fa fa-download"></i> Download</button>
</a>


@endisNotPublic

@endsection