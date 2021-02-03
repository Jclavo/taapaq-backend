<?php

namespace App\Http\Controllers;

use App\Models\Translation;
use App\Models\TranslationDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule; 
use App\Utils\TranslationUtil;

class TranslationDetailController extends BaseController
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
            'translation_id' => 'required|exists:translations,id',
            'locale' => ['required','exists:locales,code', 
                        Rule::unique('translation_details')->where(function($query) use($request) {
                            $query->where('translation_id', '=', $request->translation_id);
                      })],
            'value' => ['required','max:200', 
                        Rule::unique('translation_details')->where(function($query) use($request) {
                            $query->where('translation_id', '=', $request->translation_id)
                                  ->where('locale', '=', $request->locale);
                      })],
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $translationDetail = new TranslationDetail();
        $translationDetail->value = $request->value;
        $translationDetail->locale = $request->locale;

        //fk translation
        $translation = Translation::findOrFail($request->translation_id);
        $translation->details()->save($translationDetail);

        return $this->sendResponse($translationDetail->toArray(), TranslationUtil::getTranslation('crud.create')); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TranslationDetail  $translationDetail
     * @return \Illuminate\Http\Response
     */
    public function show(TranslationDetail $translationDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TranslationDetail  $translationDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(TranslationDetail $translationDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TranslationDetail  $translationDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TranslationDetail $translationDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TranslationDetail  $translationDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $translationDetail = TranslationDetail::findOrFail($id);

        $translationDetail->delete();

        return $this->sendResponse($translationDetail->toArray(), TranslationUtil::getTranslation('crud.delete'));
    }

    
    /**
     * Get Detail by Translation
     * 
     * @return \Illuminate\Http\Response
     */
    public function detailsByTranslation(int $translation_id){

        $models = TranslationDetail::whereHas('translation', function ($query) use($translation_id) {
            $query->where('translations.id', '=', $translation_id);
        })
        ->get();

        return $this->sendResponse($models->toArray(), TranslationUtil::getTranslation('crud.pagination'));
    }


    /**
     * Get Translation
     */

    public function getTranslation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required|max:45',
            'translationable_type' => 'required|max:45',
            // 'translationable_id' => 'nullable|gt:0',
            // 'model_id' => 'required|exists:system_models,id',
            'locale' => 'required|exists:locales,code'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $translation = TranslationUtil::getTranslationCore($request->key, $request->translationable_type, $request->locale);

        return $this->sendResponse($translation->toArray(), TranslationUtil::getTranslation('crud.read'));

     }
}
