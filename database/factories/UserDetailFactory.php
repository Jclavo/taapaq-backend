<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\UserDetail;
use Faker\Generator as Faker;

$factory->define(UserDetail::class, function (Faker $faker) {
    return [
        'identification' => $faker->unique()->randomNumber(8, $strict = true),
        'email' => $faker->unique()->email,
        'name' => $faker->name,
        'lastname' => $faker->name,
        'phone' => $faker->e164PhoneNumber,
        'address' => $faker->address,        
    ];
});
