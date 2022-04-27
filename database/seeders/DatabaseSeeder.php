<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use \Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $adminId = Str::uuid();
        $authorOneId = Str::uuid();
        $authorTwoId = Str::uuid();
        $authorThreeId = Str::uuid();
        
        $adminRoleId = Str::uuid();
        $authorRoleId = Str::uuid();
        

        DB::table('roles')->insert([
            'id'    => $adminRoleId,
            'name'  => 'administrator'
        ]);

        DB::table('roles')->insert([
            'id'    => $authorRoleId,
            'name'  => 'author'
        ]);


        DB::table('users')->insert([
            'id'                => $adminId,
            'username'          => 'admin',
            'first_name'        => 'Filip',
            'last_name'         => 'Petek',
            'email'             => 'petekf@outlook.com',
            'password'          => Hash::make('admin'),
            'role_id'           => $adminRoleId,
            'remember_token'    => null,
            'login_attempts'    => 0,
            'created_at'        => now(),
            'updated_at'        => now(),
            'email_verified_at' => null
        ]);

        \App\Models\User::factory()
            ->count(3)
            ->state(new Sequence(
                ['id' => $authorOneId],
                ['id' => $authorTwoId],
                ['id' => $authorThreeId]
            ))
            ->create(['role_id' => $authorRoleId]);

        \App\Models\Page::factory()->count(1)->create(['author_id' => $adminId]);

        \App\Models\Page::factory()->count(2)->create(['author_id' => $authorOneId]);

        \App\Models\Page::factory()->count(1)->create(['author_id' => $authorTwoId]);

    }
}
