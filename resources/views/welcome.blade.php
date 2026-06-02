<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome to Ovatify | Premium Music Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .hero-gradient {
            background: radial-gradient(circle at 50% 50%, rgba(255, 0, 255, 0.15) 0%, rgba(15, 15, 15, 0) 70%);
        }
        .glow-button {
            box-shadow: 0 0 20px rgba(255, 0, 255, 0.3);
            transition: all 0.3s ease;
        }
        .glow-button:hover {
            box-shadow: 0 0 30px rgba(255, 0, 255, 0.5);
            transform: translateY(-2px);
        }
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>

<body class="bg-[#0f0f0f] text-white font-inter overflow-x-hidden">
    {{-- Header --}}
    <header class="fixed top-0 left-0 w-full z-50 px-8 py-6 flex items-center justify-between backdrop-blur-md bg-[#0f0f0f]/50 border-b border-white/5">
        <div class="flex items-center gap-2">
            <span class="text-3xl font-extrabold text-magenta tracking-tighter">Ovatify</span>
        </div>
        <div class="flex items-center gap-6">
            <a href="{{ route('login') }}" class="text-sm font-medium hover:text-magenta transition-colors">Sign In</a>
            <a href="{{ route('register') }}" class="px-6 py-2.5 bg-magenta rounded-full text-sm font-bold glow-button">Get Started</a>
        </div>
    </header>

    {{-- Hero Section --}}
    <section class="min-h-screen flex flex-col items-center justify-center relative px-6 hero-gradient">
        <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-magenta/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-[150px]"></div>
        
        <div class="max-w-4xl text-center z-10">
            <h1 class="text-6xl md:text-8xl font-extrabold tracking-tighter mb-6 leading-tight uppercase">
                THE FUTURE OF <span class="text-magenta">MUSIC</span> MANAGEMENT
            </h1>
            <p class="text-gray-400 text-lg md:text-xl max-w-2xl mx-auto mb-12 leading-relaxed">
                Connect with creators, manage your rights, and scale your music business with Ovatify's all-in-one AI-powered platform.
            </p>
            
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('consumer.dashboard.index') }}" class="px-8 py-4 bg-white text-black rounded-2xl font-bold flex items-center gap-3 hover:bg-gray-200 transition-colors">
                    <i class="fa-solid fa-play"></i> Enter App
                </a>
                <a href="{{ route('admin.dashboard') }}" class="px-8 py-4 bg-[#252525] border border-white/10 rounded-2xl font-bold flex items-center gap-3 hover:bg-white/5 transition-colors">
                    <i class="fa-solid fa-user-shield"></i> Admin Panel
                </a>
            </div>
        </div>

        {{-- Floating Icons --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <i class="fa-solid fa-music text-magenta/20 text-4xl absolute top-[20%] right-[15%] floating" style="animation-delay: 0s"></i>
            <i class="fa-solid fa-headphones text-blue-500/20 text-5xl absolute top-[40%] left-[10%] floating" style="animation-delay: 1s"></i>
            <i class="fa-solid fa-microphone text-purple-500/20 text-3xl absolute bottom-[20%] left-[20%] floating" style="animation-delay: 2s"></i>
            <i class="fa-solid fa-compact-disc text-magenta/20 text-6xl absolute bottom-[30%] right-[10%] floating" style="animation-delay: 0.5s"></i>
        </div>
    </section>

    {{-- Quick Links --}}
    <section class="py-24 px-8 border-t border-white/5 bg-[#141414]">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-2xl font-bold mb-12 text-center text-gray-400 uppercase tracking-[0.2em]">Platform Navigators</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Auth Flow -->
                <div class="p-8 rounded-3xl bg-[#1A1A1A] border border-white/5 hover:border-magenta/30 transition-all group">
                    <h3 class="text-xl font-bold mb-6 text-magenta flex items-center gap-2">
                        <i class="fa-solid fa-lock"></i> Authentication
                    </h3>
                    <div class="space-y-4">
                        <a href="{{ route('login') }}" class="flex items-center justify-between text-sm text-gray-400 group-hover:text-white transition-colors">Login <i class="fa-solid fa-arrow-right"></i></a>
                        <a href="{{ route('register') }}" class="flex items-center justify-between text-sm text-gray-400 group-hover:text-white transition-colors">Register <i class="fa-solid fa-arrow-right"></i></a>
                        <a href="{{ route('verification') }}" class="flex items-center justify-between text-sm text-gray-400 group-hover:text-white transition-colors">Verify Account <i class="fa-solid fa-arrow-right"></i></a>
                        <a href="{{ route('forgot.password') }}" class="flex items-center justify-between text-sm text-gray-400 group-hover:text-white transition-colors">Reset Password <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Consumer Area -->
                <div class="p-8 rounded-3xl bg-[#1A1A1A] border border-white/5 hover:border-blue-500/30 transition-all group">
                    <h3 class="text-xl font-bold mb-6 text-blue-500 flex items-center gap-2">
                        <i class="fa-solid fa-user"></i> Consumer Area
                    </h3>
                    <div class="space-y-4">
                        <a href="{{ route('consumer.dashboard.index') }}" class="flex items-center justify-between text-sm text-gray-400 group-hover:text-white transition-colors">User Dashboard <i class="fa-solid fa-arrow-right"></i></a>
                        <a href="{{ route('consumer.my.tracks') }}" class="flex items-center justify-between text-sm text-gray-400 group-hover:text-white transition-colors">My Library <i class="fa-solid fa-arrow-right"></i></a>
                        <a href="{{ route('consumer.marketplace.index') }}" class="flex items-center justify-between text-sm text-gray-400 group-hover:text-white transition-colors">Marketplace <i class="fa-solid fa-arrow-right"></i></a>
                        <a href="{{ route('consumer.profile.index') }}" class="flex items-center justify-between text-sm text-gray-400 group-hover:text-white transition-colors">My Profile <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Admin Area -->
                <div class="p-8 rounded-3xl bg-[#1A1A1A] border border-white/5 hover:border-purple-500/30 transition-all group">
                    <h3 class="text-xl font-bold mb-6 text-purple-500 flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved"></i> Admin Management
                    </h3>
                    <div class="space-y-4">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-between text-sm text-gray-400 group-hover:text-white transition-colors">Admin Stats <i class="fa-solid fa-arrow-right"></i></a>
                        <a href="{{ route('admin.users') }}" class="flex items-center justify-between text-sm text-gray-400 group-hover:text-white transition-colors">Manage Users <i class="fa-solid fa-arrow-right"></i></a>
                        <a href="{{ route('admin.tracks') }}" class="flex items-center justify-between text-sm text-gray-400 group-hover:text-white transition-colors">Manage Content <i class="fa-solid fa-arrow-right"></i></a>
                        <a href="{{ route('admin.financials') }}" class="flex items-center justify-between text-sm text-gray-400 group-hover:text-white transition-colors">Revenue & Payouts <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-8 text-center border-t border-white/5 text-xs text-gray-600">
        &copy; 2026 Ovatify Premium Music Platform. All Rights Reserved.
    </footer>
</body>

</html>
