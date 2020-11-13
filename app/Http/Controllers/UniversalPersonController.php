<?php

namespace App\Http\Controllers;

use App\Models\UniversalPerson;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; 

//Utils
use App\Utils\PaginationUtil;

class UniversalPersonController extends BaseController
{
    function __construct()
    {
        $this->middleware('permission_in_role:persons/read'); 
        $this->middleware('permission_in_role:persons/create', ['only' => ['store']]);
        $this->middleware('permission_in_role:persons/update', ['only' => ['update']]);
        $this->middleware('permission_in_role:persons/delete', ['only' => ['destroy']]); 
        $this->middleware('permission_in_role:persons/pagination', ['only' => ['pagination']]); 
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
            'type_id' => 'required|exists:person_types,code',
            'email' => ['nullable','email','unique:universal_people'],
            'name' => 'required|max:45',
            'lastname' => 'required|max:45',
            'phone' => ['required', 'max:45','unique:universal_people'],
            'address' => 'required|max:100',
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
        $user->type_id = $request->type_id;

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
            // 'identification' => ['required', 'numeric', 'min:8', Rule::unique('universal_people')->ignore($id)],
            'type_id' => 'required|exists:person_types,code',
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
        
        // $user->identification = $request->identification;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->type_id = $request->type_id;

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

        /**
     * Pagination of table users
     */
    public function pagination(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pageSize' => 'numeric|gt:0',
        ]);

        $validator->sometimes('company_id', 'exists:companies,id', function ($input) {
            return $input->company_id > 0;
        });

        $validator->sometimes('project_id', 'exists:projects,id', function ($input) {
            return $input->project_id > 0;
        });

        $validator->sometimes('role_id', 'exists:roles,id', function ($input) {
            return $input->role_id > 0;
        });

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

       // SearchOptions values
        $pageSize      = PaginationUtil::getPageSize($request->pageSize);
        $sortColumn    = PaginationUtil::getSortColumn($request->sortColumn,'universal_people');
        $sortDirection = PaginationUtil::getSortDirection($request->sortDirection);
        $searchValue   = $request->searchValue;
        //custom fields from User

        $query = UniversalPerson::query();

        $query->where('universal_people.identification', 'like', '%'. $searchValue .'%')
                  ->orwhere('universal_people.name', 'like', '%'. $searchValue .'%')
                  ->orwhere('universal_people.lastname', 'like', '%'. $searchValue .'%')
                  ->orWhere('universal_people.email', 'like', '%'. $searchValue .'%')
                  ->orWhere('universal_people.phone', 'like', '%'. $searchValue .'%')
                  ->orWhere('universal_people.address', 'like', '%'. $searchValue .'%');

        
        $results = $query->orderBy('universal_people.'. $sortColumn, $sortDirection)
                         ->paginate($pageSize);
 
        return $this->sendResponse($results->items(), 'Persons retrieved successfully.', $results->total() );

    }

}
