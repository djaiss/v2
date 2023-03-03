<?php

namespace App\Domains\Settings\ManageRoles\Web\ViewModels;

use Illuminate\Support\Collection;

class SettingsRoleShowViewModel
{
    public function __construct(
        public int $id,
        public string $name,
        public string $url,
    ) {
    }
}
