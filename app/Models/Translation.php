<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Translation extends Model
{
    protected $with = ['detail'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key','translationable_id','model_id'
    ];

    /**
     * RELATIONSHIPS
     */

    /**
     * Get the model that owns the Translation
     */
    public function model()
    {
        return $this->belongsTo('App\Models\SystemModel');
    }

    /**
     * Get the details for the translation
     */
    public function detail()
    {
        return $this->hasOne('App\Models\TranslationDetail')
                              ->where('locale',App::getLocale());;
    }
}
