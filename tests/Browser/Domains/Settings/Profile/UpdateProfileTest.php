<?php

namespace Tests\Browser\Domains\Settings\Profile;

use App\Models\Employee;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UpdateProfileTest extends DuskTestCase
{
    use DatabaseTruncation;

    /** @test */
    public function it_update_the_profile_of_the_logged_employee(): void
    {
        $employee = Employee::factory()->create([
            'email' => 'regis@dumb.io',
        ]);

        $this->browse(function (Browser $browser) use ($employee) {
            $browser->loginAs($employee)
                ->visitRoute('settings.index')
                ->assertRouteIs('settings.index')
                ->assertValue('@first-name-field', '')
                ->assertValue('@last-name-field', '')
                ->assertValue('@email-field', 'regis@dumb.io')
                ->type('@first-name-field', 'Regis')
                ->type('@last-name-field', 'dumb')
                ->press('@submit-button')
                ->assertValue('@first-name-field', 'Regis')
                ->assertValue('@last-name-field', 'dumb')
                ->assertValue('@email-field', 'regis@dumb.io');
        });
    }
}
