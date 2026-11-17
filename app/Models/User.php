<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'user_name', // mobileno#societycode
        'email',
        'mobile',
        'password',
        'pin',
        'avatar',
        'is_super_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'pin',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_super_admin' => 'boolean',
        ];
    }

    /**
     * Helper to generate user_name format: mobileno#societycode
     */
    public static function generateUserName(string $mobile, string $societyCode): string
    {
        return trim($mobile) . '#' . strtoupper(trim($societyCode));
    }

    /**
     * Resolve a user by user_name, email, or mobile number.
     * When $societyId is provided, prefers/scopes users belonging to that society.
     */
    public static function findByLoginIdentifier(string $identifier, ?int $societyId = null, ?string $societyCode = null): ?self
    {
        $value = trim($identifier);
        if ($value === '') {
            return null;
        }

        if ($societyCode !== null && $societyCode !== '') {
            $expectedUserName = self::generateUserName($value, $societyCode);
            $byGenerated = static::query()->where('user_name', $expectedUserName)->first();
            if ($byGenerated) {
                return $byGenerated;
            }
        }

        $query = static::query()->where(function ($q) use ($value) {
            $q->where('user_name', $value)
                ->orWhere('email', $value)
                ->orWhere('mobile', $value);
        });

        if ($societyId !== null) {
            $query->whereHas('societyMembers', function ($q) use ($societyId) {
                $q->where('society_id', $societyId)->where('status', 'active');
            });
        }

        return $query->first();
    }

    public function societyMembers(): HasMany
    {
        return $this->hasMany(SocietyMember::class);
    }

    public function societies(): BelongsToMany
    {
        return $this->belongsToMany(Society::class, 'society_members')
            ->withPivot(['role_type', 'status'])
            ->withTimestamps();
    }

    public function ownedProperties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'owner_property')
            ->withPivot(['is_primary', 'ownership_start_date'])
            ->withTimestamps();
    }

    public function tenancies(): HasMany
    {
        return $this->hasMany(Tenant::class, 'tenant_user_id');
    }

    public function committeeDesignations(): HasMany
    {
        return $this->hasMany(CommitteeMember::class, 'user_id');
    }

    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class, 'submitted_by');
    }
}
