<?php

namespace App\Domains\Settings\ManageRoles\Services;

use App\Models\Employee;
use App\Models\Role;
use App\Services\BaseService;

class DestroyRole extends BaseService
{
    public function rules(): array
    {
        return [
            'employee_id' => 'required|integer|exists:employees,id',
            'role_id' => 'required|integer|exists:roles,id',
        ];
    }

    public function execute(array $data): void
    {
        $this->validateRules($data);

        $employee = Employee::findOrFail($data['employee_id']);
        $role = Role::where('company_id', $employee->company_id)
            ->findOrFail($data['role_id']);

        $role->delete();
    }
}
