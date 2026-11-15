<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintComment;
use App\Models\Newsletter;
use App\Models\Property;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SocietyApiController extends Controller
{
    public function newsletters(Request $request): JsonResponse
    {
        $role = $request->header('X-User-Role', 'both');

        $query = Newsletter::with('author:id,name')
            ->where('status', 'published');

        if ($role === 'house_owner') {
            $query->whereIn('target_audience', ['owners_only', 'both']);
        } elseif ($role === 'tenant') {
            $query->whereIn('target_audience', ['tenants_only', 'both']);
        }

        $newsletters = $query->latest('published_at')->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $newsletters,
        ]);
    }

    public function complaints(Request $request): JsonResponse
    {
        $user = $request->user();
        $role = $request->header('X-User-Role');

        $query = Complaint::with(['property', 'category', 'submitter:id,name', 'comments.user:id,name']);

        // Committee members can see all society complaints; owners/tenants see their own
        if ($role !== 'committee_member') {
            $query->where('submitted_by', $user->id);
        }

        $complaints = $query->latest()->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $complaints,
        ]);
    }

    public function storeComplaint(Request $request): JsonResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'society_id' => ['required', 'exists:societies,id'],
            'property_id' => ['nullable', 'exists:properties,id'],
            'category_id' => ['required', 'exists:complaint_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'priority' => ['required', 'in:low,medium,high'],
            'submitter_role' => ['required', 'in:house_owner,tenant'],
            'photo' => ['nullable', 'image', 'max:5120'],
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('complaints', 'public');
        }

        $complaint = Complaint::create([
            'society_id' => $validated['society_id'],
            'property_id' => $validated['property_id'] ?? null,
            'submitted_by' => $user->id,
            'submitter_role' => $validated['submitter_role'],
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'priority' => $validated['priority'],
            'photo_path' => $photoPath,
            'status' => 'Pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Complaint logged successfully.',
            'data' => $complaint->load(['category', 'property']),
        ], 201);
    }

    public function addComment(Request $request, int $id): JsonResponse
    {
        $user = $request->user();

        $request->validate([
            'remark' => ['required', 'string'],
            'status' => ['nullable', 'in:Pending,In Progress,Resolved,Rejected'],
        ]);

        $complaint = Complaint::findOrFail($id);

        if ($request->filled('status')) {
            $complaint->status = $request->status;
            $complaint->save();
        }

        $comment = ComplaintComment::create([
            'complaint_id' => $complaint->id,
            'user_id' => $user->id,
            'remark' => $request->remark,
            'status_changed_to' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Remark posted.',
            'data' => $comment->load('user:id,name'),
        ]);
    }

    public function properties(Request $request): JsonResponse
    {
        $properties = Property::with(['owners:id,name,mobile', 'currentTenant.tenantUser:id,name,mobile'])
            ->orderBy('wing_or_block')
            ->orderBy('house_number')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $properties,
        ]);
    }
}
