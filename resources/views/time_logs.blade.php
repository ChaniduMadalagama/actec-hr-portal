@extends('layouts.app')

@slot('title')
    LogiFlow Dispatch | Time Tracking &amp; Audit Logs
@endslot

@section('header-actions')
<a href="/jobs/create" class="bg-secondary text-on-secondary px-6 py-2 rounded-lg flex items-center gap-2 font-semibold text-body-sm transition-all shadow-lg shadow-primary/20 hover:brightness-105 active:scale-95">
    Create New Job
</a>
@endsection

@section('content')
<!-- Page Header -->
<div class="flex flex-col md:flex-row md:items-end justify-between gap-md">
    <div>
        <h2 class="font-headline-md text-headline-md text-primary mb-base font-bold text-2xl text-white">Time Tracking &amp; Audit Logs</h2>
        <p class="font-body-md text-on-surface-variant">Verify precision and maintain compliance across the fleet.</p>
    </div>
    <!-- Filters Bar -->
    <div class="flex flex-wrap items-center gap-sm bg-surface-container-lowest p-sm rounded-xl border border-white/10 p-2">
        <div class="flex flex-col">
            <label class="font-label-caps text-label-caps text-on-surface-variant px-xs mb-xs uppercase text-[10px]">Date</label>
            <input id="filterDate" class="border-none bg-surface-container-low rounded px-2 py-1 text-body-sm focus:ring-2 focus:ring-secondary text-white" type="date" onchange="applyFilters()" />
        </div>
        <div class="w-px h-8 bg-white/10 mx-sm"></div>
        <div class="flex flex-col">
            <label class="font-label-caps text-label-caps text-on-surface-variant px-xs mb-xs uppercase text-[10px]">Technician</label>
            <select id="filterTech" class="border-none bg-surface-container-low rounded px-2 py-1 text-body-sm focus:ring-2 focus:ring-secondary min-w-[140px] text-white" onchange="applyFilters()">
                <option value="all">All Technicians</option>
            </select>
        </div>
        <button class="bg-white/5 text-white h-10 px-4 rounded font-body-sm font-semibold hover:bg-white/10 transition-colors ml-sm border border-white/10" onclick="resetFilters()">Reset</button>
    </div>
</div>

<!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <div class="glass-card p-6 rounded-2xl flex flex-col justify-between h-32 relative overflow-hidden group">
        <div class="flex justify-between items-start">
            <p class="font-label-caps text-label-caps text-outline uppercase text-[11px]">Total Deployed Hours</p>
            <div class="p-2 bg-primary/10 rounded-lg">
                <span class="material-symbols-outlined text-primary text-[20px]">schedule</span>
            </div>
        </div>
        <div class="flex items-end gap-sm">
            <span id="totalHoursText" class="font-headline-xl text-[36px] leading-none text-white font-bold">0.0</span>
            <span class="font-body-sm text-secondary bg-white/5 px-2 py-0.5 rounded text-[10px] mb-1">Hours</span>
        </div>
    </div>
    <div class="glass-card p-6 rounded-2xl flex flex-col justify-between h-32 relative overflow-hidden group">
        <div class="flex justify-between items-start">
            <p class="font-label-caps text-label-caps text-outline uppercase text-[11px]">Deviation Alerts</p>
            <div class="p-2 bg-error/10 rounded-lg">
                <span class="material-symbols-outlined text-error text-[20px]">warning</span>
            </div>
        </div>
        <div class="flex items-end gap-sm">
            <span id="tamperCountText" class="font-headline-xl text-[36px] leading-none text-error font-bold">0</span>
            <span class="font-body-sm text-error bg-error/10 px-2 py-0.5 rounded text-[10px] mb-1">Requires Audit</span>
        </div>
    </div>
    <div class="glass-card p-6 rounded-2xl flex flex-col justify-between h-32 relative overflow-hidden group col-span-2">
        <div class="flex justify-between items-start">
            <p class="font-label-caps text-label-caps text-outline uppercase text-[11px]">Fleet Security Compliance</p>
            <span class="text-[10px] font-bold text-secondary bg-white/5 px-2 py-0.5 rounded-full">TARGET: 100%</span>
        </div>
        <div class="flex items-center gap-md">
            <div class="flex-1 bg-white/5 h-2 rounded-full overflow-hidden">
                <div id="complianceBar" class="bg-secondary h-full transition-all duration-500" style="width: 0%;"></div>
            </div>
            <span id="complianceText" class="font-headline-xl text-[24px] leading-none text-white font-bold">0%</span>
        </div>
    </div>
