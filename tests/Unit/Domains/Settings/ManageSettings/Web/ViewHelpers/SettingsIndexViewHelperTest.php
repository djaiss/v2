<?php

namespace Tests\Unit\Domains\ManageSettings\Web\ViewHelpers;

use App\Domains\Settings\ManageSettings\Web\ViewHelpers\SettingsIndexViewHelper;
use App\Domains\Settings\ManageSettings\Web\ViewModels\SettingsIndexViewModel;
use App\Models\Employee;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SettingsIndexViewHelperTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_the_data_needed_for_the_view(): void
    {
        $employee = Employee::factory()->create([
            'first_name' => 'regis',
            'last_name' => 'boudin',
            'email' => 'regis@boudin.com',
        ]);

        $viewModel = SettingsIndexViewHelper::data($employee);

        $this->assertInstanceOf(
            SettingsIndexViewModel::class,
            $viewModel
        );

        $this->assertEquals(
            'regis',
            $viewModel->firstName
        );
        $this->assertEquals(
            'boudin',
            $viewModel->lastName
        );
        $this->assertEquals(
            'regis@boudin.com',
            $viewModel->email
        );
    }
}
