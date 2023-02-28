<?php

namespace App\Domains\Settings\ManageProfile\Web\Controllers;

use App\Domains\Settings\ManageCompany\Services\CreateCompany;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageProfileController extends Controller
{
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
