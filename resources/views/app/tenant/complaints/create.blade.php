@extends('layouts.app')

@section('title', 'Raise Request')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-base font-bold text-slate-900 tracking-tight">Raise Maintenance Request</h2>
            <p class="text-[11px] text-slate-500">Report an issue regarding your rented unit</p>
        </div>
        <a href="{{ route('tenant.complaints.index') }}" class="btn-secondary px-3 py-1 text-xs">
            &larr; Back
        </a>
    </div>

    <div class="card p-4 bg-white">
        @if($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-800 text-xs">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('tenant.complaints.store') }}" enctype="multipart/form-data" class="space-y-3 text-xs">
            @csrf

            @if($tenancy)
                <input type="hidden" name="property_id" value="{{ $tenancy->property_id }}">
                <div class="p-2.5 rounded bg-blue-50/60 border border-blue-100 text-blue-900">
                    <span class="text-[10px] text-blue-600 font-bold uppercase block">Rented Unit</span>
                    <span class="font-bold text-xs">{{ $tenancy->property->full_identifier }}</span>
                </div>
            @endif

            <div>
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Category <span class="text-red-500">*</span>
                </label>
                <select name="category_id" required class="w-full px-3 py-2 rounded-lg border border-slate-300">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Request Title <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g. Water seepage / Intercom not working" required
                       class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs">
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Detailed Description <span class="text-red-500">*</span>
                </label>
                <textarea name="description" rows="4" required placeholder="Please provide specific details..."
                          class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Priority <span class="text-red-500">*</span>
                </label>
                <select name="priority" class="w-full px-3 py-2 rounded-lg border border-slate-300">
                    <option value="low">Low</option>
                    <option value="medium" selected>Medium</option>
                    <option value="high">High (Urgent)</option>
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Photo Proof (Optional)
                </label>
                <input type="file" name="photo" accept="image/*"
                       class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-700">
            </div>

            <div class="pt-2">
                <button type="submit" class="btn-primary w-full py-2.5 text-xs font-bold shadow-sm">
                    Submit Request to Committee
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
