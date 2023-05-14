<?php

namespace Tests\Unit\Domains\Settings\ManageRoles\Services;

use App\Domains\Settings\ManageRoles\Services\CreateRole;
use App\Exceptions\NotEnoughPermissionException;
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
        $employee = $this->createEmployeeWithPermission(Permission::COMPANY_MANAGE_PERMISSIONS);
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

    /** @test */
    public function it_cant_execute_the_service_with_the_wrong_permissions(): void
    {
        $employee = Employee::factory()->create();

        $this->expectException(NotEnoughPermissionException::class);
        $this->executeService($employee);
    }

    private function executeService(Employee $employee): void
    {
        $permission = Permission::factory()->create();

        $request = [
            'author_id' => $employee->id,
            'label' => 'Dunder',
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
            'label' => 'Dunder',
        ]);

        $this->assertDatabaseHas('permission_role', [
            'permission_id' => $permission->id,
            'role_id' => $role->id,
        ]);
    }
}
