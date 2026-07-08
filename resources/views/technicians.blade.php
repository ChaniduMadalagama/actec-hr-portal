<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Technician Management - LogiFlow Dispatch</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;600;700;800&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0F1021;
            color: #e0e3e5;
            overflow-x: hidden;
        }
        .glass-card {
            background: rgba(26, 27, 58, 0.8);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.4);
        }
        .glass-modal {
            background: rgba(20, 21, 45, 0.95);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.1);
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
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 20;
        }
        .active-nav-glow {
            box-shadow: 0 0 15px rgba(46, 91, 255, 0.3);
        }
        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }
        .sidebar-active {
            background: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #00dbe7;
            color: #00dbe7;
        }
    </style>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-error-container": "#ffdad6",
                        "primary-container": "#131b2e",
                        "inverse-on-surface": "#2d3133",
                        "on-primary-container": "#efefff",
                        "on-primary": "#002388",
                        "on-error": "#690005",
                        "surface-tint": "#b8c3ff",
                        "on-secondary-container": "#006a70",
                        "inverse-surface": "#e0e3e5",
                        "secondary-fixed-dim": "#00dbe7",
                        "on-secondary": "#00363a",
                        "on-tertiary-fixed": "#171837",
                        "on-primary-fixed-variant": "#0035be",
                        "background": "#101415",
                        "surface-container-high": "#272a2c",
                        "on-primary-fixed": "#001356",
                        "primary": "#b8c3ff",
                        "inverse-primary": "#124af0",
                        "surface-container-lowest": "#0b0f10",
                        "primary-fixed-dim": "#b8c3ff",
                        "surface-bright": "#363a3b",
                        "tertiary-fixed": "#e1e0ff",
                        "surface-container": "#1d2022",
                        "tertiary": "#c3c3eb",
                        "surface-dim": "#101415",
                        "primary-fixed": "#dde1ff",
                        "on-surface-variant": "#c4c5d9",
                        "on-tertiary-container": "#f1eeff",
                        "on-tertiary-fixed-variant": "#434465",
                        "secondary": "#ddfcff",
                        "secondary-fixed": "#74f5ff",
                        "error": "#ffb4ab",
                        "tertiary-fixed-dim": "#c3c3eb",
                        "outline-variant": "#434656",
                        "on-secondary-fixed": "#002022",
                        "outline": "#8e90a2",
                        "surface-container-low": "#191c1e",
                        "surface-container-highest": "#323537",
                        "on-background": "#e0e3e5",
                        "error-container": "#93000a",
                        "surface": "#101415",
                        "on-surface": "#e0e3e5",
                        "tertiary-container": "#696a8e",
                        "on-tertiary": "#2c2d4d",
                        "on-secondary-fixed-variant": "#004f54",
                        "surface-variant": "#323537",
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
                        "unit": "4px",
                        "margin-desktop": "48px",
                        "margin-mobile": "16px",
                        "gutter": "24px"
                    },
                    "fontFamily": {
                        "headline-md": ["Hanken Grotesk"],
                        "headline-xl": ["Hanken Grotesk"],
                        "label-caps": ["JetBrains Mono"],
                        "headline-lg-mobile": ["Hanken Grotesk"],
                        "body-md": ["Inter"],
                        "body-lg": ["Inter"],
                        "headline-lg": ["Hanken Grotesk"],
                        "body-sm": ["Inter"]
                    },
                    "fontSize": {
                        "headline-md": ["24px", { "lineHeight": "32px", "fontWeight": "600" }],
                        "headline-xl": ["48px", { "lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "label-caps": ["12px", { "lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "500" }],
                        "headline-lg-mobile": ["24px", { "lineHeight": "32px", "fontWeight": "600" }],
                        "body-md": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                        "body-lg": ["18px", { "lineHeight": "28px", "fontWeight": "400" }],
                        "headline-lg": ["32px", { "lineHeight": "40px", "fontWeight": "600" }],
                        "body-sm": ["14px", { "lineHeight": "20px", "fontWeight": "400" }]
                    }
                },
            },
        }
    </script>
    <script>
        // Auth Redirect Check
        if (!localStorage.getItem('api_token')) {
            window.location.href = '/login';
        }
    </script>
</head>
<body class="flex min-h-screen">
<div class="bg-glow"></div>

