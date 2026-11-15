@extends('layouts.app')

@section('title', 'Owner Dashboard')

@section('content')
<div class="space-y-4">
    <!-- Welcome Header -->
    <div class="card p-4 bg-gradient-to-r from-teal-700 to-teal-800 text-white shadow-sm border-0">
        <span class="text-[11px] font-semibold text-teal-200 uppercase tracking-wider block">House Owner Portal</span>
        <h2 class="text-lg font-bold mt-0.5">Welcome, {{ Auth::user()->name }}!</h2>
        <p class="text-xs text-teal-100 mt-1">Manage owned properties, tenant leases, complaints, and society notices.</p>
    </div>

    <!-- My Properties Cards -->
    <div class="space-y-2">
        <div class="flex items-center justify-between">
            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">My Properties</h3>
            <span class="text-teal-600 font-mono text-xs font-bold">{{ $ownedProperties->count() }} Owned</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
            @forelse($ownedProperties as $prop)
                <div class="card p-3.5 space-y-2">
                    <div class="flex items-start justify-between">
                        <div>
                            <span class="text-xs font-bold text-slate-900">{{ $prop->full_identifier }}</span>
                            <span class="text-[10px] text-slate-400 block">{{ $prop->property_type }}</span>
                        </div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold capitalize
                            @if($prop->occupancy_status === 'owner_occupied') bg-emerald-100 text-emerald-800
                            @elseif($prop->occupancy_status === 'rented') bg-blue-100 text-blue-800
                            @else bg-slate-100 text-slate-600 @endif">
                            {{ str_replace('_', ' ', $prop->occupancy_status) }}
                        </span>
                    </div>

                    @if($prop->occupancy_status === 'rented' && $prop->currentTenant)
                        <div class="p-2 rounded bg-blue-50/60 border border-blue-100 text-[11px] text-blue-900 flex items-center justify-between">
                            <div>
                                <span class="font-bold block">Tenant: {{ $prop->currentTenant->tenantUser->name ?? 'Occupant' }}</span>
                                <span class="text-[10px] text-slate-500 font-mono">{{ $prop->currentTenant->tenantUser->mobile ?? '-' }}</span>
                            </div>
                            <a href="{{ route('owner.tenants.index') }}" class="text-[10px] font-bold text-blue-700 hover:underline">
                                Details &rarr;
                            </a>
                        </div>
                    @elseif($prop->occupancy_status === 'vacant')
                        <div class="text-[11px] text-slate-400">
                            Unit is vacant. <a href="{{ route('owner.tenants.index') }}" class="text-teal-600 font-bold hover:underline">+ Add Tenant</a>
                        </div>
                    @endif
                </div>
            @empty
                <div class="card p-4 text-center text-xs text-slate-400 col-span-2">
                    No properties linked to your account yet. Contact Committee.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Quick Action / Complaint Status Box -->
    <div class="card p-3.5 bg-white">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-bold text-slate-800 uppercase tracking-wider">My Complaints</span>
            <a href="{{ route('owner.complaints.create') }}" class="btn-primary px-3 py-1 text-[11px] font-bold">
                + New Complaint
            </a>
        </div>

        <div class="grid grid-cols-4 gap-2 text-center text-xs">
            <div class="p-2 rounded bg-slate-50 border border-slate-100">
                <span class="text-base font-bold text-slate-800 block">{{ $complaintStats['total'] }}</span>
                <span class="text-[10px] text-slate-500">Total</span>
            </div>
            <div class="p-2 rounded bg-amber-50 border border-amber-100">
                <span class="text-base font-bold text-amber-800 block">{{ $complaintStats['pending'] }}</span>
                <span class="text-[10px] text-amber-700">Pending</span>
            </div>
            <div class="p-2 rounded bg-blue-50 border border-blue-100">
                <span class="text-base font-bold text-blue-800 block">{{ $complaintStats['in_progress'] }}</span>
                <span class="text-[10px] text-blue-700">Progress</span>
            </div>
            <div class="p-2 rounded bg-emerald-50 border border-emerald-100">
                <span class="text-base font-bold text-emerald-800 block">{{ $complaintStats['resolved'] }}</span>
                <span class="text-[10px] text-emerald-700">Resolved</span>
            </div>
        </div>
    </div>

    <!-- Latest Owner Notices -->
    <div class="card overflow-hidden">
        <div class="p-3 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Owner Announcements</h3>
            <a href="{{ route('owner.newsletters.index') }}" class="text-[11px] text-teal-600 font-bold hover:underline">
                View All
            </a>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($newsletters as $nl)
                <a href="{{ route('owner.newsletters.show', $nl) }}" class="p-3 block hover:bg-slate-50 transition">
                    <div class="flex items-center justify-between mb-1">
                        <span class="font-bold text-xs text-slate-900 truncate max-w-[200px]">{{ $nl->title }}</span>
                        <span class="text-[10px] text-slate-400">{{ $nl->published_at ? $nl->published_at->diffForHumans() : 'Recent' }}</span>
                    </div>
                    <p class="text-[11px] text-slate-600 line-clamp-2">{{ $nl->content }}</p>
                </a>
            @empty
                <div class="p-4 text-center text-xs text-slate-400">
                    No active announcements for owners.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
