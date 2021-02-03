<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UniversalPerson;
use App\Models\Company;
use App\Models\Project;
use App\Models\CustomSpatieRole as Role;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

//Utils
use App\Utils\PaginationUtil;
use App\Utils\UserUtil;
use App\Utils\ProjectUtil;
use App\Utils\TranslationUtil;

class UserController extends BaseController
{
    function __construct()
    {
        $this->middleware('permission_in_role:users/read', ['except' => ['login','logout', 'changePassword']]);
        $this->middleware('permission_in_role:users/create', ['only' => ['store']]);
        
        $this->middleware('permission_in_role:users/delete', ['only' => ['destroy']]);
        $this->middleware('permission_in_role:users/assign-role', ['only' => ['assignRole', 'assignMassiveRole']]);
        $this->middleware('permission_in_role:users/remove-role', ['only' => ['removeRole', 'assignMassiveRole']]);
        $this->middleware('permission_in_role:users/activated-status', ['only' => ['changeActivatedStatus']]);
        $this->middleware('permission_in_role:users/pagination', ['only' => ['pagination']]);
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
            'universal_person_id' => 'required|exists:universal_people,id',
            'company_id' => 'required|exists:companies,id',
            'project_id' => 'required|exists:projects,id'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $universalPerson = UniversalPerson::findOrFail($request->universal_person_id);

        $company_project_id = ProjectUtil::getCompanyProjectID($request->company_id, $request->project_id);

        $user = UserUtil::createCore($company_project_id,$universalPerson);;

        return $this->sendResponse($user->toArray(), TranslationUtil::getTranslation('crud.create'));  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with(['roles','person'])->findOrFail($id);
                
        return $this->sendResponse($user->toArray(), TranslationUtil::getTranslation('crud.read'));
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
        $universalPerson = UniversalPerson::findOrFail($user->universal_person_id);
        
        $user->login = $universalPerson->identification . $user->company_project_id;
        //Update password if it has a value
        if(!empty($request->password)){
            $user->password = bcrypt(base64_decode($request->password));
        }
        $user->save();

        return $this->sendResponse($user->toArray(), TranslationUtil::getTranslation('crud.update'));
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

        if($user->id === Auth::user()->id){
            return $this->sendError(TranslationUtil::getTranslation('user.delete.own'));
        }

        $user->delete();

        return $this->sendResponse($user->toArray(), TranslationUtil::getTranslation('crud.delete'));
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
            'isCustom' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        //Decrypt password
        $input = $request->all();
        $input['password'] = base64_decode($input['password']);
        $request->replace($input);

        if ($request->isCustom) {

            $user = User::where('login',$request->login)->first();

            if(!$user){
                return $this->sendError(TranslationUtil::getTranslation('user.login.incorrect')); 
            }

            if(!Hash::check($request->password, $user->password)){
                return $this->sendError(TranslationUtil::getTranslation('user.login.password.incorrect'));  
            }
            
        }else{

            $credentials = $request->only('login', 'password');

            if (!Auth::attempt($credentials)) {
                return $this->sendError(TranslationUtil::getTranslation('user.login.both.incorrect'));  
            }

            $user = Auth::user();
        }

        //check if user status validated is true
        if(!$user->activated){
            Auth::logout();
            return $this->sendError(TranslationUtil::getTranslation('user.not.activated'));   
        }

        $user->api_token = Str::random(80);
        $user->save();

        //load relationships
        $user->load(['company_project','company.person.country','project', 'company.setting','person']);
        
        if ($user->isSuper()) {
            $user->isSuper = 1;
        }else{
            $user->isSuper = 0;
        }

        $user->isAdmin = UserUtil::isAdminByToken($user->api_token);
        $user->hasInitialPassword = UserUtil::hasInitialPassword($user->id);

        // sync user in Ranqhana DB
        if (!$request->isCustom) {
            UserUtil::syncRanqhanaUser(Auth::user()->id, Auth::user()->login, Auth::user()->company_project->id);
        }

        return $this->sendResponse($user->toArray(), TranslationUtil::getTranslation('user.login.success'));          
    }

