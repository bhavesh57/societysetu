<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Society;
use App\Models\SocietyMember;
use Illuminate\Http\Request;

class AdminMonitoringController extends Controller
{
    public function index(Request $request)
    {
        $societies = Society::withCount([
            'members',
            'properties',
            'newsletters',
            'complaints'
        ])
        ->withCount(['complaints as pending_complaints_count' => function ($q) {
            $q->withoutGlobalScopes()->where('status', 'Pending');
        }])
        ->withCount(['complaints as in_progress_complaints_count' => function ($q) {
            $q->withoutGlobalScopes()->where('status', 'In Progress');
        }])
        ->withCount(['complaints as resolved_complaints_count' => function ($q) {
            $q->withoutGlobalScopes()->where('status', 'Resolved');
        }])
        ->latest()
        ->paginate(15);

        $recentComplaints = Complaint::withoutGlobalScopes()
            ->with(['society', 'submitter', 'category'])
            ->latest()
            ->take(8)
            ->get();

        return view('admin.monitoring', compact('societies', 'recentComplaints'));
    }
}
