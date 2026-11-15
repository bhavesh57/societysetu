<?php

namespace App\Models;

use App\Traits\BelongsToSociety;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Complaint extends Model
{
    use HasFactory, BelongsToSociety;

    protected $fillable = [
        'society_id',
        'property_id',
        'submitted_by',
        'submitter_role', // house_owner, tenant
        'category_id',
        'title',
        'description',
        'photo_path',
        'priority',       // low, medium, high
        'status',         // Pending, In Progress, Resolved, Rejected
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function submitter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ComplaintCategory::class, 'category_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ComplaintComment::class)->latest();
    }
}
