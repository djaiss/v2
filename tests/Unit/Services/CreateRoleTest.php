<?php

namespace Tests\Unit\Services;

use App\Exceptions\NotEnoughPermissionException;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Services\CreateRole;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CreateRoleTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_creates_a_role(): void
    {
        $user = $this->createUserWithPermission(Permission::ORGANIZATION_MANAGE_PERMISSIONS);
        $this->executeService($user);
    }

    /** @test */
    public function it_fails_if_wrong_parameters_are_given(): void
    {
        $request = [
            'title' => 'Ross',
        ];

        $this->expectException(ValidationException::class);
        (new CreateRole())->execute($request);
    }

    /** @test */
    public function it_cant_execute_the_service_with_the_wrong_permissions(): void
    {
        $user = User::factory()->create();

        $this->expectException(NotEnoughPermissionException::class);
        $this->executeService($user);
    }

    private function executeService(User $user): void
    {
        $permission = Permission::factory()->create();

        $request = [
            'author_id' => $user->id,
            'label' => 'Dunder',
            'permissions' => [
                0 => [
                    'id' => $permission->id,
                    'active' => true,
                ],
            ],
        ];

        $role = (new CreateRole())->execute($request);

        $this->assertInstanceOf(
            Role::class,
            $role
        );

        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'label' => 'Dunder',
        ]);

        $this->assertDatabaseHas('permission_role', [
            'permission_id' => $permission->id,
            'role_id' => $role->id,
        ]);
    }
}
