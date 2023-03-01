<?php

namespace App\Domains\Settings\ManageSettings\Web\ViewModels;

class SettingsIndexViewModel
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $email,
    ) {
    }
}
