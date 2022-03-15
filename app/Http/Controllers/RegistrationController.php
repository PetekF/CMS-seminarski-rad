<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;

/**
 * Description of RegistrationController
 *
 * @author Filip
 */
class RegistrationController {
    
    public function __construct(){
        
    }
    
    public function view(){
        return view("register");
    }
    
    /**
     * @param  \Illuminate\Http\Request  $request
     */
    public function register(Request $request){

        $credentials = $request->validateWithBag("registration",[
            "name" => "required|min:4",
            "email" => "required|email",
            "password" => "required|min:6|confirmed"
        ]);
     
        // Check if user exists
        $user = User::where("email", $credentials["email"])->first();
        
        if($user !== null){
            $errBag = new MessageBag();
            $errBag->add("user", "User with that email already exists.");
            return back()->withErrors($errBag, "registration")->withInput();
        }
        
        // Create user
        $user = new User();
        $user->name = $credentials["name"];
        $user->email = $credentials["email"];
        $user->password = Hash::make($credentials["password"]);
        
        $user->save();  
     
        // 
        return back()->with("registration_success", true);
    }
}
