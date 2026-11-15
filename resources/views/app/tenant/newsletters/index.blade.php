@extends('layouts.app')

@section('title', 'Tenant Bulletins')

@section('content')
<div class="space-y-4">
    <div>
        <h2 class="text-base font-bold text-slate-900 tracking-tight">Tenant Bulletins</h2>
        <p class="text-[11px] text-slate-500">Notices relevant to tenants and general society updates</p>
    </div>

    <div class="space-y-3">
        @forelse($newsletters as $nl)
            <a href="{{ route('tenant.newsletters.show', $nl) }}" class="card p-3.5 block hover:border-teal-400 transition space-y-1.5">
                <div class="flex items-start justify-between">
                    <h3 class="text-xs font-bold text-slate-900">{{ $nl->title }}</h3>
                    <span class="text-[10px] text-slate-400 whitespace-nowrap ml-2">
                        {{ $nl->published_at ? $nl->published_at->format('d M') : '' }}
                    </span>
                </div>
                <p class="text-xs text-slate-600 line-clamp-2">{{ $nl->content }}</p>
                <div class="text-[10px] text-teal-600 font-semibold pt-1">
                    Read bulletin &rarr;
                </div>
            </a>
        @empty
            <div class="card p-6 text-center text-xs text-slate-400">
                No active bulletins for tenants.
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
