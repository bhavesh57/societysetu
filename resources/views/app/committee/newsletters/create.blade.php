@extends('layouts.app')

@section('title', 'Compose Notice')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-base font-bold text-slate-900 tracking-tight">Compose Circular</h2>
            <p class="text-[11px] text-slate-500">Target notices to owners or tenants</p>
        </div>
        <a href="{{ route('committee.newsletters.index') }}" class="btn-secondary px-3 py-1 text-xs">
            &larr; Back
        </a>
    </div>

    <div class="card p-4 bg-white">
        @if($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-800 text-xs">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('committee.newsletters.store') }}" enctype="multipart/form-data" class="space-y-3">
            @csrf

            <div>
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Notice Title <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g. Lift Servicing / AGM Notice" required
                       class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs focus:ring-2 focus:ring-teal-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Target Audience <span class="text-red-500">*</span>
                </label>
                <select name="target_audience" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-semibold focus:ring-2 focus:ring-teal-500 focus:outline-none">
                    <option value="both">Both (All Society Residents)</option>
                    <option value="owners_only">House Owners Only (Hidden from Tenants)</option>
                    <option value="tenants_only">Tenants Only (Hidden from Owners)</option>
                </select>
                <span class="text-[10px] text-slate-400 mt-1 block">
                    Recipients will be automatically filtered and assigned based on this selection.
                </span>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Notice Content <span class="text-red-500">*</span>
                </label>
                <textarea name="content" rows="5" required placeholder="Write the full announcement details here..."
                          class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs focus:ring-2 focus:ring-teal-500 focus:outline-none">{{ old('content') }}</textarea>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Attachment (PDF / Image)
                </label>
                <input type="file" name="attachment" accept=".pdf,image/*"
                       class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
            </div>

            <div class="pt-3">
                <button type="submit" class="btn-primary w-full py-2.5 text-xs font-bold shadow-sm">
                    Publish &amp; Dispatch to Recipients
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
