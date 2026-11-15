@extends('layouts.app')

@section('title', 'My Complaints')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-base font-bold text-slate-900 tracking-tight">My Complaints</h2>
            <p class="text-[11px] text-slate-500">Service requests for your rented unit</p>
        </div>
        <a href="{{ route('tenant.complaints.create') }}" class="btn-primary px-3 py-1.5 text-xs font-semibold shadow-xs">
            + Raise Request
        </a>
    </div>

    <!-- Complaints Cards -->
    <div class="space-y-3">
        @forelse($complaints as $c)
            <a href="{{ route('tenant.complaints.show', $c) }}" class="card p-3.5 block hover:border-teal-400 transition space-y-2">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-xs font-bold text-slate-900">{{ $c->title }}</h3>
                        <span class="text-[10px] text-slate-400">
                            Unit: {{ $c->property->full_identifier ?? 'General' }} &bull; {{ $c->category->name ?? 'General' }}
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
                    <span>{{ $c->created_at->diffForHumans() }}</span>
                    <span class="text-teal-700 font-semibold">{{ $c->comments->count() }} Remark(s) &rarr;</span>
                </div>
            </a>
        @empty
            <div class="card p-6 text-center text-xs text-slate-400">
                No maintenance complaints lodged. Use "+ Raise Request" to notify the society committee.
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
