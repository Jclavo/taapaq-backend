<?php

namespace App\Utils;

use App\Models\Translation;
use App\Models\TranslationDetail;
use App\Models\Country;
use App\Models\Locale;
use App\Models\Module;

use App\Utils\SystemModelUtil;
use App\Utils\ModuleUtil;

class TranslationUtil
{

    // static function updateOrCreateTranslation($id, $value, $locale, $type, $key = null ){

    //     is_null($key) ? $key = 'name' : null;

    //     $newTranslation = Translation::updateOrCreate(
    //         ['key' => $key, 'locale' => $locale, 'translationable_id' => $id,'translationable_type' => $type],
    //         [ 'value' => $value]);

    // }

    static function customUpdateOrCreate($projectCode, $modelName, $values){

        $newModel = SystemModelUtil::createFromProjectCode($projectCode,$modelName);

        foreach ($values as $value) {

            switch ($modelName) {
                case 'COUNTRY':
                    $model = Country::class;
                    $newValue = Country::updateOrCreate(['code' => $value->code],
                                    ['name' => $value->name, 'timezone' => $value->timezone, 
                                    'currency' => $value->currency, 'locale' => $value->locale, 'tax' => $value->tax]);
                    break;
                case 'LOCALE':
                    $model = Locale::class;
                    $newValue = Locale::updateOrCreate(['code' => $value->code], ['language' => $value->language]); 
                    break;
            }
            
            self::customUpdateOrCreateCore($value->translation,$model,$newValue->id);
       
        }
    }

    static function customUpdateOrCreateCore($translation, $model, $model_id){

        $newTranslation = Translation::updateOrCreate(['key' => $translation->key,
                                                            'translationable_id' => $model_id,
                                                            'translationable_type' => $model,
                                                            // 'model_id' => $newModel->id,
                                                        ]);

        foreach ($translation->details as $detail) {
                TranslationDetail::updateOrCreate(['translation_id' => $newTranslation->id, 'locale' => $detail->locale],
                                                ['value' => $detail->value,]);
        } 

    }
    
}