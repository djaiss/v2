<?php

namespace Tests\Unit\Models;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_belongs_to_one_company()
    {
        $role = Role::factory()->create();
        $this->assertTrue($role->company()->exists());
    }

    /** @test */
    public function it_has_many_permissions()
    {
        $permission = Permission::factory()->create();
        $role = Role::factory()->create();
        $role->permissions()->attach($role);

        $this->assertTrue($role->permissions()->exists());
    }

    /** @test */
    public function it_gets_the_custom_name_if_defined()
    {
        $role = Role::factory()->create([
            'name' => 'this is the real name',
            'translation_key' => 'life_event_category.label',
        ]);

        $this->assertEquals(
            'this is the real name',
            $role->name
        );

        $role = Role::factory()->create([
            'name' => null,
            'translation_key' => 'life_event_category.label',
        ]);

        $this->assertEquals(
            'life_event_category.label',
            $role->name
        );
    }
}
