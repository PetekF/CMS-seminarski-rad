<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase as DefaultTestCase;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    
    public function test_user_class_has_property_fillable()
    {
        $this->assertClassHasAttribute("fillable", User::class);
    }
    
    public function test_user_filip_petek_exists(){
        $user = User::where("name", "Filip Petek")->first();
        
        $this->assertNotNull($user);
        $this->assertNotNull($user->name);
        $this->assertSame("Filip Petek", $user->name);
    }
}
