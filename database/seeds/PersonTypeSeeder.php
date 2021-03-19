<?php

use Illuminate\Database\Seeder;
use App\Utils\TranslationUtil;

class PersonTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // PersonType::updateOrCreate(['code' => '1'],['name' => 'Natural']);
        // PersonType::updateOrCreate(['code' => '2'],['name' => 'Juridical']);

        $personTypes = [
            (object) array('code' => 1,'name' => 'Natural',
                            
                        'translation' => 
                            (object) array('key' => 'name',
                            'details' => [
                                    (object) array('value' => 'Natural', 'locale' => 'es'),
                                    (object) array('value' => 'Natural', 'locale' => 'pt')]
                            )
                    ),
            (object) array('code' => 2,'name' => 'Juridical',
                            
                    'translation' => 
                        (object) array('key' => 'name',
                        'details' => [
                                (object) array('value' => 'Juridica', 'locale' => 'es'),
                                (object) array('value' => 'Juridica', 'locale' => 'pt')]
                        )
                ),
        ];

        TranslationUtil::customUpdateOrCreate(env('PROJECT_TAAPAQ_CODE'),'PERSON-TYPE',$personTypes);
    }
}
