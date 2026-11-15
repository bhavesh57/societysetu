<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Society;
use App\Models\SocietyMember;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class OwnerTenantController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $societyId = session('current_society_id');

        $ownedProperties = Property::where('society_id', $societyId)
            ->whereHas('owners', function ($q) use ($userId) {
                $q->where('users.id', $userId);
            })->get();

        $propertyIds = $ownedProperties->pluck('id')->toArray();

        $tenants = Tenant::where('society_id', $societyId)
            ->whereIn('property_id', $propertyIds)
            ->with(['property', 'tenantUser'])
            ->latest()
            ->get();

        return view('app.owner.tenants.index', compact('tenants', 'ownedProperties'));
    }

    public function store(Request $request)
    {
        $userId = Auth::id();
        $societyId = session('current_society_id');
        $society = Society::findOrFail($societyId);

        $request->validate([
            'property_id' => ['required', 'exists:properties,id'],
            'name' => ['required', 'string', 'max:150'],
            'mobile' => ['required', 'string', 'regex:/^[0-9]{10}$/'],
            'email' => ['nullable', 'email'],
            'password' => ['nullable', 'string', 'min:4'],
            'lease_start_date' => ['required', 'date'],
            'lease_end_date' => ['nullable', 'date', 'after:lease_start_date'],
        ]);

        $prop = Property::where('society_id', $societyId)
            ->where('id', $request->property_id)
            ->whereHas('owners', function ($q) use ($userId) {
                $q->where('users.id', $userId);
            })->firstOrFail();

        $password = $request->filled('password') ? $request->password : '1234';
        $userName = User::generateUserName($request->mobile, $society->society_code);

        $user = User::firstOrCreate(
            ['mobile' => $request->mobile],
            [
                'name' => $request->name,
                'user_name' => $userName,
                'email' => $request->email,
                'pin' => Hash::make($password),
                'password' => Hash::make($password),
            ]
        );

        if (empty($user->user_name)) {
            $user->user_name = $userName;
            $user->save();
        }

        $roleTenant = Role::firstOrCreate(['name' => 'tenant']);
        if (!$user->hasRole('tenant')) {
            $user->assignRole($roleTenant);
        }

        SocietyMember::firstOrCreate([
            'society_id' => $societyId,
            'user_id' => $user->id,
            'role_type' => 'tenant',
        ], ['status' => 'active']);

        Tenant::create([
            'society_id' => $societyId,
            'property_id' => $prop->id,
            'owner_id' => $userId,
            'tenant_user_id' => $user->id,
            'lease_start_date' => $request->lease_start_date,
            'lease_end_date' => $request->lease_end_date,
            'status' => 'active',
        ]);

        $prop->occupancy_status = 'rented';
        $prop->save();

        return redirect()->route('owner.tenants.index')
            ->with('success', "Tenant {$user->name} added successfully for unit {$prop->full_identifier}. Username: {$userName}, Password: {$password}");
    }

    public function deactivate(Tenant $tenant)
    {
        $userId = Auth::id();

        if ($tenant->owner_id !== $userId) {
            abort(403);
        }

        $tenant->status = 'moved_out';
        $tenant->save();

        $hasOtherActive = Tenant::where('property_id', $tenant->property_id)
            ->where('status', 'active')
            ->exists();

        if (!$hasOtherActive) {
            $prop = Property::find($tenant->property_id);
            if ($prop) {
                $prop->occupancy_status = 'vacant';
                $prop->save();
            }
        }

        return back()->with('success', 'Tenant marked as moved out.');
    }
}
