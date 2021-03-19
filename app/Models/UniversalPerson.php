<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use App\Scopes\BelongsToCompanyProjectScope;

class UniversalPerson extends Model
{
    protected $table = 'universal_people';
    protected $with = ['type','images'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identification', 'email', 'name', 'lastname', 'phone', 'address', 'country_code', 'created_by'
    ];

    /**
     * BOOT
     */
    public static function boot()
    {
        parent::boot();

        // create a event to happen on saving
        static::saving(function($table)  {
            if (Auth::check()) {
                $table->created_by = Auth::user()->id;
            }
        });

        //add scope 
        //static::addGlobalScope(new BelongsToCompanyProjectScope);

        
    }

    /**
     * Get the users for the UniversalPerson
     */
    public function users()
    {
        return $this->hasMany('App\Models\User')
                    ->orderBy('login');
    }

    /**
     * Get the companies for the UniversalPerson
     */
    public function companies()
    {
        return $this->hasMany('App\Models\Company');
                    // ->orderBy('login');
    }

    /**
     * Get the UniversalPerson that owns the user.
     */
    public function type()
    {
        return $this->belongsTo('App\Models\PersonType', 'type_id', 'code');
    }

    /**
     * Get the country that owns the person.
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_code', 'code');
    }

    /**
     * Get all of the item's images.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
