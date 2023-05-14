<?php

namespace Tests;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function createUserWithPermission(string $permission): User
    {
        $role = Role::factory()->create();
        $permission = Permission::factory()->create([
            'action' => $permission,
        ]);
        $role->permissions()->attach($permission);

        return User::factory()->create([
            'role_id' => $role->id,
        ]);
    }
}
