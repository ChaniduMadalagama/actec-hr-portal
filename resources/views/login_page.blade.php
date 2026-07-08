<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>LogiFlow Dispatch | Secure Access</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&display=swap" rel="stylesheet"/>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 20;
        }
        .glass-card {
            background: rgba(26, 27, 58, 0.65);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .input-glow:focus-within {
            box-shadow: 0 0 0 2px rgba(0, 241, 254, 0.2);
        }
        .btn-gradient {
            background: linear-gradient(135deg, #124af0 0%, #2e5bff 100%);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-gradient:hover {
            filter: brightness(1.1);
            box-shadow: 0 0 20px rgba(46, 91, 255, 0.4);
            transform: translateY(-1px);
        }
        .atmospheric-glow {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100vw;
            height: 100vh;
            background: radial-gradient(circle at 50% 50%, rgba(46, 91, 255, 0.15) 0%, rgba(16, 20, 21, 0) 70%);
            pointer-events: none;
            z-index: -1;
        }
        .logo-icon-glow {
            background: linear-gradient(135deg, #2e5bff 0%, #00f1fe 100%);
            box-shadow: 0 0 30px rgba(46, 91, 255, 0.3);
        }
    </style>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-error": "#690005",
                        "on-primary": "#002388",
                        "on-primary-container": "#efefff",
                        "inverse-on-surface": "#2d3133",
                        "primary-container": "#2e5bff",
                        "on-error-container": "#ffdad6",
                        "on-primary-fixed-variant": "#0035be",
                        "on-tertiary-fixed": "#171837",
                        "on-secondary": "#00363a",
                        "secondary-fixed-dim": "#00dbe7",
                        "surface-tint": "#b8c3ff",
                        "inverse-surface": "#e0e3e5",
                        "on-secondary-container": "#006a70",
                        "surface-bright": "#363a3b",
                        "primary-fixed-dim": "#b8c3ff",
                        "surface-container-lowest": "#0b0f10",
                        "primary": "#b8c3ff",
                        "inverse-primary": "#124af0",
                        "on-primary-fixed": "#001356",
                        "surface-container-high": "#272a2c",
                        "background": "#101415",
                        "on-tertiary-container": "#f1eeff",
                        "primary-fixed": "#dde1ff",
                        "on-surface-variant": "#c4c5d9",
                        "surface-dim": "#101415",
                        "tertiary": "#c3c3eb",
                        "surface-container": "#1d2022",
                        "tertiary-fixed": "#e1e0ff",
                        "secondary-fixed": "#74f5ff",
                        "secondary": "#ddfcff",
                        "on-tertiary-fixed-variant": "#434465",
                        "error": "#ffb4ab",
                        "on-surface": "#e0e3e5",
                        "surface": "#101415",
                        "error-container": "#93000a",
                        "on-background": "#e0e3e5",
                        "surface-container-highest": "#323537",
                        "surface-container-low": "#191c1e",
                        "outline": "#8e90a2",
                        "outline-variant": "#434656",
                        "on-secondary-fixed": "#002022",
                        "tertiary-fixed-dim": "#c3c3eb",
                        "secondary-container": "#00f1fe",
                        "surface-variant": "#323537",
                        "on-secondary-fixed-variant": "#004f54",
                        "on-tertiary": "#2c2d4d",
                        "tertiary-container": "#696a8e"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "fontFamily": {
                        "label-caps": ["JetBrains Mono"],
                        "headline-lg-mobile": ["Hanken Grotesk"],
                        "body-md": ["Inter"],
                        "body-lg": ["Inter"],
                        "headline-lg": ["Hanken Grotesk"],
                        "body-sm": ["Inter"],
                        "headline-md": ["Hanken Grotesk"],
                        "headline-xl": ["Hanken Grotesk"]
                    },
                    "fontSize": {
                        "label-caps": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "500"}],
                        "headline-lg-mobile": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                        "headline-lg": ["32px", {"lineHeight": "40px", "fontWeight": "600"}],
                        "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "headline-xl": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}]
                    }
                },
            },
        }
    </script>
