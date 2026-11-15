@extends('layouts.app')

@section('title', 'Manage Tenants')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-base font-bold text-slate-900 tracking-tight">Tenant Management</h2>
            <p class="text-[11px] text-slate-500">Manage rental occupants for your properties</p>
        </div>
        <button type="button" onclick="document.getElementById('addTenantCard').classList.toggle('hidden')"
                class="btn-primary px-3 py-1.5 text-xs font-semibold shadow-xs">
            + Add Tenant
        </button>
    </div>

    <!-- Add Tenant Card (Collapsible) -->
    <div id="addTenantCard" class="hidden card p-4 bg-white border border-teal-200">
        <h3 class="text-xs font-bold text-teal-900 uppercase tracking-wider mb-2">Register Rental Tenant</h3>
        <form method="POST" action="{{ route('owner.tenants.store') }}" class="space-y-2.5 text-xs">
            @csrf
            <div>
                <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Select Owned Property</label>
                <select name="property_id" required class="w-full px-3 py-1.5 rounded border border-slate-300">
                    @foreach($ownedProperties as $prop)
                        <option value="{{ $prop->id }}">{{ $prop->full_identifier }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Tenant Full Name</label>
                <input type="text" name="name" required placeholder="Tenant Name"
                       class="w-full px-3 py-1.5 rounded border border-slate-300">
            </div>
            <div>
                <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">10-Digit Mobile</label>
                <input type="tel" name="mobile" required pattern="[0-9]{10}" placeholder="9820000000"
                       class="w-full px-3 py-1.5 rounded border border-slate-300">
            </div>
            <div>
                <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Email (Optional)</label>
                <input type="email" name="email" placeholder="tenant@example.com"
                       class="w-full px-3 py-1.5 rounded border border-slate-300">
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Lease Start</label>
                    <input type="date" name="lease_start_date" value="{{ date('Y-m-d') }}" required
                           class="w-full px-2 py-1.5 rounded border border-slate-300">
                </div>
                <div>
                    <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Lease End</label>
                    <input type="date" name="lease_end_date"
                           class="w-full px-2 py-1.5 rounded border border-slate-300">
                </div>
            </div>
            <button type="submit" class="btn-primary w-full py-2 text-xs font-bold mt-1">
                Save &amp; Generate Tenant Access
            </button>
        </form>
    </div>

    <!-- Active & Past Tenants List -->
    <div class="space-y-3">
        @forelse($tenants as $tn)
            <div class="card p-3.5 space-y-2">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-xs font-bold text-slate-900">{{ $tn->tenantUser->name ?? 'Tenant' }}</h3>
                        <span class="text-[11px] text-slate-500 font-mono">{{ $tn->tenantUser->mobile ?? '-' }}</span>
                        <div class="text-[10px] text-teal-700 font-semibold mt-0.5">
                            Property: {{ $tn->property->full_identifier ?? 'Unit' }}
                        </div>
                    </div>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold capitalize
                        {{ $tn->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                        {{ str_replace('_', ' ', $tn->status) }}
                    </span>
                </div>

                <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                    <span>Lease: {{ $tn->lease_start_date ? $tn->lease_start_date->format('M Y') : 'N/A' }} - {{ $tn->lease_end_date ? $tn->lease_end_date->format('M Y') : 'Ongoing' }}</span>
                    @if($tn->status === 'active')
                        <form method="POST" action="{{ route('owner.tenants.deactivate', $tn) }}" onsubmit="return confirm('Mark tenant as moved out?')">
                            @csrf
                            <button type="submit" class="text-red-600 font-semibold hover:underline">
                                Mark Moved Out
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="card p-6 text-center text-xs text-slate-400">
                No tenants currently registered under your properties.
            </div>
        @endforelse
    </div>
</div>
@endsection
