<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Organization;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            'username' => 'required|unique:users,username|string|max:255',
        ];
    }

    /**
     * Create an account for the user.
     */
    public function execute(array $data): User
    {
        $this->validateRules($data);

        $slug = Str::slug($data['username']);

        if (Organization::where('slug', $slug)->exists()) {
            throw new Exception(trans_key('This name already exists'));
        }

        if (User::where('slug', $slug)->exists()) {
            throw new Exception(trans_key('This name already exists'));
        }

        $user = User::create([
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'slug' => $slug,
        ]);

        event(new Registered($user));

        return $user;
    }
}
