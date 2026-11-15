<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SocietySetu - Multi-Tenant Society Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between">
    <!-- Header -->
    <header class="bg-white border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <span class="w-10 h-10 rounded-xl bg-teal-600 flex items-center justify-center text-white font-black text-xl shadow-sm">SS</span>
                <div>
                    <h1 class="text-xl font-bold tracking-tight text-slate-900 leading-tight">Society<span class="text-teal-600">Setu</span></h1>
                    <p class="text-xs text-slate-500 font-medium">Single Codebase Web + NativePHP Mobile</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('app.login') }}" class="px-4 py-2 text-sm font-semibold text-teal-700 bg-teal-50 hover:bg-teal-100 rounded-lg transition">
                    Mobile App View
                </a>
                <a href="{{ route('admin.login') }}" class="px-4 py-2 text-sm font-semibold text-white bg-teal-600 hover:bg-teal-700 rounded-lg shadow-sm transition">
                    Super Admin Portal
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Content -->
    <main class="max-w-6xl mx-auto px-4 py-12 flex-1">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-teal-100 text-teal-800 mb-4 border border-teal-200">
                Phase 1 Prototype &bull; Multi-Tenant Architecture
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                Unified Society Management with Strict Tenant Isolation
            </h2>
            <p class="mt-4 text-base text-slate-600 leading-relaxed">
                Empowering Super Admins, Society Managing Committees, House Owners, and Rental Tenants from a single high-performance Laravel core with NativePHP mobile capabilities.
            </p>
        </div>

        <!-- Portals Grid -->
        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <!-- Portal 1: Super Admin Web -->
            <div class="card p-6 bg-white shadow-sm hover:shadow-md transition">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-slate-900 text-white flex items-center justify-center font-bold text-xl shadow-xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">1. Super Admin Web Portal</h3>
                        <p class="text-xs text-slate-500">Desktop browser access exclusively for platform operators</p>
                    </div>
                </div>

                <ul class="text-xs text-slate-600 space-y-2 mb-6">
                    <li class="flex items-center"><svg class="w-4 h-4 text-teal-600 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Multi-society lifecycle (create, deactivate, unique code generation)</li>
                    <li class="flex items-center"><svg class="w-4 h-4 text-teal-600 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Assign committee members (President, Secretary, Treasurer)</li>
                    <li class="flex items-center"><svg class="w-4 h-4 text-teal-600 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Global monitoring of complaints and user metrics across societies</li>
                </ul>

                <div class="bg-slate-50 rounded-lg p-3 text-xs mb-4 border border-slate-200">
                    <span class="font-semibold text-slate-700 block mb-1">Seeded Credentials:</span>
                    <div>Email: <span class="font-mono text-teal-700 font-bold">admin@societysetu.com</span></div>
                    <div>Password: <span class="font-mono text-slate-700">password</span></div>
                </div>

                <a href="{{ route('admin.login') }}" class="btn-primary w-full py-2.5 text-center text-sm font-semibold">
                    Open Super Admin Login &rarr;
                </a>
            </div>

            <!-- Portal 2: Mobile App Experience -->
            <div class="card p-6 bg-white shadow-sm hover:shadow-md transition">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-teal-600 text-white flex items-center justify-center font-bold text-xl shadow-xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">2. NativePHP Mobile App Portal</h3>
                        <p class="text-xs text-slate-500">For Committee Members, House Owners, and Rental Tenants</p>
                    </div>
                </div>

                <ul class="text-xs text-slate-600 space-y-2 mb-6">
                    <li class="flex items-center"><svg class="w-4 h-4 text-teal-600 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Fast login with <strong>Society Code</strong> + <strong>Mobile Number</strong> + <strong>PIN/OTP</strong></li>
                    <li class="flex items-center"><svg class="w-4 h-4 text-teal-600 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> In-app <strong>Role Switcher</strong> for multi-role residents (e.g., Committee &amp; Owner)</li>
                    <li class="flex items-center"><svg class="w-4 h-4 text-teal-600 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Strict newsletter targeting (Owners Only vs. Tenants Only) &amp; Complaints</li>
                </ul>

                <div class="bg-teal-50 rounded-lg p-3 text-xs mb-4 border border-teal-200">
                    <span class="font-semibold text-teal-900 block mb-1">Seeded Demo Society: KOHINOOR01 &bull; Default PIN: 1234</span>
                    <div class="grid grid-cols-3 gap-2 mt-2">
                        <div class="bg-white p-2 rounded border border-teal-100">
                            <span class="block font-bold text-slate-900">Committee</span>
                            <span class="text-[11px] font-mono text-teal-700">9820011223</span>
                        </div>
                        <div class="bg-white p-2 rounded border border-teal-100">
                            <span class="block font-bold text-slate-900">Owner</span>
                            <span class="text-[11px] font-mono text-teal-700">9820077889</span>
                        </div>
                        <div class="bg-white p-2 rounded border border-teal-100">
                            <span class="block font-bold text-slate-900">Tenant</span>
                            <span class="text-[11px] font-mono text-teal-700">9820099001</span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('app.login') }}" class="btn-primary w-full py-2.5 text-center text-sm font-semibold">
                    Launch Mobile App Portal &rarr;
                </a>
            </div>
        </div>

        <!-- Architecture & Tech Stack Pill Box -->
        <div class="bg-white border border-slate-200 rounded-xl p-6">
            <h4 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-3">Single-Codebase Technology Stack</h4>
            <div class="flex flex-wrap gap-2 text-xs">
                <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-full font-medium">Laravel 12 (Latest)</span>
                <span class="px-3 py-1 bg-teal-50 text-teal-700 border border-teal-200 rounded-full font-medium">NativePHP for Mobile</span>
                <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-full font-medium">MySQL Multi-Tenant (BelongsToSociety Scope)</span>
                <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-full font-medium">Tailwind CSS + Design Tokens</span>
                <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-full font-medium">Spatie Laravel Permission</span>
                <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-full font-medium">Laravel Sanctum (/api/v1)</span>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-500">
        &copy; {{ date('Y') }} SocietySetu &bull; Target Directory: <span class="font-mono">/home/bhavesh/code/abmdigitallab/societysetu</span>
    </footer>
</body>
</html>
