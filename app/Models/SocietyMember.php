<?php

namespace App\Models;

use App\Traits\BelongsToSociety;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocietyMember extends Model
{
    use HasFactory, BelongsToSociety;

    protected $fillable = [
        'society_id',
        'user_id',
        'role_type', // committee_member, house_owner, tenant
        'status',    // active, inactive
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
