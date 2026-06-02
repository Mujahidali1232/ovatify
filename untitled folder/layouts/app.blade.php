<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ovatify</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-[#1A1A1A] text-white font-inter">
    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="w-64 h-screen p-8 sticky top-0 flex-shrink-0 z-40 border-r border-gray-800/40 bg-[#1A1A1A]">
            <h1 class="text-[32px] font-bold text-magenta mb-12 tracking-tight">Ovatify</h1>

            <nav class="space-y-2 w-full">
                {{-- Home --}}
                <a href="{{ route('consumer.dashboard.index') }}"
                    class="flex items-center gap-4 py-3 transition-all duration-200 group
                    {{ Request::routeIs('consumer.dashboard.index') ? 'text-magenta' : 'text-gray-400 hover:text-white' }}">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                    <span class="font-medium text-[17px]">Home</span>
                </a>

                <div class="h-px bg-gray-800/40 my-2"></div>

                {{-- My Tracks --}}
                <a href="{{ route('consumer.my.tracks') }}"
                    class="flex items-center gap-4 py-3 transition-all duration-200 group
                    {{ Request::routeIs('consumer.my.*') ? 'text-magenta' : 'text-gray-400 hover:text-white' }}">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 18V5l12-2v13"/>
                        <circle cx="6" cy="18" r="3"/>
                        <circle cx="18" cy="16" r="3"/>
                    </svg>
                    <span class="font-medium text-[17px]">My Tracks</span>
                </a>

                <div class="h-px bg-gray-800/40 my-2"></div>

                {{-- Rights --}}
                <a href="{{ route('consumer.rights.index') }}"
                    class="flex items-center gap-4 py-3 transition-all duration-200 group
                    {{ Request::routeIs('consumer.rights.*') ? 'text-magenta' : 'text-gray-400 hover:text-white' }}">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                    <span class="font-medium text-[17px]">Rights</span>
                </a>

                <div class="h-px bg-gray-800/40 my-2"></div>

                {{-- Marketplace --}}
                <a href="{{ route('consumer.marketplace.index') }}"
                    class="flex items-center gap-4 py-3 transition-all duration-200 group
                    {{ Request::routeIs('consumer.marketplace.*') || Request::routeIs('consumer.wallet.connect') ? 'text-magenta' : 'text-gray-400 hover:text-white' }}">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"/>
                        <circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                    <span class="font-medium text-[17px]">Marketplace</span>
                </a>

                <div class="h-px bg-gray-800/40 my-2"></div>

                {{-- Me --}}
                <a href="{{ route('consumer.profile.index') }}"
                    class="flex items-center gap-4 py-3 transition-all duration-200 group
                    {{ Request::routeIs('consumer.profile.*') ? 'text-magenta' : 'text-gray-400 hover:text-white' }}">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    <span class="font-medium text-[17px]">Me</span>
                </a>

                <div class="h-px bg-gray-800/40 my-2"></div>

                {{-- Logout --}}
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="flex items-center gap-4 py-3 transition-all duration-200 group text-gray-500 hover:text-red-500">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    <span class="font-medium text-[17px]">Logout</span>
                </a>
            </nav>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 p-8 min-h-screen relative overflow-hidden" style="background-color: #1A1A1A;">
            @yield('content')
        </main>

    </div>

    {{-- Global Modals --}}
    @include('components.modals.wallet-modal')
    @include('components.modals.success-modal')

    @stack('scripts')
</body>


</html>