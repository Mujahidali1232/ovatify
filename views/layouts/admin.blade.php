<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ovatify Admin - @yield('title', 'Dashboard')</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .admin-sidebar-item.active {
            background: linear-gradient(90deg, rgba(255, 0, 255, 0.1) 0%, rgba(255, 0, 255, 0) 100%);
            border-left: 4px solid var(--color-accent);
            color: var(--color-accent);
        }
        .admin-card {
            background: #252525;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
        }
        .glass-panel {
            background: rgba(37, 37, 37, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body class="bg-[#1A1A1A] text-white font-inter">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 h-screen sticky top-0 flex-shrink-0 z-40 border-r border-white/5 bg-[#1A1A1A]">
            <div class="p-8">
                <h1 class="text-[28px] font-bold text-magenta mb-10 tracking-tight">Ovatify <span class="text-xs font-medium text-white/40 uppercase tracking-widest block mt-1">Admin Panel</span></h1>
                
                <nav class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="admin-sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-white/5 {{ Request::routeIs('admin.dashboard') ? 'active' : 'text-gray-400' }}">
                        <i class="fa-solid fa-chart-line w-5"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    
                    <a href="{{ route('admin.users') }}" 
                       class="admin-sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-white/5 {{ Request::routeIs('admin.users') ? 'active' : 'text-gray-400' }}">
                        <i class="fa-solid fa-users w-5"></i>
                        <span class="font-medium">Users</span>
                    </a>
                    
                    <a href="{{ route('admin.tracks') }}" 
                       class="admin-sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-white/5 {{ Request::routeIs('admin.tracks') ? 'active' : 'text-gray-400' }}">
                        <i class="fa-solid fa-music w-5"></i>
                        <span class="font-medium">Tracks</span>
                    </a>
                    
                    <a href="{{ route('admin.financials') }}" 
                       class="admin-sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-white/5 {{ Request::routeIs('admin.financials') ? 'active' : 'text-gray-400' }}">
                        <i class="fa-solid fa-wallet w-5"></i>
                        <span class="font-medium">Financials</span>
                    </a>
                    
                    <div class="h-px bg-white/5 my-6"></div>
                    
                    <a href="{{ route('admin.settings') }}" 
                       class="admin-sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-white/5 {{ Request::routeIs('admin.settings') ? 'active' : 'text-gray-400' }}">
                        <i class="fa-solid fa-gear w-5"></i>
                        <span class="font-medium">Settings</span>
                    </a>
                </nav>
            </div>
            
            <div class="absolute bottom-8 left-0 w-full px-8">
                <a href="{{ route('consumer.dashboard.index') }}" class="flex items-center gap-3 text-gray-500 hover:text-white transition-colors text-sm">
                    <i class="fa-solid fa-arrow-left"></i>
                    Back to Website
                </a>
            </div>
        </aside>

        {{-- Main --}}
        <main class="flex-1 overflow-y-auto">
            {{-- Top Header --}}
            <header class="h-20 border-b border-white/5 px-10 flex items-center justify-between sticky top-0 bg-[#1A1A1A]/80 backdrop-blur-md z-30">
                <h2 class="text-xl font-semibold">@yield('page_title', 'Dashboard')</h2>
                
                <div class="flex items-center gap-6">
                    <div class="relative">
                        <i class="fa-solid fa-bell text-gray-400 hover:text-white cursor-pointer transition-colors"></i>
                        <span class="absolute -top-1 -right-1 w-2 h-2 bg-magenta rounded-full"></span>
                    </div>
                    
                    <div class="flex items-center gap-3 pl-6 border-l border-white/10">
                        <div class="text-right">
                            <p class="text-sm font-medium">Admin User</p>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-[10px] text-magenta hover:underline font-bold uppercase tracking-wider">Logout</a>
                        </div>
                        <img src="https://ui-avatars.com/api/?name=Admin+User&background=FF00FF&color=fff" class="w-10 h-10 rounded-full border border-magenta/20" alt="Admin">
                    </div>
                </div>
            </header>

            {{-- Content --}}
            <div class="p-10">
                @if(session('success'))
                    <div class="mb-6 bg-green-500/10 border border-green-500/20 text-green-500 px-4 py-3 rounded-xl flex justify-between items-center relative" x-data="{ show: true }" x-show="show">
                        <div class="flex items-center gap-3"><i class="fa-solid fa-check-circle"></i> {{ session('success') }}</div>
                        <button @click="show = false" class="text-green-500 hover:text-green-400"><i class="fa-solid fa-times"></i></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-500 px-4 py-3 rounded-xl flex justify-between items-center relative" x-data="{ show: true }" x-show="show">
                        <div class="flex items-center gap-3"><i class="fa-solid fa-exclamation-circle"></i> {{ session('error') }}</div>
                        <button @click="show = false" class="text-red-500 hover:text-red-400"><i class="fa-solid fa-times"></i></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>
