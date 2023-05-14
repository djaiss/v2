<?php

namespace Tests\Unit\Services;

use App\Jobs\SetupOrganization;
use App\Models\Organization;
use App\Models\User;
use App\Services\CreateOrganization;
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
        $user = User::factory()->create();
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
    public function it_fails_if_organization_slug_already_exists(): void
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
        $user = User::factory()->create();
        Organization::factory()->create([
            'name' => 'acme',
            'slug' => 'acme',
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

        $this->assertInstanceOf(
            Organization::class,
            $organization
        );

        $this->assertDatabaseHas('organizations', [
            'id' => $organization->id,
            'name' => 'acme',
            'slug' => 'acme',
        ]);

        $this->assertDatabaseHas('organization_user', [
            'organization_id' => $organization->id,
            'user_id' => $user->id,
        ]);

        Queue::assertPushed(SetupOrganization::class);
    }
}