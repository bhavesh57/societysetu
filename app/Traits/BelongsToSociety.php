<?php

namespace App\Traits;

use App\Models\Society;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToSociety
{
    /**
     * Get the society this model belongs to.
     */
    public function society(): BelongsTo
    {
        return $this->belongsTo(Society::class);
    }
}
