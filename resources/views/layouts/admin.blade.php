<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ovatify Admin — @yield('title', 'Dashboard')</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        .admin-sidebar-item.active {
            background: linear-gradient(90deg, rgba(255, 0, 255, 0.12) 0%, rgba(255, 0, 255, 0) 100%);
            border-left: 3px solid #FF00FF;
            color: #FF00FF;
        }
        .admin-card { background: #252525; border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 16px; }
        .glass-panel { background: rgba(37, 37, 37, 0.7); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.1); }
        .stat-card { transition: transform 0.2s ease, border-color 0.2s ease; }
        .stat-card:hover { transform: translateY(-2px); border-color: rgba(255, 0, 255, 0.3); }
        .table-row:hover { background: rgba(255, 255, 255, 0.02); }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #1A1A1A; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #444; }
    </style>
    @stack('head')
</head>

<body class="bg-[#1A1A1A] text-white font-inter">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 h-screen sticky top-0 flex-shrink-0 z-40 border-r border-white/5 bg-[#1A1A1A] overflow-y-auto">
            <div class="p-6">
                <a href="{{ route('admin.dashboard') }}" class="block mb-8">
                    <h1 class="text-[24px] font-bold text-accent tracking-tight">Ovatify</h1>
                    <span class="text-[10px] font-medium text-white/40 uppercase tracking-widest block mt-1">Admin Panel</span>
                </a>

                <nav class="space-y-0.5">
                    {{-- OVERVIEW --}}
                    <div class="text-[10px] uppercase tracking-widest text-white/30 px-4 mb-2 mt-2">Overview</div>
                    @include('admin.partials.nav-item', ['route' => 'admin.dashboard', 'icon' => 'fa-chart-line', 'label' => 'Dashboard'])

                    {{-- PEOPLE --}}
                    <div class="text-[10px] uppercase tracking-widest text-white/30 px-4 mb-2 mt-6">People</div>
                    @include('admin.partials.nav-item', ['route' => 'admin.users', 'icon' => 'fa-users', 'label' => 'Users'])
                    @include('admin.partials.nav-item', ['route' => 'admin.creators', 'icon' => 'fa-microphone-lines', 'label' => 'Creators'])

                    {{-- CONTENT --}}
                    <div class="text-[10px] uppercase tracking-widest text-white/30 px-4 mb-2 mt-6">Content</div>
                    @include('admin.partials.nav-item', ['route' => 'admin.tracks', 'icon' => 'fa-music', 'label' => 'Tracks & Media'])
                    @include('admin.partials.nav-item', ['route' => 'admin.sessions', 'icon' => 'fa-pen-ruler', 'label' => 'Creator Sessions'])
                    @include('admin.partials.nav-item', ['route' => 'admin.ai-tasks', 'icon' => 'fa-wand-magic-sparkles', 'label' => 'AI Tasks'])

                    {{-- MARKETPLACE --}}
                    <div class="text-[10px] uppercase tracking-widest text-white/30 px-4 mb-2 mt-6">Marketplace</div>
                    @include('admin.partials.nav-item', ['route' => 'admin.transactions', 'icon' => 'fa-cart-shopping', 'label' => 'Transactions'])
                    @include('admin.partials.nav-item', ['route' => 'admin.distributions', 'icon' => 'fa-tower-broadcast', 'label' => 'Distributions'])
                    @include('admin.partials.nav-item', ['route' => 'admin.collab-requests', 'icon' => 'fa-handshake', 'label' => 'Collab Requests'])
                    @include('admin.partials.nav-item', ['route' => 'admin.financials', 'icon' => 'fa-wallet', 'label' => 'Financials'])

                    {{-- SYSTEM --}}
                    <div class="text-[10px] uppercase tracking-widest text-white/30 px-4 mb-2 mt-6">System</div>
                    @include('admin.partials.nav-item', ['route' => 'admin.site-content', 'icon' => 'fa-pen-to-square', 'label' => 'Site Content'])
                    @include('admin.partials.nav-item', ['route' => 'admin.lookups', 'icon' => 'fa-tags', 'label' => 'Lookup Data'])
                    @include('admin.partials.nav-item', ['route' => 'admin.settings', 'icon' => 'fa-gear', 'label' => 'Settings'])
                </nav>
            </div>

            <div class="p-6 mt-6 border-t border-white/5">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 text-gray-500 hover:text-white transition-colors text-sm w-full">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main --}}
        <main class="flex-1 min-w-0 overflow-y-auto min-h-screen">
            {{-- Top Header --}}
            <header class="h-20 border-b border-white/5 px-8 flex items-center justify-between sticky top-0 bg-[#1A1A1A]/90 backdrop-blur-md z-30">
                <h2 class="text-xl font-semibold">@yield('page_title', 'Dashboard')</h2>

                <div class="flex items-center gap-6">
                    <div class="relative cursor-pointer text-gray-400 hover:text-white transition-colors">
                        <i class="fa-solid fa-bell"></i>
                        <span class="absolute -top-1 -right-1 w-2 h-2 bg-accent rounded-full"></span>
                    </div>

                    <div class="flex items-center gap-3 pl-6 border-l border-white/10">
                        <div class="text-right">
                            <p class="text-sm font-medium">{{ auth()->user()?->username ?? 'Admin' }}</p>
                            <p class="text-[10px] text-magenta uppercase tracking-wider font-bold">Administrator</p>
                        </div>
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()?->username ?? 'Admin') }}&background=FF00FF&color=fff" class="w-10 h-10 rounded-full border border-accent/20" alt="Admin">
                    </div>
                </div>
            </header>

            {{-- Content --}}
            <div class="p-8">
                @if(session('success'))
                    <div class="mb-6 bg-green-500/10 border border-green-500/20 text-green-500 px-4 py-3 rounded-xl flex justify-between items-center" x-data="{ show: true }" x-show="show">
                        <div class="flex items-center gap-3"><i class="fa-solid fa-check-circle"></i> {{ session('success') }}</div>
                        <button @click="show = false"><i class="fa-solid fa-times"></i></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-500 px-4 py-3 rounded-xl flex justify-between items-center" x-data="{ show: true }" x-show="show">
                        <div class="flex items-center gap-3"><i class="fa-solid fa-exclamation-circle"></i> {{ session('error') }}</div>
                        <button @click="show = false"><i class="fa-solid fa-times"></i></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>
