<?php

namespace Tests\Unit\Domains\Settings\ManageCompany\Services;

use App\Domains\Settings\ManageCompany\Services\CreateCompany;
use App\Domains\Settings\ManageProfile\Services\UpdateProfileInformation;
use App\Models\Employee;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class UpdateProfileInformationTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_updates_the_information_of_the_employee(): void
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
        (new CreateCompany())->execute($request);
    }

    /** @test */
    public function it_fails_if_employee_enters_the_same_email(): void
    {
        $employee = Employee::factory()->create([
            'email' => 'michael.scott@gmail.com',
        ]);

        $this->expectException(ValidationException::class);
        $this->executeService($employee);
    }

    private function executeService(Employee $employee): void
    {
        $request = [
            'employee_id' => $employee->id,
            'first_name' => 'michael',
            'last_name' => 'scott',
            'email' => 'michael.scott@gmail.com',
        ];

        $employee = (new UpdateProfileInformation())->execute($request);

        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'first_name' => 'michael',
            'last_name' => 'scott',
            'email' => 'michael.scott@gmail.com',
        ]);

        $this->assertInstanceOf(
            Employee::class,
            $employee
        );
    }
}
