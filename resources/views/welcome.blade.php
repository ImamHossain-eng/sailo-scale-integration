<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ 
    darkMode: localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
    mobileMenuOpen: false
}" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- SEO Meta Tags -->
    <title>Hamza Trading International | Maritime Port Weighbridge & Logistics Integration</title>
    <meta name="description" content="Welcome to Hamza Trading International, a premiere global maritime logistics, cargo stevedoring, and automated weighbridge scale integration supplier. Powered by Sailo Scale.">
    <meta name="keywords" content="hamza trading, weighbridge integration, port scales, maritime logistics, vessel weight scale, bangladesh shipping">
    <meta name="author" content="Hamza Trading International">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles and Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-800 dark:text-slate-100 bg-[#f8fafc] dark:bg-[#0b0f19] transition-colors duration-300 bg-grid-pattern">

    <!-- Glowing Decorative Background Blobs -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-500/10 dark:bg-blue-600/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/3 right-10 w-80 h-80 bg-emerald-500/10 dark:bg-emerald-600/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-2/3 left-10 w-96 h-96 bg-indigo-500/10 dark:bg-indigo-600/5 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Navigation Header -->
    <header class="sticky top-0 z-50 backdrop-blur-md bg-white/75 dark:bg-[#0b0f19]/75 border-b border-slate-200/80 dark:border-slate-800/80 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            
            <!-- Logo Section -->
            <a href="/" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center shadow-lg shadow-blue-500/20 text-white font-bold text-xl group-hover:scale-105 transition-transform">
                    <!-- SVG Anchor / Scale Icon -->
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17m0 0H9m3 0h3M12 9a3 3 0 110-6 3 3 0 010 6zm0 11a4 4 0 100-8 4 4 0 000 8zm-8-4h3m10 0h3"></path>
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="font-outfit font-extrabold text-lg sm:text-xl tracking-tight bg-gradient-to-r from-slate-900 to-slate-700 dark:from-white dark:to-slate-300 bg-clip-text text-transparent">
                        HAMZA TRADING
                    </span>
                    <span class="text-[10px] uppercase tracking-[0.2em] font-semibold text-blue-600 dark:text-blue-400 -mt-1">
                        International
                    </span>
                </div>
            </a>

            <!-- Desktop Nav Links -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600 dark:text-slate-300">
                <a href="#services" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Services</a>
                <a href="#telemetry" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Live Feeds</a>
                <a href="#simulator" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Cargo Calculator</a>
                <a href="#about" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">About Us</a>
                <a href="#contact" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Contact</a>
            </nav>

            <!-- Actions Right Side -->
            <div class="hidden md:flex items-center gap-4">
                <!-- Theme toggle button -->
                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" 
                        id="theme-toggle-btn"
                        class="p-2.5 rounded-lg border border-slate-200 dark:border-slate-800 text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/50 transition-colors cursor-pointer"
                        aria-label="Toggle dark mode">
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.706-.706a3.5 3.5 0 10-5.66 0l-.706.706z"></path>
                    </svg>
                    <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                </button>

                @auth
                    <a href="{{ url('/dashboard') }}" 
                       id="nav-dashboard-link"
                       class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-sm font-semibold bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white shadow-lg shadow-blue-500/20 hover:shadow-xl hover:shadow-blue-500/30 transition-all duration-300">
                        Dashboard
                    </a>
                @endauth
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="flex items-center gap-3 md:hidden">
                <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" 
                        class="p-2 rounded-lg border border-slate-200 dark:border-slate-800 text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/50 transition-colors cursor-pointer"
                        aria-label="Toggle dark mode">
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.706-.706a3.5 3.5 0 10-5.66 0l-.706.706z"></path>
                    </svg>
                    <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                </button>
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="p-2.5 rounded-lg border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer"
                        aria-label="Toggle mobile menu">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="md:hidden border-b border-slate-200 dark:border-slate-800 bg-white dark:bg-[#0b0f19] px-4 pt-2 pb-6 flex flex-col gap-4 text-slate-700 dark:text-slate-300 font-medium"
             style="display: none;">
            <a href="#services" @click="mobileMenuOpen = false" class="py-2 border-b border-slate-100 dark:border-slate-800/40">Services</a>
            <a href="#telemetry" @click="mobileMenuOpen = false" class="py-2 border-b border-slate-100 dark:border-slate-800/40">Live Feeds</a>
            <a href="#simulator" @click="mobileMenuOpen = false" class="py-2 border-b border-slate-100 dark:border-slate-800/40">Cargo Calculator</a>
            <a href="#about" @click="mobileMenuOpen = false" class="py-2 border-b border-slate-100 dark:border-slate-800/40">About Us</a>
            <a href="#contact" @click="mobileMenuOpen = false" class="py-2">Contact</a>
            
            <div class="flex items-center gap-4 mt-2">
                @auth
                    <a href="{{ url('/dashboard') }}" class="flex-1 text-center py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm">
                        Dashboard
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section class="relative pt-12 pb-20 lg:pt-24 lg:pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                
                <!-- Left Hero Content -->
                <div class="lg:col-span-7 flex flex-col text-left">
                    <!-- Status Tag -->
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-blue-500/20 bg-blue-500/10 text-blue-600 dark:text-blue-400 text-xs font-semibold self-start mb-6 animate-pulse">
                        <span class="w-2 h-2 rounded-full bg-blue-500 dark:bg-blue-400"></span>
                        SAILO SCALE MONITORING ACTIVE
                    </div>

                    <h1 class="font-outfit font-extrabold text-4xl sm:text-5xl lg:text-6xl tracking-tight text-slate-900 dark:text-white leading-tight">
                        Precision Cargo Weighing <br>
                        <span class="bg-gradient-to-r from-blue-600 via-indigo-500 to-emerald-500 bg-clip-text text-transparent">
                            & Global Trade Logistics
                        </span>
                    </h1>

                    <p class="mt-6 text-base sm:text-lg text-slate-600 dark:text-slate-300 max-w-xl leading-relaxed">
                        Hamza Trading International delivers secure, automated weighbridge scale integrations and shipping agency services for bulk dry, liquid, and mineral cargo ports. Engineered with real-time telemetry syncing terminal scales to client dashboards.
                    </p>

                    <!-- CTAs -->
                    <div class="mt-8 flex flex-col sm:flex-row gap-4 sm:items-center">
                        <a href="#simulator" 
                           class="inline-flex items-center justify-center px-8 py-4 rounded-xl font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-indigo-700 hover:from-blue-700 hover:via-indigo-700 hover:to-indigo-800 text-white shadow-lg shadow-blue-500/30 hover:scale-[1.02] active:scale-[0.98] transition-all text-center">
                            Calculate Billing
                            <svg class="w-5 h-5 ml-2.5 -mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </a>
                        <a href="#telemetry" 
                           class="inline-flex items-center justify-center px-8 py-4 rounded-xl font-semibold border border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-900/30 backdrop-blur-sm text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors text-center">
                            Explore Live Telemetry
                        </a>
                    </div>

                    <!-- Trust Stats Row -->
                    <div class="mt-12 sm:mt-16 grid grid-cols-3 gap-6 border-t border-slate-200/80 dark:border-slate-800/80 pt-8 max-w-md">
                        <div>
                            <span class="block text-2xl sm:text-3xl font-extrabold font-outfit text-slate-900 dark:text-white">6+</span>
                            <span class="text-xs font-medium text-slate-500 dark:text-slate-400">Port Scales Online</span>
                        </div>
                        <div>
                            <span class="block text-2xl sm:text-3xl font-extrabold font-outfit text-slate-900 dark:text-white">42.5k</span>
                            <span class="text-xs font-medium text-slate-500 dark:text-slate-400">Daily Tonnage (MT)</span>
                        </div>
                        <div>
                            <span class="block text-2xl sm:text-3xl font-extrabold font-outfit text-slate-900 dark:text-white">100%</span>
                            <span class="text-xs font-medium text-slate-500 dark:text-slate-400">Verified Precision</span>
                        </div>
                    </div>
                </div>

                <!-- Right Hero Graphic -->
                <div class="lg:col-span-5 relative w-full flex justify-center lg:justify-end">
                    <!-- Glassmorphic Mock Widget Card -->
                    <div class="w-full max-w-[420px] rounded-2xl border border-slate-200/80 dark:border-slate-800/80 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md shadow-2xl p-6 relative overflow-hidden transition-all duration-300 glow-border">
                        <!-- Card Background Lights -->
                        <div class="absolute -top-10 -left-10 w-24 h-24 bg-emerald-500/10 rounded-full blur-xl"></div>
                        <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-blue-500/10 rounded-full blur-xl"></div>
                        
                        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4 mb-4">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                                <span class="font-semibold text-xs tracking-wider uppercase text-slate-500 dark:text-slate-400">Terminal Scale Indicator</span>
                            </div>
                            <span class="px-2 py-0.5 rounded bg-blue-50 dark:bg-blue-900/30 text-[10px] text-blue-600 dark:text-blue-400 font-bold border border-blue-200/40 dark:border-blue-800/40">ID: WBRIDGE-CT-04</span>
                        </div>

                        <!-- LED Weighbridge Weight Display -->
                        <div class="bg-slate-950 rounded-xl p-4 border border-slate-800/80 flex flex-col relative overflow-hidden">
                            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(59,130,246,0.15),transparent)]"></div>
                            
                            <div class="flex items-center justify-between z-10 text-[9px] uppercase font-bold tracking-widest text-slate-500">
                                <span>Gross Load</span>
                                <span class="text-blue-500">Active Vessel weighing</span>
                            </div>
                            <div class="flex items-baseline justify-between z-10 mt-1">
                                <span class="font-mono text-3xl sm:text-4xl text-emerald-400 font-bold tracking-widest drop-shadow-[0_0_10px_rgba(52,211,153,0.3)]">
                                    34,428.50
                                </span>
                                <span class="font-mono text-emerald-400 font-bold ml-1 text-sm tracking-wider">MT</span>
                            </div>
                            <div class="flex items-center justify-between z-10 border-t border-slate-900 pt-2 mt-2 text-[9px] text-slate-400 font-medium">
                                <span>Tare: 12,180 MT</span>
                                <span>Net: 22,248.50 MT</span>
                            </div>
                        </div>

                        <!-- Mini Vessel Details -->
                        <div class="mt-4 space-y-3">
                            <div class="flex items-center justify-between text-xs py-1 border-b border-slate-100 dark:border-slate-800/40">
                                <span class="text-slate-500 dark:text-slate-400">Active Vessel:</span>
                                <span class="font-semibold text-slate-800 dark:text-slate-200">MV Hamza Express</span>
                            </div>
                            <div class="flex items-center justify-between text-xs py-1 border-b border-slate-100 dark:border-slate-800/40">
                                <span class="text-slate-500 dark:text-slate-400">Cargo Type:</span>
                                <span class="font-semibold text-slate-800 dark:text-slate-200">Coal (Bulk Cargo)</span>
                            </div>
                            <div class="flex items-center justify-between text-xs py-1">
                                <span class="text-slate-500 dark:text-slate-400">Assigned Operator:</span>
                                <span class="font-semibold text-slate-800 dark:text-slate-200">K. Ahmed (OP-442)</span>
                            </div>
                        </div>

                        <!-- Micro progress loader -->
                        <div class="mt-4 bg-slate-100 dark:bg-slate-800 rounded-full h-1.5 overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-600 to-emerald-500 h-full w-[72%] rounded-full animate-pulse"></div>
                        </div>
                        <div class="flex justify-between text-[10px] text-slate-500 mt-1 font-semibold">
                            <span>Bulk Offload Progress</span>
                            <span>72% Completed</span>
                        </div>
                    </div>

                    <!-- Extra floating graphic decoration -->
                    <div class="absolute -bottom-6 -left-6 bg-slate-900 text-white rounded-xl p-4 shadow-xl border border-slate-800 max-w-[170px] hidden sm:flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/20 flex items-center justify-center text-emerald-400 font-bold">
                            ✔
                        </div>
                        <div>
                            <span class="block text-xs font-bold uppercase tracking-wider text-slate-400">API Gateway</span>
                            <span class="text-[10px] text-slate-300">Secured with SSL</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CORE SERVICES SECTION -->
    <section id="services" class="py-20 bg-white dark:bg-slate-900/40 border-y border-slate-200/80 dark:border-slate-800/80 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto">
                <span class="text-xs uppercase tracking-[0.2em] font-extrabold text-blue-600 dark:text-blue-400">Our Portfolios</span>
                <h2 class="font-outfit font-extrabold text-3xl sm:text-4xl text-slate-900 dark:text-white mt-2">
                    Professional Trading & Port Infrastructure
                </h2>
                <p class="mt-4 text-slate-600 dark:text-slate-400">
                    Hamza Trading International bridges global raw supplies with local port efficiency, providing custom scales and end-to-end maritime support.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mt-16">
                <!-- Service 1 -->
                <div class="group p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800/80 hover:border-blue-500/30 bg-slate-50/50 dark:bg-slate-900/20 hover:bg-white dark:hover:bg-slate-800/30 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center group-hover:scale-110 transition-transform mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="font-outfit font-bold text-lg text-slate-950 dark:text-white mb-2">Weighbridge Telemetry</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed flex-grow">
                        Real-time digital weighbridge integration syncing terminal indicator scales automatically. Zero manual data tampering.
                    </p>
                </div>

                <!-- Service 2 -->
                <div class="group p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800/80 hover:border-emerald-500/30 bg-slate-50/50 dark:bg-slate-900/20 hover:bg-white dark:hover:bg-slate-800/30 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center group-hover:scale-110 transition-transform mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </div>
                    <h3 class="font-outfit font-bold text-lg text-slate-950 dark:text-white mb-2">Marine Agencies</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed flex-grow">
                        Full-vessel representation, cargo stevedoring, draft surveying, and clearance coordinating directly at primary port zones.
                    </p>
                </div>

                <!-- Service 3 -->
                <div class="group p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800/80 hover:border-indigo-500/30 bg-slate-50/50 dark:bg-slate-900/20 hover:bg-white dark:hover:bg-slate-800/30 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col">
                    <div class="w-12 h-12 rounded-xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center group-hover:scale-110 transition-transform mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                        </svg>
                    </div>
                    <h3 class="font-outfit font-bold text-lg text-slate-950 dark:text-white mb-2">Global Commodities</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed flex-grow">
                        Bulk importing and supply chains of high-grade coal, clinker, fly ash, grains, gypsum, and key manufacturing minerals.
                    </p>
                </div>

                <!-- Service 4 -->
                <div class="group p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800/80 hover:border-violet-500/30 bg-slate-50/50 dark:bg-slate-900/20 hover:bg-white dark:hover:bg-slate-800/30 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col">
                    <div class="w-12 h-12 rounded-xl bg-violet-500/10 text-violet-600 dark:text-violet-400 flex items-center justify-center group-hover:scale-110 transition-transform mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="font-outfit font-bold text-lg text-slate-950 dark:text-white mb-2">Port Clearance & Customs</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed flex-grow">
                        Automated documentation systems matching weighing scales with bill of lading profiles, shortening custom processing times.
                    </p>
                </div>
            </div>

        </div>
    </section>

    <!-- LIVE TELEMETRY SIMULATOR AND INTERACTIVE CALCULATOR -->
    <section id="telemetry" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs uppercase tracking-[0.2em] font-extrabold text-indigo-600 dark:text-indigo-400">Console Preview</span>
            <h2 class="font-outfit font-extrabold text-3xl sm:text-4xl text-slate-900 dark:text-white mt-2">
                Interactive Weighbridge Operations
            </h2>
            <p class="mt-4 text-slate-600 dark:text-slate-400">
                Observe live simulated telemetry data feeding from port terminals or use the interactive toll calculator to estimate cargo handling statistics.
            </p>
        </div>

        <div class="grid lg:grid-cols-12 gap-8 items-start">
            
            <!-- LEFT CONTAINER: LIVE TELEMETRY SIMULATOR -->
            <div class="lg:col-span-7 rounded-2xl border border-slate-200/85 dark:border-slate-800/85 bg-white dark:bg-[#0f1422] p-6 shadow-xl relative" 
                 x-data="{
                    records: [
                        { time: '02:29:10', vessel: 'MV Hamza Express', scale: 'SC-01', commodity: 'Coal', gross: 42350, status: 'Verified' },
                        { time: '02:28:42', vessel: 'MV Ocean Crest', scale: 'SC-03', commodity: 'Clinker', gross: 28410, status: 'Verified' },
                        { time: '02:26:15', vessel: 'MV Bengal Monarch', scale: 'SC-02', commodity: 'Wheat', gross: 19180, status: 'Verified' },
                        { time: '02:24:08', vessel: 'MV Blue Horizon', scale: 'SC-01', commodity: 'Iron Ore', gross: 55420, status: 'Verified' },
                        { time: '02:22:50', vessel: 'MV Golden Gate', scale: 'SC-04', commodity: 'Gypsum', gross: 14200, status: 'Verified' }
                    ],
                    vesselPool: ['MV Hamza Rover', 'MV Padma Crown', 'MV Bay Clipper', 'MV Meghna Pride', 'MV River Pearl'],
                    scalePool: ['SC-01', 'SC-02', 'SC-03', 'SC-04'],
                    commodityPool: ['Coal', 'Clinker', 'Wheat', 'Iron Ore', 'Gypsum', 'Scrap Metal'],
                    
                    addRecord() {
                        const now = new Date();
                        const timeStr = now.toTimeString().split(' ')[0];
                        const randomVessel = this.vesselPool[Math.floor(Math.random() * this.vesselPool.length)];
                        const randomScale = this.scalePool[Math.floor(Math.random() * this.scalePool.length)];
                        const randomCommodity = this.commodityPool[Math.floor(Math.random() * this.commodityPool.length)];
                        const randomGross = Math.floor(Math.random() * 45000) + 10000;
                        
                        // Add to start, limit to 6 entries
                        this.records.unshift({
                            time: timeStr,
                            vessel: randomVessel,
                            scale: randomScale,
                            commodity: randomCommodity,
                            gross: randomGross,
                            status: 'Verified'
                        });
                        
                        if (this.records.length > 6) {
                            this.records.pop();
                        }
                    },
                    init() {
                        setInterval(() => this.addRecord(), 4000);
                    }
                 }">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800/80 pb-4 mb-4">
                    <div>
                        <h3 class="font-outfit font-bold text-lg text-slate-900 dark:text-white">Port Telemetry Simulator</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Real-time mock feed of completed scale measurements</p>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-emerald-50 dark:bg-emerald-950/40 text-[10px] text-emerald-600 dark:text-emerald-400 font-bold border border-emerald-200/30 dark:border-emerald-800/30">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></span>
                        LIVE CONNECTED
                    </span>
                </div>

                <!-- Simulation Feed Table -->
                <div class="overflow-x-auto min-h-[300px]">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="text-slate-400 dark:text-slate-500 font-semibold border-b border-slate-100 dark:border-slate-800/60 pb-2">
                                <th class="pb-3">Timestamp</th>
                                <th class="pb-3">Vessel Name</th>
                                <th class="pb-3">Scale ID</th>
                                <th class="pb-3">Commodity</th>
                                <th class="pb-3 text-right">Gross (MT)</th>
                                <th class="pb-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/40">
                            <template x-for="(rec, index) in records" :key="rec.time + index">
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-all duration-300 font-mono align-middle">
                                    <td class="py-3 text-slate-500" x-text="rec.time"></td>
                                    <td class="py-3 font-semibold text-slate-800 dark:text-slate-200 font-sans" x-text="rec.vessel"></td>
                                    <td class="py-3 text-slate-600 dark:text-slate-400" x-text="rec.scale"></td>
                                    <td class="py-3 font-sans text-slate-700 dark:text-slate-300" x-text="rec.commodity"></td>
                                    <td class="py-3 font-bold text-slate-900 dark:text-emerald-400 text-right" x-text="rec.gross.toLocaleString() + ' MT'"></td>
                                    <td class="py-3 text-center">
                                        <span class="inline-flex px-2 py-0.5 rounded text-[9px] font-bold bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-800/20" x-text="rec.status"></span>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 border-t border-slate-100 dark:border-slate-800/60 pt-4 flex items-center justify-between text-[11px] text-slate-500 font-semibold">
                    <span>Telemetry source: Port Operations (Chittagong, BD)</span>
                    <span>Interval: 4s auto-refresh</span>
                </div>
            </div>

            <!-- RIGHT CONTAINER: DYNAMIC BILLING CALCULATOR -->
            <div id="simulator" class="lg:col-span-5 rounded-2xl border border-slate-200/85 dark:border-slate-800/85 bg-white dark:bg-[#0f1422] p-6 shadow-xl relative"
                 x-data="{
                    vesselClass: 'handymax',
                    cargoType: 'coal',
                    cargoLoad: 35000,
                    usdRate: 118.5, // 1 USD = 118.5 BDT
                    
                    // Rates in BDT per Metric Ton (MT)
                    cargoRates: {
                        coal: { handling: 150, weighbridge: 15, agency: 55000 },
                        clinker: { handling: 180, weighbridge: 18, agency: 65000 },
                        grains: { handling: 120, weighbridge: 12, agency: 45000 },
                        scrap: { handling: 250, weighbridge: 25, agency: 75000 },
                        cement: { handling: 200, weighbridge: 20, agency: 60000 },
                        gypsum: { handling: 140, weighbridge: 14, agency: 50000 }
                    },
                    vesselLimits: {
                        handysize: { min: 10000, max: 35000 },
                        handymax: { min: 35000, max: 60000 },
                        panamax: { min: 60000, max: 80000 },
                        capesize: { min: 80000, max: 150000 }
                    },

                    get maxLoad() {
                        return this.vesselLimits[this.vesselClass].max;
                    },
                    get minLoad() {
                        return this.vesselLimits[this.vesselClass].min;
                    },
                    
                    adjustLoad() {
                        if (this.cargoLoad > this.maxLoad) this.cargoLoad = this.maxLoad;
                        if (this.cargoLoad < this.minLoad) this.cargoLoad = this.minLoad;
                    },

                    get billHandling() {
                        const rate = this.cargoRates[this.cargoType].handling;
                        return Math.round(this.cargoLoad * rate);
                    },
                    get billWeighbridge() {
                        const rate = this.cargoRates[this.cargoType].weighbridge;
                        return Math.round(this.cargoLoad * rate);
                    },
                    get billAgency() {
                        return this.cargoRates[this.cargoType].agency;
                    },
                    get billSubtotal() {
                        return this.billHandling + this.billWeighbridge + this.billAgency;
                    },
                    get billTax() {
                        return Math.round(this.billSubtotal * 0.15); // 15% VAT
                    },
                    get billTotalBDT() {
                        return this.billSubtotal + this.billTax;
                    },
                    get billTotalUSD() {
                        return Math.round((this.billTotalBDT / this.usdRate) * 100) / 100;
                    }
                 }"
                 x-init="$watch('vesselClass', value => adjustLoad())">
                
                <h3 class="font-outfit font-bold text-lg text-slate-900 dark:text-white border-b border-slate-100 dark:border-slate-800/80 pb-4 mb-4">
                    Corporate Billing Calculator
                </h3>

                <!-- Calculator Form Controls -->
                <div class="space-y-4">
                    <!-- Vessel Class -->
                    <div>
                        <label for="calc-vessel-class" class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1.5">Vessel Cargo Class</label>
                        <select id="calc-vessel-class" x-model="vesselClass" class="w-full rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 p-2.5 text-xs font-medium focus:ring-2 focus:ring-blue-500/20 text-slate-800 dark:text-slate-100">
                            <option value="handysize">Handysize Bulk Carrier (10k - 35k MT)</option>
                            <option value="handymax">Handymax Carrier (35k - 60k MT)</option>
                            <option value="panamax">Panamax Vessel (60k - 80k MT)</option>
                            <option value="capesize">Capesize Heavy Carrier (80k - 150k MT)</option>
                        </select>
                    </div>

                    <!-- Cargo Type -->
                    <div>
                        <label for="calc-cargo-type" class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1.5">Commodity Category</label>
                        <select id="calc-cargo-type" x-model="cargoType" class="w-full rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 p-2.5 text-xs font-medium focus:ring-2 focus:ring-blue-500/20 text-slate-800 dark:text-slate-100">
                            <option value="coal">Industrial Coal</option>
                            <option value="clinker">Cement Clinker</option>
                            <option value="grains">Wheat & Grains</option>
                            <option value="scrap">Scrap Metals</option>
                            <option value="cement">Portland Cement</option>
                            <option value="gypsum">Raw Gypsum</option>
                        </select>
                    </div>

                    <!-- Load Range Slider -->
                    <div>
                        <div class="flex justify-between text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1.5">
                            <label for="calc-cargo-slider">Gross Load Weight</label>
                            <span class="font-mono text-blue-600 dark:text-blue-400" x-text="parseInt(cargoLoad).toLocaleString() + ' MT'"></span>
                        </div>
                        <input id="calc-cargo-slider" type="range" :min="minLoad" :max="maxLoad" step="500" x-model="cargoLoad" class="w-full accent-blue-600 bg-slate-100 dark:bg-slate-800 rounded-lg appearance-none h-2 cursor-pointer">
                        <div class="flex justify-between text-[9px] text-slate-400 font-semibold mt-1">
                            <span x-text="minLoad.toLocaleString() + ' MT'"></span>
                            <span x-text="maxLoad.toLocaleString() + ' MT'"></span>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Outputs Display -->
                <div class="mt-6 bg-slate-50 dark:bg-[#070b13] border border-slate-100 dark:border-slate-900 rounded-xl p-4 space-y-3">
                    <div class="flex justify-between text-xs py-1 border-b border-slate-150 dark:border-slate-800/40">
                        <span class="text-slate-500 dark:text-slate-400">Stevedoring & Port Handling:</span>
                        <span class="font-bold text-slate-800 dark:text-slate-200" x-text="billHandling.toLocaleString() + ' BDT'"></span>
                    </div>
                    <div class="flex justify-between text-xs py-1 border-b border-slate-150 dark:border-slate-800/40">
                        <span class="text-slate-500 dark:text-slate-400">Automated Weighbridge Fee:</span>
                        <span class="font-bold text-slate-800 dark:text-slate-200" x-text="billWeighbridge.toLocaleString() + ' BDT'"></span>
                    </div>
                    <div class="flex justify-between text-xs py-1 border-b border-slate-150 dark:border-slate-800/40">
                        <span class="text-slate-500 dark:text-slate-400">Agency Customs Clearance:</span>
                        <span class="font-bold text-slate-800 dark:text-slate-200" x-text="billAgency.toLocaleString() + ' BDT'"></span>
                    </div>
                    <div class="flex justify-between text-xs py-1 border-b border-slate-150 dark:border-slate-800/40">
                        <span class="text-slate-500 dark:text-slate-400">Tax / VAT (15%):</span>
                        <span class="font-bold text-slate-800 dark:text-slate-200" x-text="billTax.toLocaleString() + ' BDT'"></span>
                    </div>
                    <div class="flex justify-between text-sm pt-1 border-t border-slate-200 dark:border-slate-800">
                        <span class="font-bold text-slate-700 dark:text-slate-300">Total Invoice Billing:</span>
                        <div class="text-right">
                            <span class="block font-extrabold text-blue-600 dark:text-blue-400 text-base" x-text="billTotalBDT.toLocaleString() + ' BDT'"></span>
                            <span class="text-[10px] font-semibold text-slate-450" x-text="'≈ $' + billTotalUSD.toLocaleString() + ' USD'"></span>
                        </div>
                    </div>
                </div>

                <!-- Interactive Overload Alert Bar -->
                <div class="mt-4 px-3 py-2.5 rounded-lg border text-[11px] font-semibold flex items-center gap-2"
                     :class="{
                        'bg-emerald-500/10 border-emerald-500/20 text-emerald-600 dark:text-emerald-400': cargoLoad < maxLoad * 0.9,
                        'bg-amber-500/10 border-amber-500/20 text-amber-600 dark:text-amber-400': cargoLoad >= maxLoad * 0.9 && cargoLoad < maxLoad * 0.98,
                        'bg-red-500/10 border-red-500/20 text-red-600 dark:text-red-400': cargoLoad >= maxLoad * 0.98
                     }">
                     <span class="w-2 h-2 rounded-full" 
                           :class="{
                             'bg-emerald-500': cargoLoad < maxLoad * 0.9,
                             'bg-amber-500': cargoLoad >= maxLoad * 0.9 && cargoLoad < maxLoad * 0.98,
                             'bg-red-500': cargoLoad >= maxLoad * 0.98
                           }"></span>
                     <span x-show="cargoLoad < maxLoad * 0.9">Tariff within standard offload limit.</span>
                     <span x-show="cargoLoad >= maxLoad * 0.9 && cargoLoad < maxLoad * 0.98" style="display: none;">High load density. Subject to harbor surcharge.</span>
                     <span x-show="cargoLoad >= maxLoad * 0.98" style="display: none;">Maximum terminal capacity. Excess tonnage tariff applies.</span>
                </div>
            </div>

        </div>
    </section>

    <!-- SAILO SCALE INTEGRATION FEATURE SHOWCASE -->
    <section id="about" class="py-20 bg-slate-900 text-white relative transition-colors duration-300">
        <div class="absolute inset-0 bg-grid-pattern opacity-10"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                
                <!-- Left: Integration Mock UI -->
                <div class="relative flex justify-center">
                    <div class="w-full max-w-[460px] rounded-2xl border border-slate-800 bg-[#0f1424] p-6 shadow-2xl relative overflow-hidden">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-yellow-500"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                            <span class="text-xs text-slate-500 uppercase tracking-widest font-mono ml-2">sailo_weight_scale - config.yaml</span>
                        </div>

                        <!-- Codeblock Display -->
                        <div class="bg-slate-950/80 rounded-xl p-4 border border-slate-900 font-mono text-[10px] sm:text-xs text-slate-300 leading-relaxed overflow-x-auto">
