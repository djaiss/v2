<?php

namespace Tests\Unit\Models;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_belongs_to_one_organization()
    {
        $user = User::factory()->create();

        $this->assertTrue($user->organization()->exists());
    }

    /** @test */
    public function it_belongs_to_one_role()
    {
        $user = User::factory()->create();

        $this->assertTrue($user->role()->exists());
    }

    /** @test */
    public function it_checks_if_a_user_can_do_an_action()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();
        $permission = Permission::factory()->create([
            'action' => 'organization.permissions',
        ]);
        $role->permissions()->syncWithoutDetaching([$permission->id => ['active' => true]]);
        $user->role_id = $role->id;
        $user->save();

        $this->assertTrue($user->hasTheRightTo('organization.permissions'));
    }

    /** @test */
    public function it_checks_if_a_user_cant_do_an_action()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();
        $permission = Permission::factory()->create([
            'action' => 'organization.permissions',
        ]);
        $role->permissions()->syncWithoutDetaching([$permission->id => ['active' => false]]);
        $user->role_id = $role->id;
        $user->save();

        $this->assertFalse($user->hasTheRightTo('organization.permissions'));
    }
}
