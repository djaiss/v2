<?php

namespace App\Domains\Settings\ManageSettings\Web\Controllers;

use App\Domains\Settings\ManageSettings\Web\ViewModels\SettingsIndexViewModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        $viewModel = new SettingsIndexViewModel(
            firstName: Auth::user()->first_name,
            lastName: Auth::user()->last_name,
            email: Auth::user()->email,
        );

        return view('settings.index', [
            'view' => $viewModel,
        ]);
    }
}
