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
        $societyId = static::getCurrentSocietyId();

        if ($societyId) {
            $builder->where($model->getTable() . '.society_id', $societyId);
        }
    }

    /**
     * Retrieve the current active society ID from request or session.
     */
    public static function getCurrentSocietyId(): ?int
    {
        // 1. Session based (Web / NativePHP Mobile WebView)
        if (session()->has('current_society_id')) {
            return (int) session('current_society_id');
        }

        // 2. Request header based (API / Native Mobile Client)
        if (request()->hasHeader('X-Society-Id')) {
            return (int) request()->header('X-Society-Id');
        }

        // 3. User property if set
        if (auth()->check() && !empty(auth()->user()->current_society_id)) {
            return (int) auth()->user()->current_society_id;
        }

        return null;
    }
}
