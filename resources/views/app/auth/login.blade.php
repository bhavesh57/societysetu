<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="robots" content="noindex, nofollow, noarchive, nosnippet">
    <title>Resident &amp; Committee Login | SocietySetu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen flex items-center justify-center p-3">
    <div class="w-full max-w-sm">
        <!-- Brand Header -->
        <div class="text-center mb-6">
            <div class="inline-flex w-12 h-12 rounded-2xl bg-teal-600 text-white items-center justify-center font-black text-2xl shadow-md mb-2">
                SS
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Society<span class="text-teal-600">Setu</span></h1>
            <p class="text-xs text-slate-500 font-medium">Resident, Owner &amp; Committee App</p>
        </div>

        <div class="card p-6 bg-white shadow-md">
            @if(session('success'))
                <div class="mb-4 p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-800 text-xs font-medium">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('app.login.submit') }}" id="loginForm" class="space-y-4" autocomplete="off">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Society Code <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="society_code" name="society_code" value="{{ old('society_code') }}" required
                           placeholder="Enter society code"
                           autocomplete="off"
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm font-mono font-bold uppercase tracking-wider focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Mobile Number <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" id="mobile" name="mobile" value="{{ old('mobile') }}" required pattern="[0-9]{10}"
                           placeholder="10-digit registered mobile number"
                           autocomplete="off"
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Password / PIN <span class="text-red-500">*</span>
                    </label>
                    <input type="password" id="password" name="password" value="" required
                           placeholder="Enter your password"
                           autocomplete="new-password"
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>

                <button type="submit" class="btn-primary w-full py-2.5 text-sm font-semibold shadow-sm mt-2">
                    Enter Society Portal
                </button>
            </form>
        </div>
    </div>
</body>
</html>
