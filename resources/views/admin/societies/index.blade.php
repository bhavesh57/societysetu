@extends('layouts.admin')

@section('title', 'Manage Societies')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Society Management</h1>
            <p class="text-xs text-slate-500 mt-1">Directory of all client societies and housing complexes</p>
        </div>
        <a href="{{ route('admin.societies.create') }}" class="btn-primary px-4 py-2 text-xs font-semibold shadow-sm">
            + Onboard New Society
        </a>
    </div>

    <!-- Filter & Search Bar -->
    <div class="card p-4">
        <form method="GET" action="{{ route('admin.societies.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, code, or city..."
                       class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs focus:ring-2 focus:ring-teal-500 focus:outline-none">
            </div>
            <div>
                <select name="status" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs focus:ring-2 focus:ring-teal-500 focus:outline-none">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="flex space-x-2">
                <button type="submit" class="btn-primary px-4 py-2 text-xs flex-1">Filter</button>
                <a href="{{ route('admin.societies.index') }}" class="btn-secondary px-3 py-2 text-xs">Reset</a>
            </div>
        </form>
    </div>

    <!-- Societies Table -->
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 uppercase font-semibold border-b border-slate-200">
                        <th class="py-3 px-4">Code</th>
                        <th class="py-3 px-4">Society Name</th>
                        <th class="py-3 px-4">City / State</th>
                        <th class="py-3 px-4">Contact Info</th>
                        <th class="py-3 px-4">Flats</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($societies as $soc)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4 font-mono font-bold text-teal-700">
                                {{ $soc->society_code }}
                            </td>
                            <td class="py-3.5 px-4">
                                <a href="{{ route('admin.societies.show', $soc) }}" class="font-bold text-slate-900 hover:text-teal-600 block">
                                    {{ $soc->name }}
                                </a>
                                <span class="text-[11px] text-slate-400">{{ $soc->address }}</span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">{{ $soc->city }}, {{ $soc->state }}</td>
                            <td class="py-3.5 px-4 text-slate-600">
                                <div>{{ $soc->contact_person }}</div>
                                <div class="text-[11px] text-slate-400">{{ $soc->contact_phone }}</div>
                            </td>
                            <td class="py-3.5 px-4 font-medium text-slate-700">{{ $soc->properties_count }}</td>
                            <td class="py-3.5 px-4">
                                <form method="POST" action="{{ route('admin.societies.toggle_status', $soc) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="cursor-pointer">
                                        @if($soc->status === 'active')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-100 text-emerald-800 hover:bg-emerald-200 transition">
                                                Active &check;
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-red-100 text-red-800 hover:bg-red-200 transition">
                                                Inactive &times;
                                            </span>
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td class="py-3.5 px-4 text-right space-x-2">
                                <a href="{{ route('admin.societies.show', $soc) }}" class="px-2.5 py-1 text-xs font-semibold bg-teal-50 text-teal-700 rounded hover:bg-teal-100">
                                    Manage
                                </a>
                                <a href="{{ route('admin.societies.edit', $soc) }}" class="px-2.5 py-1 text-xs font-semibold bg-slate-100 text-slate-700 rounded hover:bg-slate-200">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-500">No societies found matching your criteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($societies->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $societies->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
