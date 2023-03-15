<?php

namespace Tests\Unit\Domains\Settings\ManageCompany\Jobs;

use App\Domains\Settings\ManageCompany\Jobs\SetupCompany;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SetupCompanyTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_sets_a_company_up(): void
    {
        $company = Company::factory()->create();
        $employee = Employee::factory()->create();

        SetupCompany::dispatchSync($company, $employee);

        $this->assertDatabaseHas('roles', [
            'company_id' => $company->id,
            'translation_key' => 'Administrator',
        ]);
        $this->assertDatabaseHas('roles', [
            'company_id' => $company->id,
            'translation_key' => 'Employee',
        ]);

        $this->assertDatabaseHas('permissions', [
            'action' => 'company.permissions',
        ]);
    }
}
