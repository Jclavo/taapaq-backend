<?php

namespace App\Http\Controllers;

use App\Models\UniversalPerson;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; 

class UniversalPersonController extends BaseController
{
    function __construct()
    {
        $this->middleware('permission_in_role:persons/read'); 
        $this->middleware('permission_in_role:persons/create', ['only' => ['store']]);
        $this->middleware('permission_in_role:persons/update', ['only' => ['update']]);
        $this->middleware('permission_in_role:persons/delete', ['only' => ['destroy']]); 
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = UniversalPerson::orderBy('name')->get();
            
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
            'identification' => ['required', 'numeric', 'min:8', 'unique:universal_people'],
            'email' => ['nullable','email','unique:universal_people'],
            'name' => 'required|max:45',
            'lastname' => 'required|max:45',
            'phone' => ['required', 'max:45','unique:universal_people'],
            'address' => 'required|max:100'
        ]);
      
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $user = new UniversalPerson();
        
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
     * @param  \App\UniversalPerson  $UniversalPerson
     * @return \Illuminate\Http\Response
     */
    public function show(UniversalPerson $UniversalPerson)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UniversalPerson  $UniversalPerson
     * @return \Illuminate\Http\Response
     */
    public function edit(UniversalPerson $UniversalPerson)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UniversalPerson  $UniversalPerson
     * @return \Illuminate\Http\Response
     */
    public function update(int $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'identification' => ['required', 'numeric', 'min:8', Rule::unique('universal_people')->ignore($id)],
            'email' => ['nullable','email',Rule::unique('universal_people')->ignore($id)],
            'name' => 'required|max:45',
            'lastname' => 'required|max:45',
            'phone' => ['required', 'max:45', Rule::unique('universal_people')->ignore($id)],
            'address' => 'required|max:100'
        ]);
      
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $user = UniversalPerson::findOrFail($id);
        
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
     * @param  \App\UniversalPerson  $UniversalPerson
     * @return \Illuminate\Http\Response
     */
    public function destroy(UniversalPerson $UniversalPerson)
    {
        //
    }
}
