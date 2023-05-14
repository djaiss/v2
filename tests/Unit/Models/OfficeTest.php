<?php

namespace Tests\Unit\Models;

use App\Models\Employee;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class OfficeTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_belongs_to_one_organization()
    {
        $employee = Employee::factory()->create();

        $this->assertTrue($employee->organization()->exists());
    }
}
