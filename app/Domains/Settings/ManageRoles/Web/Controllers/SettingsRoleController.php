<?php

namespace App\Domains\Settings\ManageRoles\Web\Controllers;

use App\Domains\Settings\ManageRoles\Web\ViewHelpers\SettingsRoleIndexViewHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsRoleController extends Controller
{
    public function index(): View
    {
        $viewModel = SettingsRoleIndexViewHelper::data(auth()->user()->company);

        return view('settings.roles.index', [
            'view' => $viewModel,
        ]);
    }

    public function show(Request $request, int $roleId): View
    {
        $viewModel = SettingsRoleIndexViewHelper::data(auth()->user()->company);

        return view('settings.roles.index', [
            'view' => $viewModel,
        ]);
    }
}
