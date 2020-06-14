<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use App\Models\Company;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends BaseController
{
    function __construct()
    {
        $this->middleware('permission_in_role:users/read', ['except' => ['login','logout']]);
        $this->middleware('permission_in_role:users/create', ['only' => ['store']]);
        $this->middleware('permission_in_role:users/update', ['only' => ['update']]);
        $this->middleware('permission_in_role:users/delete', ['only' => ['destroy']]);

        $this->middleware('permission_in_role:users/assign-role', ['only' => ['assignRole']]);
        $this->middleware('permission_in_role:users/remove-role', ['only' => ['removeRole']]);
        $this->middleware('permission_in_role:users/activated-status', ['only' => ['changeActivatedStatus']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $users = User::all();
            
        // return $this->sendResponse($users->toArray(), 'Users retrieved successfully.');
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
            'user_detail_id' => 'required|exists:user_details,id',
            'company_id' => 'required|exists:companies,id',
            'project_id' => 'required|exists:projects,id'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        //Get company project ID
        $company = Company::findOrFail($request->company_id);
        $company = $company->projects()->findOrFail($request->project_id);

        $userDetails = UserDetail::findOrFail($request->user_detail_id);
        
        $user = new User();
        $user->login = $userDetails->identification . $company->pivot->id;
        $user->password = Hash::make($user->login);
        $user->company_project_id = $company->pivot->id; //Assign company project ID
        $user->user_detail_id = $userDetails->id;
        $user->save();

        return $this->sendResponse($user->toArray(), 'User created successfully.');  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return $this->sendResponse($user->toArray(), 'User deleted successfully.');
    }

    /**
     * Login user with email credential
     * 
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required|max:45',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $credentials = $request->only('login', 'password');

        if (!Auth::attempt($credentials)) {
            return $this->sendError('Login/Password incorrect.');  
        }

        //check if user status validated is true
        if(!Auth::user()->activated){
            Auth::logout();
            return $this->sendError('Your user is not activated yet.');  
        }

        Auth::user()->api_token = Str::random(80);
        Auth::user()->save();

        Auth::user()->load(['company_project','user_detail']);
        
        if (Auth::user()->isSuper()) {
            Auth::user()->isSuper = 1;
        }else{
            Auth::user()->isSuper = 0;
        }

        return $this->sendResponse(Auth::user()->toArray(), 'User login successfully.');  
    }

    /**
     * Assign a role to an User
     * 
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function assignRole(Request $request){

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);
        
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $user = User::findOrFail($request->user_id);
        $user->assignRole(Role::findOrFail($request->role_id));

        return $this->sendResponse($user->toArray(), 'Role assigned successfully.');  
    }

    /**
     * Remove a role to an User
     * 
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function removeRole(Request $request){

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);
        
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $user = User::findOrFail($request->user_id);
        $role = Role::findOrFail($request->role_id);

        //Check if role has the permission
        if(!$user->hasRole($role)){
            return $this->sendError('Role can not be removed because it was not given to user.');  
        }

        $user->removeRole($role);

        return $this->sendResponse($user->toArray(), 'Role removed successfully.');  
    }

    /**
     * Display a listing of user and its roles.
     *
     * @return \Illuminate\Http\Response
     */
    public function withRoles()
    {
        $users = User::with('roles')->get();
            
        return $this->sendResponse($users->toArray(), 'Users retrieved successfully.');
    }

    /**
     * Display a listing of user and its roles by Project-Company relation
     */
    public function UserRolesByProjectCompany(int $company_id, int $project_id){

        $company = User::whereHas('company_project', function ($query) use($company_id, $project_id) {
            $query->where('company_project.company_id', '=', $company_id)
                  ->where('company_project.project_id', '=', $project_id);
        })->with(['roles','user_detail'])
        ->orderBy('users.login')
        ->get();

        return $this->sendResponse($company->toArray(), 'User-Roles by Project-Company relation retrieved successfully.');
    }

    /**
     * Change Activated status
     */
    public function changeActivatedStatus(int $user_id){

        $user = User::findOrFail($user_id);

        $user->activated = !$user->activated;
        $user->save();

        return $this->sendResponse($user->toArray(), 'Users status changed successfully.');

    }

    /**
     * Close session
     */
    public function logout(){
        Auth::user()->api_token = null;
        Auth::user()->save();
        return $this->sendResponse([], 'User logout.');
    }
    
    
}
