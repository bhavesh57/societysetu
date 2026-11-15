<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class CommitteePropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::with(['owners', 'currentTenant.tenantUser']);

        if ($request->filled('wing')) {
            $query->where('wing_or_block', 'like', "%{$request->wing}%");
        }

        if ($request->filled('status')) {
            $query->where('occupancy_status', $request->status);
        }

        $properties = $query->orderBy('wing_or_block')->orderBy('house_number')->paginate(12)->withQueryString();

        return view('app.committee.properties.index', compact('properties'));
    }

    public function create()
    {
        return view('app.committee.properties.create');
    }

    public function store(Request $request)
    {
        $societyId = session('current_society_id');

        $validated = $request->validate([
            'wing_or_block' => ['required', 'string', 'max:50'],
            'house_number' => ['required', 'string', 'max:50'],
            'property_type' => ['required', 'string', 'in:Flat,Villa,Tenament,Shop'],
            'occupancy_status' => ['required', 'string', 'in:vacant,owner_occupied,rented'],
        ]);

        // Check unique wing and house number in this society
        $exists = Property::where('wing_or_block', $validated['wing_or_block'])
            ->where('house_number', $validated['house_number'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['house_number' => 'This unit already exists in this wing/block.'])->withInput();
        }

        $property = Property::create($validated);

        return redirect()->route('committee.properties.index')
            ->with('success', "Property {$property->wing_or_block} - {$property->house_number} created successfully.");
    }
}
