<?php

namespace Tests\Unit\Domains\Settings\ManageRoles\Services;

use App\Domains\Settings\ManageRoles\Services\CreateRole;
use App\Models\Employee;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CreateRoleTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_creates_a_role(): void
    {
        $employee = Employee::factory()->create();
        $this->executeService($employee);
    }

    /** @test */
    public function it_fails_if_wrong_parameters_are_given(): void
    {
        $request = [
            'title' => 'Ross',
        ];

        $this->expectException(ValidationException::class);
        (new CreateRole())->execute($request);
    }

    private function executeService(Employee $employee): void
    {
        $permission = Permission::factory()->create();

        $request = [
            'employee_id' => $employee->id,
            'name' => 'Dunder',
            'permissions' => [
                0 => [
                    'id' => $permission->id,
                    'active' => true,
                ],
            ],
        ];

        $role = (new CreateRole())->execute($request);

        $this->assertInstanceOf(
            Role::class,
            $role
        );

        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'name' => 'Dunder',
        ]);

        $this->assertDatabaseHas('permission_role', [
            'permission_id' => $permission->id,
            'role_id' => $role->id,
            'company_id' => $role->company_id,
        ]);
    }
}
