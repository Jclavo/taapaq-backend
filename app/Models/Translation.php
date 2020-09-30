<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
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
    public function details()
    {
        return $this->hasMany('App\Models\TranslationDetail');
    }
}
