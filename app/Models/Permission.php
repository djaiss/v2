<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'permissions';

    public const COMPANY_PERMISSIONS = 'company.permissions';
    public const COMPANY_MANAGE_EMPLOYEES = 'company.employees';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'action',
        'translation_key',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'permission_role', 'permission_id', 'role_id')->withPivot('active');
    }

    /**
     * @return Attribute<?string,never>
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => __($attributes['translation_key']),
        );
    }
}
