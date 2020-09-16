<?php

namespace App\Http\Controllers;

use App\Models\SystemModel;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\Auth;

class SystemModelController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'project_id' => 'required|exists:projects,id',
            'name' => ['required','max:45', 
                        Rule::unique('system_models')->where(function($query) use($request) {
                            $query->where('project_id', '=', $request->project_id);
                        })],
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $systemModel = new SystemModel();
        $systemModel->name = $request->name;

        $project = Project::findOrFail($request->project_id);
        $project->system_models()->save($systemModel);

        return $this->sendResponse($systemModel->toArray(), 'Model created successfully.'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SystemModel  $systemModel
     * @return \Illuminate\Http\Response
     */
    public function show(SystemModel $systemModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SystemModel  $systemModel
     * @return \Illuminate\Http\Response
     */
    public function edit(SystemModel $systemModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SystemModel  $systemModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SystemModel $systemModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SystemModel  $systemModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $systemModel = SystemModel::findOrFail($id);

        $systemModel->delete();

        return $this->sendResponse($systemModel->toArray(), 'Model deleted successfully.');
    }

}
