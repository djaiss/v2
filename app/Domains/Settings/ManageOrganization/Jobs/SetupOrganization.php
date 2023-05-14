<?php

namespace App\Domains\Settings\ManageOrganization\Jobs;

use App\Models\Organization;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SetupOrganization implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Organization $organization,
        public User $user
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
            'organization_id' => $this->organization->id,
            'label_translation_key' => trans_key('Administrator'),
        ]);

        $userRole = Role::create([
            'organization_id' => $this->organization->id,
            'label_translation_key' => trans_key('User'),
        ]);

        $this->user->role_id = $administratorRole->id;
        $this->user->save();

        // permissions for administrators
        $permissionsTable = [
            [
                'action' => Permission::ORGANIZATION_MANAGE_PERMISSIONS,
                'label_translation_key' => 'Manage company roles and permissions',
                'active' => true,
            ],
            [
                'action' => Permission::ORGANIZATION_MANAGE_USERS,
                'label_translation_key' => 'Manage users',
                'active' => true,
            ],
            [
                'action' => Permission::ORGANIZATION_MANAGE_OFFICES,
                'label_translation_key' => 'Manage offices',
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

        // permissions for users
        $permissionsTable = [
            [
                'action' => 'organization.permissions',
                'label_translation_key' => 'Manage company roles and permissions',
                'active' => false,
            ],
        ];

        foreach ($permissionsTable as $permission) {
            $object->roles()->syncWithoutDetaching([
                $userRole->id => [
                    'active' => $permission['active'],
                ],
            ]);
        }
    }
}