<span class="text-indigo-400">weighbridge:</span>
  <span class="text-emerald-400">indicator_model:</span> XK3190-A9+
  <span class="text-emerald-400">baud_rate:</span> 9600
  <span class="text-emerald-400">data_bits:</span> 8
  <span class="text-emerald-400">parity:</span> none

<span class="text-indigo-400">api_sync:</span>
  <span class="text-emerald-400">endpoint:</span> https://trading.hamza.com/api/v1/scale-logs
  <span class="text-emerald-400">auth_mode:</span> bearer_jwt
  <span class="text-emerald-400">retry_limit:</span> 5
  <span class="text-emerald-400">offline_storage:</span> enabled

<span class="text-indigo-400">roles_permissions:</span>
  <span class="text-emerald-400">- super-admin:</span> Full system reset & calibrating
  <span class="text-emerald-400">- admin:</span> Print vessels & view audit logs
  <span class="text-emerald-400">- operator:</span> Weighing, draft input & print tickets
                        </div>

                        <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-blue-500/10 rounded-full blur-xl"></div>
                    </div>
                </div>

                <!-- Right: Information Content -->
                <div class="flex flex-col text-left">
                    <span class="text-xs uppercase tracking-[0.2em] font-extrabold text-blue-400">Proprietary Technology</span>
                    <h2 class="font-outfit font-extrabold text-3xl sm:text-4xl text-white mt-2 leading-tight">
                        Sailo Weighbridge Scale Integration
                    </h2>
                    <p class="mt-6 text-slate-300 leading-relaxed text-sm sm:text-base">
                        Our terminals deploy the custom-configured <strong>Sailo Scale System</strong>, directly linking physical industrial weighbridge scale indicators to a web-based database portal. Operators log gross, tare, and net weights with zero manual input vectors, preventing ledger discrepancies.
                    </p>

                    <!-- Features bullets list -->
                    <div class="mt-8 space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-lg bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400 text-xs shrink-0 mt-0.5">
                                ✓
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-slate-100">Multi-Role User Dashboard</h4>
                                <p class="text-xs text-slate-400 mt-0.5">Super Admins check audit paths; Admins generate shipping reports; Operators register weights directly.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-lg bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 text-xs shrink-0 mt-0.5">
                                ✓
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-slate-100">Automated Ticket Printing</h4>
                                <p class="text-xs text-slate-400 mt-0.5">Vessel weighing tickets print automatically inside local port operator hubs using preset thermal configs.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-lg bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400 text-xs shrink-0 mt-0.5">
                                ✓
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-slate-100">Fallback Offline Cache</h4>
                                <p class="text-xs text-slate-400 mt-0.5">Scale measurements buffer locally during intermittent harbor network outages, auto-syncing when line reconnects.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>



    <!-- TESTIMONIAL CAROUSEL -->
    <section class="py-20 bg-slate-50 dark:bg-slate-900/20 border-y border-slate-200/80 dark:border-slate-800/80 transition-colors duration-300"
             x-data="{
                activeSlide: 0,
                slides: [
                    {
                        quote: 'The Sailo integration implemented by Hamza Trading has cut down our port offload reporting time from 24 hours to instantaneous database sync. Our logistics agents are thrilled.',
                        author: 'Capt. S. M. Rahman',
                        role: 'Terminal Operations Manager, Chittagong Port Authority'
                    },
                    {
                        quote: 'Zero discrepancies since we set up Hamza Trading weighbridges. Automated indicator reading ensures complete financial accountability across all coal imports.',
                        author: 'M. H. Chowdhury',
                        role: 'Procurement Director, Orion Power Group'
                    },
                    {
                        quote: 'Fantastic support and reliable marine stevedoring agency services. Hamza Trading handles our draft surveys and bulk materials with extreme diligence.',
                        author: 'Alastair Vance',
                        role: 'Global Logistics Lead, Interbulk Trading Ltd.'
                    }
                ],
                next() {
                    this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                },
                prev() {
                    this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length;
                }
             }">
        <div class="max-w-4xl mx-auto px-4 text-center relative">
            <span class="text-xs uppercase tracking-[0.2em] font-extrabold text-blue-600 dark:text-blue-400">Client Reviews</span>
            <h2 class="font-outfit font-extrabold text-3xl text-slate-900 dark:text-white mt-2 mb-12">
                Trusted by Terminal Captains & Traders
            </h2>

            <!-- Slide Window -->
            <div class="relative min-h-[160px] flex items-center justify-center">
                <template x-for="(slide, idx) in slides" :key="idx">
                    <div x-show="activeSlide === idx"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="space-y-4"
                         x-cloak>
                        <p class="font-outfit font-medium text-lg sm:text-xl text-slate-700 dark:text-slate-300 italic leading-relaxed">
                            &ldquo;<span x-text="slide.quote"></span>&rdquo;
                        </p>
                        <div>
                            <span class="block font-bold text-slate-900 dark:text-white" x-text="slide.author"></span>
                            <span class="text-xs text-slate-500 dark:text-slate-400 font-semibold" x-text="slide.role"></span>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Carousel Nav Buttons -->
            <div class="flex items-center justify-center gap-4 mt-8">
                <button @click="prev()" class="p-2 rounded-full border border-slate-200 dark:border-slate-800 hover:bg-white dark:hover:bg-slate-800 text-slate-500 transition-colors cursor-pointer" aria-label="Previous testimonial">
                    ←
                </button>
                <!-- Dots indicators -->
                <div class="flex gap-2">
                    <template x-for="(slide, idx) in slides" :key="idx">
                        <button @click="activeSlide = idx" 
                                class="w-2.5 h-2.5 rounded-full transition-colors cursor-pointer"
                                :class="activeSlide === idx ? 'bg-blue-600' : 'bg-slate-300 dark:bg-slate-700'"></button>
                    </template>
                </div>
                <button @click="next()" class="p-2 rounded-full border border-slate-200 dark:border-slate-800 hover:bg-white dark:hover:bg-slate-800 text-slate-500 transition-colors cursor-pointer" aria-label="Next testimonial">
                    →
                </button>
            </div>
        </div>
    </section>

    <!-- CONTACT FORM & PORT LOCATIONS -->
    <section id="contact" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-12 gap-12 items-start">
            
            <!-- Left Info Block -->
            <div class="lg:col-span-5 flex flex-col text-left">
                <span class="text-xs uppercase tracking-[0.2em] font-extrabold text-blue-600 dark:text-blue-400">Get in Touch</span>
                <h2 class="font-outfit font-extrabold text-3xl sm:text-4xl text-slate-900 dark:text-white mt-2">
                    Connect with Our Operations Center
                </h2>
                <p class="mt-4 text-slate-600 dark:text-slate-400 text-sm sm:text-base leading-relaxed">
                    Need weighbridge installations or agency scheduling at a new harbor terminal? Reach out to our logistics planners for immediate quotes and deployment options.
                </p>

                <!-- Location details -->
                <div class="mt-8 space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-lg bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold shrink-0 mt-1">
                            📍
                        </div>
                        <div>
                            <span class="block font-bold text-xs uppercase tracking-wider text-slate-400">Headquarters Office</span>
                            <p class="text-sm font-semibold text-slate-800 dark:text-slate-200 mt-1">Hamza Tower, Level 8, Lalbagh, Dhaka, Bangladesh</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400 font-bold shrink-0 mt-1">
                            ⚓
                        </div>
                        <div>
                            <span class="block font-bold text-xs uppercase tracking-wider text-slate-400">Harbor Operations Liaison</span>
                            <p class="text-sm font-semibold text-slate-800 dark:text-slate-200 mt-1">Sadarghat Terminal Road, Chittagong Port Area, Chittagong</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Glassmorphic Form -->
            <div class="lg:col-span-7 rounded-2xl border border-slate-200/80 dark:border-slate-800/80 bg-white/70 dark:bg-slate-900/50 backdrop-blur-md p-6 sm:p-8 shadow-xl">
                <form id="contact-form" 
                      x-data="{ 
                          name: '',
                          email: '',
                          subject: 'scale',
                          message: '',
                          loading: false,
                          success: false,
                          error: false,
                          errorMessage: '',
                          submitForm() {
                              this.loading = true;
                              this.success = false;
                              this.error = false;
                              fetch('/contact', {
                                  method: 'POST',
                                  headers: {
                                      'Content-Type': 'application/json',
                                      'Accept': 'application/json',
                                      'X-CSRF-TOKEN': document.querySelector('meta[name=&quot;csrf-token&quot;]').getAttribute('content')
                                  },
                                  body: JSON.stringify({
                                      name: this.name,
                                      email: this.email,
                                      subject: this.subject,
                                      message: this.message
                                  })
                              })
                              .then(res => {
                                  if (!res.ok) {
                                      return res.json().then(data => { throw new Error(data.message || 'Submission failed'); });
                                  }
                                  return res.json();
                              })
                              .then(data => {
                                  this.success = true;
                                  this.name = '';
                                  this.email = '';
                                  this.message = '';
                              })
                              .catch(err => {
                                  this.error = true;
                                  this.errorMessage = err.message || 'An error occurred during submission. Please try again.';
                              })
                              .finally(() => {
                                  this.loading = false;
                              });
                          }
                      }" 
                      @submit.prevent="submitForm">
                    
                    <div x-show="success" class="p-6 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 text-sm font-semibold text-center mb-6" x-cloak>
                        Thank you! Your inquiry has been saved successfully in our system. An operations officer will contact you shortly.
                    </div>
                    
                    <div x-show="error" class="p-6 rounded-xl bg-red-500/10 border border-red-500/20 text-red-600 dark:text-red-400 text-sm font-semibold text-center mb-6" x-cloak>
                        <span x-text="errorMessage"></span>
                    </div>
                    
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div>
                            <label for="contact-name" class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1.5">Full Name</label>
                            <input id="contact-name" required type="text" x-model="name" placeholder="e.g. John Doe" class="w-full rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950 p-2.5 text-xs font-medium focus:ring-2 focus:ring-blue-500/20 text-slate-800 dark:text-slate-100">
                        </div>
                        <div>
                            <label for="contact-email" class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1.5">Corporate Email</label>
                            <input id="contact-email" required type="email" x-model="email" placeholder="e.g. name@company.com" class="w-full rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950 p-2.5 text-xs font-medium focus:ring-2 focus:ring-blue-500/20 text-slate-800 dark:text-slate-100">
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="contact-subject" class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1.5">Inquiry Subject</label>
                        <select id="contact-subject" x-model="subject" class="w-full rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950 p-2.5 text-xs font-medium focus:ring-2 focus:ring-blue-500/20 text-slate-800 dark:text-slate-100">
                            <option value="scale">Weighbridge Scale Installation & Software</option>
                            <option value="agency">Marine Stevedoring & Agency Services</option>
                            <option value="trade">Commodity Supply Contract</option>
                            <option value="support">API / Technical System Integration</option>
                        </select>
                    </div>

                    <div class="mt-6">
                        <label for="contact-message" class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1.5">Detail Message</label>
                        <textarea id="contact-message" required rows="4" x-model="message" placeholder="Brief details about your vessel capacity, terminal requirements, or scale indicators..." class="w-full rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/50 p-2.5 text-xs font-medium focus:ring-2 focus:ring-blue-500/20 text-slate-800 dark:text-slate-100"></textarea>
                    </div>

                    <button type="submit" :disabled="loading" class="mt-8 w-full py-3 rounded-lg font-bold bg-blue-600 hover:bg-blue-700 disabled:opacity-50 text-white font-semibold text-xs tracking-wider uppercase transition-colors shadow-lg shadow-blue-500/20 flex items-center justify-center gap-2">
                        <span x-show="loading" class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin" x-cloak></span>
                        <span x-text="loading ? 'Sending...' : 'Send Secure Message'"></span>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="border-t border-slate-200/80 dark:border-slate-800/80 bg-white dark:bg-[#060912] transition-colors duration-300 text-slate-500 dark:text-slate-400 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <!-- Branding column -->
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center text-white font-bold text-md">
                            ⚓
                        </div>
                        <span class="font-outfit font-extrabold text-md tracking-tight text-slate-900 dark:text-white">
                            HAMZA TRADING INTERNATIONAL
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 max-w-sm leading-relaxed">
                        Supplier of heavy harbor machinery, bulk imports, and automated telemetry weighbridge scales synced with Sailo Integration engines.
                    </p>
                </div>

                <!-- Resources Links Column -->
                <div class="flex flex-col gap-2">
                    <span class="text-xs uppercase font-extrabold text-slate-700 dark:text-slate-300 tracking-wider">Services</span>
                    <a href="#services" class="text-xs hover:text-blue-500 transition-colors">Weighbridges</a>
                    <a href="#services" class="text-xs hover:text-blue-500 transition-colors">Stevedoring</a>
                    <a href="#services" class="text-xs hover:text-blue-500 transition-colors">Brokerage</a>
                    <a href="#services" class="text-xs hover:text-blue-500 transition-colors">Commodities</a>
                </div>

                <!-- Navigation Column -->
                <div class="flex flex-col gap-2">
                    <span class="text-xs uppercase font-extrabold text-slate-700 dark:text-slate-300 tracking-wider">Quick Links</span>
                    <a href="#services" class="text-xs hover:text-blue-500 transition-colors">Our Services</a>
                    <a href="#telemetry" class="text-xs hover:text-blue-500 transition-colors">Live Telemetry</a>
                    <a href="#simulator" class="text-xs hover:text-blue-500 transition-colors">Billing Simulator</a>
                    <a href="#about" class="text-xs hover:text-blue-500 transition-colors">Proprietary Technology</a>
                    <a href="#contact" class="text-xs hover:text-blue-500 transition-colors">Support Desk</a>
                </div>
            </div>

            <div class="border-t border-slate-200/50 dark:border-slate-800/50 pt-8 mt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400">
                <span>&copy; {{ date('Y') }} Hamza Trading International. All Rights Reserved.</span>
                <span class="flex items-center gap-1 mt-2 sm:mt-0">
                    Powered by <strong class="text-blue-500 font-semibold">Sailo Weight Scale Integration</strong>
                </span>
            </div>
        </div>
    </footer>

</body>
</html>
