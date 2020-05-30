@extends('layouts.app')

@section('head')
<title>{{ $user->username }}'s Gallery — {{ config('app.name', 'Laravel') }}</title>

<!-- OpenGraph/Twitter -->
<meta data-rh="true" name="description" content="{{ $user->username }}'s Gallery" />
<meta data-rh="true" property="og:url" content="{{ url()->current() }}" />
<meta data-rh="true" property="og:description" content="{{ $user->username }}'s Gallery" />
<meta data-rh="true" property="og:image" content="{{ url(url($user->avatar)) }}" />
<meta data-rh="true" property="og:title" content="{{ config('app.name') }}" />
<meta data-rh="true" property="og:website" content="website" />
<meta data-rh="true" property="og:site_name" content="{{ config('app.name') }}.app" />
<meta data-rh="true" name="twitter:image:src" content="{{ url(url($user->avatar)) }}" />
<meta data-rh="true" property="twitter:description" content="{{ $user->username }}'s Gallery" />
<meta data-rh="true" name="twitter:card" content="summary_large_image" />
<meta data-rh="true" name="twitter:creator" content="@HavensYT" />
<meta data-rh="true" name="author" content="Thomas Drumont" />
<meta data-rh="true" name="twitter:site" content="@limg_app" />
<meta data-rh="true" property="twitter:title" content="{{ config('app.name') }}" />

@endsection

@section('content')
@livewire('user-gallery')
@endsection