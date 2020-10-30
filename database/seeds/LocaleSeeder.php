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
        Locale::updateOrCreate(['code' => 'es'], ['language' => 'Spanish']); 
        Locale::updateOrCreate(['code' => 'en'], ['language' => 'English']); 
        Locale::updateOrCreate(['code' => 'pt'], ['language' => 'Portugues']); 
    }
}
