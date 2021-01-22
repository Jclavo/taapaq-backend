<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
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
    public function store(Request $request)
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
    public function destroy($image)
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
}
