<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PermissionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $permissions = Permission::all();
            
        // return $this->sendResponse($permissions->toArray(), 'Permissions retrieved successfully.');
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
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|max:45|unique:permissions'
        // ]);
        
        // if ($validator->fails()) {
        //     return $this->sendError($validator->errors()->first());
        // }

        // $permission = Permission::create(['name' => $request->name]);

        // return $this->sendResponse($permission->toArray(), 'Permission created successfully.');  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        //
    }

     /**
     * Get all permission and set true or false to the column user_has_role
     * if the user has the role
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getByRole(int $role_id)
    {
        Role::findOrFail($role_id);

        $permissions = Permission::select('permissions.*',
                                     DB::raw('IF(role_has_permissions.role_id IS NULL, FALSE, TRUE) as role_has_permission'))
                        ->leftjoin('role_has_permissions', function ($leftjoin) use($role_id){
                            $leftjoin->on('permissions.id', '=', 'role_has_permissions.permission_id')
                                ->where('role_has_permissions.role_id', '=', $role_id);
                        })
                        ->whereIn('permissions.id', function ($subquery1) use($role_id) {
                                $subquery1->select('permissions.id')
                                        ->from('permissions')
                                        ->join('resources', 'permissions.resource_id', '=', 'resources.id')
                                        ->join('modules', 'resources.module_id', '=', 'modules.id')
                                        ->join('projects', 'modules.project_id', '=', 'projects.id')
                                        ->where('projects.id', function ($subquery2) use($role_id) {
                                            $subquery2->select('roles.project_id')
                                                ->from('roles')
                                                ->join('projects', 'roles.project_id', '=', 'projects.id')
                                                ->where('roles.id', '=', $role_id);
                                        });
                                })
                        ->orderBy('permissions.name')
                        ->get();

        return $this->sendResponse($permissions->toArray(), 'Permissions retrieved successfully.');

    }

    /**
     * Get the permissions for the project
     */
    // public function getByProject(int $project_id){

    //     $permissions = Permission::select('permissions.*')
    //         ->join('resources', 'permissions.resource_id', '=', 'resources.id')
    //         ->join('modules', 'resources.module_id', '=', 'modules.id')
    //         ->join('projects', 'modules.project_id', '=', 'projects.id')
    //         ->where('projects.id', $project_id)
    //         ->get();

    //     return $this->sendResponse($permissions->toArray(), 'Project - Permissions retrieved successfully.');
    // }

}
