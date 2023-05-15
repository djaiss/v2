<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    public const AGE_HIDDEN = 'hidden';

    public const AGE_ONLY_MONTH_DAY = 'month_day';

    public const AGE_FULL = 'full';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'slug',
        'first_name',
        'last_name',
        'email',
        'password',
        'locale',
        'email_verified_at',
        'timezone',
        'born_at',
        'age_preferences',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'born_at' => 'datetime',
    ];

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    public function projects(): MorphMany
    {
        return $this->morphMany(Project::class, 'projectable');
    }

    protected function age(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                if (is_null($attributes['born_at'])) {
                    return null;
                }

                $date = Carbon::parse($attributes['born_at']);

                if ($attributes['age_preferences'] === self::AGE_HIDDEN) {
                    return null;
                }

                if ($attributes['age_preferences'] === self::AGE_ONLY_MONTH_DAY) {
                    return $date->isoFormat(trans('format.month_day'));
                }

                return $date->isoFormat(trans('format.year_month_day')).' ('.$date->age.')';
            }
        );
    }

    public function isMemberOfOrganization(Organization $organization): bool
    {
        return $this->members()->get()->contains(
            fn (Member $member) => $member->organization_id === $organization->id
        );
    }
}
