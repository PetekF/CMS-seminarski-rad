<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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


Route::get("/login", [App\Http\Controllers\LoginController::class, "view"])
    ->name("login");

Route::post("/login", [App\Http\Controllers\LoginController::class, "authenticate"]);

Route::get("/logout", [App\Http\Controllers\LoginController::class, "logout"]);



Route::prefix('cms')->middleware('auth:web')->group(function(){

    Route::get("/dashboard", [App\Http\Controllers\DashboardController::class, 'index'])
        ->name("dashboard");

    // USER
    Route::get("/users", [App\Http\Controllers\UserController::class, 'index'])
        ->name('users');

    Route::delete("/user/{id}", [\App\Http\Controllers\UserController::class, 'destroy'])
        ->name('delete_user');

    Route::get("/user/{id}/edit", [\App\Http\Controllers\UserController::class, 'edit'])
        ->name('edit_user');

    Route::get('/user/create', [\App\Http\Controllers\UserController::class, 'create'])
        ->name('new_user');

    Route::post('/user', [\App\Http\Controllers\UserController::class, 'store'])
        ->name('create_user');

    Route::get('/user/{id}', [\App\Http\Controllers\UserController::class, 'edit'])
        ->name('edit_user');

    Route::patch('/user/{id}', [\App\Http\Controllers\UserController::class, 'update'])
        ->name('update_user');

    
    // ROLE
    Route::get("/roles", [App\Http\Controllers\RoleController::class, 'index'])
        ->name('roles');

    Route::get('/role/create', [\App\Http\Controllers\RoleController::class, 'create'])
        ->name('new_role');
    
    Route::delete("/role/{id}", [\App\Http\Controllers\RoleController::class, 'destroy'])
        ->name('delete_role');

    Route::get('/role/{id}', [\App\Http\Controllers\RoleController::class, 'edit'])
        ->name('edit_role');

    Route::post('/role', [\App\Http\Controllers\RoleController::class, 'store'])
        ->name('create_role');  

    Route::patch('/role/{id}', [\App\Http\Controllers\RoleController::class, 'update'])
        ->name('update_role');
    

    // PAGES
    Route::patch('/page/root', [\App\Http\Controllers\PageController::class, 'setAsRoot'])
        ->name('root_page');

    Route::get('/pages', [App\Http\Controllers\PageController::class, 'index'])
        ->name('pages');

    Route::get('/page/create', [\App\Http\Controllers\PageController::class, 'create'])
        ->name('new_page');

    Route::delete("/page/{id}", [\App\Http\Controllers\PageController::class, 'destroy'])
        ->name('delete_page');

    Route::get('/page/{id}', [\App\Http\Controllers\PageController::class, 'edit'])
        ->name('edit_page');

    Route::post('/page', [\App\Http\Controllers\PageController::class, 'store'])
        ->name('create_page');  

    Route::patch('/page/{id}', [\App\Http\Controllers\PageController::class, 'update'])
        ->name('update_page');
        

    // NAVIGATION
    Route::get('/navigation', [\App\Http\Controllers\NavigationController::class, 'index'])
        ->name('navigation');

    Route::post('/navigation', [\App\Http\Controllers\NavigationController::class, 'store'])
        ->name('create_navigation_item');

    Route::patch('/navigation/{id}', [\App\Http\Controllers\NavigationController::class, 'update'])
        ->name('update_navigation');

    Route::get('/navigation/create', [\App\Http\Controllers\NavigationController::class, 'create'])
        ->name('new_navigation');

    Route::delete('/navigation/{id}', [\App\Http\Controllers\NavigationController::class, 'destroy'])
        ->name('delete_navigation');
    
});

Route::post('api/image', [\App\Http\Controllers\Api\ImageController::class, 'store']);


// Public facing routes, no need to be authenticated

Route::get('/', [App\Http\Controllers\PageController::class, 'rootPage']);

Route::get("/{page}", [\App\Http\Controllers\PageController::class, 'show'])
    ->name('static_page');

