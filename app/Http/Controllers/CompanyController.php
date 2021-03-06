<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Project;
use App\Models\UniversalPerson;
use App\Models\PersonType;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

//Utils
use App\Utils\CompanyUtil;
use App\Utils\TranslationUtil;

class CompanyController extends BaseController
{
    function __construct()
    {
        $this->middleware('permission_in_role:companies/read'); 
        $this->middleware('permission_in_role:companies/create', ['only' => ['store']]);
        $this->middleware('permission_in_role:companies/update', ['only' => ['update']]);
        $this->middleware('permission_in_role:companies/delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::with('person.country')->get();

        return $this->sendResponse($companies->toArray(), TranslationUtil::getTranslation('crud.pagination'));
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
            'universal_person_id' => 'required|exists:universal_people,id|unique:companies'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $person = UniversalPerson::findOrFail($request->universal_person_id);

        if($person->type_id == PersonType::getForNatural()){
            return $this->sendError('The person is not juridical.');
        }

        $company = CompanyUtil::createCore($request->universal_person_id);

        return $this->sendResponse($company->toArray(), TranslationUtil::getTranslation('crud.create'));      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        // $company = Company::findOrFail($id);

        // $company->delete();

        // return $this->sendResponse($company->toArray(), TranslationUtil::getTranslation('crud.delete'));
    }

    /**
     * Get Companies that are missing in a project.
     */

    public function NotInProject(int $id){

        $companies = Company::whereDoesntHave('projects', function ($query) use($id) {
            $query->where('projects.id', '=', $id);
        })->get();

        return $this->sendResponse($companies->toArray(), TranslationUtil::getTranslation('crud.pagination'));

    }


}
