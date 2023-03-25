<?php

namespace App\Domains\Settings\ManageSettings\Web\ViewHelpers;

use App\Models\Employee;
use App\Models\Permission;

class SettingsMenuViewHelper
{
    public static function data(Employee $employee): array
    {
        return [
            'can_see_permissions' => $employee->hasTheRightTo(Permission::COMPANY_MANAGE_PERMISSIONS),
            'can_see_offices' => $employee->hasTheRightTo(Permission::COMPANY_MANAGE_OFFICES),
        ];
    }
}
