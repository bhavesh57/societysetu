@extends('layouts.app')

@section('title', $newsletter->title)

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <a href="{{ route('tenant.newsletters.index') }}" class="btn-secondary px-3 py-1 text-xs">
            &larr; Back to Bulletins
        </a>
        <span class="text-[11px] text-slate-400">
            {{ $newsletter->published_at ? $newsletter->published_at->format('d M Y, h:i A') : '' }}
        </span>
    </div>

    <div class="card p-4 space-y-3 bg-white">
        <div>
            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-amber-100 text-amber-800">
                {{ str_replace('_', ' ', $newsletter->target_audience) }}
            </span>
            <h2 class="text-base font-bold text-slate-900 mt-2">{{ $newsletter->title }}</h2>
            <div class="text-[11px] text-slate-400 mt-0.5">
                From: Society Managing Committee
            </div>
        </div>

        <div class="text-xs text-slate-700 leading-relaxed whitespace-pre-line border-t border-slate-100 pt-3">
            {{ $newsletter->content }}
        </div>

        @if($newsletter->attachment_path)
            <div class="pt-3 border-t border-slate-100">
                <a href="{{ asset('storage/' . $newsletter->attachment_path) }}" target="_blank"
                   class="btn-primary w-full py-2 text-xs font-semibold text-center block">
                    📎 Download / View Attachment
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
