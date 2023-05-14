<?php

namespace Tests\Unit\Domains\Settings\ManageOrganization\Services;

use App\Domains\Settings\ManageOrganization\Jobs\SetupOrganization;
use App\Domains\Settings\ManageOrganization\Services\CreateOrganization;
use App\Models\Organization;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CreateOrganizationTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_creates_an_organization(): void
    {
        $user = User::factory()->create([
            'organization_id' => null,
        ]);
        $this->executeService($user);
    }

    /** @test */
    public function it_fails_if_wrong_parameters_are_given(): void
    {
        $request = [
            'title' => 'Ross',
        ];

        $this->expectException(ValidationException::class);
        (new CreateOrganization())->execute($request);
    }

    /** @test */
    public function it_fails_if_user_already_owns_a_company(): void
    {
        $user = User::factory()->create([
            'organization_id' => Organization::factory(),
        ]);

        $this->expectException(Exception::class);
        $this->executeService($user);
    }

    private function executeService(User $user): void
    {
        Queue::fake();

        $request = [
            'user_id' => $user->id,
            'name' => 'acme',
        ];

        $organization = (new CreateOrganization())->execute($request);

        $this->assertDatabaseHas('organizations', [
            'id' => $organization->id,
            'name' => 'acme',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'organization_id' => $organization->id,
        ]);

        $this->assertInstanceOf(
            Organization::class,
            $organization
        );

        Queue::assertPushed(SetupOrganization::class);
    }
}
