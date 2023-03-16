<?php

namespace App\Domains\Settings\ManageRoles\Services;

use App\Models\Employee;
use App\Models\Permission;
use App\Models\Role;
use App\Services\BaseService;

class CreateRole extends BaseService
{
    public function rules(): array
    {
        return [
            'author_id' => 'required|integer|exists:employees,id',
            'name' => 'required|string|max:255',
            'permissions' => 'nullable|array',
        ];
    }

    public function permissions(): string
    {
        return Permission::COMPANY_MANAGE_PERMISSIONS;
    }

    public function execute(array $data): Role
    {
        $this->validateRules($data);

        $role = Role::create([
            'company_id' => $this->author->company_id,
            'name' => $data['name'],
        ]);

        foreach ($data['permissions'] as $permission) {
            $permissionObject = Permission::findOrFail($permission['id']);
            $role->permissions()->syncWithoutDetaching([$permissionObject->id => ['active' => $permission['active']]]);
        }

        return $role;
    }
}
