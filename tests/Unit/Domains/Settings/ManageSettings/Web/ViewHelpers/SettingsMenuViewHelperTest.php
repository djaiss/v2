<?php

namespace Tests\Unit\Domains\Settings\ManageSettings\Web\ViewHelpers;

use App\Domains\Settings\ManageSettings\Web\ViewHelpers\SettingsMenuViewHelper;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SettingsMenuViewHelperTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_the_data_needed_for_the_view(): void
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();
        $permission = Permission::factory()->create([
            'action' => Permission::ORGANIZATION_MANAGE_PERMISSIONS,
        ]);
        $role->permissions()->syncWithoutDetaching([$permission->id => ['active' => true]]);
        $user->role_id = $role->id;
        $user->save();

        $array = SettingsMenuViewHelper::data($user);

        $this->assertTrue($array['can_see_permissions']);
        $this->assertFalse($array['can_see_offices']);
    }
}
