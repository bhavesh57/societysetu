<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SocietySetu - Multi-Tenant Society Management Platform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between">
    <!-- Header (No login buttons) -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-20">
        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="w-10 h-10 rounded-xl bg-teal-600 flex items-center justify-center text-white font-black text-xl shadow-xs">SS</span>
                <div>
                    <h1 class="text-xl font-bold tracking-tight text-slate-900 leading-tight">Society<span class="text-teal-600">Setu</span></h1>
                    <p class="text-xs text-slate-500 font-medium">Single-Codebase Society Management Platform</p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span>
                    API &amp; Engine Active
                </span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-12 flex-1 space-y-16">
        <!-- Hero Section -->
        <div class="text-center max-w-3xl mx-auto">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-teal-100 text-teal-800 mb-4 border border-teal-200">
                Phase 1 Prototype &bull; Multi-Tenant Platform Overview
            </span>
            <h2 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                Modern Society Management for Communities, Owners &amp; Tenants
            </h2>
            <p class="mt-5 text-base sm:text-lg text-slate-600 leading-relaxed">
                SocietySetu is an all-in-one housing society management platform engineered with a single-codebase architecture. It streamlines communication, property ownership, tenant leasing, maintenance workflows, and administrative compliance.
            </p>
        </div>

        <!-- Section: What We Provide -->
        <div class="space-y-8">
            <div class="text-center max-w-2xl mx-auto">
                <h3 class="text-xs font-bold text-teal-700 uppercase tracking-widest">Platform Capabilities</h3>
                <h4 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">What SocietySetu Provides</h4>
                <p class="text-xs sm:text-sm text-slate-500 mt-2">
                    A comprehensive suite of role-tailored tools designed specifically for each stakeholder in residential housing societies.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <!-- Feature 1 -->
                <div class="card p-6 bg-white space-y-3">
                    <div class="w-10 h-10 rounded-lg bg-teal-50 text-teal-700 flex items-center justify-center text-xl font-bold">
                        🏢
                    </div>
                    <h5 class="text-base font-bold text-slate-900">Multi-Society Governance</h5>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Centralized administration supporting unlimited housing complexes and towers. Each society is provisioned with a distinct uppercase alphanumeric code (e.g., <code class="bg-slate-100 px-1 py-0.5 rounded text-teal-800 font-mono">KOHINOOR01</code>) and isolated tenant datasets.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="card p-6 bg-white space-y-3">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center text-xl font-bold">
                        🎖️
                    </div>
                    <h5 class="text-base font-bold text-slate-900">Managing Committee Operations</h5>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Equips Presidents, Secretaries, and Treasurers with digital rosters, unit inventory management, owner-tenant linkage, complaint assignment, and official resolution remark workflows.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="card p-6 bg-white space-y-3">
                    <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-700 flex items-center justify-center text-xl font-bold">
                        🏡
                    </div>
                    <h5 class="text-base font-bold text-slate-900">House Owner Portfolio</h5>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Gives property owners clear visibility over all owned flats, direct registration and lease management of rental tenants, owner-targeted announcements, and unit maintenance ticketing.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="card p-6 bg-white space-y-3">
                    <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center text-xl font-bold">
                        🔑
                    </div>
                    <h5 class="text-base font-bold text-slate-900">Rental Tenant Experience</h5>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Provides rental occupants with easy access to rented property details, landlord contact information, tenant-relevant notices (police verification, moving rules), and service request lodging.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="card p-6 bg-white space-y-3">
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center text-xl font-bold">
                        📢
                    </div>
                    <h5 class="text-base font-bold text-slate-900">Audience-Targeted Notices</h5>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Circulars with strict audience segregation: <strong class="text-slate-800">Owners Only</strong>, <strong class="text-slate-800">Tenants Only</strong>, or <strong class="text-slate-800">Both</strong>. Financial resolutions are kept confidential from tenants, while tenant guidelines remain focused.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="card p-6 bg-white space-y-3">
                    <div class="w-10 h-10 rounded-lg bg-rose-50 text-rose-700 flex items-center justify-center text-xl font-bold">
                        🛠️
                    </div>
                    <h5 class="text-base font-bold text-slate-900">Complaint Lifecycle &amp; Audit</h5>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Categorized maintenance ticketing across Water, Electricity, Security, Cleaning, and Parking with priority levels, photo evidence uploads, and a transparent timeline of committee responses.
                    </p>
                </div>
            </div>
        </div>

        <!-- Section: Authentication Model -->
        <div class="card p-8 bg-white border border-slate-200">
            <h4 class="text-xs font-bold text-teal-700 uppercase tracking-widest mb-1">Security &amp; Identity</h4>
            <h3 class="text-2xl font-bold text-slate-900 tracking-tight mb-4">Unified Authentication Specification</h3>
            <div class="grid md:grid-cols-2 gap-6 text-xs text-slate-600">
                <div class="space-y-3">
                    <h5 class="text-sm font-bold text-slate-900">Unique Username Scheme</h5>
                    <p class="leading-relaxed">
                        Every resident (Committee, Owner, Tenant) is identified by an automated compound username stored as:
                    </p>
                    <div class="p-3 bg-slate-900 text-teal-400 font-mono text-xs rounded-lg">
                        mobileno#societycode &rarr; e.g. 9820011223#KOHINOOR01
                    </div>
                    <p class="leading-relaxed">
                        This format allows a single mobile phone number to hold distinct active memberships across multiple societies without database collision.
                    </p>
                </div>

                <div class="space-y-3">
                    <h5 class="text-sm font-bold text-slate-900">Multi-Channel Credential Verification</h5>
                    <ul class="space-y-2">
                        <li class="flex items-start">
                            <span class="text-teal-600 font-bold mr-2">&check;</span>
                            <span><strong>Web &amp; Mobile Portals:</strong> Authenticate using Society Code + Mobile Number + Password.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-teal-600 font-bold mr-2">&check;</span>
                            <span><strong>Multi-Role Switcher:</strong> When a user holds multiple roles (e.g. Committee Member and House Owner), the app provides an instant in-header role switcher pill.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-teal-600 font-bold mr-2">&check;</span>
                            <span><strong>REST APIs:</strong> Headless authentication issuing Laravel Sanctum Personal Access Tokens.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Section: Single-Codebase Architecture -->
        <div class="card p-8 bg-white border border-slate-200">
            <h4 class="text-xs font-bold text-teal-700 uppercase tracking-widest mb-1">Architecture</h4>
            <h3 class="text-2xl font-bold text-slate-900 tracking-tight mb-4">Single-Codebase Technology Stack</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-xs font-bold text-slate-500 uppercase block mb-1">Backend</span>
                    <span class="text-base font-extrabold text-slate-900 block">Laravel 12</span>
                    <span class="text-[11px] text-teal-700 font-medium">PHP 8.2+ Core</span>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-xs font-bold text-slate-500 uppercase block mb-1">Mobile Shell</span>
                    <span class="text-base font-extrabold text-slate-900 block">NativePHP</span>
                    <span class="text-[11px] text-teal-700 font-medium">Android &amp; iOS</span>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-xs font-bold text-slate-500 uppercase block mb-1">Database</span>
                    <span class="text-base font-extrabold text-slate-900 block">MySQL</span>
                    <span class="text-[11px] text-teal-700 font-medium">Direct Society FK</span>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-xs font-bold text-slate-500 uppercase block mb-1">API Tokens</span>
                    <span class="text-base font-extrabold text-slate-900 block">Sanctum</span>
                    <span class="text-[11px] text-teal-700 font-medium">REST API v1</span>
                </div>
            </div>
        </div>

        <!-- Section: REST API v1 Specification -->
        <div class="card p-8 bg-white border border-slate-200">
            <h4 class="text-xs font-bold text-teal-700 uppercase tracking-widest mb-1">Integration</h4>
            <h3 class="text-2xl font-bold text-slate-900 tracking-tight mb-4">Live REST API Endpoints</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 text-slate-600 font-semibold border-b border-slate-200 uppercase">
                            <th class="py-2.5 px-3">Method</th>
                            <th class="py-2.5 px-3">Endpoint</th>
                            <th class="py-2.5 px-3">Purpose</th>
                            <th class="py-2.5 px-3">Auth</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-mono">
                        <tr>
                            <td class="py-2 px-3 text-emerald-700 font-bold">POST</td>
                            <td class="py-2 px-3 text-slate-800">/api/v1/auth/login</td>
                            <td class="py-2 px-3 font-sans text-slate-600">Society Code + Mobile + Password login; returns Bearer token</td>
                            <td class="py-2 px-3 font-sans text-slate-400">Public</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-3 text-blue-700 font-bold">GET</td>
                            <td class="py-2 px-3 text-slate-800">/api/v1/auth/me</td>
                            <td class="py-2 px-3 font-sans text-slate-600">Authenticated profile and active society memberships</td>
                            <td class="py-2 px-3 font-sans text-teal-700 font-semibold">Bearer Token</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-3 text-blue-700 font-bold">GET</td>
                            <td class="py-2 px-3 text-slate-800">/api/v1/newsletters</td>
                            <td class="py-2 px-3 font-sans text-slate-600">Audience-filtered notices (owners_only / tenants_only / both)</td>
                            <td class="py-2 px-3 font-sans text-teal-700 font-semibold">Bearer Token</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-3 text-blue-700 font-bold">GET</td>
                            <td class="py-2 px-3 text-slate-800">/api/v1/complaints</td>
                            <td class="py-2 px-3 font-sans text-slate-600">List complaints scoped to user or society</td>
                            <td class="py-2 px-3 font-sans text-teal-700 font-semibold">Bearer Token</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-3 text-emerald-700 font-bold">POST</td>
                            <td class="py-2 px-3 text-slate-800">/api/v1/complaints</td>
                            <td class="py-2 px-3 font-sans text-slate-600">Submit new complaint with photo proof upload</td>
                            <td class="py-2 px-3 font-sans text-teal-700 font-semibold">Bearer Token</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-3 text-emerald-700 font-bold">POST</td>
                            <td class="py-2 px-3 text-slate-800">/api/v1/complaints/{id}/comment</td>
                            <td class="py-2 px-3 font-sans text-slate-600">Post resolution remark &amp; update complaint status</td>
                            <td class="py-2 px-3 font-sans text-teal-700 font-semibold">Bearer Token</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-3 text-blue-700 font-bold">GET</td>
                            <td class="py-2 px-3 text-slate-800">/api/v1/properties</td>
                            <td class="py-2 px-3 font-sans text-slate-600">Society property units inventory</td>
                            <td class="py-2 px-3 font-sans text-teal-700 font-semibold">Bearer Token</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-500">
        &copy; {{ date('Y') }} SocietySetu Platform &bull; Single-Codebase Architecture &bull; All Rights Reserved
    </footer>
</body>
</html>
