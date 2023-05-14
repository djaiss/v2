<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    use HasFactory;

    protected $table = 'organizations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'invitation_code',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'organization_user')->withPivot('role_id')->withTimestamps();
    }

    public function offices(): HasMany
    {
        return $this->hasMany(Office::class);
    }

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }
}
