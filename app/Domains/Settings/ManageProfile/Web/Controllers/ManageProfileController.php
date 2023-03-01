<?php

namespace App\Domains\Settings\ManageProfile\Web\Controllers;

use App\Domains\Settings\ManageProfile\Services\UpdateProfileInformation;
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

        $employee = (new UpdateProfileInformation())->execute([
            'employee_id' => Auth::user()->id,
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
        ]);

        return redirect()->route('home.index');
    }
}
