<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Module;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule; 

class ResourceController extends BaseController
{
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

        $resource = new Resource();
        $resource->name = $request->name;

        $module = Module::findOrFail($request->module_id);
        $module->resources()->save($resource);

        //Create permission
        $permissionName = $module->name . '/' . $resource->name;
        Permission::create(['name' => $permissionName, 'resource_id' => $resource->id]);

        return $this->sendResponse($resource->toArray(), 'Resource created successfully.'); 
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

        return $this->sendResponse($resource->toArray(), 'Resource deleted successfully.');
    }

    /**
     * 
     */
    public function permission(int $id)
    {
        $resource = Resource::with('permission')->findOrFail($id);

        return $this->sendResponse($resource->toArray(), 'Resource and permission retrieved successfully.');
        
    }
}
