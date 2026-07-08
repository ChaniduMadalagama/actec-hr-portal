<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>LogiFlow Dispatch - Job Queue</title>
    <link href="/assets/c7c836b4ae5dc2238aa4b499d2db9e8b.css" rel="stylesheet" />
    <link href="/assets/a39f5c6fcbb87b419667ec984d2e579a.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "on-tertiary-fixed": "#07006c",
                        "on-secondary-fixed-variant": "#004395",
                        "surface-dim": "#ccdbf2",
                        "primary-fixed": "#dae2fd",
                        "secondary-fixed": "#d8e2ff",
                        "tertiary-container": "#07006c",
                        "surface-container-highest": "#d4e4fa",
                        "surface-tint": "#565e74",
                        "secondary": "#0058be",
                        "on-primary-container": "#7c839b",
                        "inverse-on-surface": "#e9f1ff",
                        "tertiary-fixed": "#e1e0ff",
                        "primary-fixed-dim": "#bec6e0",
                        "primary": "#000000",
                        "on-tertiary": "#ffffff",
                        "error": "#ba1a1a",
                        "tertiary-fixed-dim": "#c0c1ff",
                        "surface-container-low": "#eef4ff",
                        "on-primary": "#ffffff",
                        "primary-container": "#131b2e",
                        "error-container": "#ffdad6",
                        "surface-container": "#e5efff",
                        "outline-variant": "#c6c6cd",
                        "on-secondary-container": "#fefcff",
                        "surface-bright": "#f8f9ff",
                        "outline": "#76777d",
                        "on-tertiary-fixed-variant": "#2f2ebe",
                        "tertiary": "#000000",
                        "on-primary-fixed": "#131b2e",
                        "secondary-container": "#2170e4",
                        "surface-container-lowest": "#ffffff",
                        "on-tertiary-container": "#7073ff",
                        "on-secondary-fixed": "#001a42",
                        "on-primary-fixed-variant": "#3f465c",
                        "inverse-surface": "#233143",
                        "on-error-container": "#93000a",
                        "on-background": "#0d1c2d",
                        "background": "#f8f9ff",
                        "inverse-primary": "#bec6e0",
                        "surface-variant": "#d4e4fa",
                        "surface-container-high": "#dbe9ff",
                        "secondary-fixed-dim": "#adc6ff",
                        "surface": "#f8f9ff",
                        "on-error": "#ffffff",
                        "on-surface-variant": "#45464d",
                        "on-secondary": "#ffffff",
                        "on-surface": "#0d1c2d"
                    },
                    borderRadius: {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    spacing: {
                        "xl": "32px",
                        "sm": "8px",
                        "xs": "4px",
                        "lg": "24px",
                        "gutter": "16px",
                        "container-margin": "24px",
                        "md": "16px",
                        "base": "4px"
                    },
                    fontFamily: {
                        "headline-lg": ["Inter"],
                        "label-caps": ["Inter"],
                        "body-lg": ["Inter"],
                        "data-mono": ["JetBrains Mono"],
                        "headline-sm": ["Inter"],
                        "headline-md": ["Inter"],
                        "body-md": ["Inter"],
                        "body-sm": ["Inter"]
                    },
                    fontSize: {
                        "headline-lg": ["30px", {"lineHeight": "38px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "label-caps": ["11px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "700"}],
                        "body-lg": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "data-mono": ["13px", {"lineHeight": "16px", "fontWeight": "500"}],
                        "headline-sm": ["18px", {"lineHeight": "24px", "fontWeight": "600"}],
                        "headline-md": ["24px", {"lineHeight": "32px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                        "body-md": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                        "body-sm": ["12px", {"lineHeight": "16px", "fontWeight": "400"}]
                    }
                }
            }
        };
    </script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        body { font-family: Inter, sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24;
            vertical-align: middle;
        }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
    <script>
        if (!localStorage.getItem('api_token')) {
            window.location.href = '/login';
        }
    </script>
