<?php

namespace Tests\Unit\Domains\Settings\ManageCompany\Services;

use App\Domains\Settings\ManageCompany\Services\CreateCompany;
use App\Models\Company;
use App\Models\Employee;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CreateCompanyTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_creates_a_company(): void
    {
        $employee = Employee::factory()->create([
            'company_id' => null,
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
        (new CreateCompany())->execute($request);
    }

    /** @test */
    public function it_fails_if_employee_already_owns_a_company(): void
    {
        $employee = Employee::factory()->create([
            'company_id' => Company::factory(),
        ]);

        $this->expectException(Exception::class);
        $this->executeService($employee);
    }

    private function executeService(Employee $employee): void
    {
        $request = [
            'employee_id' => $employee->id,
            'name' => 'acme',
        ];

        $company = (new CreateCompany())->execute($request);

        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'name' => 'acme',
        ]);

        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'company_id' => $company->id,
        ]);

        $this->assertInstanceOf(
            Company::class,
            $company
        );
    }
}
