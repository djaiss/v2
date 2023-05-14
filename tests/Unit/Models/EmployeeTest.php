<?php

namespace Tests\Unit\Models;

use App\Models\Employee;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_belongs_to_one_organization()
    {
        $employee = Employee::factory()->create();

        $this->assertTrue($employee->organization()->exists());
    }

    /** @test */
    public function it_belongs_to_one_role()
    {
        $employee = Employee::factory()->create();

        $this->assertTrue($employee->role()->exists());
    }

    /** @test */
    public function it_checks_if_an_employee_can_do_an_action()
    {
        $employee = Employee::factory()->create();
        $role = Role::factory()->create();
        $permission = Permission::factory()->create([
            'action' => 'company.permissions',
        ]);
        $role->permissions()->syncWithoutDetaching([$permission->id => ['active' => true]]);
        $employee->role_id = $role->id;
        $employee->save();

        $this->assertTrue($employee->hasTheRightTo('company.permissions'));
    }

    /** @test */
    public function it_checks_if_an_employee_cant_do_an_action()
    {
        $employee = Employee::factory()->create();
        $role = Role::factory()->create();
        $permission = Permission::factory()->create([
            'action' => 'company.permissions',
        ]);
        $role->permissions()->syncWithoutDetaching([$permission->id => ['active' => false]]);
        $employee->role_id = $role->id;
        $employee->save();

        $this->assertFalse($employee->hasTheRightTo('company.permissions'));
    }
}
