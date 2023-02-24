<?php

namespace Tests\Unit\Domains\Auth\Services;

use App\Domains\Auth\Services\CreateAccount;
use App\Models\Employee;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CreateAccountTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_creates_an_account(): void
    {
        $this->executeService();
    }

    /** @test */
    public function it_fails_if_wrong_parameters_are_given(): void
    {
        $request = [
            'title' => 'Ross',
        ];

        $this->expectException(ValidationException::class);
        (new CreateAccount())->execute($request);
    }

    private function executeService(): void
    {
        Event::fake();

        $request = [
            'email' => 'john@email.com',
            'password' => 'johnny',
        ];

        $employee = (new CreateAccount())->execute($request);

        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'email' => 'john@email.com',
        ]);

        $this->assertInstanceOf(
            Employee::class,
            $employee
        );

        Event::assertDispatched(Registered::class);
    }
}
