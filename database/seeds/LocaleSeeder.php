<?php

use Illuminate\Database\Seeder;
use App\Models\Locale;

class LocaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Locale::class)->create(['code' => 'es','language' => 'Spanish']);
        factory(Locale::class)->create(['code' => 'en','language' => 'English']);
        factory(Locale::class)->create(['code' => 'pt','language' => 'Portugues']);
    }
}
