<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;

trait LanguageTrait
{
    /**
     * Load translation values for model
     */
    public function translate($collections){

        if (method_exists($collections, 'translations')) {
            $collections->load('translations');

            foreach ($collections->translations as $translation) {
                $detail = $translation->detail;
                if(!is_null($detail)){
                    $collections[$translation->key] = $detail->value;
                }
                
            }
            unset($collections['translations']);
        }

    }
}