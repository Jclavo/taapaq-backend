<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TranslationDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value','locale','translation_id'
    ];


    /**
     * RELATIONSHIPS
     */

    /**
     * Get the translation that owns the details
     */
    public function translation()
    {
        return $this->belongsTo('App\Models\Translation');
    }

    /**
     * Get the locale that owns the translation detail
     */
    public function locale()
    {
        return $this->belongsTo('App\Models\Locale');
    }
}
