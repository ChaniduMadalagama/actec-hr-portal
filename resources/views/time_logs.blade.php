<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>LogiFlow Dispatch - Time Tracking &amp; Audit Logs</title>
    <link href="/assets/c7c836b4ae5dc2238aa4b499d2db9e8b.css" rel="stylesheet" />
    <link href="/assets/a39f5c6fcbb87b419667ec984d2e579a.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary-container": "#131b2e",
                        "surface": "#f8f9ff",
                        "outline-variant": "#c6c6cd",
                        "on-tertiary": "#ffffff",
                        "on-secondary-fixed-variant": "#004395",
                        "inverse-on-surface": "#e9f1ff",
                        "on-surface-variant": "#45464d",
                        "on-primary-fixed": "#131b2e",
                        "error-container": "#ffdad6",
                        "background": "#f8f9ff",
                        "on-tertiary-fixed": "#07006c",
                        "surface-container": "#e5efff",
                        "on-background": "#0d1c2d",
                        "secondary-fixed-dim": "#adc6ff",
                        "inverse-primary": "#bec6e0",
                        "tertiary": "#000000",
                        "surface-container-lowest": "#ffffff",
                        "primary-fixed": "#dae2fd",
                        "tertiary-container": "#07006c",
                        "on-tertiary-fixed-variant": "#2f2ebe",
                        "secondary": "#0058be",
                        "outline": "#76777d",
                        "on-primary-container": "#7c839b",
                        "secondary-fixed": "#d8e2ff",
                        "tertiary-fixed-dim": "#c0c1ff",
                        "primary": "#000000",
                        "surface-tint": "#565e74",
                        "primary-fixed-dim": "#bec6e0",
                        "error": "#ba1a1a",
                        "on-tertiary-container": "#7073ff",
                        "on-error-container": "#93000a",
                        "on-primary-fixed-variant": "#3f465c",
                        "on-secondary-container": "#fefcff",
                        "surface-variant": "#d4e4fa",
                        "surface-container-high": "#dbe9ff",
                        "on-surface": "#0d1c2d",
                        "on-primary": "#ffffff",
                        "secondary-container": "#2170e4",
                        "surface-container-low": "#eef4ff",
                        "inverse-surface": "#233143",
                        "surface-container-highest": "#d4e4fa",
                        "surface-bright": "#f8f9ff",
                        "on-secondary": "#ffffff",
                        "on-error": "#ffffff",
                        "tertiary-fixed": "#e1e0ff",
                        "surface-dim": "#ccdbf2",
                        "on-secondary-fixed": "#001a42"
                    },
                    borderRadius: {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    spacing: {
                        "md": "16px",
                        "container-margin": "24px",
                        "xl": "32px",
                        "lg": "24px",
                        "sm": "8px",
                        "base": "4px",
                        "gutter": "16px",
                        "xs": "4px"
                    },
                    fontFamily: {
                        "headline-md": ["Inter"],
                        "body-sm": ["Inter"],
                        "data-mono": ["JetBrains Mono"],
                        "body-md": ["Inter"],
                        "body-lg": ["Inter"],
                        "headline-lg": ["Inter"],
                        "label-caps": ["Inter"],
                        "headline-sm": ["Inter"]
                    },
                    fontSize: {
                        "headline-md": ["24px", {"lineHeight": "32px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                        "body-sm": ["12px", {"lineHeight": "16px", "fontWeight": "400"}],
                        "data-mono": ["13px", {"lineHeight": "16px", "fontWeight": "500"}],
                        "body-md": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                        "body-lg": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "headline-lg": ["30px", {"lineHeight": "38px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "label-caps": ["11px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "700"}],
                        "headline-sm": ["18px", {"lineHeight": "24px", "fontWeight": "600"}]
                    }
                }
            }
        };
    </script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
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
        <!-- Nav Item: Job Queue -->
        <a class="flex items-center px-md py-sm rounded text-on-primary-container hover:bg-surface-variant/10 transition-colors duration-200 cursor-pointer" href="/jobs">
            <span class="material-symbols-outlined mr-md">assignment</span>
            <span class="font-body-md text-body-md">Job Queue</span>
        </a>
        <!-- Nav Item: Technicians -->
        <a class="flex items-center px-md py-sm rounded text-on-primary-container hover:bg-surface-variant/10 transition-colors duration-200 cursor-pointer" href="/technicians">
            <span class="material-symbols-outlined mr-md">engineering</span>
            <span class="font-body-md text-body-md">Technicians</span>
        </a>
        <!-- Nav Item: Time & Audit (ACTIVE) -->
        <a class="flex items-center px-md py-sm rounded bg-secondary-container text-on-secondary-container border-r-4 border-secondary transition-colors duration-200 cursor-pointer" href="/time-logs">
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

