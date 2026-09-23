<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus Cloud Soft - Website CMS Admin Panel</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Hind Siliguri', 'Inter', sans-serif;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans min-h-screen flex flex-col">

    <!-- Toast Container -->
    <div id="toastContainer" class="fixed top-5 right-5 z-50 flex flex-col gap-2 pointer-events-none"></div>

    <!-- Main Wrapper -->
    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-slate-900 text-slate-300 flex flex-col shrink-0 transition-all duration-300 z-30">
            <!-- Logo Header -->
            <div class="p-4 border-b border-slate-800 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-blue-500/30">
                        N
                    </div>
                    <div>
                        <h1 class="text-white font-bold text-base leading-tight tracking-wide">Nexus Cloud</h1>
                        <span class="text-xs text-blue-400 font-medium">CMS Admin Panel</span>
                    </div>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1 custom-scrollbar">
                <div class="px-3 pb-2 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">
                    মেইন ড্যাশবোর্ড
                </div>
                
                <a href="#overview" onclick="switchTab('overview')" id="nav-overview" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors bg-blue-600 text-white shadow-sm">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                    <span>ওভারভিউ (Overview)</span>
                </a>

                <a href="#demorequests" onclick="switchTab('demorequests')" id="nav-demorequests" class="nav-item flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium transition-colors hover:bg-slate-800 hover:text-white text-slate-400">
                    <div class="flex items-center gap-3">
                        <i data-lucide="inbox" class="w-4 h-4"></i>
                        <span>ডেমো রিকোয়েস্ট (Leads)</span>
                    </div>
                    <span class="bg-blue-500/20 text-blue-400 text-xs px-2 py-0.5 rounded-full font-semibold">5</span>
                </a>

                <div class="pt-4 px-3 pb-2 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">
                    ওয়েবসাইট সেকশন কাস্টমাইজেশন
                </div>

                <a href="#hero" onclick="switchTab('hero')" id="nav-hero" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors hover:bg-slate-800 hover:text-white text-slate-400">
                    <i data-lucide="sparkles" class="w-4 h-4"></i>
                    <span>হিরো সেকশন (Hero)</span>
                </a>

                <a href="#about" onclick="switchTab('about')" id="nav-about" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors hover:bg-slate-800 hover:text-white text-slate-400">
                    <i data-lucide="building-2" class="w-4 h-4"></i>
                    <span>আমাদের সম্পর্কে (About Us)</span>
                </a>

                <a href="#whychoose" onclick="switchTab('whychoose')" id="nav-whychoose" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors hover:bg-slate-800 hover:text-white text-slate-400">
                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                    <span>কেন আমাদের বাছবেন (Values)</span>
                </a>

                <a href="#features" onclick="switchTab('features')" id="nav-features" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors hover:bg-slate-800 hover:text-white text-slate-400">
                    <i data-lucide="cpu" class="w-4 h-4"></i>
                    <span>ফিচারস ও সলিউশনস</span>
                </a>

                <a href="#pricing" onclick="switchTab('pricing')" id="nav-pricing" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors hover:bg-slate-800 hover:text-white text-slate-400">
                    <i data-lucide="badge-dollar-sign" class="w-4 h-4"></i>
                    <span>প্রাইসিং প্ল্যান (Pricing)</span>
                </a>

                <a href="#team" onclick="switchTab('team')" id="nav-team" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors hover:bg-slate-800 hover:text-white text-slate-400">
                    <i data-lucide="users" class="w-4 h-4"></i>
                    <span>টিম মেম্বারস (Team)</span>
                </a>

                <a href="#contact" onclick="switchTab('contact')" id="nav-contact" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors hover:bg-slate-800 hover:text-white text-slate-400">
                    <i data-lucide="phone-call" class="w-4 h-4"></i>
                    <span>যোগাযোগ ও ফুটার (Contact)</span>
                </a>

                <div class="pt-4 px-3 pb-2 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">
                    সিস্টেম সেটিংস
                </div>

                <a href="#settings" onclick="switchTab('settings')" id="nav-settings" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors hover:bg-slate-800 hover:text-white text-slate-400">
                    <i data-lucide="sliders" class="w-4 h-4"></i>
                    <span>লোগো ও SEO সেটিংস</span>
                </a>
            </nav>

            <!-- Bottom User Profile -->
            <div class="p-3 border-t border-slate-800 bg-slate-950/50 flex items-center gap-3">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=120" alt="Admin Avatar" class="w-9 h-9 rounded-full object-cover border border-blue-500">
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-slate-200 truncate">Rakib Mahmud</p>
                    <p class="text-[11px] text-slate-400 truncate">Super Admin</p>
                </div>
                <button title="Logout" onclick="showToast('লগআউট সফল হয়েছে', 'info')" class="text-slate-400 hover:text-rose-400 transition-colors p-1.5 rounded-lg hover:bg-slate-800">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                </button>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

            <!-- Top Header Navbar -->
            <header class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between shrink-0 shadow-sm z-20">
                <div class="flex items-center gap-4">
                    <button id="sidebarToggle" class="text-slate-500 hover:text-slate-800 p-1.5 rounded-lg hover:bg-slate-100 transition">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>
                    <div>
                        <h2 id="pageTitle" class="text-lg font-bold text-slate-800">ওয়েবসাইট কনটেন্ট ম্যানেজমেন্ট ড্যাশবোর্ড</h2>
                        <p class="text-xs text-slate-500 hidden sm:block">nexuscloudsoft.com লাইভ ওয়েবসাইটের সকল টেক্সট, ছবি ও তথ্য এডিট করুন</p>
                    </div>
                </div>

                <!-- Right Action Header -->
                <div class="flex items-center gap-3">
                    <button onclick="toggleLivePreviewModal()" class="flex items-center gap-2 px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium text-xs rounded-lg transition border border-slate-300">
                        <i data-lucide="eye" class="w-4 h-4 text-slate-500"></i>
                        <span class="hidden md:inline">লাইভ প্রিভিউ দেখুন</span>
                    </button>

                    <a href="https://nexuscloudsoft.com" target="_blank" class="flex items-center gap-2 px-3.5 py-2 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-medium text-xs rounded-lg transition border border-emerald-200">
                        <i data-lucide="external-link" class="w-4 h-4"></i>
                        <span class="hidden md:inline">ওয়েবসাইট ভিজিট করুন</span>
                    </a>

                    <button onclick="saveAllChanges()" class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs rounded-lg shadow-sm shadow-blue-500/30 transition">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        <span>পরিবর্তন সেভ করুন</span>
                    </button>
                </div>
            </header>

            <!-- Main Scrollable Workspace -->
            <main class="flex-1 overflow-y-auto p-6 bg-slate-50 custom-scrollbar">

                <!-- 1. OVERVIEW TAB -->
                <section id="tab-overview" class="tab-content space-y-6">
                    <!-- Status Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <i data-lucide="layers" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-slate-500">মোট ওয়েবসাইট সেকশন</p>
                                <h3 class="text-2xl font-bold text-slate-800">8 টি</h3>
                                <span class="text-[11px] text-emerald-600 font-medium flex items-center gap-1 mt-0.5">
                                    <i data-lucide="check-circle" class="w-3 h-3"></i> সবকটি অ্যাক্টিভ
                                </span>
                            </div>
                        </div>

                        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                                <i data-lucide="inbox" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-slate-500">নতুন ডেমো রিকোয়েস্ট</p>
                                <h3 class="text-2xl font-bold text-slate-800">5 টি</h3>
                                <span class="text-[11px] text-blue-600 font-medium flex items-center gap-1 mt-0.5">
                                    <i data-lucide="clock" class="w-3 h-3"></i> আজ ২ টি এসেছে
                                </span>
                            </div>
                        </div>

                        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                <i data-lucide="refresh-cw" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-slate-500">সর্বশেষ আপডেট</p>
                                <h3 class="text-base font-bold text-slate-800">আজ, ১০:৪৫ AM</h3>
                                <span class="text-[11px] text-slate-400 mt-0.5 block">By Rakib Mahmud</span>
                            </div>
                        </div>

                        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                                <i data-lucide="globe" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-slate-500">সাইট স্ট্যাটাস</p>
                                <h3 class="text-2xl font-bold text-emerald-600">অনলাইন (Live)</h3>
                                <span class="text-[11px] text-slate-500 mt-0.5 block">nexuscloudsoft.com</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Section Manager Cards -->
                    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                        <div class="flex items-center justify-between mb-5">
                            <div>
                                <h3 class="text-base font-bold text-slate-800">দ্রুত সেকশন এডিটর (Quick Content Editor)</h3>
                                <p class="text-xs text-slate-500">যে সেকশনের লেখা বা ছবি পরিবর্তন করতে চান, সরাসরি সেই কার্ডে ক্লিক করুন</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Hero Section Card -->
                            <div onclick="switchTab('hero')" class="p-4 rounded-xl border border-slate-200 hover:border-blue-500 hover:shadow-md transition cursor-pointer bg-slate-50 hover:bg-blue-50/30 group">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-2 font-semibold text-slate-800 text-sm">
                                        <i data-lucide="sparkles" class="w-4 h-4 text-blue-600"></i>
                                        <span>Hero Banner Section</span>
                                    </div>
                                    <span class="text-xs bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded font-medium">Active</span>
                                </div>
                                <p class="text-xs text-slate-500 line-clamp-2 mb-3">"Simplify Your ISP Business with One Powerful Platform..."</p>
                                <div class="flex items-center text-xs font-semibold text-blue-600 group-hover:underline gap-1">
                                    <span>এডিট করুন</span>
                                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                </div>
                            </div>

                            <!-- About Section Card -->
                            <div onclick="switchTab('about')" class="p-4 rounded-xl border border-slate-200 hover:border-blue-500 hover:shadow-md transition cursor-pointer bg-slate-50 hover:bg-blue-50/30 group">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-2 font-semibold text-slate-800 text-sm">
                                        <i data-lucide="building-2" class="w-4 h-4 text-blue-600"></i>
                                        <span>About Us Section</span>
                                    </div>
                                    <span class="text-xs bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded font-medium">Active</span>
                                </div>
                                <p class="text-xs text-slate-500 line-clamp-2 mb-3">"We Are a Team of Innovators Dedicated to Empowering Your Brand..."</p>
                                <div class="flex items-center text-xs font-semibold text-blue-600 group-hover:underline gap-1">
                                    <span>এডিট করুন</span>
                                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                </div>
                            </div>

                            <!-- Values / Why Choose Card -->
                            <div onclick="switchTab('whychoose')" class="p-4 rounded-xl border border-slate-200 hover:border-blue-500 hover:shadow-md transition cursor-pointer bg-slate-50 hover:bg-blue-50/30 group">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-2 font-semibold text-slate-800 text-sm">
                                        <i data-lucide="shield-check" class="w-4 h-4 text-blue-600"></i>
                                        <span>Why Choose Us (Values)</span>
                                    </div>
                                    <span class="text-xs bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded font-medium">3 Cards</span>
                                </div>
                                <p class="text-xs text-slate-500 line-clamp-2 mb-3">Complete ISP Automation, Advanced Network Monitoring, Scalable Platform...</p>
                                <div class="flex items-center text-xs font-semibold text-blue-600 group-hover:underline gap-1">
                                    <span>এডিট করুন</span>
                                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                </div>
                            </div>

                            <!-- Features & Solutions -->
                            <div onclick="switchTab('features')" class="p-4 rounded-xl border border-slate-200 hover:border-blue-500 hover:shadow-md transition cursor-pointer bg-slate-50 hover:bg-blue-50/30 group">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-2 font-semibold text-slate-800 text-sm">
                                        <i data-lucide="cpu" class="w-4 h-4 text-blue-600"></i>
                                        <span>Features & Solutions</span>
                                    </div>
                                    <span class="text-xs bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded font-medium">6 Features</span>
                                </div>
                                <p class="text-xs text-slate-500 line-clamp-2 mb-3">MikroTik Integration, OLT/ONU Monitoring, Payment Gateway, SMS Reminders...</p>
                                <div class="flex items-center text-xs font-semibold text-blue-600 group-hover:underline gap-1">
                                    <span>এডিট করুন</span>
                                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                </div>
                            </div>

                            <!-- Pricing Section -->
                            <div onclick="switchTab('pricing')" class="p-4 rounded-xl border border-slate-200 hover:border-blue-500 hover:shadow-md transition cursor-pointer bg-slate-50 hover:bg-blue-50/30 group">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-2 font-semibold text-slate-800 text-sm">
                                        <i data-lucide="badge-dollar-sign" class="w-4 h-4 text-blue-600"></i>
                                        <span>Pricing Plans</span>
                                    </div>
                                    <span class="text-xs bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded font-medium">3 Plans</span>
                                </div>
                                <p class="text-xs text-slate-500 line-clamp-2 mb-3">Basic Plan (৳2,000 setup), Pro Plan, Enterprise Solution...</p>
                                <div class="flex items-center text-xs font-semibold text-blue-600 group-hover:underline gap-1">
                                    <span>এডিট করুন</span>
                                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                </div>
                            </div>

                            <!-- Contact & Social -->
                            <div onclick="switchTab('contact')" class="p-4 rounded-xl border border-slate-200 hover:border-blue-500 hover:shadow-md transition cursor-pointer bg-slate-50 hover:bg-blue-50/30 group">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-2 font-semibold text-slate-800 text-sm">
                                        <i data-lucide="phone-call" class="w-4 h-4 text-blue-600"></i>
                                        <span>Contact & Footer</span>
                                    </div>
                                    <span class="text-xs bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded font-medium">Configured</span>
                                </div>
                                <p class="text-xs text-slate-500 line-clamp-2 mb-3">Phone, Email, Office Address, Social Media links and Copyright text.</p>
                                <div class="flex items-center text-xs font-semibold text-blue-600 group-hover:underline gap-1">
                                    <span>এডিট করুন</span>
                                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- 2. HERO SECTION EDIT TAB -->
                <section id="tab-hero" class="tab-content hidden space-y-6">
                    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                        <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100">
                            <div>
                                <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                                    <i data-lucide="sparkles" class="w-5 h-5 text-blue-600"></i>
                                    হিরো সেকশন এডিটর (Hero Banner)
                                </h3>
                                <p class="text-xs text-slate-500">ওয়েবসাইটের সবার উপরে প্রদর্শিত প্রধান শিরোনাম, সাবটাইটেল ও বাটন এডিট করুন</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="hero_visibility" checked class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                <span class="ml-2 text-xs font-medium text-slate-700">সেকশন চালু রাখুন</span>
                            </label>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Left Column: Form Controls -->
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">মেন হেডিং (Headline)</label>
                                    <input type="text" id="hero_title" value="Simplify Your ISP Business with One Powerful Platform" class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition">
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">সাবটাইটেল / বিবরণ (Description Paragraph)</label>
                                    <textarea id="hero_subtitle" rows="3" class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition custom-scrollbar">Manage customers, automate billing, monitor MikroTik & OLT devices, accept online payments, generate real-time reports, and grow your Internet Service Provider business effortlessly.</textarea>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">প্রাইমারি বাটন টেক্সট</label>
                                        <input type="text" id="hero_cta1_text" value="Get Started" class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">প্রাইমারি বাটন লিংক</label>
                                        <input type="text" id="hero_cta1_link" value="#about" class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none">
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">ভিডিও বাটন টেক্সট</label>
                                        <input type="text" id="hero_cta2_text" value="Watch Video" class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">ইউটিউব ভিডিও URL (Demo Video)</label>
                                        <input type="text" id="hero_cta2_link" value="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">হিরো ইমেজ URL (Banner Image)</label>
                                    <div class="flex gap-2">
                                        <input type="text" id="hero_image_url" value="images/hero_section.png" class="flex-1 px-3.5 py-2.5 text-sm rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none">
                                        <button onclick="showToast('নতুন ইমেজ আপলোড করা হয়েছে', 'success')" class="px-3.5 py-2.5 bg-slate-100 border border-slate-300 hover:bg-slate-200 rounded-lg text-slate-700 text-xs font-medium flex items-center gap-1.5 shrink-0">
                                            <i data-lucide="upload" class="w-4 h-4"></i> আপলোড
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Live Box Preview -->
                            <div class="bg-slate-900 rounded-xl p-6 text-white flex flex-col justify-between shadow-inner relative overflow-hidden">
                                <div class="absolute top-3 right-3 text-[10px] bg-blue-600/30 text-blue-300 border border-blue-500/30 px-2 py-0.5 rounded font-mono uppercase">
                                    Real-time Preview
                                </div>

                                <div class="space-y-4 my-auto py-6">
                                    <span class="inline-block px-3 py-1 bg-blue-500/20 text-blue-400 rounded-full text-xs font-medium border border-blue-500/30">
                                        ISP SaaS Platform
                                    </span>
                                    <h2 id="preview_hero_title" class="text-2xl lg:text-3xl font-extrabold leading-tight text-white">
                                        Simplify Your ISP Business with One Powerful Platform
                                    </h2>
                                    <p id="preview_hero_subtitle" class="text-slate-300 text-xs leading-relaxed">
                                        Manage customers, automate billing, monitor MikroTik & OLT devices, accept online payments, generate real-time reports, and grow your Internet Service Provider business effortlessly.
                                    </p>
                                    <div class="flex flex-wrap items-center gap-3 pt-2">
                                        <button id="preview_hero_cta1" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-xs font-semibold shadow-md">
                                            Get Started
                                        </button>
                                        <div class="flex items-center gap-2 text-xs text-slate-300 font-medium">
                                            <div class="w-7 h-7 rounded-full bg-slate-800 flex items-center justify-center border border-slate-700 text-blue-400">
                                                <i data-lucide="play" class="w-3.5 h-3.5 fill-blue-400"></i>
                                            </div>
                                            <span id="preview_hero_cta2">Watch Video</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-[11px] text-slate-500 border-t border-slate-800 pt-3 flex justify-between items-center">
                                    <span>Nexus Cloud Soft Layout</span>
                                    <span>Section #1</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end">
                            <button onclick="saveSection('hero')" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs rounded-lg transition shadow-sm flex items-center gap-2">
                                <i data-lucide="check" class="w-4 h-4"></i>
                                <span>হিরো সেকশন সেভ করুন</span>
                            </button>
                        </div>
                    </div>
                </section>

                <!-- 3. ABOUT US SECTION TAB -->
                <section id="tab-about" class="tab-content hidden space-y-6">
                    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                        <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100">
                            <div>
                                <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                                    <i data-lucide="building-2" class="w-5 h-5 text-blue-600"></i>
                                    আমাদের সম্পর্কে (About Section)
                                </h3>
                                <p class="text-xs text-slate-500">কোম্পানির পরিচিতি, লক্ষ্য ও সংক্ষিপ্ত ডেসক্রিপশন সম্পাদন করুন</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">ছোট ট্যাগলাইন (Sub-heading)</label>
                                    <input type="text" id="about_sub" value="WHO WE ARE" class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none">
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">প্রধান শিরোনাম (Main Title)</label>
                                    <input type="text" id="about_title" value="We Are a Team of Innovators Dedicated to Empowering Your Brand" class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none">
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">বিস্তারিত বিবরণ (Description Paragraph)</label>
                                    <textarea id="about_desc" rows="4" class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none custom-scrollbar">We combine strategy, creativity, and technology to help your business thrive in the digital world. Our team crafts customized web solutions, driving measurable results and building meaningful connections between you and your customers.</textarea>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">বাটন টেক্সট</label>
                                        <input type="text" id="about_btn_text" value="Read More" class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">বাটন লিংক</label>
                                        <input type="text" id="about_btn_link" value="#services" class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none">
                                    </div>
                                </div>
                            </div>

                            <!-- Preview -->
                            <div class="bg-slate-100 rounded-xl p-6 border border-slate-200 flex flex-col justify-center space-y-4">
                                <span id="preview_about_sub" class="text-xs font-bold text-blue-600 uppercase tracking-wider">
                                    WHO WE ARE
                                </span>
                                <h3 id="preview_about_title" class="text-xl font-bold text-slate-900 leading-snug">
                                    We Are a Team of Innovators Dedicated to Empowering Your Brand
                                </h3>
                                <p id="preview_about_desc" class="text-xs text-slate-600 leading-relaxed">
                                    We combine strategy, creativity, and technology to help your business thrive in the digital world. Our team crafts customized web solutions...
                                </p>
                                <div>
                                    <span id="preview_about_btn" class="inline-flex items-center gap-1 text-xs font-semibold text-blue-600 hover:text-blue-800">
                                        Read More <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end">
                            <button onclick="saveSection('about')" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs rounded-lg transition shadow-sm flex items-center gap-2">
                                <i data-lucide="check" class="w-4 h-4"></i>
                                <span>অ্যাবাউট সেকশন সেভ করুন</span>
                            </button>
                        </div>
                    </div>
                </section>

                <!-- 4. WHY CHOOSE US / VALUES TAB -->
                <section id="tab-whychoose" class="tab-content hidden space-y-6">
                    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                        <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100">
                            <div>
                                <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                                    <i data-lucide="shield-check" class="w-5 h-5 text-blue-600"></i>
                                    কেন আমাদের বাছবেন (Why Choose Us Cards)
                                </h3>
                                <p class="text-xs text-slate-500">৩ টি মূল মূল্যের (Value Proposition) কার্ড এডিট করুন</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <!-- Card 1 -->
                            <div class="p-4 border border-slate-200 rounded-xl bg-slate-50 space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-bold text-blue-600">কার্ড #১</span>
                                    <i data-lucide="cog" class="w-4 h-4 text-slate-400"></i>
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-700 mb-1">টাইটেল</label>
                                    <input type="text" value="Complete ISP Automation" class="w-full px-3 py-2 text-xs rounded border border-slate-300">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-700 mb-1">বিবরণ</label>
                                    <textarea rows="3" class="w-full px-3 py-2 text-xs rounded border border-slate-300">Automate customer billing, MikroTik management, invoice generation, service activation, suspension, and bandwidth control.</textarea>
                                </div>
                            </div>

                            <!-- Card 2 -->
                            <div class="p-4 border border-slate-200 rounded-xl bg-slate-50 space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-bold text-blue-600">কার্ড #২</span>
                                    <i data-lucide="activity" class="w-4 h-4 text-slate-400"></i>
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-700 mb-1">টাইটেল</label>
                                    <input type="text" value="Advanced Network Monitoring" class="w-full px-3 py-2 text-xs rounded border border-slate-300">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-700 mb-1">বিবরণ</label>
                                    <textarea rows="3" class="w-full px-3 py-2 text-xs rounded border border-slate-300">Monitor OLTs, ONUs, customer connectivity, optical power, bandwidth usage, and network performance in real time.</textarea>
                                </div>
                            </div>

                            <!-- Card 3 -->
                            <div class="p-4 border border-slate-200 rounded-xl bg-slate-50 space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-bold text-blue-600">কার্ড #৩</span>
                                    <i data-lucide="lock" class="w-4 h-4 text-slate-400"></i>
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-700 mb-1">টাইটেল</label>
                                    <input type="text" value="Scalable & Secure Platform" class="w-full px-3 py-2 text-xs rounded border border-slate-300">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-700 mb-1">বিবরণ</label>
                                    <textarea rows="3" class="w-full px-3 py-2 text-xs rounded border border-slate-300">Designed with Multi-Tenant architecture, role-based access control, secure data management, and cloud deployment.</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end">
                            <button onclick="saveSection('whychoose')" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs rounded-lg transition shadow-sm flex items-center gap-2">
                                <i data-lucide="check" class="w-4 h-4"></i>
                                <span>পরিবর্তন সেভ করুন</span>
                            </button>
                        </div>
                    </div>
                </section>

                <!-- 5. FEATURES & SOLUTIONS TAB -->
                <section id="tab-features" class="tab-content hidden space-y-6">
                    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                        <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100">
                            <div>
                                <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                                    <i data-lucide="cpu" class="w-5 h-5 text-blue-600"></i>
                                    আইএসপি ফিচারস ও সলিউশনস (Features List)
                                </h3>
                                <p class="text-xs text-slate-500">আপনার সফটওয়্যারের মূল ফিচার বা মডিউলগুলো পরিচালনা করুন</p>
                            </div>
                            <button onclick="addNewFeatureItem()" class="px-3.5 py-2 bg-blue-50 text-blue-600 hover:bg-blue-100 font-medium text-xs rounded-lg transition flex items-center gap-1.5 border border-blue-200">
                                <i data-lucide="plus" class="w-4 h-4"></i> নতুন ফিচার যোগ করুন
                            </button>
                        </div>

                        <div id="featuresListContainer" class="space-y-4">
                            <!-- Feature 1 -->
                            <div class="p-4 border border-slate-200 rounded-xl bg-slate-50 flex items-start gap-4">
                                <div class="w-9 h-9 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 mt-1">
                                    <i data-lucide="router" class="w-5 h-5"></i>
                                </div>
                                <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">ফিচার টাইটেল</label>
                                        <input type="text" value="MikroTik Automation" class="w-full px-3 py-1.5 text-xs rounded border border-slate-300">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">সংক্ষিপ্ত বিবরণ</label>
                                        <input type="text" value="Manage PPPoE users, profiles, queues, and customer connections directly." class="w-full px-3 py-1.5 text-xs rounded border border-slate-300">
                                    </div>
                                </div>
                                <button onclick="this.closest('.flex').remove()" class="text-slate-400 hover:text-rose-600 p-1 mt-1">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>

                            <!-- Feature 2 -->
                            <div class="p-4 border border-slate-200 rounded-xl bg-slate-50 flex items-start gap-4">
                                <div class="w-9 h-9 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 mt-1">
                                    <i data-lucide="network" class="w-5 h-5"></i>
                                </div>
                                <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">ফিচার টাইটেল</label>
                                        <input type="text" value="OLT & ONU Management" class="w-full px-3 py-1.5 text-xs rounded border border-slate-300">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">সংক্ষিপ্ত বিবরণ</label>
                                        <input type="text" value="Monitor EPON & GPON devices, optical power, MAC address, VLAN, and ONU status." class="w-full px-3 py-1.5 text-xs rounded border border-slate-300">
                                    </div>
                                </div>
                                <button onclick="this.closest('.flex').remove()" class="text-slate-400 hover:text-rose-600 p-1 mt-1">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>

                            <!-- Feature 3 -->
                            <div class="p-4 border border-slate-200 rounded-xl bg-slate-50 flex items-start gap-4">
                                <div class="w-9 h-9 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center shrink-0 mt-1">
                                    <i data-lucide="credit-card" class="w-5 h-5"></i>
                                </div>
                                <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">ফিচার টাইটেল</label>
                                        <input type="text" value="Online Payment Gateway" class="w-full px-3 py-1.5 text-xs rounded border border-slate-300">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">সংক্ষিপ্ত বিবরণ</label>
                                        <input type="text" value="Accept payments through SSLCommerz, bKash, Nagad, Rocket and auto recharge." class="w-full px-3 py-1.5 text-xs rounded border border-slate-300">
                                    </div>
                                </div>
                                <button onclick="this.closest('.flex').remove()" class="text-slate-400 hover:text-rose-600 p-1 mt-1">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end">
                            <button onclick="saveSection('features')" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs rounded-lg transition shadow-sm flex items-center gap-2">
                                <i data-lucide="check" class="w-4 h-4"></i>
                                <span>ফিচার লিস্ট সেভ করুন</span>
                            </button>
                        </div>
                    </div>
                </section>

                <!-- 6. PRICING PLANS TAB -->
                <section id="tab-pricing" class="tab-content hidden space-y-6">
                    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                        <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100">
                            <div>
                                <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                                    <i data-lucide="badge-dollar-sign" class="w-5 h-5 text-blue-600"></i>
                                    প্রাইসিং প্ল্যান ম্যানেজমেন্ট (Pricing Packages)
                                </h3>
                                <p class="text-xs text-slate-500">আপনার সফটওয়্যারের প্যাকেজ রেট, ডিসকাউন্ট ও সুবিধা সংজ্ঞায়িত করুন</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Basic Plan -->
                            <div class="p-5 border border-slate-200 rounded-xl bg-white shadow-sm space-y-4">
                                <div class="flex items-center justify-between border-b pb-3">
                                    <h4 class="font-bold text-slate-800 text-sm">Basic Plan</h4>
                                    <span class="text-xs bg-slate-100 text-slate-600 px-2 py-0.5 rounded">Starter</span>
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-700 mb-1">ওয়ান-টাইম সেটআপ ফি</label>
                                    <input type="text" value="৳ 2,000" class="w-full px-3 py-1.5 text-xs rounded border border-slate-300 font-semibold text-slate-800">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-[11px] font-semibold text-slate-700">ইউজার রেট স্ল্যাব (Monthly Fee)</label>
                                    <div class="flex justify-between items-center text-xs bg-slate-50 p-2 rounded border border-slate-200">
                                        <span>1 - 300 Users</span>
                                        <input type="text" value="৳1,000 / mo" class="w-24 px-2 py-1 text-right text-xs rounded border border-slate-300">
                                    </div>
                                    <div class="flex justify-between items-center text-xs bg-slate-50 p-2 rounded border border-slate-200">
                                        <span>301 - 500 Users</span>
                                        <input type="text" value="৳1,500 / mo" class="w-24 px-2 py-1 text-right text-xs rounded border border-slate-300">
                                    </div>
                                </div>
                            </div>

                            <!-- Standard Plan -->
                            <div class="p-5 border-2 border-blue-500 rounded-xl bg-blue-50/20 shadow-sm space-y-4 relative">
                                <span class="absolute -top-3 right-4 bg-blue-600 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase">Most Popular</span>
                                <div class="flex items-center justify-between border-b border-blue-200 pb-3">
                                    <h4 class="font-bold text-blue-900 text-sm">Professional Plan</h4>
                                    <span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded font-medium">Growth</span>
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-700 mb-1">ওয়ান-টাইম সেটআপ ফি</label>
                                    <input type="text" value="৳ 3,500" class="w-full px-3 py-1.5 text-xs rounded border border-slate-300 font-semibold text-slate-800">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-[11px] font-semibold text-slate-700">ইউজার রেট স্ল্যাব (Monthly Fee)</label>
                                    <div class="flex justify-between items-center text-xs bg-white p-2 rounded border border-blue-200">
                                        <span>501 - 1000 Users</span>
                                        <input type="text" value="৳2,500 / mo" class="w-24 px-2 py-1 text-right text-xs rounded border border-slate-300">
                                    </div>
                                    <div class="flex justify-between items-center text-xs bg-white p-2 rounded border border-blue-200">
                                        <span>1001 - 2000 Users</span>
                                        <input type="text" value="৳4,000 / mo" class="w-24 px-2 py-1 text-right text-xs rounded border border-slate-300">
                                    </div>
                                </div>
                            </div>

                            <!-- Enterprise Plan -->
                            <div class="p-5 border border-slate-200 rounded-xl bg-white shadow-sm space-y-4">
                                <div class="flex items-center justify-between border-b pb-3">
                                    <h4 class="font-bold text-slate-800 text-sm">Enterprise Plan</h4>
                                    <span class="text-xs bg-purple-100 text-purple-700 px-2 py-0.5 rounded">Unlimited</span>
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-700 mb-1">ওয়ান-টাইম সেটআপ ফি</label>
                                    <input type="text" value="Custom Quote" class="w-full px-3 py-1.5 text-xs rounded border border-slate-300 font-semibold text-slate-800">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-[11px] font-semibold text-slate-700">বৈশিষ্ট্যসমূহ</label>
                                    <p class="text-xs text-slate-500 bg-slate-50 p-3 rounded border border-slate-200 leading-relaxed">
                                        Dedicated Cloud Server, Multi-POP Setup, Custom Payment Gateways, Priority 24/7 Phone Support.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end">
                            <button onclick="saveSection('pricing')" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs rounded-lg transition shadow-sm flex items-center gap-2">
                                <i data-lucide="check" class="w-4 h-4"></i>
                                <span>প্রাইসিং ডাটা সেভ করুন</span>
                            </button>
                        </div>
                    </div>
                </section>

                <!-- 7. TEAM MEMBERS TAB -->
                <section id="tab-team" class="tab-content hidden space-y-6">
                    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                        <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100">
                            <div>
                                <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                                    <i data-lucide="users" class="w-5 h-5 text-blue-600"></i>
                                    টিম মেম্বারস (Our Team Members)
                                </h3>
                                <p class="text-xs text-slate-500">আপনার কোম্পানির টিমের সদস্য ও ডেজিগনেশন এডিট বা যোগ করুন</p>
                            </div>
                            <button onclick="addNewTeamMember()" class="px-3.5 py-2 bg-blue-50 text-blue-600 hover:bg-blue-100 font-medium text-xs rounded-lg transition flex items-center gap-1.5 border border-blue-200">
                                <i data-lucide="user-plus" class="w-4 h-4"></i> নতুন মেম্বার যোগ করুন
                            </button>
                        </div>

                        <div id="teamGridContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                            <!-- Member 1 -->
                            <div class="p-4 border border-slate-200 rounded-xl bg-slate-50 flex flex-col justify-between space-y-3">
                                <div class="flex items-center gap-3">
                                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=120" class="w-12 h-12 rounded-full object-cover border-2 border-blue-500">
                                    <div class="flex-1 min-w-0">
                                        <input type="text" value="Rakib Mahmud" class="w-full text-xs font-bold text-slate-800 bg-transparent border-b border-slate-300 pb-0.5 focus:border-blue-600 outline-none">
                                        <input type="text" value="Software Developer & Lead Architect" class="w-full text-[11px] text-slate-500 bg-transparent border-b border-slate-300 pt-0.5 outline-none">
                                    </div>
                                </div>
                                <div class="flex justify-between items-center text-xs text-slate-500 pt-2 border-t border-slate-200">
                                    <span>Status: Active</span>
                                    <button onclick="this.closest('.p-4').remove()" class="text-rose-500 hover:underline text-[11px] flex items-center gap-1">
                                        <i data-lucide="trash" class="w-3.5 h-3.5"></i> রিমুভ
                                    </button>
                                </div>
                            </div>

                            <!-- Member 2 -->
                            <div class="p-4 border border-slate-200 rounded-xl bg-slate-50 flex flex-col justify-between space-y-3">
                                <div class="flex items-center gap-3">
                                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=120" class="w-12 h-12 rounded-full object-cover border-2 border-slate-300">
                                    <div class="flex-1 min-w-0">
                                        <input type="text" value="Tanvir Ahmed" class="w-full text-xs font-bold text-slate-800 bg-transparent border-b border-slate-300 pb-0.5 focus:border-blue-600 outline-none">
                                        <input type="text" value="Network Systems Specialist" class="w-full text-[11px] text-slate-500 bg-transparent border-b border-slate-300 pt-0.5 outline-none">
                                    </div>
                                </div>
                                <div class="flex justify-between items-center text-xs text-slate-500 pt-2 border-t border-slate-200">
                                    <span>Status: Active</span>
                                    <button onclick="this.closest('.p-4').remove()" class="text-rose-500 hover:underline text-[11px] flex items-center gap-1">
                                        <i data-lucide="trash" class="w-3.5 h-3.5"></i> রিমুভ
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end">
                            <button onclick="saveSection('team')" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs rounded-lg transition shadow-sm flex items-center gap-2">
                                <i data-lucide="check" class="w-4 h-4"></i>
                                <span>টিম লিস্ট সেভ করুন</span>
                            </button>
                        </div>
                    </div>
                </section>

                <!-- 8. CONTACT & FOOTER TAB -->
                <section id="tab-contact" class="tab-content hidden space-y-6">
                    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                        <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100">
                            <div>
                                <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                                    <i data-lucide="phone-call" class="w-5 h-5 text-blue-600"></i>
                                    যোগাযোগ ও ফুটার তথ্য (Contact & Footer Settings)
                                </h3>
                                <p class="text-xs text-slate-500">ফোন নম্বর, ইমেইল, অফিস এড্রেস এবং সোশ্যাল মিডিয়া লিংক কনফিগার করুন</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">অফিসিয়াল মোবাইল / ফোন</label>
                                    <input type="text" value="+880 1700-000000" class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300">
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">অফিসিয়াল সাপোর্ট ইমেইল</label>
                                    <input type="email" value="info@nexuscloudsoft.com" class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300">
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">অফিসের ঠিকানা (Office Address)</label>
                                    <textarea rows="2" class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300">Gulshan 2, Dhaka - 1212, Bangladesh</textarea>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">ফেসবুক পেজ লিংক</label>
                                    <input type="text" value="https://facebook.com/nexuscloudsoft" class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300">
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">ইউটিউব চ্যানেল লিংক</label>
                                    <input type="text" value="https://youtube.com/nexuscloudsoft" class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300">
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">ফুটার কপিরাইট টেক্সট</label>
                                    <input type="text" value="© 2026 Nexus Cloud Soft. All Rights Reserved." class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300">
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end">
                            <button onclick="saveSection('contact')" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs rounded-lg transition shadow-sm flex items-center gap-2">
                                <i data-lucide="check" class="w-4 h-4"></i>
                                <span>কন্টাক্ট সেটিংস সেভ করুন</span>
                            </button>
                        </div>
                    </div>
                </section>

                <!-- 9. DEMO REQUESTS / LEADS TAB -->
                <section id="tab-demorequests" class="tab-content hidden space-y-6">
                    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                        <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100">
                            <div>
                                <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                                    <i data-lucide="inbox" class="w-5 h-5 text-blue-600"></i>
                                    ইনকামিং ডেমো রিকোয়েস্ট (Demo Requests & Leads)
                                </h3>
                                <p class="text-xs text-slate-500">nexuscloudsoft.com থেকে আসা লেটেস্ট ক্লায়েন্ট আবেদনগুলোর তালিকা</p>
                            </div>
                            <button onclick="showToast('CSV এক্সপোর্ট সম্পন্ন হয়েছে', 'info')" class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium text-xs rounded-lg transition flex items-center gap-1.5 border border-slate-300">
                                <i data-lucide="download" class="w-4 h-4"></i> এক্সপোর্ট Excel/CSV
                            </button>
                        </div>

                        <div class="overflow-x-auto border border-slate-200 rounded-xl">
                            <table class="w-full text-left text-xs">
                                <thead class="bg-slate-50 text-slate-600 border-b border-slate-200 font-semibold">
                                    <tr>
                                        <th class="p-3.5">আইএসপি কোম্পানির নাম</th>
                                        <th class="p-3.5">যোগাযোগকারী নাম</th>
                                        <th class="p-3.5">মোবাইল নম্বর</th>
                                        <th class="p-3.5">ইউজার সংখ্যা</th>
                                        <th class="p-3.5">তারিখ</th>
                                        <th class="p-3.5">স্ট্যাটাস</th>
                                        <th class="p-3.5 text-right">অ্যাকশন</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 text-slate-700">
                                    <tr class="hover:bg-slate-50/80">
                                        <td class="p-3.5 font-bold text-slate-900">CyberNet Online ISP</td>
                                        <td class="p-3.5">মোঃ সাইফুল ইসলাম</td>
                                        <td class="p-3.5 font-mono">01711-223344</td>
                                        <td class="p-3.5">750 Active Users</td>
                                        <td class="p-3.5 text-slate-500">২১ সেপ, ২০২৬</td>
                                        <td class="p-3.5"><span class="bg-amber-100 text-amber-800 px-2 py-0.5 rounded text-[10px] font-semibold">New Request</span></td>
                                        <td class="p-3.5 text-right flex justify-end gap-2">
                                            <button onclick="showToast('কল করার জন্য চিহ্নিত করা হয়েছে', 'success')" class="px-2.5 py-1 bg-blue-600 text-white rounded text-[11px] font-medium">কল দিন</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-slate-50/80">
                                        <td class="p-3.5 font-bold text-slate-900">Dhaka BroadBand Ltd.</td>
                                        <td class="p-3.5">আরিফুল হক</td>
                                        <td class="p-3.5 font-mono">01822-998877</td>
                                        <td class="p-3.5">1,200 Active Users</td>
                                        <td class="p-3.5 text-slate-500">২০ সেপ, ২০২৬</td>
                                        <td class="p-3.5"><span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded text-[10px] font-semibold">Contacted</span></td>
                                        <td class="p-3.5 text-right flex justify-end gap-2">
                                            <button class="px-2.5 py-1 bg-slate-200 text-slate-700 rounded text-[11px] font-medium">ডিটেইলস</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-slate-50/80">
                                        <td class="p-3.5 font-bold text-slate-900">SpeedMax Network</td>
                                        <td class="p-3.5">হাসান মাহমুদ</td>
                                        <td class="p-3.5 font-mono">01911-556677</td>
                                        <td class="p-3.5">400 Active Users</td>
                                        <td class="p-3.5 text-slate-500">১৯ সেপ, ২০২৬</td>
                                        <td class="p-3.5"><span class="bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded text-[10px] font-semibold">Demo Given</span></td>
                                        <td class="p-3.5 text-right flex justify-end gap-2">
                                            <button class="px-2.5 py-1 bg-slate-200 text-slate-700 rounded text-[11px] font-medium">ডিটেইলস</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <!-- 10. SETTINGS TAB -->
                <section id="tab-settings" class="tab-content hidden space-y-6">
                    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                        <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100">
                            <div>
                                <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                                    <i data-lucide="sliders" class="w-5 h-5 text-blue-600"></i>
                                    লোগো, ব্র্যান্ডিং ও SEO সেটিংস
                                </h3>
                                <p class="text-xs text-slate-500">ওয়েবসাইটের টাইটেল, মেটা ডেসক্রিপশন ও সার্চ ইঞ্জিন সেটিংস</p>
                            </div>
                        </div>

                        <div class="space-y-4 max-w-xl">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">ওয়েবসাইট টাইটেল (SEO Title)</label>
                                <input type="text" value="Nexus Cloud Soft - One Powerful Platform for ISP Billing & Network Management" class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">মেটা ডেসক্রিপশন (Meta Description)</label>
                                <textarea rows="3" class="w-full px-3.5 py-2 text-sm rounded-lg border border-slate-300">Manage customers, automate billing, monitor MikroTik & OLT devices, accept online payments with Nexus Cloud Soft ISP ERP solution.</textarea>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">কোম্পানির লোগো (Header Logo)</label>
                                <div class="flex items-center gap-4 p-3 border border-slate-200 rounded-lg bg-slate-50">
                                    <div class="w-12 h-12 rounded bg-slate-900 flex items-center justify-center text-white font-bold text-lg">
                                        NCS
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-slate-800">logo.png (320x80 px)</p>
                                        <button onclick="showToast('নতুন লোগো আপলোড করা হয়েছে', 'success')" class="text-xs text-blue-600 font-semibold hover:underline mt-0.5">লোগো পরিবর্তন করুন</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end">
                            <button onclick="saveSection('settings')" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium text-xs rounded-lg transition shadow-sm flex items-center gap-2">
                                <i data-lucide="check" class="w-4 h-4"></i>
                                <span>সেটিংস সেভ করুন</span>
                            </button>
                        </div>
                    </div>
                </section>

            </main>
        </div>
    </div>

    <!-- Live Preview Modal -->
    <div id="previewModal" class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-4xl h-[85vh] flex flex-col shadow-2xl overflow-hidden border border-slate-200">
            <div class="px-6 py-4 bg-slate-900 text-white flex items-center justify-between border-b border-slate-800">
                <div class="flex items-center gap-3">
                    <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                    <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                    <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                    <span class="text-xs font-mono text-slate-400 ml-2">https://nexuscloudsoft.com (Interactive Preview)</span>
                </div>
                <button onclick="toggleLivePreviewModal()" class="text-slate-400 hover:text-white p-1">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-8 space-y-12 custom-scrollbar bg-slate-50">
                <!-- Preview Header -->
                <div class="flex items-center justify-between pb-6 border-b">
                    <div class="text-xl font-black text-blue-900 tracking-wider">NEXUS CLOUD SOFT</div>
                    <div class="flex gap-4 text-xs font-semibold text-slate-600">
                        <span>Home</span>
                        <span>About</span>
                        <span>Services</span>
                        <span>Pricing</span>
                        <span class="bg-blue-600 text-white px-3 py-1 rounded">Demo Request</span>
                    </div>
                </div>

                <!-- Preview Hero -->
                <div class="text-center max-w-2xl mx-auto space-y-4 py-6">
                    <h1 id="modal_hero_title" class="text-3xl font-extrabold text-slate-900">
                        Simplify Your ISP Business with One Powerful Platform
                    </h1>
                    <p id="modal_hero_subtitle" class="text-sm text-slate-600 leading-relaxed">
                        Manage customers, automate billing, monitor MikroTik & OLT devices, accept online payments, generate real-time reports.
                    </p>
                    <div class="flex justify-center gap-3 pt-2">
                        <button id="modal_hero_cta1" class="px-5 py-2.5 bg-blue-600 text-white font-semibold text-xs rounded-lg shadow-lg shadow-blue-500/30">Get Started</button>
                        <button id="modal_hero_cta2" class="px-5 py-2.5 bg-white border border-slate-300 text-slate-700 font-semibold text-xs rounded-lg">Watch Video</button>
                    </div>
                </div>

                <!-- Preview About -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 grid grid-cols-2 gap-6 items-center">
                    <div>
                        <span id="modal_about_sub" class="text-xs font-bold text-blue-600">WHO WE ARE</span>
                        <h2 id="modal_about_title" class="text-xl font-bold text-slate-900 mt-1">We Are a Team of Innovators Dedicated to Empowering Your Brand</h2>
                        <p id="modal_about_desc" class="text-xs text-slate-500 mt-2 leading-relaxed">We combine strategy, creativity, and technology to help your business thrive...</p>
                    </div>
                    <div class="bg-slate-100 h-40 rounded-xl flex items-center justify-center text-slate-400 text-xs font-mono">
                        [ About Image Placeholder ]
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Logic -->
    <script>
        // Initialize Lucide Icons
        lucide.createIcons();

        // Real-time Preview Sync for Hero Section
        const heroTitleInput = document.getElementById('hero_title');
        const heroSubtitleInput = document.getElementById('hero_subtitle');
        const heroCta1Input = document.getElementById('hero_cta1_text');
        const heroCta2Input = document.getElementById('hero_cta2_text');

        function syncHeroPreview() {
            if(heroTitleInput) {
                document.getElementById('preview_hero_title').innerText = heroTitleInput.value;
                document.getElementById('modal_hero_title').innerText = heroTitleInput.value;
            }
            if(heroSubtitleInput) {
                document.getElementById('preview_hero_subtitle').innerText = heroSubtitleInput.value;
                document.getElementById('modal_hero_subtitle').innerText = heroSubtitleInput.value;
            }
            if(heroCta1Input) {
                document.getElementById('preview_hero_cta1').innerText = heroCta1Input.value;
                document.getElementById('modal_hero_cta1').innerText = heroCta1Input.value;
            }
            if(heroCta2Input) {
                document.getElementById('preview_hero_cta2').innerText = heroCta2Input.value;
                document.getElementById('modal_hero_cta2').innerText = heroCta2Input.value;
            }
        }

        if(heroTitleInput) heroTitleInput.addEventListener('input', syncHeroPreview);
        if(heroSubtitleInput) heroSubtitleInput.addEventListener('input', syncHeroPreview);
        if(heroCta1Input) heroCta1Input.addEventListener('input', syncHeroPreview);
        if(heroCta2Input) heroCta2Input.addEventListener('input', syncHeroPreview);

        // Real-time Sync for About Section
        const aboutSubInput = document.getElementById('about_sub');
        const aboutTitleInput = document.getElementById('about_title');
        const aboutDescInput = document.getElementById('about_desc');
        const aboutBtnInput = document.getElementById('about_btn_text');

        function syncAboutPreview() {
            if(aboutSubInput) {
                document.getElementById('preview_about_sub').innerText = aboutSubInput.value;
                document.getElementById('modal_about_sub').innerText = aboutSubInput.value;
            }
            if(aboutTitleInput) {
                document.getElementById('preview_about_title').innerText = aboutTitleInput.value;
                document.getElementById('modal_about_title').innerText = aboutTitleInput.value;
            }
            if(aboutDescInput) {
                document.getElementById('preview_about_desc').innerText = aboutDescInput.value;
                document.getElementById('modal_about_desc').innerText = aboutDescInput.value;
            }
            if(aboutBtnInput) {
                document.getElementById('preview_about_btn').innerHTML = aboutBtnInput.value + ' <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>';
                lucide.createIcons();
            }
        }

        if(aboutSubInput) aboutSubInput.addEventListener('input', syncAboutPreview);
        if(aboutTitleInput) aboutTitleInput.addEventListener('input', syncAboutPreview);
        if(aboutDescInput) aboutDescInput.addEventListener('input', syncAboutPreview);
        if(aboutBtnInput) aboutBtnInput.addEventListener('input', syncAboutPreview);

        // Tab Switching Logic
        function switchTab(tabId) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            
            // Show selected tab content
            const targetTab = document.getElementById('tab-' + tabId);
            if(targetTab) targetTab.classList.remove('hidden');

            // Reset navigation active state
            document.querySelectorAll('.nav-item').forEach(el => {
                el.classList.remove('bg-blue-600', 'text-white', 'shadow-sm');
                el.classList.add('hover:bg-slate-800', 'hover:text-white', 'text-slate-400');
            });

            // Set active state on clicked nav link
            const activeNav = document.getElementById('nav-' + tabId);
            if(activeNav) {
                activeNav.classList.add('bg-blue-600', 'text-white', 'shadow-sm');
                activeNav.classList.remove('hover:bg-slate-800', 'hover:text-white', 'text-slate-400');
            }

            // Update page title
            const titles = {
                'overview': 'ওয়েবসাইট কনটেন্ট ম্যানেজমেন্ট ড্যাশবোর্ড',
                'hero': 'হিরো সেকশন কনফিগারেশন',
                'about': 'আমাদের সম্পর্কে (About Us) কনফিগ',
                'whychoose': 'কেন আমাদের বাছবেন (Values)',
                'features': 'ফিচারস ও সফটওয়্যার সলিউশনস',
                'pricing': 'প্রাইসিং প্যাকেজ ম্যানেজমেন্ট',
                'team': 'টিম মেম্বারস ম্যানেজমেন্ট',
                'contact': 'যোগাযোগ ও ফুটার সেটিংস',
                'demorequests': 'ইনকামিং ডেমো রিকোয়েস্ট (Leads)',
                'settings': 'লোগো ও SEO সেটিংস'
            };

            if(titles[tabId]) {
                document.getElementById('pageTitle').innerText = titles[tabId];
            }
        }

        // Dynamic Add Feature
        function addNewFeatureItem() {
            const container = document.getElementById('featuresListContainer');
            const newElem = document.createElement('div');
            newElem.className = 'p-4 border border-slate-200 rounded-xl bg-slate-50 flex items-start gap-4';
            newElem.innerHTML = `
                <div class="w-9 h-9 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 mt-1">
                    <i data-lucide="star" class="w-5 h-5"></i>
                </div>
                <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">ফিচার টাইটেল</label>
                        <input type="text" placeholder="নতুন ফিচার নাম" class="w-full px-3 py-1.5 text-xs rounded border border-slate-300">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">সংক্ষিপ্ত বিবরণ</label>
                        <input type="text" placeholder="ফিচারের বিবরণ লিখুন" class="w-full px-3 py-1.5 text-xs rounded border border-slate-300">
                    </div>
                </div>
                <button onclick="this.closest('.flex').remove()" class="text-slate-400 hover:text-rose-600 p-1 mt-1">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
            `;
            container.appendChild(newElem);
            lucide.createIcons();
            showToast('নতুন ফিচার যুক্ত করা হয়েছে', 'info');
        }

        // Dynamic Add Team Member
        function addNewTeamMember() {
            const container = document.getElementById('teamGridContainer');
            const newElem = document.createElement('div');
            newElem.className = 'p-4 border border-slate-200 rounded-xl bg-slate-50 flex flex-col justify-between space-y-3';
            newElem.innerHTML = `
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 shrink-0">
                        <i data-lucide="user" class="w-6 h-6"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <input type="text" placeholder="সদস্যের নাম" class="w-full text-xs font-bold text-slate-800 bg-transparent border-b border-slate-300 pb-0.5 focus:border-blue-600 outline-none">
                        <input type="text" placeholder="পদবি / Designation" class="w-full text-[11px] text-slate-500 bg-transparent border-b border-slate-300 pt-0.5 outline-none">
                    </div>
                </div>
                <div class="flex justify-between items-center text-xs text-slate-500 pt-2 border-t border-slate-200">
                    <span>Status: New</span>
                    <button onclick="this.closest('.p-4').remove()" class="text-rose-500 hover:underline text-[11px] flex items-center gap-1">
                        <i data-lucide="trash" class="w-3.5 h-3.5"></i> রিমুভ
                    </button>
                </div>
            `;
            container.appendChild(newElem);
            lucide.createIcons();
            showToast('নতুন টিম মেম্বার যুক্ত করা হয়েছে', 'info');
        }

        // Toast Notification System
        function showToast(message, type = 'success') {
            const toastContainer = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `px-4 py-3 rounded-xl shadow-lg text-xs font-semibold flex items-center gap-2.5 transition-all transform translate-y-2 pointer-events-auto border ${
                type === 'success' ? 'bg-emerald-900 text-emerald-100 border-emerald-700' :
                type === 'info' ? 'bg-slate-900 text-white border-slate-700' :
                'bg-rose-900 text-rose-100 border-rose-700'
            }`;

            const iconName = type === 'success' ? 'check-circle' : type === 'info' ? 'info' : 'alert-circle';
            toast.innerHTML = `<i data-lucide="${iconName}" class="w-4 h-4"></i> <span>${message}</span>`;
            
            toastContainer.appendChild(toast);
            lucide.createIcons();

            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-[-10px]');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Save Functionality Simulation
        function saveSection(sectionName) {
            showToast(`${sectionName.toUpperCase()} সেকশন সফলভাবে আপডেট করা হয়েছে!`, 'success');
        }

        function saveAllChanges() {
            showToast('সবগুলো সেকশনের তথ্য লাইভ ওয়েবসাইটে আপডেট করা হয়েছে!', 'success');
        }

        // Live Preview Modal Toggle
        function toggleLivePreviewModal() {
            const modal = document.getElementById('previewModal');
            modal.classList.toggle('hidden');
        }

        // Sidebar Toggle for Mobile
        document.getElementById('sidebarToggle').addEventListener('click', () => {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
            sidebar.classList.toggle('w-0');
        });
    </script>
</body>
</html>