</div>

<!-- Data Grid (Table Section) -->
<div class="glass-card rounded-2xl overflow-hidden shadow-2xl flex flex-col">
    <!-- Table Header Actions -->
    <div class="flex items-center justify-between p-6 border-b border-white/10 bg-white/5">
        <div class="flex items-center gap-sm">
            <span class="font-headline-sm text-headline-sm text-white font-semibold">Audit Log</span>
            <span class="bg-white/5 text-on-surface-variant text-[10px] px-2 py-0.5 rounded-full font-bold">LIVE UPDATE</span>
        </div>
        <button class="bg-white/5 text-white border border-white/10 px-4 py-2 rounded flex items-center gap-2 font-body-md hover:bg-white/10 transition-colors" onclick="exportReport()">
            <span class="material-symbols-outlined text-md">download</span> Export Report
        </button>
    </div>
    <!-- Table Content -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white/5 border-b border-white/10">
                    <th class="p-4 font-label-caps text-[11px] text-on-surface-variant uppercase tracking-wider">Date</th>
                    <th class="p-4 font-label-caps text-[11px] text-on-surface-variant uppercase tracking-wider">Technician</th>
                    <th class="p-4 font-label-caps text-[11px] text-on-surface-variant uppercase tracking-wider">Job ID</th>
                    <th class="p-4 font-label-caps text-[11px] text-on-surface-variant uppercase tracking-wider">Client Address</th>
                    <th class="p-4 font-label-caps text-[11px] text-on-surface-variant uppercase tracking-wider">In-Time</th>
                    <th class="p-4 font-label-caps text-[11px] text-on-surface-variant uppercase tracking-wider">Out-Time</th>
                    <th class="p-4 font-label-caps text-[11px] text-on-surface-variant uppercase tracking-wider text-right">Total Hours</th>
                    <th class="p-4 font-label-caps text-[11px] text-on-surface-variant uppercase tracking-wider">Audit Status</th>
                </tr>
            </thead>
            <tbody id="logsTableBody" class="divide-y divide-white/5">
                <tr>
                    <td colspan="8" class="p-4 text-center text-outline">Loading time tracking logs...</td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- Pagination Footer -->
    <div class="p-4 flex items-center justify-between bg-white/[0.01] border-t border-white/10">
        <span id="showingLogsText" class="text-body-sm text-on-surface-variant">Showing 0 logs</span>
        <div class="flex gap-1">
            <button class="p-1 rounded border border-white/10 hover:bg-white/5 disabled:opacity-30" disabled>
                <span class="material-symbols-outlined text-md">chevron_left</span>
            </button>
            <button class="px-3 py-1 rounded border border-secondary bg-secondary/10 text-secondary font-bold text-xs">1</button>
            <button class="p-1 rounded border border-white/10 hover:bg-white/5">
                <span class="material-symbols-outlined text-md">chevron_right</span>
            </button>
        </div>
    </div>
</div>

