<?php

namespace App\Domains\Settings\ManageSettings\Web\ViewHelpers;

use App\Domains\Settings\ManageSettings\Web\ViewModels\SettingsIndexViewModel;
use App\Models\Employee;

class SettingsIndexViewHelper
{
    public static function data(Employee $employee): SettingsIndexViewModel
    {
        return new SettingsIndexViewModel(
            firstName: $employee->first_name,
            lastName: $employee->last_name,
            email: $employee->email,
        );
    }
}
