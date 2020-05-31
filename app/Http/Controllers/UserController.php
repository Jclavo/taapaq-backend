<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
            
        return $this->sendResponse($users->toArray(), 'Users retrieved successfully.');
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
            'name' => 'required|max:45',
            'email' => 'required|email|max:45|unique:users',
        ]);
        
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $user = new User();
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->email);

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
    public function destroy(User $user)
    {
        //
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

    
    
}
