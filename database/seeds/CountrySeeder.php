<?php

use Illuminate\Database\Seeder;
use App\Utils\TranslationUtil;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            (object) array('code' => 55,'name' => 'Brazil', 'timezone' => 'America/Sao_Paulo', 
                           'currency' => 'BRL', 'locale' => 'pt', 'tax' => '20',
                            
                        'translation' => 
                            (object) array('key' => 'name',
                            'details' => [
                                    (object) array('value' => 'Brasil', 'locale' => 'es'),
                                    (object) array('value' => 'Brasil', 'locale' => 'pt')]
                            )
                    ),
            (object) array('code' => 51,'name' => 'Peru', 'timezone' => 'America/Lima',
                           'currency' => 'PEN', 'locale' => 'es', 'tax' => '18',
                     
                        'translation' => 
                            (object) array('key' => 'name',
                            'details' => [
                                    (object) array('value' => 'Perú', 'locale' => 'es'),
                                    (object) array('value' => 'Peru', 'locale' => 'pt')]
                            )
                ),
        ];

        TranslationUtil::customUpdateOrCreate(env('PROJECT_TAAPAQ_CODE'),'COUNTRY',$countries);

    }
}
