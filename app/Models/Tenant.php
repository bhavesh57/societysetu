<?php

namespace App\Models;

use App\Traits\BelongsToSociety;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tenant extends Model
{
    use HasFactory, BelongsToSociety;

    protected $fillable = [
        'society_id',
        'property_id',
        'owner_id',
        'tenant_user_id',
        'lease_start_date',
        'lease_end_date',
        'status', // active, moved_out
    ];

    protected function casts(): array
    {
        return [
            'lease_start_date' => 'date',
            'lease_end_date' => 'date',
        ];
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function tenantUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tenant_user_id');
    }
}
