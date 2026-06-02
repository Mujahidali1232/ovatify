@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto mb-20">
    <div class="bg-[#1b1b1f] border border-white/5 rounded-[32px] p-10 shadow-2xl overflow-hidden">
        
        {{-- Top Section: Image & Basic Info --}}
        <div class="flex flex-col lg:flex-row gap-10 mb-10">
            {{-- Image Preview --}}
            <div class="w-full lg:w-[320px] aspect-square rounded-[24px] overflow-hidden border border-white/5 shadow-xl">
                <img src="https://picsum.photos/600/600?random=1" class="w-full h-full object-cover">
            </div>

            {{-- Title & Artist --}}
            <div class="flex-1">
                <h1 class="text-white text-[32px] font-bold mb-4">Title of the image</h1>
                
                <div class="flex items-center gap-4 mb-8">
                    <img src="https://i.pravatar.cc/100?u=artist" class="w-12 h-12 rounded-full border border-white/10">
                    <div>
                        <h4 class="text-white font-bold text-[16px] leading-tight">Johna Smith</h4>
                        <a href="#" class="text-gray-500 text-[12px] hover:text-[#5c67ff] transition-colors">View profile</a>
                    </div>
                </div>

                {{-- Metadata Icons --}}
                <div class="grid grid-cols-3 md:grid-cols-5 gap-6 border-t border-white/5 pt-8">
                    <div>
                        <p class="text-gray-500 text-[10px] uppercase font-bold mb-1 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-[#5c67ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m4-4l-5 5m11-1v4m0 0h-4m-4-4l5 5"/></svg>
                            Resolution
                        </p>
                        <p class="text-white font-bold text-[14px]">1600x1600</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-[10px] uppercase font-bold mb-1 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-[#5c67ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Format & Size
                        </p>
                        <p class="text-white font-bold text-[14px]">PNG - 10 MB</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-[10px] uppercase font-bold mb-1 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-[#5c67ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Upload date
                        </p>
                        <p class="text-white font-bold text-[14px]">November 8, 2025</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-[10px] uppercase font-bold mb-1 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-[#5c67ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            Type
                        </p>
                        <p class="text-white font-bold text-[14px]">Photo</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-[10px] uppercase font-bold mb-1 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-[#5c67ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                            Orientation
                        </p>
                        <p class="text-white font-bold text-[14px]">Square</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tags Section --}}
        <div class="mb-12">
            <h3 class="text-white text-[20px] font-bold mb-4 flex items-center gap-2">
                <span class="text-[#5c67ff]">#</span> Tags
            </h3>
            <div class="flex flex-wrap gap-3">
                @foreach(range(1, 5) as $i)
                    <span class="px-6 py-2 bg-[#25252a] rounded-[10px] text-gray-400 font-bold text-[13px] border border-white/5 hover:border-[#5c67ff]/30 cursor-pointer transition-colors">Lorem</span>
                @endforeach
            </div>
        </div>

        {{-- License & Pricing Section --}}
        <div class="bg-[#1b1c20]/50 border border-white/5 rounded-[24px] p-8" x-data="{ tab: 'standard' }">
            <h3 class="text-white text-[22px] font-bold mb-6">License & Pricing</h3>

            {{-- Tabs --}}
            <div class="flex items-center gap-12 border-b border-white/5 mb-8">
                <button @click="tab = 'standard'" class="pb-4 font-bold text-[16px] transition-all relative" :class="tab === 'standard' ? 'text-white' : 'text-gray-500 hover:text-gray-400'">
                    Standard
                    <div class="absolute bottom-0 left-0 w-full h-[3px] bg-[#5c67ff] transition-all" x-show="tab === 'standard'"></div>
                </button>
                <button @click="tab = 'extended'" class="pb-4 font-bold text-[16px] transition-all relative ml-auto" :class="tab === 'extended' ? 'text-white' : 'text-gray-500 hover:text-gray-400'">
                    Extended
                    <div class="absolute bottom-0 left-0 w-full h-[3px] bg-[#5c67ff] transition-all" x-show="tab === 'extended'"></div>
                </button>
            </div>

            {{-- Content Box --}}
            <div class="bg-[#2a2b30]/50 rounded-[20px] p-8 mb-10 border border-white/5">
                <div class="flex justify-between items-center mb-8 pb-8 border-b border-white/5">
                    <h4 class="text-white font-bold text-[18px]">Standard License</h4>
                    <span class="text-white font-bold text-[24px]">$19</span>
                </div>

                <ul class="space-y-4">
                    <li class="flex items-center gap-3 text-gray-300 font-medium text-[15px]">
                        <div class="w-1.5 h-1.5 rounded-full bg-[#5c67ff]"></div>
                        Digital & Print use
                    </li>
                    <li class="flex items-center gap-3 text-gray-300 font-medium text-[15px]">
                        <div class="w-1.5 h-1.5 rounded-full bg-[#5c67ff]"></div>
                        Up to 5M Impressions
                    </li>
                    <li class="flex items-center gap-3 text-gray-300 font-medium text-[15px]">
                        <div class="w-1.5 h-1.5 rounded-full bg-[#5c67ff]"></div>
                        Unlimited Projects
                    </li>
                    <li class="flex items-center gap-3 text-gray-300 font-medium text-[15px]">
                        <div class="w-1.5 h-1.5 rounded-full bg-[#5c67ff]"></div>
                        Royalty Free
                    </li>
                </ul>
            </div>

            {{-- Buttons --}}
            <div class="space-y-4">
                <a href="{{ route('consumer.license.selection') }}" class="block w-full bg-transparent border border-white/10 hover:border-white/30 text-white text-center font-bold text-[17px] py-5 rounded-[12px] transition-all duration-300 active:scale-[0.98]">
                    License
                </a>
                <a href="{{ route('consumer.marketplace.image.invest') }}" class="block w-full bg-transparent border border-white/10 hover:border-white/30 text-white text-center font-bold text-[17px] py-5 rounded-[12px] transition-all duration-300 active:scale-[0.98]">
                    Invest in this Image
                </a>
                <a href="{{ route('consumer.marketplace.image.checkout') }}" class="block w-full bg-[#5c67ff] hover:bg-[#4b55e6] text-white text-center font-bold text-[18px] py-5 rounded-[12px] transition-all duration-300 shadow-xl shadow-[#5c67ff]/20 active:scale-[0.98]">
                    Buy now
                </a>
            </div>
        </div>

    </div>
</div>

@endsection