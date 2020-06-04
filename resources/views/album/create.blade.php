@extends('layouts.app')

@section('head')
    <title>Create albums — {{ config('app.name', 'Laravel') }} — {{ config('app.description') }}</title>
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