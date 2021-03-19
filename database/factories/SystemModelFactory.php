<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SystemModel;
use App\Models\Project;
use Faker\Generator as Faker;

$factory->define(SystemModel::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'project_id' => Project::all()->random()->id,
    ];
});