<!-- Side Navigation Bar -->
<aside class="fixed left-0 top-0 h-full w-[280px] bg-primary-container border-r border-white/5 flex flex-col py-6 px-4 gap-4 z-50">
    <div class="flex items-center gap-3 mb-8 px-2">
        <div class="w-10 h-10 rounded-lg bg-secondary flex items-center justify-center">
            <span class="material-symbols-outlined text-on-primary">engineering</span>
        </div>
        <div>
            <h2 class="text-headline-md font-headline-md font-bold text-on-surface text-white">LogiFlow</h2>
            <p class="text-xs text-on-surface-variant">Dispatch HQ</p>
        </div>
    </div>
    <nav class="flex-1 space-y-1">
        <a class="flex items-center gap-3 px-3 py-2.5 text-on-surface-variant hover:bg-white/10 transition-all duration-200 rounded-lg group" href="/dashboard">
            <span class="material-symbols-outlined text-[22px]">dashboard</span>
            <span class="text-label-caps font-label-caps">Dispatch</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-2.5 text-on-surface-variant hover:bg-white/10 transition-all duration-200 rounded-lg group" href="/dashboard">
            <span class="material-symbols-outlined text-[22px]">analytics</span>
            <span class="text-label-caps font-label-caps">Analytics</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-2.5 text-on-surface-variant hover:bg-white/10 transition-all duration-200 rounded-lg group" href="/jobs">
            <span class="material-symbols-outlined text-[22px]">list_alt</span>
            <span class="text-label-caps font-label-caps">Job Queue</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-2.5 bg-white/10 text-on-surface rounded-lg border-l-4 border-secondary-fixed-dim sidebar-active font-bold group" href="/technicians">
            <span class="material-symbols-outlined text-[22px]">engineering</span>
            <span class="text-label-caps font-label-caps font-bold">Technicians</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-2.5 text-on-surface-variant hover:bg-white/10 transition-all duration-200 rounded-lg group" href="/time-logs">
            <span class="material-symbols-outlined text-[22px]">history</span>
            <span class="text-label-caps font-label-caps">Time &amp; Audit</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-2.5 text-on-surface-variant hover:bg-white/10 transition-all duration-200 rounded-lg group" href="/settings">
            <span class="material-symbols-outlined text-[22px]">settings</span>
            <span class="text-label-caps font-label-caps">Settings</span>
        </a>
    </nav>
    <div class="mt-auto space-y-1">
        <button onclick="window.location.href='/jobs/create'" class="w-full mb-6 py-3 px-4 bg-gradient-to-r from-primary-container to-[#124af0] text-white font-semibold rounded-xl flex items-center justify-center gap-2 shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-98 transition-all">
            <span class="material-symbols-outlined text-[20px]">add</span>
            <span class="text-body-sm font-bold">New Dispatch</span>
        </button>
        <a class="flex items-center gap-3 px-3 py-2.5 text-on-surface-variant hover:bg-white/10 transition-all duration-200 rounded-lg group" href="#">
            <span class="material-symbols-outlined text-[22px]">help_outline</span>
            <span class="text-label-caps font-label-caps">Support</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-2.5 text-on-surface-variant hover:bg-white/10 transition-all duration-200 rounded-lg group cursor-pointer" onclick="handleLogout()">
            <span class="material-symbols-outlined text-[22px]">logout</span>
            <span class="text-label-caps font-label-caps">Sign Out</span>
        </a>
    </div>
</aside>

