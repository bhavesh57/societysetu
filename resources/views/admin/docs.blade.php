@extends('layouts.admin')

@section('title', 'Developer & API Documentation')

@section('content')
<div class="space-y-8 max-w-5xl">
    <!-- Header banner -->
    <div class="card p-6 bg-gradient-to-r from-slate-900 via-teal-950 to-slate-900 text-white border-0 shadow-md">
        <div class="flex items-center space-x-2 text-xs font-semibold text-teal-400 uppercase tracking-widest mb-1">
            <span>Confidential</span>
            <span>&bull;</span>
            <span>Internal Developer &amp; API Reference</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">SocietySetu Technical Documentation</h1>
        <p class="text-xs text-slate-300 mt-2 max-w-3xl leading-relaxed">
            Comprehensive development specifications, multi-tenant architecture, compound username model, and complete live REST API v1 endpoints. Protected from public search engines.
        </p>
    </div>

    <!-- Section 1: Username & Identity Specification -->
    <div class="card p-6 bg-white space-y-4">
        <div class="flex items-center space-x-2">
            <span class="w-8 h-8 rounded-lg bg-teal-50 text-teal-700 font-bold flex items-center justify-center text-sm">01</span>
            <h2 class="text-lg font-bold text-slate-900">Compound Username &amp; Authentication Model</h2>
        </div>
        <p class="text-xs text-slate-600 leading-relaxed">
            In housing societies, a resident or committee member may own or rent flats across multiple different complexes using the same phone number. SocietySetu solves this by assigning every resident a compound unique identifier:
        </p>
        <div class="p-4 rounded-xl bg-slate-900 text-teal-400 font-mono text-xs border border-slate-800">
            <strong>Format:</strong> mobileno#societycode <br>
            <strong>Example:</strong> 9820011223#KOHINOOR01 &bull; 9820077889#KOHINOOR01 &bull; 9820099001#KOHINOOR01
        </div>
        <div class="grid sm:grid-cols-2 gap-3 text-xs text-slate-600 pt-2">
            <div class="p-3 rounded-lg bg-slate-50 border border-slate-200">
                <span class="font-bold text-slate-900 block mb-1">Web &amp; Mobile App Login:</span>
                Accepts <code class="bg-white px-1 py-0.5 rounded border border-slate-200 text-teal-700 font-semibold">Society Code</code> + <code class="bg-white px-1 py-0.5 rounded border border-slate-200 text-teal-700 font-semibold">Mobile Number</code> + <code class="bg-white px-1 py-0.5 rounded border border-slate-200 text-teal-700 font-semibold">Password</code>.
            </div>
            <div class="p-3 rounded-lg bg-slate-50 border border-slate-200">
                <span class="font-bold text-slate-900 block mb-1">API Token Flow:</span>
                Authenticates against <code class="bg-white px-1 py-0.5 rounded border border-slate-200 text-teal-700 font-semibold">/api/v1/auth/login</code> and returns a Laravel Sanctum Bearer token with granted role abilities.
            </div>
        </div>
    </div>

    <!-- Section 2: Single-Codebase Architecture -->
    <div class="card p-6 bg-white space-y-4">
        <div class="flex items-center space-x-2">
            <span class="w-8 h-8 rounded-lg bg-blue-50 text-blue-700 font-bold flex items-center justify-center text-sm">02</span>
            <h2 class="text-lg font-bold text-slate-900">Single-Codebase Technology Architecture</h2>
        </div>
        <div class="grid sm:grid-cols-4 gap-3 text-xs">
            <div class="p-4 rounded-lg bg-slate-50 border border-slate-200 text-center">
                <span class="font-bold text-slate-500 block uppercase text-[10px]">Backend Core</span>
                <span class="font-extrabold text-slate-900 text-sm block mt-1">Laravel 12</span>
                <span class="text-[11px] text-teal-700">PHP 8.2+ Architecture</span>
            </div>
            <div class="p-4 rounded-lg bg-slate-50 border border-slate-200 text-center">
                <span class="font-bold text-slate-500 block uppercase text-[10px]">Mobile Runtime</span>
                <span class="font-extrabold text-slate-900 text-sm block mt-1">NativePHP Mobile</span>
                <span class="text-[11px] text-teal-700">Android &amp; iOS</span>
            </div>
            <div class="p-4 rounded-lg bg-slate-50 border border-slate-200 text-center">
                <span class="font-bold text-slate-500 block uppercase text-[10px]">Database</span>
                <span class="font-extrabold text-slate-900 text-sm block mt-1">MySQL / MariaDB</span>
                <span class="text-[11px] text-teal-700">Multi-Tenant Foreign Keys</span>
            </div>
            <div class="p-4 rounded-lg bg-slate-50 border border-slate-200 text-center">
                <span class="font-bold text-slate-500 block uppercase text-[10px]">Security</span>
                <span class="font-extrabold text-slate-900 text-sm block mt-1">Spatie &amp; Sanctum</span>
                <span class="text-[11px] text-teal-700">RBAC + API Tokens</span>
            </div>
        </div>
    </div>

    <!-- Section 3: REST API Endpoints & Curl Examples -->
    <div class="card p-6 bg-white space-y-6">
        <div class="flex items-center space-x-2">
            <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 font-bold flex items-center justify-center text-sm">03</span>
            <h2 class="text-lg font-bold text-slate-900">Live REST API v1 Documentation</h2>
        </div>
        <p class="text-xs text-slate-600">
            Base Endpoint: <code class="font-mono bg-slate-100 text-teal-800 px-2 py-0.5 rounded font-bold">http://127.0.0.1:8000/api/v1</code>
        </p>

        <!-- API Endpoint 1 -->
        <div class="space-y-2 border border-slate-200 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2 font-mono text-xs">
                    <span class="px-2 py-0.5 rounded font-bold bg-emerald-100 text-emerald-800">POST</span>
                    <span class="font-bold text-slate-900">/api/v1/auth/login</span>
                </div>
                <span class="text-[11px] text-slate-400 font-medium">Public</span>
            </div>
            <p class="text-xs text-slate-600">Authenticate resident and issue Sanctum token with compound username.</p>
            <div class="p-3 bg-slate-900 text-slate-200 rounded-lg font-mono text-[11px] overflow-x-auto">
