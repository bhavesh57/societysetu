@extends('layouts.app')

@section('title', 'Complaint #' . $complaint->id)

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-base font-bold text-slate-900 tracking-tight">Complaint #{{ $complaint->id }}</h2>
            <p class="text-[11px] text-slate-500">Lodged on {{ $complaint->created_at->format('d M Y, h:i A') }}</p>
        </div>
        <a href="{{ route('committee.complaints.index') }}" class="btn-secondary px-3 py-1 text-xs">
            &larr; Back
        </a>
    </div>

    <!-- Complaint Info Card -->
    <div class="card p-4 space-y-3">
        <div class="flex items-start justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-900">{{ $complaint->title }}</h3>
                <span class="text-[11px] text-slate-500">
                    Category: <strong>{{ $complaint->category->name ?? 'General' }}</strong> &bull; Priority: <span class="capitalize font-semibold text-slate-800">{{ $complaint->priority }}</span>
                </span>
            </div>
            <span class="px-2.5 py-1 rounded text-xs font-bold
                @if($complaint->status === 'Pending') badge-pending
                @elseif($complaint->status === 'In Progress') badge-in_progress
                @elseif($complaint->status === 'Resolved') badge-resolved
                @else badge-rejected @endif">
                {{ $complaint->status }}
            </span>
        </div>

        <div class="p-3 rounded-lg bg-slate-50 border border-slate-100 text-xs text-slate-700 whitespace-pre-line leading-relaxed">
            {{ $complaint->description }}
        </div>

        @if($complaint->photo_path)
            <div class="pt-2">
                <span class="text-[11px] font-bold text-slate-600 block mb-1">Attached Photo:</span>
                <img src="{{ asset('storage/' . $complaint->photo_path) }}" alt="Complaint Photo" class="rounded-lg max-h-56 object-cover border border-slate-200">
            </div>
        @endif

        <div class="pt-3 border-t border-slate-100 grid grid-cols-2 gap-2 text-[11px]">
            <div>
                <span class="text-slate-400 block">Reported By:</span>
                <span class="font-bold text-slate-800">{{ $complaint->submitter->name ?? 'Resident' }}</span>
                <span class="text-slate-500 block">Role: {{ str_replace('_', ' ', $complaint->submitter_role) }}</span>
            </div>
            <div>
                <span class="text-slate-400 block">Housing Unit:</span>
                <span class="font-bold text-slate-800">{{ $complaint->property->full_identifier ?? 'General Society' }}</span>
            </div>
        </div>
    </div>

    <!-- Status Update & Remarks Action Box -->
    <div class="card p-4 bg-teal-50/50 border border-teal-200">
        <h3 class="text-xs font-bold text-teal-900 uppercase tracking-wider mb-2">Update Status &amp; Post Remark</h3>
        <form method="POST" action="{{ route('committee.complaints.update_status', $complaint) }}" class="space-y-3">
            @csrf
            <div>
                <label class="block text-[11px] font-semibold text-slate-700 mb-1">Status</label>
                <select name="status" required class="w-full px-3 py-1.5 rounded border border-slate-300 text-xs font-bold bg-white focus:ring-2 focus:ring-teal-500">
                    <option value="Pending" {{ $complaint->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="In Progress" {{ $complaint->status === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="Resolved" {{ $complaint->status === 'Resolved' ? 'selected' : '' }}>Resolved</option>
                    <option value="Rejected" {{ $complaint->status === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-semibold text-slate-700 mb-1">Official Committee Remark</label>
                <textarea name="remark" rows="3" required placeholder="Add resolution note, vendor assigned, or feedback for resident..."
                          class="w-full px-3 py-1.5 rounded border border-slate-300 text-xs bg-white focus:ring-2 focus:ring-teal-500"></textarea>
            </div>

            <button type="submit" class="btn-primary w-full py-2 text-xs font-bold shadow-xs">
                Post Remark &amp; Update
            </button>
        </form>
    </div>

    <!-- Timeline of Remarks -->
    <div class="card p-4 space-y-3">
        <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Remarks &amp; Activity Timeline</h3>
        <div class="divide-y divide-slate-100">
            @forelse($complaint->comments as $cm)
                <div class="py-2.5 text-xs space-y-1">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-slate-800">{{ $cm->user->name ?? 'User' }}</span>
                        <span class="text-[10px] text-slate-400">{{ $cm->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-slate-600">{{ $cm->remark }}</p>
                    @if($cm->status_changed_to)
                        <span class="inline-block text-[10px] font-semibold text-teal-700 bg-teal-50 px-1.5 py-0.5 rounded border border-teal-100">
                            Status changed to: {{ $cm->status_changed_to }}
                        </span>
                    @endif
                </div>
            @empty
                <div class="py-3 text-center text-xs text-slate-400">No committee remarks yet.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
