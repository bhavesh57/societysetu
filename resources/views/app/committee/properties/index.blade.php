@extends('layouts.app')

@section('title', 'Manage Properties')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-base font-bold text-slate-900 tracking-tight">Society Properties</h2>
            <p class="text-[11px] text-slate-500">Inventory of flats, villas, and shops</p>
        </div>
        <a href="{{ route('committee.properties.create') }}" class="btn-primary px-3 py-1.5 text-xs font-semibold shadow-xs">
            + Add Unit
        </a>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('committee.properties.index') }}" class="flex gap-2">
        <input type="text" name="wing" value="{{ request('wing') }}" placeholder="Filter wing/block..."
               class="flex-1 px-3 py-1.5 rounded-lg border border-slate-300 text-xs focus:ring-2 focus:ring-teal-500 focus:outline-none">
        <select name="status" class="px-2 py-1.5 rounded-lg border border-slate-300 text-xs focus:ring-2 focus:ring-teal-500 focus:outline-none">
            <option value="">All</option>
            <option value="owner_occupied" {{ request('status') === 'owner_occupied' ? 'selected' : '' }}>Owner</option>
            <option value="rented" {{ request('status') === 'rented' ? 'selected' : '' }}>Rented</option>
            <option value="vacant" {{ request('status') === 'vacant' ? 'selected' : '' }}>Vacant</option>
        </select>
        <button type="submit" class="btn-primary px-3 py-1.5 text-xs">Filter</button>
    </form>

    <!-- Properties Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        @forelse($properties as $p)
            <div class="card p-3.5 space-y-2">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-900">{{ $p->full_identifier }}</span>
                        <span class="text-[10px] text-slate-400 block">{{ $p->property_type }}</span>
                    </div>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold capitalize
                        @if($p->occupancy_status === 'owner_occupied') bg-emerald-100 text-emerald-800
                        @elseif($p->occupancy_status === 'rented') bg-blue-100 text-blue-800
                        @else bg-slate-100 text-slate-600 @endif">
                        {{ str_replace('_', ' ', $p->occupancy_status) }}
                    </span>
                </div>

                <div class="pt-2 border-t border-slate-100 text-[11px] space-y-1">
                    <div class="flex justify-between">
                        <span class="text-slate-400">Owner:</span>
                        <span class="font-medium text-slate-800">
                            {{ $p->owners->pluck('name')->join(', ') ?: 'Unassigned' }}
                        </span>
                    </div>
                    @if($p->occupancy_status === 'rented')
                        <div class="flex justify-between">
                            <span class="text-slate-400">Tenant:</span>
                            <span class="font-medium text-blue-700">
                                {{ $p->currentTenant->tenantUser->name ?? 'Active' }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="card p-6 text-center text-xs text-slate-400 col-span-2">
                No units found. Click "+ Add Unit" above to add society flats.
            </div>
        @endforelse
    </div>

    @if($properties->hasPages())
        <div class="pt-2">
            {{ $properties->links() }}
        </div>
    @endif
</div>
@endsection
