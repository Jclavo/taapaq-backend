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

//Utils
use App\Utils\PaginationUtils;

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
    public function show($id)
    {
        $user = User::with(['user_detail','roles'])->findOrFail($id);
                
        return $this->sendResponse($user->toArray(), 'User retrieved successfully.');
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
    public function update(int $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'nullable|min:8|max:45',
            'repassword' => 'nullable|required_with:password|min:8|max:45|same:password'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $user = User::findOrFail($id);
        $userDetails = UserDetail::findOrFail($user->user_detail_id);
        
        $user->login = $userDetails->identification . $user->company_project_id;
        //Update password if it has a value
        if(!empty($request->password)){
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return $this->sendResponse($user->toArray(), 'User updated successfully.');
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

        Auth::user()->load(['company_project','user_detail','company.country']);
        
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
     * Assign massive roles to an User
     * 
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function assignMassiveRole(Request $request){

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'roles' => 'nullable|array',
            'roles.*' => 'nullable|exists:roles,id'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $user = User::findOrFail($request->user_id);
        // $roles = $request->roles ;

        // All current roles will be removed from the user and replaced by the array given
        // $user->syncRoles(['writer', 'admin']);

        $roles = array();
        foreach ($request->roles as $value) {
            array_push($roles, Role::findOrFail($value));
        } 

        $user->syncRoles($roles);

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

        $validator->sometimes('role_id', 'exists:roles,id', function ($input) {
            return $input->role_id > 0;
        });

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }


        // $company = User::whereHas('company_project', function ($query) use($company_id, $project_id) {
        //     $query->where('company_project.company_id', '=', $company_id)
        //           ->where('company_project.project_id', '=', $project_id);
        // })->with(['roles','user_detail'])
        // ->orderBy('users.login')
        // ->get();


       // SearchOptions values
        $pageSize      = PaginationUtils::getPageSize($request->pageSize);
        $sortColumn    = PaginationUtils::getSortColumn($request->sortColumn,'user_details');
        $sortDirection = PaginationUtils::getSortDirection($request->sortDirection);
        $searchValue   = $request->searchValue;
        //custom fields from User
        $company_id    = $request->company_id;
        $role_id       = $request->role_id;


        $query = User::query();
        $query->with(['user_detail','company','roles']);

        $query->whereHas('company_project', function ($query) use($company_id){
                $query->when($company_id > 0, function ($query) use($company_id) {
                    return $query->where('company_project.company_id', '=', $company_id);
                });    
        });

        $query->when($role_id > 0, function ($query) use($role_id) {
            return $query->whereHas('roles', function ($query) use($role_id){
                $query->where('id',$role_id);    
            });
        });  

        $query->whereHas('user_detail', function ($query) use ($searchValue,$sortColumn, $sortDirection) {
            $query->where('user_details.identification', 'like', '%'. $searchValue .'%')
                  ->orwhere('user_details.name', 'like', '%'. $searchValue .'%')
                  ->orwhere('user_details.lastname', 'like', '%'. $searchValue .'%')
                  ->orWhere('user_details.email', 'like', '%'. $searchValue .'%')
                  ->orWhere('user_details.phone', 'like', '%'. $searchValue .'%')
                  ->orWhere('user_details.address', 'like', '%'. $searchValue .'%');
        });
        
        $results = $query->orderBy('users.'. $sortColumn, $sortDirection)
                         ->paginate($pageSize);
        // $results = $query->paginate($pageSize);


        
        // $query->select('users.id','users.login','users.identification','users.name','users.lastname','users.email',
        //                 'users.phone','users.address', 'users.store_id','stores.name as store')
        // $query->select('users.*','stores.name as store', 'countries.code as country_code')
        //       ->join('stores', 'users.store_id', '=', 'stores.id')
        //       ->join('countries', 'stores.country_id', '=', 'countries.id');    
       
        // $query->where(function($q) use ($searchValue){
        //     $q->where('users.login', 'like', '%'. $searchValue .'%');
        // });

        // $query->where(function($q) use ($searchValue){
        //     $q->orwhere('user_details.identification', 'like', '%'. $searchValue .'%')
        //       ->orwhere('user_details.name', 'like', '%'. $searchValue .'%')
        //       ->orwhere('user_details.lastname', 'like', '%'. $searchValue .'%')
        //       ->orWhere('user_details.email', 'like', $searchValue .'%')
        //       ->orWhere('user_details.phone', 'like', $searchValue .'%')
        //       ->orWhere('user_details.address', 'like', $searchValue .'%');
        // });

        // $results = $query->orderBy('users.'.$sortColumn, $sortDirection)
        //                  ->paginate($pageSize);
 
        return $this->sendResponse($results->items(), 'Users retrieved successfully.', $results->total() );

    }
    
    
}
