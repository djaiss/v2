<?php

namespace App\Domains\Settings\ManageOrganization\Services;

use App\Domains\Settings\ManageOrganization\Jobs\SetupOrganization;
use App\Models\Employee;
use App\Models\Organization;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Str;

class CreateOrganization extends BaseService
{
    private Employee $employee;

    private array $data;

    private Organization $organization;

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
     * Create an organization and associate the employee to it, as the owner.
     */
    public function execute(array $data): Organization
    {
        $this->validateRules($data);
        $this->data = $data;

        $this->checkEmployee();
        $this->createOrganization();
        $this->associateEmployeeToOrganization();

        return $this->organization;
    }

    private function checkEmployee(): void
    {
        $this->employee = Employee::findOrFail($this->data['employee_id']);

        if ($this->employee->organization_id) {
            throw new Exception('Employee already has a company');
        }
    }

    private function createOrganization(): void
    {
        $this->organization = Organization::create([
            'name' => $this->data['name'],
            'invitation_code' => Str::random(40),
        ]);

        SetupOrganization::dispatch($this->organization, $this->employee);
    }

    private function associateEmployeeToOrganization(): void
    {
        $this->employee->organization_id = $this->organization->id;
        $this->employee->save();
    }
}
