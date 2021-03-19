<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Locale;
use Faker\Generator as Faker;

$factory->define(Locale::class, function (Faker $faker) {
    return [
        'code' => $faker->languageCode,
        'language' => $faker->name,
    ];
});
