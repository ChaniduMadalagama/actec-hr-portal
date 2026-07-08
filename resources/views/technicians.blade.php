<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>LogiFlow Dispatch - Technician Management</title>
    <link href="/assets/0f60630073a0d3e5ff06cfa428922188.css" rel="stylesheet" />
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
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9ff;
        }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
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
        <!-- Nav Item: Job Queue -->
        <a class="flex items-center px-md py-sm rounded text-on-primary-container hover:bg-surface-variant/10 transition-colors duration-200 cursor-pointer" href="/jobs">
            <span class="material-symbols-outlined mr-md">assignment</span>
            <span class="font-body-md text-body-md">Job Queue</span>
        </a>
        <!-- Nav Item: Technicians (ACTIVE) -->
        <a class="flex items-center px-md py-sm rounded bg-secondary-container text-on-secondary-container border-r-4 border-secondary font-bold transition-colors duration-200 cursor-pointer" href="/technicians">
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
    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <!-- TopNavBar Anchor -->
        <header class="sticky top-0 z-50 flex justify-between items-center px-lg py-sm w-full bg-surface border-b border-outline-variant">
            <div class="flex items-center gap-lg flex-1">
                <h1 class="font-headline-md text-headline-md font-bold text-primary">Technician Management</h1>
                <div class="relative w-full max-w-md ml-lg">
                    <span class="material-symbols-outlined absolute left-sm top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                    <input id="techSearchInput" class="w-full bg-surface-container-low border border-outline-variant rounded-lg pl-xl pr-md py-xs font-body-md focus:ring-2 focus:ring-secondary-container focus:border-secondary outline-none transition-all" placeholder="Search technician by name or email..." type="text" />
                </div>
            </div>
            <div class="flex items-center gap-md">
                <button class="p-xs text-on-surface-variant hover:bg-surface-container rounded-full transition-colors">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                <button class="p-xs text-on-surface-variant hover:bg-surface-container rounded-full transition-colors mr-md">
                    <span class="material-symbols-outlined">help</span>
                </button>
                <button class="bg-secondary text-on-secondary px-md py-sm rounded-lg font-bold flex items-center gap-sm hover:opacity-90 active:scale-95 transition-all" onclick="openModal()">
                    <span class="material-symbols-outlined">person_add</span>
                    Register New Technician
                </button>
            </div>
        </header>

        <!-- Dashboard Content -->
        <div class="p-lg overflow-y-auto custom-scrollbar flex-1">
            <!-- Stats Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-md mb-lg">
                <div class="bg-surface-container-lowest border border-outline-variant p-md rounded-xl">
                    <p class="text-label-caps font-label-caps text-on-surface-variant">TOTAL TECHNICIANS</p>
                    <h3 id="totalTechsCount" class="text-headline-md font-headline-md text-on-surface mt-xs">0</h3>
                </div>
                <div class="bg-surface-container-lowest border border-outline-variant p-md rounded-xl">
                    <p class="text-label-caps font-label-caps text-on-surface-variant">ON-DUTY (ACTIVE)</p>
                    <h3 id="activeTechsCount" class="text-headline-md font-headline-md text-on-surface mt-xs">0</h3>
                </div>
                <div class="bg-surface-container-lowest border border-outline-variant p-md rounded-xl">
                    <p class="text-label-caps font-label-caps text-on-surface-variant">OFF-DUTY (OFFLINE)</p>
                    <h3 id="offlineTechsCount" class="text-headline-md font-headline-md text-on-surface mt-xs">0</h3>
                </div>
            </div>

            <!-- Technician Table Card -->
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden shadow-sm">
                <div class="px-md py-sm border-b border-outline-variant bg-white">
                    <h3 class="font-headline-sm text-headline-sm text-on-surface">Technician Directory</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low border-b-2 border-outline-variant">
                                <th class="px-md py-sm font-label-caps text-label-caps text-on-surface-variant">NAME</th>
                                <th class="px-md py-sm font-label-caps text-label-caps text-on-surface-variant">EMAIL</th>
                                <th class="px-md py-sm font-label-caps text-label-caps text-on-surface-variant">USERNAME</th>
                                <th class="px-md py-sm font-label-caps text-label-caps text-on-surface-variant">LIVE STATUS</th>
                            </tr>
                        </thead>
                        <tbody id="techsTableBody" class="divide-y divide-outline-variant font-body-md text-body-md">
                            <tr>
                                <td colspan="4" class="px-md py-lg text-center text-on-surface-variant">Loading technicians...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Registration Modal Overlay -->
