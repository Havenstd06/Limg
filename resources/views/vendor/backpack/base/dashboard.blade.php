@extends(backpack_view('blank'))

@section('content')
  <h1 class="mb-4">Welcome to {{ config('app.name') }} dashboard!</h1>
@endsection

@php
    $widgets['after_content'][] = [
    'type'    => 'div',
    'class'   => 'row',
    'content' => [
        [
          'type'        => 'progress_white',
          'class'       => 'card mb-2',
          'value'       => App\User::count(),
          'description' => 'Users',
          'progress'    => App\User::count() * 100 / 100, // integer
          'progressClass' => 'progress-bar bg-info',
          'hint'        => 100 - App\User::count() . ' more until 100 users!',
        ],
        [
          'type'        => 'progress_white',
          'class'       => 'card mb-2',
          'value'       => App\Image::count(),
          'description' => 'Images',
          'progress'    => App\Image::count() * 100 / 5000, // integer
          'progressClass' => 'progress-bar bg-warning',
          'hint'        => 5000 - App\Image::count() . ' more until 5000 images!',
        ],
        [
          'type'        => 'progress_white',
          'class'       => 'card mb-2',
          'value'       => App\Album::count(),
          'description' => 'Albums',
          'progress'    => App\Album::count() * 100 / 50, // integer
          'progressClass' => 'progress-bar bg-success',
          'hint'        => 50 - App\Album::count() . ' more until 50 albums.',
        ],
      ]
    ];
@endphp
