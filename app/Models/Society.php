<?php

namespace App\Models;

use App\Scopes\SocietyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Society extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'society_code',
        'address',
        'city',
        'state',
        'pincode',
        'contact_person',
        'contact_phone',
        'contact_email',
        'status',
    ];

    public function members(): HasMany
    {
        return $this->hasMany(SocietyMember::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'society_members')
            ->withPivot(['role_type', 'status'])
            ->withTimestamps();
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function committeeMembers(): HasMany
    {
        return $this->hasMany(CommitteeMember::class);
    }

    public function newsletters(): HasMany
    {
        return $this->hasMany(Newsletter::class);
    }

    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class);
    }
}
