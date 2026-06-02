@extends('layouts.app')

@section('content')

<div class="max-w-[1200px] mx-auto pb-10">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 gap-6">
        <div>
            <h2 class="text-magenta text-[32px] font-bold mb-0">Hey!</h2>
            <h1 class="text-[48px] font-black text-white leading-none tracking-tight">Ready to create?</h1>
        </div>

        {{-- Stats --}}
        <div class="flex flex-wrap gap-8 pb-2">
            <div class="flex gap-2 items-baseline">
                <span class="text-[18px] font-bold text-white">03</span>
                <span class="text-[15px] font-medium text-white/80">Publishes</span>
            </div>
            <div class="flex gap-2 items-baseline">
                <span class="text-[18px] font-bold text-white">02</span>
                <span class="text-[15px] font-medium text-white/80">Drafts</span>
            </div>
            <div class="flex gap-2 items-baseline">
                <span class="text-[18px] font-bold text-white">$00,000</span>
                <span class="text-[15px] font-medium text-white/80">Earnings</span>
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="space-y-5 mb-16">
        <a href="{{ route('consumer.ai-tools.track-mixing') }}"
            class="block w-full py-6 rounded-[14px] bg-[#4D61FF] text-white text-center text-[19px] font-bold hover:bg-[#3d4ed9] transition-all shadow-xl shadow-[#4D61FF]/10 active:scale-[0.99]">
            Create a new track with AI
        </a>
        <a href="{{ route('consumer.studio.upload') }}"
            class="block w-full py-6 rounded-[14px] bg-transparent border border-gray-800 text-white text-center text-[19px] font-bold hover:bg-white/5 transition-all active:scale-[0.99]">
            Upload your own content
        </a>
    </div>

    {{-- New Releases --}}
    <div class="mb-16">
        <h3 class="text-[26px] font-bold text-white mb-8">New Relaeses</h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @for($i = 0; $i < 4; $i++)
                <div class="rounded-[24px] overflow-hidden bg-[#1b1c20] border border-white/5 group hover:border-[#4D61FF]/30 transition-all duration-300">
                    {{-- Track Cover Area --}}
                    <div class="relative h-[200px] overflow-hidden">
                        <img src="https://picsum.photos/400/400?random={{$i}}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/40 group-hover:bg-black/20 transition-all duration-300"></div>
                        
                        {{-- Play Button --}}
                        <div class="absolute inset-0 flex items-center justify-center">
                            <button class="w-14 h-14 flex items-center justify-center rounded-full bg-magenta shadow-[0_0_25px_rgba(255,0,255,0.4)] opacity-90 transition-all duration-300 transform group-hover:scale-110">
                                <svg class="w-7 h-7 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z" />
                                </svg>
                            </button>
                        </div>

                        {{-- Price Overlay --}}
                        <div class="absolute bottom-4 right-4 bg-black/60 backdrop-blur-md px-3 py-1 rounded-lg border border-white/5">
                            <span class="text-white font-bold text-sm">$19</span>
                        </div>
                    </div>

                    {{-- Track Details --}}
                    <div class="p-6">
                        <div class="mb-4">
                            <h4 class="font-bold text-white text-[17px] mb-1">Cloudside</h4>
                            <p class="text-[12px] text-gray-500 font-medium uppercase tracking-wider">R&B | Melancholic</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <img src="https://i.pravatar.cc/32?u={{ $i }}" alt="Artist" class="w-6 h-6 rounded-full border border-white/10 ring-2 ring-magenta/20">
                            <span class="text-[13px] text-gray-400 font-semibold tracking-tight">Luna Beats</span>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>

    {{-- Creative Workspace --}}
    <div class="mb-16">
        <h3 class="text-[26px] font-bold text-white mb-8">Creative Workspace</h3>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5">
            @php
                $tools = [
                    ['name' => 'Vocal Enhancer', 'route' => 'consumer.ai-tools.mixing-assistant'],
                    ['name' => 'Lyric Assistance', 'route' => 'consumer.ai-tools.hook-generator'],
                    ['name' => 'Melody Generator', 'route' => 'consumer.ai-tools.melody-generator'],
                    ['name' => 'Hook Generator', 'route' => 'consumer.ai-tools.hook-generator'],
                    ['name' => 'Genre Matcher', 'route' => 'consumer.ai-tools.genre-matcher'],
                ];
            @endphp

            @foreach($tools as $tool)
                <div class="p-6 rounded-[24px] bg-[#161719] border border-white/5 hover:border-[#4D61FF]/40 transition-all duration-300 flex flex-col justify-between h-[180px] group shadow-lg">
                    <h4 class="text-[16px] font-bold text-white leading-snug group-hover:text-[#4D61FF] transition-colors">{{ $tool['name'] }}</h4>
                    <a href="{{ route($tool['route']) }}"
                        class="block w-full py-3 rounded-[12px] border border-gray-800 text-[13px] font-bold text-white text-center hover:bg-[#4D61FF] hover:border-[#4D61FF] transition-all duration-300 capitalize shadow-sm">
                        Use it
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Collab Requests --}}
    <div>
        <h3 class="text-[26px] font-bold text-white mb-8">Collab Requests</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @for($i = 0; $i < 3; $i++)
                <div class="p-6 rounded-[24px] bg-[#1b1c20] border border-white/5 flex items-center justify-between group hover:border-gray-700 transition-all">
                    <div class="flex items-center gap-4">
                        <img src="https://i.pravatar.cc/50?u={{ $i + 50 }}" class="w-12 h-12 rounded-full border border-magenta/20">
                        <div>
                            <h4 class="text-white font-bold text-sm">Artist Name</h4>
                            <p class="text-gray-500 text-[11px] font-medium">12 Mutual connections</p>
                        </div>
                    </div>
                    <button class="text-magenta hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
                    </button>
                </div>
            @endfor
        </div>
    </div>
</div>

@endsection