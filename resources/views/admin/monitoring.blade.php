@extends('layouts.admin')

@section('title', 'Global Monitoring')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Global Society Monitoring</h1>
            <p class="text-xs text-slate-500 mt-1">Cross-society complaint resolution metrics and resident engagement</p>
        </div>
    </div>

    <!-- Society Health Table -->
    <div class="card overflow-hidden">
        <div class="p-4 border-b border-slate-200">
            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Tenant Health & Complaint Overview</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 font-semibold border-b border-slate-200 uppercase">
                        <th class="py-3 px-4">Society</th>
                        <th class="py-3 px-4">Flats</th>
                        <th class="py-3 px-4">Registered Users</th>
                        <th class="py-3 px-4">Notices</th>
                        <th class="py-3 px-4 text-center">Pending Complaints</th>
                        <th class="py-3 px-4 text-center">In Progress</th>
                        <th class="py-3 px-4 text-center">Resolved</th>
                        <th class="py-3 px-4 text-right">Total Issues</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($societies as $soc)
                        <tr class="hover:bg-slate-50">
                            <td class="py-3.5 px-4">
                                <a href="{{ route('admin.societies.show', $soc) }}" class="font-bold text-slate-900 hover:text-teal-600 block">
                                    {{ $soc->name }}
                                </a>
                                <span class="font-mono text-[11px] text-teal-700 font-semibold">{{ $soc->society_code }}</span>
                            </td>
                            <td class="py-3.5 px-4 font-medium">{{ $soc->properties_count }}</td>
                            <td class="py-3.5 px-4 font-medium">{{ $soc->members_count }}</td>
                            <td class="py-3.5 px-4 font-medium">{{ $soc->newsletters_count }}</td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                    {{ $soc->pending_complaints_count }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">
                                    {{ $soc->in_progress_complaints_count }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                    {{ $soc->resolved_complaints_count }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right font-bold text-slate-900">
                                {{ $soc->complaints_count }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-6 text-center text-slate-500">No society records available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Complaints Across Platform -->
    <div class="card overflow-hidden">
        <div class="p-4 border-b border-slate-200">
            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Live Global Complaint Stream</h2>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse($recentComplaints as $comp)
                <div class="p-4 flex items-start justify-between hover:bg-slate-50 transition text-xs">
                    <div class="space-y-1">
                        <div class="flex items-center space-x-2">
                            <span class="font-semibold text-slate-900">{{ $comp->title }}</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-slate-100 text-slate-600">
                                {{ $comp->society->name ?? 'Society' }}
                            </span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-semibold
                                @if($comp->status === 'Pending') badge-pending
                                @elseif($comp->status === 'In Progress') badge-in_progress
                                @elseif($comp->status === 'Resolved') badge-resolved
                                @else badge-rejected @endif">
                                {{ $comp->status }}
                            </span>
                        </div>
                        <p class="text-slate-600 line-clamp-1">{{ $comp->description }}</p>
                        <div class="text-[11px] text-slate-400">
                            By {{ $comp->submitter->name ?? 'Resident' }} ({{ str_replace('_', ' ', $comp->submitter_role) }}) &bull; {{ $comp->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-slate-500 text-xs">No recent complaints filed.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
