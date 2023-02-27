<?php

namespace App\Domains\Settings\ManageCompany\Web\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    public function index(): View
    {
        if (Auth::user()->company_id) {
            return redirect()->route('home.index');
        }

        return view('home.welcome');
    }
}
