@extends('layouts.app')

@slot('title')
    LogiFlow Dispatch | Device Security &amp; Session Log
@endslot

@section('header-actions')
<a href="/jobs/create" class="bg-secondary text-on-secondary px-6 py-2 rounded-lg flex items-center gap-2 font-semibold text-body-sm transition-all shadow-lg shadow-primary/20 hover:brightness-105 active:scale-95">
    Create New Job
</a>
@endsection

@section('content')
<!-- Page Header -->
<div>
    <h2 class="font-headline-lg text-headline-lg text-white mb-1">Device Security &amp; Session Log</h2>
    <p class="text-outline font-body-md">Monitor active sessions, device UUIDs, and geofencing compliance.</p>
</div>

<!-- Bento Grid Summary Stats -->
<section class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Stat Card 1 -->
    <div class="glass-card rounded-2xl p-6 flex flex-col justify-between h-36 relative overflow-hidden group" id="statCardDevices">
        <div>
            <div class="flex justify-between items-start mb-2">
                <span class="font-label-caps text-label-caps text-outline uppercase tracking-wider text-[11px]">Total Active Devices</span>
                <div class="p-2 bg-primary/10 rounded-lg">
                    <span class="material-symbols-outlined text-primary text-[20px]">devices</span>
                </div>
            </div>
            <h3 class="text-headline-xl font-headline-xl text-white font-bold leading-none mt-2">1,248</h3>
        </div>
        <div class="flex items-center gap-1 mt-4">
            <span class="text-secondary font-bold text-body-sm">+12%</span>
            <span class="text-outline text-body-sm text-[11px]">from last week</span>
        </div>
    </div>
    <!-- Stat Card 2 -->
    <div class="glass-card rounded-2xl p-6 flex flex-col justify-between h-36 relative overflow-hidden group border border-error/20" id="statCardAttempts">
        <div>
            <div class="flex justify-between items-start mb-2">
                <span class="font-label-caps text-label-caps text-error uppercase tracking-wider text-[11px]">Unauthorized Access</span>
                <div class="p-2 bg-error/10 rounded-lg">
                    <span class="material-symbols-outlined text-error text-[20px]">warning</span>
                </div>
            </div>
            <h3 class="text-headline-xl font-headline-xl text-error font-bold leading-none mt-2">14</h3>
        </div>
        <div class="flex items-center gap-1 mt-4">
            <span class="text-error font-bold text-body-sm">Critical</span>
            <span class="text-outline text-body-sm text-[11px]">Requires review</span>
        </div>
    </div>
    <!-- Stat Card 3 -->
    <div class="glass-card rounded-2xl p-6 flex flex-col justify-between h-36 relative overflow-hidden group" id="statCardRegistrations">
        <div>
            <div class="flex justify-between items-start mb-2">
                <span class="font-label-caps text-label-caps text-outline uppercase tracking-wider text-[11px]">New Registrations (24h)</span>
                <div class="p-2 bg-secondary-fixed-dim/10 rounded-lg">
                    <span class="material-symbols-outlined text-secondary-fixed-dim text-[20px]">app_registration</span>
                </div>
            </div>
            <h3 class="text-headline-xl font-headline-xl text-white font-bold leading-none mt-2">32</h3>
        </div>
        <div class="flex items-center gap-2 mt-4">
            <span class="text-outline text-body-sm text-[11px]">Verification pending for 8 devices</span>
        </div>
    </div>
</section>

