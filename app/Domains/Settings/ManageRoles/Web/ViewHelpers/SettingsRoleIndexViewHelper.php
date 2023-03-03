<?php

namespace App\Domains\Settings\ManageRoles\Web\ViewHelpers;

use App\Domains\Settings\ManageRoles\Web\ViewModels\SettingsRoleIndexViewModel;
use App\Domains\Settings\ManageRoles\Web\ViewModels\SettingsRoleShowViewModel;
use App\Models\Company;
use App\Models\Role;

class SettingsRoleIndexViewHelper
{
    public static function data(Company $company): SettingsRoleIndexViewModel
    {
        $roles = $company->roles()->get()
            ->map(fn (Role $role) => new SettingsRoleShowViewModel(
                id: $role->id,
                name: $role->name,
                url: route('settings.roles.show', $role->id),
            ));

        return new SettingsRoleIndexViewModel(
            roles: $roles,
        );
    }
}
