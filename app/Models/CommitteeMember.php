<?php

namespace App\Models;

use App\Traits\BelongsToSociety;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommitteeMember extends Model
{
    use HasFactory, BelongsToSociety;

    protected $fillable = [
        'society_id',
        'user_id',
        'designation', // President, Secretary, Treasurer, Member
        'term_start',
        'term_end',
    ];

    protected function casts(): array
    {
        return [
            'term_start' => 'date',
            'term_end' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
