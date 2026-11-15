<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\OwnerProperty;
use App\Models\Property;
use App\Models\Society;
use App\Models\SocietyMember;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CommitteeMemberController extends Controller
{
    public function directory(Request $request)
    {
        $societyId = session('current_society_id');

        // Owners in this society
        $owners = OwnerProperty::where('society_id', $societyId)
            ->with(['user', 'property'])
            ->latest()
            ->get();

        // Active Tenants in this society
        $tenants = Tenant::where('society_id', $societyId)
            ->with(['tenantUser', 'property', 'owner'])
            ->where('status', 'active')
            ->latest()
            ->get();

        $properties = Property::where('society_id', $societyId)
            ->orderBy('wing_or_block')
            ->orderBy('house_number')
            ->get();

        return view('app.committee.members.directory', compact('owners', 'tenants', 'properties'));
    }

    public function storeOwner(Request $request)
    {
        $societyId = session('current_society_id');
        $society = Society::findOrFail($societyId);

        $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'mobile' => ['required', 'string', 'regex:/^[0-9]{10}$/'],
            'email' => ['nullable', 'email'],
            'password' => ['nullable', 'string', 'min:4'],
            'property_id' => ['required', 'exists:properties,id'],
            'ownership_start_date' => ['nullable', 'date'],
        ]);

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

        $roleOwner = Role::firstOrCreate(['name' => 'house_owner']);
        if (!$user->hasRole('house_owner')) {
            $user->assignRole($roleOwner);
        }

        SocietyMember::firstOrCreate([
            'society_id' => $societyId,
            'user_id' => $user->id,
            'role_type' => 'house_owner',
        ], ['status' => 'active']);

        OwnerProperty::firstOrCreate([
            'society_id' => $societyId,
            'property_id' => $request->property_id,
            'user_id' => $user->id,
        ], [
            'ownership_start_date' => $request->ownership_start_date ?? now(),
            'is_primary' => true,
        ]);

        $prop = Property::where('society_id', $societyId)->find($request->property_id);
        if ($prop && $prop->occupancy_status === 'vacant') {
            $prop->occupancy_status = 'owner_occupied';
            $prop->save();
        }

        return redirect()->route('committee.members.directory')
            ->with('success', "Owner {$user->name} linked to {$prop->full_identifier}. Username: {$userName}, Password: {$password}");
    }

    public function storeTenant(Request $request)
    {
        $societyId = session('current_society_id');
        $society = Society::findOrFail($societyId);

        $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'mobile' => ['required', 'string', 'regex:/^[0-9]{10}$/'],
            'email' => ['nullable', 'email'],
            'password' => ['nullable', 'string', 'min:4'],
            'property_id' => ['required', 'exists:properties,id'],
            'lease_start_date' => ['required', 'date'],
            'lease_end_date' => ['nullable', 'date', 'after:lease_start_date'],
        ]);

        $prop = Property::where('society_id', $societyId)->findOrFail($request->property_id);
        $primaryOwner = $prop->owners()->first();
        if (!$primaryOwner) {
            return back()->withErrors(['property_id' => 'This property must have a registered owner before adding a tenant.'])->withInput();
        }

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
            'owner_id' => $primaryOwner->id,
            'tenant_user_id' => $user->id,
            'lease_start_date' => $request->lease_start_date,
            'lease_end_date' => $request->lease_end_date,
            'status' => 'active',
        ]);

        $prop->occupancy_status = 'rented';
        $prop->save();

        return redirect()->route('committee.members.directory')
            ->with('success', "Tenant {$user->name} registered for {$prop->full_identifier}. Username: {$userName}, Password: {$password}");
    }
}
