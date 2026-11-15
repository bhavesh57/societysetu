<?php

namespace App\Models;

use App\Traits\BelongsToSociety;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Property extends Model
{
    use HasFactory, BelongsToSociety;

    protected $fillable = [
        'society_id',
        'wing_or_block',
        'house_number',
        'property_type',
        'occupancy_status',
    ];

    public function owners(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'owner_property')
            ->withPivot(['ownership_start_date', 'is_primary'])
            ->withTimestamps();
    }

    public function tenants(): HasMany
    {
        return $this->hasMany(Tenant::class);
    }

    public function currentTenant(): HasOne
    {
        return $this->hasOne(Tenant::class)->where('status', 'active')->latestOfMany();
    }

    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class);
    }

    public function getFullIdentifierAttribute(): string
    {
        return "{$this->wing_or_block} - {$this->house_number}";
    }
}
