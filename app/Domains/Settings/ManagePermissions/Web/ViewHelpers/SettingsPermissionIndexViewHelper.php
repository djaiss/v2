<?php

namespace App\Domains\Settings\ManagePermissions\Web\ViewHelpers;

use App\Domains\Settings\ManagePermissions\Web\ViewModels\SettingsPermissionIndexViewModel;
use App\Models\Company;
use App\Models\Role;

class SettingsPermissionIndexViewHelper
{
    public static function data(Company $company): SettingsPermissionIndexViewModel
    {
        $roles = $company->roles()->get()
            ->map(fn (Role $role) => [
                'id' => $role->id,
                'name' => $role->name,
                'url' => route('settings.roles.show', $role->id),
            ]);

        return new SettingsPermissionIndexViewModel(
            roles: $roles,
        );
    }
}
