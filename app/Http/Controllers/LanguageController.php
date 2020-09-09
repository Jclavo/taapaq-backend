<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class LanguageController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $languages = Language::all();
            
        return $this->sendResponse($languages->toArray(), 'Languages retrieved successfully.');
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
     * @param  \App\Models\Language1  $language1
     * @return \Illuminate\Http\Response
     */
    public function show(Language1 $language1)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Language1  $language1
     * @return \Illuminate\Http\Response
     */
    public function edit(Language1 $language1)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Language1  $language1
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Language1 $language1)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Language1  $language1
     * @return \Illuminate\Http\Response
     */
    public function destroy(Language1 $language1)
    {
        //
    }
}
