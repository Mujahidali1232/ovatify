@extends('layouts.app')

@section('content')

    {{-- Header --}}
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl md:text-4xl font-normal tracking-wide"><span class="text-[#f900ff]">Explore</span><br><span class="text-white">Your Marketplace</span></h1>
        </div>
    </div>

    {{-- Search Form --}}
    <form method="GET" action="{{ route('consumer.marketplace.index') }}" class="mb-8">
        <div class="relative w-full group text-sm">
            <div class="absolute left-4 top-1/2 -translate-y-1/2 flex items-center justify-center pointer-events-none z-20">
                <svg class="w-5 h-5 text-[#5c67ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search song"
                class="w-full bg-[#1b1b1b] border border-transparent rounded-xl pl-12 pr-4 py-3 text-sm text-white placeholder:text-gray-500 focus:outline-none focus:border-[#5c67ff] focus:ring-1 focus:ring-[#5c67ff]" />
        </div>
    </form>

    {{-- Tabs --}}
    <div class="grid grid-cols-2 mb-10 border-b border-gray-800">
        <a href="{{ route('consumer.marketplace.index') }}"
            class="py-3 px-4 text-center text-sm bg-[#1e1f3a] text-white rounded-t-lg">
            Tracks/Audios
        </a>
        <a href="{{ route('consumer.marketplace.images') }}"
            class="py-3 px-4 text-center text-sm text-white hover:text-gray-300">
            Images/Illustrations
        </a>
    </div>

    {{-- Featured Drops --}}
    <h3 class="text-xl text-white mb-6">Featured Drops</h3>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-12">
        @foreach($featuredDrops as $track)
            <div class="bg-[#0b0a0f] rounded-xl overflow-hidden p-4 flex flex-col justify-between" style="border: 1px solid rgba(255,255,255,0.05);">
                {{-- Track Image with Waveform --}}
                <div class="relative h-32 rounded-xl mb-4 bg-gradient-to-br from-[#2a134a] to-[#14183d] flex flex-col items-center justify-center overflow-hidden">
                    {{-- Artistic Background waves --}}
                    <div class="absolute inset-0 opacity-40 bg-cover bg-center" style="background-image: url('data:image/svg+xml,%3Csvg width=\'100%25\' height=\'100%25\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M0 60 Q 50 10, 100 60 T 200 60\' stroke=\'rgba(249, 0, 255, 0.4)\' fill=\'none\' stroke-width=\'2\'/%3E%3C/svg%3E');"></div>
                    
                    {{-- Play Button --}}
                    <button class="relative z-10 w-10 h-10 mt-2 flex items-center justify-center rounded-full bg-black/60 shadow-lg hover:scale-110 transition-transform">
                        <svg class="w-4 h-4 text-[#f900ff] ml-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z" />
                        </svg>
                    </button>
                    
                    {{-- Waveform lines --}}
                    <div class="absolute bottom-4 left-0 right-0 flex justify-center items-end gap-[3px] px-2 opacity-80">
                        @foreach([10, 18, 12, 25, 10, 20, 26, 14, 22, 12, 16, 24, 15, 20, 16, 22, 14, 18, 22, 12, 16, 20] as $h)
                            <div class="w-1 rounded-sm bg-[#5c67ff]" style="height: {{ $h / 1.2 }}px;"></div>
                        @endforeach
                    </div>
                </div>

                {{-- Track Info --}}
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <h4 class="font-semibold text-white text-sm truncate pr-2">{{ $track->title }}</h4>
                        <span class="text-xs bg-[#1f2023] px-2 py-0.5 rounded text-white whitespace-nowrap">${{ $track->marketplaceAssets->first()->price ?? '19' }}</span>
                    </div>
                    <p class="text-[11px] text-gray-400 mb-4">By {{ $track->user->username }}</p>

                    <a href="{{ route('consumer.dashboard.track.details', $track->id) }}" class="block w-full py-2 text-center rounded-lg bg-[#5c67ff] hover:bg-[#4b55e6] text-xs text-white transition-colors focus:ring-2 focus:ring-[#5c67ff] focus:ring-offset-2 focus:ring-offset-[#0b0a0f]">
                        View details
                    </a>
                </div>
            </div>
        @endforeach
        
        @if($featuredDrops->isEmpty())
             <div class="col-span-1 sm:col-span-2 xl:col-span-4 py-8 text-center text-gray-500 bg-[#141414] rounded-xl text-sm">No featured tracks found.</div>
        @endif
    </div>

    @if(!$trendingNow->isEmpty())
        {{-- Trending Now --}}
        <h3 class="text-xl text-white mb-6">Trending Now</h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 pb-20">
            @foreach($trendingNow as $track)
                <div class="bg-[#121212] rounded-xl overflow-hidden hover:ring-1 hover:ring-gray-700 transition" style="border: 1px solid rgba(255,255,255,0.05);">
                    {{-- Top Image --}}
                    <div class="relative h-28 bg-gradient-to-br from-[#2a134a] to-[#14183d] flex items-center justify-center overflow-hidden">
                        {{-- Background Graphics --}}
                        <div class="absolute inset-0 opacity-50 flex items-center">
                            {{-- Simulating the wavy background from screenshot --}}
                            <div class="w-full h-full bg-gradient-to-tr from-transparent via-[#f900ff]/10 to-[#5c67ff]/20"></div>
                        </div>

                        {{-- Play button in bottom right --}}
                        <button class="absolute -bottom-4 right-4 w-10 h-10 flex items-center justify-center rounded-full bg-[#121212] shadow shadow-black/80 z-20 border border-gray-800 hover:scale-110 transition-transform">
                            <svg class="w-4 h-4 text-[#f900ff] ml-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z" />
                            </svg>
                        </button>
                    </div>

                    {{-- Details --}}
                    <div class="p-4 pt-5 bg-[#121212]">
                        <div class="flex justify-between items-start mb-1">
                            <div class="overflow-hidden">
                                <h4 class="font-semibold text-white text-sm truncate pr-2">{{ $track->title }}</h4>
                                <p class="text-[10px] text-gray-400 mt-0.5 truncate">{{ $track->genre ?? 'R&B | Melancholic' }}</p>
                            </div>
                            <span class="text-xs bg-[#1f2023] px-2 py-0.5 rounded text-white whitespace-nowrap">${{ $track->marketplaceAssets->first()->price ?? '19' }}</span>
                        </div>
                        
                        <div class="flex items-center gap-2 mt-4">
                            <img src="{{ $track->user->profile_image ? asset('storage/' . $track->user->profile_image) : 'https://i.pravatar.cc/24?u=' . $track->user->id }}" alt="Artist" class="w-5 h-5 rounded-full object-cover">
                            <span class="text-xs text-gray-400 font-medium">{{ $track->user->username }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

@endsection