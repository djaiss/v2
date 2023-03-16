<?php

namespace App\Domains\Settings\ManageOffices\Web\ViewHelpers;

use App\Models\Company;
use App\Models\Office;

class SettingsOfficeIndexViewHelper
{
    public static function data(Company $company): array
    {
        $offices = $company->offices()
            ->orderBy('name')
            ->get()
            ->map(fn (Office $office) => self::dto($office));

        return [
            'offices' => $offices,
        ];
    }

    public static function dto(Office $office): array
    {
        return [
            'id' => $office->id,
            'name' => $office->name,
        ];
    }
}
