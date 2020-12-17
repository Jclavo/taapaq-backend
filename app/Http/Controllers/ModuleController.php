<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Project;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\Auth;

//Utils
use App\Utils\ModuleUtil;

class ModuleController extends BaseController
{
    function __construct()
    {
        $this->middleware('permission_in_role:modules/read', ['except' => ['byUser']]); 
        $this->middleware('permission_in_role:modules/create', ['only' => ['store']]);
        $this->middleware('permission_in_role:modules/update', ['only' => ['update']]);
        $this->middleware('permission_in_role:modules/delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $module = Module::all();
            
        // return $this->sendResponse($module->toArray(), 'Module retrieved successfully.');
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
            'labeled' => 'nullable|boolean',
            'url' => 'required_unless:labeled,1|max:500',
        ]);

        //Validate parent_id
        $validator->sometimes('parent_id', 'exists:modules,id', function ($input) {
            return $input->parent_id > 0;
        });
        
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

      
        $module = new Module();
        $module->name = $request->name;
        $module->url = $request->url;
        $module->parent_id = $request->parent_id;
        $module->labeled = $request->labeled;

        $module = ModuleUtil::createCore($request->project_id, $module, $module->parent_id);

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
     * Get modules by User
     */
    public function byUser(){

        Auth::user()->load(['company_project']);
        $project_id = Auth::user()->company_project->project_id;

        $modules = Module::with(['children'])->whereHas('project', function ($query) use($project_id) {
            $query->where('projects.id', '=', $project_id)
                  ->whereNull('modules.parent_id');
        })
        ->orderBy('modules.order')
        ->get();

        $newModules = $this->filterModuleByUserPermission($modules->toArray(),Auth::user()->id);

        return $this->sendResponse($newModules, 'Modules retrieved successfully.');

    }


    /**
     * Return Modules where the user has permissions 
     */

    public function filterModuleByUserPermission($modules, $user_id){

        $newModules = array();
        foreach ($modules as $module) {

            $moduleWithPermissions = false;

            if($module['labeled']){
                if(count($module['children']) > 0){
                    $subModules = $this->filterModuleByUserPermission($module['children'],$user_id);
                    if(count($subModules) > 0){
                        $module['children'] = $subModules;
                        $moduleWithPermissions = true;
                    }
                }
            }else{
                $queryPermission = $this->moduleByUserPermission($module['id'],$user_id);

                if(!$queryPermission->isEmpty()){
                    $moduleWithPermissions = true;
                }
            }

            if($moduleWithPermissions){
                unset($module['resources']);
                array_push($newModules,(object) $module);
            }
            
        }

        return $newModules;

    }


    /**
     * Check if the user has permission in that specific module
     */

    public function moduleByUserPermission($module_id,$user_id){

        return Module::select('modules.id', 'modules.name', 'modules.url', 'modules.labeled' )
                    ->join('resources','modules.id','=','resources.module_id')
                    ->join('permissions','resources.id','=','permissions.resource_id')
                    ->join('role_has_permissions','permissions.id','=','role_has_permissions.permission_id')
                    ->join('roles','role_has_permissions.role_id','=','roles.id')
                    ->join('model_has_roles','roles.id','=','model_has_roles.role_id')
                    ->join('users','model_has_roles.model_id','=','users.id')
                    ->where('users.id','=', $user_id)
                    ->where('modules.id', $module_id)
                    ->where('modules.visibled', 1)
                    ->get();
    }

    /**
     * Get Modules by Project
     */
    public function resourcesByProject($project_id){

        $modules = Module::with(['resources','children'])->whereHas('project', function ($query) use($project_id) {
            $query->where('projects.id', '=', $project_id)
                  ->whereNull('modules.parent_id');
        })
        ->orderBy('modules.name')
        ->get();

        return $this->sendResponse($modules->toArray(), 'Modules retrieved successfully.');
    }

    /**
     * Get Label Modules by Project
     */
    public function labelsByProject($project_id){

        $modules = Module::whereHas('project', function ($query) use($project_id) {
            $query->where('projects.id', '=', $project_id)
                  ->where('modules.labeled',true);
        })
        ->orderBy('modules.name')
        ->get();

        return $this->sendResponse($modules->toArray(), 'Modules retrieved successfully.');
    }
}