</head>
<body class="flex min-h-screen overflow-hidden text-on-surface bg-background">

<!-- SideNavBar (Shared Component) -->
<aside class="bg-primary-container h-full w-64 fixed left-0 top-0 border-r border-outline-variant flex flex-col py-lg z-50 text-white">
    <div class="px-md mb-xl">
        <h1 class="font-headline-sm text-headline-sm font-bold text-on-primary">LogiFlow Dispatch</h1>
        <p class="font-body-sm text-on-primary-container">Dispatch HQ</p>
    </div>
    <nav class="flex-1 px-sm space-y-base">
        <!-- Nav Item: Dispatch -->
        <a class="flex items-center px-md py-sm rounded text-on-primary-container hover:bg-surface-variant/10 transition-colors duration-200 cursor-pointer" href="/dashboard">
            <span class="material-symbols-outlined mr-md">local_shipping</span>
            <span class="font-body-md text-body-md">Dispatch</span>
        </a>
        <!-- Nav Item: Analytics -->
        <a class="flex items-center px-md py-sm rounded text-on-primary-container hover:bg-surface-variant/10 transition-colors duration-200 cursor-pointer" href="/dashboard">
            <span class="material-symbols-outlined mr-md">analytics</span>
            <span class="font-body-md text-body-md">Analytics</span>
        </a>
        <!-- Nav Item: Job Queue (ACTIVE) -->
        <a class="flex items-center px-md py-sm rounded bg-secondary-container text-on-secondary-container border-r-4 border-secondary font-bold transition-colors duration-200 cursor-pointer" href="/jobs">
            <span class="material-symbols-outlined mr-md">assignment</span>
            <span class="font-body-md text-body-md">Job Queue</span>
        </a>
        <!-- Nav Item: Technicians -->
        <a class="flex items-center px-md py-sm rounded text-on-primary-container hover:bg-surface-variant/10 transition-colors duration-200 cursor-pointer" href="/technicians">
            <span class="material-symbols-outlined mr-md">engineering</span>
            <span class="font-body-md text-body-md">Technicians</span>
        </a>
        <!-- Nav Item: Time & Audit -->
        <a class="flex items-center px-md py-sm rounded text-on-primary-container hover:bg-surface-variant/10 transition-colors duration-200 cursor-pointer" href="/time-logs">
            <span class="material-symbols-outlined mr-md">history</span>
            <span class="font-body-md text-body-md">Time &amp; Audit</span>
        </a>
        <!-- Nav Item: Settings -->
        <a class="flex items-center px-md py-sm rounded text-on-primary-container hover:bg-surface-variant/10 transition-colors duration-200 cursor-pointer" href="/settings">
            <span class="material-symbols-outlined mr-md">settings</span>
            <span class="font-body-md text-body-md">Settings</span>
        </a>
    </nav>
    <div class="px-sm space-y-base mt-auto">
        <button class="w-full bg-secondary text-on-secondary py-sm rounded-lg mb-md flex items-center justify-center font-body-md font-semibold" onclick="window.location.href='/jobs/create'">
            <span class="material-symbols-outlined mr-sm">add</span> New Dispatch
        </button>
        <a class="flex items-center px-md py-sm rounded text-on-primary-container hover:bg-surface-variant/10 transition-colors duration-200 cursor-pointer" href="#">
            <span class="material-symbols-outlined mr-md">support_agent</span>
            <span class="font-body-md text-body-md">Support</span>
        </a>
        <a class="flex items-center px-md py-sm rounded text-on-primary-container hover:bg-surface-variant/10 transition-colors duration-200 cursor-pointer" onclick="handleLogout()">
            <span class="material-symbols-outlined mr-md">logout</span>
            <span class="font-body-md text-body-md">Sign Out</span>
        </a>
    </div>
</aside>

