<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class BelongsToCompanyProjectScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        // $builder->whereIn('universal_people.id', function($query){
            
        //     $query->select('universal_people.id')
        //         ->from('universal_people')
        //         ->join('users','universal_people.id','=','users.universal_person_id')
        //         ->join('company_project','users.company_project_id','=','company_project.id')
        //         ->where('company_project.id', Auth::user()->company_project_id);
        //         // ->union
                
        //     $query->select('universal_people.id')
        //         ->from('universal_people')
        //         ->join('companies','universal_people.id','=','companies.universal_person_id')
        //         ->join('company_project','companies.id','=','company_project.company_id')
        //         ->where('company_project.id', Auth::user()->company_project_id);
        // });

    }
}