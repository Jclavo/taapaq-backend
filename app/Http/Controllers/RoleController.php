<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\CustomSpatieRole as Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule; 

//Utils
use App\Utils\RoleUtil;
use App\Utils\ProjectUtil;
use App\Utils\TranslationUtil;

class RoleController extends BaseController
{
    function __construct()
    {
        $this->middleware('permission_in_role:roles/read'); 
        $this->middleware('permission_in_role:roles/create', ['only' => ['store']]);
        $this->middleware('permission_in_role:roles/update', ['only' => ['update']]);
        $this->middleware('permission_in_role:roles/delete', ['only' => ['destroy']]);
        $this->middleware('permission_in_role:roles/give-permission', ['only' => ['givePermissionTo']]);
        $this->middleware('permission_in_role:roles/revoke-permission', ['only' => ['revokePermissionTo']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::orderBy('name')->get();
            
        return $this->sendResponse($roles->toArray(), TranslationUtil::getTranslation('crud.pagination'));
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
            'company_id' => 'required|exists:companies,id',
            'project_id' => 'required|exists:projects,id',
            'name' => ['required','max:45',
                        // 'unique:roles',
                        // Rule::unique('roles')->where(function($query) use($request){
                        //     $query->where('project_id', $request->project_id);
                        // })  
                       ],
            
        ]);
        
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $role = RoleUtil::createCore($request->company_id, $request->project_id,$request->name);
        
        return $this->sendResponse($role->toArray(), TranslationUtil::getTranslation('crud.create'));  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);
                
        return $this->sendResponse($role->toArray(), TranslationUtil::getTranslation('crud.read'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $role = Role::findOrFail($id);

        $role->delete();

        return $this->sendResponse($role->toArray(), TranslationUtil::getTranslation('crud.delete'));
    }

    /**
     * Give an specified Permission to a Role
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function givePermissionTo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|exists:roles,id',
            'permission_id' => 'required|exists:permissions,id'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $role = Role::findOrFail($request->role_id);
        $role->givePermissionTo($request->permission_id);

        return $this->sendResponse($role->toArray(), TranslationUtil::getTranslation('crud.assign'));  

    }

    /**
     * Revoke an specified Permission to a Role
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function revokePermissionTo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|exists:roles,id',
            'permission_id' => 'required|exists:permissions,id'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first()) ;
        }

        $role = Role::findOrFail($request->role_id);

        //Check if role has the permission
        if(!$role->hasPermissionTo(Permission::findOrFail($request->permission_id))){
            return $this->sendError('Permission can not be revoked because it was not given to role.');  
        }

        //revoke permission
        $role->revokePermissionTo($request->permission_id);

        return $this->sendResponse($role->toArray(), TranslationUtil::getTranslation('crud.remove'));  

    }

    public function giveAllPermissionTo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|exists:roles,id'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $role = Role::findOrFail($request->role_id);

        $permissions = Permission::select('permissions.*')
            ->join('resources', 'permissions.resource_id', '=', 'resources.id')
            ->join('modules', 'resources.module_id', '=', 'modules.id')
            ->join('projects', 'modules.project_id', '=', 'projects.id')
            ->join('company_project', 'projects.id', '=', 'company_project.project_id')
            ->where('company_project.id', $role->company_project_id)
            ->get();
        
        
        foreach ($permissions as $permission) {
            $role->givePermissionTo($permission->id);    
        }

        return $this->sendResponse($role->toArray(), TranslationUtil::getTranslation('crud.assign'));  

    }


    /**
     * Get Roles by user
     * 
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function byUser(Request $request){

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $user_id = $request->user_id;

        $roles = Role::select('roles.*')
                        ->join('model_has_roles','roles.id','=','model_has_roles.role_id')
                        ->join('users', function ($join) use($user_id){
                            $join->on('model_has_roles.model_id', '=', 'users.id')
                                ->where('users.id', '=', $user_id);
                        })
                        ->orderBy('roles.name')
                        ->get();

        return $this->sendResponse($roles->toArray(), TranslationUtil::getTranslation('crud.pagination'));  

    }

    /**
     * Get Roles that are not assigned to an user
     * 
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function notInUser(int $user_id){

        $user = User::with('company_project')->findOrFail($user_id);

        $rolesNot = Role::whereDoesntHave('users', function ($query) use($user_id){
            $query->where('users.id', '=', $user_id);
            
        })->where('roles.company_project_id', '=', $user->company_project->id)
        ->orderBy('roles.name')
        ->get();   

        return $this->sendResponse($rolesNot->toArray(), TranslationUtil::getTranslation('crud.pagination'));  
    }

    /**
     * Get Roles by project
     * 
     * @return \Illuminate\Http\Response
     */
    public function byCompanyProject(int $company_id,int $project_id){
 
        $company_project_id = ProjectUtil::getCompanyProjectID($company_id, $project_id);

        $roles = Role::select('roles.*')
                       ->join('company_project','roles.company_project_id','=','company_project.id')
                       ->where('company_project.id', '=', $company_project_id)
                       ->orderBy('roles.name')
                       ->get();

        return $this->sendResponse($roles->toArray(), TranslationUtil::getTranslation('crud.pagination'));
    }
}