    public function changePassword(Request $request){

        $validator = Validator::make($request->all(), [
            'api_token' => 'required|size:80',
            'actualPassword' => 'required|min:8|max:45',
            'newPassword' => 'required|min:8|max:45',
            'reNewPassword' => 'required|min:8|max:45|same:newPassword'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        //Decrypt password
        $input = $request->all();
        $input['actualPassword'] = base64_decode($input['actualPassword']);
        $input['newPassword'] = base64_decode($input['newPassword']);
        $request->replace($input);

        //Check if token and password belong to same user
        $user = User::where('api_token',$request->api_token)
                    ->first();

        if(!$user){
            return $this->sendError(TranslationUtil::getTranslation('user.token.invalid'));    
        }

        if(!Hash::check($request->actualPassword, $user->password)){
            return $this->sendError(TranslationUtil::getTranslation('user.actual-password.incorrect'));  
        }

        //Check password is not the same as user login
        if($request->newPassword == $user->login){
            return $this->sendError(TranslationUtil::getTranslation('user.new-password.equal')); 
        }

        $user->password = bcrypt($request->newPassword);
        $user->api_token = Str::random(80);
        $user->save();

        return $this->sendResponse($user->toArray(), TranslationUtil::getTranslation('user.password.changed'));
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

        return $this->sendResponse($user->toArray(), TranslationUtil::getTranslation('role.assign.success'));  
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

        return $this->sendResponse($user->toArray(), TranslationUtil::getTranslation('crud.assign'));  
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
            return $this->sendError(TranslationUtil::getTranslation('crud.remove.error'));  
        }

        $user->removeRole($role);

        return $this->sendResponse($user->toArray(), TranslationUtil::getTranslation('crud.remove'));  
    }

    /**
     * Display a listing of user and its roles by Project-Company relation
     */
    public function UserRolesByProjectCompany(int $company_id, int $project_id){

        $company = User::whereHas('company_project', function ($query) use($company_id, $project_id) {
            $query->where('company_project.company_id', '=', $company_id)
                  ->where('company_project.project_id', '=', $project_id);
        })->with(['roles'])
        ->orderBy('users.login')
        ->get();

        return $this->sendResponse($company->toArray(), TranslationUtil::getTranslation('crud.read'));
    }

    /**
     * Change Activated status
     */
    public function changeActivatedStatus(int $user_id){

        $user = User::findOrFail($user_id);

        $user->activated = !$user->activated;
        $user->save();

        return $this->sendResponse($user->toArray(), TranslationUtil::getTranslation('user.status.changed'));

    }

    /**
     * Close session
     */
    public function logout(){
        Auth::user()->api_token = null;
        Auth::user()->save();
        return $this->sendResponse([], TranslationUtil::getTranslation('user.logout'));
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
        $company_id    = $request->company_id;
        $project_id    = $request->project_id;
        $role_id       = $request->role_id;


        $query = User::query();
        $query->with(['company','roles','person']);

        $query->whereHas('company_project', function ($query) use($company_id,$project_id){
            $query->when($company_id > 0, function ($query) use($company_id) {
                return $query->where('company_project.company_id', '=', $company_id);
            });
            $query->when($project_id > 0, function ($query) use($project_id) {
                return $query->where('company_project.project_id', '=', $project_id);
            }); 
        });

        $query->when($role_id > 0, function ($query) use($role_id) {
            return $query->whereHas('roles', function ($query) use($role_id){
                $query->where('id',$role_id);    
            });
        });  

        $query->whereHas('person', function ($query) use ($searchValue,$sortColumn, $sortDirection) {
            $query->where('universal_people.identification', 'like', '%'. $searchValue .'%')
                  ->orwhere('universal_people.name', 'like', '%'. $searchValue .'%')
                  ->orwhere('universal_people.lastname', 'like', '%'. $searchValue .'%')
                  ->orWhere('universal_people.email', 'like', '%'. $searchValue .'%')
                  ->orWhere('universal_people.phone', 'like', '%'. $searchValue .'%')
                  ->orWhere('universal_people.address', 'like', '%'. $searchValue .'%');
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
        //     $q->orwhere('universal_people.identification', 'like', '%'. $searchValue .'%')
        //       ->orwhere('universal_people.name', 'like', '%'. $searchValue .'%')
        //       ->orwhere('universal_people.lastname', 'like', '%'. $searchValue .'%')
        //       ->orWhere('universal_people.email', 'like', $searchValue .'%')
        //       ->orWhere('universal_people.phone', 'like', $searchValue .'%')
        //       ->orWhere('universal_people.address', 'like', $searchValue .'%');
        // });

        // $results = $query->orderBy('users.'.$sortColumn, $sortDirection)
        //                  ->paginate($pageSize);
 
        return $this->sendResponse($results->items(), TranslationUtil::getTranslation('crud.pagination'), $results->total() );

    }
    
    
}
