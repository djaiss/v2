<?php

namespace App\Domains\Settings\ManageCompany\Web\Controllers;

use App\Domains\Settings\ManageCompany\Services\CreateCompany;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CreateCompanyController extends Controller
{
    public function index(): View|RedirectResponse
    {
        if (Auth::user()->company_id) {
            return redirect()->route('home.index');
        }

        return view('home.create-company');
    }

    public function store(Request $request): RedirectResponse
    {
        if (Auth::user()->company_id) {
            return redirect()->route('home.index');
        }

        (new CreateCompany())->execute([
            'employee_id' => Auth::user()->id,
            'name' => $request->input('name'),
        ]);

        return redirect()->route('home.index');
    }
}
