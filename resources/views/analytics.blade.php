@extends('layouts.app')

@slot('title')
    LogiFlow Dispatch | Analytics & Insights
@endslot

@section('header-actions')
<a href="/jobs/create" class="bg-secondary text-on-secondary px-6 py-2 rounded-lg flex items-center gap-2 font-semibold text-body-sm transition-all shadow-lg shadow-primary/20 hover:brightness-105 active:scale-95">
    Create New Job
</a>
@endsection

@section('content')
<!-- Page Header -->
<div>
    <h2 class="font-headline-lg text-headline-lg text-white mb-1">Analytics &amp; Insights</h2>
    <p class="text-outline font-body-md">Analyze technician duty times, shift details, and working durations.</p>
</div>

<!-- Stats Summary Bento -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="glass-card p-6 rounded-2xl flex flex-col justify-between h-32 relative overflow-hidden group">
        <div class="flex justify-between items-start">
            <p class="font-label-caps text-label-caps text-outline uppercase text-[11px]">Total Tracked Hours</p>
            <div class="p-2 bg-primary/10 rounded-lg">
                <span class="material-symbols-outlined text-primary text-[20px]">timer</span>
            </div>
        </div>
        <h3 id="statTotalHours" class="font-headline-xl text-[40px] leading-none text-white font-bold">0.0</h3>
    </div>
    <div class="glass-card p-6 rounded-2xl flex flex-col justify-between h-32 relative overflow-hidden group">
        <div class="flex justify-between items-start">
            <p class="font-label-caps text-label-caps text-outline uppercase text-[11px]">Average Session Duration</p>
            <div class="p-2 bg-secondary-fixed-dim/10 rounded-lg">
                <span class="material-symbols-outlined text-secondary-fixed-dim text-[20px]">avg_time</span>
            </div>
        </div>
        <h3 id="statAvgDuration" class="font-headline-xl text-[40px] leading-none text-white font-bold">0.0 hrs</h3>
    </div>
    <div class="glass-card p-6 rounded-2xl flex flex-col justify-between h-32 relative overflow-hidden group">
        <div class="flex justify-between items-start">
            <p class="font-label-caps text-label-caps text-outline uppercase text-[11px]">Completed Sessions</p>
            <div class="p-2 bg-green-400/10 rounded-lg">
                <span class="material-symbols-outlined text-green-400 text-[20px]">check_circle</span>
            </div>
        </div>
        <h3 id="statTotalSessions" class="font-headline-xl text-[40px] leading-none text-white font-bold">0</h3>
    </div>
</div>

