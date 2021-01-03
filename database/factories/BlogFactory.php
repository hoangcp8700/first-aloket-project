<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'image' => $faker->imageUrl($width = 640, $height = 480),
        'email' => $faker->unique()->safeEmail,
        'status' => 1,
        'remember_token' => Str::random(10),
    ];
});
