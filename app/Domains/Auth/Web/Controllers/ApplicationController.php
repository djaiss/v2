<?php

namespace App\Domains\Auth\Web\Controllers;

use App\Domains\Auth\Services\CreateAccount;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function index(): RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('home.index');
        }

        return redirect()->route('login.create');
    }
}
