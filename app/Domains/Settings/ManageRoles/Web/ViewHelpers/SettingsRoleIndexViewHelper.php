<?php

namespace App\Domains\Settings\ManageRoles\Web\ViewHelpers;

use App\Models\Company;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Collection;

class SettingsRoleIndexViewHelper
{
    public static function data(Company $company): array
    {
        $roles = $company->roles()
            ->with('permissions')
            ->get()
            ->map(fn (Role $role) => self::role($role));

        $permissions = Permission::all()
            ->map(fn (Permission $permission) => self::permission($permission));

        return [
            'roles' => $roles,
            'all_possible_permissions' => $permissions,
        ];
    }

    public static function role(Role $role): array
    {
        return [
            'id' => $role->id,
            'name' => $role->name,
            'permissions' => self::permissions($role),
        ];
    }

    public static function permissions(Role $role): Collection
    {
        $permissions = $role->permissions()->get();

        return $permissions->map(fn (Permission $permission) => self::permission($permission, $permission->pivot->active));
    }

    public static function permission(Permission $permission, bool $active = true): array
    {
        return [
            'id' => $permission->id,
            'name' => $permission->name,
            'active' => $active,
        ];
    }
}
