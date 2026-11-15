<?php

namespace App\Traits;

use App\Models\Society;
use App\Scopes\SocietyScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToSociety
{
    /**
     * Boot the BelongsToSociety trait for a model.
     */
    protected static function bootBelongsToSociety(): void
    {
        // Add multi-tenant global query scope
        static::addGlobalScope(new SocietyScope);

        // Auto-assign society_id on creation if tenant context is active
        static::creating(function ($model) {
            if (empty($model->society_id)) {
                $societyId = SocietyScope::getCurrentSocietyId();
                if ($societyId) {
                    $model->society_id = $societyId;
                }
            }
        });
    }

    /**
     * Get the society this model belongs to.
     */
    public function society(): BelongsTo
    {
        return $this->belongsTo(Society::class);
    }
}
