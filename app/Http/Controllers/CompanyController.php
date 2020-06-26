<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Project;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $companies = Company::orderBy('name')->get();

        return $this->sendResponse($companies->toArray(), 'Companies retrieved successfully.');
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
            'name' => 'required|unique:companies',
            'country_id' => 'required|exists:countries,id'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $company = Company::create(['name' => $request->name, 'country_id' => $request->country_id]);

        return $this->sendResponse($company->toArray(), 'Company created successfully.');      
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
        $company = Company::findOrFail($id);

        $company->delete();

        return $this->sendResponse($company->toArray(), 'Company deleted successfully.');
    }

    /**
     * Get Companies that are missing in a project.
     */

    public function NotInProject(int $id){

        $companies = Company::whereDoesntHave('projects', function ($query) use($id) {
            $query->where('projects.id', '=', $id);
        })->get();

        return $this->sendResponse($companies->toArray(), 'Project - Roles retrieved successfully.');

    }


}
