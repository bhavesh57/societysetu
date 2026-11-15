<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
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
            <p class="text-xs text-slate-500 font-medium">Resident &amp; Managing Committee App</p>
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

            <form method="POST" action="{{ route('app.login.submit') }}" id="loginForm" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Society Code <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="society_code" name="society_code" value="{{ old('society_code', 'KOHINOOR01') }}" required
                           placeholder="e.g. KOHINOOR01"
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm font-mono font-bold uppercase tracking-wider focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Mobile Number <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" id="mobile" name="mobile" value="{{ old('mobile', '9820011223') }}" required pattern="[0-9]{10}"
                           placeholder="10-digit mobile number"
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            4-Digit PIN / OTP <span class="text-red-500">*</span>
                        </label>
                        <span class="text-[10px] text-teal-600 font-semibold">(Mock OTP: 1234)</span>
                    </div>
                    <input type="password" id="pin" name="pin" value="1234" required minlength="4" maxlength="6"
                           placeholder="Enter 4-digit PIN"
                           class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm font-mono tracking-widest text-center text-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>

                <button type="submit" class="btn-primary w-full py-2.5 text-sm font-semibold shadow-sm mt-2">
                    Enter Society Portal
                </button>
            </form>

            <!-- One-Click Demo Role Fillers for prototype testing -->
            <div class="mt-6 pt-5 border-t border-slate-100">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block text-center mb-2">
                    Quick One-Click Prototype Logins
                </span>
                <div class="grid grid-cols-3 gap-1.5 text-center">
                    <button type="button" onclick="fillLogin('KOHINOOR01', '9820011223', '1234')"
                            class="p-2 rounded border border-teal-200 bg-teal-50/70 hover:bg-teal-100 text-teal-900 transition text-xs">
                        <span class="font-bold block text-[11px]">Committee</span>
                        <span class="text-[9px] text-slate-500">Rajesh S.</span>
                    </button>
                    <button type="button" onclick="fillLogin('KOHINOOR01', '9820077889', '1234')"
                            class="p-2 rounded border border-blue-200 bg-blue-50/70 hover:bg-blue-100 text-blue-900 transition text-xs">
                        <span class="font-bold block text-[11px]">Owner</span>
                        <span class="text-[9px] text-slate-500">Amit D.</span>
                    </button>
                    <button type="button" onclick="fillLogin('KOHINOOR01', '9820099001', '1234')"
                            class="p-2 rounded border border-amber-200 bg-amber-50/70 hover:bg-amber-100 text-amber-900 transition text-xs">
                        <span class="font-bold block text-[11px]">Tenant</span>
                        <span class="text-[9px] text-slate-500">Vikram M.</span>
                    </button>
                </div>
            </div>

            <div class="mt-4 text-center">
                <a href="{{ route('home') }}" class="text-xs text-slate-500 hover:text-slate-800">
                    &larr; Back to Platform Home
                </a>
            </div>
        </div>
    </div>

    <script>
        function fillLogin(code, mob, pin) {
            document.getElementById('society_code').value = code;
            document.getElementById('mobile').value = mob;
            document.getElementById('pin').value = pin;
            document.getElementById('loginForm').submit();
        }
    </script>
</body>
</html>
