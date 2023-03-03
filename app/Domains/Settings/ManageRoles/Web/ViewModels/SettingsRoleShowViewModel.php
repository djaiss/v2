<?php

namespace App\Domains\Settings\ManageRoles\Web\ViewModels;

class SettingsRoleShowViewModel
{
    public function __construct(
        public int $id,
        public string $name,
        public string $url,
    ) {
    }
}
