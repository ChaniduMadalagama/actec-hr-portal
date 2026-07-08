<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>LogiFlow Dispatch | Control Center</title>
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;600;700&family=Inter:wght@400;500&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet"/>
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
    </style>
    <script>
        // Auth Redirect Check
        if (!localStorage.getItem('api_token')) {
            window.location.href = '/login';
        }
    </script>
</head>
<body class="font-body-md text-body-md antialiased min-h-screen flex flex-col">

<!-- SideNavBar -->
<aside class="fixed left-0 top-0 h-full w-[280px] bg-primary-container border-r border-white/5 flex flex-col py-8 px-4 gap-4 z-50 shadow-2xl shadow-black/40">
    <div class="flex flex-col gap-1 mb-8 px-4">
        <h1 class="font-headline-md text-headline-md text-primary">LogiFlow</h1>
        <p class="font-label-caps text-label-caps text-on-surface-variant uppercase tracking-widest">Precision Dispatch</p>
    </div>
    <nav class="flex-1 flex flex-col gap-2">
        <a class="flex items-center gap-3 py-3 px-4 rounded-lg transition-all duration-200 sidebar-active font-bold" href="/dashboard">
            <span class="material-symbols-outlined">calendar_today</span>
            <span>Dispatch</span>
        </a>
        <a class="flex items-center gap-3 py-3 px-4 rounded-lg transition-all duration-200 text-on-surface-variant hover:bg-white/5 hover:text-on-surface" href="/dashboard">
            <span class="material-symbols-outlined">insights</span>
            <span>Analytics</span>
        </a>
        <a class="flex items-center gap-3 py-3 px-4 rounded-lg transition-all duration-200 text-on-surface-variant hover:bg-white/5 hover:text-on-surface" href="/jobs">
            <span class="material-symbols-outlined">list_alt</span>
            <span>Job Queue</span>
        </a>
        <a class="flex items-center gap-3 py-3 px-4 rounded-lg transition-all duration-200 text-on-surface-variant hover:bg-white/5 hover:text-on-surface" href="/technicians">
            <span class="material-symbols-outlined">engineering</span>
            <span>Technicians</span>
        </a>
        <a class="flex items-center gap-3 py-3 px-4 rounded-lg transition-all duration-200 text-on-surface-variant hover:bg-white/5 hover:text-on-surface" href="/time-logs">
            <span class="material-symbols-outlined">history</span>
            <span>Time &amp; Audit</span>
        </a>
        <a class="flex items-center gap-3 py-3 px-4 rounded-lg transition-all duration-200 text-on-surface-variant hover:bg-white/5 hover:text-on-surface" href="/settings">
            <span class="material-symbols-outlined">settings</span>
            <span>Settings</span>
        </a>
    </nav>
    <button onclick="window.location.href='/jobs/create'" class="mt-4 mx-4 py-3 bg-gradient-to-r from-primary-container to-[#124af0] text-white font-headline-md text-body-md rounded-xl shadow-lg hover:shadow-primary/20 transition-all active:scale-95 flex items-center justify-center gap-2">
        <span class="material-symbols-outlined">add</span>
        New Dispatch
    </button>
    <div class="mt-auto flex flex-col gap-2 pt-6 border-t border-white/10">
        <a class="flex items-center gap-3 py-2 px-4 text-outline hover:text-primary transition-colors font-label-caps" href="#">
            <span class="material-symbols-outlined">help</span>
            <span>Support</span>
        </a>
        <a class="flex items-center gap-3 py-2 px-4 text-outline hover:text-primary transition-colors font-label-caps cursor-pointer" onclick="handleLogout()">
            <span class="material-symbols-outlined">logout</span>
            <span>Log Out</span>
        </a>
    </div>
</aside>

