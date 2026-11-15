<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Newsletter;
use App\Models\OwnerProperty;
use App\Models\Property;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $societyId = session('current_society_id');

        // Properties owned by this user in this society
        $ownedProperties = Property::whereHas('owners', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })->with(['currentTenant.tenantUser'])->get();

        $propertyIds = $ownedProperties->pluck('id')->toArray();

        // Active tenants in owned properties
        $tenants = Tenant::whereIn('property_id', $propertyIds)
            ->where('status', 'active')
            ->with(['property', 'tenantUser'])
            ->get();

        // Latest Newsletters targeted to Owners or Both
        $newsletters = Newsletter::where(function ($q) {
                $q->where('target_audience', 'owners_only')
                  ->orWhere('target_audience', 'both');
            })
            ->where('status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get();

        // Complaints submitted by this owner
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

        return view('app.owner.dashboard', compact(
            'ownedProperties',
            'tenants',
            'newsletters',
            'complaints',
            'complaintStats'
        ));
    }
}