<!-- Main Section Split -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Sessions Table -->
    <div class="lg:col-span-2 glass-card rounded-2xl overflow-hidden flex flex-col shadow-2xl">
        <div class="px-6 py-5 border-b border-white/10 bg-white/5 flex items-center justify-between">
            <h2 class="text-headline-md font-headline-md text-on-surface text-lg text-white">Technician Duty Hours</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/5 border-b border-white/10">
                        <th class="px-6 py-4 text-label-caps font-label-caps text-on-surface-variant uppercase tracking-wider">Technician</th>
                        <th class="px-6 py-4 text-label-caps font-label-caps text-on-surface-variant uppercase tracking-wider">Shift Date</th>
                        <th class="px-6 py-4 text-label-caps font-label-caps text-on-surface-variant uppercase tracking-wider">Clock In</th>
                        <th class="px-6 py-4 text-label-caps font-label-caps text-on-surface-variant uppercase tracking-wider">Clock Out</th>
                        <th class="px-6 py-4 text-label-caps font-label-caps text-on-surface-variant uppercase tracking-wider text-right">Duration</th>
                    </tr>
                </thead>
                <tbody id="analyticsTableBody" class="divide-y divide-white/5">
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-outline">Loading shift logs...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Productivity / Headcount stats -->
    <div class="glass-card rounded-2xl p-6 flex flex-col shadow-2xl">
        <h3 class="font-headline-sm text-headline-sm text-white mb-6 flex items-center gap-2 font-semibold">
            <span class="material-symbols-outlined text-secondary">analytics</span>
            Worked Hours by Tech
        </h3>
        <div id="techLeaderboard" class="space-y-6">
            <p class="text-sm text-outline text-center py-4">Loading stats...</p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let allLogs = [];

    async function loadAnalyticsData() {
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
                renderAnalytics();
            }
        } catch (err) {
            console.error('Error loading analytics logs:', err);
        }
    }

    function renderAnalytics() {
        const tbody = document.getElementById('analyticsTableBody');
        const searchVal = document.getElementById('globalSearchInput').value.toLowerCase();

        // Filter logs based on global search value
        let filtered = allLogs;
        if (searchVal) {
            filtered = allLogs.filter(log => {
                const name = log.technician ? log.technician.name.toLowerCase() : '';
                const email = log.technician ? log.technician.email.toLowerCase() : '';
                return name.includes(searchVal) || email.includes(searchVal);
            });
        }

        // Metrics aggregation
        const completedSessions = filtered.filter(l => l.checkOutTime !== null);
        const totalSessionsCount = completedSessions.length;

        let sumHours = 0;
        const techHours = {}; // map of techId => { name, totalHours }

        completedSessions.forEach(log => {
            const hrs = log.totalHours !== null ? parseFloat(log.totalHours) : 0;
            sumHours += hrs;

            if (log.technician) {
                const t = log.technician;
                if (!techHours[t.id]) {
                    techHours[t.id] = { name: t.name, totalHours: 0 };
                }
                techHours[t.id].totalHours += hrs;
            }
        });

        const avgDuration = totalSessionsCount > 0 ? (sumHours / totalSessionsCount).toFixed(1) : '0.0';

        document.getElementById('statTotalHours').innerText = sumHours.toFixed(1);
        document.getElementById('statAvgDuration').innerText = `${avgDuration} hrs`;
        document.getElementById('statTotalSessions').innerText = totalSessionsCount;

        // Render Table Body
        if (filtered.length === 0) {
            tbody.innerHTML = `<tr><td colspan="5" class="px-6 py-8 text-center text-outline">No working shift logs found.</td></tr>`;
            document.getElementById('techLeaderboard').innerHTML = `<p class="text-sm text-outline text-center py-4">No hours logged.</p>`;
            return;
        }

        tbody.innerHTML = filtered.map(log => {
            const techName = log.technician ? log.technician.name : 'Unknown';
            const logDate = log.checkInTime ? new Date(log.checkInTime).toLocaleDateString() : 'N/A';
            const checkIn = log.checkInTime ? new Date(log.checkInTime).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : 'N/A';
            const checkOut = log.checkOutTime ? new Date(log.checkOutTime).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : 'Active';
            const hoursDisplay = log.totalHours !== null ? `${log.totalHours} hrs` : 'Active';
            const initials = techName.split(' ').map(n => n[0]).join('').slice(0, 2).toUpperCase();

            return `
                <tr class="hover:bg-white/[0.02] transition-colors group">
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center border border-white/5 font-bold text-primary group-hover:scale-105 transition-transform">
                                ${initials}
                            </div>
                            <span class="font-semibold text-white text-body-md">${escapeHtml(techName)}</span>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-body-sm text-on-surface-variant">${logDate}</td>
                    <td class="px-6 py-5 font-mono text-body-sm text-outline">${checkIn}</td>
                    <td class="px-6 py-5 font-mono text-body-sm text-outline">${checkOut}</td>
                    <td class="px-6 py-5 font-body-md font-bold text-right text-white">${hoursDisplay}</td>
                </tr>
            `;
        }).join('');

        // Render Leaderboard / worked duration bars
        const techList = Object.values(techHours).sort((a, b) => b.totalHours - a.totalHours);
        const maxHours = techList.length > 0 ? Math.max(...techList.map(t => t.totalHours), 1) : 1;

        if (techList.length === 0) {
            document.getElementById('techLeaderboard').innerHTML = `<p class="text-sm text-outline text-center py-4">No hours logged.</p>`;
            return;
        }

        document.getElementById('techLeaderboard').innerHTML = techList.map(t => {
            const percentage = Math.min((t.totalHours / maxHours) * 100, 100);
            return `
                <div class="space-y-2">
                    <div class="flex justify-between items-center text-body-sm">
                        <span class="font-semibold text-white">${escapeHtml(t.name)}</span>
                        <span class="font-bold text-secondary font-mono">${t.totalHours.toFixed(1)} hrs</span>
                    </div>
                    <div class="w-full bg-white/5 h-2 rounded-full overflow-hidden">
                        <div class="bg-secondary h-full rounded-full transition-all duration-500 shadow-[0_0_8px_rgba(0,219,231,0.5)]" style="width: ${percentage}%"></div>
                    </div>
                </div>
            `;
        }).join('');
    }

    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
    }

    // Search filter for table via global search input
    document.getElementById('globalSearchInput').addEventListener('input', renderAnalytics);

    // Initial load
    loadAnalyticsData();
</script>
@endsection
