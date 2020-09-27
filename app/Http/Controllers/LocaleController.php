<?php

namespace App\Http\Controllers;

use App\Models\Locale;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class LocaleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locales = Locale::orderBy('language')->get();
            
        return $this->sendResponse($locales->toArray(), 'Locales retrieved successfully.');
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
     * @param  \App\Models\Locale  $locale
     * @return \Illuminate\Http\Response
     */
    public function show(Locale $locale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Locale  $locale
     * @return \Illuminate\Http\Response
     */
    public function edit(Locale $locale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Locale  $locale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Locale $locale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Locale  $locale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Locale $locale)
    {
        //
    }
}
