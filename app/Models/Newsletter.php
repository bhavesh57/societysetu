<?php

namespace App\Models;

use App\Traits\BelongsToSociety;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Newsletter extends Model
{
    use HasFactory, BelongsToSociety;

    protected $fillable = [
        'society_id',
        'created_by',
        'title',
        'content',
        'attachment_path',
        'target_audience', // owners_only, tenants_only, both
        'published_at',
        'status',          // draft, published
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function recipients(): HasMany
    {
        return $this->hasMany(NewsletterRecipient::class);
    }

    public function recipientUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'newsletter_recipients')
            ->withPivot('read_at')
            ->withTimestamps();
    }
}