<!-- Main Content Wrapper -->
<div class="flex-1 flex flex-col ml-64 min-w-0">
    <!-- TopNavBar (Top) -->
    <!-- TopNavBar (Top) -->
    <header class="sticky top-0 z-50 flex justify-between items-center px-lg py-sm w-full bg-surface dark:bg-surface-container-high border-b border-outline-variant dark:border-outline">
        <div class="flex items-center gap-lg flex-1">
            <span class="font-headline-md text-headline-md font-bold text-primary dark:text-inverse-primary">LogiFlow Dispatch</span>
            <div class="relative w-full max-w-md hidden md:block">
                <span class="material-symbols-outlined absolute left-sm top-1/2 -translate-y-1/2 text-on-surface-variant" data-icon="search">search</span>
                <input id="jobSearchInput" class="w-full pl-xl pr-md py-xs bg-surface-container-low border border-outline-variant rounded focus:outline-none focus:ring-2 focus:ring-secondary/20 font-body-md" placeholder="Search by client, address, or technician..." type="text">
            </div>
        </div>
        <div class="flex items-center gap-md">
            <a href="/jobs/create" class="bg-secondary text-on-secondary px-md py-xs rounded flex items-center gap-xs font-body-md font-bold hover:brightness-95 active:scale-95 transition-all">
                <span class="material-symbols-outlined" data-icon="add">add</span>
                Create New Job
            </a>
            <div class="flex items-center gap-sm">
                <button class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-surface-container transition-colors relative">
                    <span class="material-symbols-outlined text-on-surface-variant" data-icon="notifications">notifications</span>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full"></span>
                </button>
                <button class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-surface-container transition-colors">
                    <span class="material-symbols-outlined text-on-surface-variant" data-icon="help">help</span>
                </button>
            </div>
            <div class="h-8 w-px bg-outline-variant mx-xs"></div>
            <img alt="User profile avatar" class="w-8 h-8 rounded-full border border-outline-variant object-cover animate-avatar" src="/assets/a219ec9d098081f311e070b70333095d.png">
        </div>
    </header>

        <!-- Content Canvas -->
        <main class="flex-1 overflow-y-auto p-lg bg-surface-container-low custom-scrollbar">
            <!-- Page Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-xl gap-md">
                <div>
                    <h2 class="font-headline-md text-headline-md text-primary mb-base font-bold text-2xl">Repair Job Queue</h2>
                    <p class="font-body-md text-on-surface-variant">Track, monitor, and filter all AC repair jobs dispatched across your territory.</p>
                </div>
                <!-- Status Tabs / Filter controls -->
                <div class="flex items-center bg-white border border-outline-variant rounded-lg p-xs gap-xs">
                    <button onclick="setStatusFilter('all')" class="status-tab-btn px-md py-xs rounded font-body-sm font-semibold bg-secondary text-on-secondary transition-all" id="tab-all">All Jobs</button>
                    <button onclick="setStatusFilter('pending')" class="status-tab-btn px-md py-xs rounded font-body-sm font-semibold text-on-surface-variant hover:bg-surface-container transition-all" id="tab-pending">Pending</button>
                    <button onclick="setStatusFilter('in-route')" class="status-tab-btn px-md py-xs rounded font-body-sm font-semibold text-on-surface-variant hover:bg-surface-container transition-all" id="tab-in-route">In-Route</button>
                    <button onclick="setStatusFilter('in-progress')" class="status-tab-btn px-md py-xs rounded font-body-sm font-semibold text-on-surface-variant hover:bg-surface-container transition-all" id="tab-in-progress">In-Progress</button>
                    <button onclick="setStatusFilter('completed')" class="status-tab-btn px-md py-xs rounded font-body-sm font-semibold text-on-surface-variant hover:bg-surface-container transition-all" id="tab-completed">Completed</button>
                </div>
            </div>

            <!-- Data Table Section -->
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden shadow-sm">
                <!-- Table Header Actions -->
                <div class="flex items-center justify-between p-md border-b border-outline-variant bg-white">
                    <div class="flex items-center gap-sm">
                        <span class="font-headline-sm text-headline-sm text-primary font-semibold">Job Entries</span>
                    </div>
                </div>
                <!-- Table Content -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low border-b-2 border-primary-container/10">
                                <th class="p-md font-label-caps text-label-caps text-on-primary-fixed-variant uppercase tracking-wider">Job ID</th>
                                <th class="p-md font-label-caps text-label-caps text-on-primary-fixed-variant uppercase tracking-wider">Client Details</th>
                                <th class="p-md font-label-caps text-label-caps text-on-primary-fixed-variant uppercase tracking-wider">Address</th>
                                <th class="p-md font-label-caps text-label-caps text-on-primary-fixed-variant uppercase tracking-wider">Technician</th>
                                <th class="p-md font-label-caps text-label-caps text-on-primary-fixed-variant uppercase tracking-wider">Scheduled At</th>
                                <th class="p-md font-label-caps text-label-caps text-on-primary-fixed-variant uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody id="jobsTableBody" class="divide-y divide-outline-variant/50">
                            <tr>
                                <td colspan="6" class="p-md text-center text-on-surface-variant">Loading jobs queue...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
    </main>
