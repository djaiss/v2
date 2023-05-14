<?php

namespace Tests\Unit\Models;

use App\Models\Organization;
use App\Models\Permission;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_belongs_to_many_organizations(): void
    {
        $user = User::factory()->create();
        $organization = Organization::factory()->create();
        $user->organizations()->attach($organization);

        $this->assertTrue($user->organizations()->exists());
    }

    /** @test */
    public function it_has_many_projects(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();

        $project->projectable_id = $user->id;
        $project->projectable_type = User::class;
        $project->save();

        $this->assertTrue($user->projects()->exists());
    }

    /** @test */
    // public function it_checks_if_a_user_can_do_an_action()
    // {
    //     $user = User::factory()->create();
    //     $role = Role::factory()->create();
    //     $permission = Permission::factory()->create([
    //         'action' => 'organization.permissions',
    //     ]);
    //     $role->permissions()->syncWithoutDetaching([$permission->id => ['active' => true]]);
    //     $user->role_id = $role->id;
    //     $user->save();

    //     $this->assertTrue($user->hasTheRightTo('organization.permissions'));
    // }

    // /** @test */
    // public function it_checks_if_a_user_cant_do_an_action()
    // {
    //     $user = User::factory()->create();
    //     $role = Role::factory()->create();
    //     $permission = Permission::factory()->create([
    //         'action' => 'organization.permissions',
    //     ]);
    //     $role->permissions()->syncWithoutDetaching([$permission->id => ['active' => false]]);
    //     $user->role_id = $role->id;
    //     $user->save();

    //     $this->assertFalse($user->hasTheRightTo('organization.permissions'));
    // }
}
