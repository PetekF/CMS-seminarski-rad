<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ImageController
{
    public function store(Request $request){
        if($request->file('image') === null){
            $responseMessage = json_encode([
                'errorCode'     => 1,
                'errorMessage'  => __('No image given')
            ]);
    
            return response($responseMessage, 400)->header('Content-Type', 'application/json');
        }
    
        if(file_exists(public_path('images/pages/') . $request->file('image')->getClientOriginalName())){
            $responseMessage = json_encode([
                'errorCode'     => 2,
                'errorMessage'  => __('Image with that name already exists'),
                'url'           => '/images/pages/' . $request->file('image')->getClientOriginalName()
            ]);
    
            return response($responseMessage, 409)->header('Content-Type', 'application/json');
        }
    
        try{
            $request->file('image')->move(public_path('images/pages/'), $request->file('image')->getClientOriginalName());
        }
        catch(Exception $e){
            Log::error($e);
            return response(status: 500);
        }
        
        $responseMessage = json_encode([
            'success' => true,
            'url' => '/images/pages/' . $request->file('image')->getClientOriginalName()
        ]);
        
        return response($responseMessage, 200)->header('Content-Type', 'application/json');
    }
}