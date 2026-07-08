@extends('layouts.app')

@slot('title')
    Job Creation | DispatchCore AI
@endslot

@section('styles')
<!-- Leaflet Map CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    #globalSearchInput { display: none !important; }
    /* Leaflet overrides to fit dark theme */
    .leaflet-bar {
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        background-color: rgba(26, 27, 58, 0.8) !important;
    }
    .leaflet-bar a {
        background-color: transparent !important;
        color: #e0e3e5 !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
    }
    .leaflet-bar a:hover {
        background-color: rgba(255, 255, 255, 0.1) !important;
        color: #00dbe7 !important;
    }
    .leaflet-container {
        font-family: inherit;
    }
</style>
@endsection

@section('content')
<!-- Map Selection Modal at root level to prevent clipping -->
<div id="mapModal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-md flex items-center justify-center z-[9999] p-4">
    <div class="glass-modal w-full max-w-4xl rounded-2xl overflow-hidden flex flex-col shadow-2xl border border-white/10 h-[80vh]">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-white/10 flex items-center justify-between bg-white/5">
            <div>
                <h3 class="text-headline-sm font-headline-sm text-white font-bold text-lg">Pick Service Location</h3>
                <p class="text-xs text-outline">Search or drag the pin to mark the exact service coordinates.</p>
            </div>
            <button type="button" onclick="closeMapModal()" class="text-outline hover:text-white transition-colors flex items-center justify-center p-2 rounded-full hover:bg-white/5">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>
        <!-- Modal Body (Map Container) -->
        <div class="flex-grow relative bg-[#1A1B3A]">
            <div id="modalMap" class="w-full h-full"></div>
            <!-- Floating Address Search Input -->
            <div class="absolute top-4 left-12 right-12 z-[1000] flex gap-2 max-w-md">
                <input id="modalSearchAddress" type="text" placeholder="Search address in Sri Lanka..." class="w-full bg-[#101415]/95 border border-white/15 rounded-lg px-4 py-2.5 text-white text-sm focus:ring-2 focus:ring-secondary focus:border-transparent outline-none shadow-xl" onkeydown="if(event.key === 'Enter') { event.preventDefault(); searchModalAddress(); }" />
                <button type="button" onclick="searchModalAddress()" class="bg-secondary text-on-secondary px-4 rounded-lg font-semibold text-sm hover:brightness-105 active:scale-95 transition-all flex items-center justify-center shadow-lg shrink-0">
                    <span class="material-symbols-outlined text-sm">search</span>
                </button>
            </div>
        </div>
        <!-- Modal Footer -->
        <div class="px-6 py-4 border-t border-white/10 bg-[#14152D]/95 flex items-center justify-between">
            <div class="text-left max-w-md">
                <p id="modalCoordsText" class="text-xs font-mono text-secondary font-bold">Coords: 6.927100, 79.861200</p>
                <p id="modalAddressText" class="text-[11px] text-outline truncate mt-0.5">Colombo, Sri Lanka</p>
            </div>
            <button type="button" onclick="confirmMapSelection()" class="bg-secondary text-on-secondary px-6 py-2.5 rounded-lg font-bold text-sm shadow-lg shadow-secondary/20 hover:brightness-105 active:scale-95 transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">check_circle</span> Confirm Location
            </button>
        </div>
    </div>
</div>

