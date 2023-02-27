<?php

namespace Tests\Browser\Domains\Auth;

use App\Models\Employee;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateCompanyTest extends DuskTestCase
{
    use DatabaseTruncation;

    /** @test */
    public function it_redirects_to_the_welcome_page_if_employee_doesnt_belong_to_a_company(): void
    {
        $employee = Employee::factory()->create([
            'company_id' => null,
        ]);

        $this->browse(function (Browser $browser) use ($employee) {
            $browser->loginAs($employee)
                    ->visitRoute('home.index')
                    ->assertRouteIs('welcome.index')
                    ->click('@link-create-company')
                    ->assertRouteIs('create_company.index')
                    ->type('@company-name-field', 'My company')
                    ->press('@submit-button')
                    ->assertRouteIs('home.index');
        });
    }

    /** @test */
    public function it_redirects_to_the_home_page_if_employee_belongs_to_a_company(): void
    {
        $employee = Employee::factory()->create();

        $this->browse(function (Browser $browser) use ($employee) {
            $browser->loginAs($employee)
                    ->visitRoute('home.index')
                    ->assertRouteIs('home.index');
        });
    }

    /** @test */
    public function it_makes_sure_we_cant_reach_the_welcome_page_if_the_company_already_exists(): void
    {
        $employee = Employee::factory()->create();

        $this->browse(function (Browser $browser) use ($employee) {
            $browser->loginAs($employee)
                ->visitRoute('welcome.index')
                ->assertRouteIs('home.index')
                ->visitRoute('create_company.index')
                ->assertRouteIs('home.index');
        });
    }
}
