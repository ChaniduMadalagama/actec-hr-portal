@extends('layouts.app')

@slot('title')
    LogiFlow Dispatch | Job Queue
@endslot

@section('header-actions')
<a href="/jobs/create" class="bg-secondary text-on-secondary px-6 py-2 rounded-lg flex items-center gap-2 font-semibold text-body-sm transition-all shadow-lg shadow-primary/20 hover:brightness-105 active:scale-95">
    Create New Job
</a>
@endsection

@section('content')
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
@endsection

@section('scripts')
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
        const searchVal = document.getElementById('globalSearchInput').value.toLowerCase();

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

    // Search input listener linked to layout search input
    document.getElementById('globalSearchInput').addEventListener('input', renderJobsTable);

    // Initial load
    loadJobs();
</script>
@endsection