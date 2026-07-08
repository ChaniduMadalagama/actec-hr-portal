<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>LogiFlow Dispatch - Admin Sign In</title>
    <script src="/assets/03ba5d9f9e95fc3599acebcbe7e5fb9a.js"></script>
    <link href="/assets/c7c836b4ae5dc2238aa4b499d2db9e8b.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #311042 100%);
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-md">
    <div class="glass-panel w-full max-w-md rounded-2xl overflow-hidden p-lg flex flex-col gap-lg text-white">
        
        <!-- Logo / Brand Header -->
        <div class="text-center">
            <div class="w-14 h-14 bg-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-md shadow-lg shadow-indigo-600/30">
                <span class="material-symbols-outlined text-[32px] text-white">terminal</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight">LogiFlow Dispatch</h1>
            <p class="text-sm text-slate-400 mt-xs">Sign in to control center console</p>
        </div>

        <!-- Error Message Alert -->
        <div id="errorAlert" class="hidden bg-red-950/40 border border-red-500/30 text-red-200 px-md py-sm rounded-lg text-sm flex items-center gap-sm">
            <span class="material-symbols-outlined text-red-400">error</span>
            <span id="errorMessage">Invalid credentials. Please try again.</span>
        </div>

        <!-- Login Form -->
        <form id="loginForm" class="flex flex-col gap-md">
            <div class="flex flex-col gap-xs">
                <label class="text-[11px] font-bold tracking-widest text-slate-400 uppercase">Username</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">person</span>
                    <input type="text" id="username" name="username" required
                        class="w-full pl-10 pr-4 py-sm bg-slate-950/40 border border-slate-700/50 rounded-xl focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-sm transition-all"
                        placeholder="e.g. admin">
                </div>
            </div>

            <div class="flex flex-col gap-xs">
                <label class="text-[11px] font-bold tracking-widest text-slate-400 uppercase">Password</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">lock</span>
                    <input type="password" id="password" name="password" required
                        class="w-full pl-10 pr-4 py-sm bg-slate-950/40 border border-slate-700/50 rounded-xl focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none text-sm transition-all"
                        placeholder="••••••••••••">
                </div>
            </div>

            <button type="submit" id="submitBtn"
                class="w-full py-sm bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl shadow-lg shadow-indigo-600/20 active:scale-98 transition-all flex items-center justify-center gap-sm">
                Sign In
            </button>
        </form>

        <div class="text-center text-xs text-slate-500 mt-md">
            AC Repair Service Management System v1.0.0
        </div>
    </div>

    <script>
        // Check if token exists, redirect to dashboard
        if (localStorage.getItem('api_token')) {
            window.location.href = '/dashboard';
        }

        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const submitBtn = document.getElementById('submitBtn');
            const errorAlert = document.getElementById('errorAlert');
            const errorMessage = document.getElementById('errorMessage');
            
            // UI state loading
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="material-symbols-outlined animate-spin text-sm">sync</span> Signing in...';
            errorAlert.classList.add('hidden');

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            try {
                const response = await fetch('/api/v1/auth/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ username, password })
                });

                const data = await response.json();

                if (response.ok) {
                    // Save token & user profile
                    localStorage.setItem('api_token', data.token);
                    localStorage.setItem('user_profile', JSON.stringify(data.user));
                    
                    window.location.href = '/dashboard';
                } else {
                    // Show validation error or invalid credentials error
                    errorMessage.innerText = data.message || 'Login failed. Please verify your credentials.';
                    errorAlert.classList.remove('hidden');
                }
            } catch (err) {
                console.error(err);
                errorMessage.innerText = 'Unable to connect to the server. Please check your connection.';
                errorAlert.classList.remove('hidden');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Sign In';
            }
        });
    </script>
</body>
</html>
