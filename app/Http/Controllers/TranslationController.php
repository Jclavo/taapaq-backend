<?php

namespace App\Http\Controllers;

use App\Models\Translation;
use App\Models\SystemModel;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;

class TranslationController extends BaseController
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
            'model_id' => 'required|exists:system_models,id',
            'key' => 'required',
            'translationable_id' => 'nullable|gt:0'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $translation = new Translation();
        $translation->key = $request->key;
        $translation->translationable_id = $request->translationable_id;

        $model = SystemModel::findOrFail($request->model_id);
        $model->translations()->save($translation);

        return $this->sendResponse($translation->toArray(), 'Translation created successfully.'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Translation  $translation
     * @return \Illuminate\Http\Response
     */
    public function show(Translation $translation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Translation  $translation
     * @return \Illuminate\Http\Response
     */
    public function edit(Translation $translation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Translation  $translation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Translation $translation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Translation  $translation
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $translation = Translation::findOrFail($id);

        $translation->delete();

        return $this->sendResponse($translation->toArray(), 'Translation deleted successfully.');
    }


     /**
     * Get Translation by Model
     * 
     * @return \Illuminate\Http\Response
     */
    public function translationsByModel(int $model_id){

        $models = Translation::whereHas('model', function ($query) use($model_id) {
            $query->where('system_models.id', '=', $model_id);
        })
        ->get();

        return $this->sendResponse($models->toArray(), 'Translations retrieved successfully.');
    }


}
