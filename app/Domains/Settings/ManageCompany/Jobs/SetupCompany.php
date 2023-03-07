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

        // permissions
        $permissionsTable = [
            [
                'action' => 'roles.create',
                'translation_key' => 'Create a role',
            ],
            [
                'action' => 'roles.update',
                'translation_key' => 'Update a role',
            ],
            [
                'action' => 'roles.destroy',
                'translation_key' => 'Delete a role',
            ],
        ];

        foreach ($permissionsTable as $permission) {
            $permission = Permission::create($permission);
            $permission->roles()->attach($administratorRole->id, ['company_id' => $this->company->id]);
        }
    }
}
