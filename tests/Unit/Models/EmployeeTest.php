<?php

namespace Tests\Unit\Models;

use App\Models\Emotion;
use App\Models\Employee;
use App\Models\Note;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_belongs_to_one_company()
    {
        $employee = Employee::factory()->create();

        $this->assertTrue($employee->company()->exists());
    }
}
