<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommitteeMember;
use App\Models\Complaint;
use App\Models\Society;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalSocieties = Society::count();
        $activeSocieties = Society::where('status', 'active')->count();
        $inactiveSocieties = Society::where('status', 'inactive')->count();
        $totalUsers = User::where('is_super_admin', false)->count();
        $totalCommittee = CommitteeMember::distinct('user_id')->count('user_id');
        $totalComplaints = Complaint::withoutGlobalScopes()->count();
        $pendingComplaints = Complaint::withoutGlobalScopes()->where('status', 'Pending')->count();

        $recentSocieties = Society::withCount(['properties', 'members', 'complaints'])
            ->latest()
            ->take(6)
            ->get();

        return view('admin.dashboard', compact(
            'totalSocieties',
            'activeSocieties',
            'inactiveSocieties',
            'totalUsers',
            'totalCommittee',
            'totalComplaints',
            'pendingComplaints',
            'recentSocieties'
        ));
    }
}
