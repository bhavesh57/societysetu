<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Super Admin Login | SocietySetu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-6">
            <div class="inline-flex w-12 h-12 rounded-2xl bg-teal-600 text-white items-center justify-center font-black text-2xl shadow-md mb-2">
                SS
            </div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Society<span class="text-teal-600">Setu</span></h1>
            <p class="text-xs text-slate-500 mt-1">Super Administrator Web Portal</p>
        </div>

        <div class="card p-8 bg-white shadow-md">
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

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email', 'admin@societysetu.com') }}" required autofocus
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Password</label>
                    <input type="password" id="password" name="password" value="password" required
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                </div>

                <div class="flex items-center justify-between text-xs text-slate-600">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                        <span>Remember me</span>
                    </label>
                </div>

                <button type="submit" class="btn-primary w-full py-2.5 text-sm font-semibold shadow-sm">
                    Sign In as Super Admin
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-slate-100 text-center">
                <a href="{{ route('home') }}" class="text-xs text-teal-600 hover:text-teal-700 font-medium">
                    &larr; Return to Home / Switch to Mobile View
                </a>
            </div>
        </div>
    </div>
</body>
</html>
