<?php

use Illuminate\Database\Seeder;
use App\Utils\TranslationUtil;

class LocaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Locale::updateOrCreate(['code' => 'es'], ['language' => 'Spanish']); 
        // Locale::updateOrCreate(['code' => 'en'], ['language' => 'English']); 
        // Locale::updateOrCreate(['code' => 'pt'], ['language' => 'Portugues']); 

        $locales = [
            (object) array('code' => 'es','language' => 'Spanish',
                            
                        'translation' => 
                            (object) array('key' => 'language',
                            'details' => [
                                    (object) array('value' => 'Español', 'locale' => 'es'),
                                    (object) array('value' => 'Espanhol', 'locale' => 'pt')]
                            )
                    ),

            (object) array('code' => 'en','language' => 'English',
                            
                    'translation' => 
                        (object) array('key' => 'language',
                        'details' => [
                                (object) array('value' => 'Inglés', 'locale' => 'es'),
                                (object) array('value' => 'Inglês', 'locale' => 'pt')]
                        )
                ),

            (object) array('code' => 'pt','language' => 'Portugues',
                            
                'translation' => 
                    (object) array('key' => 'language',
                    'details' => [
                            (object) array('value' => 'Portugues', 'locale' => 'es'),
                            (object) array('value' => 'Português', 'locale' => 'pt')]
                    )
                ),
        ];

        TranslationUtil::customUpdateOrCreate(env('PROJECT_TAAPAQ_CODE'),'LOCALE',$locales);
    }
}
