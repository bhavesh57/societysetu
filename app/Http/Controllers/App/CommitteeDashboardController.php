<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Property;
use App\Models\SocietyMember;
use App\Models\Tenant;
use Illuminate\Http\Request;

class CommitteeDashboardController extends Controller
{
    public function index()
    {
        $societyId = session('current_society_id');

        $totalHouses = Property::where('society_id', $societyId)->count();
        $totalOwners = SocietyMember::where('society_id', $societyId)->where('role_type', 'house_owner')->count();
        $totalTenants = Tenant::where('society_id', $societyId)->where('status', 'active')->count();
        $pendingComplaintsCount = Complaint::where('society_id', $societyId)->where('status', 'Pending')->count();
        $inProgressComplaintsCount = Complaint::where('society_id', $societyId)->where('status', 'In Progress')->count();

        $recentComplaints = Complaint::where('society_id', $societyId)
            ->with(['property', 'submitter', 'category'])
            ->latest()
            ->take(5)
            ->get();

        return view('app.committee.dashboard', compact(
            'totalHouses',
            'totalOwners',
            'totalTenants',
            'pendingComplaintsCount',
            'inProgressComplaintsCount',
            'recentComplaints'
        ));
    }
}
