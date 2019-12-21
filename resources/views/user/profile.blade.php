@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @if ($message = Session::get('success'))

                <div class="alert alert-success alert-block">

                    <button type="button" class="close" data-dismiss="alert">×</button>

                    <strong>{{ $message }}</strong>

                </div>

            @endif

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>


        <style>
        .rounded-circle {
            width: 150px;
            height: 150px;
        }
        </style>
        <div class="row justify-content-center">
            <div class="profile-header-container">
                <div class="profile-header-img">
                    <h3>Avatar :</h3>
                    <img class="rounded-circle" src="{{ url('storage/avatars/' . $user->avatar) }}"/>
                    <!-- badge -->
                    <div class="rank-label-container">
                        <span class="label label-default rank-label">{{ $user->username }}</span>
                    </div>
                </div>
            </div>

        </div>

        @if (auth()->user() == $user)
        <div class="row justify-content-center">
            <form action="/p/update_avatar" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <input type="file" class="form-control-file" name="avatar" aria-describedby="fileHelp">
                    <small id="fileHelp" class="form-text text-muted">Please upload a valid image file. Size of image should not be more than 2MB.</small>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    @endif
@endsection
