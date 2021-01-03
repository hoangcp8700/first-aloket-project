<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Role;
use App\Admin;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
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

$factory->define(Admin::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'phone'=> $faker->phoneNumber,
        'password' => Hash::make(123123123),
        'image' => $faker->imageUrl($width = 640, $height = 480),
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'role_id' =>  Role::all()->random()->id,
        'status' => 1,
        'remember_token' => Str::random(10),

    ];
});
