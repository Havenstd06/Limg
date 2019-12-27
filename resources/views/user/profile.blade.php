@extends('layouts.app')

@section('content')

                    <h3>Avatar :</h3>
                    <img src="{{ Storage::url($user->avatar) }}"/>
                    <!-- badge -->

                        <span>{{ $user->username }}</span>
                    </div>


    @if ($user->images)
        <ul>
            @foreach ($user->images as $image)
                <li>
                <a href="{{ route('image.show', ['image' => $image->name]) }}">
                <img class="w-64 my-4" src="{{ route('image.show', ['image' => $image->fullname]) }}" alt="{{ $image->title ?? $user->username }}" title="{{ $image->title ?? $user->username }}">
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
