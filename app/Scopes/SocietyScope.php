<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class SocietyScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        // Global scope removed per user request for direct query control
    }

    /**
     * Retrieve the current active society ID from request or session.
     */
    public static function getCurrentSocietyId(): ?int
    {
        if (session()->has('current_society_id')) {
            return (int) session('current_society_id');
        }

        if (request()->hasHeader('X-Society-Id')) {
            return (int) request()->header('X-Society-Id');
        }

        return null;
    }
}
