<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\UniversalPerson;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Validation\Rule; 
use App\Utils\TranslationUtil;

class ImageController extends BaseController
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
    public function storePhysical(Request $request)
    {       
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|max:1024'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        
        $imageFile = $request->file('image');
        
        $path = Auth::user()->company_project_id;
        $imageNewName = Carbon::now()->timestamp . '.' . $imageFile->getClientOriginalExtension();
        
        $filename = Storage::disk('images')->putFileAs($path, $imageFile, $imageNewName);
        $fullPath = Storage::disk('images')->path('') . $filename ;
        
        return $this->sendResponse(['name' => basename($filename), 'fullPath' => $fullPath ], TranslationUtil::getTranslation('crud.create'));  
    }

    public function storeLogical(Request $request)
    {
        $this->modelsAllowed = array('PERSON');

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'model_id' => 'required|integer|gt:0',
            'model' => [
                'required',
                Rule::in($this->modelsAllowed)
            ]
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        switch ($request->model) {
            case 'PERSON':
                UniversalPerson::findOrFail($request->model_id); 
                $model = UniversalPerson::class;
                break;
            
            default:
                # code...
                break;
        }

        $newImage = new Image();
        $newImage->name = $request->name;
        $newImage->imageable_id = $request->model_id;
        $newImage->imageable_type = $model;
        $newImage->save();

        return $this->sendResponse($newImage->toArray(), TranslationUtil::getTranslation('crud.create'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroyPhysical($image)
    {
        $path = Auth::user()->company_project_id . '/' . $image;

        $fileexists = Storage::disk('images')->exists( $path );    

        if ($fileexists) {
            unlink(Storage::disk('images')->path('') . $path );
            return $this->sendResponse([], TranslationUtil::getTranslation('crud.delete')); 
        }else{
            return $this->sendError('Image does not exist.');
        }

    }

    public function destroyLogical(int $id)
    {
        $image = Image::findOrFail($id);
        
        $image->delete();

        return $this->sendResponse($image->toArray(), TranslationUtil::getTranslation('crud.delete'));
    }
}
