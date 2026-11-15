<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Newsletter;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $societyId = session('current_society_id');

        // Current active tenancy
        $tenancy = Tenant::where('tenant_user_id', $userId)
            ->where('status', 'active')
            ->with(['property', 'owner'])
            ->first();

        // Latest Newsletters targeted to Tenants or Both
        $newsletters = Newsletter::where(function ($q) {
                $q->where('target_audience', 'tenants_only')
                  ->orWhere('target_audience', 'both');
            })
            ->where('status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get();

        // Complaints lodged by this tenant
        $complaints = Complaint::where('submitted_by', $userId)
            ->with(['category', 'property', 'comments'])
            ->latest()
            ->take(5)
            ->get();

        $complaintStats = [
            'total' => Complaint::where('submitted_by', $userId)->count(),
            'pending' => Complaint::where('submitted_by', $userId)->where('status', 'Pending')->count(),
            'in_progress' => Complaint::where('submitted_by', $userId)->where('status', 'In Progress')->count(),
            'resolved' => Complaint::where('submitted_by', $userId)->where('status', 'Resolved')->count(),
        ];

        return view('app.tenant.dashboard', compact(
            'tenancy',
            'newsletters',
            'complaints',
            'complaintStats'
        ));
    }
}
