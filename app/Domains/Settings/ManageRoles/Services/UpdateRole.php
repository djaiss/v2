<?php

namespace App\Domains\Settings\ManageRoles\Services;

use App\Models\Employee;
use App\Models\Permission;
use App\Models\Role;
use App\Services\BaseService;

class UpdateRole extends BaseService
{
    public function rules(): array
    {
        return [
            'author_id' => 'required|integer|exists:employees,id',
            'role_id' => 'required|integer|exists:roles,id',
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

        $role = Role::where('company_id', $this->author->company_id)
            ->findOrFail($data['role_id']);

        $role->name = $data['name'];
        $role->save();

        foreach ($data['permissions'] as $permission) {
            $permissionObject = Permission::findOrFail($permission['id']);
            $role->permissions()->syncWithoutDetaching([$permissionObject->id => ['active' => $permission['active']]]);
        }

        return $role;
    }
}
