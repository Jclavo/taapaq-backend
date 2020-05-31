<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Resource;
use App\Models\Page;
use Faker\Generator as Faker;

$factory->define(Resource::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'page_id' => Page::all()->random()->id,
    ];
});
