<?php

namespace App\Models;

use App\Constants;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'string',
        'email_verified_at' => 'datetime',
    ];

    public function role(){
        return $this->belongsTo(Role::class);
    }

    // CUSTOM METHODS ***************************************************************

    // Public API
    public function getUsers(array $filterRules = []): EloquentCollection{
        return $this->getUsersQuery($filterRules)->get();
    }

    public function getUsersPaginated(array $filterRules = []): LengthAwarePaginator{
        return $this->getUsersQuery($filterRules)
            ->paginate(
                perPage: $filterRules['per_page'] ?? Constants::DEFAULT_ITEMS_PER_PAGE,
                page: $filterRules['page'] ?? 1
            );
    }

    /**
     * @throws Illuminate\Database\QueryException
     */
    public function updateUser(string $id, array $userData): void {
        
        $user = User::find($id);

        $user->username = $userData['username'] ?? $user->username;
        $user->first_name = $userData['first_name'] ?? $user->first_name;
        $user->last_name = $userData['last_name'] ?? $user->last_name;
        $user->email = $userData['email'] ?? $user->email;
        $user->password = isset($userData['password']) ? Hash::make($userData['password']): $user->password;
        $user->role_id = $userData['role'] ?? $user->role_id;
        
        try{
            $user->update();  
        }
        catch(QueryException $e){
            Log::error($e->getMessage());
            throw $e;
        }

        Log::info("User updated {id: $id}");
    }

    /**
     * @throws Illuminate\Database\QueryException
     */
    public function createUser($userData): void {

        $user = new User();
        
        $user->id = Str::uuid();
        $user->username = $userData["username"];
        $user->first_name = $userData["first_name"];
        $user->last_name = $userData["last_name"];
        $user->email = $userData["email"];
        $user->password = Hash::make($userData["password"]);
        $user->role_id = $userData["role"];

        try{
          $user->save();
        }
        catch(QueryException $e){
            Log::error($e->getMessage());
            throw $e;
        }
        
        Log::info("New user created {id: $user->id, username: $user->username, email: $user->email}");
    }

    /**
     * @throws Illuminate\Database\QueryException
     */
    public function deleteUser($id): void {

        try{
            User::destroy($id);
        }
        catch(QueryException $e){
            Log::error($e->getMessage());
            throw $e;
        }

        Log::info("User deleted {id: $id}");
    }

    // Private methods
    private function getUsersQuery(array $filterRules = []): Builder{
        $query = $this->newQuery();

        if($filterRules['username']){
            $query->where('username', 'like', '%'.$filterRules['username'].'%');
        }

        if($filterRules['first_name']){
            $query->where('first_name', 'like', '%'.$filterRules['first_name'].'%');
        }

        if($filterRules['last_name']){
            $query->where('last_name', 'like', '%'.$filterRules['last_name'].'%');
        }

        if($filterRules['email']){
            $query->where('email', 'like', '%'.$filterRules['email'].'%');
        }

        return $query;
    }

    

}

