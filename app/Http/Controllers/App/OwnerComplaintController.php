<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintCategory;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerComplaintController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $complaints = Complaint::where('submitted_by', $userId)
            ->with(['category', 'property', 'comments.user'])
            ->latest()
            ->paginate(10);

        return view('app.owner.complaints.index', compact('complaints'));
    }

    public function create()
    {
        $userId = Auth::id();

        $properties = Property::whereHas('owners', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })->get();

        $categories = ComplaintCategory::all();

        return view('app.owner.complaints.create', compact('properties', 'categories'));
    }

    public function store(Request $request)
    {
        $userId = Auth::id();
        $societyId = session('current_society_id');

        $validated = $request->validate([
            'property_id' => ['nullable', 'exists:properties,id'],
            'category_id' => ['required', 'exists:complaint_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'priority' => ['required', 'in:low,medium,high'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('complaints', 'public');
        }

        $complaint = Complaint::create([
            'society_id' => $societyId,
            'property_id' => $validated['property_id'] ?? null,
            'submitted_by' => $userId,
            'submitter_role' => 'house_owner',
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'priority' => $validated['priority'],
            'photo_path' => $photoPath,
            'status' => 'Pending',
        ]);

        return redirect()->route('owner.complaints.show', $complaint)
            ->with('success', 'Complaint lodged successfully. Committee will review shortly.');
    }

    public function show(Complaint $complaint)
    {
        $userId = Auth::id();
        if ($complaint->submitted_by !== $userId) {
            abort(403);
        }

        $complaint->load(['category', 'property', 'comments.user']);

        return view('app.owner.complaints.show', compact('complaint'));
    }
}
