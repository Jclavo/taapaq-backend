<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\TranslationDetail;
use App\Models\Translation;
use App\Models\Locale;
use Faker\Generator as Faker;

$factory->define(TranslationDetail::class, function (Faker $faker) {
    return [
        'value' => $faker->name,
        'locale' => Locale::all()->random()->id,
        'translation_id' => Translation::all()->random()->id,
    ];
});
