<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Resource;
use App\Models\Module;
use Faker\Generator as Faker;

$factory->define(Resource::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'module_id' => Module::all()->random()->id,
    ];
});
