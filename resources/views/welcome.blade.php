<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SocietySetu - Modern Housing Society Management Platform</title>
    <meta name="description" content="SocietySetu is an all-in-one society management platform connecting managing committees, house owners, and rental tenants with transparent notices, property portfolios, and real-time maintenance requests.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between selection:bg-teal-500 selection:text-white">
    <!-- Navigation Header (Clean customer navigation, no login buttons) -->
    <header class="bg-white/95 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-30 shadow-xs">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-18 flex items-center justify-between">
            <a href="/" class="flex items-center space-x-2.5">
                <span class="w-10 h-10 rounded-xl bg-teal-600 flex items-center justify-center text-white font-black text-xl shadow-xs">SS</span>
                <div>
                    <span class="text-xl font-bold tracking-tight text-slate-900 block leading-tight">Society<span class="text-teal-600">Setu</span></span>
                    <span class="text-[11px] text-slate-400 font-medium tracking-wide">Connected Community Living</span>
                </div>
            </a>

            <nav class="hidden md:flex items-center space-x-8 text-xs font-semibold text-slate-600">
                <a href="#solutions" class="hover:text-teal-600 transition">Solutions</a>
                <a href="#features" class="hover:text-teal-600 transition">What We Provide</a>
                <a href="#how-it-works" class="hover:text-teal-600 transition">How It Works</a>
                <a href="#benefits" class="hover:text-teal-600 transition">Resident Benefits</a>
                <a href="#contact" class="hover:text-teal-600 transition">Contact</a>
            </nav>

            <div class="flex items-center space-x-3">
                <span class="hidden sm:inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-teal-50 text-teal-700 border border-teal-200/70">
                    Trusted by Housing Societies
                </span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1">
        <!-- Hero Section -->
        <section class="py-16 sm:py-24 px-4 sm:px-6 bg-gradient-to-b from-white to-slate-50 border-b border-slate-200/60">
            <div class="max-w-4xl mx-auto text-center space-y-6">
                <div class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-semibold bg-teal-50 text-teal-800 border border-teal-200 shadow-xs">
                    🌟 Next-Generation Society Living
                </div>
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-slate-900 tracking-tight leading-tight">
                    Effortless Society Management, <br class="hidden sm:inline"/>
                    <span class="text-teal-600">Happier Communities</span>
                </h1>
                <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-2xl mx-auto">
                    The modern all-in-one digital platform designed for housing societies, apartment complexes, and gated communities. Bridging managing committees, house owners, and tenants with complete transparency and ease.
                </p>

                <div class="pt-4 flex flex-wrap items-center justify-center gap-3 text-xs font-semibold text-slate-600">
                    <span class="inline-flex items-center bg-white px-3.5 py-2 rounded-lg border border-slate-200 shadow-xs">
                        &check; Targeted Circulars &amp; Notices
                    </span>
                    <span class="inline-flex items-center bg-white px-3.5 py-2 rounded-lg border border-slate-200 shadow-xs">
                        &check; Owner &amp; Tenant Portfolios
                    </span>
                    <span class="inline-flex items-center bg-white px-3.5 py-2 rounded-lg border border-slate-200 shadow-xs">
                        &check; Rapid Maintenance Resolution
                    </span>
                </div>
            </div>
        </section>

        <!-- Solutions for Every Stakeholder -->
        <section id="solutions" class="py-16 px-4 sm:px-6 max-w-6xl mx-auto space-y-12">
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <span class="text-xs font-bold uppercase tracking-widest text-teal-600">Tailored Solutions</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Built For Everyone In Your Society</h2>
                <p class="text-xs sm:text-sm text-slate-500">Every member of your residential community enjoys an experience crafted specifically for their role.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <!-- Managing Committee Card -->
                <div class="card p-6 bg-white space-y-4 hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center text-2xl font-bold">
                        🏛️
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Managing Committee</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Say goodbye to paper circulars and chaotic messaging groups. Oversee property records, publish targeted announcements, assign service vendors, and resolve resident complaints with a transparent audit trail.
                    </p>
                    <ul class="text-xs text-slate-600 space-y-2 pt-2 border-t border-slate-100">
                        <li class="flex items-center"><span class="text-teal-600 font-bold mr-2">&bull;</span> Complete house &amp; resident directory</li>
                        <li class="flex items-center"><span class="text-teal-600 font-bold mr-2">&bull;</span> Target circulars by owner or tenant</li>
                        <li class="flex items-center"><span class="text-teal-600 font-bold mr-2">&bull;</span> Track complaint progress &amp; post remarks</li>
                    </ul>
                </div>

                <!-- House Owners Card -->
                <div class="card p-6 bg-white space-y-4 hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-2xl font-bold">
                        🏡
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">House Owners</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Whether living in your flat or leasing it out, maintain complete control. Register rental tenants, track lease dates, review financial &amp; society notices, and lodge unit maintenance issues directly.
                    </p>
                    <ul class="text-xs text-slate-600 space-y-2 pt-2 border-t border-slate-100">
                        <li class="flex items-center"><span class="text-blue-600 font-bold mr-2">&bull;</span> Property ownership summary card</li>
                        <li class="flex items-center"><span class="text-blue-600 font-bold mr-2">&bull;</span> Effortless tenant registration &amp; history</li>
                        <li class="flex items-center"><span class="text-blue-600 font-bold mr-2">&bull;</span> Direct committee maintenance requests</li>
                    </ul>
                </div>

                <!-- Rental Tenants Card -->
                <div class="card p-6 bg-white space-y-4 hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center text-2xl font-bold">
                        🔑
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Rental Tenants</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Feel right at home in your society. Access rented unit records, direct landlord contact details, tenant-specific guidelines, and submit maintenance tickets with photo attachments anytime.
                    </p>
                    <ul class="text-xs text-slate-600 space-y-2 pt-2 border-t border-slate-100">
                        <li class="flex items-center"><span class="text-purple-600 font-bold mr-2">&bull;</span> Rented unit &amp; landlord contact info</li>
                        <li class="flex items-center"><span class="text-purple-600 font-bold mr-2">&bull;</span> Move-in rules &amp; community bulletins</li>
                        <li class="flex items-center"><span class="text-purple-600 font-bold mr-2">&bull;</span> 24/7 service issue lodging with photos</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- What We Provide: Core Features Grid -->
        <section id="features" class="py-16 px-4 sm:px-6 bg-white border-y border-slate-200/60">
            <div class="max-w-6xl mx-auto space-y-12">
                <div class="text-center max-w-2xl mx-auto space-y-2">
                    <span class="text-xs font-bold uppercase tracking-widest text-teal-600">Complete Platform</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">What We Provide</h2>
                    <p class="text-xs sm:text-sm text-slate-500">Everything needed to run a modern, secure, and well-organized society.</p>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="p-5 rounded-xl border border-slate-200/80 bg-slate-50/60 space-y-2.5">
                        <div class="text-2xl">📢</div>
                        <h4 class="text-sm font-bold text-slate-900">Targeted Circulars Engine</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Publish notices strictly to Owners Only, Tenants Only, or Both. Ensures financial resolutions stay private while tenant guidelines stay relevant.
                        </p>
                    </div>

                    <div class="p-5 rounded-xl border border-slate-200/80 bg-slate-50/60 space-y-2.5">
                        <div class="text-2xl">🛠️</div>
                        <h4 class="text-sm font-bold text-slate-900">Maintenance &amp; Helpdesk</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Categorized ticketing across Water, Electricity, Security, Cleaning, and Parking with priority tags, photos, and a real-time committee remark timeline.
                        </p>
                    </div>

                    <div class="p-5 rounded-xl border border-slate-200/80 bg-slate-50/60 space-y-2.5">
                        <div class="text-2xl">📑</div>
                        <h4 class="text-sm font-bold text-slate-900">Tenant Onboarding &amp; Leases</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Owners can register their tenants directly with lease start and end dates. Automatically keeps society occupancy records up-to-date.
                        </p>
                    </div>

                    <div class="p-5 rounded-xl border border-slate-200/80 bg-slate-50/60 space-y-2.5">
                        <div class="text-2xl">🔄</div>
                        <h4 class="text-sm font-bold text-slate-900">Multi-Role Switching</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Residents who are both Committee Members and Flat Owners can seamlessly switch profiles in one click without needing multiple logins.
                        </p>
                    </div>

                    <div class="p-5 rounded-xl border border-slate-200/80 bg-slate-50/60 space-y-2.5">
                        <div class="text-2xl">📱</div>
                        <h4 class="text-sm font-bold text-slate-900">Mobile-First Experience</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Optimized for smartphone screens and mobile app shells, giving residents one-touch access to notices, contacts, and requests from anywhere.
                        </p>
                    </div>

                    <div class="p-5 rounded-xl border border-slate-200/80 bg-slate-50/60 space-y-2.5">
                        <div class="text-2xl">🛡️</div>
                        <h4 class="text-sm font-bold text-slate-900">Secure Society Isolation</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Each housing complex operates within its own dedicated society code, ensuring member privacy and data security at all times.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works (3 Steps) -->
        <section id="how-it-works" class="py-16 px-4 sm:px-6 max-w-6xl mx-auto space-y-12">
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <span class="text-xs font-bold uppercase tracking-widest text-teal-600">Simplicity First</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">How Societies Get Started</h2>
                <p class="text-xs sm:text-sm text-slate-500">Getting your society up and running takes just three simple steps.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center space-y-3">
                    <div class="w-12 h-12 rounded-full bg-teal-600 text-white font-black text-lg flex items-center justify-center mx-auto shadow-sm">
                        1
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Society Code Setup</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Your complex is provisioned with a unique, memorable society code and unit structure.
                    </p>
                </div>

                <div class="text-center space-y-3">
                    <div class="w-12 h-12 rounded-full bg-teal-600 text-white font-black text-lg flex items-center justify-center mx-auto shadow-sm">
                        2
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Resident Directory Linkage</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Committee members register houses and connect owners and rental tenants with verified mobile contacts.
                    </p>
                </div>

                <div class="text-center space-y-3">
                    <div class="w-12 h-12 rounded-full bg-teal-600 text-white font-black text-lg flex items-center justify-center mx-auto shadow-sm">
                        3
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Seamless Community Living</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Broadcast instant notices, track maintenance repairs in real-time, and manage tenants with total peace of mind.
                    </p>
                </div>
            </div>
        </section>

        <!-- Resident Benefits Section -->
        <section id="benefits" class="py-16 px-4 sm:px-6 bg-slate-900 text-white">
            <div class="max-w-6xl mx-auto space-y-10">
                <div class="text-center max-w-2xl mx-auto space-y-2">
                    <span class="text-xs font-bold uppercase tracking-widest text-teal-400">Why Residents Love SocietySetu</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">A Smarter, Connected Living Environment</h2>
                </div>

                <div class="grid md:grid-cols-4 gap-6 text-center text-xs">
                    <div class="p-5 rounded-xl bg-slate-800/80 border border-slate-700/80 space-y-2">
                        <span class="text-3xl font-black text-teal-400 block">100%</span>
                        <span class="font-bold text-white text-sm block">Digital Notices</span>
                        <p class="text-slate-400 leading-relaxed">No paper notices missed or lost on noticeboards.</p>
                    </div>

                    <div class="p-5 rounded-xl bg-slate-800/80 border border-slate-700/80 space-y-2">
                        <span class="text-3xl font-black text-teal-400 block">24/7</span>
                        <span class="font-bold text-white text-sm block">Issue Tracking</span>
                        <p class="text-slate-400 leading-relaxed">Lodge maintenance requests anytime with instant status updates.</p>
                    </div>

                    <div class="p-5 rounded-xl bg-slate-800/80 border border-slate-700/80 space-y-2">
                        <span class="text-3xl font-black text-teal-400 block">Zero</span>
                        <span class="font-bold text-white text-sm block">Notice Clutter</span>
                        <p class="text-slate-400 leading-relaxed">Audience filtering keeps every broadcast relevant to you.</p>
                    </div>

                    <div class="p-5 rounded-xl bg-slate-800/80 border border-slate-700/80 space-y-2">
                        <span class="text-3xl font-black text-teal-400 block">Direct</span>
                        <span class="font-bold text-white text-sm block">Transparency</span>
                        <p class="text-slate-400 leading-relaxed">Transparent communication between owners, tenants, and committee.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact & Inquiry Section -->
        <section id="contact" class="py-16 px-4 sm:px-6 max-w-4xl mx-auto space-y-8">
            <div class="text-center space-y-2">
                <span class="text-xs font-bold uppercase tracking-widest text-teal-600">Get In Touch</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Modernize Your Housing Society</h2>
                <p class="text-xs sm:text-sm text-slate-500">Interested in bringing SocietySetu to your residential complex or apartment building? Reach out to our team.</p>
            </div>

            <div class="card p-8 bg-white border border-slate-200 shadow-xs max-w-xl mx-auto space-y-4">
                <div class="space-y-3 text-xs text-slate-600">
                    <div class="flex items-center space-x-3">
                        <span class="w-8 h-8 rounded-lg bg-teal-50 text-teal-700 flex items-center justify-center font-bold">📍</span>
                        <span>Available for Co-operative Housing Societies, Apartment Associations, &amp; Townships</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="w-8 h-8 rounded-lg bg-teal-50 text-teal-700 flex items-center justify-center font-bold">✉️</span>
                        <span>Direct Inquiries: <strong class="text-slate-800 font-medium">support@societysetu.com</strong></span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="w-8 h-8 rounded-lg bg-teal-50 text-teal-700 flex items-center justify-center font-bold">🕒</span>
                        <span>Customer Support: Monday &ndash; Saturday, 9:00 AM &ndash; 6:00 PM IST</span>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-8 px-4 sm:px-6 text-center text-xs text-slate-500 space-y-2">
        <p>&copy; {{ date('Y') }} SocietySetu &bull; Housing Society Management System &bull; All Rights Reserved</p>
        <p class="text-[11px] text-slate-400">Designed for smarter, transparent, and connected residential communities.</p>
    </footer>
</body>
</html>
