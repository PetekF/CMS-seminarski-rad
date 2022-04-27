<?php

namespace App\Http\Controllers;

use App\Models\Navigation;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class NavigationController extends Controller
{
    public function index(){



        return view('cms.navigation', [
            'current_nav_page'  => 'navigation',
            'navigation'        => Navigation::all()
        ]);
    }

    public function create(){
        return view('cms.new_navigation_item', [
            'current_nav_page' => 'navigation'
        ]);
    }

    public function store(Request $request){

        $navigationData = $request->validateWithBag('navigation', [
            'href'  => 'required',
            'name'  => 'required'
        ]);

        (new Navigation())->createNavigationItem($navigationData);

        return redirect(route('navigation'))->with('success', __('Navigation item successfully created'));

    }

    public function update(Request $request, $id){

        $navigationData = $request->validateWithBag('navigation', [
            'name'  => 'required',
            'href'  =>  'required'
        ]);

        (new Navigation())->updateNavigation($id, $navigationData);

        return redirect(route('navigation'))->with('success', __('Navigation item successfully edited'));

        
    }

    public function destroy($id){

        (new Navigation())->deleteNavigationItem($id);

        Session::flash('success', __('NAvigation link successfully deleted'));
        return redirect(route('navigation'));
    }
}
