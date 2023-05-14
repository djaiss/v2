<?php

namespace App\Jobs;

use App\Models\IssueType;
use App\Models\Organization;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

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
        $this->createIssueTypes();
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

        // set the user as the administrator of the organization
        DB::table('organization_user')
            ->where('user_id', $this->user->id)
            ->where('organization_id', $this->organization->id)
            ->update(['role_id' => $administratorRole->id]);

        // permissions for administrators
        $permissionsTable = [
            [
                'action' => Permission::ORGANIZATION_MANAGE_PERMISSIONS,
                'label_translation_key' => trans_key('Manage company roles and permissions'),
                'active' => true,
            ],
            [
                'action' => Permission::ORGANIZATION_MANAGE_USERS,
                'label_translation_key' => trans_key('Manage users'),
                'active' => true,
            ],
            [
                'action' => Permission::ORGANIZATION_MANAGE_OFFICES,
                'label_translation_key' => trans_key('Manage offices'),
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
                'label_translation_key' => trans_key('Manage company roles and permissions'),
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

    private function createIssueTypes(): void
    {
        IssueType::create([
            'organization_id' => $this->organization->id,
            'label_translation_key' => 'Epic',
            'emoji' => '🚀',
        ]);

        IssueType::create([
            'organization_id' => $this->organization->id,
            'label_translation_key' => 'Story',
            'emoji' => '📖',
        ]);

        IssueType::create([
            'organization_id' => $this->organization->id,
            'label_translation_key' => 'Task',
            'emoji' => '✅',
        ]);

        IssueType::create([
            'organization_id' => $this->organization->id,
            'label_translation_key' => 'Bug',
            'emoji' => '🐛',
        ]);

        IssueType::create([
            'organization_id' => $this->organization->id,
            'label_translation_key' => 'Subtask',
            'emoji' => '💣',
        ]);
    }
}
