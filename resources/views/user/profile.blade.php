@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="profile-header-container">
                <div class="profile-header-img">
                    <h3>Avatar :</h3>
                    <img class="rounded-circle" src="{{ Storage::url($user->avatar) }}"/>
                    <!-- badge -->
                    <div class="rank-label-container">
                        <span class="label label-default rank-label">{{ $user->username }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
