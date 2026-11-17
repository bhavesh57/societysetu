<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintComment;
use App\Models\Newsletter;
use App\Models\Property;
use App\Models\SocietyMember;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SocietyApiController extends Controller
{
    /**
     * Resolve the authenticated user's active society_id and verified roles.
     *
     * @return array{society_id: int, roles: array<int, string>}
     */
    protected function resolveMembershipContext(Request $request, User $user): array
    {
        $requestedSocietyId = $request->header('X-Society-Id');

        $query = SocietyMember::query()
            ->where('user_id', $user->id)
            ->where('status', 'active');

        if ($requestedSocietyId !== null && is_numeric($requestedSocietyId)) {
            $query->where('society_id', (int) $requestedSocietyId);
        }

        $memberships = $query->get();

        if ($memberships->isEmpty()) {
            abort(403, 'No active society membership found for this user.');
        }

        $societyId = (int) $memberships->first()->society_id;
        $roles = $memberships->where('society_id', $societyId)->pluck('role_type')->values()->all();

        return [
            'society_id' => $societyId,
            'roles' => $roles,
        ];
    }

    public function newsletters(Request $request): JsonResponse
    {
        $ctx = $this->resolveMembershipContext($request, $request->user());
        $roles = $ctx['roles'];

        $query = Newsletter::with('author:id,name')
            ->where('society_id', $ctx['society_id'])
            ->where('status', 'published');

        if (! in_array('committee_member', $roles, true)) {
            $allowedAudiences = ['both'];
            if (in_array('house_owner', $roles, true)) {
                $allowedAudiences[] = 'owners_only';
            }
            if (in_array('tenant', $roles, true)) {
                $allowedAudiences[] = 'tenants_only';
            }
            $query->whereIn('target_audience', $allowedAudiences);
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
        $ctx = $this->resolveMembershipContext($request, $user);

        $query = Complaint::with(['property', 'category', 'submitter:id,name', 'comments.user:id,name'])
            ->where('society_id', $ctx['society_id']);

        // Only verified committee members can see all society complaints
        if (! in_array('committee_member', $ctx['roles'], true)) {
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
        $ctx = $this->resolveMembershipContext($request, $user);

        $validated = $request->validate([
            'property_id' => ['nullable', 'exists:properties,id'],
            'category_id' => ['required', 'exists:complaint_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'priority' => ['required', 'in:low,medium,high'],
            'submitter_role' => ['required', 'in:house_owner,tenant'],
            'photo' => ['nullable', 'image', 'max:5120'],
        ]);

        if (! in_array($validated['submitter_role'], $ctx['roles'], true) && ! in_array('committee_member', $ctx['roles'], true)) {
            return response()->json([
                'success' => false,
                'message' => 'You do not hold the selected role in this society.',
            ], 403);
        }

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('complaints', 'public');
        }

        $complaint = Complaint::create([
            'society_id' => $ctx['society_id'],
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
        $ctx = $this->resolveMembershipContext($request, $user);

        $request->validate([
            'remark' => ['required', 'string'],
            'status' => ['nullable', 'in:Pending,In Progress,Resolved,Rejected'],
        ]);

        $complaint = Complaint::where('society_id', $ctx['society_id'])->findOrFail($id);
        $isCommittee = in_array('committee_member', $ctx['roles'], true);

        if (! $isCommittee && $complaint->submitted_by !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to comment on this complaint.',
            ], 403);
        }

        if ($request->filled('status')) {
            if (! $isCommittee) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only committee members can update complaint status.',
                ], 403);
            }
            $complaint->status = $request->status;
            $complaint->save();
        }

        $comment = ComplaintComment::create([
            'complaint_id' => $complaint->id,
            'user_id' => $user->id,
            'remark' => $request->remark,
            'status_changed_to' => $isCommittee ? $request->status : null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Remark posted.',
            'data' => $comment->load('user:id,name'),
        ]);
    }

    public function properties(Request $request): JsonResponse
    {
        $ctx = $this->resolveMembershipContext($request, $request->user());

        $properties = Property::with(['owners:id,name,mobile', 'currentTenant.tenantUser:id,name,mobile'])
            ->where('society_id', $ctx['society_id'])
            ->orderBy('wing_or_block')
            ->orderBy('house_number')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $properties,
        ]);
    }
}
