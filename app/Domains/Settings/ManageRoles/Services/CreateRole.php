<?php

namespace App\Domains\Settings\ManageRoles\Services;

use App\Models\Employee;
use App\Models\Role;
use App\Services\BaseService;
use Illuminate\Validation\ValidationException;

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

        return $role;
    }
}