<!-- Table Section -->
<section class="glass-card rounded-2xl overflow-hidden flex flex-col shadow-2xl">
    <!-- Table Header/Controls -->
    <div class="px-6 py-4 border-b border-white/10 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white/5">
        <div>
            <h4 class="font-headline-sm text-headline-sm text-white font-semibold">Session &amp; Device Audit Log</h4>
            <p class="text-body-sm text-outline">Real-time monitoring of all active technician login sessions</p>
        </div>
        <div class="flex items-center gap-2">
            <button class="flex items-center gap-1 px-4 py-2 bg-white/5 border border-white/10 text-white font-body-sm rounded-lg hover:bg-white/10 transition-colors" onclick="alert('Filtering applied')">
                <span class="material-symbols-outlined text-md">filter_list</span> Filter
            </button>
            <button class="flex items-center gap-1 px-4 py-2 bg-secondary text-on-secondary font-body-sm rounded-lg hover:opacity-90 transition-opacity" onclick="alert('Exporting session log...')">
                <span class="material-symbols-outlined text-md">file_download</span> Export CSV
            </button>
        </div>
    </div>
    <!-- Scrollable Table Wrapper -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[1000px]">
            <thead class="bg-white/5 border-b border-white/10">
                <tr>
                    <th class="px-6 py-4 font-label-caps text-[11px] text-outline uppercase tracking-wider">Timestamp</th>
                    <th class="px-6 py-4 font-label-caps text-[11px] text-outline uppercase tracking-wider">Technician</th>
                    <th class="px-6 py-4 font-label-caps text-[11px] text-outline uppercase tracking-wider">Device / Model</th>
                    <th class="px-6 py-4 font-label-caps text-[11px] text-outline uppercase tracking-wider">Unique ID (UUID)</th>
                    <th class="px-6 py-4 font-label-caps text-[11px] text-outline uppercase tracking-wider">Location</th>
                    <th class="px-6 py-4 font-label-caps text-[11px] text-outline uppercase tracking-wider text-center">Security Status</th>
                    <th class="px-6 py-4 font-label-caps text-[11px] text-outline uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                <!-- Row 1: Flagged/Suspicious -->
                <tr class="hover:bg-white/[0.02] transition-colors">
                    <td class="px-6 py-4 font-mono text-body-sm text-white">2026-07-08 14:32:01</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="h-8 w-8 rounded-full bg-white/5 text-primary flex items-center justify-center font-bold text-xs border border-white/5">MC</div>
                            <span class="font-body-md font-semibold text-white">Marcus Chen</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-md text-outline">smartphone</span>
                            <span class="font-body-md text-white">iPhone 15 Pro</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-mono text-body-sm text-outline">f83e-a12b-c90d</td>
                    <td class="px-6 py-4 font-body-sm text-on-surface-variant">Chicago, IL</td>
                    <td class="px-6 py-4 text-center">
                        <div class="inline-flex items-center gap-1 bg-error/10 text-error px-3 py-1 rounded-full border border-error/20">
                            <span class="material-symbols-outlined text-[16px]">warning</span>
                            <span class="font-label-caps text-[10px] uppercase font-bold">Flagged</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-1">
                            <button class="p-2 text-error hover:bg-error/10 rounded-lg transition-colors" title="Lock Account" onclick="alert('Account Locked')">
                                <span class="material-symbols-outlined">lock</span>
                            </button>
                            <button class="p-2 text-on-surface-variant hover:bg-white/5 rounded-lg transition-colors" title="View Details" onclick="alert('Session details...')">
                                <span class="material-symbols-outlined">visibility</span>
                            </button>
                        </div>
                    </td>
                </tr>
                <!-- Row 2: New Device -->
                <tr class="hover:bg-white/[0.02] transition-colors">
                    <td class="px-6 py-4 font-mono text-body-sm text-white">2026-07-08 14:28:45</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="h-8 w-8 rounded-full bg-white/5 text-primary flex items-center justify-center font-bold text-xs border border-white/5">ER</div>
                            <span class="font-body-md font-semibold text-white">Elena Rodriguez</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-md text-outline">laptop_mac</span>
                            <span class="font-body-md text-white">MacBook Pro 14"</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-mono text-body-sm text-outline">a921-f3b0-22e1</td>
                    <td class="px-6 py-4 font-body-sm text-on-surface-variant">Austin, TX</td>
                    <td class="px-6 py-4 text-center">
                        <div class="inline-flex items-center gap-1 bg-secondary/10 text-secondary px-3 py-1 rounded-full border border-secondary/20 border-secondary-fixed-dim">
                            <span class="material-symbols-outlined text-[16px]">new_releases</span>
                            <span class="font-label-caps text-[10px] uppercase font-bold">New Device</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2 items-center">
                            <button class="px-3 py-1 border border-secondary text-secondary font-label-caps text-[10px] rounded hover:bg-secondary/5 transition-colors uppercase font-bold" onclick="alert('Authorized Device')">Authorize</button>
                            <button class="p-2 text-on-surface-variant hover:bg-white/5 rounded-lg transition-colors" onclick="alert('Device logged out')">
                                <span class="material-symbols-outlined">logout</span>
                            </button>
                        </div>
                    </td>
                </tr>
                <!-- Row 3: Verified -->
                <tr class="hover:bg-white/[0.02] transition-colors">
                    <td class="px-6 py-4 font-mono text-body-sm text-white">2026-07-08 14:15:20</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="h-8 w-8 rounded-full bg-white/5 text-primary flex items-center justify-center font-bold text-xs border border-white/5">DW</div>
                            <span class="font-body-md font-semibold text-white">David Wilson</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-md text-outline">tablet_android</span>
                            <span class="font-body-md text-white">Samsung Galaxy Tab S9</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-mono text-body-sm text-outline">b222-7777-a1x2</td>
                    <td class="px-6 py-4 font-body-sm text-on-surface-variant">Denver, CO</td>
                    <td class="px-6 py-4 text-center">
                        <div class="inline-flex items-center gap-1 bg-green-500/10 text-green-400 px-3 py-1 rounded-full border border-green-500/20">
                            <span class="material-symbols-outlined text-[16px]">verified</span>
                            <span class="font-label-caps text-[10px] uppercase font-bold">Verified</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-1">
                            <button class="p-2 text-on-surface-variant hover:bg-white/5 rounded-lg transition-colors">
                                <span class="material-symbols-outlined">more_vert</span>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-white/10 flex items-center justify-between bg-white/[0.01]">
        <span class="text-body-sm text-outline">Showing 3 of 288 active sessions</span>
        <div class="flex items-center gap-1">
            <button class="p-1 border border-white/10 rounded hover:bg-white/5 transition-colors disabled:opacity-30" disabled>
                <span class="material-symbols-outlined">chevron_left</span>
            </button>
            <div class="flex gap-1">
                <button class="w-8 h-8 bg-secondary text-on-secondary font-body-sm rounded">1</button>
                <button class="w-8 h-8 hover:bg-white/5 font-body-sm rounded text-white">2</button>
                <button class="w-8 h-8 hover:bg-white/5 font-body-sm rounded text-white">3</button>
            </div>
            <button class="p-1 border border-white/10 rounded hover:bg-white/5 transition-colors">
                <span class="material-symbols-outlined">chevron_right</span>
            </button>
        </div>
    </div>
