<?php

namespace Tests\Unit\Domains\Settings\ManageOffices\Services;

use App\Domains\Settings\ManageOffices\Services\CreateOffice;
use App\Exceptions\NotEnoughPermissionException;
use App\Models\Employee;
use App\Models\Office;
use App\Models\Permission;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CreateOfficeTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_creates_an_office(): void
    {
        $employee = $this->createEmployeeWithPermission(Permission::COMPANY_MANAGE_OFFICES);
        $this->executeService($employee);
    }

    /** @test */
    public function it_cant_execute_the_service_with_the_wrong_permissions(): void
    {
        $employee = Employee::factory()->create();

        $this->expectException(NotEnoughPermissionException::class);
        $this->executeService($employee);
    }

    /** @test */
    public function it_fails_if_wrong_parameters_are_given(): void
    {
        $request = [
            'title' => 'Ross',
        ];

        $this->expectException(ValidationException::class);
        (new CreateOffice())->execute($request);
    }

    private function executeService(Employee $employee): void
    {
        $request = [
            'author_id' => $employee->id,
            'name' => 'Dunder',
        ];

        $office = (new CreateOffice())->execute($request);

        $this->assertInstanceOf(
            Office::class,
            $office
        );

        $this->assertDatabaseHas('offices', [
            'id' => $office->id,
            'name' => 'Dunder',
        ]);
    }
}
