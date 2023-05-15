<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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
        'is_public',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_public' => 'boolean',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'organization_user')->withPivot('role_id')->withTimestamps();
    }

    public function projects(): MorphMany
    {
        return $this->morphMany(Project::class, 'projectable');
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
