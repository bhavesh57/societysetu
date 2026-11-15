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

        $totalHouses = Property::count();
        $totalOwners = SocietyMember::where('role_type', 'house_owner')->count();
        $totalTenants = Tenant::where('status', 'active')->count();
        $pendingComplaintsCount = Complaint::where('status', 'Pending')->count();
        $inProgressComplaintsCount = Complaint::where('status', 'In Progress')->count();

        $recentComplaints = Complaint::with(['property', 'submitter', 'category'])
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
