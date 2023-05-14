<?php

namespace Tests\Unit\Domains\Settings\ManageOffices\Services;

use App\Domains\Settings\ManageOffices\Services\DestroyOffice;
use App\Exceptions\NotEnoughPermissionException;
use App\Models\Office;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class DestroyOfficeTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_destroys_an_office(): void
    {
        $user = $this->createUserWithPermission(Permission::ORGANIZATION_MANAGE_OFFICES);
        $office = Office::factory()->create([
            'organization_id' => $user->organization_id,
        ]);
        $this->executeService($user, $office);
    }

    /** @test */
    public function it_fails_if_wrong_parameters_are_given(): void
    {
        $request = [
            'title' => 'Ross',
        ];

        $this->expectException(ValidationException::class);
        (new DestroyOffice())->execute($request);
    }

    /** @test */
    public function it_cant_execute_the_service_with_the_wrong_permissions(): void
    {
        $user = User::factory()->create();
        $office = Office::factory()->create();

        $this->expectException(NotEnoughPermissionException::class);
        $this->executeService($user, $office);
    }

    /** @test */
    public function it_fails_if_office_doesnt_belong_to_company(): void
    {
        $user = $this->createUserWithPermission(Permission::ORGANIZATION_MANAGE_OFFICES);
        $office = Office::factory()->create();

        $this->expectException(ModelNotFoundException::class);
        $this->executeService($user, $office);
    }

    private function executeService(User $user, Office $office): void
    {
        $request = [
            'author_id' => $user->id,
            'office_id' => $office->id,
        ];

        (new DestroyOffice())->execute($request);

        $this->assertDatabaseMissing('offices', [
            'id' => $office->id,
        ]);
    }
}
