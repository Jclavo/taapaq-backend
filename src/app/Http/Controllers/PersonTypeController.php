<?php

namespace App\Http\Controllers;

use App\Models\PersonType;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Utils\TranslationUtil;

class PersonTypeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personTypes = PersonType::all();
            
        return $this->sendResponse($personTypes->toArray(), TranslationUtil::getTranslation('crud.pagination'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PersonType  $personType
     * @return \Illuminate\Http\Response
     */
    public function show(PersonType $personType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PersonType  $personType
     * @return \Illuminate\Http\Response
     */
    public function edit(PersonType $personType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PersonType  $personType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PersonType $personType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PersonType  $personType
     * @return \Illuminate\Http\Response
     */
    public function destroy(PersonType $personType)
    {
        //
    }
}
