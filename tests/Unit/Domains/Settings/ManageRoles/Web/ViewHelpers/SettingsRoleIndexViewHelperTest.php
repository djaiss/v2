<?php

namespace Tests\Unit\Domains\Settings\ManageRoles\Web\ViewHelpers;

use App\Domains\Settings\ManageRoles\Web\ViewHelpers\SettingsRoleIndexViewHelper;
use App\Models\Company;
use App\Models\Permission;
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

        $viewModel = SettingsRoleIndexViewHelper::data($company);

        $this->assertArrayHasKey('roles', $viewModel);
        $this->assertArrayHasKey('permissions', $viewModel);
    }

    /** @test */
    public function it_gets_the_data_needed_for_the_role(): void
    {
        $role = Role::factory()->create([
            'name' => 'janitor',
        ]);

        $array = SettingsRoleIndexViewHelper::role($role);

        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('name', $array);
        $this->assertArrayHasKey('permissions', $array);
        $this->assertArrayHasKey('url', $array);

        $this->assertEquals(
            $role->id,
            $array['id']
        );
        $this->assertEquals(
            'janitor',
            $array['name']
        );
        $this->assertEquals(
            env('APP_URL').'/settings/roles/'.$role->id,
            $array['url']
        );
    }

    /** @test */
    public function it_gets_the_data_needed_for_the_permission(): void
    {
        $permission = Permission::factory()->create([
            'translation_key' => 'janitor',
        ]);

        $array = SettingsRoleIndexViewHelper::permission($permission);

        $this->assertEquals(
            [
                'id' => $permission->id,
                'name' => 'janitor',
                'active' => true,
            ],
            $array
        );
    }
}
