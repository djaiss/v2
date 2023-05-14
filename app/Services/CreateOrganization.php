<?php

namespace App\Services;

use App\Jobs\SetupOrganization;
use App\Models\Organization;
use App\Models\User;
use Exception;
use Illuminate\Support\Str;

class CreateOrganization extends BaseService
{
    private User $user;

    private array $data;

    private Organization $organization;

    /**
     * Get the validation rules that apply to the service.
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'name' => 'required|string|max:255',
        ];
    }

    /**
     * Create an organization and associate the user to it, as the owner.
     */
    public function execute(array $data): Organization
    {
        $this->validateRules($data);
        $this->data = $data;

        $this->checkUser();
        $this->createOrganization();
        $this->associateUserToOrganization();

        return $this->organization;
    }

    private function checkUser(): void
    {
        $this->user = User::findOrFail($this->data['user_id']);

        if ($this->user->organization_id) {
            throw new Exception('User already has an organization');
        }
    }

    private function createOrganization(): void
    {
        $this->organization = Organization::create([
            'name' => $this->data['name'],
            'invitation_code' => Str::random(40),
        ]);

        SetupOrganization::dispatch($this->organization, $this->user);
    }

    private function associateUserToOrganization(): void
    {
        $this->user->organization_id = $this->organization->id;
        $this->user->save();
    }
}