curl -X POST http://127.0.0.1:8000/api/v1/auth/login \<br>
&nbsp;&nbsp;-H "Content-Type: application/json" \<br>
&nbsp;&nbsp;-d '{"society_code":"KOHINOOR01","mobile":"9820011223","password":"password"}'
            </div>
        </div>

        <!-- API Endpoint 2 -->
        <div class="space-y-2 border border-slate-200 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2 font-mono text-xs">
                    <span class="px-2 py-0.5 rounded font-bold bg-blue-100 text-blue-800">GET</span>
                    <span class="font-bold text-slate-900">/api/v1/newsletters</span>
                </div>
                <span class="text-[11px] text-teal-700 font-semibold font-mono">Bearer Token</span>
            </div>
            <p class="text-xs text-slate-600">Fetch audience-segregated notices (header: <code class="font-mono text-teal-700">X-User-Role: house_owner</code> or <code class="font-mono text-teal-700">tenant</code>).</p>
            <div class="p-3 bg-slate-900 text-slate-200 rounded-lg font-mono text-[11px] overflow-x-auto">
curl -X GET http://127.0.0.1:8000/api/v1/newsletters \<br>
&nbsp;&nbsp;-H "Authorization: Bearer &lt;TOKEN&gt;" \<br>
&nbsp;&nbsp;-H "X-User-Role: tenant"
            </div>
        </div>

        <!-- API Endpoint 3 -->
        <div class="space-y-2 border border-slate-200 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2 font-mono text-xs">
                    <span class="px-2 py-0.5 rounded font-bold bg-emerald-100 text-emerald-800">POST</span>
                    <span class="font-bold text-slate-900">/api/v1/complaints</span>
                </div>
                <span class="text-[11px] text-teal-700 font-semibold font-mono">Bearer Token</span>
            </div>
            <p class="text-xs text-slate-600">Lodge maintenance ticket with optional photo evidence attachment.</p>
            <div class="p-3 bg-slate-900 text-slate-200 rounded-lg font-mono text-[11px] overflow-x-auto">
