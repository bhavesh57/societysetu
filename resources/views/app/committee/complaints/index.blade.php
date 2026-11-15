@extends('layouts.app')

@section('title', 'Society Complaints')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-base font-bold text-slate-900 tracking-tight">Society Complaints</h2>
            <p class="text-[11px] text-slate-500">Track and resolve resident issues</p>
        </div>
    </div>

    <!-- Filter Pills -->
    <div class="flex items-center space-x-1.5 overflow-x-auto pb-1 text-xs">
        <a href="{{ route('committee.complaints.index') }}"
           class="px-3 py-1 rounded-full font-semibold whitespace-nowrap {{ !request('status') ? 'bg-slate-800 text-white' : 'bg-slate-200 text-slate-700' }}">
            All
        </a>
        <a href="{{ route('committee.complaints.index', ['status' => 'Pending']) }}"
           class="px-3 py-1 rounded-full font-semibold whitespace-nowrap {{ request('status') === 'Pending' ? 'bg-amber-600 text-white' : 'bg-amber-100 text-amber-800' }}">
            Pending
        </a>
        <a href="{{ route('committee.complaints.index', ['status' => 'In Progress']) }}"
           class="px-3 py-1 rounded-full font-semibold whitespace-nowrap {{ request('status') === 'In Progress' ? 'bg-blue-600 text-white' : 'bg-blue-100 text-blue-800' }}">
            In Progress
        </a>
        <a href="{{ route('committee.complaints.index', ['status' => 'Resolved']) }}"
           class="px-3 py-1 rounded-full font-semibold whitespace-nowrap {{ request('status') === 'Resolved' ? 'bg-emerald-600 text-white' : 'bg-emerald-100 text-emerald-800' }}">
            Resolved
        </a>
    </div>

    <!-- Complaints Cards -->
    <div class="space-y-3">
        @forelse($complaints as $c)
            <a href="{{ route('committee.complaints.show', $c) }}" class="card p-3.5 block hover:border-teal-400 transition space-y-2">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-xs font-bold text-slate-900">{{ $c->title }}</h3>
                        <span class="text-[10px] text-slate-400">
                            Unit: <strong>{{ $c->property->full_identifier ?? 'General' }}</strong> &bull; Category: {{ $c->category->name ?? 'General' }}
                        </span>
                    </div>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold
                        @if($c->status === 'Pending') badge-pending
                        @elseif($c->status === 'In Progress') badge-in_progress
                        @elseif($c->status === 'Resolved') badge-resolved
                        @else badge-rejected @endif">
                        {{ $c->status }}
                    </span>
                </div>

                <p class="text-xs text-slate-600 line-clamp-2">{{ $c->description }}</p>

                <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                    <span>By: {{ $c->submitter->name ?? 'User' }} ({{ str_replace('_', ' ', $c->submitter_role) }})</span>
                    <span class="text-teal-700 font-semibold">Review &rarr;</span>
                </div>
            </a>
        @empty
            <div class="card p-6 text-center text-xs text-slate-400">
                No complaints found in this category/status.
            </div>
        @endforelse
    </div>

    @if($complaints->hasPages())
        <div class="pt-2">
            {{ $complaints->links() }}
        </div>
    @endif
</div>
@endsection
