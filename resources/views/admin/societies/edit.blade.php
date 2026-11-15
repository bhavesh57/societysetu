@extends('layouts.admin')

@section('title', 'Edit Society - ' . $society->name)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Edit Society Profile</h1>
            <p class="text-xs text-slate-500 mt-1">Update contact details and configuration for {{ $society->name }}</p>
        </div>
        <a href="{{ route('admin.societies.show', $society) }}" class="btn-secondary px-3 py-1.5 text-xs">
            &larr; Back to Details
        </a>
    </div>

    <div class="card p-6 bg-white">
        @if($errors->any())
            <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-800 text-xs">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.societies.update', $society) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                        Society Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $society->name) }}" required
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                        Society Code <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="society_code" value="{{ old('society_code', $society->society_code) }}" required
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm font-mono uppercase focus:ring-2 focus:ring-teal-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-none">
                        <option value="active" {{ old('status', $society->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $society->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                        Address
                    </label>
                    <input type="text" name="address" value="{{ old('address', $society->address) }}"
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                        City <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="city" value="{{ old('city', $society->city) }}" required
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                        State <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="state" value="{{ old('state', $society->state) }}" required
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                        Pincode
                    </label>
                    <input type="text" name="pincode" value="{{ old('pincode', $society->pincode) }}"
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                        Contact Person <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="contact_person" value="{{ old('contact_person', $society->contact_person) }}" required
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                        Contact Phone <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="contact_phone" value="{{ old('contact_phone', $society->contact_phone) }}" required
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                        Contact Email
                    </label>
                    <input type="email" name="contact_email" value="{{ old('contact_email', $society->contact_email) }}"
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-teal-500 focus:outline-none">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-200 flex items-center justify-end space-x-3">
                <a href="{{ route('admin.societies.show', $society) }}" class="btn-secondary px-4 py-2 text-xs">Cancel</a>
                <button type="submit" class="btn-primary px-5 py-2 text-xs font-semibold">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
