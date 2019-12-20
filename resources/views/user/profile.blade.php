@extends('layouts.app')

@section('content')
<div class="container">
    <div class="text-center">
        Le profil de {{ $user->username }} !
        <br><br>
        @if (auth()->user()->id == $user->id)
            @if (!$user->hasVerifiedEmail())
            Votre profile n'est pas vérifier !
            @else
            Votre profile est vérifier !
            @endif
        @endif
    </div>
</div>
@endsection
