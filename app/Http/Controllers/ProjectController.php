<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Company;
use App\Utils\ProjectUtil;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends BaseController
{
    function __construct()
    {
        $this->middleware('permission_in_role:projects/read'); 
        $this->middleware('permission_in_role:projects/create', ['only' => ['store']]);
        $this->middleware('permission_in_role:projects/update', ['only' => ['update']]);
        $this->middleware('permission_in_role:projects/delete', ['only' => ['destroy']]);
        $this->middleware('permission_in_role:projects/assign-company', ['only' => ['assignCompany']]);
        $this->middleware('permission_in_role:projects/remove-company', ['only' => ['removeCompany']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::orderBy('name')->get();
            
        return $this->sendResponse($projects->toArray(), 'Projects retrieved successfully.');
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
            'name' => 'required|max:45|unique:projects'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        // $project = Project::create(['name' => $request->name]);

        //function to generate all records in tables for new project
        ProjectUtil::createProjectAndIts($request->name);

        return $this->sendResponse([], 'Project created successfully.');  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $project = Project::findOrFail($id);

        $project->delete();

        return $this->sendResponse($project->toArray(), 'Project deleted successfully.');
    }

    /**
     * Get Projects and its modules
     * 
     * @return \Illuminate\Http\Response
     */
    public function modules(){

        $projects = Project::with('modules')->get();
            
        return $this->sendResponse($projects->toArray(), 'Projects - Modules retrieved successfully.');
    }

    /**
     * Get Project and its modules and its resources
     * 
     * @return \Illuminate\Http\Response
     */
    public function resources(int $id){

        $projects = Project::with('modules.resources')->findOrFail($id);

        return $this->sendResponse($projects->toArray(), 'Project - Modules - Resources retrieved successfully.');
    }

    /**
     * Assign a company to a Project
     */
    public function assignCompany(Request $request){

        $validator = Validator::make($request->all(), [
            'project_id' => 'required|exists:projects,id',
            'company_id' => 'required|exists:companies,id'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $project = Project::findOrFail($request->project_id);
        $company = Company::findOrFail($request->company_id);
        
        $project->companies()->syncWithoutDetaching($company); // add many to many relationship

        return $this->sendResponse($project->toArray(), 'Company was assigned successfully.');      
    }

    /**
     * Remove a company to a Project
     */
    public function removeCompany(Request $request){

        $validator = Validator::make($request->all(), [
            'project_id' => 'required|exists:projects,id',
            'company_id' => 'required|exists:companies,id'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $project = Project::findOrFail($request->project_id);
        $company = Company::findOrFail($request->company_id);
        
        $project->companies()->detach($company); // delete many to many relationship

        return $this->sendResponse($project->toArray(), 'Company was removed successfully.');      
    }

    /**
     * Get Projects and its companies
     * 
     * @return \Illuminate\Http\Response
     */
    public function companies(){

        $projects = Project::with('companies.person')->get();

        return $this->sendResponse($projects->toArray(), 'Projects and ist companies retrieved successfully.');
    }

    /**
     * Get Project and its companies
     * 
     * @return \Illuminate\Http\Response
     */
    public function companiesByProject(int $id){

        $projects = Project::with('companies.person')->findOrFail($id);

        return $this->sendResponse($projects->toArray(), 'Project and ist companies retrieved successfully.');
    }


    /***
     * Create Project and all its connections
     */
    private function createProjectAndItsXX(string $projectName){

        $modules = [
            (object) array('name' => 'Roles', 'url' => '/role-list', 'activated' => true),
            (object) array('name' => 'Users', 'url' => '/user-list', 'activated' => true),
            (object) array('name' => 'Users Master', 'url' => '/user-detail-list', 'activated' => true),
            (object) array('name' => 'Permissions', 'url' => '/permission-list', 'activated' => false),
        ];

        $resources = [
            'Create',
            'Read',
            'Update',
            'Delete',
            'Show',
            'Pagination'
        ];

        $roles = [
            'admin',
        ];
        
        
        //Create a project
        $newProject = factory(Project::class)->create(['name' => $projectName]);

        //Create Roles
        foreach ($roles as $role) {

            $adminRole = Role::create(['name' => $role . '/' . $newProject->id , 'project_id' => $newProject->id,
                                   'nickname' => $role]);

        }

        //Create modules for the project
        foreach ($modules as $module) {

            $newModule = $newProject->modules()->save(
                factory(Module::class)->make(['name' => $module->name,
                                        'url' => $module->url, 
                                        'visibled' =>  $module->activated])
            );

            foreach ($resources as $resource) {

                $newResource = $newModule->resources()->save(
                    factory(Resource::class)->make(['name' => $resource])
                );

                $permissionNickname = strtolower($newResource->module->name . '/' . str_replace(" ","-", $newResource->name));
                $permissionName = $permissionNickname . '#' . $newResource->module->project_id;

                $newPermission = Permission::create(['name' => $permissionName,
                                                    'resource_id' => $newResource->id,
                                                    'nickname' => $permissionNickname]);

                $adminRole->givePermissionTo($newPermission->id);

            }
        }

        return $newProject;

    }

}
