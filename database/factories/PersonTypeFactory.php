<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\PersonType;
use Faker\Generator as Faker;

$factory->define(PersonType::class, function (Faker $faker) {
    return [
        'code' => strtoupper($faker->unique()->lexify('??')),
        'name' => $faker->name
    ];
});