<!-- Main Content Area -->
<main class="ml-[280px] min-h-screen flex flex-col">
    <!-- TopNavBar -->
    <header class="h-16 px-12 flex justify-between items-center bg-surface/80 backdrop-blur-lg border-b border-white/10 shadow-lg shadow-black/20 sticky top-0 z-40">
        <div class="flex items-center gap-6 flex-1">
            <div class="relative w-full max-w-xl">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
                <input id="jobSearchInput" class="w-full bg-[#1A1B3A] border border-primary/30 rounded-full py-2 pl-10 pr-4 focus:ring-2 focus:ring-secondary-fixed-dim focus:border-transparent outline-none transition-all placeholder:text-outline/50" placeholder="Search jobs, techs, or clients..." type="text"/>
            </div>
        </div>
        <div class="flex items-center gap-6">
            <div class="flex items-center gap-3">
                <button class="p-2 text-on-surface-variant hover:bg-white/5 rounded-full transition-colors active:scale-95 duration-150 relative">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full"></span>
                </button>
                <button class="p-2 text-on-surface-variant hover:bg-white/5 rounded-full transition-colors active:scale-95 duration-150">
                    <span class="material-symbols-outlined">settings</span>
                </button>
            </div>
            <div class="flex items-center gap-3 pl-6 border-l border-white/10">
                <div class="text-right">
                    <p id="dispatcherName" class="font-headline-md text-body-sm font-semibold text-white">HQ Supervisor</p>
                    <p class="font-label-caps text-[10px] text-outline uppercase">Active Duty</p>
                </div>
                <img alt="User profile avatar" class="w-10 h-10 rounded-full border-2 border-secondary-fixed-dim object-cover" src="/assets/a219ec9d098081f311e070b70333095d.png"/>
            </div>
        </div>
    </header>

    <!-- Page Content Container -->
    <section class="p-12 flex flex-col gap-6">
        <!-- Header Text -->
        <div>
            <h2 class="font-headline-lg text-headline-lg text-white mb-1">Dispatch Overview</h2>
            <p class="text-outline font-body-md">Managing real-time operations for Dispatch HQ</p>
        </div>

        <!-- Summary Metrics Bento -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="glass-card p-6 rounded-2xl flex flex-col justify-between h-32 relative overflow-hidden group">
                <div class="flex justify-between items-start">
                    <p class="font-label-caps text-label-caps text-outline uppercase">Active Jobs</p>
                    <div class="p-2 bg-primary/10 rounded-lg">
                        <span class="material-symbols-outlined text-primary text-[20px]">assignment</span>
                    </div>
                </div>
                <h3 id="activeJobsCount" class="font-headline-xl text-[40px] leading-none text-white">0</h3>
            </div>
            <div class="glass-card p-6 rounded-2xl flex flex-col justify-between h-32 relative overflow-hidden group">
                <div class="flex justify-between items-start">
                    <p class="font-label-caps text-label-caps text-outline uppercase">Pending Requests</p>
                    <div class="p-2 bg-secondary-fixed-dim/10 rounded-lg">
                        <span class="material-symbols-outlined text-secondary-fixed-dim text-[20px]">hourglass_empty</span>
                    </div>
                </div>
                <h3 id="pendingJobsCount" class="font-headline-xl text-[40px] leading-none text-white">0</h3>
            </div>
            <div class="glass-card p-6 rounded-2xl flex flex-col justify-between h-32 relative overflow-hidden group">
                <div class="flex justify-between items-start">
                    <p class="font-label-caps text-label-caps text-outline uppercase">Techs On-Duty</p>
                    <div class="p-2 bg-tertiary/10 rounded-lg">
                        <span class="material-symbols-outlined text-tertiary text-[20px]">engineering</span>
                    </div>
                </div>
                <h3 id="onDutyTechsCount" class="font-headline-xl text-[40px] leading-none text-white">0</h3>
            </div>
            <div class="glass-card p-6 rounded-2xl flex flex-col justify-between h-32 relative overflow-hidden group">
                <div class="flex justify-between items-start">
                    <p class="font-label-caps text-label-caps text-outline uppercase">Completed Jobs</p>
                    <div class="p-2 bg-green-400/10 rounded-lg">
                        <span class="material-symbols-outlined text-green-400 text-[20px]">check_circle</span>
                    </div>
                </div>
                <h3 id="completedJobsCount" class="font-headline-xl text-[40px] leading-none text-white">0</h3>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Monitor Table -->
            <div class="lg:col-span-2 glass-card rounded-2xl overflow-hidden flex flex-col">
                <div class="px-6 py-4 flex items-center justify-between border-b border-white/5 bg-white/5">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">analytics</span>
                        <h3 class="font-headline-md text-body-lg font-bold">Active Jobs Monitor</h3>
                    </div>
                    <a href="/jobs" class="text-secondary-fixed-dim text-body-sm hover:underline">View All Queue</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="font-label-caps text-[11px] text-outline uppercase border-b border-white/5">
                                <th class="px-6 py-4">Job ID</th>
                                <th class="px-6 py-4">Client</th>
                                <th class="px-6 py-4">Assigned Tech</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Scheduled</th>
                            </tr>
                        </thead>
                        <tbody id="activeJobsTableBody" class="divide-y divide-white/5">
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-outline">Loading active jobs...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Map Visualization -->
            <div class="glass-card rounded-2xl overflow-hidden flex flex-col h-[550px]">
                <div class="px-6 py-4 flex items-center gap-2 border-b border-white/5 bg-white/5">
                    <span class="material-symbols-outlined text-primary">map</span>
                    <h3 class="font-headline-md text-body-lg font-bold">Live Dispatch Map</h3>
                </div>
                <div class="relative flex-1">
                    <iframe class="w-full h-full border-none opacity-80" 
                        src="https://maps.google.com/maps?q=Chicago&t=&z=11&ie=UTF8&iwloc=&output=embed"></iframe>
                    <div class="absolute inset-0 pointer-events-none border-2 border-indigo-600/10"></div>
                </div>
            </div>
        </div>
    </section>

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
    // Load Admin Profile Name
    const userProfile = JSON.parse(localStorage.getItem('user_profile') || '{}');
    const dispatcherNameEl = document.getElementById('dispatcherName');
    if (userProfile.name && dispatcherNameEl) {
        dispatcherNameEl.innerText = userProfile.name;
    }

    // Load Metrics and Active Jobs
    async function loadDashboardData() {
        const token = localStorage.getItem('api_token');
        try {
            // Fetch Jobs
            const jobsResponse = await fetch('/api/v1/admin/jobs', {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });
            const jobs = await jobsResponse.json();

            // Fetch Technicians
            const techsResponse = await fetch('/api/v1/admin/users/technicians', {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });
            const technicians = await techsResponse.json();

            if (jobsResponse.ok && techsResponse.ok) {
                renderDashboard(jobs, technicians);
            }
        } catch (err) {
            console.error('Error loading dashboard data:', err);
        }
    }

    function renderDashboard(jobs, technicians) {
        // Calculate Metrics
        const totalActive = jobs.filter(j => j.status === 'in-progress' || j.status === 'in-route').length;
        const totalPending = jobs.filter(j => j.status === 'pending').length;
        const totalCompleted = jobs.filter(j => j.status === 'completed').length;
        const techsOnDuty = technicians.filter(t => t.currentStatus === 'on_duty').length;

        document.getElementById('activeJobsCount').innerText = totalActive;
        document.getElementById('pendingJobsCount').innerText = totalPending;
        document.getElementById('completedJobsCount').innerText = totalCompleted;
        document.getElementById('onDutyTechsCount').innerText = techsOnDuty;

        // Render Active Jobs Table
        const tbody = document.getElementById('activeJobsTableBody');
        const activeJobs = jobs.filter(j => j.status !== 'completed');

        if (activeJobs.length === 0) {
            tbody.innerHTML = `<tr><td colspan="5" class="px-6 py-8 text-center text-outline">No active service jobs.</td></tr>`;
            return;
        }

        tbody.innerHTML = activeJobs.map(job => {
            let statusBadge = '';
            switch(job.status) {
                case 'pending':
                    statusBadge = `<span class="px-3 py-1 bg-amber-400/10 text-amber-400 text-[10px] font-bold rounded-full uppercase tracking-tight">Pending</span>`;
                    break;
                case 'in-route':
                    statusBadge = `<span class="px-3 py-1 bg-blue-500/10 text-blue-400 text-[10px] font-bold rounded-full uppercase tracking-tight">In-Route</span>`;
                    break;
                case 'in-progress':
                    statusBadge = `<span class="px-3 py-1 bg-indigo-500/10 text-indigo-400 text-[10px] font-bold rounded-full uppercase tracking-tight">In-Progress</span>`;
                    break;
            }

            const scheduledDate = new Date(job.scheduledAt).toLocaleString();
            const techName = job.technician ? job.technician.name : 'Unassigned';

            return `
                <tr class="hover:bg-white/5 transition-colors group">
                    <td class="px-6 py-4 font-label-caps text-secondary-fixed-dim font-bold">#JOB-${job.id}</td>
                    <td class="px-6 py-4 font-semibold text-white">${escapeHtml(job.clientName)}</td>
                    <td class="px-6 py-4 text-outline">${escapeHtml(techName)}</td>
                    <td class="px-6 py-4">${statusBadge}</td>
                    <td class="px-6 py-4 text-right font-label-caps text-outline text-[12px]">${scheduledDate}</td>
                </tr>
            `;
        }).join('');
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
    document.getElementById('jobSearchInput').addEventListener('input', (e) => {
        const val = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('#activeJobsTableBody tr');
        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(val) ? '' : 'none';
        });
    });

    // Initial load
    loadDashboardData();
    setInterval(loadDashboardData, 15000); // refresh every 15s
</script>

</body>
</html>