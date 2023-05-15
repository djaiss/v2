<?php

namespace App\Services;

use App\Models\Member;
use App\Models\Office;
use App\Models\Organization;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AddUserToOrganization extends BaseService
{
    private Organization $organization;

    private array $data;

    public function rules(): array
    {
        return [
            'author_id' => 'required|integer|exists:members,id',
            'organization_id' => 'required|integer|exists:organizations,id',
            'user_id' => 'required|integer|exists:users,id',
            'role_id' => 'required|integer|exists:roles,id',
        ];
    }

    public function permissions(): string
    {
        return Permission::ORGANIZATION_ADD_MEMBERS;
    }

    public function execute(array $data): Member
    {
        $this->data = $data;
        $this->validate();

        $member = Member::create([
            'organization_id' => $this->organization->id,
            'user_id' => $data['user_id'],
            'role_id' => $data['role_id'],
        ]);

        return $member;
    }

    public function validate(): void
    {
        $this->validateRules($this->data);

        $user = User::findOrFail($this->data['user_id']);

        if (! $user->isMemberOfOrganization($this->organization)) {
            throw new ModelNotFoundException();
        }

        Role::where('organization_id', $this->organization->id)
            ->findOrFail($this->data['role_id']);
    }
}
