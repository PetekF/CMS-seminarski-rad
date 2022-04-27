<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\Role;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filterRules = [];

        $filterRules['name']         = $request->query('name') ?? null;
        $filterRules['per_page']     = $request->query('per_page') !== null ? (int)$request->query('per_page') : Constants::DEFAULT_ITEMS_PER_PAGE;
        $filterRules['page']         = $request->query('page') !== null ? (int) (int)$request->query('page') : 1;


        $rolesPage = (new Role())->getRolesPaginated($filterRules);

        return view('cms.roles', [
            'current_nav_page'  => 'roles',
            'roles'             => $rolesPage->getCollection(),
            'page_links'        => $rolesPage->withQueryString()->linkCollection(),
            'current_page'      => $rolesPage->currentPage(),       // Page of results(roles) from DB query
            'total_pages'       => $rolesPage->lastPage(),
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
        return view('cms.new_role', [
            'current_nav_page'      => 'roles',
            'role_form_heading'     => __('Create new role'),
            'form_action'           => route('create_role')
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
        $roleData = $request->validateWithBag('roles',[
            'name'      => 'required',
        ]);


        try{
            (new Role())->createRole($roleData);
        }
        catch(QueryException $e){

            if ($e->errorInfo[1] === Constants::MYSQL_ER_DUP_ENTRY){
                $errBag = new MessageBag();
                $errBag->add("duplicate_name", __("Name already taken"));

                return back()->withErrors($errBag, "roles")->withInput();
            }
            else{
                return $e->getMessage();
            }
        }

        return redirect(route('roles'))->with('success', __('Role successfully created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('cms.edit_role', [
            'current_nav_page'      => 'roles',
            'role_form_heading'     => __('Edit role'),
            'role'                  => Role::find($id),
            'roles'                 => Role::all(),
            'form_action'           => route('update_role', ['id' => $id])
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
        
        $roleData = $request->validateWithBag("roles", [
            "name"      => "required",
        ]);

        try{
            (new Role())->updateRole($id, $roleData);
        }
        catch(QueryException $e){

            if ($e->errorInfo[1] === Constants::MYSQL_ER_DUP_ENTRY){
                $errBag = new MessageBag();
                $errBag->add("duplicate_name", __("Name already taken"));

                return back()->withErrors($errBag, "roles")->withInput();
            }
            else{
                return $e->getMessage();
            }
        }

        return redirect(route('roles'))->with('success', __('Role successfully edited'));
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
          (new Role())->deleteRole($id);
        }
        catch(QueryException $e){
            Log::error($e->getMessage());
            if($e->errorInfo[1] === Constants::MYSQL_ER_ROW_IS_REFERENCED_2){
                $errBag = new MessageBag();
                $errBag->add("delete", __("Cannot delete role while there are still users who have that role"));

                return back()->withErrors($errBag, "roles")->withInput();
                // return "Cannot delete role while there are still users who have that role.";
            }
            else{
                return $e->getMessage();
            }
        }

        Session::flash('success', __('Role successfully deleted'));
        return redirect(route('roles') . '?' . $request->getQueryString());
    }
}
