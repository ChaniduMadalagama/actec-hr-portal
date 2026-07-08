@extends('layouts.app')

@slot('title')
    LogiFlow Dispatch | Control Center
@endslot

@section('content')
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
@endsection

@section('scripts')
<script>
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
                <tr class="hover:bg-white/[0.03] transition-colors group">
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

    // Search filter for table via global search input
    document.getElementById('globalSearchInput').addEventListener('input', (e) => {
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
@endsection