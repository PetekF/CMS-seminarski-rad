<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;

/**
 * Description of LoginController
 *
 * @author Filip
 */
class LoginController {

    public function __construct() {
        
    }

    public function view() {
        return view("login");
    }

    public function authenticate(Request $request) {

        $credentials = $request->validateWithBag("login", [
            "email" => "required|email",
            "password" => "required"
        ]);
        
        if(!Auth::attempt($credentials)){
            $errBag = new MessageBag();
            $errBag->add("user", "User doesn't exit.");
            return back()->withErrors($errBag, "login");
        }
        
        
        return redirect()->intended('/dashboard');
        //return redirect("/register");
    }

    public function logout(){
        Auth::logout();
        return redirect("/");
    }
}
