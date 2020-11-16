<?php

use App\Models\Country;
use App\Models\Translation;
use App\Models\TranslationDetail;
use App\Utils\SystemModelUtil;
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
        // Country::updateOrCreate(['code' => '55'],
        //                        ['name' => 'Brazil', 'timezone' => 'America/Sao_Paulo', 
        //                         'currency' => 'BRL', 'locale' => 'pt', 'tax' => '20']);



        // Country::updateOrCreate(['code' => '51'],
        //                        ['name' => 'Peru', 'timezone' => 'America/Lima',
        //                         'currency' => 'PEN', 'locale' => 'es', 'tax' => '18']);


        $countries = [
            (object) array('code' => 55,'name' => 'Brazil', 'timezone' => 'America/Sao_Paulo', 
                           'currency' => 'BRL', 'locale' => 'pt', 'tax' => '20',
                            
                        'translations' => 
                            (object) array('key' => 'name',
                            'details' => [
                                    (object) array('value' => 'Brasil', 'locale' => 'es'),
                                    (object) array('value' => 'Brasil', 'locale' => 'pt')]
                            )
                    ),
            (object) array('code' => 51,'name' => 'Peru', 'timezone' => 'America/Lima',
                           'currency' => 'PEN', 'locale' => 'es', 'tax' => '18',
                     
                        'translations' => 
                            (object) array('key' => 'name',
                            'details' => [
                                    (object) array('value' => 'Perú', 'locale' => 'es'),
                                    (object) array('value' => 'Peru', 'locale' => 'pt')]
                            )
                ),
        ];

        $newModel = SystemModelUtil::createFromProjectCode(env('PROJECT_TAAPAQ_CODE'),'COUNTRY');

        foreach ($countries as $country) {
            
            $newCountry = Country::updateOrCreate(['code' => $country->code],
                                    ['name' => $country->name, 'timezone' => $country->timezone, 
                                    'currency' => $country->currency, 'locale' => $country->locale, 'tax' => $country->tax]);

    
            $newTranslation = Translation::updateOrCreate(['key' => $country->translations->key,
                                                           'translationable_id' => $newCountry->id,
                                                           'translationable_type' => Country::class,
                                                           'model_id' => $newModel->id,
                                                        ]);

            foreach ($country->translations->details as $detail) {
            TranslationDetail::updateOrCreate(['translation_id' => $newTranslation->id, 'locale' => $detail->locale],
                                            ['value' => $detail->value,]);
            } 
        }


        // $newModel = SystemModelUtil::createFromProjectCode(env('PROJECT_TAAPAQ_CODE'),'SYSTEM');

        // foreach ($this->translations as $translation) {

        //     $translation->translationable_id < 1 ? $translation->translationable_id = 0 : null;

        //     $newTranslation = Translation::updateOrCreate(['key' => $translation->key,
        //                                                     'model_id' => $newModel->id,
        //                                                     ]);
        //     foreach ($translation->details as $detail) {
        //             TranslationDetail::updateOrCreate(['translation_id' => $newTranslation->id, 'locale' => $detail->locale],
        //                                                 ['value' => $detail->value,]);
        //     } 
        // }
    }
}
