<?php

namespace Tests\Unit\Domains\Settings\ManageCompany\Services;

use App\Domains\Settings\ManageOrganization\Jobs\SetupOrganization;
use App\Domains\Settings\ManageOrganization\Services\CreateOrganization;
use App\Models\Organization;
use App\Models\Employee;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CreateOrganizationTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_creates_an_organization(): void
    {
        $employee = Employee::factory()->create([
            'organization_id' => null,
        ]);
        $this->executeService($employee);
    }

    /** @test */
    public function it_fails_if_wrong_parameters_are_given(): void
    {
        $request = [
            'title' => 'Ross',
        ];

        $this->expectException(ValidationException::class);
        (new CreateOrganization())->execute($request);
    }

    /** @test */
    public function it_fails_if_employee_already_owns_a_company(): void
    {
        $employee = Employee::factory()->create([
            'organization_id' => Organization::factory(),
        ]);

        $this->expectException(Exception::class);
        $this->executeService($employee);
    }

    private function executeService(Employee $employee): void
    {
        Queue::fake();

        $request = [
            'employee_id' => $employee->id,
            'name' => 'acme',
        ];

        $organization = (new CreateOrganization())->execute($request);

        $this->assertDatabaseHas('organizations', [
            'id' => $organization->id,
            'name' => 'acme',
        ]);

        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'organization_id' => $organization->id,
        ]);

        $this->assertInstanceOf(
            Organization::class,
            $organization
        );

        Queue::assertPushed(SetupOrganization::class);
    }
}
