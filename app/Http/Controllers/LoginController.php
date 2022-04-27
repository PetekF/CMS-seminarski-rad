<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use App\Models\User;
use \Illuminate\Support\Facades\Hash;
use App\Constants;
Use Illuminate\Support\Facades\Log;

/**
 * Description of LoginController
 *
 * @author Filip
 */
class LoginController extends Controller{

    public function view() {
        return view("cms.login");
    }

    public function authenticate(Request $request) {

        $credentials = $request->validateWithBag("login", [
            "username" => "required",
            "password" => "required"
        ]);

        $rememberMe = (bool)$request->input('remember_me');

        
        $user = User::where('username', $credentials['username'])->first();

        $errBag = new MessageBag();

        if($user === null){
            $errBag->add("user", __("User doesn't exist"));
            return back()->withErrors($errBag, "login");
        }
        
        
        // CHECK IF LOGIN ATTEMPTS ARE GREATER THAN MAX VALUE
        if ($user->login_attempts >= Constants::MAX_LOGIN_ATTEMPTS){
            $user->login_attempts += 1;
            $user->save();
            
            $msg = __("User not allowed to log in") . ". " . __("Too many failed attempts");
            $errBag->add("login_forbidden", $msg);
            return back()->withErrors($errBag, "login");
        }
        
        if(!Hash::check($credentials['password'], $user->password)){
            
            $user->login_attempts += 1;
            $user->save();
            
            $msg = __("Wrong password") . ". " . __("Login attempts left") . ": ";
            $errBag->add("password", $msg . Constants::MAX_LOGIN_ATTEMPTS - $user->login_attempts);
            return back()->withErrors($errBag, "login");
        }
        
        $user->login_attempts = 0;
        $user->update();
        
        Auth::guard('web')->login($user, $rememberMe);
        
        Log::info("User \"$user->username\" logged in.");
        
        $request->session()->regenerate();
        
        return redirect()->intended(route('dashboard'));
    }

    public function logout(){
        Auth::logout();
        return redirect("/");
    }
}
