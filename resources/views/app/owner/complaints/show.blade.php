@extends('layouts.app')

@section('title', 'Complaint #' . $complaint->id)

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <a href="{{ route('owner.complaints.index') }}" class="btn-secondary px-3 py-1 text-xs">
            &larr; Back to Complaints
        </a>
        <span class="px-2.5 py-1 rounded text-xs font-bold
            @if($complaint->status === 'Pending') badge-pending
            @elseif($complaint->status === 'In Progress') badge-in_progress
            @elseif($complaint->status === 'Resolved') badge-resolved
            @else badge-rejected @endif">
            {{ $complaint->status }}
        </span>
    </div>

    <!-- Complaint Info -->
    <div class="card p-4 space-y-3 bg-white">
        <div>
            <span class="text-[10px] text-teal-700 font-bold uppercase">{{ $complaint->category->name ?? 'General' }}</span>
            <h2 class="text-base font-bold text-slate-900 mt-0.5">{{ $complaint->title }}</h2>
            <div class="text-[11px] text-slate-400 mt-0.5">
                Lodged on {{ $complaint->created_at->format('d M Y, h:i A') }} &bull; Unit: {{ $complaint->property->full_identifier ?? 'General' }}
            </div>
        </div>

        <div class="p-3 rounded-lg bg-slate-50 border border-slate-100 text-xs text-slate-700 leading-relaxed whitespace-pre-line">
            {{ $complaint->description }}
        </div>

        @if($complaint->photo_path)
            <div>
                <img src="{{ asset('storage/' . $complaint->photo_path) }}" alt="Photo" class="rounded-lg max-h-48 object-cover border border-slate-200">
            </div>
        @endif
    </div>

    <!-- Committee Activity Timeline -->
    <div class="card p-4 space-y-3 bg-white">
        <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Committee Responses</h3>
        <div class="divide-y divide-slate-100">
            @forelse($complaint->comments as $cm)
                <div class="py-2.5 text-xs space-y-1">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-teal-800">{{ $cm->user->name ?? 'Committee' }}</span>
                        <span class="text-[10px] text-slate-400">{{ $cm->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-slate-600">{{ $cm->remark }}</p>
                    @if($cm->status_changed_to)
                        <span class="inline-block text-[10px] font-semibold text-teal-700 bg-teal-50 px-1.5 py-0.5 rounded border border-teal-100">
                            Status: {{ $cm->status_changed_to }}
                        </span>
                    @endif
                </div>
            @empty
                <div class="py-4 text-center text-xs text-slate-400">
                    Awaiting committee review. Remarks will appear here once attended.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
