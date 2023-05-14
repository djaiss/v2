<?php

namespace App\Domains\Settings\ManageSettings\Web\ViewHelpers;

use App\Models\Permission;
use App\Models\User;

class SettingsMenuViewHelper
{
    public static function data(User $user): array
    {
        return [
            'can_see_permissions' => $user->hasTheRightTo(Permission::ORGANIZATION_MANAGE_PERMISSIONS),
            'can_see_offices' => $user->hasTheRightTo(Permission::ORGANIZATION_MANAGE_OFFICES),
        ];
    }
}
