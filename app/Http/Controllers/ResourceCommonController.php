<?php

namespace App\Http\Controllers;

use App\Models\ResourceCommon;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class ResourceCommonController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resourceCommon = ResourceCommon::orderBy('name')->get();
            
        return $this->sendResponse($resourceCommon->toArray(), 'Resource Commons retrieved successfully.');
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
     * @param  \App\ResourceCommon  $resourceCommon
     * @return \Illuminate\Http\Response
     */
    public function show(ResourceCommon $resourceCommon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ResourceCommon  $resourceCommon
     * @return \Illuminate\Http\Response
     */
    public function edit(ResourceCommon $resourceCommon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ResourceCommon  $resourceCommon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ResourceCommon $resourceCommon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ResourceCommon  $resourceCommon
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResourceCommon $resourceCommon)
    {
        //
    }
}
