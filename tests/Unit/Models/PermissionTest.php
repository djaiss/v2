<?php

namespace Tests\Unit\Models;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_has_many_roles()
    {
        $permission = Permission::factory()->create();
        $role = Role::factory()->create();
        $permission->roles()->sync($role);

        $this->assertTrue($permission->roles()->exists());
    }

    /** @test */
    public function it_gets_the_name()
    {
        $permission = Permission::factory()->create([
            'translation_key' => 'life_event_category.label',
        ]);

        $this->assertEquals(
            'life_event_category.label',
            $permission->name
        );
    }
}
