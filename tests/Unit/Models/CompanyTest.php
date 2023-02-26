<?php

namespace Tests\Unit\Models;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_has_many_employees()
    {
        $company = Company::factory()->create();
        Employee::factory()->create(['company_id' => $company->id]);

        $this->assertTrue($company->employees()->exists());
    }
}
