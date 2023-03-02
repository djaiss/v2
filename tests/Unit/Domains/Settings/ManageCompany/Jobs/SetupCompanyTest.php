<?php

namespace Tests\Unit\Domains\Settings\ManageCompany\Jobs;

use App\Domains\Settings\ManageCompany\Jobs\SetupCompany;
use App\Models\Company;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SetupCompanyTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_sets_a_company_up(): void
    {
        $company = Company::factory()->create();

        SetupCompany::dispatchSync($company);

        $this->assertDatabaseHas('roles', [
            'company_id' => $company->id,
            'translation_key' => 'Administrator',
        ]);
        $this->assertDatabaseHas('roles', [
            'company_id' => $company->id,
            'translation_key' => 'Employee',
        ]);
    }
}
