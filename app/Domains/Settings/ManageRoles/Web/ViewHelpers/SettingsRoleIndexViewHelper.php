<?php

namespace App\Domains\Settings\ManageRoles\Web\ViewHelpers;

use App\Models\Company;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class SettingsRoleIndexViewHelper
{
    public static function data(Company $company): array
    {
        $roles = $company->roles()
            ->with('permissions')
            ->get()
            ->map(fn (Role $role) => self::role($role));

        return [
            'roles' => $roles,
        ];
    }

    public static function role(Role $role): array
    {
        return [
            'id' => $role->id,
            'name' => $role->name,
            'permissions' => self::permissions($role->permissions),
            'url' => route('settings.roles.show', $role->id),
        ];
    }

    public static function permissions(EloquentCollection $permissions): Collection
    {
        return $permissions->map(fn (Permission $permission) => self::permission($permission));
    }

    public static function permission(Permission $permission): array
    {
        return [
            'id' => $permission->id,
            'name' => $permission->name,
        ];
    }
}
