<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>LogiFlow Dispatch - Device Security &amp; Session Log</title>
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
            vertical-align: middle;
        }
        body {
            background-color: #f8f9ff;
            font-family: 'Inter', sans-serif;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
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
        <!-- Nav Item: Time & Audit -->
        <a class="flex items-center px-md py-sm rounded text-on-primary-container hover:bg-surface-variant/10 transition-colors duration-200 cursor-pointer" href="/time-logs">
            <span class="material-symbols-outlined mr-md">history</span>
            <span class="font-body-md text-body-md">Time &amp; Audit</span>
        </a>
        <!-- Nav Item: Settings (ACTIVE) -->
        <a class="flex items-center px-md py-sm rounded bg-secondary-container text-on-secondary-container border-r-4 border-secondary transition-colors duration-200 cursor-pointer" href="/settings">
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

<div class="flex-1 flex flex-col ml-64 h-screen">
    <!-- TopNavBar (Top) -->
    <header class="sticky top-0 z-50 flex justify-between items-center px-lg py-sm w-full bg-surface dark:bg-surface-container-high border-b border-outline-variant dark:border-outline">
        <div class="flex items-center gap-lg flex-1">
            <span class="font-headline-md text-headline-md font-bold text-primary dark:text-inverse-primary">LogiFlow Dispatch</span>
            <div class="relative w-full max-w-md hidden md:block">
                <span class="material-symbols-outlined absolute left-sm top-1/2 -translate-y-1/2 text-on-surface-variant" data-icon="search">search</span>
                <input id="sessionSearchInput" class="w-full pl-xl pr-md py-xs bg-surface-container-low border border-outline-variant rounded focus:outline-none focus:ring-2 focus:ring-secondary/20 font-body-md" placeholder="Search devices or IDs..." type="text" />
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

    <!-- Main Content Area -->
    <main class="p-lg space-y-lg overflow-y-auto max-h-[calc(100vh-64px)] custom-scrollbar">
        <!-- Bento Grid Summary Stats -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-lg">
            <!-- Stat Card 1 -->
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-lg flex flex-col justify-between" id="statCardDevices">
                <div>
                    <div class="flex justify-between items-start mb-sm">
                        <span class="font-label-caps text-label-caps text-outline uppercase tracking-wider">Total Active Devices</span>
                        <span class="material-symbols-outlined text-secondary">devices</span>
                    </div>
                    <h3 class="font-headline-lg text-headline-lg text-on-surface">1,248</h3>
                </div>
                <div class="mt-lg flex items-center gap-xs">
                    <span class="text-secondary font-bold text-body-sm">+12%</span>
                    <span class="text-outline text-body-sm">from last week</span>
                </div>
            </div>
            <!-- Stat Card 2 -->
            <div class="bg-error-container border border-error/20 rounded-xl p-lg flex flex-col justify-between" id="statCardAttempts">
                <div>
                    <div class="flex justify-between items-start mb-sm">
                        <span class="font-label-caps text-label-caps text-on-error-container uppercase tracking-wider">Unauthorized Access Attempts</span>
                        <span class="material-symbols-outlined text-error">warning</span>
                    </div>
                    <h3 class="font-headline-lg text-headline-lg text-on-error-container">14</h3>
                </div>
                <div class="mt-lg flex items-center gap-xs">
                    <span class="text-error font-bold text-body-sm">Critical</span>
                    <span class="text-on-error-container/60 text-body-sm">Requires immediate review</span>
                </div>
            </div>
            <!-- Stat Card 3 -->
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-lg flex flex-col justify-between" id="statCardRegistrations">
                <div>
                    <div class="flex justify-between items-start mb-sm">
                        <span class="font-label-caps text-label-caps text-outline uppercase tracking-wider">New Registrations (24h)</span>
                        <span class="material-symbols-outlined text-secondary">app_registration</span>
                    </div>
                    <h3 class="font-headline-lg text-headline-lg text-on-surface">32</h3>
                </div>
                <div class="mt-lg flex items-center gap-xs">
                    <div class="flex -space-x-2">
                        <img alt="User 1" class="w-6 h-6 rounded-full border-2 border-surface-bright" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=64&q=80" />
                        <img alt="User 2" class="w-6 h-6 rounded-full border-2 border-surface-bright" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=64&q=80" />
                    </div>
                    <span class="text-outline text-body-sm ml-sm">Verification pending for 8 devices</span>
                </div>
            </div>
        </section>

        <!-- Table Section -->
        <section class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden flex flex-col">
            <!-- Table Header/Controls -->
            <div class="px-lg py-md border-b border-outline-variant flex flex-col md:flex-row md:items-center justify-between gap-md bg-white">
                <div>
                    <h4 class="font-headline-sm text-headline-sm text-on-surface font-semibold">Session &amp; Device Audit Log</h4>
                    <p class="text-body-sm text-outline">Real-time monitoring of all active technician login sessions</p>
                </div>
                <div class="flex items-center gap-sm">
                    <button class="flex items-center gap-xs px-md py-sm bg-surface-bright border border-outline-variant text-on-surface-variant font-body-sm rounded-lg hover:bg-surface-container transition-colors" onclick="alert('Filtering applied')">
                        <span class="material-symbols-outlined text-md">filter_list</span> Filter
                    </button>
                    <button class="flex items-center gap-xs px-md py-sm bg-secondary text-white font-body-sm rounded-lg hover:opacity-90 transition-opacity" onclick="alert('Exporting session log...')">
                        <span class="material-symbols-outlined text-md">file_download</span> Export CSV
                    </button>
                </div>
            </div>
            <!-- Scrollable Table Wrapper -->
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse min-w-[1000px]">
                    <thead class="bg-surface-container-low border-b border-outline-variant">
                        <tr>
                            <th class="px-lg py-md font-label-caps text-label-caps text-outline uppercase">Timestamp</th>
                            <th class="px-lg py-md font-label-caps text-label-caps text-outline uppercase">Technician</th>
                            <th class="px-lg py-md font-label-caps text-label-caps text-outline uppercase">Device / Model</th>
                            <th class="px-lg py-md font-label-caps text-label-caps text-outline uppercase">Unique ID (UUID)</th>
                            <th class="px-lg py-md font-label-caps text-label-caps text-outline uppercase">Location</th>
                            <th class="px-lg py-md font-label-caps text-label-caps text-outline uppercase text-center">Security Status</th>
                            <th class="px-lg py-md font-label-caps text-label-caps text-outline uppercase text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/60">
                        <!-- Row 1: Flagged/Suspicious -->
                        <tr class="hover:bg-surface-container/30 transition-colors">
                            <td class="px-lg py-md font-data-mono text-data-mono text-on-surface">2023-11-24 14:32:01</td>
                            <td class="px-lg py-md">
                                <div class="flex items-center gap-sm">
                                    <img class="w-8 h-8 rounded-full border border-outline-variant" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=64&q=80" />
                                    <span class="font-body-md text-body-md font-semibold text-on-surface">Marcus Chen</span>
                                </div>
                            </td>
                            <td class="px-lg py-md">
                                <div class="flex items-center gap-xs">
                                    <span class="material-symbols-outlined text-md text-outline">smartphone</span>
                                    <span class="font-body-md text-body-md text-on-surface">iPhone 15 Pro</span>
                                </div>
                            </td>
                            <td class="px-lg py-md font-data-mono text-data-mono text-outline">f83e-a12b-c90d</td>
                            <td class="px-lg py-md font-body-sm text-body-sm text-on-surface">Chicago, IL</td>
                            <td class="px-lg py-md text-center">
                                <div class="inline-flex items-center gap-xs bg-error/10 text-error px-2 py-1 rounded border border-error/20">
                                    <span class="material-symbols-outlined text-[16px]">warning</span>
                                    <span class="font-label-caps text-[10px] uppercase font-bold">Flagged</span>
                                </div>
                            </td>
                            <td class="px-lg py-md text-right">
                                <div class="flex justify-end gap-xs">
                                    <button class="p-2 text-error hover:bg-error/10 rounded-lg transition-colors" title="Lock Account" onclick="alert('Account Locked')">
                                        <span class="material-symbols-outlined">lock</span>
                                    </button>
                                    <button class="p-2 text-on-surface-variant hover:bg-surface-container-high rounded-lg transition-colors" title="View Details" onclick="alert('Session details...')">
                                        <span class="material-symbols-outlined">visibility</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- Row 2: New Device -->
                        <tr class="hover:bg-surface-container/30 transition-colors">
                            <td class="px-lg py-md font-data-mono text-data-mono text-on-surface">2023-11-24 14:28:45</td>
                            <td class="px-lg py-md">
                                <div class="flex items-center gap-sm">
                                    <img class="w-8 h-8 rounded-full border border-outline-variant" src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=64&q=80" />
                                    <span class="font-body-md text-body-md font-semibold text-on-surface">Elena Rodriguez</span>
                                </div>
                            </td>
                            <td class="px-lg py-md">
                                <div class="flex items-center gap-xs">
                                    <span class="material-symbols-outlined text-md text-outline">laptop_mac</span>
                                    <span class="font-body-md text-body-md text-on-surface">MacBook Pro 14"</span>
                                </div>
                            </td>
                            <td class="px-lg py-md font-data-mono text-data-mono text-outline">a921-f3b0-22e1</td>
                            <td class="px-lg py-md font-body-sm text-body-sm text-on-surface">Austin, TX</td>
                            <td class="px-lg py-md text-center">
                                <div class="inline-flex items-center gap-xs bg-secondary/10 text-secondary px-2 py-1 rounded border border-secondary/20">
                                    <span class="material-symbols-outlined text-[16px]">new_releases</span>
                                    <span class="font-label-caps text-[10px] uppercase font-bold">New Device</span>
                                </div>
                            </td>
                            <td class="px-lg py-md text-right">
                                <div class="flex justify-end gap-xs items-center">
                                    <button class="px-sm py-1 border border-secondary text-secondary font-label-caps text-[10px] rounded hover:bg-secondary/5 transition-colors uppercase font-bold" onclick="alert('Authorized Device')">Authorize</button>
                                    <button class="p-2 text-on-surface-variant hover:bg-surface-container-high rounded-lg transition-colors" onclick="alert('Device logged out')">
                                        <span class="material-symbols-outlined">logout</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- Row 3: Verified -->
                        <tr class="hover:bg-surface-container/30 transition-colors">
                            <td class="px-lg py-md font-data-mono text-data-mono text-on-surface">2023-11-24 14:15:20</td>
                            <td class="px-lg py-md">
                                <div class="flex items-center gap-sm">
                                    <img class="w-8 h-8 rounded-full border border-outline-variant" src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=64&q=80" />
                                    <span class="font-body-md text-body-md font-semibold text-on-surface">David Wilson</span>
                                </div>
                            </td>
                            <td class="px-lg py-md">
                                <div class="flex items-center gap-xs">
                                    <span class="material-symbols-outlined text-md text-outline">tablet_android</span>
                                    <span class="font-body-md text-body-md text-on-surface">Samsung Galaxy Tab S9</span>
                                </div>
                            </td>
                            <td class="px-lg py-md font-data-mono text-data-mono text-outline">b222-7777-a1x2</td>
                            <td class="px-lg py-md font-body-sm text-body-sm text-on-surface">Denver, CO</td>
                            <td class="px-lg py-md text-center">
                                <div class="inline-flex items-center gap-xs bg-green-50 text-green-700 px-2 py-1 rounded border border-green-200">
                                    <span class="material-symbols-outlined text-[16px]">verified</span>
                                    <span class="font-label-caps text-[10px] uppercase font-bold">Verified</span>
                                </div>
                            </td>
                            <td class="px-lg py-md text-right">
                                <div class="flex justify-end gap-xs">
                                    <button class="p-2 text-on-surface-variant hover:bg-surface-container-high rounded-lg transition-colors">
                                        <span class="material-symbols-outlined">more_vert</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- Row 4: Critical -->
                        <tr class="hover:bg-surface-container/30 transition-colors border-l-4 border-error">
                            <td class="px-lg py-md font-data-mono text-data-mono text-on-surface">2023-11-24 14:10:05</td>
                            <td class="px-lg py-md">
                                <div class="flex items-center gap-sm">
                                    <div class="w-8 h-8 rounded-full bg-error/10 flex items-center justify-center border border-error/20">
                                        <span class="material-symbols-outlined text-error text-sm">person_off</span>
                                    </div>
                                    <span class="font-body-md text-body-md font-semibold text-error">Unregistered User</span>
                                </div>
                            </td>
                            <td class="px-lg py-md">
                                <div class="flex items-center gap-xs">
                                    <span class="material-symbols-outlined text-md text-outline">public</span>
                                    <span class="font-body-md text-body-md text-on-surface">Unknown Proxy</span>
                                </div>
                            </td>
                            <td class="px-lg py-md font-data-mono text-data-mono text-outline">unknown-ffff-0000</td>
                            <td class="px-lg py-md font-body-sm text-body-sm text-error font-bold">Lagos, Nigeria</td>
                            <td class="px-lg py-md text-center">
                                <div class="inline-flex items-center gap-xs bg-error text-white px-2 py-1 rounded shadow-sm">
                                    <span class="material-symbols-outlined text-[16px]">gpp_maybe</span>
                                    <span class="font-label-caps text-[10px] uppercase font-bold">Critical</span>
                                </div>
                            </td>
                            <td class="px-lg py-md text-right">
                                <div class="flex justify-end gap-xs">
                                    <button class="px-md py-1 bg-error text-white font-label-caps text-[10px] rounded hover:bg-error/90 transition-all uppercase flex items-center gap-xs font-bold" onclick="alert('Remote Logout executed')">
                                        <span class="material-symbols-outlined text-sm">block</span> Remote Logout
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-lg py-md border-t border-outline-variant flex items-center justify-between bg-white">
                <span class="text-body-sm text-outline">Showing 4 of 288 active sessions</span>
                <div class="flex items-center gap-xs">
                    <button class="p-1 border border-outline-variant rounded hover:bg-surface-container transition-colors disabled:opacity-50" disabled>
                        <span class="material-symbols-outlined">chevron_left</span>
                    </button>
                    <div class="flex gap-xs">
                        <button class="w-8 h-8 bg-secondary text-white font-body-sm rounded">1</button>
                        <button class="w-8 h-8 hover:bg-surface-container font-body-sm rounded">2</button>
                        <button class="w-8 h-8 hover:bg-surface-container font-body-sm rounded">3</button>
                    </div>
                    <button class="p-1 border border-outline-variant rounded hover:bg-surface-container transition-colors">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </button>
                </div>
            </div>
        </section>

        <!-- Bottom Detail Grid -->
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-lg">
            <!-- Login Geo-Map -->
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-lg flex flex-col h-[400px]">
                <div class="flex items-center justify-between mb-lg">
                    <div>
                        <h4 class="font-headline-sm text-headline-sm text-on-surface font-semibold">Live Access Heatmap</h4>
                        <p class="text-body-sm text-outline">Active sessions by geographical density</p>
                    </div>
                    <button class="p-2 hover:bg-surface-container rounded-full">
                        <span class="material-symbols-outlined">fullscreen</span>
                    </button>
                </div>
                <div class="flex-1 rounded-lg bg-surface-container-low overflow-hidden relative">
                    <!-- Simulated Map Background -->
                    <div class="absolute inset-0 bg-cover bg-center opacity-70" style="background-image: url('https://www.gstatic.com/labs-code/stitch/stitch-placeholder-300x300.svg')">
                    </div>
                    <!-- Hotspots -->
                    <div class="absolute top-1/4 left-1/4 w-8 h-8 bg-secondary/30 rounded-full animate-ping"></div>
                    <div class="absolute top-1/4 left-1/4 w-4 h-4 bg-secondary rounded-full shadow-lg border-2 border-white"></div>
                    <div class="absolute bottom-1/3 right-1/4 w-12 h-12 bg-error/20 rounded-full animate-pulse"></div>
                    <div class="absolute bottom-1/3 right-1/4 w-4 h-4 bg-error rounded-full shadow-lg border-2 border-white"></div>
                    <!-- Map Overlay Controls -->
                    <div class="absolute top-4 right-4 flex flex-col gap-2">
                        <button class="w-8 h-8 bg-surface-bright border border-outline-variant rounded shadow flex items-center justify-center hover:bg-white">
                            <span class="material-symbols-outlined text-sm">add</span>
                        </button>
                        <button class="w-8 h-8 bg-surface-bright border border-outline-variant rounded shadow flex items-center justify-center hover:bg-white">
                            <span class="material-symbols-outlined text-sm">remove</span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Security Recommendations -->
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-lg flex flex-col h-[400px]">
                <h4 class="font-headline-sm text-headline-sm text-on-surface mb-lg font-semibold">Security Health Check</h4>
                <div class="flex-1 space-y-md">
                    <div class="p-md bg-surface-bright border border-outline-variant rounded-lg flex items-start gap-md">
                        <div class="w-10 h-10 bg-on-tertiary-fixed-variant/10 rounded-full flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-on-tertiary-fixed-variant">key</span>
                        </div>
                        <div>
                            <h5 class="font-body-md font-bold text-on-surface">Force MFA Reset</h5>
                            <p class="text-body-sm text-outline mb-sm">8% of technician accounts haven't refreshed their Multi-Factor credentials in 90+ days.</p>
                            <button class="text-secondary font-label-caps text-[11px] uppercase hover:underline font-semibold">Execute Policy Update</button>
                        </div>
                    </div>
                    <div class="p-md bg-surface-bright border border-outline-variant rounded-lg flex items-start gap-md">
                        <div class="w-10 h-10 bg-error/10 rounded-full flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-error">cloud_off</span>
                        </div>
                        <div>
                            <h5 class="font-body-md font-bold text-on-surface">Unauthorized IP Range</h5>
                            <p class="text-body-sm text-outline mb-sm">Detected 3 login attempts from a known proxy network. Recommend IP Blacklisting.</p>
                            <button class="text-error font-label-caps text-[11px] uppercase hover:underline font-semibold">Manage Blocklist</button>
                        </div>
                    </div>
                    <div class="p-md bg-surface-bright border border-outline-variant rounded-lg flex items-start gap-md">
                        <div class="w-10 h-10 bg-secondary/10 rounded-full flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-secondary">phonelink_lock</span>
                        </div>
                        <div>
                            <h5 class="font-body-md font-bold text-on-surface">Auto-Logout Policy</h5>
                            <p class="text-body-sm text-outline mb-sm">Idle session timeout currently set to 4 hours. Recommend reducing to 2 hours for dispatchers.</p>
                            <button class="text-secondary font-label-caps text-[11px] uppercase hover:underline font-semibold">Adjust Settings</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

<script>
    // Search interactions
    const searchInput = document.getElementById('sessionSearchInput');
    searchInput.addEventListener('input', (e) => {
        const val = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(val) ? '' : 'none';
        });
    });

    // Hover effects on stat cards
    const statCards = [
        document.getElementById('statCardDevices'),
        document.getElementById('statCardAttempts'),
        document.getElementById('statCardRegistrations')
    ];
    statCards.forEach(card => {
        if (!card) return;
        card.addEventListener('mouseenter', () => {
            card.classList.add('shadow-md');
            card.style.transform = 'translateY(-2px)';
            card.style.transition = 'all 0.2s ease-in-out';
        });
        card.addEventListener('mouseleave', () => {
            card.classList.remove('shadow-md');
            card.style.transform = 'translateY(0)';
        });
    });

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
