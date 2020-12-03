<?php

namespace App\Http\Controllers;

use App\Models\UniversalPerson;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; 
use App\Models\PersonType;

//Utils
use App\Utils\PaginationUtil;

//Rules
use App\Rules\IdentificationCountry;
use App\Rules\PhoneCountry;


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
        // $users = UniversalPerson::orderBy('name')->get();
            
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
            'country_code' => 'required|exists:countries,code',
            'type_id' => 'required|exists:person_types,code',
            'identification' => ['required', 'numeric' ,
                    'min:8', 'unique:universal_people',
                    new IdentificationCountry($request->country_code, $request->type_id)],
            'email' => ['nullable','email','unique:universal_people'],
            'name' => 'required|max:45',
            'phone' => ['required', 'max:45','unique:universal_people', new PhoneCountry($request->country_code) ],
            'address' => 'required|max:100', 
            
        ]);

        $validator->sometimes('lastname', 'required|max:45', function ($request) {
            return $request->type_id == PersonType::getForNatural();
        });
      
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
        $user->country_code = $request->country_code;

        $user->save();
        
        return $this->sendResponse($user->toArray(), 'User created successfully.');  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UniversalPerson  $UniversalPerson
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $person = UniversalPerson::findOrFail($id);
                
        return $this->sendResponse($person->toArray(), 'Person retrieved successfully.');
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
            // 'type_id' => 'required|exists:person_types,code',
            'email' => ['nullable','email',Rule::unique('universal_people')->ignore($id)],
            'name' => 'required|max:45',
            'phone' => ['required', 'max:45', Rule::unique('universal_people')->ignore($id)],
            'address' => 'required|max:100'
        ]);

        $user = UniversalPerson::findOrFail($id);

        $validator->sometimes('lastname', 'required|max:45', function ($user) {
            return $user->type_id == PersonType::getForNatural();
        });
      
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

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

        /**
     * Pagination of table users
     */
    public function pagination(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pageSize' => 'numeric|gt:0',
        ]);

        $validator->sometimes('company_id', 'exists:companies,id', function ($request) {
            return $request->company_id > 0;
        });

        $validator->sometimes('project_id', 'exists:projects,id', function ($request) {
            return $request->project_id > 0;
        });

        $validator->sometimes('role_id', 'exists:roles,id', function ($request) {
            return $request->role_id > 0;
        });

        $validator->sometimes('type_id', 'required|exists:person_types,code', function ($request) {
            return $request->type_id > 0;
        });

        $validator->sometimes('country_code', 'required|exists:countries,code', function ($request) {
            return !empty($request->country_code);
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
        $identification   = $request->identification;
        $type_id   = $request->type_id;
        $country_code   = $request->country_code;

        $query = UniversalPerson::query();

        $query->where('universal_people.identification', 'like', '%'. $identification .'%');
        // 
                //   ->orwhere('universal_people.name', 'like', '%'. $searchValue .'%')
                //   ->orwhere('universal_people.lastname', 'like', '%'. $searchValue .'%')
                //   ->orWhere('universal_people.email', 'like', '%'. $searchValue .'%')
                //   ->orWhere('universal_people.phone', 'like', '%'. $searchValue .'%')
                //   ->orWhere('universal_people.address', 'like', '%'. $searchValue .'%');

        $query->when($type_id > 0, function ($query) use($type_id) {
            return $query->where('universal_people.type_id',$type_id);    
        });

        $query->when(!empty($country_code), function ($query) use($country_code) {
            return $query->where('universal_people.country_code', $country_code);   
        });  

        // $query->with('country');

        $results = $query->orderBy('universal_people.'. $sortColumn, $sortDirection)
                         ->paginate($pageSize);
 
        return $this->sendResponse($results->items(), 'Persons retrieved successfully.', $results->total() );

    }

}
