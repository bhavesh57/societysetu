@extends('layouts.app')

@section('title', 'Society Member Directory')

@section('content')
<div class="space-y-5">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-base font-bold text-slate-900 tracking-tight">Resident Directory</h2>
            <p class="text-[11px] text-slate-500">Owners &amp; registered rental tenants</p>
        </div>
    </div>

    <!-- Collapsible Quick Registration Box -->
    <div class="card p-3.5 bg-white space-y-3">
        <span class="text-xs font-bold text-slate-800 uppercase tracking-wider block">Add / Link Resident</span>
        <div class="grid grid-cols-2 gap-2">
            <button type="button" onclick="document.getElementById('ownerModal').classList.toggle('hidden'); document.getElementById('tenantModal').classList.add('hidden');"
                    class="btn-secondary py-2 text-xs font-semibold">
                + Link House Owner
            </button>
            <button type="button" onclick="document.getElementById('tenantModal').classList.toggle('hidden'); document.getElementById('ownerModal').classList.add('hidden');"
                    class="btn-secondary py-2 text-xs font-semibold">
                + Register Tenant
            </button>
        </div>

        <!-- Form 1: Add Owner Modal Box -->
        <div id="ownerModal" class="hidden pt-3 border-t border-slate-100">
            <h4 class="text-xs font-bold text-teal-800 mb-2">Register House Owner</h4>
            <form method="POST" action="{{ route('committee.members.store_owner') }}" class="space-y-2 text-xs">
                @csrf
                <div>
                    <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Full Name</label>
                    <input type="text" name="name" required placeholder="Owner Full Name"
                           class="w-full px-3 py-1.5 rounded border border-slate-300">
                </div>
                <div>
                    <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">10-Digit Mobile Number</label>
                    <input type="tel" name="mobile" required pattern="[0-9]{10}" placeholder="9820000000"
                           class="w-full px-3 py-1.5 rounded border border-slate-300">
                </div>
                <div>
                    <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Email (Optional)</label>
                    <input type="email" name="email" placeholder="owner@email.com"
                           class="w-full px-3 py-1.5 rounded border border-slate-300">
                </div>
                <div>
                    <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Select Owned Property</label>
                    <select name="property_id" required class="w-full px-3 py-1.5 rounded border border-slate-300">
                        @foreach($properties as $prop)
                            <option value="{{ $prop->id }}">{{ $prop->full_identifier }} ({{ $prop->occupancy_status }})</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn-primary w-full py-2 text-xs font-bold mt-1">
                    Save Owner
                </button>
            </form>
        </div>

        <!-- Form 2: Add Tenant Modal Box -->
        <div id="tenantModal" class="hidden pt-3 border-t border-slate-100">
            <h4 class="text-xs font-bold text-blue-800 mb-2">Register Rental Tenant</h4>
            <form method="POST" action="{{ route('committee.members.store_tenant') }}" class="space-y-2 text-xs">
                @csrf
                <div>
                    <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Full Name</label>
                    <input type="text" name="name" required placeholder="Tenant Full Name"
                           class="w-full px-3 py-1.5 rounded border border-slate-300">
                </div>
                <div>
                    <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">10-Digit Mobile Number</label>
                    <input type="tel" name="mobile" required pattern="[0-9]{10}" placeholder="9820000000"
                           class="w-full px-3 py-1.5 rounded border border-slate-300">
                </div>
                <div>
                    <label class="block text-[10px] font-semibold text-slate-600 mb-0.5">Select Rented Property</label>
                    <select name="property_id" required class="w-full px-3 py-1.5 rounded border border-slate-300">
                        @foreach($properties as $prop)
                            <option value="{{ $prop->id }}">{{ $prop->full_identifier }}</option>
                        @endforeach
                    </select>
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
                    Save Tenant
                </button>
            </form>
        </div>
    </div>

    <!-- Tab Section: Owners List -->
    <div class="space-y-2">
        <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center justify-between">
            <span>House Owners</span>
            <span class="text-teal-600 font-mono">{{ $owners->count() }}</span>
        </h3>
        <div class="space-y-2">
            @forelse($owners as $ow)
                <div class="card p-3 flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-slate-900">{{ $ow->user->name ?? 'Owner' }}</div>
                        <div class="text-[11px] text-slate-500 font-mono">{{ $ow->user->mobile ?? '-' }}</div>
                    </div>
                    <div class="text-right">
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-teal-100 text-teal-800">
                            {{ $ow->property->full_identifier ?? 'Unit' }}
                        </span>
                        <span class="block text-[10px] text-slate-400 mt-0.5">Primary Owner</span>
                    </div>
                </div>
            @empty
                <div class="card p-4 text-center text-xs text-slate-400">No house owners linked yet.</div>
            @endforelse
        </div>
    </div>

    <!-- Tab Section: Tenants List -->
    <div class="space-y-2">
        <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center justify-between">
            <span>Rental Tenants</span>
            <span class="text-blue-600 font-mono">{{ $tenants->count() }}</span>
        </h3>
        <div class="space-y-2">
            @forelse($tenants as $tn)
                <div class="card p-3 flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-slate-900">{{ $tn->tenantUser->name ?? 'Tenant' }}</div>
                        <div class="text-[11px] text-slate-500 font-mono">{{ $tn->tenantUser->mobile ?? '-' }}</div>
                        <div class="text-[10px] text-slate-400">Landlord: {{ $tn->owner->name ?? 'Owner' }}</div>
                    </div>
                    <div class="text-right">
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800">
                            {{ $tn->property->full_identifier ?? 'Unit' }}
                        </span>
                        <span class="block text-[10px] text-emerald-600 font-semibold mt-0.5">Active Lease</span>
                    </div>
                </div>
            @empty
                <div class="card p-4 text-center text-xs text-slate-400">No active rental tenants.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
