<?php

namespace App\Domains\Settings\ManagePermissions\Web\ViewModels;

use Illuminate\Support\Collection;

class SettingsPermissionIndexViewModel
{
    public function __construct(
        public ?Collection $roles,
    ) {
    }
}
