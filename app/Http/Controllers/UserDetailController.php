<?php

namespace App\Http\Controllers;

use App\Models\UserDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; 

class UserDetailController extends BaseController
{
    function __construct()
    {
        $this->middleware('permission_in_role:Users Masters/read'); 
        $this->middleware('permission_in_role:Users Masters/create', ['only' => ['store']]);
        $this->middleware('permission_in_role:Users Masters/update', ['only' => ['update']]);
        $this->middleware('permission_in_role:Users Masters/delete', ['only' => ['destroy']]); 
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = UserDetail::orderBy('name')->get();
            
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
            'identification' => ['required', 'numeric', 'min:8', 'unique:user_details'],
            'email' => ['nullable','email','unique:user_details'],
            'name' => 'required|max:45',
            'lastname' => 'required|max:45',
            'phone' => ['required', 'max:45','unique:user_details'],
            'address' => 'required|max:100'
        ]);
      
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $user = new UserDetail();
        
        $user->identification = $request->identification;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->phone = $request->phone;
        $user->address = $request->address;

        $user->save();
        
        return $this->sendResponse($user->toArray(), 'User created successfully.');  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserDetail  $userDetail
     * @return \Illuminate\Http\Response
     */
    public function show(UserDetail $userDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserDetail  $userDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(UserDetail $userDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserDetail  $userDetail
     * @return \Illuminate\Http\Response
     */
    public function update(int $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'identification' => ['required', 'numeric', 'min:8', Rule::unique('user_details')->ignore($id)],
            'email' => ['nullable','email',Rule::unique('user_details')->ignore($id)],
            'name' => 'required|max:45',
            'lastname' => 'required|max:45',
            'phone' => ['required', 'max:45', Rule::unique('user_details')->ignore($id)],
            'address' => 'required|max:100'
        ]);
      
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $user = UserDetail::findOrFail($id);
        
        $user->identification = $request->identification;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->phone = $request->phone;
        $user->address = $request->address;

        $user->save();
        
        return $this->sendResponse($user->toArray(), 'User updated successfully.');  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserDetail  $userDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserDetail $userDetail)
    {
        //
    }
}
