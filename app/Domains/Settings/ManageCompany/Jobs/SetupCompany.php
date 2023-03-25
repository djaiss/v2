<?php

namespace App\Domains\Settings\ManageCompany\Jobs;

use App\Models\Company;
use App\Models\Employee;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SetupCompany implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Company $company,
        public Employee $employee
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->createRoles();
    }

    private function createRoles(): void
    {
        $administratorRole = Role::create([
            'company_id' => $this->company->id,
            'translation_key' => 'Administrator',
        ]);

        $employeeRole = Role::create([
            'company_id' => $this->company->id,
            'translation_key' => 'Employee',
        ]);

        $this->employee->role_id = $administratorRole->id;
        $this->employee->save();

        // permissions for administrators
        $permissionsTable = [
            [
                'action' => Permission::COMPANY_MANAGE_PERMISSIONS,
                'translation_key' => 'Manage company roles and permissions',
                'active' => true,
            ],
            [
                'action' => Permission::COMPANY_MANAGE_EMPLOYEES,
                'translation_key' => 'Manage employees',
                'active' => true,
            ],
            [
                'action' => Permission::COMPANY_MANAGE_OFFICES,
                'translation_key' => 'Manage offices',
                'active' => true,
            ],
        ];

        foreach ($permissionsTable as $permission) {
            $object = Permission::create($permission);
            $object->roles()->syncWithoutDetaching([
                $administratorRole->id => [
                    'active' => $permission['active'],
                ],
            ]);
        }

        // permissions for employees
        $permissionsTable = [
            [
                'action' => 'company.permissions',
                'translation_key' => 'Manage company roles and permissions',
                'active' => false,
            ],
        ];

        foreach ($permissionsTable as $permission) {
            $object->roles()->syncWithoutDetaching([
                $employeeRole->id => [
                    'active' => $permission['active'],
                ],
            ]);
        }
    }
}
