<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CompanySetting;
use App\Models\Company;
use Faker\Generator as Faker;

$factory->define(CompanySetting::class, function (Faker $faker) {
    return [
        'has_cashier' => false,
        'company_id' => Company::all()->random()->id,
    ];
});
