<?php

namespace App\Models;

use App\Traits\BelongsToSociety;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OwnerProperty extends Model
{
    use HasFactory, BelongsToSociety;

    protected $table = 'owner_property';

    protected $fillable = [
        'society_id',
        'property_id',
        'user_id',
        'ownership_start_date',
        'is_primary',
    ];

    protected function casts(): array
    {
        return [
            'ownership_start_date' => 'date',
            'is_primary' => 'boolean',
        ];
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
