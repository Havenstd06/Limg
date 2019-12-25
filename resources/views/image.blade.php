@extends('layouts.app')

@section('content')
<h3 class="text-4xl">{{ $image->title }} </h3>

@ownsImage($image)
  <form role="form" method="POST" action="{{ route('image.infos', ['image' => $image->name]) }}">
    @csrf
    <label>
      <input class="w-64" type="text" name="title" value="{{ $image->title }}" placeholder="Give a title to your image">
    </label>
    <button type="submit">Submit</button>
  </form>
@endownsImage
<br><br>
<img src="{{ route('image.show', ['image' => $image->fullname]) }}" class="w-2/5">
<br><br>
<a href="{{ route('image.download', ['image' => $image->name]) }}">
  <button class="text-gray-800"><i class="fa fa-download"></i> Download</button>
</a>

@endsection