<?php

namespace App\Domains\Settings\ManageSettings\Web\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        return view('settings.index');
    }
}
