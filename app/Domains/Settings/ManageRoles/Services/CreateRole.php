<?php

namespace App\Domains\Settings\ManageRoles\Services;

use App\Models\Employee;
use App\Models\Permission;
use App\Models\Role;
use App\Services\BaseService;

class CreateRole extends BaseService
{
    /**
     * Get the validation rules that apply to the service.
     */
    public function rules(): array
    {
        return [
            'employee_id' => 'required|integer|exists:employees,id',
            'name' => 'required|string|max:255',
            'permissions' => 'nullable|array',
        ];
    }

    public function execute(array $data): Role
    {
        $this->validateRules($data);

        $employee = Employee::findOrFail($data['employee_id']);

        $role = Role::create([
            'company_id' => $employee->company_id,
            'name' => $data['name'],
        ]);

        if ($data['permissions']) {
            foreach ($data['permissions'] as $permission) {
                $permissionObject = Permission::findOrFail($permission['id']);
                if ($permission['active']) {
                    $permissionObject->roles()->sync([$role->id => ['company_id' => $employee->company_id]]);
                } else {
                    $permissionObject->roles()->detach($role->id);
                }
            }
        }

        return $role;
    }
}
