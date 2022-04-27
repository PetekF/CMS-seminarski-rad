<?php

namespace App\Models;

use App\Constants;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'string',
    ];

    public function author(){
        return $this->belongsTo(User::class);
    }


    // CUSTOM METHODS ***************************************************************

    // Public API
    public function getPages(array $filterRules = []): EloquentCollection{
        return $this->getPagesQuery($filterRules)->get();
    }
    
    public function getPagesPaginated(array $filterRules = []): LengthAwarePaginator{
        return $this->getPagesQuery($filterRules)
        ->paginate(
            perPage: $filterRules['per_page'] ?? Constants::DEFAULT_ITEMS_PER_PAGE,
            page: $filterRules['page'] ?? 1
        );
    }

    public function getPageBySlug(string $slug): Page|null {
        $page = Page::where('slug', '=', $slug)
            ->where('is_published', '=', 1)
            ->first();
        
        return $page;
    }

    public function createPage($pageData): void {
        $page = new Page();

        $page->id = Str::uuid();
        $page->title = $pageData['title'];
        $page->slug = $pageData['slug'];
        $page->author_id = $pageData['author_id'];
        $page->body = $pageData['body'];
        $page->is_published = $pageData['is_published'];

        try{
            $page->save();
        }
        catch(QueryException $e){
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function updatePage($id, array $pageData = []): void {
        $page = Page::find($id);

        $page->title = $pageData['title'] ?? $page->title;
        $page->slug = $pageData['slug'] ?? $page->slug;

        if(isset($pageData['author'])){
            $author = User::select('id')->where('username', "=", $pageData['author'])->first();
            $page->author_id = $author !== null ? $author->id : null;
        }

        if(isset($pageData['body']))
            $page->body = $pageData['body'];

        $page->is_published = $pageData['is_published'] ?? $page->is_published;

        try{
            $page->update();
        }
        catch(QueryException $e){
            Log::error($e->getMessage());
            throw $e;
        }

        Log::info("Page updated {id: $id}.");
    }

    public function deletePage($id){
        try{
            Page::destroy($id);
        }
        catch(QueryException $e){
            Log::error($e->getMessage());
            throw $e;
        }

        Log::info("Page deleted {id: $id}");
    }

    public function setAsRoot($id){

        // set previous root page to null
        Page::where('is_root_page', '=', 1)
            ->update(['is_root_page' => null]);

        // set new root page to one
        Page::where('id', '=', $id)
            ->update(['is_root_page' => 1]);
    }


    // Private methods
    private function getPagesQuery(array $filterRules = []): Builder{
        $query = $this->newQuery();

        if($filterRules['title']){
            $query->where('title', 'like', '%'.$filterRules['title'].'%');
        }

        if($filterRules['author']){
            $query->join('users', 'pages.author_id', '=', 'users.id')
                ->where('users.username', 'like', '%'.$filterRules['author'].'%');
        }

        return $query;
    }
}
