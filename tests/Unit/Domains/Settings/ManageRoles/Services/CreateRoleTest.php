<?php

namespace Tests\Unit\Domains\Settings\ManageRoles\Services;

use App\Domains\Settings\ManageRoles\Services\CreateRole;
use App\Models\Employee;
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
        $request = [
            'employee_id' => $employee->id,
            'name' => 'Dunder',
        ];

        $role = (new CreateRole())->execute($request);

        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'name' => 'Dunder',
        ]);

        $this->assertInstanceOf(
            Role::class,
            $role
        );
    }
}
