<?php

namespace Tests\Unit\Domains\Settings\ManageOrganization\Jobs;

use App\Domains\Settings\ManageOrganization\Jobs\SetupOrganization;
use App\Models\Employee;
use App\Models\Organization;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SetupOrganizationTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_sets_an_organization_up(): void
    {
        $organization = Organization::factory()->create();
        $employee = Employee::factory()->create();

        SetupOrganization::dispatchSync($organization, $employee);

        $this->assertDatabaseHas('roles', [
            'organization_id' => $organization->id,
            'label_translation_key' => 'Administrator',
        ]);
        $this->assertDatabaseHas('roles', [
            'organization_id' => $organization->id,
            'label_translation_key' => 'Employee',
        ]);

        $this->assertDatabaseHas('permissions', [
            'action' => 'company.permissions',
        ]);
    }
}
