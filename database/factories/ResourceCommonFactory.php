<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ResourceCommon;
use Faker\Generator as Faker;

$factory->define(ResourceCommon::class, function (Faker $faker) {
    return [
        'name' => $faker->name
    ];
});
