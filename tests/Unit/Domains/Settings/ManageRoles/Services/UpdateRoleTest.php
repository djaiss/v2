<?php

namespace Tests\Unit\Domains\Settings\ManageRoles\Services;

use App\Domains\Settings\ManageRoles\Services\UpdateRole;
use App\Exceptions\NotEnoughPermissionException;
use App\Models\Employee;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class UpdateRoleTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_updates_a_role(): void
    {
        $employee = $this->createEmployeeWithPermission(Permission::COMPANY_MANAGE_PERMISSIONS);
        $role = Role::factory()->create([
            'organization_id' => $employee->organization_id,
        ]);
        $this->executeService($employee, $role);
    }

    /** @test */
    public function it_fails_if_wrong_parameters_are_given(): void
    {
        $request = [
            'title' => 'Ross',
        ];

        $this->expectException(ValidationException::class);
        (new UpdateRole())->execute($request);
    }

    /** @test */
    public function it_cant_execute_the_service_with_the_wrong_permissions(): void
    {
        $employee = Employee::factory()->create();
        $role = Role::factory()->create([
            'organization_id' => $employee->organization_id,
        ]);

        $this->expectException(NotEnoughPermissionException::class);
        $this->executeService($employee, $role);
    }

    /** @test */
    public function it_fails_if_role_doesnt_belong_to_company(): void
    {
        $employee = $this->createEmployeeWithPermission(Permission::COMPANY_MANAGE_PERMISSIONS);
        $role = Role::factory()->create();

        $this->expectException(ModelNotFoundException::class);
        $this->executeService($employee, $role);
    }

    private function executeService(Employee $employee, Role $role): void
    {
        $permission = Permission::factory()->create();

        $request = [
            'author_id' => $employee->id,
            'role_id' => $role->id,
            'label' => 'Dunder',
            'permissions' => [
                0 => [
                    'id' => $permission->id,
                    'active' => true,
                ],
            ],
        ];

        $role = (new UpdateRole())->execute($request);

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
