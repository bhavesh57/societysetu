<?php

namespace App\Http\Middleware;

use App\Models\Society;
use App\Models\SocietyMember;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSocietyMember
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ?string $requiredRole = null): Response
    {
        if (!auth()->check()) {
            return redirect()->route('app.login')->with('error', 'Please log in to continue.');
        }

        $societyId = session('current_society_id');
        if (!$societyId) {
            auth()->logout();
            session()->flush();
            return redirect()->route('app.login')->with('error', 'Society session expired. Please re-enter your society code.');
        }

        $user = auth()->user();

        // Check if user has membership in this society
        $memberships = SocietyMember::where('society_id', $societyId)
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->pluck('role_type')
            ->toArray();

        if (empty($memberships)) {
            auth()->logout();
            session()->flush();
            return redirect()->route('app.login')->with('error', 'You are not an active member of this society.');
        }

        // Active role check
        $activeRole = session('active_role');
        if (!$activeRole || !in_array($activeRole, $memberships)) {
            $activeRole = $memberships[0];
            session(['active_role' => $activeRole]);
        }

        // If specific role is required on the route
        if ($requiredRole && $activeRole !== $requiredRole) {
            // If the user actually possesses this role in this society, automatically switch or redirect
            if (in_array($requiredRole, $memberships)) {
                session(['active_role' => $requiredRole]);
            } else {
                // Redirect user to their own dashboard
                return match ($activeRole) {
                    'committee_member' => redirect()->route('committee.dashboard'),
                    'house_owner' => redirect()->route('owner.dashboard'),
                    'tenant' => redirect()->route('tenant.dashboard'),
                    default => redirect()->route('app.login'),
                };
            }
        }

        return $next($request);
    }
}
