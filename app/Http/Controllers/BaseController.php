<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;

class BaseController extends Controller
{
    public function sendResponse($result, $message, $records = 0)
    {
        $response = ['status' => true, 'result' => $result, 'message' => $message, 'records' => $records];
        
        return response()->json($response, 200);
    }
    
    public function sendError($error, $errorMessages = [], $code = 200)
    {
        $response = ['status' => false, 'result' => $errorMessages, 'message' => $error, 'records' => 0];
        
        return response()->json($response, $code);
    }
  
}
