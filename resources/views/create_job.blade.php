@extends('layouts.app')

@slot('title')
    Job Creation | DispatchCore AI
@endslot

@section('styles')
<style>
    #globalSearchInput { display: none !important; }
</style>
@endsection

@section('content')
<form id="jobDispatchForm" onsubmit="handleJobDispatch(event)">
    <div class="max-w-6xl mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-md mb-8">
            <div>
                <h1 class="text-headline-lg font-headline-lg text-white font-bold text-3xl">New Service Dispatch</h1>
                <p class="text-body-md text-on-surface-variant mt-xs">Schedule and assign a new AC maintenance task for immediate deployment.</p>
            </div>
            <div class="flex gap-md mt-4">
                <a href="/dashboard" class="px-4 py-2.5 border border-white/10 text-white font-semibold rounded-lg hover:bg-white/5 transition-colors flex items-center">Cancel</a>
                <button type="submit" class="px-6 py-2.5 bg-secondary text-on-secondary font-semibold rounded-lg shadow-lg shadow-secondary/20 hover:brightness-105 active:scale-95 transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">save</span>
                    Save &amp; Dispatch
                </button>
            </div>
        </div>

        <!-- Bento-Style Form Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Left Column: Primary Info -->
            <div class="lg:col-span-8 flex flex-col gap-8">
                <!-- Section 1: Client Info & Map -->
                <div class="glass-card rounded-2xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-white/10 bg-white/5 flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary">person_pin_circle</span>
                        <h2 class="text-headline-sm font-headline-sm font-semibold text-white">Client Information</h2>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col gap-4">
                            <div>
                                <label class="block text-label-caps font-label-caps text-on-surface-variant mb-1">CLIENT NAME</label>
                                <input class="w-full bg-[#1A1B3A] border border-white/10 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-secondary focus:border-transparent outline-none text-sm" id="clientName" placeholder="e.g. Anderson Residence" required type="text" />
                            </div>
                            <div>
                                <label class="block text-label-caps font-label-caps text-on-surface-variant mb-1">PHONE NUMBER</label>
                                <input class="w-full bg-[#1A1B3A] border border-white/10 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-secondary focus:border-transparent outline-none text-sm" id="clientPhone" placeholder="+1 (555) 000-0000" required type="tel" />
                            </div>
                            <div>
                                <label class="block text-label-caps font-label-caps text-on-surface-variant mb-1">SERVICE ADDRESS</label>
                                <div class="relative">
                                    <input class="w-full bg-[#1A1B3A] border border-white/10 rounded-lg pl-4 pr-10 py-2.5 text-white focus:ring-2 focus:ring-secondary focus:border-transparent outline-none text-sm" id="serviceAddress" placeholder="Street, City, Zip Code" required type="text" />
                                    <span class="material-symbols-outlined absolute right-3 top-2.5 text-outline">location_on</span>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-label-caps text-on-surface-variant mb-1 text-[10px]">LATITUDE</label>
                                    <input class="w-full bg-[#1A1B3A] border border-white/10 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-secondary focus:border-transparent outline-none text-xs" id="latitude" placeholder="e.g. 41.8781" required type="number" step="any" />
                                </div>
                                <div>
                                    <label class="block text-label-caps text-on-surface-variant mb-1 text-[10px]">LONGITUDE</label>
                                    <input class="w-full bg-[#1A1B3A] border border-white/10 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-secondary focus:border-transparent outline-none text-xs" id="longitude" placeholder="e.g. -87.6298" required type="number" step="any" />
                                </div>
                            </div>
                        </div>
                        <!-- Geolocation Picker Placeholder -->
                        <div class="relative h-full min-h-[220px] rounded-xl border border-white/10 overflow-hidden">
                            <iframe class="w-full h-full border-none opacity-80" 
                                src="https://maps.google.com/maps?q=Chicago&t=&z=11&ie=UTF8&iwloc=&output=embed"></iframe>
                            <div class="absolute top-3 left-3 bg-[#101415]/90 backdrop-blur-sm p-2 rounded-lg border border-white/10 shadow-lg">
                                <span class="text-label-caps font-label-caps text-primary block text-[10px]">DISPATCH REGION</span>
                                <span class="text-label-caps font-label-caps text-secondary text-xs">Chicago Area Command</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: AC Issue Details -->
                <div class="glass-card rounded-2xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-white/10 bg-white/5 flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary">ac_unit</span>
                        <h2 class="text-headline-sm font-headline-sm font-semibold text-white">Service Requirements</h2>
                    </div>
                    <div class="p-6 flex flex-col gap-6">
                        <div>
                            <label class="block text-label-caps font-label-caps text-on-surface-variant mb-1">ISSUE DESCRIPTION</label>
                            <textarea class="w-full bg-[#1A1B3A] border border-white/10 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-secondary focus:border-transparent outline-none resize-none text-sm" id="issueDescription" placeholder="Provide details of the AC unit malfunction or service requirements..." required rows="4"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Scheduling & Assignment -->
            <div class="lg:col-span-4 flex flex-col gap-8">
                <!-- Section 3: Scheduling -->
                <div class="glass-card rounded-2xl overflow-hidden shadow-2xl">
                    <div class="px-6 py-4 border-b border-white/10 bg-white/5 flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary">calendar_today</span>
                        <h2 class="text-headline-sm font-headline-sm font-semibold text-white">Schedule</h2>
                    </div>
                    <div class="p-6 flex flex-col gap-4">
                        <div>
                            <label class="block text-label-caps font-label-caps text-on-surface-variant mb-1">SCHEDULED DATE &amp; TIME</label>
                            <input class="w-full bg-[#1A1B3A] border border-white/10 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-secondary focus:border-transparent outline-none text-sm" id="scheduledAt" required type="datetime-local" />
                        </div>
                    </div>
                </div>

                <!-- Section 4: Assignment -->
                <div class="glass-card rounded-2xl overflow-hidden shadow-2xl font-body-md">
                    <div class="px-6 py-4 border-b border-white/10 bg-white/5 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-secondary">engineering</span>
                            <h2 class="text-headline-sm font-headline-sm font-semibold text-white">Assign Technician</h2>
                        </div>
                    </div>
                    <div class="p-4 flex flex-col gap-2 max-h-[320px] overflow-y-auto custom-scrollbar" id="techSelectList">
                        <p class="text-sm text-outline p-4 text-center">Loading technicians...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
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
            list.innerHTML = `<p class="text-sm text-outline p-4 text-center">No technicians available.</p>`;
            return;
        }

        list.innerHTML = techs.map(tech => {
            const statusLabel = tech.currentStatus === 'on_duty' 
                ? `<span class="px-2 py-1 bg-emerald-500/10 text-emerald-400 text-[9px] font-bold rounded border border-emerald-500/20">DUTY</span>`
                : `<span class="px-2 py-1 bg-white/5 text-on-surface-variant text-[9px] font-bold rounded border border-white/10">OFFLINE</span>`;

            return `
                <label class="flex items-center justify-between p-3 border border-white/5 rounded-lg hover:bg-white/[0.02] transition-all cursor-pointer group">
                    <div class="flex items-center gap-3">
                        <input type="radio" name="assignedTo" value="${tech.id}" class="focus:ring-secondary text-secondary bg-[#1A1B3A] border-white/10" />
                        <div>
                            <div class="text-body-md font-semibold text-white">${escapeHtml(tech.name)}</div>
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

    // Set default date to today
    document.getElementById('scheduledAt').value = new Date().toISOString().slice(0, 16);

    // Initial load
    loadTechnicians();
</script>
@endsection