<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/", function () {
    return view("welcome");
});

Route::get("/dashboard", [App\Http\Controllers\DashboardController::class, "index"])
    ->name("dashboard")
    ->middleware([Authenticate::class]);

Route::get("/todo", [App\Http\Controllers\TaskController::class, "index"])
    ->name("todo")
    ->middleware([Authenticate::class]);

Route::get("/login", [App\Http\Controllers\LoginController::class, "view"])
    ->name("login");

Route::post("/login", [App\Http\Controllers\LoginController::class, "authenticate"]);

Route::get("/register", [App\Http\Controllers\RegistrationController::class, "view"])
    ->name("register");

Route::post("/register", [App\Http\Controllers\RegistrationController::class, "register"]);

Route::get("/logout", [App\Http\Controllers\LoginController::class, "logout"]);

Route::get("/phpinfo", function(){
    return phpinfo();
});
