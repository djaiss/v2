<?php

namespace App\Domains\Settings\ManageRoles\Web\ViewModels;

use Illuminate\Support\Collection;

class SettingsRoleIndexViewModel
{
    public function __construct(
        public ?Collection $roles,
    ) {
    }
}
