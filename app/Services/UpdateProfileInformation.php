<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Validation\ValidationException;

class UpdateProfileInformation extends BaseService
{
    /**
     * Get the validation rules that apply to the service.
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
        ];
    }

    /**
     * Update the information about the user.
     */
    public function execute(array $data): User
    {
        $this->validateRules($data);

        $user = User::findOrFail($data['user_id']);
        $oldEmail = $user->email;

        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->save();

        if ($oldEmail !== $data['email']) {
            if (User::where('email', $data['email'])->exists()) {
                throw ValidationException::withMessages([
                    'email' => __('This email has already been taken.'),
                ]);
            }

            $user->email = $data['email'];
            $user->email_verified_at = null;
            $user->save();
            $user->refresh()->sendEmailVerificationNotification();
        }

        return $user;
    }
}
