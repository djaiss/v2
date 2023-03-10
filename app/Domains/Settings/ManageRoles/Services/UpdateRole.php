<?php

namespace App\Domains\Settings\ManageRoles\Services;

use App\Models\Employee;
use App\Models\Permission;
use App\Models\Role;
use App\Services\BaseService;

class UpdateRole extends BaseService
{
    /**
     * Get the validation rules that apply to the service.
     */
    public function rules(): array
    {
        return [
            'employee_id' => 'required|integer|exists:employees,id',
            'role_id' => 'required|integer|exists:roles,id',
            'name' => 'required|string|max:255',
            'permissions' => 'nullable|array',
        ];
    }

    public function execute(array $data): Role
    {
        $this->validateRules($data);

        $employee = Employee::findOrFail($data['employee_id']);
        $role = Role::where('company_id', $employee->company_id)
            ->findOrFail($data['role_id']);

        $role->name = $data['name'];
        $role->save();

        if ($data['permissions']) {
            foreach ($data['permissions'] as $permission) {
                $permissionObject = Permission::findOrFail($permission['id']);
                if ($permission['active']) {
                    $role->permissions()->sync([$permissionObject->id => ['company_id' => $employee->company_id]]);
                } else {
                    $role->permissions()->detach($permissionObject->id);
                }
            }
        }

        return $role;
    }
}
