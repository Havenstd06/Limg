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
    return [
        'user_id' => 2,
        'title' => 'Limg default #3',
        'pageName' => $faker->slug(3),
        'imageName' => $faker->slug(3),
        'extension' => 'png',
        'path' => '/i/fDYOALi.png',
        'is_public' => 1,
    ];
});