</section>

<!-- Bottom Detail Grid -->
<section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Login Geo-Map -->
    <div class="glass-card rounded-2xl p-6 flex flex-col h-[400px]">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h4 class="font-headline-sm text-headline-sm text-white font-semibold">Live Access Heatmap</h4>
                <p class="text-body-sm text-outline">Active sessions by geographical density</p>
            </div>
            <button class="p-2 hover:bg-white/5 rounded-full text-white">
                <span class="material-symbols-outlined">fullscreen</span>
            </button>
        </div>
        <div class="flex-1 rounded-lg bg-[#1A1B3A] overflow-hidden relative">
            <div class="absolute inset-0 bg-cover bg-center opacity-70" style="background-image: url('https://www.gstatic.com/labs-code/stitch/stitch-placeholder-300x300.svg')">
            </div>
            <!-- Hotspots -->
            <div class="absolute top-1/4 left-1/4 w-8 h-8 bg-secondary/30 rounded-full animate-ping"></div>
            <div class="absolute top-1/4 left-1/4 w-4 h-4 bg-secondary rounded-full shadow-lg border-2 border-white"></div>
            <!-- Map Overlay Controls -->
            <div class="absolute top-4 right-4 flex flex-col gap-2">
                <button class="w-8 h-8 bg-white/5 border border-white/10 rounded shadow flex items-center justify-center hover:bg-white/10 text-white">
                    <span class="material-symbols-outlined text-sm">add</span>
                </button>
                <button class="w-8 h-8 bg-white/5 border border-white/10 rounded shadow flex items-center justify-center hover:bg-white/10 text-white">
                    <span class="material-symbols-outlined text-sm">remove</span>
                </button>
            </div>
        </div>
    </div>
    <!-- Security Recommendations -->
    <div class="glass-card rounded-2xl p-6 flex flex-col h-[400px]">
        <h4 class="font-headline-sm text-headline-sm text-white mb-4 font-semibold">Security Health Check</h4>
        <div class="flex-1 space-y-4 overflow-y-auto pr-1">
            <div class="p-4 bg-white/5 border border-white/5 rounded-lg flex items-start gap-4">
                <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-primary">key</span>
                </div>
                <div>
                    <h5 class="font-body-md font-bold text-white">Force MFA Reset</h5>
                    <p class="text-body-sm text-outline mb-2">8% of technician accounts haven't refreshed their Multi-Factor credentials in 90+ days.</p>
                    <button class="text-secondary font-label-caps text-[11px] uppercase hover:underline font-semibold">Execute Policy Update</button>
                </div>
            </div>
            <div class="p-4 bg-white/5 border border-white/5 rounded-lg flex items-start gap-4">
                <div class="w-10 h-10 bg-error/10 rounded-full flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-error">cloud_off</span>
                </div>
                <div>
                    <h5 class="font-body-md font-bold text-white">Unauthorized IP Range</h5>
                    <p class="text-body-sm text-outline mb-2">Detected 3 login attempts from a known proxy network. Recommend IP Blacklisting.</p>
                    <button class="text-error font-label-caps text-[11px] uppercase hover:underline font-semibold">Manage Blocklist</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    // Search filter for table linked to layout search input
    document.getElementById('globalSearchInput').addEventListener('input', (e) => {
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
            card.style.transform = 'translateY(-2px)';
            card.style.transition = 'all 0.2s ease-in-out';
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0)';
        });
    });
</script>
@endsection
