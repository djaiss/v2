<?php

namespace App\Domains\Settings\ManageSettings\Web\ViewModels;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SettingsIndexViewModel
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $email,
    ) {
    }
}
