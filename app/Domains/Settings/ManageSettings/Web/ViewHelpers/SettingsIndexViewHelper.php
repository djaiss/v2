<?php

namespace App\Domains\Settings\ManageSettings\Web\ViewHelpers;

use App\Models\Employee;

class SettingsIndexViewHelper
{
    public static function data(Employee $employee): array
    {
        return [
            'firstName' => $employee->first_name,
            'lastName' => $employee->last_name,
            'email' => $employee->email,
        ];
    }
}
