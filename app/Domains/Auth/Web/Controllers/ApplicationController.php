<?php

namespace App\Domains\Auth\Web\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

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
