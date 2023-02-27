<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'invitation_code',
    ];

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
