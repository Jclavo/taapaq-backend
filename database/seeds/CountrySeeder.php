<?php

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::updateOrCreate(['code' => '55'],
                               ['name' => 'Brazil', 'timezone' => 'America/Sao_Paulo', 
                                'currency' => 'BRL', 'locale' => 'pt', 'tax' => '20']);

        Country::updateOrCreate(['code' => '51'],
                               ['name' => 'Peru', 'timezone' => 'America/Lima',
                                'currency' => 'PEN', 'locale' => 'es', 'tax' => '18']);
    }
}
