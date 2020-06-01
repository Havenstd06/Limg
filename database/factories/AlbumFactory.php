<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Album;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Album::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'user_id' => 2
    ];
});
