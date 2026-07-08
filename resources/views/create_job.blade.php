<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Job Creation | DispatchCore AI</title>
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
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body { font-family: 'Inter', sans-serif; background-color: #f8f9ff; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
            border: 1px solid #c6c6cd;
        }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #c6c6cd; border-radius: 10px; }
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
        <button class="w-full bg-secondary text-on-secondary py-sm rounded-lg mb-md flex items-center justify-center font-body-md font-semibold ring-2 ring-white" onclick="window.location.href='/jobs/create'">
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
                <input class="w-full pl-xl pr-md py-xs bg-surface-container-low border border-outline-variant rounded focus:outline-none focus:ring-2 focus:ring-secondary/20 font-body-md" placeholder="Search jobs, techs, or clients..." type="text" />
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

    <!-- Scrollable Canvas -->
    <main class="flex-1 overflow-y-auto custom-scrollbar p-lg space-y-lg">
        <form id="jobDispatchForm" onsubmit="handleJobDispatch(event)">
            <div class="max-w-6xl mx-auto p-gutter lg:p-xl">
                <!-- Header Section -->
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-md mb-xl">
                    <div>
                        <h1 class="text-headline-lg font-headline-lg text-primary font-bold text-3xl">New Service Dispatch</h1>
                        <p class="text-body-md text-on-surface-variant mt-xs">Schedule and assign a new AC maintenance task for immediate deployment.</p>
                    </div>
                    <div class="flex gap-md">
                        <a href="/dashboard" class="px-md py-sm border border-outline-variant text-on-surface font-semibold rounded-lg hover:bg-surface-container-low transition-colors flex items-center">Cancel</a>
                        <button type="submit" class="px-xl py-sm bg-secondary text-on-secondary font-semibold rounded-lg shadow-sm hover:opacity-90 transition-all flex items-center gap-sm">
                            <span class="material-symbols-outlined text-[20px]">save</span>
                            Save &amp; Dispatch
                        </button>
                    </div>
                </div>

                <!-- Bento-Style Form Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-lg items-start">
                    <!-- Left Column: Primary Info -->
                    <div class="lg:col-span-8 flex flex-col gap-lg">
                        <!-- Section 1: Client Info & Map -->
                        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden">
                            <div class="px-lg py-md border-b border-outline-variant bg-surface-container-low flex items-center gap-sm">
                                <span class="material-symbols-outlined text-secondary">person_pin_circle</span>
                                <h2 class="text-headline-sm font-headline-sm font-semibold">Client Information</h2>
                            </div>
                            <div class="p-lg grid grid-cols-1 md:grid-cols-2 gap-lg">
                                <div class="flex flex-col gap-md">
                                    <div>
                                        <label class="block text-label-caps font-label-caps text-on-surface-variant mb-xs">CLIENT NAME</label>
                                        <input class="w-full px-md py-sm bg-white border border-outline rounded-lg focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all text-sm" id="clientName" placeholder="e.g. Anderson Residence" required type="text" />
                                    </div>
                                    <div>
                                        <label class="block text-label-caps font-label-caps text-on-surface-variant mb-xs">PHONE NUMBER</label>
                                        <input class="w-full px-md py-sm bg-white border border-outline rounded-lg focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all text-sm" id="clientPhone" placeholder="+1 (555) 000-0000" required type="tel" />
                                    </div>
                                    <div>
                                        <label class="block text-label-caps font-label-caps text-on-surface-variant mb-xs">SERVICE ADDRESS</label>
                                        <div class="relative">
                                            <input class="w-full pl-md pr-10 py-sm bg-white border border-outline rounded-lg focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all text-sm" id="serviceAddress" placeholder="Street, City, Zip Code" required type="text" />
                                            <span class="material-symbols-outlined absolute right-3 top-2 text-outline">location_on</span>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-sm">
                                        <div>
                                            <label class="block text-label-[10px] font-label-caps text-on-surface-variant mb-xs">LATITUDE</label>
                                            <input class="w-full px-sm py-xs bg-white border border-outline rounded-lg focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all text-xs" id="latitude" placeholder="e.g. 41.8781" required type="number" step="any" />
                                        </div>
                                        <div>
                                            <label class="block text-label-[10px] font-label-caps text-on-surface-variant mb-xs">LONGITUDE</label>
                                            <input class="w-full px-sm py-xs bg-white border border-outline rounded-lg focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all text-xs" id="longitude" placeholder="e.g. -87.6298" required type="number" step="any" />
                                        </div>
                                    </div>
                                </div>
                                <!-- Geolocation Picker Placeholder -->
                                <div class="relative h-full min-h-[220px] rounded-lg border border-outline-variant overflow-hidden">
                                    <iframe class="w-full h-full border-none" 
                                        src="https://maps.google.com/maps?q=Chicago&t=&z=11&ie=UTF8&iwloc=&output=embed"></iframe>
                                    <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm p-2 rounded-lg border border-outline-variant shadow-sm">
                                        <span class="text-label-caps font-label-caps text-primary block">DISPATCH REGION</span>
                                        <span class="text-data-mono font-data-mono text-secondary text-xs">Chicago Area Command</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: AC Issue Details -->
                        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden">
                            <div class="px-lg py-md border-b border-outline-variant bg-surface-container-low flex items-center gap-sm">
                                <span class="material-symbols-outlined text-secondary">ac_unit</span>
                                <h2 class="text-headline-sm font-headline-sm font-semibold">Service Requirements</h2>
                            </div>
                            <div class="p-lg flex flex-col gap-lg">
                                <div>
                                    <label class="block text-label-caps font-label-caps text-on-surface-variant mb-xs">ISSUE DESCRIPTION</label>
                                    <textarea class="w-full px-md py-sm bg-white border border-outline rounded-lg focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all resize-none text-sm" id="issueDescription" placeholder="Provide details of the AC unit malfunction or service requirements..." required rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Scheduling & Assignment -->
                    <div class="lg:col-span-4 flex flex-col gap-lg">
                        <!-- Section 3: Scheduling -->
                        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden shadow-sm">
                            <div class="px-lg py-md border-b border-outline-variant bg-surface-container-low flex items-center gap-sm">
                                <span class="material-symbols-outlined text-secondary">calendar_today</span>
                                <h2 class="text-headline-sm font-headline-sm font-semibold">Schedule</h2>
                            </div>
                            <div class="p-lg flex flex-col gap-md">
                                <div>
                                    <label class="block text-label-caps font-label-caps text-on-surface-variant mb-xs">SCHEDULED DATE &amp; TIME</label>
                                    <input class="w-full px-md py-sm bg-white border border-outline rounded-lg focus:ring-2 focus:ring-secondary/20 focus:border-secondary outline-none transition-all text-sm" id="scheduledAt" required type="datetime-local" />
                                </div>
                            </div>
                        </div>

                        <!-- Section 4: Assignment -->
                        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden shadow-sm">
                            <div class="px-lg py-md border-b border-outline-variant bg-surface-container-low flex items-center justify-between">
                                <div class="flex items-center gap-sm">
                                    <span class="material-symbols-outlined text-secondary">engineering</span>
                                    <h2 class="text-headline-sm font-headline-sm font-semibold">Assign Technician</h2>
                                </div>
                            </div>
                            <div class="p-md flex flex-col gap-xs max-h-[320px] overflow-y-auto custom-scrollbar" id="techSelectList">
                                <p class="text-sm text-on-surface-variant p-sm text-center">Loading technicians...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>
