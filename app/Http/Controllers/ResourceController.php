<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Module;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule; 

//Utils
use App\Utils\ResourceUtil;
use App\Utils\TranslationUtil;

class ResourceController extends BaseController
{
    function __construct()
    {
        $this->middleware('permission_in_role:resources/read'); 
        $this->middleware('permission_in_role:resources/create', ['only' => ['store']]);
        $this->middleware('permission_in_role:resources/update', ['only' => ['update']]);
        $this->middleware('permission_in_role:resources/delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
        $validator = Validator::make($request->all(), [
            'module_id' => 'required|exists:modules,id',
            'name' => ['required','max:45', 
                        Rule::unique('resources')->where(function($query) use($request) {
                            $query->where('module_id', '=', $request->module_id);
                        })],
        ]);
        
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $module = Module::with('project')->findOrFail($request->module_id);

        $resource = ResourceUtil::createCore($module->project->id, $module->id, $module->name,$request->name);

        return $this->sendResponse($resource->toArray(), TranslationUtil::getTranslation('crud.create')); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function show(Resource $resource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function edit(Resource $resource)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resource $resource)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $resource = Resource::findOrFail($id);

        $resource->delete();

        return $this->sendResponse($resource->toArray(), TranslationUtil::getTranslation('crud.delete'));
    }

}
