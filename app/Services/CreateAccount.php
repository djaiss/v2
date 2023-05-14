<?php

namespace App\Services;

use App\Models\Account;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class CreateAccount extends BaseService
{
    /**
     * Get the validation rules that apply to the service.
     */
    public function rules(): array
    {
        return [
            'email' => 'required|unique:users,email|email|max:255',
            'password' => 'required|min:6|max:60',
        ];
    }

    /**
     * Create an account for the user.
     */
    public function execute(array $data): User
    {
        $this->validateRules($data);

        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        event(new Registered($user));

        return $user;
    }
}
