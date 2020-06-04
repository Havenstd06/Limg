@extends('layouts.app')

@section('head')
    <title>Create albums — {{ config('app.name', 'Laravel') }} — {{ config('app.description') }}</title>
    <style>
    :checked+label #border {
        transform: scale(1.03);
        box-shadow: 0 0 5px #333;
        z-index: -1;
        --border-opacity: 1;
        border-color: #f9fafb;
        border-color: rgba(249, 250, 251, var(--border-opacity));
    }
    </style>
@endsection

@section('content')
@livewire('create-album')
@endsection

@section('javascripts')
<script type='text/javascript'>
    function goodbye(e) {
        if(!e) e = window.event;
        //e.cancelBubble is supported by IE - this will kill the bubbling process.
        e.cancelBubble = true;
        e.returnValue = 'You sure you want to leave?'; //This is displayed on the dialog

        //e.stopPropagation works in Firefox.
        if (e.stopPropagation) {
            e.stopPropagation();
            e.preventDefault();
        }
    }
    window.onbeforeunload=goodbye; 
</script>
@endsection