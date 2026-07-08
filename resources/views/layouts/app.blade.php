<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'LogiFlow Dispatch | Control Center')</title>
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;600;700;800&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet"/>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "secondary": "#ddfcff",
                        "inverse-primary": "#124af0",
                        "surface-container-low": "#191c1e",
                        "primary-fixed-dim": "#b8c3ff",
                        "on-background": "#e0e3e5",
                        "error": "#ffb4ab",
                        "surface-container": "#1d2022",
                        "surface-container-lowest": "#0b0f10",
                        "outline": "#8e90a2",
                        "tertiary": "#c3c3eb",
                        "surface": "#101415",
                        "primary-container": "#131b2e",
                        "secondary-fixed-dim": "#00dbe7",
                        "on-secondary-fixed": "#002022",
                        "on-tertiary-container": "#f1eeff",
                        "primary": "#b8c3ff",
                        "on-surface-variant": "#c4c5d9",
                        "on-primary-container": "#efefff",
                        "primary-fixed": "#dde1ff",
                        "on-primary": "#002388",
                        "outline-variant": "#434656",
                        "tertiary-fixed-dim": "#c3c3eb",
                        "on-primary-fixed-variant": "#0035be",
                        "on-tertiary": "#2c2d4d",
                        "tertiary-container": "#696a8e",
                        "surface-container-highest": "#323537",
                        "on-tertiary-fixed": "#171837",
                        "inverse-surface": "#e0e3e5",
                        "on-surface": "#e0e3e5",
                        "on-primary-fixed": "#001356",
                        "tertiary-fixed": "#e1e0ff",
                        "surface-bright": "#363a3b",
                        "on-error-container": "#ffdad6",
                        "on-secondary-fixed-variant": "#004f54",
                        "surface-container-high": "#272a2c",
                        "on-error": "#690005",
                        "inverse-on-surface": "#2d3133",
                        "surface-tint": "#b8c3ff",
                        "secondary-fixed": "#74f5ff",
                        "on-secondary": "#00363a",
                        "surface-variant": "#323537",
                        "on-tertiary-fixed-variant": "#434465",
                        "background": "#101415",
                        "on-secondary-container": "#006a70",
                        "surface-dim": "#101415",
                        "error-container": "#93000a",
                        "secondary-container": "#2170e4"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "container-max": "1440px",
                        "margin-mobile": "16px",
                        "gutter": "24px",
                        "unit": "4px",
                        "margin-desktop": "48px"
                    },
                    "fontFamily": {
                        "headline-xl": ["Hanken Grotesk"],
                        "headline-md": ["Hanken Grotesk"],
                        "label-caps": ["JetBrains Mono"],
                        "body-md": ["Inter"],
                        "headline-lg-mobile": ["Hanken Grotesk"],
                        "headline-lg": ["Hanken Grotesk"],
                        "body-sm": ["Inter"],
                        "body-lg": ["Inter"]
                    },
                    "fontSize": {
                        "headline-xl": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "label-caps": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "500"}],
                        "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "headline-lg-mobile": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "headline-lg": ["32px", {"lineHeight": "40px", "fontWeight": "600"}],
                        "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                        "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}]
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .glass-card {
            background: rgba(26, 27, 58, 0.7);
            backdrop-filter: blur(16px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            border-left: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.4);
        }
        .glass-modal {
            background: rgba(20, 21, 45, 0.95);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .sidebar-active {
            background: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #00dbe7;
            color: #00dbe7;
        }
        body {
            background-color: #0F1021;
            color: #e0e3e5;
            overflow-x: hidden;
            font-family: 'Inter', sans-serif;
        }
        .bg-glow {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
            background: radial-gradient(circle at 80% 20%, rgba(46, 91, 255, 0.12) 0%, transparent 40%),
                        radial-gradient(circle at 20% 80%, rgba(0, 219, 231, 0.08) 0%, transparent 40%);
            pointer-events: none;
        }
    </style>
    <script>
        // Auth Redirect Check
        if (!localStorage.getItem('api_token')) {
            window.location.href = '/login';
        }
    </script>
    @yield('styles')
</head>
<body class="font-body-md text-body-md antialiased min-h-screen flex flex-col">
<div class="bg-glow"></div>

<!-- SideNavBar -->
<aside class="fixed left-0 top-0 h-full w-[280px] bg-primary-container border-r border-white/5 flex flex-col py-6 px-4 gap-4 z-50 shadow-2xl shadow-black/40">
    <div class="flex items-center gap-3 mb-8 px-2">
        <div class="w-10 h-10 rounded-lg bg-secondary flex items-center justify-center text-on-primary-container shadow-lg shadow-primary/20">
            <span class="material-symbols-outlined text-2xl text-on-primary">ac_unit</span>
        </div>
        <div>
            <h2 class="text-headline-md font-headline-md font-bold text-on-surface leading-tight text-white">LogiFlow</h2>
            <p class="text-[10px] font-label-caps text-primary/70 uppercase tracking-widest">Precision Dispatch</p>
        </div>
    </div>
    <nav class="flex-1 flex flex-col gap-1">
        <a class="flex items-center gap-3 px-3 py-3 text-on-surface-variant hover:text-on-surface hover:bg-white/10 rounded-lg transition-all duration-200 {{ Request::is('dashboard') || Request::is('/') ? 'sidebar-active font-bold' : '' }}" href="/dashboard">
            <span class="material-symbols-outlined">calendar_today</span>
            <span class="font-label-caps">Dispatch</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-3 text-on-surface-variant hover:text-on-surface hover:bg-white/10 rounded-lg transition-all duration-200" href="/dashboard">
            <span class="material-symbols-outlined">insights</span>
            <span class="font-label-caps">Analytics</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-3 text-on-surface-variant hover:text-on-surface hover:bg-white/10 rounded-lg transition-all duration-200 {{ Request::is('jobs') ? 'sidebar-active font-bold' : '' }}" href="/jobs">
            <span class="material-symbols-outlined">list_alt</span>
            <span class="font-label-caps">Job Queue</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-3 text-on-surface-variant hover:text-on-surface hover:bg-white/10 rounded-lg transition-all duration-200 {{ Request::is('technicians') ? 'sidebar-active font-bold' : '' }}" href="/technicians">
            <span class="material-symbols-outlined">engineering</span>
            <span class="font-label-caps">Technicians</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-3 text-on-surface-variant hover:text-on-surface hover:bg-white/10 rounded-lg transition-all duration-200 {{ Request::is('time-logs') ? 'sidebar-active font-bold' : '' }}" href="/time-logs">
            <span class="material-symbols-outlined">history</span>
            <span class="font-label-caps">Time &amp; Audit</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-3 text-on-surface-variant hover:text-on-surface hover:bg-white/10 rounded-lg transition-all duration-200 {{ Request::is('settings') ? 'sidebar-active font-bold' : '' }}" href="/settings">
            <span class="material-symbols-outlined">settings</span>
            <span class="font-label-caps">Settings</span>
        </a>
    </nav>
    <div class="mt-auto flex flex-col gap-1 border-t border-white/5 pt-4">
        <button onclick="window.location.href='/jobs/create'" class="w-full bg-primary text-on-primary font-bold py-3 rounded-lg flex items-center justify-center gap-2 mb-4 hover:opacity-90 active:scale-95 transition-all">
            <span class="material-symbols-outlined">add</span>
            <span class="font-label-caps">New Dispatch</span>
        </button>
        <a class="flex items-center gap-3 px-3 py-2 text-on-surface-variant hover:text-on-surface hover:bg-white/10 rounded-lg transition-all duration-200" href="#">
            <span class="material-symbols-outlined">help_outline</span>
            <span class="font-label-caps">Support</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 text-on-surface-variant hover:text-on-surface hover:bg-white/10 rounded-lg transition-all duration-200 cursor-pointer" onclick="handleLogout()">
            <span class="material-symbols-outlined">logout</span>
            <span class="font-label-caps">Sign Out</span>
        </a>
    </div>
</aside>

<!-- Main Content Area -->
<main class="ml-[280px] min-h-screen flex flex-col">
    <!-- TopNavBar -->
    <header class="h-16 sticky top-0 z-40 bg-surface-container/80 backdrop-blur-lg border-b border-white/10 px-12 flex justify-between items-center w-full">
        <div class="flex items-center gap-4 flex-1">
            <div class="relative w-full max-w-md">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-xl">search</span>
                <input id="globalSearchInput" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-full py-2 pl-10 pr-4 text-body-sm focus:outline-none focus:border-primary/50 transition-colors placeholder:text-outline/50 text-white" placeholder="Search..." type="text"/>
            </div>
        </div>
        <div class="flex items-center gap-4">
            @yield('header-actions')
            <div class="flex items-center gap-2">
                <button class="p-2 text-on-surface-variant hover:bg-white/5 rounded-full transition-colors relative">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-secondary rounded-full"></span>
                </button>
                <button class="p-2 text-on-surface-variant hover:bg-white/5 rounded-full transition-colors">
                    <span class="material-symbols-outlined">help</span>
                </button>
                <div class="flex items-center gap-3 pl-4 border-l border-white/10">
                    <div class="text-right hidden md:block">
                        <p id="dispatcherName" class="font-headline-md text-body-sm font-semibold text-white">HQ Supervisor</p>
                        <p class="font-label-caps text-[10px] text-outline uppercase">Active Duty</p>
                    </div>
                    <div class="w-8 h-8 rounded-full overflow-hidden border border-primary/30">
                        <img id="dispatcherAvatar" class="w-full h-full object-cover" src="/assets/a219ec9d098081f311e070b70333095d.png" alt="User avatar"/>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Content Body -->
    <div class="p-12 flex flex-col gap-8 max-w-[1400px] w-full mx-auto flex-grow">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="mt-auto px-12 py-6 bg-surface-container-lowest border-t border-white/5 flex justify-between items-center text-outline">
        <p class="font-label-caps text-label-caps uppercase tracking-widest">© 2026 LogiFlow Dispatch Systems</p>
        <div class="flex gap-8 font-label-caps text-label-caps">
            <a class="hover:text-primary transition-colors" href="#">Privacy Policy</a>
            <a class="hover:text-primary transition-colors" href="#">Terms of Service</a>
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                <span class="hover:text-primary transition-colors">System Status: Optimal</span>
            </div>
        </div>
    </footer>
</main>

<script>
    // Load Admin Profile Info
    const userProfile = JSON.parse(localStorage.getItem('user_profile') || '{}');
    const dispatcherNameEl = document.getElementById('dispatcherName');
    if (userProfile.name && dispatcherNameEl) {
        dispatcherNameEl.innerText = userProfile.name;
    }

    async function handleLogout() {
        const token = localStorage.getItem('api_token');
        try {
            await fetch('/api/v1/auth/logout', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });
        } catch (err) {
            console.error(err);
        } finally {
            localStorage.clear();
            window.location.href = '/login';
        }
    }
</script>
@yield('scripts')
</body>
</html>
