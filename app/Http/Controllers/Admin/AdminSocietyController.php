<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommitteeMember;
use App\Models\Society;
use App\Models\SocietyMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class AdminSocietyController extends Controller
{
    public function index(Request $request)
    {
        $query = Society::withCount(['properties', 'members', 'complaints']);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('society_code', 'like', "%{$s}%")
                  ->orWhere('city', 'like', "%{$s}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $societies = $query->latest()->paginate(10)->withQueryString();

        return view('admin.societies.index', compact('societies'));
    }

    public function create()
    {
        // Suggest unique society code
        $suggestedCode = strtoupper(Str::random(3)) . rand(100, 999);
        return view('admin.societies.create', compact('suggestedCode'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'society_code' => ['required', 'string', 'max:30', 'alpha_num', 'unique:societies,society_code'],
            'address' => ['nullable', 'string'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'pincode' => ['nullable', 'string', 'max:20'],
            'contact_person' => ['required', 'string', 'max:150'],
            'contact_phone' => ['required', 'string', 'max:25'],
            'contact_email' => ['nullable', 'email', 'max:150'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $validated['society_code'] = strtoupper($validated['society_code']);

        $society = Society::create($validated);

        return redirect()->route('admin.societies.show', $society)
            ->with('success', "Society '{$society->name}' created successfully with code: {$society->society_code}");
    }

    public function show(Society $society)
    {
        $society->loadCount(['properties', 'members', 'complaints', 'newsletters']);
        $committeeMembers = CommitteeMember::withoutGlobalScopes()
            ->where('society_id', $society->id)
            ->with('user')
            ->get();

        $properties = $society->properties()->latest()->take(10)->get();

        return view('admin.societies.show', compact('society', 'committeeMembers', 'properties'));
    }

    public function edit(Society $society)
    {
        return view('admin.societies.edit', compact('society'));
    }

    public function update(Request $request, Society $society)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'society_code' => ['required', 'string', 'max:30', 'alpha_num', 'unique:societies,society_code,' . $society->id],
            'address' => ['nullable', 'string'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'pincode' => ['nullable', 'string', 'max:20'],
            'contact_person' => ['required', 'string', 'max:150'],
            'contact_phone' => ['required', 'string', 'max:25'],
            'contact_email' => ['nullable', 'email', 'max:150'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $validated['society_code'] = strtoupper($validated['society_code']);
        $society->update($validated);

        return redirect()->route('admin.societies.show', $society)
            ->with('success', 'Society profile updated successfully.');
    }

    public function toggleStatus(Society $society)
    {
        $society->status = ($society->status === 'active') ? 'inactive' : 'active';
        $society->save();

        return back()->with('success', "Society status changed to {$society->status}.");
    }

    public function addCommitteeMember(Request $request, Society $society)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'mobile' => ['required', 'string', 'regex:/^[0-9]{10}$/'],
            'designation' => ['required', 'string', 'in:President,Secretary,Treasurer,Member'],
            'pin' => ['required', 'string', 'min:4', 'max:6'],
        ]);

        // Find or create user by mobile
        $user = User::firstOrCreate(
            ['mobile' => $request->mobile],
            [
                'name' => $request->name,
                'email' => null,
                'pin' => Hash::make($request->pin),
                'password' => Hash::make($request->pin),
                'is_super_admin' => false,
            ]
        );

        // Ensure Spatie role
        $role = Role::firstOrCreate(['name' => 'committee_member']);
        if (!$user->hasRole('committee_member')) {
            $user->assignRole($role);
        }

        // Add to society_members
        SocietyMember::firstOrCreate([
            'society_id' => $society->id,
            'user_id' => $user->id,
            'role_type' => 'committee_member',
        ], ['status' => 'active']);

        // Add or update committee designation
        CommitteeMember::updateOrCreate([
            'society_id' => $society->id,
            'user_id' => $user->id,
        ], [
            'designation' => $request->designation,
            'term_start' => now(),
            'term_end' => now()->addYears(2),
        ]);

        return redirect()->route('admin.societies.show', $society)
            ->with('success', "Assigned {$user->name} as {$request->designation} for {$society->name}.");
    }
}
