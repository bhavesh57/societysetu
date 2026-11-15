@extends('layouts.app')

@section('title', 'Committee Dashboard')

@section('content')
<div class="space-y-4">
    <!-- Welcome greeting -->
    <div class="card p-4 bg-gradient-to-r from-teal-700 to-teal-800 text-white shadow-sm border-0">
        <span class="text-[11px] font-semibold text-teal-200 uppercase tracking-wider block">Managing Committee Portal</span>
        <h2 class="text-lg font-bold mt-0.5">Welcome, {{ Auth::user()->name }}!</h2>
        <p class="text-xs text-teal-100 mt-1">Directly oversee housing units, resident directories, broadcast notices, and complaints.</p>
    </div>

    <!-- Metrics Grid -->
    <div class="grid grid-cols-2 gap-3">
        <!-- Houses -->
        <a href="{{ route('committee.properties.index') }}" class="card p-3.5 hover:border-teal-400 transition block">
            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Total Units</span>
            <div class="text-2xl font-black text-slate-900 mt-1">{{ $totalHouses }}</div>
            <span class="text-[10px] text-teal-600 font-semibold mt-0.5 block">View properties &rarr;</span>
        </a>

        <!-- Owners -->
        <a href="{{ route('committee.members.directory') }}" class="card p-3.5 hover:border-teal-400 transition block">
            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">House Owners</span>
            <div class="text-2xl font-black text-slate-900 mt-1">{{ $totalOwners }}</div>
            <span class="text-[10px] text-teal-600 font-semibold mt-0.5 block">Owner directory &rarr;</span>
        </a>

        <!-- Tenants -->
        <a href="{{ route('committee.members.directory') }}" class="card p-3.5 hover:border-teal-400 transition block">
            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Rental Tenants</span>
            <div class="text-2xl font-black text-slate-900 mt-1">{{ $totalTenants }}</div>
            <span class="text-[10px] text-teal-600 font-semibold mt-0.5 block">Tenant directory &rarr;</span>
        </a>

        <!-- Pending Complaints -->
        <a href="{{ route('committee.complaints.index', ['status' => 'Pending']) }}" class="card p-3.5 hover:border-amber-400 transition block bg-amber-50/40 border-amber-200">
            <span class="text-[10px] font-bold uppercase tracking-wider text-amber-800">Pending Complaints</span>
            <div class="text-2xl font-black text-amber-900 mt-1">{{ $pendingComplaintsCount }}</div>
            <span class="text-[10px] text-amber-700 font-semibold mt-0.5 block">Action needed &rarr;</span>
        </a>
    </div>

    <!-- Quick Action Buttons -->
    <div class="card p-3">
        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block mb-2.5">Quick Actions</span>
        <div class="grid grid-cols-3 gap-2">
            <a href="{{ route('committee.newsletters.create') }}" class="p-2.5 text-center rounded-lg bg-teal-50 border border-teal-200 text-teal-800 hover:bg-teal-100 transition">
                <span class="text-lg block">📢</span>
                <span class="text-[10px] font-bold block mt-1">Publish Notice</span>
            </a>
            <a href="{{ route('committee.properties.create') }}" class="p-2.5 text-center rounded-lg bg-blue-50 border border-blue-200 text-blue-800 hover:bg-blue-100 transition">
                <span class="text-lg block">🏢</span>
                <span class="text-[10px] font-bold block mt-1">Add House</span>
            </a>
            <a href="{{ route('committee.members.directory') }}" class="p-2.5 text-center rounded-lg bg-indigo-50 border border-indigo-200 text-indigo-800 hover:bg-indigo-100 transition">
                <span class="text-lg block">👤</span>
                <span class="text-[10px] font-bold block mt-1">Link Resident</span>
            </a>
        </div>
    </div>

    <!-- Recent Complaints List -->
    <div class="card overflow-hidden">
        <div class="p-3 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Recent Complaints</h3>
            <a href="{{ route('committee.complaints.index') }}" class="text-[11px] text-teal-600 font-bold hover:underline">
                View All
            </a>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($recentComplaints as $c)
                <a href="{{ route('committee.complaints.show', $c) }}" class="p-3 block hover:bg-slate-50 transition">
                    <div class="flex items-center justify-between mb-1">
                        <span class="font-bold text-xs text-slate-900 truncate max-w-[200px]">{{ $c->title }}</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold
                            @if($c->status === 'Pending') badge-pending
                            @elseif($c->status === 'In Progress') badge-in_progress
                            @elseif($c->status === 'Resolved') badge-resolved
                            @else badge-rejected @endif">
                            {{ $c->status }}
                        </span>
                    </div>
                    <div class="flex items-center space-x-2 text-[11px] text-slate-500">
                        <span>{{ $c->category->name ?? 'General' }}</span>
                        <span>&bull;</span>
                        <span>Unit: {{ $c->property->full_identifier ?? 'General' }}</span>
                        <span>&bull;</span>
                        <span>{{ $c->created_at->diffForHumans() }}</span>
                    </div>
                </a>
            @empty
                <div class="p-4 text-center text-xs text-slate-400">
                    No complaints registered. All systems operational!
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