<div class="fixed inset-0 z-[100] hidden bg-black/40 backdrop-blur-sm flex items-center justify-center p-md" id="registrationModal">
    <!-- Form View -->
    <div class="bg-white w-full max-w-lg rounded-xl shadow-2xl overflow-hidden border border-outline-variant" id="formView">
        <div class="px-lg py-md border-b border-outline-variant flex justify-between items-center bg-surface-container-low">
            <div>
                <h2 class="font-headline-sm text-headline-sm font-bold text-on-surface">Register New Technician</h2>
                <p class="text-body-sm text-on-surface-variant">Initialize a new employee profile in the dispatch network.</p>
            </div>
            <button class="p-xs hover:bg-surface-variant rounded-full transition-colors" onclick="closeModal()">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form class="p-lg space-y-md" id="techForm" onsubmit="handleRegistration(event)">
            <div class="space-y-xs">
                <label class="font-label-caps text-label-caps text-on-surface-variant">FULL NAME</label>
                <input class="w-full bg-white border border-outline-variant rounded-lg px-md py-sm font-body-md focus:ring-2 focus:ring-secondary-container focus:border-secondary outline-none" id="fullName" placeholder="e.g. Michael Finn" required type="text" />
            </div>
            <div class="space-y-xs">
                <label class="font-label-caps text-label-caps text-on-surface-variant">USERNAME</label>
                <input class="w-full bg-white border border-outline-variant rounded-lg px-md py-sm font-body-md focus:ring-2 focus:ring-secondary-container focus:border-secondary outline-none" id="usernameInput" placeholder="e.g. m_finn" required type="text" />
            </div>
            <div class="space-y-xs">
                <label class="font-label-caps text-label-caps text-on-surface-variant">EMAIL ADDRESS</label>
                <input class="w-full bg-white border border-outline-variant rounded-lg px-md py-sm font-body-md focus:ring-2 focus:ring-secondary-container focus:border-secondary outline-none" id="email" placeholder="m.finn@logiflow.com" required type="email" />
            </div>
            <div class="pt-md border-t border-outline-variant flex justify-end gap-md">
                <button class="px-md py-sm font-bold text-on-surface-variant hover:bg-surface-container rounded-lg transition-colors" onclick="closeModal()" type="button">Cancel</button>
                <button class="px-lg py-sm bg-secondary text-on-secondary font-bold rounded-lg shadow-sm hover:opacity-90 active:scale-95 transition-all" type="submit">Create Profile</button>
            </div>
        </form>
    </div>

    <!-- Success View (Hidden initially) -->
    <div class="hidden bg-white w-full max-w-lg rounded-xl shadow-2xl overflow-hidden border border-outline-variant" id="successView">
        <div class="p-lg text-center bg-emerald-50 border-b border-emerald-100">
            <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-md border-4 border-white shadow-sm">
                <span class="material-symbols-outlined text-[32px]">check_circle</span>
            </div>
            <h2 class="font-headline-md text-headline-md font-bold text-on-surface">Registration Successful</h2>
            <p class="text-body-md text-on-surface-variant mt-xs">Profile created for <span class="font-bold text-on-surface" id="displayTechName">Michael Finn</span></p>
        </div>
        <div class="p-lg space-y-lg">
            <div class="grid grid-cols-2 gap-md">
                <div class="p-md bg-surface-container-low rounded-xl border border-outline-variant">
                    <p class="text-label-caps font-label-caps text-on-surface-variant mb-xs">UNIQUE USERNAME</p>
                    <p class="font-data-mono text-data-mono text-secondary text-lg" id="genUsername">@m_finn</p>
                </div>
                <div class="p-md bg-surface-container-low rounded-xl border border-outline-variant">
                    <p class="text-label-caps font-label-caps text-on-surface-variant mb-xs">TEMPORARY PASSWORD</p>
                    <div class="flex justify-between items-center">
                        <p class="font-data-mono text-data-mono text-on-surface text-lg tracking-wider" id="genPassword">LF-772-XT9</p>
                    </div>
                </div>
            </div>
            <div class="space-y-sm">
                <label class="font-label-caps text-label-caps text-on-surface-variant">INVITATION TEMPLATE</label>
                <div class="p-md bg-surface border border-outline-variant rounded-lg text-body-sm text-on-surface-variant italic leading-relaxed" id="invitationTemplateText">
                </div>
            </div>
            <button class="w-full py-sm border border-outline-variant rounded-lg font-bold hover:bg-surface-container-low transition-colors" onclick="closeModal()">Done, Return to List</button>
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
            tbody.innerHTML = `<tr><td colspan="4" class="px-md py-lg text-center text-on-surface-variant">No technicians registered.</td></tr>`;
            return;
        }

        tbody.innerHTML = techs.map(tech => {
            const statusBadge = tech.currentStatus === 'on_duty'
                ? `<span class="inline-flex items-center gap-xs px-sm py-xs bg-emerald-100 text-emerald-700 rounded-full text-[11px] font-bold uppercase tracking-wider"><span class="w-2 h-2 rounded-full bg-emerald-500"></span>On Duty</span>`
                : `<span class="inline-flex items-center gap-xs px-sm py-xs bg-gray-100 text-gray-700 rounded-full text-[11px] font-bold uppercase tracking-wider"><span class="w-2 h-2 rounded-full bg-gray-400"></span>Off Duty</span>`;

            return `
                <tr class="hover:bg-surface-container transition-colors">
                    <td class="px-md py-sm font-semibold text-primary">${escapeHtml(tech.name)}</td>
                    <td class="px-md py-sm text-on-surface-variant">${escapeHtml(tech.email)}</td>
                    <td class="px-md py-sm font-data-mono text-data-mono text-secondary">@${escapeHtml(tech.username)}</td>
                    <td class="px-md py-sm">${statusBadge}</td>
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
                    `"Welcome to LogiFlow, ${data.user.name}! Your technician account has been created. Username: @${data.username} | Password: ${data.password}. Please sign in to start duty."`;

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
</div>
</body>
</html>