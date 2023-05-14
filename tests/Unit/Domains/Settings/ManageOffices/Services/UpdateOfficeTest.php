<?php

namespace Tests\Unit\Domains\Settings\ManageOffices\Services;

use App\Domains\Settings\ManageOffices\Services\UpdateOffice;
use App\Exceptions\NotEnoughPermissionException;
use App\Models\Employee;
use App\Models\Office;
use App\Models\Permission;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class UpdateOfficeTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_updates_an_office(): void
    {
        $employee = $this->createEmployeeWithPermission(Permission::COMPANY_MANAGE_OFFICES);
        $office = Office::factory()->create([
            'organization_id' => $employee->organization_id,
        ]);
        $this->executeService($employee, $office);
    }

    /** @test */
    public function it_fails_if_wrong_parameters_are_given(): void
    {
        $request = [
            'title' => 'Ross',
        ];

        $this->expectException(ValidationException::class);
        (new UpdateOffice())->execute($request);
    }

    /** @test */
    public function it_cant_execute_the_service_with_the_wrong_permissions(): void
    {
        $employee = Employee::factory()->create();
        $office = Office::factory()->create();

        $this->expectException(NotEnoughPermissionException::class);
        $this->executeService($employee, $office);
    }

    /** @test */
    public function it_fails_if_office_doesnt_belong_to_company(): void
    {
        $employee = $this->createEmployeeWithPermission(Permission::COMPANY_MANAGE_OFFICES);
        $office = Office::factory()->create();

        $this->expectException(ModelNotFoundException::class);
        $this->executeService($employee, $office);
    }

    private function executeService(Employee $employee, Office $office): void
    {
        $request = [
            'author_id' => $employee->id,
            'office_id' => $office->id,
            'name' => 'Dunder',
            'is_main_office' => true,
        ];

        $office = (new UpdateOffice())->execute($request);

        $this->assertInstanceOf(
            Office::class,
            $office
        );

        $this->assertDatabaseHas('offices', [
            'id' => $office->id,
            'name' => 'Dunder',
            'is_main_office' => true,
        ]);
    }
}
