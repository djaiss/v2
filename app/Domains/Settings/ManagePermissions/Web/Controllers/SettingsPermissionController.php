<?php

namespace App\Domains\Settings\ManagePermissions\Web\Controllers;

use App\Domains\Settings\ManagePermissions\Web\ViewHelpers\SettingsPermissionIndexViewHelper;
use App\Domains\Settings\ManageSettings\Web\ViewHelpers\SettingsIndexViewHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SettingsPermissionController extends Controller
{
    public function index(): View
    {
        $viewModel = SettingsPermissionIndexViewHelper::data(Auth::user()->company);

        return view('settings.roles.index', [
            'view' => $viewModel,
        ]);
    }

    public function show(Request $request, int $roleId): View
    {
        $viewModel = SettingsPermissionIndexViewHelper::data(Auth::user()->company);

        return view('settings.roles.index', [
            'view' => $viewModel,
        ]);
    }
}
