<?php

namespace App\Domains\Settings\ManageEmployees\Services;

use App\Models\Employee;
use App\Models\Permission;
use App\Models\Role;
use App\Services\BaseService;

class CreateEmployee extends BaseService
{
    public function rules(): array
    {
        return [
            'author_id' => 'required|integer|exists:employees,id',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'permissions' => 'required|array',
        ];
    }

    public function permissions(): string
    {
        return Permission::COMPANY_MANAGE_EMPLOYEES;
    }

    public function execute(array $data): Employee
    {
        $this->validateRules($data);

        Role::where('company_id', $this->author->company_id)
            ->findOrFail($data['role_id']);

        $employee = Employee::create([
            'company_id' => $this->author->company_id,
            'first_name' => $this->valueOrNull($data, 'first_name'),
            'last_name' => $this->valueOrNull($data, 'last_name'),
            'email' => $data['email'],
            'role_id' => $data['role_id'],
        ]);

        return $employee;
    }
}
