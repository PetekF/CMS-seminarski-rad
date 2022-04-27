<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\Navigation;
use App\Models\Page;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filterRules = [];

        $filterRules['title']   = $request->query('title') ?? null;

        // This will be author (user)name but in DB there is author id in corresponding field
        $filterRules['author']  = $request->query('author') ?? null;
        $filterRules['per_page']        = $request->query('per_page') !== null ? (int)$request->query('per_page') : Constants::DEFAULT_ITEMS_PER_PAGE;
        $filterRules['page']            = $request->query('page') !== null ? (int) (int)$request->query('page') : 1;


        $pagesPage = (new Page())->getPagesPaginated($filterRules);

        return view('cms.pages', [
            'current_nav_page'  => 'pages',
            'pages'             => $pagesPage->getCollection(),
            'page_links'        => $pagesPage->withQueryString()->linkCollection(),
            'current_page'      => $pagesPage->currentPage(),       // Page of results(pages) from DB query
            'total_pages'       => $pagesPage->lastPage(),
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
        return view('cms.new_page', [
            'current_nav_page'  => 'pages',
            'page_form_heading' => __('Create new page'),
            'form_action'       => route('create_page')
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
        $pageData = $request->input();

        $request->validateWithBag('pages', [
            'title' => 'required',
            'slug'  => 'required',
        ]);

        $pageData['author_id'] = Auth::user()->id;
        $pageData['is_published'] = $pageData['is_published'] ?? 0;


        try{
            (new Page())->createPage($pageData);
        }
        catch(QueryException $e){
            if ($e->errorInfo[1] === Constants::MYSQL_ER_DUP_ENTRY){
                $errBag = new MessageBag();
                $errBag->add("taken", __("Title or slug already taken"));
                return back()->withErrors($errBag, "pages")->withInput();
            }
            else{
                return $e->getMessage();
            }
        }
     
        return redirect(route('pages'))->with('success', __('Page successfully created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $page = Page::where('slug', '=', $slug)->first();
        $page = (new Page())->getPageBySlug($slug);

        if($page === null) abort(404);

        return view('themes.default.static_page', [
            'navigation_items' => Navigation::all(),
            'page' => $page
        ]);
    }

    /**
     * 
     */
    public function rootPage(){
        $page = Page::where('is_root_page', '=', 1)
            ->where('is_published', '=', 1)
            ->first();

        if($page !== null){
          return view('themes.default.static_page', [
            'navigation_items' => Navigation::all(),
            'page' => $page
            ]);  
        }
        else{
            abort('404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('cms.edit_page', [
            'current_nav_page'  => 'pages',
            'page_form_heading' => __('Edit page'),
            'page'              => Page::find($id),
            'form_action'       => route('update_page', ['id' => $id])
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = null)
    {
        $pageData = $request->input();
        
        // If request is send throught page edit form then input has to be validated.
        // If request is sent throught publish action (in pages table) then there is
        // no need for validation.
        if ($request->query('publish_action', "0") === "0"){
            $request->validateWithBag("pages", [
                'title' => 'required',
                'slug'  => 'required'
            ]);

        }
        else{
            $pageData['is_published'] = $request->post('is_published');
        }

        $pageData['is_published'] = $pageData['is_published'] ?? 0;

        try{
            (new Page())->updatePage($id, $pageData);
        }
        catch(QueryException $e){
            if ($e->errorInfo[1] === Constants::MYSQL_ER_DUP_ENTRY){
                $errBag = new MessageBag();
                $errBag->add("taken", __("Title or slug already taken"));
                return back()->withErrors($errBag, "pages")->withInput();
            }
            else{
                return $e->getMessage();
            }
        }
        
        return redirect(route('pages') . '?' . $request->getQueryString())->with('success', __('Page successfully edited'));
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
            (new Page())->deletePage($id);
        }
        catch(QueryException $e){
            if($e->errorInfo[1] === Constants::MYSQL_ER_ROW_IS_REFERENCED_2){
                $errBag = new MessageBag();
                $errBag->add("delete", __("Cannot delete page"));
                return back()->withErrors($errBag, "page")->withInput();
            }
            else{
                return $e->getMessage();
            }
        }

        Session::flash('success', __('Page successfully deleted'));
        return redirect(route('pages') . '?' . $request->getQueryString());
    }

    public function setAsRoot(Request $request){

        $id = $request->input('root-page-id');

        try{
            (new Page())->setAsRoot($id);
        }
        catch(QueryException $e){
            return $e->getMessage();
        }

        return redirect(route('pages') . '?' . $request->getQueryString())->with('success', __('Root page changed'));
    }
}
