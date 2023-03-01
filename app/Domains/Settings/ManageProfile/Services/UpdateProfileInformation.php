<?php

namespace App\Domains\Settings\ManageProfile\Services;

use App\Models\Employee;
use App\Services\BaseService;

class UpdateProfileInformation extends BaseService
{
    /**
     * Get the validation rules that apply to the service.
     */
    public function rules(): array
    {
        return [
            'employee_id' => 'required|integer|exists:employees,id',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
        ];
    }

    /**
     * Update the information about the employee.
     */
    public function execute(array $data): Employee
    {
        $this->validateRules($data);

        $employee = Employee::findOrFail($data['employee_id']);
        $oldEmail = $employee->email;

        $employee->first_name = $data['first_name'];
        $employee->last_name = $data['last_name'];
        $employee->save();

        if ($oldEmail !== $data['email']) {
            $employee->email = $data['email'];
            $employee->email_verified_at = null;
            $employee->save();
            $employee->refresh()->sendEmailVerificationNotification();
        }

        return $employee;
    }
}
