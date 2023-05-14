<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasFactory;

    public const ORGANIZATION_MANAGE_PERMISSIONS = 'organization.permissions';

    public const ORGANIZATION_MANAGE_USERS = 'organization.users';

    public const ORGANIZATION_MANAGE_OFFICES = 'organization.offices';

    protected $table = 'permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'action',
        'label_translation_key',
        'label',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'permission_role', 'permission_id', 'role_id')->withPivot('active');
    }

    /**
     * @return Attribute<?string,never>
     */
    protected function label(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => __($attributes['label_translation_key']),
        );
    }
}