<form id="jobDispatchForm" onsubmit="handleJobDispatch(event)">
    <div class="max-w-6xl mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
            <div>
                <h1 class="text-headline-lg font-headline-lg text-white font-bold text-3xl">New Service Dispatch</h1>
                <p class="text-body-md text-on-surface-variant mt-xs">Schedule and assign a new AC maintenance task for immediate deployment.</p>
            </div>
            <div class="flex gap-4 mt-4">
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
                                    <input class="w-full bg-[#1A1B3A] border border-white/10 rounded-lg pl-4 pr-10 py-2.5 text-white focus:ring-2 focus:ring-secondary focus:border-transparent outline-none text-sm" id="serviceAddress" placeholder="Colombo, Sri Lanka" required type="text" />
                                    <button type="button" onclick="openMapModal()" class="absolute right-2 top-2 text-secondary hover:text-white transition-colors flex items-center justify-center p-1 hover:bg-white/5 rounded">
                                        <span class="material-symbols-outlined">my_location</span>
                                    </button>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-label-caps text-on-surface-variant mb-1 text-[10px]">LATITUDE</label>
                                    <input class="w-full bg-[#1A1B3A] border border-white/10 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-secondary focus:border-transparent outline-none text-xs" id="latitude" placeholder="e.g. 6.9271" required type="number" step="any" readonly />
                                </div>
                                <div>
                                    <label class="block text-label-caps text-on-surface-variant mb-1 text-[10px]">LONGITUDE</label>
                                    <input class="w-full bg-[#1A1B3A] border border-white/10 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-secondary focus:border-transparent outline-none text-xs" id="longitude" placeholder="e.g. 79.8612" required type="number" step="any" readonly />
                                </div>
                            </div>
                        </div>
                        <!-- Geolocation Map Preview Thumbnail Card -->
                        <div onclick="openMapModal()" class="relative h-full min-h-[260px] rounded-xl border border-white/10 overflow-hidden cursor-pointer group hover:border-secondary/40 transition-colors">
                            <div id="previewMap" class="w-full h-full min-h-[260px] opacity-75 group-hover:opacity-90 transition-opacity"></div>
                            <div class="absolute inset-0 bg-black/40 group-hover:bg-black/20 transition-colors flex items-center justify-center">
                                <span class="bg-[#101415]/95 backdrop-blur-sm px-4 py-2 rounded-lg border border-white/10 shadow-lg text-secondary text-xs font-bold font-label-caps flex items-center gap-2 transform group-hover:scale-105 transition-all z-[999] pointer-events-none">
                                    <span class="material-symbols-outlined text-[16px]">map</span>
                                    Pick on Map
                                </span>
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
<!-- Leaflet Map JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    // Selected coordinates (Default: Colombo, Sri Lanka)
    let selectedLat = 6.9271;
    let selectedLng = 79.8612;
    let selectedAddress = 'Colombo, Sri Lanka';

    // Initialize Preview (Thumbnail) Map - Interactivity disabled
    let previewMap = L.map('previewMap', {
        zoomControl: false,
        dragging: false,
        scrollWheelZoom: false,
        doubleClickZoom: false,
        boxZoom: false,
        touchZoom: false
    }).setView([selectedLat, selectedLng], 13);
    
    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        maxZoom: 20
    }).addTo(previewMap);

    let previewMarker = L.marker([selectedLat, selectedLng]).addTo(previewMap);

    // Initialize Modal (Large) Map
    let modalMap;
    let modalMarker;

    function initModalMap() {
        if (modalMap) return;

        modalMap = L.map('modalMap').setView([selectedLat, selectedLng], 14);
        
        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            maxZoom: 20
        }).addTo(modalMap);

        modalMarker = L.marker([selectedLat, selectedLng], { draggable: true }).addTo(modalMap);

        // Update modal metrics when dragging
        modalMarker.on('dragend', function (e) {
            let position = modalMarker.getLatLng();
            updateModalStatus(position.lat, position.lng);
        });

        // Click to place marker on modal map
        modalMap.on('click', function (e) {
            modalMarker.setLatLng(e.latlng);
            updateModalStatus(e.latlng.lat, e.latlng.lng);
        });
    }

    function updateModalStatus(lat, lng) {
        document.getElementById('modalCoordsText').innerText = `Coords: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
        reverseGeocodeModal(lat, lng);
    }

    async function reverseGeocodeModal(lat, lng) {
        try {
            const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
            const data = await res.json();
            if (data && data.display_name) {
                document.getElementById('modalAddressText').innerText = data.display_name;
            }
        } catch (err) {
            console.error(err);
        }
    }

    function openMapModal() {
        const modal = document.getElementById('mapModal');
        modal.classList.remove('hidden');
        
        // Init map delayed to guarantee viewport rendering size is set
        setTimeout(() => {
            initModalMap();
            modalMap.invalidateSize();
            modalMap.setView([selectedLat, selectedLng], 14);
            modalMarker.setLatLng([selectedLat, selectedLng]);
            document.getElementById('modalCoordsText').innerText = `Coords: ${selectedLat.toFixed(6)}, ${selectedLng.toFixed(6)}`;
            document.getElementById('modalAddressText').innerText = selectedAddress;
        }, 100);
    }

    function closeMapModal() {
        document.getElementById('mapModal').classList.add('hidden');
    }

    function confirmMapSelection() {
        const position = modalMarker.getLatLng();
        selectedLat = position.lat;
        selectedLng = position.lng;
        selectedAddress = document.getElementById('modalAddressText').innerText;

        // Update Form Inputs
        document.getElementById('latitude').value = selectedLat.toFixed(6);
        document.getElementById('longitude').value = selectedLng.toFixed(6);
        document.getElementById('serviceAddress').value = selectedAddress;

        // Update Small Preview Map
        previewMap.setView([selectedLat, selectedLng], 13);
        previewMarker.setLatLng([selectedLat, selectedLng]);

        closeMapModal();
    }

    // Modal Geocoding search address field
    async function searchModalAddress() {
        const query = document.getElementById('modalSearchAddress').value;
        if (!query || query.length < 3) return;

        try {
            const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query + ', Sri Lanka')}`);
            const data = await res.json();
            if (data && data.length > 0) {
                const first = data[0];
                const lat = parseFloat(first.lat);
                const lng = parseFloat(first.lon);
                
                modalMarker.setLatLng([lat, lng]);
                modalMap.panTo([lat, lng]);
                updateModalStatus(lat, lng);
            } else {
                alert('Location not found in Sri Lanka. Try refinement.');
            }
        } catch (err) {
            console.error('Geocoding error:', err);
        }
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