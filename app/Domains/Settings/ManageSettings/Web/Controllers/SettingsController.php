<?php

namespace App\Domains\Settings\ManageSettings\Web\Controllers;

use App\Domains\Settings\ManageSettings\Web\ViewHelpers\SettingsIndexViewHelper;
use App\Domains\Settings\ManageSettings\Web\ViewModels\SettingsIndexViewModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        $viewModel = SettingsIndexViewHelper::data(Auth::user());

        return view('settings.index', [
            'view' => $viewModel,
        ]);
    }
}