</head>
<body class="bg-background text-on-background min-h-screen flex flex-col font-body-md overflow-hidden">
<!-- Atmospheric Layer -->
<div class="atmospheric-glow"></div>
<!-- Top Nav Shell -->
<header class="flex justify-center items-center py-8 w-full z-10">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg logo-icon-glow flex items-center justify-center text-white">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">terminal</span>
        </div>
        <h1 class="font-headline-md text-headline-md font-bold text-on-surface tracking-tight">LogiFlow Dispatch</h1>
    </div>
</header>
<!-- Main Content Canvas -->
<main class="flex-grow flex items-center justify-center px-4 relative">
    <!-- Background Decoration (Abstract Cooling Flow) -->
    <div class="absolute inset-0 opacity-20 pointer-events-none overflow-hidden">
        <svg class="w-full h-full scale-150" viewBox="0 0 1000 1000" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 500 Q250 200 500 500 T1000 500" fill="none" stroke="url(#gradient-line)" stroke-width="2"></path>
            <defs>
                <linearGradient id="gradient-line" x1="0%" x2="100%" y1="0%" y2="0%">
                    <stop offset="0%" stop-color="#2e5bff"></stop>
                    <stop offset="100%" stop-color="#00f1fe"></stop>
                </linearGradient>
            </defs>
        </svg>
    </div>
    <!-- Login Card -->
    <div class="glass-card w-full max-w-md p-8 lg:p-10 rounded-xl relative z-10">
        <div class="text-center mb-6">
            <p class="font-body-md text-on-surface-variant opacity-80">Sign in to control center console</p>
        </div>

        <!-- Error Message Alert -->
        <div id="errorAlert" class="hidden mb-6 bg-red-950/40 border border-red-500/30 text-red-200 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-red-400">error</span>
            <span id="errorMessage">Invalid credentials. Please try again.</span>
        </div>

        <form id="loginForm" class="space-y-6">
            <!-- Username Field -->
            <div class="space-y-2">
                <label class="font-label-caps text-label-caps text-on-surface-variant block ml-1">USERNAME</label>
                <div class="input-glow flex items-center bg-[#1A1B3A] border border-outline-variant/30 rounded-lg overflow-hidden group transition-all duration-300">
                    <div class="pl-4 text-on-surface-variant group-focus-within:text-secondary-fixed">
                        <span class="material-symbols-outlined text-[20px]">person</span>
                    </div>
                    <input class="w-full bg-transparent border-none focus:ring-0 text-on-surface py-3 px-3 placeholder:text-outline-variant/50 font-body-sm outline-none" placeholder="e.g. admin" type="text" id="username" name="username" required />
                </div>
            </div>
            <!-- Password Field -->
            <div class="space-y-2">
                <div class="flex justify-between items-center px-1">
                    <label class="font-label-caps text-label-caps text-on-surface-variant">PASSWORD</label>
                    <a class="text-[11px] font-label-caps text-secondary-fixed-dim hover:text-secondary-fixed transition-colors" href="#">FORGOT?</a>
                </div>
                <div class="input-glow flex items-center bg-[#1A1B3A] border border-outline-variant/30 rounded-lg overflow-hidden group transition-all duration-300">
                    <div class="pl-4 text-on-surface-variant group-focus-within:text-secondary-fixed">
                        <span class="material-symbols-outlined text-[20px]">lock</span>
                    </div>
                    <input class="w-full bg-transparent border-none focus:ring-0 text-on-surface py-3 px-3 placeholder:text-outline-variant/50 font-body-sm tracking-widest outline-none" placeholder="••••••••••••" type="password" id="password" name="password" required />
                    <button class="pr-4 text-on-surface-variant hover:text-on-surface transition-colors" type="button" onclick="togglePasswordVisibility()">
                        <span id="visibilityIcon" class="material-symbols-outlined text-[18px]">visibility</span>
                    </button>
                </div>
            </div>
            <!-- Remember Me & Security Policy -->
            <div class="flex items-center gap-2 px-1">
                <input class="w-4 h-4 rounded border-outline-variant/30 bg-surface-container-low text-primary focus:ring-primary/20 cursor-pointer" id="remember" type="checkbox"/>
                <label class="font-body-sm text-body-sm text-on-surface-variant cursor-pointer select-none" for="remember">Remember this terminal session</label>
            </div>
            <!-- Action Button -->
            <button id="submitBtn" class="btn-gradient w-full py-4 rounded-lg font-headline-md text-on-primary-container font-semibold tracking-wide flex items-center justify-center gap-2 group" type="submit">
                Sign In
                <span class="material-symbols-outlined text-[20px] group-hover:translate-x-1 transition-transform">login</span>
            </button>
        </form>
        <!-- Secondary Info -->
        <div class="mt-8 pt-8 border-t border-outline-variant/10 flex items-center justify-between">
            <div class="flex flex-col">
                <span class="font-label-caps text-[10px] text-on-surface-variant">NODE STATUS</span>
                <div class="flex items-center gap-1.5 mt-0.5">
                    <span class="w-2 h-2 rounded-full bg-[#00f1fe] animate-pulse"></span>
                    <span class="font-label-caps text-[11px] text-[#00f1fe]">OPTIMIZED</span>
                </div>
            </div>
            <div class="text-right">
                <span class="font-label-caps text-[10px] text-on-surface-variant">REGION</span>
                <span class="block font-label-caps text-[11px] text-on-surface mt-0.5">CENTRAL-US-04</span>
            </div>
        </div>
    </div>
</main>
<!-- Footer Shell -->
<footer class="flex flex-col items-center justify-center pb-8 gap-3 w-full z-10">
    <p class="font-body-sm text-body-sm text-on-surface-variant opacity-60">
        AC Repair Service Management System v1.0.0
    </p>
    <div class="flex gap-6">
        <a class="font-label-caps text-label-caps text-on-surface-variant hover:text-primary transition-colors" href="#">Privacy Policy</a>
        <a class="font-label-caps text-label-caps text-on-surface-variant hover:text-primary transition-colors" href="#">Terms of Service</a>
        <a class="font-label-caps text-label-caps text-on-surface-variant hover:text-primary transition-colors" href="#">Support</a>
    </div>
</footer>
<!-- Micro-interaction & Auth Scripts -->
<script>
    // Redirect if already authenticated
    if (localStorage.getItem('api_token')) {
        window.location.href = '/dashboard';
    }

    // Toggle Password Visibility
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const visibilityIcon = document.getElementById('visibilityIcon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            visibilityIcon.textContent = 'visibility_off';
        } else {
            passwordInput.type = 'password';
            visibilityIcon.textContent = 'visibility';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const inputs = document.querySelectorAll('input[type="text"], input[type="password"]');
        
        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                const parent = input.closest('.input-glow');
                if (parent) {
                    parent.style.borderColor = 'rgba(0, 241, 254, 0.4)';
                }
            });
            
            input.addEventListener('blur', () => {
                const parent = input.closest('.input-glow');
                if (parent) {
                    parent.style.borderColor = 'rgba(255, 255, 255, 0.08)';
                }
            });
        });

        // Subtle mouse parallax for the card
        const card = document.querySelector('.glass-card');
        document.addEventListener('mousemove', (e) => {
            const xAxis = (window.innerWidth / 2 - e.pageX) / 100;
            const yAxis = (window.innerHeight / 2 - e.pageY) / 100;
            card.style.transform = `rotateY(${xAxis}deg) rotateX(${yAxis}deg)`;
        });
    });

    // Form Submit Handler
    document.getElementById('loginForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const submitBtn = document.getElementById('submitBtn');
        const errorAlert = document.getElementById('errorAlert');
        const errorMessage = document.getElementById('errorMessage');
        
        // UI loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="material-symbols-outlined animate-spin text-[20px]">sync</span> Signing in...';
        errorAlert.classList.add('hidden');

        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        try {
            const response = await fetch('/api/v1/auth/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ username, password })
            });

            const data = await response.json();

            if (response.ok) {
                // Save token & user profile
                localStorage.setItem('api_token', data.token);
                localStorage.setItem('user_profile', JSON.stringify(data.user));
                
                window.location.href = '/dashboard';
            } else {
                errorMessage.innerText = data.message || 'Login failed. Please verify your credentials.';
                errorAlert.classList.remove('hidden');
            }
        } catch (err) {
            console.error(err);
            errorMessage.innerText = 'Unable to connect to the server. Please check your connection.';
            errorAlert.classList.remove('hidden');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Sign In <span class="material-symbols-outlined text-[20px] group-hover:translate-x-1 transition-transform">login</span>';
        }
    });
</script>
</body>
</html>
