<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IssueType extends Model
{
    use HasFactory, Translatable;

    protected $table = 'issue_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'company_id',
        'label',
        'label_translation_key',
        'emoji',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
