@extends('layouts.app')

@section('title', 'Add Property')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-base font-bold text-slate-900 tracking-tight">Add Unit / Flat</h2>
            <p class="text-[11px] text-slate-500">Register a new housing unit in this society</p>
        </div>
        <a href="{{ route('committee.properties.index') }}" class="btn-secondary px-3 py-1 text-xs">
            &larr; Back
        </a>
    </div>

    <div class="card p-4 bg-white">
        @if($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-800 text-xs">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('committee.properties.store') }}" class="space-y-3">
            @csrf

            <div>
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Wing / Block <span class="text-red-500">*</span>
                </label>
                <input type="text" name="wing_or_block" value="{{ old('wing_or_block') }}" placeholder="e.g. Wing A, Block B, Tower 1" required
                       class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs focus:ring-2 focus:ring-teal-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Unit / House Number <span class="text-red-500">*</span>
                </label>
                <input type="text" name="house_number" value="{{ old('house_number') }}" placeholder="e.g. 101, 402, Villa 5" required
                       class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs focus:ring-2 focus:ring-teal-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Property Type <span class="text-red-500">*</span>
                </label>
                <select name="property_type" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs focus:ring-2 focus:ring-teal-500 focus:outline-none">
                    <option value="Flat">Flat</option>
                    <option value="Villa">Villa</option>
                    <option value="Tenament">Tenament</option>
                    <option value="Shop">Shop / Commercial</option>
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Initial Occupancy Status <span class="text-red-500">*</span>
                </label>
                <select name="occupancy_status" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs focus:ring-2 focus:ring-teal-500 focus:outline-none">
                    <option value="vacant">Vacant</option>
                    <option value="owner_occupied">Owner Occupied</option>
                    <option value="rented">Rented</option>
                </select>
            </div>

            <div class="pt-3">
                <button type="submit" class="btn-primary w-full py-2.5 text-xs font-bold">
                    Save Property
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
