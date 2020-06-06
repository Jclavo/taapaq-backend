<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Company;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
            
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

        $project = Project::create(['name' => $request->name]);

        return $this->sendResponse($project->toArray(), 'Project created successfully.');  
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
     * Get Project and its modules
     * 
     * @return \Illuminate\Http\Response
     */
    public function modulesByProject(int $id){

        $projects = Project::with('modules')->findOrFail($id);
            
        return $this->sendResponse($projects->toArray(), 'Project - Modules retrieved successfully.');
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

        $projects = Project::with('companies')->get();

        return $this->sendResponse($projects->toArray(), 'Projects and ist companies retrieved successfully.');
    }

    /**
     * Get Project and its companies
     * 
     * @return \Illuminate\Http\Response
     */
    public function companiesByProject(int $id){

        $projects = Project::with('companies')->findOrFail($id);

        return $this->sendResponse($projects->toArray(), 'Project and ist companies retrieved successfully.');
    }

    /**
     * Get Project and its roles
     * 
     * @return \Illuminate\Http\Response
     */
    public function rolesByProject(int $id){

        $projects = Project::with('roles')->findOrFail($id);
            
        return $this->sendResponse($projects->toArray(), 'Project - Roles retrieved successfully.');
    }
}
