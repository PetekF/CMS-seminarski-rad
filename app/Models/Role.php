<?php

namespace App\Models;

use App\Constants;
use Illuminate\Database\Console\DumpCommand;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class Role extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $casts = [
        'id' => 'string'
    ];

    public function users(){
        return $this->belongsToMany(User::class);
    }
    
    // CUSTOM METHODS *****************************************************

    // Public API

    public function getRoles(array $filterRules = []): EloquentCollection {
        return $this->getRolesQuery($filterRules)->get();
    } 

    public function getRolesPaginated(array $filterRules = []): LengthAwarePaginator {
        return $this->getRolesQuery($filterRules)
            ->paginate(
                perPage: $filterRules['per_page'] ?? Constants::DEFAULT_ITEMS_PER_PAGE,
                page: $filterRules['page'] ?? 1
            );
    }

    /**
     * @throws Illuminate\Database\QueryException
     */
    public function createRole($roleData): void {
        $role = new Role();

        $role->id = Str::uuid();
        $role->name = $roleData['name'];
        
        try{
            $role->save();
          }
        catch(QueryException $e){
            Log::error($e->getMessage());
            throw $e;
        }

        Log::info("New role created {id: $role->id, name: $role->name}");
    }

    /**
     * @throws Illuminate\Database\QueryException
     */
    public function updateRole(string $id, array $roleData): void{

        $role = Role::find($id);
        $role->name = $roleData['name'];

        try{
            $role->update();
        }
        catch(QueryException $e){
            Log::error($e->getMessage());
            throw $e;
        }

        Log::info("Role edited {id: $id}");

    }

    /**
     * @throws Illuminate\Database\QueryException
     */
    public function deleteRole($id): void {

        try{
            Role::destroy($id);
        }
        catch(QueryException $e){
            Log::error($e->getMessage());
            throw $e;
        }
        
        Log::info("User deleted { id: $id }");
    }

    // Private methods
    private function getRolesQuery($filterRules = []): Builder {
        $query = $this->newQuery();

        if($filterRules['name']){
            $query->where('name', 'like', '%'.$filterRules['name'].'%');
        }

        return $query;
    }
}
