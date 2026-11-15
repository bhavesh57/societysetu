@extends('layouts.app')

@section('title', 'Society Notices')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-base font-bold text-slate-900 tracking-tight">Society Notices</h2>
            <p class="text-[11px] text-slate-500">Targeted circulars &amp; broadcast updates</p>
        </div>
        <a href="{{ route('committee.newsletters.create') }}" class="btn-primary px-3 py-1.5 text-xs font-semibold shadow-xs">
            + Compose
        </a>
    </div>

    <!-- Notices Stream -->
    <div class="space-y-3">
        @forelse($newsletters as $nl)
            <div class="card p-4 space-y-2">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-xs font-bold text-slate-900">{{ $nl->title }}</h3>
                        <span class="text-[10px] text-slate-400">
                            By {{ $nl->author->name ?? 'Committee' }} &bull; {{ $nl->published_at ? $nl->published_at->format('d M Y, h:i A') : 'Draft' }}
                        </span>
                    </div>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase
                        @if($nl->target_audience === 'owners_only') bg-purple-100 text-purple-800
                        @elseif($nl->target_audience === 'tenants_only') bg-amber-100 text-amber-800
                        @else bg-teal-100 text-teal-800 @endif">
                        {{ str_replace('_', ' ', $nl->target_audience) }}
                    </span>
                </div>

                <p class="text-xs text-slate-600 line-clamp-3 whitespace-pre-line">{{ $nl->content }}</p>

                @if($nl->attachment_path)
                    <div class="pt-2">
                        <a href="{{ asset('storage/' . $nl->attachment_path') }}" target="_blank"
                           class="inline-flex items-center text-[11px] text-teal-700 font-semibold hover:underline">
                            📎 View Attached Document
                        </a>
                    </div>
                @endif

                <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                    <span>Recipients: <strong>{{ $nl->recipients_count }}</strong> residents</span>
                    <span class="text-emerald-600 font-semibold">&check; Published</span>
                </div>
            </div>
        @empty
            <div class="card p-6 text-center text-xs text-slate-400">
                No notices published yet. Use "+ Compose" to send your first broadcast.
            </div>
        @endforelse
    </div>

    @if($newsletters->hasPages())
        <div class="pt-2">
            {{ $newsletters->links() }}
        </div>
    @endif
</div>
@endsection
