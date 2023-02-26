<?php

namespace App\Domains\Settings\ManageCompany\Services;

use App\Models\Company;
use App\Models\Employee;
use App\Services\BaseService;
use Exception;

class CreateCompany extends BaseService
{
    private Employee $employee;

    private array $data;

    private Company $company;

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

    /**
     * Create a company and associate the employee to it, as the owner.
     */
    public function execute(array $data): Company
    {
        $this->validateRules($data);
        $this->data = $data;

        $this->checkEmployee();
        $this->createCompany();
        $this->associateEmployeeToCompany();

        return $this->company;
    }

    private function checkEmployee(): void
    {
        $this->employee = Employee::findOrFail($this->data['employee_id']);

        if ($this->employee->company_id) {
            throw new Exception('Employee already has a company');
        }
    }

    private function createCompany(): void
    {
        $this->company = Company::create([
            'name' => $this->data['name'],
        ]);
    }

    private function associateEmployeeToCompany(): void
    {
        $this->employee->company_id = $this->company->id;
        $this->employee->save();
    }
}