<!-- Main Content Area -->
<div class="flex-1 flex flex-col ml-64 h-screen">
    <!-- TopNavBar (Top) -->
    <header class="sticky top-0 z-50 flex justify-between items-center px-lg py-sm w-full bg-surface dark:bg-surface-container-high border-b border-outline-variant dark:border-outline">
        <div class="flex items-center gap-lg flex-1">
            <span class="font-headline-md text-headline-md font-bold text-primary dark:text-inverse-primary">LogiFlow Dispatch</span>
            <div class="relative w-full max-w-md hidden md:block">
                <span class="material-symbols-outlined absolute left-sm top-1/2 -translate-y-1/2 text-on-surface-variant" data-icon="search">search</span>
                <input id="logSearchInput" class="w-full pl-xl pr-md py-xs bg-surface-container-low border border-outline-variant rounded focus:outline-none focus:ring-2 focus:ring-secondary/20 font-body-md" placeholder="Quick Search Job ID..." type="text" oninput="applyFilters()" />
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
    <section class="flex-1 overflow-y-auto p-lg bg-surface-container-low custom-scrollbar space-y-lg">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-md">
            <div>
                <h2 class="font-headline-md text-headline-md text-primary mb-base font-bold text-2xl">Time Tracking &amp; Audit Logs</h2>
                <p class="font-body-md text-on-surface-variant">Verify precision and maintain compliance across the fleet.</p>
            </div>
            <!-- Filters Bar -->
            <div class="flex flex-wrap items-center gap-sm bg-surface-container-lowest p-sm rounded-xl border border-outline-variant">
                <div class="flex flex-col">
                    <label class="font-label-caps text-label-caps text-on-surface-variant px-xs mb-xs uppercase">Date</label>
                    <input id="filterDate" class="border-none bg-surface-container-low rounded px-sm py-xs text-body-sm focus:ring-2 focus:ring-secondary" type="date" onchange="applyFilters()" />
                </div>
                <div class="w-px h-8 bg-outline-variant mx-sm"></div>
                <div class="flex flex-col">
                    <label class="font-label-caps text-label-caps text-on-surface-variant px-xs mb-xs uppercase">Technician</label>
                    <select id="filterTech" class="border-none bg-surface-container-low rounded px-sm py-xs text-body-sm focus:ring-2 focus:ring-secondary min-w-[140px]" onchange="applyFilters()">
                        <option value="all">All Technicians</option>
                    </select>
                </div>
                <button class="bg-secondary text-on-secondary h-10 px-md rounded font-body-sm font-semibold hover:opacity-90 transition-opacity ml-sm" onclick="resetFilters()">Reset</button>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-md">
            <div class="bg-surface-container-lowest border border-outline-variant p-md rounded-xl">
                <p class="font-label-caps text-label-caps text-on-surface-variant mb-base uppercase">Total Deployed Hours</p>
                <div class="flex items-end gap-sm">
                    <span id="totalHoursText" class="font-headline-md text-headline-md text-primary">0.0</span>
                    <span class="font-body-sm text-secondary bg-surface-container px-xs rounded mb-1">Total</span>
                </div>
            </div>
            <div class="bg-surface-container-lowest border border-outline-variant p-md rounded-xl">
                <p class="font-label-caps text-label-caps text-on-surface-variant mb-base uppercase">Deviation Alerts</p>
                <div class="flex items-end gap-sm">
                    <span id="tamperCountText" class="font-headline-md text-headline-md text-error">0</span>
                    <span class="font-body-sm text-error bg-error-container px-xs rounded mb-1">Requires Audit</span>
                </div>
            </div>
            <div class="bg-surface-container-lowest border border-outline-variant p-md rounded-xl col-span-2">
                <div class="flex justify-between items-start mb-base">
                    <p class="font-label-caps text-label-caps text-on-surface-variant uppercase">Fleet Security Compliance</p>
                    <span class="text-[10px] font-bold text-secondary bg-surface-container px-sm py-0.5 rounded-full">TARGET: 100%</span>
                </div>
                <div class="flex items-center gap-md">
                    <div class="flex-1 bg-surface-container-low h-2 rounded-full overflow-hidden">
                        <div id="complianceBar" class="bg-secondary h-full transition-all duration-500" style="width: 0%;"></div>
                    </div>
                    <span id="complianceText" class="font-headline-md text-headline-md text-primary">0%</span>
                </div>
            </div>
        </div>

        <!-- Data Grid (Table Section) -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden shadow-sm flex flex-col">
            <!-- Table Header Actions -->
            <div class="flex items-center justify-between p-md border-b border-outline-variant bg-white">
                <div class="flex items-center gap-sm">
                    <span class="font-headline-sm text-headline-sm text-primary font-semibold">Audit Log</span>
                    <span class="bg-surface-container text-on-surface-variant text-[10px] px-sm py-0.5 rounded-full font-bold">LIVE UPDATE</span>
                </div>
                <button class="bg-surface text-primary border border-outline-variant px-md py-sm rounded flex items-center gap-sm font-body-md hover:bg-surface-container-low transition-colors" onclick="exportReport()">
                    <span class="material-symbols-outlined text-md">download</span> Export Report
                </button>
            </div>
            <!-- Table Content -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low border-b-2 border-primary-container/10">
                            <th class="p-md font-label-caps text-label-caps text-on-primary-fixed-variant uppercase tracking-wider">Date</th>
                            <th class="p-md font-label-caps text-label-caps text-on-primary-fixed-variant uppercase tracking-wider">Technician</th>
                            <th class="p-md font-label-caps text-label-caps text-on-primary-fixed-variant uppercase tracking-wider">Job ID</th>
                            <th class="p-md font-label-caps text-label-caps text-on-primary-fixed-variant uppercase tracking-wider">Client Address</th>
                            <th class="p-md font-label-caps text-label-caps text-on-primary-fixed-variant uppercase tracking-wider">In-Time</th>
                            <th class="p-md font-label-caps text-label-caps text-on-primary-fixed-variant uppercase tracking-wider">Out-Time</th>
                            <th class="p-md font-label-caps text-label-caps text-on-primary-fixed-variant uppercase tracking-wider text-right">Total Hours</th>
                            <th class="p-md font-label-caps text-label-caps text-on-primary-fixed-variant uppercase tracking-wider">Audit Status</th>
                        </tr>
                    </thead>
                    <tbody id="logsTableBody" class="divide-y divide-outline-variant/50">
                        <tr>
                            <td colspan="8" class="p-md text-center text-on-surface-variant">Loading time tracking logs...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Pagination Footer -->
            <div class="p-md flex items-center justify-between bg-surface border-t border-outline-variant">
                <span id="showingLogsText" class="text-body-sm text-on-surface-variant">Showing 0 logs</span>
                <div class="flex gap-xs">
                    <button class="p-xs rounded border border-outline-variant hover:bg-surface-container-low disabled:opacity-30" disabled>
                        <span class="material-symbols-outlined text-md">chevron_left</span>
                    </button>
                    <button class="px-sm py-xs rounded border border-secondary bg-secondary-container text-on-secondary-container font-bold text-xs">1</button>
                    <button class="p-xs rounded border border-outline-variant hover:bg-surface-container-low">
                        <span class="material-symbols-outlined text-md">chevron_right</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Contextual Info Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-lg">
            <div class="lg:col-span-2 bg-primary-container text-on-primary p-lg rounded-xl flex items-center justify-between relative overflow-hidden shadow-md">
                <div class="relative z-10 space-y-sm">
                    <h3 class="font-headline-sm text-headline-sm text-white font-bold text-xl">Fleet-wide Security</h3>
                    <p class="font-body-md text-slate-300 max-w-md">AC Repair system performs active geofencing verification. Technician check-in/out coordinates are automatically cross-checked with the job's service address. Any distance deviation exceeding 5 meters triggers a security flag.</p>
                    <a href="/dashboard" class="inline-block mt-md bg-secondary text-on-secondary px-md py-sm rounded font-semibold text-body-sm hover:brightness-110 transition-all">View Dispatch Map</a>
                </div>
                <div class="absolute right-0 top-0 h-full w-1/3 opacity-20 bg-gradient-to-l from-secondary to-transparent pointer-events-none"></div>
                <span class="material-symbols-outlined text-[120px] absolute -right-8 -bottom-8 opacity-10 pointer-events-none">verified_user</span>
            </div>

            <div class="bg-surface-container-lowest border border-outline-variant p-lg rounded-xl shadow-sm">
                <h3 class="font-headline-sm text-headline-sm text-primary mb-md flex items-center gap-sm font-semibold">
                    <span class="material-symbols-outlined text-secondary">pending_actions</span>
                    Manual Reviews
                </h3>
                <ul id="manualReviewList" class="space-y-md divide-y divide-outline-variant/50">
                    <li class="py-sm text-center text-on-surface-variant">No logs needing review.</li>
                </ul>
            </div>
        </div>
    </section>
