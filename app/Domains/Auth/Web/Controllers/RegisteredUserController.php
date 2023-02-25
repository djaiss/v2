<?php

namespace App\Domains\Auth\Web\Controllers;

use App\Domains\Auth\Services\CreateAccount;
use App\Http\Controllers\Controller;
use App\Domains\Auth\Web\Controllers\EmailVerificationPromptController;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $employee = (new CreateAccount())->execute([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        Auth::login($employee);

        return redirect(RouteServiceProvider::HOME);
    }
}