</div>

<script>
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
                renderTechOptions(techs);
            }
        } catch (err) {
            console.error('Error loading technicians:', err);
        }
    }

    function renderTechOptions(techs) {
        const list = document.getElementById('techSelectList');
        if (techs.length === 0) {
            list.innerHTML = `<p class="text-sm text-on-surface-variant p-sm text-center">No technicians available.</p>`;
            return;
        }

        list.innerHTML = techs.map(tech => {
            const statusLabel = tech.currentStatus === 'on_duty' 
                ? `<span class="px-sm py-xs bg-green-100 text-green-700 text-[9px] font-bold rounded">DUTY</span>`
                : `<span class="px-sm py-xs bg-gray-100 text-gray-700 text-[9px] font-bold rounded">OFFLINE</span>`;

            return `
                <label class="flex items-center justify-between p-sm border border-outline-variant rounded-lg hover:bg-surface-container transition-all cursor-pointer group">
                    <div class="flex items-center gap-md">
                        <input type="radio" name="assignedTo" value="${tech.id}" class="focus:ring-secondary text-secondary" />
                        <div>
                            <div class="text-body-md font-semibold text-primary">${escapeHtml(tech.name)}</div>
                            <div class="text-xs text-on-surface-variant">@${escapeHtml(tech.username)}</div>
                        </div>
                    </div>
                    ${statusLabel}
                </label>
            `;
        }).join('');
    }

    async function handleJobDispatch(event) {
        event.preventDefault();
        const token = localStorage.getItem('api_token');
        const submitBtn = event.target.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<span class="material-symbols-outlined animate-spin text-sm">sync</span> Dispatching...';
        submitBtn.disabled = true;

        const clientName = document.getElementById('clientName').value;
        const clientPhone = document.getElementById('clientPhone').value;
        const serviceAddress = document.getElementById('serviceAddress').value;
        const latitude = document.getElementById('latitude').value;
        const longitude = document.getElementById('longitude').value;
        const issueDescription = document.getElementById('issueDescription').value;
        const scheduledAt = document.getElementById('scheduledAt').value;

        const selectedTech = document.querySelector('input[name="assignedTo"]:checked');
        const assignedTo = selectedTech ? selectedTech.value : null;

        try {
            const response = await fetch('/api/v1/admin/jobs', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    clientName,
                    clientPhone,
                    serviceAddress,
                    latitude,
                    longitude,
                    issueDescription,
                    scheduledAt,
                    assignedTo
                })
            });

            if (response.ok) {
                window.location.href = '/dashboard';
            } else {
                const errData = await response.json();
                alert(errData.message || 'Failed to dispatch job.');
            }
        } catch (err) {
            console.error(err);
            alert('Server error creating dispatch job.');
        } finally {
            submitBtn.innerHTML = '<span class="material-symbols-outlined text-[20px]">save</span> Save &amp; Dispatch';
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

    // Set default date to today
    document.getElementById('scheduledAt').value = new Date().toISOString().slice(0, 16);

    // Initial load
    loadTechnicians();
</script>
    </main>
</div>
</body>
</html>