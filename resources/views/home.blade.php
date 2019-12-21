@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">LaraImg</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in {{ $user->username }} !
                    
                    <br><br>

                    
                    <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                        <input type="file" id="image" name="image">
                        <input type="submit" value="ok">
                    </form>
                    <br>

                    @if ($image->path != null)
                        <a href="{{ route('image.show', ['image' => $image->name]) }}" target="_nofollow">
                            {{ route('image.show', ['image' => $image->name]) }}
                        </a>
                        <br>
                        preview : <br>

                        <img src="{{ route('image.show', ['image' => $image->fullname]) }}" height="200">
                    @endif


                    {{-- <ul>
                        @if ($images->count() != 0)
                            @foreach ($images as $image)
                                <li>{{ $image->name }}</li>
                                <img src="{{ $image->path }}" alt="{{ $image->user->username }}" height="200">
                            @endforeach
                        @endif
                    </ul> --}}
                </div>
            </div>
        </div>
    </div>
</div>


<div class="md:flex container border p-4">
    <div class="md:flex-shrink-0">
        <img class="rounded-lg md:w-56" src="https://images.unsplash.com/photo-1556740738-b6a63e27c4df?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=448&q=80" alt="Woman paying for a purchase">
    </div>
    <div class="mt-4 md:mt-0 md:ml-6">
        <div class="uppercase tracking-wide text-sm text-indigo-600 font-bold">Marketing</div>
        <a href="#" class="block mt-1 text-lg leading-tight font-semibold text-gray-900 hover:underline">Finding customers for your new business</a>
        <p class="mt-2 text-gray-600">Getting a new business off the ground is a lot of hard work. Here are five ideas you can use to find your first customers.</p>
    </div>
</div>


@if ($image->path != null)
<script>
    window.onbeforeunload = function() {
        return "Do you really want to leave our brilliant application?";
    };
</script>
@endif
@endsection
