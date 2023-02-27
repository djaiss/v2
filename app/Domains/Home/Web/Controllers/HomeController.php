<?php

namespace App\Domains\Home\Web\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        if (! Auth::user()->company_id) {
            return redirect()->route('welcome.index');
        }

        return view('home.index');
    }
}
