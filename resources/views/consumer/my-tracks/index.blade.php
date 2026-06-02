@extends('layouts.app')

@section('content')

@php
    $staticTracks = [
        ['title' => 'Moonlight Sonata (AI Remix)', 'status' => 'Draft', 'genre' => 'Pop R&B', 'mood' => 'Warm happy', 'image' => 'https://images.unsplash.com/photo-1614613535308-eb5fbd3d2c17?q=80&w=200&auto=format&fit=crop'],
        ['title' => 'Neo Tokyo Drift', 'status' => 'Completed', 'genre' => 'Electronic', 'mood' => 'Energetic dark', 'image' => 'https://images.unsplash.com/photo-1557683316-973673baf926?q=80&w=200&auto=format&fit=crop'],
        ['title' => 'Urban Echoes', 'status' => 'Completed', 'genre' => 'Hip Hop', 'mood' => 'Chill lo-fi', 'image' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?q=80&w=200&auto=format&fit=crop'],
        ['title' => 'Sunset Boulevard', 'status' => 'Completed', 'genre' => 'Jazz', 'mood' => 'Relaxed smooth', 'image' => 'https://images.unsplash.com/photo-1493225255756-d9584f8606e9?q=80&w=200&auto=format&fit=crop'],
    ];
@endphp

<div class="h-full flex flex-col justify-start pt-12 px-12" x-data="{ 
        activeTab: 'ai'
    }">
    
    <div class="w-full max-w-[1000px]">
        
        {{-- Header Section --}}
        <div class="mb-10">
            <h2 class="text-magenta text-[24px] font-semibold mb-[-8px]">Explore</h2>
            <h1 class="text-[48px] tracking-tight font-black text-white">Your Tracks</h1>
        </div>

        {{-- Tabs Section --}}
        <div class="flex items-center justify-between mb-8 border-b border-white/5">
            <div class="flex gap-10">
                <button @click="activeTab = 'published'" :class="activeTab === 'published' ? 'text-white border-b-2 border-magenta pb-4' : 'text-white/40 pb-4'" class="text-[16px] font-semibold transition-all">
                    My Published Tracks
                </button>
                <button @click="activeTab = 'ai'" :class="activeTab === 'ai' ? 'text-white border-b-2 border-magenta pb-4' : 'text-white/40 pb-4'" class="text-[16px] font-semibold transition-all">
                    My Creations with AI
                </button>
            </div>
        </div>

        {{-- Tracks List --}}
        <div class="space-y-4 mb-20">
            @foreach($staticTracks as $track)
                <div class="w-full bg-[#1A1A1A]/60 hover:bg-[#1A1A1A]/100 border border-white/5 rounded-[12px] p-4 pr-6 flex items-center transition-all group">
                    {{-- Thumbnail with Play --}}
                    <div class="relative w-32 h-24 rounded-[8px] overflow-hidden flex-shrink-0">
                        <img src="{{ $track['image'] }}" alt="Cover" class="w-full h-full object-cover opacity-60">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <button class="w-10 h-10 rounded-full border border-magenta flex items-center justify-center text-magenta bg-magenta/10 transition-transform active:scale-90 hover:bg-magenta/20">
                                <svg class="w-5 h-5 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </button>
                        </div>
                    </div>

                    {{-- Track Info --}}
                    <div class="ml-6 flex-1 min-w-0">
                        <h4 class="text-white text-[18px] font-semibold tracking-tight truncate">{{ $track['title'] }}</h4>
                        <p class="text-white/40 text-[13px] font-medium uppercase tracking-wider mt-0.5">{{ $track['genre'] }} | {{ $track['mood'] }}</p>
                        
                        <div class="flex items-center gap-4 mt-3">
                            <span class="{{ $track['status'] == 'Draft' ? 'text-magenta bg-magenta/10 border border-magenta/20' : 'text-[#22C55E] bg-[#22C55E]/10 border border-[#22C55E]/20' }} px-3 py-1 rounded-[4px] text-[10px] font-bold uppercase tracking-widest">
                                {{ $track['status'] }}
                            </span>

                            <div class="text-[#4D61FF]">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Waveform --}}
                    <div class="hidden lg:flex items-center gap-[2px] h-[30px] px-10">
                        @foreach([30, 50, 40, 70, 40, 60, 80, 50, 40, 30, 50, 70, 40, 60, 50, 40, 30, 60, 50, 40] as $h)
                            <div class="w-[3px] bg-[#1E297D] rounded-full" style="height: {{ $h }}%; opacity: {{ $loop->index < 8 ? '1' : '0.4' }}"></div>
                        @endforeach
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-6">
                        <button class="text-white/30 hover:text-white transition-colors">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="1"></circle>
                                <circle cx="12" cy="5" r="1"></circle>
                                <circle cx="12" cy="19" r="1"></circle>
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Bottom Button --}}
        <div class="pt-10">
            <a href="{{ route('consumer.forms.list-on-marketplace') }}" class="w-full py-4 bg-transparent border border-white/20 text-white font-medium rounded-[8px] text-[16px] hover:bg-white/5 transition-all block text-center tracking-wide">
                List your track on OmeMarketplace
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush