<?php

namespace Tests\Unit\Jobs;

use App\Jobs\SetupOrganization;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SetupOrganizationTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_sets_an_organization_up(): void
    {
        $organization = Organization::factory()->create();
        $user = User::factory()->create();

        SetupOrganization::dispatchSync($organization, $user);

        $this->assertDatabaseHas('roles', [
            'organization_id' => $organization->id,
            'label_translation_key' => 'Administrator',
        ]);
        $this->assertDatabaseHas('roles', [
            'organization_id' => $organization->id,
            'label_translation_key' => 'User',
        ]);

        $this->assertDatabaseHas('permissions', [
            'action' => 'organization.permissions',
        ]);

        $this->assertDatabaseHas('issue_types', [
            'label_translation_key' => 'Task',
            'emoji' => '✅',
        ]);
    }
}
