@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto mb-20">
    {{-- Header --}}
    <div class="mb-10">
        <h2 class="text-[#ff00ff] text-[32px] font-bold leading-tight uppercase tracking-tight">Explore</h2>
        <h1 class="text-white text-[42px] font-bold leading-tight -mt-2">Your Marketplace</h1>
    </div>

    {{-- Search Bar --}}
    <div class="relative mb-8 max-w-5xl">
        <div class="absolute left-5 top-1/2 -translate-y-1/2 flex items-center">
            <svg class="w-6 h-6 text-[#5c67ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
        <input type="text" placeholder="Search song" class="w-full bg-[#1b1b1f] border-none rounded-xl py-5 pl-14 pr-6 text-white placeholder-gray-500 focus:ring-1 focus:ring-[#5c67ff]/50 transition-all font-medium">
    </div>

    {{-- Custom Tabs --}}
    <div class="flex items-center mb-12 border-b border-white/5">
        <a href="{{ route('consumer.marketplace.index') }}" class="flex-1 text-center py-4 text-gray-400 font-bold text-[15px] hover:text-white transition-colors relative group">
            Track/Audios
            <div class="absolute bottom-0 left-0 w-full h-1 bg-transparent group-hover:bg-white/10 transition-colors"></div>
        </a>
        <a href="{{ route('consumer.marketplace.images') }}" class="flex-1 text-center py-4 text-white font-bold text-[15px] relative">
            Images/Illustrations
            <div class="absolute bottom-0 left-0 w-full h-1 bg-[#2b2d42]"></div>
        </a>
    </div>

    {{-- Trending Now Section --}}
    <div class="mb-12">
        <div class="flex justify-between items-center mb-8">
            <h3 class="text-white text-[24px] font-bold">Trending now</h3>
            <a href="{{ route('consumer.marketplace.all-trending') }}" class="text-[#5c67ff] font-bold text-[15px] hover:underline">View all</a>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @foreach(range(1, 5) as $i)
                <div class="group cursor-pointer">
                    <div class="relative aspect-square rounded-2xl overflow-hidden mb-4 border border-white/5 shadow-lg group-hover:border-[#5c67ff]/30 transition-all duration-300">
                        <img src="https://picsum.photos/400/400?random={{ $i + 10 }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    </div>
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="text-white font-bold text-[15px] truncate max-w-[120px]">Lorem Ipsum</h4>
                            <p class="text-gray-500 text-[10px] uppercase font-bold mt-1">1000 X 1000</p>
                            <p class="text-gray-500 text-[10px] uppercase font-bold mt-0.5">Standard License</p>
                        </div>
                        <span class="text-white font-bold text-[15px]">$20</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Recommended for you Section --}}
    <div>
        <div class="flex justify-between items-center mb-8">
            <h3 class="text-white text-[24px] font-bold">Recommended for you</h3>
            <a href="{{ route('consumer.marketplace.all-recommendations') }}" class="text-[#5c67ff] font-bold text-[15px] hover:underline">View all</a>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @foreach(range(1, 5) as $i)
                <div class="group cursor-pointer">
                    <div class="relative aspect-square rounded-2xl overflow-hidden mb-4 border border-white/5 shadow-lg group-hover:border-[#5c67ff]/30 transition-all duration-300">
                        <img src="https://picsum.photos/400/400?random={{ $i + 20 }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    </div>
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="text-white font-bold text-[15px] truncate max-w-[120px]">Lorem Ipsum</h4>
                            <p class="text-gray-500 text-[10px] uppercase font-bold mt-1">1000 X 1000</p>
                            <p class="text-gray-500 text-[10px] uppercase font-bold mt-0.5">Standard License</p>
                        </div>
                        <span class="text-white font-bold text-[15px]">$20</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection