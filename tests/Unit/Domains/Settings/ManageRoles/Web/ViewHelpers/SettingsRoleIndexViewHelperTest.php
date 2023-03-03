<?php

namespace Tests\Unit\Domains\Settings\ManageRoles\Web\ViewHelpers;

use App\Domains\Settings\ManageRoles\Web\ViewHelpers\SettingsRoleIndexViewHelper;
use App\Domains\Settings\ManageRoles\Web\ViewModels\SettingsRoleIndexViewModel;
use App\Domains\Settings\ManageSettings\Web\ViewHelpers\SettingsIndexViewHelper;
use App\Domains\Settings\ManageSettings\Web\ViewModels\SettingsIndexViewModel;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Role;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SettingsRoleIndexViewHelperTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_the_data_needed_for_the_view(): void
    {
        $company = Company::factory()->create();
        $role = Role::factory()->create([
            'company_id' => $company->id,
        ]);

        $viewModel = SettingsRoleIndexViewHelper::data($company);

        $this->assertInstanceOf(
            SettingsRoleIndexViewModel::class,
            $viewModel
        );

        $this->assertEquals(
            [
                0 => [
                    'id' => $role->id,
                    'name' => $role->name,
                    'url' => env('APP_URL').'/settings/roles/'.$role->id,
                ],
            ],
            $viewModel->roles->toArray()
        );
    }
}
