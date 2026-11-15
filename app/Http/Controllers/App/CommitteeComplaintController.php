<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintCategory;
use App\Models\ComplaintComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommitteeComplaintController extends Controller
{
    public function index(Request $request)
    {
        $societyId = session('current_society_id');

        $query = Complaint::where('society_id', $societyId)
            ->with(['property', 'submitter', 'category']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $complaints = $query->latest()->paginate(10)->withQueryString();
        $categories = ComplaintCategory::all();

        return view('app.committee.complaints.index', compact('complaints', 'categories'));
    }

    public function show(Complaint $complaint)
    {
        $complaint->load(['property', 'submitter', 'category', 'comments.user']);

        return view('app.committee.complaints.show', compact('complaint'));
    }

    public function updateStatus(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status' => ['required', 'in:Pending,In Progress,Resolved,Rejected'],
            'remark' => ['required', 'string', 'max:1000'],
        ]);

        $oldStatus = $complaint->status;
        $complaint->status = $request->status;
        $complaint->save();

        ComplaintComment::create([
            'complaint_id' => $complaint->id,
            'user_id' => Auth::id(),
            'remark' => $request->remark,
            'status_changed_to' => ($oldStatus !== $request->status) ? $request->status : null,
        ]);

        return back()->with('success', "Complaint status updated to '{$request->status}' and remark posted.");
    }
}
