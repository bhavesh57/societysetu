<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Society;
use App\Models\SocietyMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AppAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check() && session()->has('current_society_id') && session()->has('active_role')) {
            return match (session('active_role')) {
                'committee_member' => redirect()->route('committee.dashboard'),
                'house_owner' => redirect()->route('owner.dashboard'),
                'tenant' => redirect()->route('tenant.dashboard'),
                default => view('app.auth.login'),
            };
        }

        return view('app.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'society_code' => ['nullable', 'string', 'max:60'],
            'login' => ['required_without_all:mobile,email', 'nullable', 'string', 'max:150'],
            'mobile' => ['required_without_all:login,email', 'nullable', 'string', 'max:150'],
            'email' => ['required_without_all:login,mobile', 'nullable', 'string', 'max:150'],
            'password' => ['nullable', 'string'],
            'pin' => ['nullable', 'string'],
        ]);

        $societyCode = strtoupper(trim((string) $request->input('society_code', '')));
        $identifier = trim((string) ($request->input('login') ?? $request->input('mobile') ?? $request->input('email') ?? ''));
        $password = trim((string) ($request->password ?? $request->pin ?? ''));

        if (empty($password)) {
            return back()->withErrors(['password' => 'Password is required.'])->withInput();
        }

        $society = null;
        if ($societyCode !== '') {
            $society = Society::where('society_code', $societyCode)->first();
            if (!$society) {
                return back()->withErrors(['society_code' => 'No society found matching this code.'])->withInput();
            }
            if ($society->status !== 'active') {
                return back()->withErrors(['society_code' => 'This society portal is currently inactive. Contact your committee.'])->withInput();
            }
        }

        $user = User::findByLoginIdentifier($identifier, $society?->id, $society?->society_code);

        if (!$user) {
            return back()->withErrors(['mobile' => 'Account not found for the provided credentials.'])->withInput();
        }

        // Verify password or PIN strictly (no hardcoded backdoors)
        $isPasswordValid = ($user->password && Hash::check($password, $user->password)) ||
                           ($user->pin && Hash::check($password, $user->pin));

        if (!$isPasswordValid) {
            return back()->withErrors(['password' => 'Incorrect password or PIN credentials.'])->withInput();
        }

        if (!$society) {
            $membership = SocietyMember::with('society')
                ->where('user_id', $user->id)
                ->where('status', 'active')
                ->whereHas('society', fn ($q) => $q->where('status', 'active'))
                ->first();
            $society = $membership?->society;
        }

        if (!$society) {
            return back()->withErrors(['mobile' => 'You do not have an active society membership.'])->withInput();
        }

        if (empty($user->user_name) && !empty($user->mobile)) {
            $user->user_name = User::generateUserName($user->mobile, $society->society_code);
            $user->save();
        }

        $memberships = SocietyMember::where('society_id', $society->id)
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->pluck('role_type')
            ->toArray();

        if (empty($memberships)) {
            return back()->withErrors(['mobile' => 'You do not have an active membership in ' . $society->name])->withInput();
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        // 7. Determine initial role
        $initialRole = $memberships[0];
        if (in_array('committee_member', $memberships)) {
            $initialRole = 'committee_member';
        }

        session([
            'current_society_id' => $society->id,
            'current_society_code' => $society->society_code,
            'current_society_name' => $society->name,
            'available_roles' => $memberships,
            'active_role' => $initialRole,
        ]);

        return match ($initialRole) {
            'committee_member' => redirect()->route('committee.dashboard')->with('success', "Welcome to {$society->name}!"),
            'house_owner' => redirect()->route('owner.dashboard')->with('success', "Welcome to {$society->name}!"),
            'tenant' => redirect()->route('tenant.dashboard')->with('success', "Welcome to {$society->name}!"),
            default => redirect()->route('app.login'),
        };
    }

    public function switchRole(string $role)
    {
        $availableRoles = session('available_roles', []);
        if (!in_array($role, $availableRoles)) {
            return back()->with('error', 'Role not permitted for your account.');
        }

        session(['active_role' => $role]);

        return match ($role) {
            'committee_member' => redirect()->route('committee.dashboard')->with('success', 'Switched to Committee view.'),
            'house_owner' => redirect()->route('owner.dashboard')->with('success', 'Switched to House Owner view.'),
            'tenant' => redirect()->route('tenant.dashboard')->with('success', 'Switched to Tenant view.'),
            default => redirect()->route('app.login'),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('app.login')->with('success', 'Logged out successfully.');
    }
}
