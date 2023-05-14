<?php

namespace Tests\Unit\Services;

use App\Exceptions\NotEnoughPermissionException;
use App\Models\Office;
use App\Models\Permission;
use App\Models\User;
use App\Services\CreateOffice;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CreateOfficeTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_creates_an_office(): void
    {
        $user = $this->createUserWithPermission(Permission::ORGANIZATION_MANAGE_OFFICES);
        $this->executeService($user);
    }

    /** @test */
    public function it_cant_execute_the_service_with_the_wrong_permissions(): void
    {
        $user = User::factory()->create();

        $this->expectException(NotEnoughPermissionException::class);
        $this->executeService($user);
    }

    /** @test */
    public function it_fails_if_wrong_parameters_are_given(): void
    {
        $request = [
            'title' => 'Ross',
        ];

        $this->expectException(ValidationException::class);
        (new CreateOffice())->execute($request);
    }

    private function executeService(User $user): void
    {
        $request = [
            'author_id' => $user->id,
            'name' => 'Dunder',
            'is_main_office' => true,
        ];

        $office = (new CreateOffice())->execute($request);

        $this->assertInstanceOf(
            Office::class,
            $office
        );

        $this->assertDatabaseHas('offices', [
            'id' => $office->id,
            'name' => 'Dunder',
            'is_main_office' => true,
        ]);
    }
}
