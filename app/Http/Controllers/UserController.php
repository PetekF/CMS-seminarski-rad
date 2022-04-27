<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;
// use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filterRules = [];

        $filterRules['first_name']      = $request->query('first_name') ?? null;
        $filterRules['last_name']       = $request->query('last_name') ?? null;
        $filterRules['email']           = $request->query('email') ?? null;
        $filterRules['username']        = $request->query('username') ?? null;
        $filterRules['per_page']        = $request->query('per_page') !== null ? (int)$request->query('per_page') : Constants::DEFAULT_ITEMS_PER_PAGE;
        $filterRules['page']            = $request->query('page') !== null ? (int) (int)$request->query('page') : 1;

        $usersPage = (new User())->getUsersPaginated($filterRules);

        return view('cms.users', [
            'current_nav_page'  => 'users',                         // To highlight the right page in navbar
            'users'             => $usersPage->getCollection(),
            'page_links'        => $usersPage->withQueryString()->linkCollection(),
            'current_page'      => $usersPage->currentPage(),       // Page of results(users) from DB query
            'total_pages'       => $usersPage->lastPage(),
            'query_string'      => $request->getQueryString() ?? '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cms.new_user', [
            'current_nav_page'      => 'users',
            'user_form_heading'     => __('Create new user'),
            'roles'                 => Role::all(),
            'form_action'           => route('create_user')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userData = $request->validateWithBag('users',[
            'username'      => 'required|min:4',
            'first_name'    => 'required|min:2',
            'last_name'     => 'required|min:2',
            'email'         => 'required|email',

            // regex: at least one uppercase char, one lowercase char one number and one special character, min 6 chars
            'password'      => 'required|min:6|confirmed|regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{6,}$/',
            'role'          => 'required'
        ]);


        try{
            (new User())->createUser($userData);
        }
        catch(QueryException $e){
            if ($e->errorInfo[1] === Constants::MYSQL_ER_DUP_ENTRY){
                $errBag = new MessageBag();
                $errBag->add("user", __("Username or email already taken"));
                return back()->withErrors($errBag, "users")->withInput();
            }
            else{
                return $e->getMessage();
            }
        }

        return redirect(route('users'))->with('success', __('User successfully created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('cms.edit_user', [
            'current_nav_page'      => 'users',
            'user_form_heading'     => __('Edit user'),
            'user'                  => User::find($id),
            'roles'                 => Role::all(),
            'form_action'           => route('update_user', ['id' => $id])
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $userData = $request->validateWithBag("users",[
            "username"      => "required|min:4",
            "last_name"     => "required|min:2",
            "first_name"    => "required|min:2",
            "email"         => "required|email",
            "role"          => "required"
        ]);

        if($request->post('password') !== null){
            $newPassword = $request->validateWithBag('users',[
                
                // regex: at least one uppercase char, one lowercase char one number and one special character, min 6 chars
                'password'  => 'confirmed|min:6|regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{6,}$/'
            ]);

            $userData = array_merge($userData, $newPassword);
        }

        try{
            (new User())->updateUser($id, $userData);
        }
        catch(QueryException $e){
            if ($e->errorInfo[1] === Constants::MYSQL_ER_DUP_ENTRY){
                $errBag = new MessageBag();
                $errBag->add("user", __("Username or email already taken"));
                return back()->withErrors($errBag, "users")->withInput();
            }
            else{
                return $e->getMessage();
            }
        }
        
        return redirect(route('users'))->with('success', __('User successfully edited'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try{
            (new User())->deleteUser($id);
        }
        catch(QueryException $e){
            if($e->errorInfo[1] === Constants::MYSQL_ER_ROW_IS_REFERENCED_2){
                $errBag = new MessageBag();
                $errBag->add("delete", __("Cannot delete user while he is still author of posts or pages"));
                return back()->withErrors($errBag, "users")->withInput();
            }
            else{
                return $e->getMessage();
            }
        }
        
        Session::flash('success', __('User successfully deleted'));
        return redirect(route('users') . '?' . $request->getQueryString());
    }
}