</div>

<script>
    let allLogs = [];

    async function loadLogs() {
        const token = localStorage.getItem('api_token');
        try {
            const response = await fetch('/api/v1/admin/logs/time-tracking', {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });
            const logs = await response.json();
            if (response.ok) {
                allLogs = logs;
                populateTechFilter(logs);
                renderLogs(logs);
            }
        } catch (err) {
            console.error('Error loading time logs:', err);
        }
    }

    function populateTechFilter(logs) {
        const select = document.getElementById('filterTech');
        const currentVal = select.value;
        select.innerHTML = '<option value="all">All Technicians</option>';
        
        const techs = {};
        logs.forEach(log => {
            if (log.technician) {
                techs[log.technician.id] = log.technician.name;
            }
        });

        for (const [id, name] of Object.entries(techs)) {
            const opt = document.createElement('option');
            opt.value = id;
            opt.textContent = name;
            select.appendChild(opt);
        }
        select.value = currentVal;
    }

    function renderLogs(logs) {
        const tbody = document.getElementById('logsTableBody');
        const reviewList = document.getElementById('manualReviewList');
        const showingLogsText = document.getElementById('showingLogsText');
        
        showingLogsText.innerText = `Showing ${logs.length} audit logs`;

        if (logs.length === 0) {
            tbody.innerHTML = `<tr><td colspan="8" class="p-md text-center text-on-surface-variant">No check-in logs recorded.</td></tr>`;
            reviewList.innerHTML = `<li class="py-sm text-center text-on-surface-variant">No logs needing review.</li>`;
            updateStats(0, 0, 100);
            return;
        }

        let totalHours = 0;
        let tamperCount = 0;
        let reviewItemsHtml = '';

        tbody.innerHTML = logs.map(log => {
            const techName = log.technician ? log.technician.name : 'Unknown';
            const clientAddress = log.job ? log.job.serviceAddress : 'Unknown Address';
            
            const logDate = log.checkInTime ? new Date(log.checkInTime).toLocaleDateString() : 'N/A';
            const checkIn = log.checkInTime ? new Date(log.checkInTime).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : 'N/A';
            const checkOut = log.checkOutTime ? new Date(log.checkOutTime).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : 'N/A';
            const hoursVal = log.totalHours !== null ? parseFloat(log.totalHours) : 0;
            totalHours += hoursVal;

            const hoursDisplay = log.totalHours !== null ? `${log.totalHours} hrs` : 'Active';

            // Security/Tamper Alert Status
            let securityStatus = `<span class="inline-flex items-center gap-xs px-sm py-base rounded bg-green-50 text-green-700 font-body-sm font-semibold border border-green-200"><span class="material-symbols-outlined text-sm">check_circle</span>Verified</span>`;
            if (log.deviceTamperFlag) {
                tamperCount++;
                securityStatus = `<span class="inline-flex items-center gap-xs px-sm py-base rounded bg-red-50 text-red-700 font-body-sm font-semibold border border-red-200"><span class="material-symbols-outlined text-sm">warning</span>Tamper Alert</span>`;
                
                reviewItemsHtml += `
                    <li class="flex items-center justify-between py-sm first:pt-0">
                        <div class="flex flex-col">
                            <span class="font-body-md font-bold text-primary">Job #JOB-${log.jobId}</span>
                            <span class="text-xs text-on-surface-variant">${escapeHtml(techName)} · Location deviation</span>
                        </div>
                        <span class="text-error font-bold text-xs">REVIEW REQUIRED</span>
                    </li>
                `;
            }

            return `
                <tr class="hover:bg-surface-variant/5 transition-colors">
                    <td class="p-md font-body-md text-primary">${logDate}</td>
                    <td class="p-md">
                        <div class="flex items-center gap-sm">
                            <div class="h-8 w-8 rounded-full overflow-hidden bg-primary-container text-on-primary flex items-center justify-center font-bold text-xs">${escapeHtml(techName.substring(0, 2).toUpperCase())}</div>
                            <span class="font-body-md font-medium text-primary">${escapeHtml(techName)}</span>
                        </div>
                    </td>
                    <td class="p-md font-data-mono text-secondary font-bold">#JOB-${log.jobId}</td>
                    <td class="p-md font-body-sm text-on-surface-variant max-w-[200px] truncate" title="${escapeHtml(clientAddress)}">${escapeHtml(clientAddress)}</td>
                    <td class="p-md font-data-mono text-body-sm">${checkIn}</td>
                    <td class="p-md font-data-mono text-body-sm">${checkOut}</td>
                    <td class="p-md font-body-md font-bold text-right">${hoursDisplay}</td>
                    <td class="p-md">${securityStatus}</td>
                </tr>
            `;
        }).join('');

        if (reviewItemsHtml) {
            reviewList.innerHTML = reviewItemsHtml;
        } else {
            reviewList.innerHTML = `<li class="py-sm text-center text-on-surface-variant">All check-ins verified. No deviations.</li>`;
        }

        const compliance = logs.length > 0 ? Math.round(((logs.length - tamperCount) / logs.length) * 100) : 100;
        updateStats(totalHours, tamperCount, compliance);
    }

    function updateStats(totalHours, tamperCount, compliance) {
        document.getElementById('totalHoursText').innerText = totalHours.toFixed(1);
        document.getElementById('tamperCountText').innerText = tamperCount;
        document.getElementById('complianceText').innerText = `${compliance}%`;
        document.getElementById('complianceBar').style.width = `${compliance}%`;
    }

    function applyFilters() {
        const dateVal = document.getElementById('filterDate').value;
        const techVal = document.getElementById('filterTech').value;
        const searchVal = document.getElementById('logSearchInput').value.toLowerCase();

        let filtered = allLogs;

        if (dateVal) {
            filtered = filtered.filter(log => {
                const logDate = log.checkInTime ? log.checkInTime.split('T')[0] : '';
                return logDate === dateVal;
            });
        }

        if (techVal !== 'all') {
            filtered = filtered.filter(log => log.technician && log.technician.id == techVal);
        }

        if (searchVal) {
            filtered = filtered.filter(log => {
                const idMatch = `#job-${log.jobId}`.includes(searchVal) || String(log.jobId).includes(searchVal);
                const techMatch = log.technician && log.technician.name.toLowerCase().includes(searchVal);
                const addressMatch = log.job && log.job.serviceAddress.toLowerCase().includes(searchVal);
                return idMatch || techMatch || addressMatch;
            });
        }

        renderLogs(filtered);
    }

    function resetFilters() {
        document.getElementById('filterDate').value = '';
        document.getElementById('filterTech').value = 'all';
        document.getElementById('logSearchInput').value = '';
        renderLogs(allLogs);
    }

    function exportReport() {
        alert("Preparing time tracking audit report download...");
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
</script>
</body>
</html>