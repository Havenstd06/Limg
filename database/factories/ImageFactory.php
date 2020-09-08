<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Image;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
 */

$factory->define(Image::class, function (Faker $faker) {
    $imagePool = [
        '/i/lNHJ8ot.png',
        '/i/gQHOGpS.png',
        '/i/ANVbpsT.png',
        '/i/Ujo5lMZ.png',
        '/i/GsTcFDd.png',
        '/i/HoJQtbq.png',
        '/i/fDYOALi.png',
    ];

    return [
        'user_id'   => 2,
        'title'     => 'Limg default #3',
        'pageName'  => $faker->slug(3),
        'imageName' => $faker->slug(3),
        'extension' => 'png',
        'path'      => $faker->randomElement($imagePool),
        'is_public' => 1,
    ];
});
