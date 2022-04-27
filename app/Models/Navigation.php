<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class Navigation extends Model
{
    use HasFactory;

    public $table = "navigation";

    protected $casts = [
        'id' => 'string',
    ];

    public function deleteNavigationItem($id): void{
        try{
            Navigation::destroy($id);
        }
        catch(QueryException $e){
            Log::error($e->getMessage());
            throw $e;
        }

        Log::info("Navigation item deleted {id: $id}.");

    }

    public function createNavigationItem($navigationData = []): void{
        $nav = new Navigation();

        $nav->id    = Str::uuid();
        $nav->href  = $navigationData['href'];
        $nav->name  = $navigationData['name'];

        $nav->save();

    }

    public function updateNavigation($id, $navigationData = []):void {
        $nav = Navigation::find($id);

        $nav->href = $navigationData['href'] ?? $nav->href;
        $nav->name = $navigationData['name'] ?? $nav->name;

        $nav->update();

        Log::info("Navigation item updated {id: $id}.");
    }
}