<!-- Main Content -->
<main class="ml-[280px] flex-1 flex flex-col min-h-screen">
    <!-- Top Navigation Bar -->
    <header class="h-16 sticky top-0 z-40 bg-surface-container/80 backdrop-blur-lg border-b border-white/10 flex justify-between items-center w-full px-8 shadow-sm">
        <div class="flex items-center flex-1 max-w-xl">
            <div class="relative w-full max-w-md">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">search</span>
                <input id="techSearchInput" class="w-full bg-[#1A1B3A] border border-white/10 rounded-lg pl-10 pr-4 py-2 text-body-sm focus:outline-none focus:border-secondary transition-colors text-on-surface placeholder:text-outline/50" placeholder="Search technician by name or email..." type="text"/>
            </div>
        </div>
        <div class="flex items-center gap-6">
            <div class="flex items-center gap-3">
                <button class="p-2 text-on-surface-variant hover:bg-white/5 rounded-full transition-colors relative">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-secondary rounded-full"></span>
                </button>
                <button class="p-2 text-on-surface-variant hover:bg-white/5 rounded-full transition-colors">
                    <span class="material-symbols-outlined">help</span>
                </button>
            </div>
            <button onclick="openModal()" class="bg-secondary text-on-secondary px-6 py-2 rounded-lg flex items-center gap-2 font-semibold text-body-sm transition-all shadow-lg shadow-primary/20 hover:brightness-105 active:scale-95">
                <span class="material-symbols-outlined text-[20px]">person_add</span>
                Register New Technician
            </button>
            <div class="flex items-center gap-2 pl-4 border-l border-white/10">
                <div class="w-8 h-8 rounded-full bg-surface-container-highest overflow-hidden">
                    <img class="w-full h-full object-cover" src="/assets/a219ec9d098081f311e070b70333095d.png" alt="Admin avatar"/>
                </div>
            </div>
        </div>
    </header>

    <!-- Canvas Area -->
    <div class="p-8 space-y-8">
        <div class="flex items-center justify-between">
            <h1 class="text-headline-lg font-headline-lg text-on-surface text-white">Technician Management</h1>
        </div>

        <!-- Metric Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Technicians -->
            <div class="glass-card rounded-xl p-6 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <span class="material-symbols-outlined text-6xl">engineering</span>
                </div>
                <p class="text-label-caps font-label-caps text-on-surface-variant mb-4 uppercase tracking-widest">Total Technicians</p>
                <div class="flex items-end gap-2">
                    <h3 id="totalTechsCount" class="text-headline-xl font-headline-xl text-primary">0</h3>
                    <span class="text-body-sm text-on-surface-variant mb-2 font-medium">Headcount</span>
                </div>
                <div class="mt-4 h-1 w-full bg-white/5 rounded-full overflow-hidden">
                    <div class="h-full bg-primary w-full shadow-[0_0_8px_rgba(184,195,255,0.5)]"></div>
                </div>
            </div>
            <!-- On-Duty (Active) -->
            <div class="glass-card rounded-xl p-6 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <span class="material-symbols-outlined text-6xl">bolt</span>
                </div>
                <p class="text-label-caps font-label-caps text-on-surface-variant mb-4 uppercase tracking-widest">On-Duty (Active)</p>
                <div class="flex items-end gap-2">
                    <h3 id="activeTechsCount" class="text-headline-xl font-headline-xl text-secondary">0</h3>
                    <span class="text-body-sm text-on-surface-variant mb-2 font-medium">Currently online</span>
                </div>
                <div class="mt-4 h-1 w-full bg-white/5 rounded-full overflow-hidden">
                    <div class="h-full bg-secondary w-1/2 transition-all duration-1000 shadow-[0_0_8px_rgba(0,219,231,0.5)]"></div>
                </div>
            </div>
            <!-- Off-Duty (Offline) -->
            <div class="glass-card rounded-xl p-6 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <span class="material-symbols-outlined text-6xl">cloud_off</span>
                </div>
                <p class="text-label-caps font-label-caps text-on-surface-variant mb-4 uppercase tracking-widest">Off-Duty (Offline)</p>
                <div class="flex items-end gap-2">
                    <h3 id="offlineTechsCount" class="text-headline-xl font-headline-xl text-on-surface text-white">0</h3>
                    <span class="text-body-sm text-on-surface-variant mb-2 font-medium">Offline</span>
                </div>
                <div class="mt-4 h-1 w-full bg-white/5 rounded-full overflow-hidden">
                    <div class="h-full bg-white/20 w-full"></div>
                </div>
            </div>
        </div>

        <!-- Technician Directory Table -->
        <div class="glass-card rounded-xl overflow-hidden shadow-2xl">
            <div class="px-6 py-5 border-b border-white/10 flex items-center justify-between">
                <h2 class="text-headline-md font-headline-md text-on-surface text-white">Technician Directory</h2>
                <div class="flex items-center gap-2">
                    <button class="p-2 hover:bg-white/5 rounded-lg transition-colors">
                        <span class="material-symbols-outlined text-[20px] text-on-surface-variant">filter_list</span>
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white/5 border-b border-white/10">
                            <th class="px-6 py-4 text-label-caps font-label-caps text-on-surface-variant uppercase tracking-wider">Name</th>
                            <th class="px-6 py-4 text-label-caps font-label-caps text-on-surface-variant uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-label-caps font-label-caps text-on-surface-variant uppercase tracking-wider">Username</th>
                            <th class="px-6 py-4 text-label-caps font-label-caps text-on-surface-variant uppercase tracking-wider">Live Status</th>
                        </tr>
                    </thead>
                    <tbody id="techsTableBody" class="divide-y divide-white/5">
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-outline">Loading technicians...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Registration Modal Overlay -->
<div class="fixed inset-0 z-[100] hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-6" id="registrationModal">
    <!-- Form View -->
    <div class="glass-modal w-full max-w-lg rounded-xl shadow-2xl overflow-hidden" id="formView">
        <div class="px-8 py-5 border-b border-white/10 flex justify-between items-center bg-white/5">
            <div>
                <h2 class="font-headline-sm text-headline-sm font-bold text-on-surface text-white">Register New Technician</h2>
                <p class="text-body-sm text-on-surface-variant">Initialize a new employee profile in the dispatch network.</p>
            </div>
            <button class="p-2 hover:bg-white/10 rounded-full text-white transition-colors" onclick="closeModal()">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form class="p-8 space-y-6" id="techForm" onsubmit="handleRegistration(event)">
            <div class="space-y-2">
                <label class="font-label-caps text-label-caps text-on-surface-variant block">FULL NAME</label>
                <input class="w-full bg-[#1A1B3A] border border-white/10 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-secondary focus:border-transparent outline-none" id="fullName" placeholder="e.g. Michael Finn" required type="text" />
            </div>
            <div class="space-y-2">
                <label class="font-label-caps text-label-caps text-on-surface-variant block">USERNAME</label>
                <input class="w-full bg-[#1A1B3A] border border-white/10 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-secondary focus:border-transparent outline-none" id="usernameInput" placeholder="e.g. m_finn" required type="text" />
            </div>
            <div class="space-y-2">
                <label class="font-label-caps text-label-caps text-on-surface-variant block">EMAIL ADDRESS</label>
                <input class="w-full bg-[#1A1B3A] border border-white/10 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-secondary focus:border-transparent outline-none" id="email" placeholder="m.finn@logiflow.com" required type="email" />
            </div>
            <div class="pt-6 border-t border-white/10 flex justify-end gap-4">
                <button class="px-4 py-2.5 font-bold text-on-surface-variant hover:bg-white/5 rounded-lg transition-colors" onclick="closeModal()" type="button">Cancel</button>
                <button class="px-6 py-2.5 bg-secondary text-on-secondary font-bold rounded-lg shadow-lg shadow-secondary/20 hover:brightness-105 active:scale-95 transition-all" type="submit">Create Profile</button>
            </div>
        </form>
    </div>

    <!-- Success View (Hidden initially) -->
    <div class="hidden glass-modal w-full max-w-lg rounded-xl shadow-2xl overflow-hidden" id="successView">
        <div class="p-8 text-center bg-emerald-950/20 border-b border-white/10">
            <div class="w-16 h-16 bg-emerald-500/10 text-emerald-400 rounded-full flex items-center justify-center mx-auto mb-4 border-2 border-emerald-500/30 shadow-lg">
                <span class="material-symbols-outlined text-[32px]">check_circle</span>
            </div>
            <h2 class="font-headline-md text-headline-md font-bold text-white">Registration Successful</h2>
            <p class="text-body-md text-on-surface-variant mt-2">Profile created for <span class="font-bold text-white" id="displayTechName">Michael Finn</span></p>
        </div>
        <div class="p-8 space-y-6">
            <div class="grid grid-cols-2 gap-4">
                <div class="p-4 bg-white/5 rounded-xl border border-white/5">
                    <p class="text-label-caps font-label-caps text-on-surface-variant mb-1">UNIQUE USERNAME</p>
                    <p class="font-label-caps text-secondary text-base" id="genUsername">@m_finn</p>
                </div>
                <div class="p-4 bg-white/5 rounded-xl border border-white/5">
                    <p class="text-label-caps font-label-caps text-on-surface-variant mb-1">TEMPORARY PASSWORD</p>
                    <p class="font-label-caps text-white text-base tracking-wider" id="genPassword">LF-772-XT9</p>
                </div>
            </div>
            <div class="space-y-2">
                <label class="font-label-caps text-label-caps text-on-surface-variant block">INVITATION TEMPLATE</label>
                <div class="p-4 bg-black/40 border border-white/5 rounded-lg text-body-sm text-on-surface-variant italic leading-relaxed" id="invitationTemplateText">
                </div>
            </div>
            <button class="w-full py-3 bg-white/5 border border-white/10 rounded-lg text-white font-bold hover:bg-white/10 transition-colors" onclick="closeModal()">Done, Return to List</button>
        </div>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('registrationModal').classList.remove('hidden');
        document.getElementById('formView').classList.remove('hidden');
        document.getElementById('successView').classList.add('hidden');
    }

    function closeModal() {
        document.getElementById('registrationModal').classList.add('hidden');
        document.getElementById('techForm').reset();
        loadTechnicians(); // Refresh list on modal close
    }

    async function loadTechnicians() {
        const token = localStorage.getItem('api_token');
        try {
            const response = await fetch('/api/v1/admin/users/technicians', {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });
            const techs = await response.json();
            if (response.ok) {
                renderTechs(techs);
            }
        } catch (err) {
            console.error('Error loading technicians:', err);
        }
    }

    function renderTechs(techs) {
        // Stats
        document.getElementById('totalTechsCount').innerText = techs.length;
        document.getElementById('activeTechsCount').innerText = techs.filter(t => t.currentStatus === 'on_duty').length;
        document.getElementById('offlineTechsCount').innerText = techs.filter(t => t.currentStatus === 'off_duty').length;

        // Table Body
        const tbody = document.getElementById('techsTableBody');
        if (techs.length === 0) {
            tbody.innerHTML = `<tr><td colspan="4" class="px-6 py-8 text-center text-outline">No technicians registered.</td></tr>`;
            return;
        }

        tbody.innerHTML = techs.map(tech => {
            const statusBadge = tech.currentStatus === 'on_duty'
                ? `<span class="inline-flex items-center px-3 py-1 bg-emerald-500/10 text-emerald-400 rounded-full text-[11px] font-bold uppercase tracking-wider border border-emerald-500/20"><span class="status-dot bg-emerald-400 animate-pulse"></span>On Duty</span>`
                : `<span class="inline-flex items-center px-3 py-1 bg-white/5 text-on-surface-variant rounded-full text-[11px] font-bold uppercase tracking-wider border border-white/10"><span class="status-dot bg-gray-400"></span>Off Duty</span>`;

            // Initials helper
            const initials = tech.name.split(' ').map(n => n[0]).join('').slice(0, 2).toUpperCase();

            return `
                <tr class="hover:bg-white/[0.02] transition-colors group">
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center border border-white/5 font-bold text-primary group-hover:scale-105 transition-transform">
                                ${initials}
                            </div>
                            <span class="font-semibold text-white text-body-md">${escapeHtml(tech.name)}</span>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-body-sm text-on-surface-variant">${escapeHtml(tech.email)}</td>
                    <td class="px-6 py-5 text-body-sm font-mono text-secondary">@${escapeHtml(tech.username)}</td>
                    <td class="px-6 py-5">${statusBadge}</td>
                </tr>
            `;
        }).join('');
    }

    async function handleRegistration(event) {
        event.preventDefault();
        const token = localStorage.getItem('api_token');
        const submitBtn = event.target.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<span class="material-symbols-outlined animate-spin text-sm">sync</span> Registering...';
        submitBtn.disabled = true;

        const name = document.getElementById('fullName').value;
        const username = document.getElementById('usernameInput').value;
        const email = document.getElementById('email').value;

        try {
            const response = await fetch('/api/v1/admin/users/register', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ name, email, username })
            });

            const data = await response.json();

            if (response.ok) {
                document.getElementById('displayTechName').innerText = data.user.name;
                document.getElementById('genUsername').innerText = `@${data.username}`;
                document.getElementById('genPassword').innerText = data.password;

                document.getElementById('invitationTemplateText').innerText = 
                    `Welcome to LogiFlow, ${data.user.name}! Your technician account has been created. Username: @${data.username} | Password: ${data.password}. Please sign in to start duty.`;

                document.getElementById('formView').classList.add('hidden');
                document.getElementById('successView').classList.remove('hidden');
            } else {
                alert(data.message || 'Registration failed.');
            }
        } catch (err) {
            console.error(err);
            alert('Server error registering technician.');
        } finally {
            submitBtn.innerHTML = 'Create Profile';
            submitBtn.disabled = false;
        }
    }

    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
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

    // Search filter for table
    document.getElementById('techSearchInput').addEventListener('input', (e) => {
        const val = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('#techsTableBody tr');
        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(val) ? '' : 'none';
        });
    });

    // Close on escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeModal();
    });

    // Initial load
    loadTechnicians();
</script>
</body>
</html>