<?php

namespace Tests\Browser\Domains\Settings\Roles;

use App\Models\Employee;
use App\Models\Role;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ManageRoleTest extends DuskTestCase
{
    use DatabaseTruncation;

    /** @test */
    public function it_manages_roles(): void
    {
        $employee = Employee::factory()->create([
            'email' => 'regis@dumb.io',
        ]);
        SetupOrganization::dispatch($employee->company);

        $this->browse(function (Browser $browser) use ($employee) {
            // create a role
            $browser->loginAs($employee)
                ->visitRoute('settings.roles.index')
                ->click('@open-modal-button')
                ->waitFor('@name-field')
                ->type('@name-field', 'sub employee')
                ->press('@submit-button')
                ->waitForText('sub employee')
                ->assertSee('sub employee');
        });
    }
}
