<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Translation;
use App\Models\SystemModel;
use Faker\Generator as Faker;

$factory->define(Translation::class, function (Faker $faker) {
    return [
        'key' => $faker->name,
        'translationable_id' => 0,
        'model_id' => SystemModel::all()->random()->id,
    ];
});
