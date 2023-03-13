<?php

namespace App\Domains\Settings\ManageCompany\Jobs;

use App\Models\Company;
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
        public Company $company
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

        // permissions for administrators
        $permissionsTable = [
            [
                'action' => 'company.permissions',
                'translation_key' => 'Manage company roles and permissions',
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

        // permissions for administrators
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
