<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Project;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule; 

class ModuleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $module = Module::all();
            
        return $this->sendResponse($module->toArray(), 'Module retrieved successfully.');
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
            'project_id' => 'required|exists:projects,id',
            'name' => ['required','max:45', 
                        Rule::unique('modules')->where(function($query) use($request) {
                            $query->where('project_id', '=', $request->project_id);
                        })],
            'url' => 'required|max:500',
        ]);
        
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $module = new Module();
        $module->name = $request->name;
        $module->url = $request->url;

        $project = Project::findOrFail($request->project_id);
        $project->modules()->save($module);

        return $this->sendResponse($module->toArray(), 'Module created successfully.'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function show(Module $module)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function edit(Module $module)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Module $module)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $module = Module::findOrFail($id);

        $module->delete();

        return $this->sendResponse($module->toArray(), 'Module deleted successfully.');
    }

     /**
     * Get Module and its resources
     * 
     * @return \Illuminate\Http\Response
     */
    public function resourcesByModule(int $id){

        $module = Module::with('resources')->findOrFail($id);
            
        return $this->sendResponse($module->toArray(), 'Module - Resources retrieved successfully.');
    }

    /**
     * 
     */
    public function byUser(int $user_id){

        // $resources = Module::select('modules.id', 'modules.name', 'modules.url', 'resources.name as resource')
        $resources = Module::select('modules.id', 'modules.name', 'modules.url')
        ->join('resources','modules.id','=','resources.module_id')
        ->join('permissions','resources.id','=','permissions.resource_id')
        ->join('role_has_permissions','permissions.id','=','role_has_permissions.permission_id')
        ->join('roles','role_has_permissions.role_id','=','roles.id')
        ->join('model_has_roles','roles.id','=','model_has_roles.role_id')
        ->join('users','model_has_roles.model_id','=','users.id')
        ->where('users.id','=',$user_id)
        ->distinct()
        ->get();

        return $this->sendResponse($resources->toArray(), 'Module - Resources by User retrieved successfully.');
    }
}