curl -X POST http://127.0.0.1:8000/api/v1/complaints \<br>
&nbsp;&nbsp;-H "Authorization: Bearer &lt;TOKEN&gt;" \<br>
&nbsp;&nbsp;-F "society_id=1" \<br>
&nbsp;&nbsp;-F "category_id=1" \<br>
&nbsp;&nbsp;-F "submitter_role=tenant" \<br>
&nbsp;&nbsp;-F "title=Water seepage" \<br>
&nbsp;&nbsp;-F "description=Ceiling leakage in utility room" \<br>
&nbsp;&nbsp;-F "priority=high" \<br>
&nbsp;&nbsp;-F "photo=@/path/to/evidence.jpg"
            </div>
        </div>

        <!-- API Endpoint 4 -->
        <div class="space-y-2 border border-slate-200 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2 font-mono text-xs">
                    <span class="px-2 py-0.5 rounded font-bold bg-emerald-100 text-emerald-800">POST</span>
                    <span class="font-bold text-slate-900">/api/v1/complaints/{id}/comment</span>
                </div>
                <span class="text-[11px] text-teal-700 font-semibold font-mono">Bearer Token</span>
            </div>
            <p class="text-xs text-slate-600">Add committee remark and transition complaint status (Pending, In Progress, Resolved, Rejected).</p>
            <div class="p-3 bg-slate-900 text-slate-200 rounded-lg font-mono text-[11px] overflow-x-auto">
curl -X POST http://127.0.0.1:8000/api/v1/complaints/1/comment \<br>
&nbsp;&nbsp;-H "Authorization: Bearer &lt;TOKEN&gt;" \<br>
&nbsp;&nbsp;-H "Content-Type: application/json" \<br>
&nbsp;&nbsp;-d '{"remark":"Plumber assigned for inspection","status":"In Progress"}'
            </div>
        </div>
    </div>

    <!-- Section 4: Seeded Accounts Reference -->
    <div class="card p-6 bg-white space-y-4">
        <div class="flex items-center space-x-2">
            <span class="w-8 h-8 rounded-lg bg-purple-50 text-purple-700 font-bold flex items-center justify-center text-sm">04</span>
            <h2 class="text-lg font-bold text-slate-900">Seeded Prototype Accounts</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs font-mono">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 uppercase font-semibold border-b border-slate-200">
                        <th class="py-2.5 px-3">Role</th>
                        <th class="py-2.5 px-3">user_name</th>
                        <th class="py-2.5 px-3">Mobile</th>
                        <th class="py-2.5 px-3">Society Code</th>
                        <th class="py-2.5 px-3">Password</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr>
                        <td class="py-2 px-3 font-sans font-bold text-teal-800">Committee</td>
                        <td class="py-2 px-3">9820011223#KOHINOOR01</td>
                        <td class="py-2 px-3">9820011223</td>
                        <td class="py-2 px-3 font-bold">KOHINOOR01</td>
                        <td class="py-2 px-3">password</td>
                    </tr>
                    <tr>
                        <td class="py-2 px-3 font-sans font-bold text-blue-800">Owner</td>
                        <td class="py-2 px-3">9820077889#KOHINOOR01</td>
                        <td class="py-2 px-3">9820077889</td>
                        <td class="py-2 px-3 font-bold">KOHINOOR01</td>
                        <td class="py-2 px-3">password</td>
                    </tr>
                    <tr>
                        <td class="py-2 px-3 font-sans font-bold text-amber-800">Tenant</td>
                        <td class="py-2 px-3">9820099001#KOHINOOR01</td>
                        <td class="py-2 px-3">9820099001</td>
                        <td class="py-2 px-3 font-bold">KOHINOOR01</td>
                        <td class="py-2 px-3">password</td>
                    </tr>
                    <tr>
                        <td class="py-2 px-3 font-sans font-bold text-slate-800">Super Admin</td>
                        <td class="py-2 px-3">9999999999#SUPERADMIN</td>
                        <td class="py-2 px-3">9999999999</td>
                        <td class="py-2 px-3 font-sans text-slate-400">admin@societysetu.com</td>
                        <td class="py-2 px-3">password</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
