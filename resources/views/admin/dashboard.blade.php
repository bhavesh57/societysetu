@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Header banner -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Super Admin Overview</h1>
            <p class="text-xs text-slate-500 mt-1">Platform-wide statistics and multi-society operations</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.societies.create') }}" class="btn-primary px-4 py-2 text-xs font-semibold shadow-sm">
                + Onboard New Society
            </a>
            <a href="{{ route('admin.monitoring') }}" class="btn-secondary px-4 py-2 text-xs font-semibold">
                View Global Monitoring
            </a>
        </div>
    </div>

    <!-- Metric Cards Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <!-- Card 1 -->
        <div class="card p-5">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Societies</span>
                <span class="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center font-bold text-xs">
                    🏢
                </span>
            </div>
            <div class="mt-3 flex items-baseline space-x-2">
                <span class="text-2xl font-bold text-slate-900">{{ $totalSocieties }}</span>
                <span class="text-xs text-emerald-600 font-medium">({{ $activeSocieties }} active)</span>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="card p-5">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Residents</span>
                <span class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs">
                    👥
                </span>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-bold text-slate-900">{{ $totalUsers }}</span>
                <span class="text-xs text-slate-500 block">Registered users</span>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="card p-5">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Committee Reps</span>
                <span class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs">
                    🎖️
                </span>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-bold text-slate-900">{{ $totalCommittee }}</span>
                <span class="text-xs text-slate-500 block">Appointed leaders</span>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="card p-5">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Active Complaints</span>
                <span class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-xs">
                    ⚠️
                </span>
            </div>
            <div class="mt-3 flex items-baseline space-x-2">
                <span class="text-2xl font-bold text-slate-900">{{ $pendingComplaints }}</span>
                <span class="text-xs text-slate-500">of {{ $totalComplaints }} total</span>
            </div>
        </div>
    </div>

    <!-- Recent Societies Table -->
    <div class="card overflow-hidden">
        <div class="p-5 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-900">Registered Societies</h2>
                <p class="text-xs text-slate-500">Managed housing societies on SocietySetu</p>
            </div>
            <a href="{{ route('admin.societies.index') }}" class="text-xs font-semibold text-teal-600 hover:text-teal-700">
                View All &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 uppercase font-semibold border-b border-slate-200">
                        <th class="py-3 px-4">Society Name</th>
                        <th class="py-3 px-4">Code</th>
                        <th class="py-3 px-4">Location</th>
                        <th class="py-3 px-4">Units</th>
                        <th class="py-3 px-4">Members</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentSocieties as $soc)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3 px-4 font-semibold text-slate-900">
                                <a href="{{ route('admin.societies.show', $soc) }}" class="hover:text-teal-600">
                                    {{ $soc->name }}
                                </a>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded font-mono font-bold bg-slate-100 text-teal-700 border border-slate-200">
                                    {{ $soc->society_code }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-600">{{ $soc->city }}, {{ $soc->state }}</td>
                            <td class="py-3 px-4 text-slate-700 font-medium">{{ $soc->properties_count }} Flats</td>
                            <td class="py-3 px-4 text-slate-700 font-medium">{{ $soc->members_count }} Users</td>
                            <td class="py-3 px-4">
                                @if($soc->status === 'active')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-100 text-emerald-800">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-red-100 text-red-800">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right space-x-2">
                                <a href="{{ route('admin.societies.show', $soc) }}" class="text-teal-600 hover:text-teal-800 font-semibold">
                                    Manage
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-6 text-center text-slate-500">No societies onboarded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