<!-- Contextual Info Cards -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 glass-card text-on-primary p-6 rounded-2xl flex items-center justify-between relative overflow-hidden shadow-2xl">
        <div class="relative z-10 space-y-2">
            <h3 class="font-headline-sm text-headline-sm text-white font-bold text-xl">Fleet-wide Security</h3>
            <p class="font-body-md text-slate-300 max-w-xl">LogiFlow performs active geofencing verification. Technician check-in/out coordinates are automatically cross-checked with the job's service address. Any distance deviation exceeding 5 meters triggers a security flag.</p>
            <a href="/dashboard" class="inline-block mt-4 bg-secondary text-on-secondary px-4 py-2 rounded font-semibold text-body-sm hover:brightness-110 transition-all">View Dispatch Map</a>
        </div>
        <div class="absolute right-0 top-0 h-full w-1/3 opacity-20 bg-gradient-to-l from-secondary to-transparent pointer-events-none"></div>
        <span class="material-symbols-outlined text-[120px] absolute -right-8 -bottom-8 opacity-10 pointer-events-none text-white">verified_user</span>
    </div>

    <div class="glass-card p-6 rounded-2xl shadow-2xl">
        <h3 class="font-headline-sm text-headline-sm text-white mb-4 flex items-center gap-2 font-semibold">
            <span class="material-symbols-outlined text-secondary">pending_actions</span>
            Manual Reviews
        </h3>
        <ul id="manualReviewList" class="space-y-4 divide-y divide-white/5">
            <li class="py-2 text-center text-on-surface-variant">No logs needing review.</li>
        </ul>
    </div>
</div>
@endsection

@section('scripts')
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
            tbody.innerHTML = `<tr><td colspan="8" class="p-4 text-center text-outline">No check-in logs recorded.</td></tr>`;
            reviewList.innerHTML = `<li class="py-2 text-center text-on-surface-variant">No logs needing review.</li>`;
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
            let securityStatus = `<span class="inline-flex items-center gap-1 px-3 py-1 rounded bg-green-500/10 text-green-400 font-body-sm font-semibold border border-green-500/20"><span class="material-symbols-outlined text-sm">check_circle</span>Verified</span>`;
            if (log.deviceTamperFlag) {
                tamperCount++;
                securityStatus = `<span class="inline-flex items-center gap-1 px-3 py-1 rounded bg-red-500/10 text-red-400 font-body-sm font-semibold border border-red-500/20"><span class="material-symbols-outlined text-sm">warning</span>Tamper Alert</span>`;
                
                reviewItemsHtml += `
                    <li class="flex items-center justify-between py-2 first:pt-0">
                        <div class="flex flex-col">
                            <span class="font-body-md font-bold text-white">Job #JOB-${log.jobId}</span>
                            <span class="text-xs text-on-surface-variant">${escapeHtml(techName)} · Location deviation</span>
                        </div>
                        <span class="text-error font-bold text-xs">REVIEW REQUIRED</span>
                    </li>
                `;
            }

            return `
                <tr class="hover:bg-white/[0.02] transition-colors">
                    <td class="p-4 font-body-md text-white">${logDate}</td>
                    <td class="p-4">
                        <div class="flex items-center gap-2">
                            <div class="h-8 w-8 rounded-full overflow-hidden bg-white/5 text-primary flex items-center justify-center font-bold text-xs border border-white/5">${escapeHtml(techName.substring(0, 2).toUpperCase())}</div>
                            <span class="font-body-md font-medium text-white">${escapeHtml(techName)}</span>
                        </div>
                    </td>
                    <td class="p-4 font-label-caps text-secondary-fixed-dim font-bold">#JOB-${log.jobId}</td>
                    <td class="p-4 font-body-sm text-on-surface-variant max-w-[200px] truncate" title="${escapeHtml(clientAddress)}">${escapeHtml(clientAddress)}</td>
                    <td class="p-4 font-mono text-body-sm">${checkIn}</td>
                    <td class="p-4 font-mono text-body-sm">${checkOut}</td>
                    <td class="p-4 font-body-md font-bold text-right text-white">${hoursDisplay}</td>
                    <td class="p-4">${securityStatus}</td>
                </tr>
            `;
        }).join('');

        if (reviewItemsHtml) {
            reviewList.innerHTML = reviewItemsHtml;
        } else {
            reviewList.innerHTML = `<li class="py-2 text-center text-on-surface-variant">All check-ins verified. No deviations.</li>`;
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
        const searchVal = document.getElementById('globalSearchInput').value.toLowerCase();

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
        document.getElementById('globalSearchInput').value = '';
        renderLogs(allLogs);
    }

    function exportReport() {
        alert("Preparing time tracking audit report download...");
    }

    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
    }

    // Search input listener linked to global search input
    document.getElementById('globalSearchInput').addEventListener('input', applyFilters);

    // Initial load
    loadLogs();
</script>
@endsection