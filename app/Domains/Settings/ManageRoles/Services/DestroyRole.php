<?php

namespace App\Domains\Settings\ManageRoles\Services;

use App\Models\Permission;
use App\Models\Role;
use App\Services\BaseService;

class DestroyRole extends BaseService
{
    public function rules(): array
    {
        return [
            'author_id' => 'required|integer|exists:employees,id',
            'role_id' => 'required|integer|exists:roles,id',
        ];
    }

    public function permissions(): string
    {
        return Permission::COMPANY_MANAGE_PERMISSIONS;
    }

    public function execute(array $data): void
    {
        $this->validateRules($data);

        $role = Role::where('company_id', $this->author->company_id)
            ->findOrFail($data['role_id']);

        $role->delete();
    }
}
