<?php

namespace Tests\Browser\Domains\Settings\Profile;

use App\Models\Employee;
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

        $this->browse(function (Browser $browser) use ($employee) {
            $browser->loginAs($employee)
                ->visitRoute('settings.roles.index')
                ->click('@open-modal-button')
                ->type('@name-field', 'sub employee')
                ->press('@submit-button')
                ->assertSee('sub employee')
                ->click('@open-modal-button');
        });
    }
}
