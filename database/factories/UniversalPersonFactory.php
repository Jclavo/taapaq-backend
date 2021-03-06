<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\UniversalPerson;
use App\Models\Country;
use Faker\Generator as Faker;

$factory->define(UniversalPerson::class, function (Faker $faker) {
    return [
        'identification' => $faker->unique()->randomNumber(8, $strict = true),
        'email' => $faker->unique()->email,
        'name' => $faker->name,
        'lastname' => $faker->name,
        'phone' => $faker->e164PhoneNumber,
        'address' => $faker->address, 
        'country_id' => Country::all()->random()->code,  
    ];
});