</div>

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
            btn.classList.remove('bg-secondary', 'text-on-secondary');
            btn.classList.add('text-on-surface-variant', 'hover:bg-surface-container');
        });
        
        const activeBtn = document.getElementById(`tab-${status}`);
        if (activeBtn) {
            activeBtn.classList.remove('text-on-surface-variant', 'hover:bg-surface-container');
            activeBtn.classList.add('bg-secondary', 'text-on-secondary');
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
            tbody.innerHTML = `<tr><td colspan="6" class="p-md text-center text-on-surface-variant">No dispatch jobs found matching the selection.</td></tr>`;
            return;
        }

        tbody.innerHTML = filteredJobs.map(job => {
            const techName = job.technician ? job.technician.name : '<span class="text-slate-400 italic">Unassigned</span>';
            const scheduledDate = new Date(job.scheduledAt).toLocaleString();

            let statusBadge = '';
            switch(job.status) {
                case 'pending':
                    statusBadge = `<span class="px-xs py-[2px] rounded bg-yellow-100 text-yellow-700 text-[10px] font-bold uppercase border border-yellow-200">Pending</span>`;
                    break;
                case 'in-route':
                    statusBadge = `<span class="px-xs py-[2px] rounded bg-blue-100 text-blue-700 text-[10px] font-bold uppercase border border-blue-200">In-Route</span>`;
                    break;
                case 'in-progress':
                    statusBadge = `<span class="px-xs py-[2px] rounded bg-indigo-100 text-indigo-700 text-[10px] font-bold uppercase border border-indigo-200">In-Progress</span>`;
                    break;
                case 'completed':
                    statusBadge = `<span class="px-xs py-[2px] rounded bg-green-100 text-green-700 text-[10px] font-bold uppercase border border-green-200">Completed</span>`;
                    break;
            }

            return `
                <tr class="hover:bg-surface-variant/5 transition-colors">
                    <td class="p-md font-data-mono text-secondary font-bold">#JOB-${job.id}</td>
                    <td class="p-md font-semibold text-primary">
                        <div>${escapeHtml(job.clientName)}</div>
                        <div class="text-xs text-on-surface-variant font-normal">${escapeHtml(job.clientPhone)}</div>
                    </td>
                    <td class="p-md font-body-sm text-on-surface-variant max-w-[250px] truncate" title="${escapeHtml(job.serviceAddress)}">${escapeHtml(job.serviceAddress)}</td>
                    <td class="p-md font-body-md">${techName}</td>
                    <td class="p-md font-data-mono text-body-sm">${scheduledDate}</td>
                    <td class="p-md">${statusBadge}</td>
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