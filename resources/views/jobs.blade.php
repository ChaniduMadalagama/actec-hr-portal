<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>LogiFlow Dispatch | Job Queue</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;600;700&family=Inter:wght@400;500&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "inverse-on-surface": "#2d3133",
                    "on-tertiary-fixed": "#171837",
                    "on-secondary": "#00363a",
                    "primary": "#b8c3ff",
                    "on-tertiary-fixed-variant": "#434465",
                    "tertiary-fixed": "#e1e0ff",
                    "tertiary": "#c3c3eb",
                    "surface-dim": "#101415",
                    "primary-container": "#131b2e",
                    "primary-fixed-dim": "#b8c3ff",
                    "on-tertiary-container": "#f1eeff",
                    "on-primary": "#002388",
                    "surface-container-high": "#272a2c",
                    "on-tertiary": "#2c2d4d",
                    "on-surface-variant": "#c4c5d9",
                    "on-primary-fixed": "#001356",
                    "tertiary-fixed-dim": "#c3c3eb",
                    "outline": "#8e90a2",
                    "secondary-fixed-dim": "#00dbe7",
                    "on-secondary-fixed": "#002022",
                    "surface-tint": "#b8c3ff",
                    "primary-fixed": "#dde1ff",
                    "background": "#0F1021",
                    "on-primary-container": "#efefff",
                    "surface-container-low": "#191c1e",
                    "inverse-surface": "#e0e3e5",
                    "on-primary-fixed-variant": "#0035be",
                    "secondary-fixed": "#74f5ff",
                    "outline-variant": "#434656",
                    "error": "#ffb4ab",
                    "surface-container-lowest": "#0b0f10",
                    "on-secondary-container": "#006a70",
                    "inverse-primary": "#124af0",
                    "on-secondary-fixed-variant": "#004f54",
                    "surface-bright": "#363a3b",
                    "on-background": "#e0e3e5",
                    "surface-container": "#1d2022",
                    "surface-variant": "#323537",
                    "on-error-container": "#ffdad6",
                    "on-error": "#690005",
                    "tertiary-container": "#696a8e",
                    "secondary": "#ddfcff",
                    "secondary-container": "#2170e4",
                    "on-surface": "#e0e3e5",
                    "surface": "#101415",
                    "error-container": "#93000a",
                    "surface-container-highest": "#323537"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
            },
            "spacing": {
                    "gutter": "24px",
                    "unit": "4px",
                    "margin-desktop": "48px",
                    "container-max": "1440px",
                    "margin-mobile": "16px"
            },
            "fontFamily": {
                    "label-caps": ["JetBrains Mono"],
                    "headline-xl": ["Hanken Grotesk"],
                    "headline-lg": ["Hanken Grotesk"],
                    "headline-md": ["Hanken Grotesk"],
                    "body-lg": ["Inter"],
                    "body-md": ["Inter"],
                    "body-sm": ["Inter"]
            },
            "fontSize": {
                    "label-caps": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "500"}],
                    "headline-xl": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                    "headline-lg": ["32px", {"lineHeight": "40px", "fontWeight": "600"}],
                    "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                    "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                    "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                    "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}]
            }
          },
        },
      }
    </script>
    <style>
        body {
            background-color: #0F1021;
            color: #e0e3e5;
            overflow-x: hidden;
            font-family: 'Inter', sans-serif;
        }
        .glass-panel {
            background: rgba(26, 27, 58, 0.8);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .bg-glow {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
            background: radial-gradient(circle at 80% 20%, rgba(46, 91, 255, 0.15) 0%, transparent 40%),
                        radial-gradient(circle at 20% 80%, rgba(0, 219, 231, 0.1) 0%, transparent 40%);
            pointer-events: none;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 20;
        }
        .active-tab-indicator {
            box-shadow: 0 0 15px rgba(46, 91, 255, 0.4);
        }
        .sidebar-active {
            background: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #00dbe7;
            color: #00dbe7;
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
<div class="bg-glow"></div>

<!-- SideNavBar -->
<aside class="fixed left-0 top-0 h-full w-[280px] bg-primary-container border-r border-white/5 flex flex-col py-6 px-4 gap-4 z-50">
    <div class="flex items-center gap-3 px-2 mb-4">
        <div class="w-10 h-10 rounded-lg bg-secondary flex items-center justify-center text-on-primary-container shadow-lg shadow-primary/20">
            <span class="material-symbols-outlined text-2xl text-on-primary">ac_unit</span>
        </div>
        <div>
            <h1 class="font-headline-md text-headline-md font-bold text-on-surface leading-tight text-white">LogiFlow</h1>
            <p class="text-[10px] font-label-caps text-primary/70 uppercase tracking-widest">Dispatch HQ</p>
        </div>
    </div>
    <nav class="flex-1 flex flex-col gap-1">
        <a class="flex items-center gap-3 px-3 py-3 text-on-surface-variant hover:text-on-surface hover:bg-white/10 rounded-lg transition-all duration-200" href="/dashboard">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="font-label-caps">Dispatch</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-3 text-on-surface-variant hover:text-on-surface hover:bg-white/10 rounded-lg transition-all duration-200" href="/dashboard">
            <span class="material-symbols-outlined">analytics</span>
            <span class="font-label-caps">Analytics</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-3 bg-white/10 text-on-surface rounded-lg border-l-4 border-secondary-fixed-dim sidebar-active font-bold" href="/jobs">
            <span class="material-symbols-outlined">list_alt</span>
            <span class="font-label-caps">Job Queue</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-3 text-on-surface-variant hover:text-on-surface hover:bg-white/10 rounded-lg transition-all duration-200" href="/technicians">
            <span class="material-symbols-outlined">engineering</span>
            <span class="font-label-caps">Technicians</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-3 text-on-surface-variant hover:text-on-surface hover:bg-white/10 rounded-lg transition-all duration-200" href="/time-logs">
            <span class="material-symbols-outlined">history</span>
            <span class="font-label-caps">Time &amp; Audit</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-3 text-on-surface-variant hover:text-on-surface hover:bg-white/10 rounded-lg transition-all duration-200" href="/settings">
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
                <input id="jobSearchInput" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-full py-2 pl-10 pr-4 text-body-sm focus:outline-none focus:border-primary/50 transition-colors placeholder:text-outline/50" placeholder="Search by client, address, or technician..." type="text"/>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <button onclick="window.location.href='/jobs/create'" class="bg-primary text-on-primary px-4 py-2 rounded-lg font-label-caps text-[12px] hover:opacity-90 active:scale-95 transition-all">
                Create New Job
            </button>
            <div class="flex items-center gap-2">
                <button class="p-2 text-on-surface-variant hover:bg-white/5 rounded-full transition-colors relative">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full border-2 border-surface-container"></span>
                </button>
                <button class="p-2 text-on-surface-variant hover:bg-white/5 rounded-full transition-colors">
                    <span class="material-symbols-outlined">help</span>
                </button>
                <div class="w-8 h-8 rounded-full overflow-hidden border border-primary/30">
                    <img class="w-full h-full object-cover" src="/assets/a219ec9d098081f311e070b70333095d.png" alt="User avatar"/>
                </div>
            </div>
        </div>
    </header>

    <!-- Content Body -->
    <div class="p-12 flex flex-col gap-8 max-w-[1400px] w-full mx-auto">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h2 class="font-headline-lg text-headline-lg text-on-surface mb-1 text-white">Repair Job Queue</h2>
                <p class="text-on-surface-variant font-body-md max-w-2xl">Track, monitor, and filter all AC repair jobs dispatched across your territory.</p>
            </div>
            <!-- Tab Filters -->
            <div class="flex p-1 bg-surface-container-low rounded-xl border border-white/5 self-start">
                <button onclick="setStatusFilter('all')" class="status-tab-btn px-5 py-2 rounded-lg font-label-caps text-on-primary-container bg-primary-container active-tab-indicator transition-all" id="tab-all">All Jobs</button>
                <button onclick="setStatusFilter('pending')" class="status-tab-btn px-5 py-2 rounded-lg font-label-caps text-on-surface-variant hover:text-on-surface transition-colors" id="tab-pending">Pending</button>
                <button onclick="setStatusFilter('in-route')" class="status-tab-btn px-5 py-2 rounded-lg font-label-caps text-on-surface-variant hover:text-on-surface transition-colors" id="tab-in-route">In-Route</button>
                <button onclick="setStatusFilter('in-progress')" class="status-tab-btn px-5 py-2 rounded-lg font-label-caps text-on-surface-variant hover:text-on-surface transition-colors" id="tab-in-progress">In-Progress</button>
                <button onclick="setStatusFilter('completed')" class="status-tab-btn px-5 py-2 rounded-lg font-label-caps text-on-surface-variant hover:text-on-surface transition-colors" id="tab-completed">Completed</button>
            </div>
        </div>

        <!-- Table Container (Glassmorphic) -->
        <div class="glass-panel rounded-2xl overflow-hidden shadow-2xl">
            <div class="px-6 py-4 border-b border-white/10 flex justify-between items-center bg-white/5">
                <h3 class="font-headline-md text-headline-md text-on-surface text-lg text-white">Job Entries</h3>
                <div class="flex gap-2">
                    <button class="p-2 text-on-surface-variant hover:text-on-surface transition-colors">
                        <span class="material-symbols-outlined">filter_list</span>
                    </button>
                    <button class="p-2 text-on-surface-variant hover:text-on-surface transition-colors">
                        <span class="material-symbols-outlined">download</span>
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-high/50 border-b border-white/10">
                            <th class="px-6 py-4 font-label-caps text-[11px] text-on-surface-variant uppercase tracking-wider">Job ID</th>
                            <th class="px-6 py-4 font-label-caps text-[11px] text-on-surface-variant uppercase tracking-wider">Client Details</th>
                            <th class="px-6 py-4 font-label-caps text-[11px] text-on-surface-variant uppercase tracking-wider">Address</th>
                            <th class="px-6 py-4 font-label-caps text-[11px] text-on-surface-variant uppercase tracking-wider">Technician</th>
                            <th class="px-6 py-4 font-label-caps text-[11px] text-on-surface-variant uppercase tracking-wider">Scheduled At</th>
                            <th class="px-6 py-4 font-label-caps text-[11px] text-on-surface-variant uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody id="jobsTableBody" class="divide-y divide-white/5">
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-outline">Loading jobs queue...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script>
    let allJobs = [];
    let currentStatusFilter = 'all';

    async function loadJobs() {
        const token = localStorage.getItem('api_token');
        try {
            const response = await fetch('/api/v1/admin/jobs', {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });
            const jobs = await response.json();
            if (response.ok) {
                allJobs = jobs;
                renderJobsTable();
            }
        } catch (err) {
            console.error('Error loading jobs queue:', err);
        }
    }

    function setStatusFilter(status) {
        currentStatusFilter = status;
        
        // Update tab buttons styles
        document.querySelectorAll('.status-tab-btn').forEach(btn => {
            btn.classList.remove('bg-primary-container', 'text-on-primary-container', 'active-tab-indicator');
            btn.classList.add('text-on-surface-variant', 'hover:text-on-surface');
        });
        
        const activeBtn = document.getElementById(`tab-${status}`);
        if (activeBtn) {
            activeBtn.classList.remove('text-on-surface-variant', 'hover:text-on-surface');
            activeBtn.classList.add('bg-primary-container', 'text-on-primary-container', 'active-tab-indicator');
        }

        renderJobsTable();
    }

    function renderJobsTable() {
        const tbody = document.getElementById('jobsTableBody');
        const searchVal = document.getElementById('jobSearchInput').value.toLowerCase();

        // Filter by status
        let filteredJobs = allJobs;
        if (currentStatusFilter !== 'all') {
            filteredJobs = allJobs.filter(j => j.status === currentStatusFilter);
        }

        // Filter by search text
        if (searchVal) {
            filteredJobs = filteredJobs.filter(j => {
                const clientName = j.clientName ? j.clientName.toLowerCase() : '';
                const address = j.serviceAddress ? j.serviceAddress.toLowerCase() : '';
                const phone = j.clientPhone ? j.clientPhone.toLowerCase() : '';
                const techName = j.technician ? j.technician.name.toLowerCase() : 'unassigned';
                return clientName.includes(searchVal) || address.includes(searchVal) || phone.includes(searchVal) || techName.includes(searchVal);
            });
        }

        if (filteredJobs.length === 0) {
            tbody.innerHTML = `<tr><td colspan="6" class="px-6 py-8 text-center text-outline">No dispatch jobs found matching the selection.</td></tr>`;
            return;
        }

        tbody.innerHTML = filteredJobs.map(job => {
            const techName = job.technician ? job.technician.name : '<span class="text-outline italic">Unassigned</span>';
            const scheduledDate = new Date(job.scheduledAt).toLocaleString();

            let statusBadge = '';
            switch(job.status) {
                case 'pending':
                    statusBadge = `<span class="px-3 py-1 rounded-full text-[10px] font-bold tracking-wider bg-amber-500/10 text-amber-400 border border-amber-500/20 uppercase">Pending</span>`;
                    break;
                case 'in-route':
                    statusBadge = `<span class="px-3 py-1 rounded-full text-[10px] font-bold tracking-wider bg-secondary-fixed/10 text-secondary-fixed border border-secondary-fixed/20 uppercase">In-Route</span>`;
                    break;
                case 'in-progress':
                    statusBadge = `<span class="px-3 py-1 rounded-full text-[10px] font-bold tracking-wider bg-error/10 text-error border border-error/20 uppercase">In-Progress</span>`;
                    break;
                case 'completed':
                    statusBadge = `<span class="px-3 py-1 rounded-full text-[10px] font-bold tracking-wider bg-green-500/10 text-green-400 border border-green-500/20 uppercase">Completed</span>`;
                    break;
            }

            return `
                <tr class="hover:bg-white/[0.03] transition-colors group">
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-2">
                            <div class="w-1.5 h-6 bg-secondary rounded-full"></div>
                            <span class="font-label-caps text-primary font-bold">#JOB-${job.id}</span>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <div>
                            <p class="font-bold text-white">${escapeHtml(job.clientName)}</p>
                            <p class="text-body-sm text-on-surface-variant">${escapeHtml(job.clientPhone)}</p>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-body-sm text-on-surface-variant max-w-[250px] truncate" title="${escapeHtml(job.serviceAddress)}">
                        ${escapeHtml(job.serviceAddress)}
                    </td>
                    <td class="px-6 py-5 text-body-sm text-on-surface">
                        ${techName}
                    </td>
                    <td class="px-6 py-5 text-body-sm">
                        <p class="text-on-surface">${new Date(job.scheduledAt).toLocaleDateString()}</p>
                        <p class="text-on-surface-variant">${new Date(job.scheduledAt).toLocaleTimeString()}</p>
                    </td>
                    <td class="px-6 py-5">
                        ${statusBadge}
                    </td>
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

    // Search input listener
    document.getElementById('jobSearchInput').addEventListener('input', renderJobsTable);

    // Initial load
    loadJobs();
</script>
</body>
</html>