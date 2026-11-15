@extends('layouts.admin')

@section('title', $society->name)

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb & Title -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2 text-xs text-slate-500 mb-1">
                <a href="{{ route('admin.societies.index') }}" class="hover:text-teal-600">Societies</a>
                <span>&bull;</span>
                <span class="font-mono text-teal-700 font-semibold">{{ $society->society_code }}</span>
            </div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">{{ $society->name }}</h1>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.societies.edit', $society) }}" class="btn-secondary px-3 py-1.5 text-xs font-semibold">
                Edit Details
            </a>
            <form method="POST" action="{{ route('admin.societies.toggle_status', $society) }}">
                @csrf
                <button type="submit" class="px-3 py-1.5 text-xs font-semibold rounded-md border {{ $society->status === 'active' ? 'border-red-200 text-red-600 hover:bg-red-50' : 'border-emerald-200 text-emerald-600 hover:bg-emerald-50' }}">
                    {{ $society->status === 'active' ? 'Deactivate Society' : 'Activate Society' }}
                </button>
            </form>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="card p-4">
            <span class="text-xs text-slate-500 font-semibold uppercase">Flats / Units</span>
            <div class="text-xl font-bold text-slate-900 mt-1">{{ $society->properties_count }}</div>
        </div>
        <div class="card p-4">
            <span class="text-xs text-slate-500 font-semibold uppercase">Total Members</span>
            <div class="text-xl font-bold text-slate-900 mt-1">{{ $society->members_count }}</div>
        </div>
        <div class="card p-4">
            <span class="text-xs text-slate-500 font-semibold uppercase">Newsletters</span>
            <div class="text-xl font-bold text-slate-900 mt-1">{{ $society->newsletters_count }}</div>
        </div>
        <div class="card p-4">
            <span class="text-xs text-slate-500 font-semibold uppercase">Complaints Lodged</span>
            <div class="text-xl font-bold text-slate-900 mt-1">{{ $society->complaints_count }}</div>
        </div>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        <!-- Society Info Left Column -->
        <div class="card p-5 space-y-4">
            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider border-b border-slate-100 pb-2">
                Society Profile
            </h2>

            <div class="space-y-3 text-xs">
                <div>
                    <span class="text-slate-400 block font-medium">Society Code (Login Key)</span>
                    <span class="font-mono text-base font-bold text-teal-700 bg-teal-50 px-2 py-0.5 rounded border border-teal-200 inline-block mt-0.5">
                        {{ $society->society_code }}
                    </span>
                </div>
                <div>
                    <span class="text-slate-400 block font-medium">Status</span>
                    <span class="capitalize font-semibold {{ $society->status === 'active' ? 'text-emerald-600' : 'text-red-600' }}">
                        {{ $society->status }}
                    </span>
                </div>
                <div>
                    <span class="text-slate-400 block font-medium">Address</span>
                    <span class="text-slate-700">{{ $society->address ?: 'Not provided' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block font-medium">City & State</span>
                    <span class="text-slate-700">{{ $society->city }}, {{ $society->state }} - {{ $society->pincode }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block font-medium">Primary Contact</span>
                    <span class="text-slate-800 font-semibold">{{ $society->contact_person }}</span>
                    <div class="text-slate-600">{{ $society->contact_phone }} &bull; {{ $society->contact_email }}</div>
                </div>
            </div>
        </div>

        <!-- Committee Assignment Right Column (2 cols) -->
        <div class="md:col-span-2 space-y-6">
            <!-- Add Committee Member Form -->
            <div class="card p-5 bg-white">
                <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-3">
                    Assign Committee Member
                </h2>
                <p class="text-xs text-slate-500 mb-4">Grant administrative committee leadership permissions (President, Secretary, Treasurer) to manage properties, announcements, and complaints.</p>

                <form method="POST" action="{{ route('admin.societies.add_committee', $society) }}" class="space-y-3">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                        <div class="sm:col-span-1">
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Full Name</label>
                            <input type="text" name="name" placeholder="Member Name" required
                                   class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs focus:ring-2 focus:ring-teal-500 focus:outline-none">
                        </div>
                        <div class="sm:col-span-1">
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">10-Digit Mobile</label>
                            <input type="text" name="mobile" placeholder="9820011223" required pattern="[0-9]{10}"
                                   class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs focus:ring-2 focus:ring-teal-500 focus:outline-none">
                        </div>
                        <div class="sm:col-span-1">
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Designation</label>
                            <select name="designation" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs focus:ring-2 focus:ring-teal-500 focus:outline-none">
                                <option value="President">President</option>
                                <option value="Secretary">Secretary</option>
                                <option value="Treasurer">Treasurer</option>
                                <option value="Member">Committee Member</option>
                            </select>
                        </div>
                        <div class="sm:col-span-1">
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">Default PIN</label>
                            <input type="text" name="pin" value="1234" required minlength="4" maxlength="6"
                                   class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs focus:ring-2 focus:ring-teal-500 focus:outline-none">
                        </div>
                    </div>
                    <div class="text-right pt-2">
                        <button type="submit" class="btn-primary px-4 py-2 text-xs font-semibold">
                            + Assign Committee Member
                        </button>
                    </div>
                </form>
            </div>

            <!-- Committee Members List -->
            <div class="card overflow-hidden">
                <div class="p-4 border-b border-slate-200">
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Current Committee Body</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 text-slate-600 font-semibold border-b border-slate-200">
                                <th class="py-2.5 px-4">Member Name</th>
                                <th class="py-2.5 px-4">Mobile</th>
                                <th class="py-2.5 px-4">Designation</th>
                                <th class="py-2.5 px-4">Term</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($committeeMembers as $cm)
                                <tr class="hover:bg-slate-50">
                                    <td class="py-3 px-4 font-semibold text-slate-900">{{ $cm->user->name ?? 'User' }}</td>
                                    <td class="py-3 px-4 text-slate-600 font-mono">{{ $cm->user->mobile ?? '-' }}</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-teal-100 text-teal-800">
                                            {{ $cm->designation }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-slate-500">
                                        {{ $cm->term_start ? $cm->term_start->format('M Y') : 'Active' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-slate-500">No committee members assigned yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
