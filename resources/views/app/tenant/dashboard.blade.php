@extends('layouts.app')

@section('title', 'Tenant Dashboard')

@section('content')
<div class="space-y-4">
    <!-- Welcome Header -->
    <div class="card p-4 bg-gradient-to-r from-teal-700 to-teal-800 text-white shadow-sm border-0">
        <span class="text-[11px] font-semibold text-teal-200 uppercase tracking-wider block">Resident Tenant Portal</span>
        <h2 class="text-lg font-bold mt-0.5">Welcome, {{ Auth::user()->name }}!</h2>
        <p class="text-xs text-teal-100 mt-1">Access rented unit information, landlord contact, announcements, and lodge issues.</p>
    </div>

    <!-- Rented Property & Landlord Cards -->
    @if($tenancy)
        <div class="card p-3.5 space-y-3">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[10px] font-bold uppercase text-slate-400">Rented Unit</span>
                    <h3 class="text-sm font-black text-slate-900">{{ $tenancy->property->full_identifier }}</h3>
                    <span class="text-[11px] text-slate-500">{{ $tenancy->property->property_type }}</span>
                </div>
                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800">
                    Active Lease
                </span>
            </div>

            <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-xs">
                <div>
                    <span class="text-[10px] text-slate-400 block font-semibold">Landlord / Owner:</span>
                    <span class="font-bold text-slate-800">{{ $tenancy->owner->name ?? 'Owner' }}</span>
                </div>
                <div class="text-right">
                    <span class="text-[10px] text-slate-400 block font-semibold">Contact:</span>
                    <span class="font-mono text-teal-700 font-bold">{{ $tenancy->owner->mobile ?? 'Contact office' }}</span>
                </div>
            </div>
        </div>
    @endif

    <!-- Complaint Stats & Quick Action -->
    <div class="card p-3.5 bg-white">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-bold text-slate-800 uppercase tracking-wider">My Maintenance Requests</span>
            <a href="{{ route('tenant.complaints.create') }}" class="btn-primary px-3 py-1 text-[11px] font-bold">
                + Raise Request
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
                <span class="text-[10px] text-blue-700">In Work</span>
            </div>
            <div class="p-2 rounded bg-emerald-50 border border-emerald-100">
                <span class="text-base font-bold text-emerald-800 block">{{ $complaintStats['resolved'] }}</span>
                <span class="text-[10px] text-emerald-700">Done</span>
            </div>
        </div>
    </div>

    <!-- Tenant Targeted Newsletters -->
    <div class="card overflow-hidden">
        <div class="p-3 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Tenant Bulletins</h3>
            <a href="{{ route('tenant.newsletters.index') }}" class="text-[11px] text-teal-600 font-bold hover:underline">
                View All
            </a>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($newsletters as $nl)
                <a href="{{ route('tenant.newsletters.show', $nl) }}" class="p-3 block hover:bg-slate-50 transition">
                    <div class="flex items-center justify-between mb-1">
                        <span class="font-bold text-xs text-slate-900 truncate max-w-[200px]">{{ $nl->title }}</span>
                        <span class="text-[10px] text-slate-400">{{ $nl->published_at ? $nl->published_at->diffForHumans() : 'Recent' }}</span>
                    </div>
                    <p class="text-[11px] text-slate-600 line-clamp-2">{{ $nl->content }}</p>
                </a>
            @empty
                <div class="p-4 text-center text-xs text-slate-400">
                    No active bulletins for tenants.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
