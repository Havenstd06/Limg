@extends('layouts.app')

@section('content')
<div class="text-center">
  l'image : <br> <br>

  <img src="{{ route('image.show', ['image' => $image->fullname]) }}" width="500">
</div>


@endsection