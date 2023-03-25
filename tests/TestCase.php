<?php

namespace Tests;

use App\Models\Employee;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function createEmployeeWithPermission(string $permission): Employee
    {
        $role = Role::factory()->create();
        $permission = Permission::factory()->create([
            'action' => $permission,
        ]);
        $role->permissions()->attach($permission);

        return Employee::factory()->create([
            'role_id' => $role->id,
        ]);
    }
}
