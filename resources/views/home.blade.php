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

@if ($image->path != null)
<script>
    window.onbeforeunload = function() {
        return "Do you really want to leave our brilliant application?";
    };
</script>
@endif
@endsection
