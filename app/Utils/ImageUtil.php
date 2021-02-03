<?php

namespace App\Utils;

use App\Models\Image;
use Illuminate\Support\Facades\Auth;

class ImageUtil
{
    static function getImage($model_id,$model){

        return Image::where('imageable_id', $model_id)
                    ->where('imageable_type', $model)
                    ->where('company_project_id', Auth::user()->company_project_id)
                    ->get();
    }
}